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
// Get input
$topic_guid 		= (int) get_input('topic_guid');
$post 				= get_input('new_post',null);
$discussion_subtype = get_input('discussion_subtype', ENLIGHTN_DISCUSSION);
$json_return        = array();
$json_return['success'] = false;

if (strip_tags($post,'<img>') == "" || trim($post) == "") {
    $json_return['message'] = elgg_echo('enlightn:messageempty');
    echo json_encode($json_return);
    exit();
}

disable_right($topic_guid);
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
$topic->save();//trigger entities save, in order to update the update_time;
if (is_array($message['guids'])) {
	foreach ($message['guids'] as $embeded_guids) {
		add_entity_relationship($embeded_guids,ENLIGHTN_EMBEDED,$post_id);
	}
}
// add to river
add_to_river('enlightn/river/comment', 'create', $user->guid, $topic_guid, "", 0, $post_id);
//Mark as read && follow
if (add_entity_relationship($user->guid, ENLIGHTN_FOLLOW, $topic_guid)) {
    //Remove invitation
    remove_entity_relationship($topic_guid, ENLIGHTN_INVITED, $user->guid);
}
add_entity_relationship($user->guid, ENLIGHTN_READED, $post_id);
//system_message(elgg_echo("enlightn:success"));
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
                sprintf(elgg_echo('enlightn:newmessage:subject'), $topic->title),
                sprintf(elgg_echo('enlightn:newmessage:body'), $follower->name, $user->name, $topic->title, $url),
                NULL);
    }


}
$json_return['message'] = elgg_echo('enlightn:discussion_sucessfully_created');
$json_return['success'] = $post_id;
echo json_encode($json_return);
exit();