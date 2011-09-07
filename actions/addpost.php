<?php

/**
 * Elgg groups: add post to a topic
 *
 * @package ElggGroups
 */

// Make sure we're logged in and have a CSRF token
gatekeeper();
global $CONFIG;
$url 				= $CONFIG->wwwroot . "pg/enlightn";
$enlightn 			= new enlightn();
elgg_get_access_object()->set_ignore_access(true);
// Get input
$topic_guid 		= (int) get_input('topic_guid');
$group_guid 		= (int) get_input('group_guid');
$post 				= get_input('new_post',null,false);
$discussion_subtype = get_input('discussion_subtype', ENLIGHTN_DISCUSSION);
//var_dump($_POST);die();
if (!is_null($embeded)) {
	$post 			.= $embeded;
}



// Check that user is a group member
$user 				= get_loggedin_user();
// Let's see if we can get an form topic with the specified GUID, and that it's a group forum topic
$topic 				= get_entity($topic_guid);


// add the post to the forum topic
$message 	= create_embeded_entities($post,$topic);
$post		= $message['message'];


$post_id = $topic->annotate($discussion_subtype, $post, $topic->access_id, $user->guid);
if ($post_id == false) {
	system_message(elgg_echo("groupspost:failure"));
	forward($_SERVER['HTTP_REFERER']);
}
if (is_array($message['guids'])) {
	foreach ($message['guids'] as $embeded_guids) {
		add_entity_relationship($embeded_guids,ENLIGHTN_EMBEDED,$post_id);
	}
}
// add to river
add_to_river('enlightn/river/comment', 'create', $user->guid, $topic_guid, "", 0, $post_id);
//Mark as read
add_entity_relationship($user->guid, ENLIGHTN_FOLLOW, $topic_guid);
add_entity_relationship($user->guid, ENLIGHTN_READED, $post_id);
system_message(elgg_echo("enlightn:success"));
// Remove cache
$enlightn->flush_cache(array('entity_guid' => $topic_guid),'search');
$enlightn->flush_cache(array('user_guid' => $user->guid,'access_level' => ENLIGHTN_ACCESS_PU),'search');
$followers = get_discussion_members($topic_guid);
foreach($followers as $follower) {
	$enlightn->flush_cache(array('user_guid' => $follower->guid,'access_level' => ENLIGHTN_ACCESS_PR),'search');
	$enlightn->flush_cache(array('user_guid' => $follower->guid,'access_level' => ENLIGHTN_ACCESS_IN),'search');
	$enlightn->flush_cache(array('user_guid' => $follower->guid,'access_level' => ENLIGHTN_ACCESS_FA),'search');
	$enlightn->flush_cache(array('user_guid' => $follower->guid),'unreaded');
    // Send email
    if ($follower->{"notification:method:".NOTIFICATION_EMAIL_MESSAGE_FOLLOWED} == '1' && $follower->guid != $user->guid) {
        notify_user($follower->getGUID(), $user->guid,
                sprintf(elgg_echo('enlightn:newmessagefollowed:subject'), $topic->title),
                sprintf(elgg_echo('enlightn:newmessagefollowed:body'), $follower->name, $user->name, $topic->title, $url),
                NULL);
    }


}
echo elgg_echo('enlightn:discussion_sucessfully_created');
elgg_get_access_object()->set_ignore_access(false);
exit();