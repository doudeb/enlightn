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
	$discussion = get_entity($discussion_guid);
	if ($discussion->access_id == ACCESS_PUBLIC) 	{ // only public discussion can be followed
		if (add_entity_relationship($user_guid, 'member', $discussion->guid)) {
			system_message(elgg_echo("groups:joined"));
			add_to_river('river/relationship/member/create','join',$user->guid,$discussion->guid);
			exit;
		}
		else
			register_error(elgg_echo("groups:cantjoin"));

	}
	else
		register_error(elgg_echo("groups:cantjoin"));
exit;
?>
