<?php


class enlightn {

	var $cache;

	function __construct() {
		static $cache;
		if ((!$cache) && (is_memcache_available())) {
			$this->cache = new ElggMemcache('enlightn_cache');
		} else {
            $this->cache = false;
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
		return  get_data($query, 'entity_row_to_elggstar');
	}

	public function search ($user_guid, $entity_guid = 0, $access_level = 0, $unreaded_only = 0,$words, $from_users = '', $date_begin = '""', $date_end = '""', $subtype = '', $offset = 0, $limit = 10) {
		$key_cache = $this->generate_key_cache(get_defined_vars(), 'search');
		#Access
		switch ($access_level) {
			case 1:#Public Only 1
				$force[] = "#Force Index (idx_annotations_time)";
				$where[] = "And a.access_id = " . ACCESS_PUBLIC;
				break;
			case 2:#Private Followed And Public Folowed 2
				$force[] = "#Force Index (idx_annotations_time)";
				$join[] = "Inner Join entity_relationships As rel_follow On a.entity_guid = rel_follow.guid_two";
				$where[] = "And rel_follow.guid_one = $user_guid
							And rel_follow.relationship = '". ENLIGHTN_FOLLOW . "'";
				break;
			case 3:#Favorite
				//$force[] = "Force Index (idx_annotations_time)";
				$join[] = "Inner Join entity_relationships rel_favorite On a.entity_guid = rel_favorite.guid_two";
				$where[] = "And rel_favorite.guid_one = $user_guid
							And rel_favorite.relationship = '". ENLIGHTN_FAVORITE . "'";
				break;
			case 4:#Private Folowed or Public 4
				$join[] = "Left Join entity_relationships As rel_all On a.entity_guid = rel_all.guid_two";
				$where[] = "And ((rel_all.guid_one = $user_guid
							And rel_all.relationship = '". ENLIGHTN_FOLLOW . "'
							And a.access_id  = " . ACCESS_PRIVATE .")
						Or a.access_id  = " . ACCESS_PUBLIC . ')';
				break;#Invited aka request 5
			case 5:
				#$force[] = "Force Index (idx_annotations_time)";
				$join[] = "Inner Join entity_relationships As rel_req On a.entity_guid = rel_req.guid_one";
				$where[] = "And rel_req.guid_two = $user_guid
							And rel_req.relationship = '". ENLIGHTN_INVITED . "'";
				break;
			default:
				break;
		}
		if ($unreaded_only) {
			#Unreaded
			$where[] = "And Not Exists(Select id
		    	                        From entity_relationships As rel
		                                Where a.id = rel.guid_two
		                                And rel.guid_one = 2
		                                And rel.relationship = '". ENLIGHTN_READED . "')";
		}
		#From user
		if (is_array($from_users)) {
			$from_users = implode(',',$from_users);
			if (!empty($from_users)) {
				$where[] = "And a.owner_guid in ($from_users)";
			}
		}
		#Subtype
		if ($subtype) {
			$subtype		= str_replace("'","",$subtype);
			$subtype_names = explode(',',$subtype);
			foreach ($subtype_names as $key => $subtype_name) {
				$subtype_ids[] = get_metastring_id($subtype_name);
			}
			$subtype_id = implode(',',$subtype_ids);
			/*$where[] = "And (Exists(Select mst.string
									From entity_relationships rel_embeded
									Inner Join metadata mtd On rel_embeded.guid_one = mtd.entity_guid
									Inner Join metastrings mst On mtd.value_id = mst.id
									Where rel_embeded.guid_two = a.id
									And rel_embeded.relationship = '" . ENLIGHTN_EMBEDED . "'
									And mst.string In('$subtype'))
					Or Exists(Select mst.string
		                            From metastrings mst
		                            Where a.name_id = mst.id
		                            And mst.string In('$subtype')))";*/
			$join[]	= "Inner Join entity_relationships As rel_embed On a.id = rel_embed.guid_two And rel_embed.relationship = 'embeded'
						Inner Join metadata mtd On rel_embed.guid_one = mtd.entity_guid And mtd.value_id in ($subtype_id)";
		}
		#Words
		if ($words) {
			$force   = array();
			$join [] = "Inner Join sphinx_search sphinx On a.id = sphinx.id And a.entity_guid = sphinx.guid";
			$where[] = "And sphinx.query='@(title,content) $words;mode=extended;offset=$offset;limit=50;sort=extended:@weight desc'";
			//remove offset when going throught sphinx... not needed as it's the main data source.
			if ($offset > 0) {
				$offset = 0;
			}
		}
		#Entity guid
		if ($entity_guid) {
			$where[] = "And a.entity_guid = $entity_guid";
			$group[] = "Group By p.id";
		} else {
			$group[] = "Group By p.guid";
		}
		#date
		if ($date_begin || $date_end) {
			if (empty($date_begin)) {
				$date_begin = strtotime("now");
			}
			if (empty($date_end)) {
				$date_end = strtotime("now");
			}
			$where[] = "And a.time_created Between $date_begin And $date_end";
		}
		$force 	= implode(' ',$force);
		$join	= implode(' ',$join);
		$where	= implode(' ',$where);
		$group	= implode(' ',$group);
		$query 	= "Select * From (
						Select a.entity_guid as guid
						, a.time_created as created
						, a.id
				From annotations a $force
				$join
				Where 1
				$where
				Order By a.time_created Desc
				Limit $offset,50) as p
				$group
				Order By p.created Desc
				Limit $offset, $limit";
		//echo "<pre>" . $query;die();
		return  $this->get_data($query, $key_cache, null);
	}

	public function count_unreaded_discussion ($user_guid, $entity_guid = 0) {
		$key_cache = $this->generate_key_cache(get_defined_vars(), 'unreaded');
		if (!$user_guid) {
			return false;
		}
		$query = "(Select Distinct " . ENLIGHTN_ACCESS_PU . "  as access_level
		,a.entity_guid
From annotations a
Where a.access_id  = " . ACCESS_PUBLIC . "
And Not Exists (Select rel.id
					From entity_relationships As rel
					Where a.id = rel.guid_two
					And rel.guid_one = $user_guid
					And rel.relationship = '" . ENLIGHTN_READED . "')
Limit 150)
Union
#unreaded follow
(Select Distinct " . ENLIGHTN_ACCESS_PR . " as access_level
		,a.entity_guid
From annotations a
Inner Join entity_relationships As rel On a.entity_guid = rel.guid_two
								And rel.guid_one = $user_guid
								And rel.relationship = '" . ENLIGHTN_FOLLOW . "'
Left Join entity_relationships As rel_readed On a.id = rel_readed.guid_two
												And rel_readed.guid_one = $user_guid
												And rel_readed.relationship = '" . ENLIGHTN_READED . "'
Where a.access_id  = " . ACCESS_PRIVATE . "
And rel_readed.id Is Null
Limit 150)
Union
#Favorite
(Select Distinct " . ENLIGHTN_ACCESS_FA . " as access_level
		,a.entity_guid
From annotations a
Inner Join entity_relationships As rel On a.entity_guid = rel.guid_two
								And rel.guid_one = $user_guid
								And rel.relationship = '" . ENLIGHTN_FAVORITE . "'
Left Join entity_relationships As rel_readed On a.id = rel_readed.guid_two
												And rel_readed.guid_one = $user_guid
												And rel_readed.relationship = '" . ENLIGHTN_READED . "'
Where a.access_id  in (" . ACCESS_PRIVATE . "," . ACCESS_PUBLIC . ")
And rel_readed.id Is Null
Limit 150)
Union
#request
(Select Distinct " . ENLIGHTN_ACCESS_IN . " as access_level
		,a.entity_guid
From annotations a
Inner Join entity_relationships As rel_req On a.entity_guid = rel_req.guid_one
											And rel_req.guid_two = $user_guid
											And rel_req.relationship = '" . ENLIGHTN_INVITED . "'
Limit 150)";
		//echo $query;
		return  $this->get_data($query, $key_cache);
	}

public function get_my_cloud ($user_guid, $simpletype = false, $words = false,$from_users = false,$date_begin = false, $date_end = false,$limit = 10, $offset = 0) {
		$file_subtype_id = get_subtype_id('object','file');
		if (!$file_subtype_id) {
			return false;
		}
		//$key_cache = $this->generate_key_cache(get_defined_vars(), 'cloud');
		$key_cache = false;
		if (!$user_guid) {
			return false;
		}
		if ($simpletype) {
			$join[] = "Inner Join metadata mtd On mtd.entity_guid = ent.guid
						Inner Join metastrings mst On mtd.value_id = mst.id";
			$where[] = "And mst.string In ('$simpletype')";
		}
		if ($words) {
			$join [] = "Inner Join objects_entity object_ent On ent.guid = object_ent.guid";
			$where[] = "And Match (object_ent.title,object_ent.description) Against ('$words' IN BOOLEAN MODE)";

		}
		#date
		if ($date_begin || $date_end) {
			if (empty($date_begin)) {
				$date_begin = strtotime("now");
			}
			if (empty($date_end)) {
				$date_end = strtotime("now");
			}
			$where[] = "And ent.time_created Between $date_begin And $date_end";
		}
		#From user
		if (is_array($from_users)) {
			$from_users = implode(',',$from_users);
			if (!empty($from_users)) {
				$where[] = "And ent.owner_guid in ($from_users)";
			} else {
				$user= "Or ent.owner_guid = " . $user_guid;
			}
		}
		$join	= implode(' ',$join);
		$where	= implode(' ',$where);
		$query = "Select Distinct ent.*
From entities ent
Left Join entity_relationships As rel_embed On ent.guid = rel_embed.guid_one And rel_embed.relationship = '" . ENLIGHTN_EMBEDED ."'
Left Join annotations a On rel_embed.guid_two = a.id
Left Join entity_relationships As rel_follow On rel_follow.guid_two = a.entity_guid And rel_follow.guid_one = " . $user_guid ." And rel_follow.relationship = '" . ENLIGHTN_FOLLOW ."'
$join
Where ent.subtype = $file_subtype_id #File type
And  (ent.access_id In (" . ACCESS_PUBLIC ."," . ACCESS_PRIVATE .")
		$user)
$where
Order By ent.time_created Desc
Limit $offset,$limit";
		//echo "<pre>" .$query;
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
		if (isset($args['date_begin'])) {
			$use_cache		= false;
		}

		if (isset($args['date_end'])) {
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
        if (!$this->cache) {
            return true;
        }
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
		if ($key_cache && $this->cache) {
			$results = $this->cache->load($key_cache);
			if ($results) {
				elgg_log('enlightn:cache:loaded => ' . $key_cache);
				return $results;
			}
		}
		$results = get_data($query, $call_back);
		if ($key_cache && $this->cache) {
			if(!$this->cache->save($key_cache,$results)) {
				elgg_log('enlightn:cache:error:save => ' . $key_cache);
			} else {
				elgg_log('enlightn:cache:saved => ' . $key_cache);
			}
		}
		return  $results;
	}
}