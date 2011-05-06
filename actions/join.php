<?php
	/**
	 * Join a group action.
	 *
	 * @package ElggGroups
	 */

	// Load configuration
	gatekeeper();
	global $CONFIG;
	$url = $CONFIG->wwwroot . "pg/enlightn";
	$user_guid = get_loggedin_userid();
	$discussion_guid = get_input('discussion_guid');

	// @todo fix for #287
	// disable access to get entity.
	$invitations = get_invitations($user_guid, TRUE);

	if (in_array($discussion_guid, $invitations)) {
		$ia = elgg_set_ignore_access(TRUE);
	}

	$user = get_entity($user_guid);
	$discussion = get_entity($discussion_guid);

	if (($user instanceof ElggUser)) 	{
		if (add_entity_relationship($user->guid, 'member', $discussion->guid)) {
			system_message(elgg_echo("enlightn:joined"));

			// Remove any invite or join request flags
			remove_entity_relationship($discussion->guid, 'invited', $user->guid);
			remove_entity_relationship($user->guid, 'membership_request', $discussion->guid);
			// add to river
			add_to_river('river/relationship/member/create','join',$user->guid,$discussion->guid,$discussion->access_id);
			forward($url);
			exit;
		}
		else
			register_error(elgg_echo("groups:cantjoin"));

	}
	else
		register_error(elgg_echo("groups:cantjoin"));

	forward($url . '?discussion_id=' . $discussion->guid);
	exit;
?>
