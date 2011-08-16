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
	$user_guid 			= get_loggedin_userid();
	$discussion_guid 	= get_input('discussion_guid');
	// @todo fix for #287
	// disable access to get entity.
	$discussion 		= get_entity($discussion_guid);
	$is_readed			= check_entity_relationship($user_guid, ENLIGHTN_READED, $discussion_guid);
	if ($is_readed) {
		remove_entity_relationship($user_guid, ENLIGHTN_READED, $discussion_guid);
		add_to_river('river/relationship/member/create','mark_as_unread',$user->guid,$discussion->guid);
	} else {
		if (add_entity_relationship($user_guid, ENLIGHTN_READED, $discussion_guid)) {
			add_to_river('river/relationship/member/create','mark_as_read',$user->guid,$discussion_guid);
		}
	}
	$enlightn->flush_cache(array('user_guid' => $user_guid),'unreaded');
	$enlightn->flush_cache(array('user_guid' => $user_guid,'access_level' => ENLIGHTN_ACCESS_PR),'search');
	$enlightn->flush_cache(array('user_guid' => $user_guid,'access_level' => ENLIGHTN_ACCESS_PU),'search');
	$enlightn->flush_cache(array('user_guid' => $user_guid,'access_level' => ENLIGHTN_ACCESS_IN),'search');
exit;
?>
