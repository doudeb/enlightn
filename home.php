<?php
include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

//Some basic var
gatekeeper();
global $enlightn;
$user_guid 				= get_loggedin_userid();
$user_ent				= get_user($user_guid);
$discussion_unreaded	= $enlightn->count_unreaded_discussion($user_guid);
if (!$user_guid || !$user_ent) {
	forward();
}
/**
 * Left part
 */
$left 				= '';
//Activity
//$activity 			= elgg_view('enlightn/activity',array());
//$left 				.= $activity;
//unset($activity);
//New discussion
$new_discussion		= elgg_view('enlightn/new_discussion',array(
																'user_ent' => $user_ent
																));
$left 				.= $new_discussion;
unset($new_discussion);
//retreive last discussion subject
$discussion_list 	= elgg_view('enlightn/discussion_list',array('user_guid' => $user_guid
																, 'discussion_id' => $discussion_id));
$left			 	.= $discussion_list;
unset($discussion_list);

/**
 * Right part
 */

//search filters
$search_filters = elgg_view('enlightn/search_filters',array());
$right .= $search_filters;
unset($search_filters);
//discussion type
$discussion_type_selector = elgg_view('enlightn/discussion_type_selector',array('discussion_unreaded' => $discussion_unreaded));
$right .= $discussion_type_selector;
unset($discussion_type_selector);
//online people
//$online_people = elgg_view('enlightn/online_people',array());
//$right .= $online_people;
//unset($online_people);
//Compile into a layout
$body = $left . $right;
// Display page
page_draw(elgg_echo('enlightn:main'),$body);