<?php


class enlightn {

	var $cache;

	function __construct() {
		static $cache;
		if ((!$cache) && (is_memcache_available())) {
			$this->cache = new ElggMemcache('enlightn_cache');
		}
	}

	function get_discussion ($user_guid, $discussion_type = 0) {

		if (!$user_guid) {
			return false;
		}
		$where = elgg_get_entity_type_subtype_where_sql('e', 'object', ENLIGHTN_DISCUSSION, null);
		$query = "Select e.*
From entities as e
Left Join entity_relationships As rel On e.guid = rel.guid_two And rel.guid_one = 404 And rel.relationship = '".ENLIGHTN_FOLLOW . "'
Where $where
And Case
	When 0=$discussion_type Then rel.id Is not Null And e.access_id = 0#Only for membership
	When 1=$discussion_type Then e.access_id = 1 #All for logged user aka public
	Else Null
End
Order By e.time_created desc";
		elgg_get_access_object()->set_ignore_access(true);
		return  get_data($query, 'entity_row_to_elggstar');
	}

	public function search ($user_guid, $entity_guid = 0, $access_level = 0, $unreaded_only = 0,$words, $from_users = '', $date_begin = '""', $date_end = '""', $subtype = '', $offset = 0, $limit = 10) {
		$key_cache = $this->generate_key_cache(get_defined_vars(), 'search');
		$query = "Select * From (
				Select a.*
					, msv.string as value
					, ent_title.title
					, a.entity_guid as guid
					, FROM_UNIXTIME(a.time_created) as created
From annotations a
Inner Join objects_entity ent_title On a.entity_guid = ent_title.guid
Inner Join metastrings msv on a.value_id = msv.id
Where
	Case
		When $entity_guid != 0 Then
			a.entity_guid = $entity_guid
		Else true
	End
And
	Case
		When $access_level = 1 Then #Public Only
			a.access_id = " . ACCESS_PUBLIC ."
		When $access_level = 2 Then #Private Followed And Public Folowed
			(
				Exists(
					Select id
					From entity_relationships As rel
					Where a.entity_guid = rel.guid_two
					And rel.guid_one = $user_guid
					And rel.relationship = '". ENLIGHTN_FOLLOW . "'
				) And a.access_id IN(" . ACCESS_PRIVATE ."," . ACCESS_PUBLIC .")
			)
		When $access_level = 3 Then #Favorite Private an Public
			Exists(
				Select id
				From entity_relationships As rel
				Where a.entity_guid = rel.guid_two
				And rel.guid_one = $user_guid
				And rel.relationship = '". ENLIGHTN_FAVORITE . "'
				And a.access_id IN(" . ACCESS_PRIVATE ."," . ACCESS_PUBLIC .")
			)
		When $access_level = 4 Then #Private Folowed or Public
			(
				Exists(
					Select id
					From entity_relationships As rel
					Where a.entity_guid = rel.guid_two
					And rel.guid_one = $user_guid
					And rel.relationship = '". ENLIGHTN_FOLLOW . "'
					And a.access_id  = " . ACCESS_PRIVATE ."
				)
			) Or a.access_id  = " . ACCESS_PUBLIC ."
		When $access_level = " . ENLIGHTN_ACCESS_IN . " Then #Invited aka request
			Exists(
				Select id
				From entity_relationships As rel
				Where a.entity_guid = rel.guid_one
				And rel.guid_two = $user_guid
				And rel.relationship = '". ENLIGHTN_INVITED . "'
			)
		Else false
	End
And
	Case
		When 1 = $unreaded_only Then #Unreaded Only
                        Not Exists(
                                Select id
                                From entity_relationships As rel
                                Where a.id = rel.guid_two
                                And rel.guid_one = 2
                                And rel.relationship = 'readed'
                        )
                Else true
        End
And
	Case
		When length('$words') > 2 And length('$words') <= @@ft_min_word_len Then
			ent_title.title Like '%$words%' Or msv.string Like '%$words%'
		When length('$words') > @@ft_min_word_len Then
			(MATCH (ent_title.title,msv.string) AGAINST ('$words' IN BOOLEAN MODE))
		Else true
	End
And
	Case
		When length('$from_users') > 0 And locate(',','$from_users') = 0 Then
			a.owner_guid = '$from_users'
		When length('$from_users') > 0 And locate(',','$from_users') > 0 Then
			a.owner_guid in ('$from_users')
		Else true
	End
And a.time_created Between $date_begin And $date_end
And
	Case
		When length(\"$subtype\") > 0 Then
			(Exists(Select mst.string
							From entity_relationships rel_embeded
							Inner Join metadata mtd On rel_embeded.guid_one = mtd.entity_guid
							Inner Join metastrings mst On mtd.value_id = mst.id
							Where rel_embeded.guid_two = a.id
							And rel_embeded.relationship = '" . ENLIGHTN_EMBEDED . "'
							And mst.string In('$subtype'))
			Or Exists(Select mst.string
                            From metastrings mst
                            Where a.name_id = mst.id
                            And mst.string In('$subtype')))
		Else true
	End
Order By a.time_created Desc
,Case
	When locate('$words',ent_title.title) Then 1
	When locate('$words',msv.string) Then 2
	Else false
End
Limit $offset,50) as p
Group By
	Case
		When length('$words')  = 0 And $entity_guid = 0 Then
	 		p.guid
	 	Else p.id
	End
Order By p.created Desc
Limit $offset, $limit";
		//echo "<pre>" . $query;die();
		return  $this->get_data($query, $key_cache, 'row_to_elggannotation');
	}

	public function count_unreaded_discussion ($user_guid, $entity_guid = 0) {
		$key_cache = $this->generate_key_cache(get_defined_vars(), 'unreaded');
		if (!$user_guid) {
			return false;
		}
		$query = "Select a.entity_guid as guid
		,Count(a.id) as unreaded
		,If(Exists(Select rel.id
					From entity_relationships As rel
					Where a.entity_guid = rel.guid_two
					And rel.guid_one = $user_guid
					And rel.relationship = '" . ENLIGHTN_FAVORITE ."'),1,0) as Favorite
		,If(Exists(Select rel.id
					From entity_relationships As rel
					Where a.entity_guid = rel.guid_one
					And rel.guid_two = $user_guid
					And rel.relationship = '". ENLIGHTN_INVITED ."'),1,0) as Invited
		,Case
			When a.access_id = ". ACCESS_PRIVATE . " Then ". ENLIGHTN_ACCESS_PR . "
			When a.access_id = ". ACCESS_PUBLIC . " Then ". ENLIGHTN_ACCESS_PU . "
			Else 0
		End As access_level
From annotations a
Where Not Exists (Select rel.id
					From entity_relationships As rel
					Where a.id = rel.guid_two
					And rel.guid_one = $user_guid
					And rel.relationship = '" . ENLIGHTN_READED ."')
And (Exists(
		Select id
		From entity_relationships As rel
		Where a.entity_guid = rel.guid_two
		And rel.guid_one = $user_guid
		And rel.relationship IN ('". ENLIGHTN_FOLLOW . "')
		And a.access_id  = " . ACCESS_PRIVATE .")
	Or Exists(
		Select id
		From entity_relationships As rel
		Where a.entity_guid = rel.guid_one
		And rel.guid_two = $user_guid
		And rel.relationship IN ('". ENLIGHTN_INVITED ."'))
	Or a.access_id  = " . ACCESS_PUBLIC ."
	)
And
	Case
		When $entity_guid != 0 Then
			a.entity_guid = $entity_guid
		Else
			True
	End
Group By a.entity_guid";
		//echo $query;
		return  $this->get_data($query, $key_cache);
	}

public function get_my_cloud ($user_guid, $simpletype = 'simpletype', $limit = 10, $offset = 0) {
		$file_subtype_id = get_subtype_id('object','file');
		if (!$file_subtype_id) {
			return false;
		}
		//$key_cache = $this->generate_key_cache(get_defined_vars(), 'cloud');
		$key_cache = false;
		if (!$user_guid) {
			return false;
		}
		$query = "Select ent.*
From entities ent
Where ent.subtype = $file_subtype_id #File type
And ( #Get all file for *the current user or *public or *private and embeded
		Exists( Select distinct rel_embed.guid_one
				From entity_relationships As rel_follow
				Inner join entity_relationships As rel_embed
					On rel_embed.guid_two = rel_follow.guid_two
					And rel_embed.relationship = '" . ENLIGHTN_EMBEDED ."'
				Where ent.guid = rel_embed.guid_one
					And rel_follow.guid_one = " . $user_guid ."
					And rel_follow.relationship = '" . ENLIGHTN_FOLLOW ."'
					And ent.access_id = " . ACCESS_PRIVATE ."
		)
		Or ent.access_id  = " . ACCESS_PUBLIC ."
		Or ent.owner_guid = " . $user_guid ."
	)
And
	Case
		When 'simpletype' != '$simpletype' Then
					Exists(Select mst.string
							From metadata mtd
							Inner Join metastrings mst On mtd.value_id = mst.id
							Where mtd.entity_guid = ent.guid
							And mst.string = '$simpletype')
		Else true
	End
Order By ent.time_created Desc
Limit $offset,$limit";
		echo $query;
		return  $this->get_data($query, $key_cache, 'entity_row_to_elggstar');
	}

	private function generate_key_cache ($args = false, $prefix = 'enlightn') {
		//by default, always use cache, some criteria will change that
		$use_cache			= true;
		$key_cache			= false;
		if (!is_array($args)) {
			return false;
		}
		if(isset($args['words']) && $args['words'] != '') {
			$use_cache		= false;
		}

		if (isset($args['subtype']) && $args['subtype'] != '') {
			$use_cache		= false;
		}

		if (isset($args['offset']) && $args['offset'] > 0) {
			$use_cache		= false;
		}
		if(isset($args['from_users']) && $args['from_users'] != '') {
			$use_cache		= false;
		}
		if (isset($args['date_begin']) && $args['date_begin'] != strtotime("-5 week")) {
			$use_cache		= false;
		}

		if (isset($args['date_end']) && $args['date_end'] != strtotime("now")) {
			$use_cache		= false;
		}
		if ($args['unreaded_only'] == '1') {
			$use_cache		= false;
		}
		if ($use_cache) {
			if ($args['access_level'] == ENLIGHTN_ACCESS_PU) {
				$key_cache = $args['access_level'];
			}
			if (in_array($args['access_level'],array(ENLIGHTN_ACCESS_PR,ENLIGHTN_ACCESS_FA,ENLIGHTN_ACCESS_IN))) {
				$key_cache = $args['user_guid'] . $args['access_level'];
			}
			if ($args['entity_guid'] != 0) {
				if ($prefix == 'search') {
					$key_cache = $args['entity_guid'];
				}
			}
			if ($prefix == 'unreaded') {
				$key_cache = $args['user_guid'];
			}
			return $prefix . $key_cache;
		}
		return false;
	}

	public function flush_cache ($args, $prefix = 'default') {
		$key_cache = $this->generate_key_cache($args,$prefix);
		if ($this->cache->load($key_cache)) {
			$this->cache->delete($key_cache);
			elgg_log('enlightn:cache:keydeleted => ' . $key_cache);
		} else {
			elgg_log('enlightn:cache:miss => ' . $key_cache);
		}
		return true;
	}

	private function get_data ($query, $key_cache, $call_back = false) {
		if ($key_cache) {
			$results = $this->cache->load($key_cache);
			if ($results) {
				elgg_log('enlightn:cache:loaded => ' . $key_cache);
				return $results;
			}
		}
		$results = get_data($query, $call_back);
		if ($key_cache) {
			if(!$this->cache->save($key_cache,$results)) {
				elgg_log('enlightn:cache:error:save => ' . $key_cache);
			} else {
				elgg_log('enlightn:cache:saved => ' . $key_cache);
			}
		}
		return  $results;
	}
}
?>