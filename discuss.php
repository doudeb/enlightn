<?php
include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");


//Some basic var
gatekeeper();
$user_guid 			= get_loggedin_userid();
$user_ent			= get_user($user_guid);
$discussion_id		= get_input('discussion_id');
if (!$user_guid || !$user_ent) {
	forward();
}
elgg_get_access_object()->set_ignore_access(true);
$topic 				= get_entity(get_input('entity_guid'));
if (!$topic) forward();

/**
 * Left part 
 */
$left 				= ''; // Display them
//Title
$title				=  elgg_view("enlightn/title", array('entity' => $topic
												,'user_guid' => $user_guid));
$left 				.= $title;
unset($title);

//new post
$new_post			=  elgg_view("enlightn/new_post", array('entity' => $topic
												,'user_ent' => $user_ent
												,'user_guid' => $user_guid));
$left 				.= $new_post;
unset($new_post);
//posts
$posts			=  elgg_view("enlightn/posts", array('entity' => $topic
												,'user_ent' => $user_ent
												,'user_guid' => $user_guid));
$left 				.= $posts;
unset($new_post);
/**
 * Right part
 */
//discussion action
$discussion_action	= elgg_view("enlightn/discussion_action", array('entity' => $topic
									, 'user_guid' => $user_guid));
$right 				.= $discussion_action;
unset($discussion_action);									
//search filters
$search_filters 	= elgg_view('enlightn/search_filters',array());
$right 				.= $search_filters;
unset($search_filters);
//followers
$followers	 		= elgg_view('enlightn/followers',array('entity' => $topic));
$right 				.= $followers;
unset($followers);
//Compile into a layout
$body 				= elgg_view_layout("two_column_right_sidebar", '', $left, $right);
// Display page
page_draw(elgg_echo('enlightn:main'),$body);