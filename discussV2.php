<?php
include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
elgg_load_css('discuss');
elgg_load_js('discuss');
//Some basic var
gatekeeper();
$user_guid 			= elgg_get_logged_in_user_guid();
$user_ent			= get_user($user_guid);
$guid                           = get_input('entity_guid');
global $enlightn;
if (!$user_guid || !$user_ent) {
	forward();
}
disable_right($guid);
$topic 				= get_entity($guid);
if (!$topic) forward();
add_to_river('enlightn/helper/riverlog','open', $user_guid,$guid,$topic->access_id);
/**
 * Left part
 */
$left 				= '';
//Title
$discussion_header				=  elgg_view("enlightn/discussion/header", array('entity' => $topic
												,'user_guid' => $user_guid));
$left 				.= $discussion_header;
unset($title);

//new post
$cloud_discussion   = $enlightn->get_my_cloud($user_guid,$subtype,$words,$from_users,$date_begin, $date_end,$guid,100,0);
$new_post			= elgg_view("enlightn/discussion/post", array('entity' => $topic
												,'user_ent' => $user_ent
												,'cloud_discussion' => $cloud_discussion
												,'user_guid' => $user_guid));
$left 				.= $new_post;
unset($new_post);
//posts
$posts				= elgg_view("enlightn/discussion/feed", array('entity' => $topic
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
echo elgg_view_page(elgg_echo('enlightn:main'),$body,'enlightn');