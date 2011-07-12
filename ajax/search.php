<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");


//Some basic var
gatekeeper();
$user_guid 		= get_loggedin_userid();
global $enlightn;
/**
 * @todo set it to cache
 */
$words 			= get_input('q','');
$date_begin 	= get_input('date_begin', date('Y-m-d H:i:s'));
$date_end 		= get_input('date_end', date('Y-m-d H:i:s'));
$from_users 	= get_input('from_users');
$subtype	 	= get_input('subtype');
$offset			= get_input('offset', 0);
$limit			= get_input('limit', 10);
$access_level	= get_input('discussion_type', 4);
$entity_guid	= get_input('entity_guid', 0);
$fetch_modified	= get_input('fetch_modified', 0);
$unreaded_only	= get_input('unreaded_only', 0);

//var_dump($subtype);
//Filtering some datas and disable the cache in some case.

$last_search	= serialize(array('user_guid' => $user_guid,'entity_guid' => $entity_guid,'access_level' => $access_level,'unreaded_only' => $unreaded_only,'words' => $words,'from_users' => $from_users,'date_begin' => $date_begin,'date_end' => $date_end,'subtype' => $subtype,'offset' => $offset,'limit' => $limit));

if (empty($date_begin) || $date_begin == $date_end) {
	$date_begin = strtotime("-5 week");
} else {
	$date_begin 	= strtotime($date_begin);
}

if (empty($date_end)) {
	$date_end 		= strtotime("now");
} else {
	$date_end 		= strtotime($date_end);
}

$search_results 		= $enlightn->search($user_guid,$entity_guid,$access_level,$unreaded_only,$words,$from_users,$date_begin,$date_end,$subtype,$offset,$limit);
$discussion_unreaded	= $enlightn->count_unreaded_discussion($user_guid);
if ($entity_guid > 0) {
	$discussion_activities = get_entity_relationships($entity_guid,true);
	$discussion_activities = array_reverse($discussion_activities);
	$discussion_activities = sort_entity_activities($discussion_activities);
} else {
	$_SESSION['last_search'] = $last_search;
}
$nb_results = count($search_results);
if ($nb_results > 0) {
	header("Last-Modified: " . gmdate("D, d M Y H:i:s",$search_results[0]->time_created) . " GMT");
	if ($fetch_modified === '1') {
		echo json_encode(array('last-modified' => $search_results[0]->time_created));
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