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
	if (!check_entity_relationship($user_guid, ENLIGHTN_FAVORITE, $discussion->guid)) { 
		if (add_entity_relationship($user_guid, ENLIGHTN_FAVORITE, $discussion->guid)) {
			exit;
		}
		else
			register_error(elgg_echo("groups:cantjoin"));

	}
	else
		remove_entity_relationship($user_guid, ENLIGHTN_FAVORITE, $discussion->guid);
exit;
?>
