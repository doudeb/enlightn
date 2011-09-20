<?php
include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
//Some basic var
gatekeeper();
$user_guid 			= get_loggedin_userid();
$user_ent			= get_user($user_guid);
$entity_guid		= get_input('entity_guid');
if (!$user_guid || !$user_ent) {
	forward();
}
disable_right($entity_guid);
$topic 				= get_entity($entity_guid);
if (!$topic) forward();
/**
 * Left part
 */
$left 				= '';
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
$posts				=  elgg_view("enlightn/posts", array('entity' => $topic
												,'user_ent' => $user_ent
												,'user_guid' => $user_guid));
$left 				.= $posts;
unset($post);
/**
 * Right part
 */
//search filters
$search_filters 	= elgg_view('enlightn/search_filters',array());
$right 				.= $search_filters;
unset($search_filters);
//discussion type
$discussion_shortcut = elgg_view('enlightn/discussion_shortcut',array('discussion_unreaded' => $discussion_unreaded, 'discussion_id' => $topic->guid));
$right .= $discussion_shortcut;
unset($discussion_shortcut);
//Compile into a layout
$body 				= $left . $right;
// Display page
page_draw(elgg_echo('enlightn:main'),$body);