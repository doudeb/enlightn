<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");


//Some basic var
gatekeeper();
$user_guid 		= get_loggedin_userid();
global $enlightn;
/**
 * @todo set it to cache
 */
$words 			= sanitise_string_special(get_input('q',''));
$date_begin 	= get_input('date_begin');
$date_end 		= get_input('date_end');
$from_users 	= sanitise_string(get_input('from_users'));
$from_users		= parse_user_to($from_users);
$subtype	 	= sanitise_string(get_input('subtype'));
$offset			= sanitise_int(get_input('offset', 0));
$limit			= sanitise_int(get_input('limit', 10));
$access_level	= sanitise_int(get_input('discussion_type', 4));
$entity_guid	= sanitise_int(get_input('entity_guid', 0));
$fetch_modified	= sanitise_int(get_input('fetch_modified', 0));
$unreaded_only	= sanitise_int(get_input('unreaded_only', 0));


//var_dump($subtype);
$last_search	= serialize(array('user_guid' => $user_guid,'entity_guid' => $entity_guid,'access_level' => $access_level,'unreaded_only' => $unreaded_only,'words' => $words,'from_users' => $from_users,'date_begin' => $date_begin,'date_end' => $date_end,'subtype' => $subtype,'offset' => $offset,'limit' => $limit));

$date_begin 	= strtotime($date_begin);
$date_end 		= strtotime($date_end);

if ($entity_guid > 0) {
	$flag_member = check_entity_relationship($user_guid, ENLIGHTN_FOLLOW,$entity_guid);
	if ($flag_member) {
		elgg_set_ignore_access(true);
	}
	$discussion_activities  = get_entity_relationships($entity_guid,true);
	$discussion_activities  = array_reverse($discussion_activities);
	$discussion_activities  = sort_entity_activities($discussion_activities);
	$discussion				= get_entity($entity_guid);
	$search_results			= $discussion->getAnnotations('', $limit, $offset, "desc");
	$last_modified			= $search_results[0]->time_created;
} else {
	$search_results 		= $enlightn->search($user_guid,$entity_guid,$access_level,$unreaded_only,$words,$from_users,$date_begin,$date_end,$subtype,$offset,$limit);
	$_SESSION['last_search'] = $last_search;
	$last_modified			= $search_results[0]->created;
}
$discussion_unreaded	= $enlightn->count_unreaded_discussion($user_guid);

$nb_results = count($search_results);
if ($nb_results > 0) {
	header("Last-Modified: " . gmdate("D, d M Y H:i:s",$last_modified) . " GMT");
	header("Query-uid: " . md5($last_search));
	if ($fetch_modified === 1) {
		//echo json_encode(array('last-modified' => $search_results[0]->created));
		return;
	}
	foreach ($search_results as $key => $topic) {
		if ((int)$entity_guid > 0) {
			$flag_readed = check_entity_relationship($user_guid, ENLIGHTN_READED,$topic->id);
			if ($nb_results-1 == $key) {
				$topic_activities = $discussion_activities;
			} else {
				$topic_activities = get_activities_by_time(&$discussion_activities,$topic->time_created);
			}
			if ($key === 0) {
				echo elgg_view('enlightn/post_header', array());
			}
			echo elgg_view("enlightn/topic_activities",array('entity' => $topic
														, 'activities' => $topic_activities));
			if(!$flag_readed) {
				add_entity_relationship($user_guid, ENLIGHTN_READED,$topic->id);
				$enlightn->flush_cache(array('user_guid' => $user_guid),'unreaded');
			}
		    echo elgg_view("enlightn/topicpost",array('entity' => $topic
		    											, 'query' => $words
		    											, 'flag_readed' => $flag_readed));
		} else {
			echo  elgg_view("enlightn/discussion_short", array('entity' => $topic
												, 'current' => $key===0?true:false
												, 'user_guid' => $user_guid
												, 'query' => $words
												, 'discussion_id' => $discussion_id
												, 'discussion_unreaded' => $discussion_unreaded));
		}
	}
}