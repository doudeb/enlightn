<?php
	/**
	 * Join a group action.
	 *
	 * @package ElggGroups
	 */

// Load configuration
gatekeeper();
global $CONFIG, $enlightn;
$url = $CONFIG->wwwroot . "pg/enlightn";
$user_guid = get_loggedin_userid();
$discussion_guid = get_input('discussion_guid');
// @todo fix for #287
// disable access to get entity.
$discussion = get_entity($discussion_guid);
if (!check_entity_relationship($user_guid, ENLIGHTN_FAVORITE, $discussion->guid)) { 
	add_entity_relationship($user_guid, ENLIGHTN_FAVORITE, $discussion->guid);
} else {
	remove_entity_relationship($user_guid, ENLIGHTN_FAVORITE, $discussion->guid);
}
$enlightn->flush_cache(array('user_guid' => $user_guid,'access_level' => ENLIGHTN_ACCESS_FA),'search');
exit;
?>
