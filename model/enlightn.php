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

	public function search ($user_guid, $entity_guid = 0, $access_level = 0, $unreaded_only = 0,$words, $from_users = '', $date_begin = false, $date_end =false, $subtype = '', $offset = 0, $limit = 10) {
		$key_cache = $this->generate_key_cache(get_defined_vars(), 'search');
        $force 	= array();
		$join	= array();
		$where	= array();
        $having = array();
		$group	= array();
        $where[]= elgg_get_entity_type_subtype_where_sql('ent', 'object', ENLIGHTN_DISCUSSION, null);
		#Access
		switch ($access_level) {
			case 1:#Public Only 1
			default:
				$force[] = "#Force Index (idx_annotations_time)";
				$where[] = "And ent.access_id = " . ACCESS_PUBLIC;
				break;
			case 2:#Private Followed And Public Folowed 2
				$force[] = "#Force Index (idx_annotations_time)";
				$join[] = "";
				$where[] = "And Exists(Select rel_follow.id From entity_relationships As rel_follow Where ent.guid = rel_follow.guid_two And rel_follow.guid_one = $user_guid And rel_follow.relationship = '". ENLIGHTN_FOLLOW . "')";
				break;
			case 3:#Favorite
				//$force[] = "Force Index (idx_annotations_time)";
				$join[] = "Inner Join entity_relationships rel_favorite On ent.guid = rel_favorite.guid_two And rel_favorite.guid_one = $user_guid And rel_favorite.relationship = '". ENLIGHTN_FAVORITE . "'";
				$where[] = "";
				break;
			case 4:#Private Folowed or Public 4
				//$join[] = "Left Join entity_relationships As rel_all On a.entity_guid = rel_all.guid_two And rel_all.guid_one = $user_guid And rel_all.relationship = '". ENLIGHTN_FOLLOW . "' And a.access_id  = " . ACCESS_PRIVATE;
                $where[] = "And ( Exists (Select rel_all.id  From entity_relationships As rel_all Where ent.guid = rel_all.guid_two And rel_all.guid_one = $user_guid And rel_all.relationship = '". ENLIGHTN_FOLLOW . "' And ent.access_id  = " . ACCESS_PRIVATE . ")
                                  Or ent.access_id  = " . ACCESS_PUBLIC . ')';
				break;
			case 5:#Invited aka request 5
				#$force[] = "Force Index (idx_annotations_time)";
				$join[] = "Inner Join entity_relationships As rel_req On ent.guid = rel_req.guid_one And rel_req.guid_two = $user_guid And rel_req.relationship = '". ENLIGHTN_INVITED . "'";
				$where[] = "";
				break;
		}
		if ($unreaded_only) {
			#Unreaded
			$where[] = "And Exists(Select a.id
									From annotations a
									Left join entity_relationships rel On a.id = rel.guid_two And rel.guid_one = $user_guid And rel.relationship = '". ENLIGHTN_READED . "'
									Where a.entity_guid = ent.guid
									And rel.id Is Null)";
		}
		#From user
		if (is_array($from_users)) {
			$from_users = implode(',',$from_users);
			if (!empty($from_users)) {
				$from_users = "And a.owner_guid in ($from_users)";
                $having[]   = "Having id";
			}
		}
		#Subtype
		if ($subtype) {
			$subtype		= str_replace(array(0=>"'",1=>'\\'),"",$subtype);
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
			$join[]	= "Inner Join annotations a On ent.guid = a.entity_guid
                        Inner Join entity_relationships As rel_embed On a.id = rel_embed.guid_two And rel_embed.relationship = '" . ENLIGHTN_EMBEDED . "'
						Inner Join metadata mtd On rel_embed.guid_one = mtd.entity_guid And mtd.value_id in ($subtype_id)";
		}
		#Words
		if ($words) {
            $sphinx_enabled = get_plugin_setting('sphinx_enabled','enlightn');
            if ($sphinx_enabled == 1) {
                $force   = array();
                $join [] = "Inner Join sphinx_search sphinx On ent.guid = sphinx.guid";
                $where[] = "And sphinx.query='@(title,content) $words;mode=extended;offset=$offset;limit=10;sort=extended:@weight desc'";
                //remove offset when going throught sphinx... not needed as it's the main data source.
                if ($offset > 0) {
                    $offset = 0;
                }
            } else {
                $join [] = "Inner Join objects_entity ent_title On ent_title.guid = ent.guid
                            Inner Join annotations a On ent.guid = a.entity_guid
                            Inner Join metastrings msv On a.value_id = msv.id";
                $where[] = "And
                                Case
                                    When length('$words') > 2 And length('$words') <= @@ft_min_word_len Then
                                        ent_title.title Like concat('%', '$words', '%') Or msv.string Like concat('%', '$words', '%')
                                    When length('$words') > @@ft_min_word_len Then
                                        MATCH (ent_title.title,msv.string) AGAINST ('$words' IN BOOLEAN MODE)
                                    Else true
                                End";
            }
		}
		#Entity guid
		if ($entity_guid) {
			$where[] = "And ent.guid = $entity_guid";
			$group[] = "Group By p.id";
		} else {
			//$group[] = "Group By p.guid";
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
		$force 	= implode(' ',$force);
		$join	= implode(' ',$join);
		$where	= implode(' ',$where);
		$group	= implode(' ',$group);
		$having	= implode(' ',$having);
		$query 	= "Select Distinct ent.guid
                        ,  (Select Max(a.id) From annotations a Where ent.guid = a.entity_guid $from_users) id
                        , ent.time_updated created
                    From entities ent $force
                    $join
                    Where
    				$where
                    $having
        			Order By ent.time_updated Desc
            		Limit $offset,$limit";
		//echo "<pre>" . $query;//die();
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
			$join [] = "Inner Join objects_entity ent_title On ent.guid = ent_title.guid";
			$where[] = "And
                                Case
                                    When length('$words') > 2 And length('$words') <= @@ft_min_word_len Then
                                        ent_title.title Like concat('%', '$words', '%') Or ent_title.description Like concat('%', '$words', '%')
                                    When length('$words') > @@ft_min_word_len Then
                                        MATCH (ent_title.title,ent_title.description) AGAINST ('$words' IN BOOLEAN MODE)
                                    Else true
                                End";

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
$join
Where ent.subtype = $file_subtype_id #File type
And  (
		Case
            When ent.owner_guid = $user_guid Then True
			When ent.access_id = " . ACCESS_PUBLIC . " Then True
			When ent.access_id = " . ACCESS_PRIVATE . " Then
				Exists(Select rel_follow.id
						From entity_relationships rel_embed
						Inner Join annotations a On rel_embed.guid_two = a.id
						Inner join entity_relationships As rel_follow On a.entity_guid = rel_follow.guid_two
																		And rel_follow.guid_one = $user_guid
																		And rel_follow.relationship = '" . ENLIGHTN_FOLLOW . "'
						Where ent.guid = rel_embed.guid_one And rel_embed.relationship = '" . ENLIGHTN_EMBEDED . "')
			Else Null
		End
)
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

    public function is_embeded_and_followed ($guid) {
        $user_guid = get_loggedin_userid();
        if (!$user_guid) {
            return false;
        }
        $query = "Select a.entity_guid
                    From annotations a
                    Inner Join entity_relationships As rel_embed On a.id = rel_embed.guid_two And rel_embed.relationship = '" . ENLIGHTN_EMBEDED . "'
                    Where (Exists (Select id From entity_relationships As rel_all Where a.entity_guid = rel_all.guid_two And rel_all.guid_one = $user_guid And rel_all.relationship = '" . ENLIGHTN_FOLLOW . "' And a.access_id  = " . ENLIGHTN_ACCESS_PRIVATE . ")
                           Or Exists (Select id From entity_relationships As rel_all Where a.entity_guid = rel_all.guid_one And rel_all.guid_two = $user_guid And rel_all.relationship = '" . ENLIGHTN_INVITED . "' And a.access_id  = 0)
                           Or a.access_id  = " . ACCESS_PUBLIC . ")
                    And rel_embed.guid_one = $guid
                    Limit 1";
        //echo "<pre>"; die($query);
		return  get_data($query);

    }
}