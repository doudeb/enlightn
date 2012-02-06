<?php
	/**
	 * Join a group action.
	 *
	 * @package ElggGroups
	 */

	// Load configuration
	gatekeeper();
	global $CONFIG,$enlightn;
	$url 				= $CONFIG->wwwroot . "pg/enlightn";
	$user_guid 			= elgg_get_logged_in_user_guid();
	$discussion_guid 	= get_input('discussion_guid');
	elgg_set_ignore_access(TRUE);

	$user = get_entity($user_guid);
	$discussion = get_entity($discussion_guid);
	if (($user instanceof ElggUser)) 	{
		// Remove any invite or join request flags
		remove_entity_relationship($discussion->guid, ENLIGHTN_INVITED, $user->guid);
		//remove_entity_relationship($user->guid, 'membership_request', $discussion->guid);
		if (add_entity_relationship($user->guid, 'member', $discussion->guid)) {
			system_message(elgg_echo("enlightn:joined"));
			// add to river
			add_to_river('river/relationship/member/create','join',$user->guid,$discussion->guid,$discussion->access_id);
			$enlightn->flush_cache(array('user_guid' => $user_guid),'unreaded');
			$enlightn->flush_cache(array('user_guid' => $user_guid,'access_level' => ENLIGHTN_ACCESS_PR),'search');
			$enlightn->flush_cache(array('user_guid' => $user_guid,'access_level' => ENLIGHTN_ACCESS_PU),'search');
			$enlightn->flush_cache(array('user_guid' => $user_guid,'access_level' => ENLIGHTN_ACCESS_IN),'search');
			forward($url);
			exit;
		} else {
			register_error(elgg_echo("groups:cantjoin"));
		}
	}
	forward($url);
	exit;
?>
