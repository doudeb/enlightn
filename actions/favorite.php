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
$user_guid = elgg_get_logged_in_user_guid();
$discussion_guid 	= get_input('discussion_guid');
$annotation_id	 	= get_input('annotation_id');

if (!$discussion_guid) {
	$post 			= elgg_get_annotation_from_id($annotation_id);
	$discussion_guid= $post->entity_guid;
}
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
