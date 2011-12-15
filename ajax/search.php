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
$annotation_id	= sanitise_int(get_input('annotation_id', 0));


$last_search	= serialize(array('user_guid' => $user_guid,'entity_guid' => $entity_guid,'access_level' => $access_level,'unreaded_only' => $unreaded_only,'words' => $words,'from_users' => $from_users,'date_begin' => $date_begin,'date_end' => $date_end,'subtype' => $subtype,'offset' => $offset,'limit' => $limit));
$date_begin 	= strtotime($date_begin);
$date_end 		= strtotime($date_end);

if ($annotation_id > 0) {
    disable_right($entity_guid);
    $search_results[0]		= elgg_get_annotation_from_id($annotation_id);
    $last_modified			= $search_results[0]->time_created;
} elseif ($entity_guid > 0) {
    disable_right($entity_guid);
	$discussion_activities  = get_entity_relationships($entity_guid,true);
	$discussion_activities  = array_reverse($discussion_activities);
	$discussion_activities  = sort_entity_activities($discussion_activities);
    $discussion				= get_entity($entity_guid);
	$search_results			= $discussion->getAnnotations(ENLIGHTN_DISCUSSION, $limit, $offset, "desc");
    $previous_result        = $offset>0?$discussion->getAnnotations(ENLIGHTN_DISCUSSION, 1, abs($offset-$limit), "desc"):false;
    $total_results          = $discussion->countAnnotations('');
    //$search_results         = array_reverse($search_results);
	$last_modified			= $search_results[0]->time_created;
} else {
	$search_results 		= $enlightn->search($user_guid,$entity_guid,$access_level,$unreaded_only,$words,$from_users,$date_begin,$date_end,$subtype,$offset,$limit);
	$_SESSION['last_search'] = $last_search;
	$last_modified			= $search_results[0]->created;
    if ($access_level == ENLIGHTN_ACCESS_IN) {
        set_context(ENLIGHTN_INVITED);
    }
}
$discussion_unreaded	= $enlightn->count_unreaded_discussion($user_guid);

$nb_results = count($search_results);
if ($nb_results > 0) {
	header("Last-Modified: " . gmdate("D, d M Y H:i:s",$last_modified) . " GMT");
	header("Query-uid: " . md5($last_search));
	header("Fetch-rows: " . $nb_results);
	if ($fetch_modified === 1) {
		//echo json_encode(array('last-modified' => $search_results[0]->created));
		return;
	}
	foreach ($search_results as $key => $topic) {
        if ($annotation_id > 0) {
            echo elgg_view("enlightn/topicpost",array('entity' => $topic
		    											, 'query' => $words
		    											, 'flag_readed' => true));
        } elseif ((int)$entity_guid > 0) {
            $current_date       = $topic->time_created;
            $previous_date      = !$previous_result?false:$previous_result[0]->time_created;
			$flag_readed        = check_entity_relationship($user_guid, ENLIGHTN_READED,$topic->id);
			$topic_activities   = get_activities_by_time(&$discussion_activities,$current_date,$previous_date);
			if ($key === 0) {
				echo elgg_view('enlightn/post_header', array());
			}
			if(!$flag_readed) {
				add_entity_relationship($user_guid, ENLIGHTN_QUEUE_READED,$topic->id);
			}
            echo elgg_view("enlightn/topic_activities",array('entity' => $topic
														, 'activities' => $topic_activities));
            echo elgg_view("enlightn/topicpost",array('entity' => $topic
		    											, 'query' => $words
		    											, 'flag_readed' => $flag_readed));
            if ($key + $offset + 1 === $total_results) {
                echo elgg_view("enlightn/topic_activities",array('entity' => $topic
														, 'activities' => $discussion_activities));
            }
		} else {
			echo  elgg_view("enlightn/discussion_short", array('entity' => $topic
												, 'current' => $key===0?true:false
												, 'user_guid' => $user_guid
												, 'query' => $words
												, 'discussion_id' => $discussion_id
												, 'discussion_unreaded' => $discussion_unreaded));
		}
	}
    if ($key >=9) {
        echo elgg_view('input/seemore', array());
    }
}