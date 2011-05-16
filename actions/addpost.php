<?php

/**
 * Elgg groups: add post to a topic
 *
 * @package ElggGroups
 */

// Make sure we're logged in and have a CSRF token
gatekeeper();
global $CONFIG;
$url = $CONFIG->wwwroot . "pg/enlightn";
elgg_get_access_object()->set_ignore_access(true);
// Get input
$topic_guid = (int) get_input('topic_guid');
$group_guid = (int) get_input('group_guid');
$post = get_input('topic_post');
$embeded = get_input('embedContent',null,false);
$discussion_subtype = get_input('discussion_subtype', ENLIGHTN_DISCUSSION);

if (!is_null($embeded)) {
	$post .= $embeded;
}

// make sure we have text in the post
if (!$post) {
	register_error(elgg_echo("grouppost:nopost"));
	forward($_SERVER['HTTP_REFERER']);
}


// Check that user is a group member
$group = get_entity($group_guid);
$user = get_loggedin_user();
/*if (!$group->isMember($user)) {
	register_error(elgg_echo("groups:notmember"));
	forward($_SERVER['HTTP_REFERER']);
}*/


// Let's see if we can get an form topic with the specified GUID, and that it's a group forum topic
$topic = get_entity($topic_guid);


// add the post to the forum topic
$post_id = $topic->annotate($discussion_subtype, $post, $topic->access_id, $user->guid);
if ($post_id == false) {
	system_message(elgg_echo("groupspost:failure"));
	forward($_SERVER['HTTP_REFERER']);
}

// add to river
add_to_river('enlightn/river/comment', 'create', $user->guid, $topic_guid, "", 0, $post_id);
//Mark as read
add_entity_relationship($_SESSION['user']->guid, ENLIGHTN_READED, $post_id);
system_message(elgg_echo("groupspost:success"));
elgg_get_access_object()->set_ignore_access(false);
forward($url . '?discussion_id=' . $topic_guid);
