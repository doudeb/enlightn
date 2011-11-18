<?php

/**
 * Elgg groups: add post to a topic
 *
 * @package ElggGroups
 */

// Make sure we're logged in and have a CSRF token
gatekeeper();
global $enlightn,$CONFIG;
// Get input
$guid               = (int) get_input('topic_guid');
$message    		= get_input('new_post',null);
$discussion_subtype = get_input('discussion_subtype', ENLIGHTN_DISCUSSION);
$json_return        = array();
$json_return['success'] = false;

if (strip_tags($message,'<img>') == "" || trim($message) == "") {
    $json_return['message'] = elgg_echo('enlightn:messageempty');
    echo json_encode($json_return);
    exit();
}

disable_right($topic_guid);
// Check that user is a group member
$user_guid 				= get_loggedin_userid();
// Let's see if we can get an form topic with the specified GUID, and that it's a group forum topic
$json_return = create_enlightn_discussion ($user_guid, $access_id,$message, $title,$tags, $userto,$guid);

// Remove cache
$enlightn->flush_cache(array('entity_guid' => $guid),'search');
$enlightn->flush_cache(array('user_guid' => $user_guid,'access_level' => ENLIGHTN_ACCESS_PU),'search');
$enlightndiscussion = get_entity($guid);
$followers = get_discussion_members($guid);
foreach($followers as $follower) {
	$enlightn->flush_cache(array('user_guid' => $follower->guid,'access_level' => ENLIGHTN_ACCESS_PR),'search');
	$enlightn->flush_cache(array('user_guid' => $follower->guid,'access_level' => ENLIGHTN_ACCESS_IN),'search');
	$enlightn->flush_cache(array('user_guid' => $follower->guid,'access_level' => ENLIGHTN_ACCESS_FA),'search');
	$enlightn->flush_cache(array('user_guid' => $follower->guid),'unreaded');
    // Send email
    if ($follower->{"notification:method:".NOTIFICATION_EMAIL_MESSAGE_FOLLOWED} == '1' && $follower->guid != $user->guid) {
        notify_user($follower->guid, $user_guid,
                sprintf(elgg_echo('enlightn:newmessage:subject'), $enlightndiscussion->title),
                sprintf(elgg_echo('enlightn:newmessage:body'), $follower->name, $user->name, $enlightndiscussion->title, $url),
                NULL);
    }
}
$json_return['message'] = elgg_echo('enlightn:discussion_sucessfully_created');
echo json_encode($json_return);
exit();