<?php

    /**
	 * Elgg groups plugin add topic action.
	 *
	 * @package ElggGroups
	 */

// Make sure we're logged in; forward to the front page if not
gatekeeper();
if (!isloggedin()) forward();
global $enlightn;
// Get input data
$title 				= strip_tags(get_input('title'));
$message 			= get_input('description',null);
$tags 				= get_input('interests');
$access 			= get_input('membership');
$user_guid			= get_loggedin_userid(); // you need to be logged in to comment on a group forum
$userto 			= get_input('invite');
$discussion_subtype = get_input('discussion_subtype', ENLIGHTN_DISCUSSION);
$json_return        = array();
$json_return['success'] = false;
global $CONFIG;
// Convert string of tags into a preformatted array
$tagarray = string_to_tag_array($tags);
// Make sure the title / message aren't blank
if (empty($title) || empty($message)) {
	$json_return['message'] = elgg_echo('enlightn:missingData');

// Otherwise, save the topic
} else {
	// Initialise a new ElggObject
	$enlightndiscussion = new ElggObject();
	// Tell the system it's a simple post, url link, media,etc.
	$enlightndiscussion->subtype = ENLIGHTN_DISCUSSION;
	// Set its owner to the current user
	$enlightndiscussion->owner_guid = $user_guid;
	// Set the group it belongs to
	$enlightndiscussion->container_guid = $group_guid;
	// For now, set its access to public (we'll add an access dropdown shortly)
	$enlightndiscussion->access_id = $access;
	// Set its title and description appropriately
	$enlightndiscussion->title = $title;
	// Before we can set metadata, we need to save the topic
	if (!$enlightndiscussion->save()) {
		$json_return['message'] = elgg_echo("grouptopic:error");
		//forward("pg/groups/forum/{$group_guid}/");
	}
	// Now let's add tags. We can pass an array directly to the object property! Easy.
	if (is_array($tagarray)) {
		$enlightndiscussion->tags = $tagarray;
	}
	$message 	= create_embeded_entities($message,$enlightndiscussion);
	$post		= $message['message'];
	// now add the topic message as an annotation
	$annotationid = $enlightndiscussion->annotate($discussion_type,$post,$access, $user_guid);
	//link attachement
	if (is_array($message['guids'])) {
		foreach ($message['guids'] as $embeded_guids) {
			add_entity_relationship($embeded_guids,ENLIGHTN_EMBEDED,$annotationid);
		}
	}
	// add to river
	add_to_river('enlightn/river/create','create',$user_guid,$enlightndiscussion->guid,$access, 0, $post_id);
	// Success message
	//system_message(elgg_echo("grouptopic:created"));
	// Remove cache for public access
	$enlightn->flush_cache(array('access_level' => ENLIGHTN_ACCESS_PU),'search');
	$enlightn->flush_cache(array('user_guid' => $user_guid,'access_level' => ENLIGHTN_ACCESS_PR),'search');
	// Add users membership to the discussion
	//Current user
	add_entity_relationship($user_guid, ENLIGHTN_FOLLOW, $enlightndiscussion->guid);
	//Invited user
	$userto = parse_user_to($userto);
	if (is_array($userto)) {
		foreach ($userto as $key => $usertoid) {
			// Remove cache for private access, need to be deployed on user side
			if ($access == ACCESS_PRIVATE) {
				$enlightn->flush_cache(array('user_guid' => $usertoid),'unreaded');
				$enlightn->flush_cache(array('user_guid' => $usertoid,'access_level' => ENLIGHTN_ACCESS_PR),'search');
				$enlightn->flush_cache(array('user_guid' => $usertoid,'access_level' => ENLIGHTN_ACCESS_IN),'search');
			}
			$usertoid = get_entity((int)$usertoid);
			if ($usertoid->guid && $usertoid->guid != $enlightndiscussion->owner_guid) {
				/*if (!$usertoid->isFriend()) {
					add_entity_relationship($_SESSION['user']->guid, 'friend', $usertoid->guid);
				}*/
				if(add_entity_relationship($enlightndiscussion->guid, ENLIGHTN_INVITED, $usertoid->guid)) {
					// Add membership requested
					add_entity_relationship($usertoid->guid, 'membership_request', $enlightndiscussion->guid);
					// Send email
					$url = "{$CONFIG->url}pg/enlightn";
                    if ($usertoid->{"notification:method:".NOTIFICATION_EMAIL_INVITE} == '1') {
                        notify_user($usertoid->getGUID(), $enlightndiscussion->owner_guid,
                                sprintf(elgg_echo('enlightn:invite:subject'), $enlightndiscussion->title),
                                sprintf(elgg_echo('enlightn:invite:body'), $usertoid->name, $user_guid, $enlightndiscussion->title, $url),
                                NULL);
                    }

				}
			}
		}
	}
	//Mark the message as read
	//add_entity_relationship($user_guid, ENLIGHTN_READED, $enlightndiscussion->guid);
	add_entity_relationship($user_guid, ENLIGHTN_READED, $annotationid);
	$json_return['message'] = elgg_echo('enlightn:discussion_sucessfully_created');
    $json_return['success'] = $enlightndiscussion->guid;
}
echo json_encode($json_return);
exit();