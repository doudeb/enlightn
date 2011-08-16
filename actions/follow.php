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
	$annotation_id	 	= get_input('annotation_id');

	if (!$discussion_guid) {
		$post 			= get_annotation($annotation_id);
		$discussion_guid= $post->entity_guid;
	}

	// @todo fix for #287
	// disable access to get entity.
	$discussion 		= get_entity($discussion_guid);
	$is_follow			= check_entity_relationship($user_guid, ENLIGHTN_FOLLOW, $discussion_guid);
	if ($is_follow) {
		remove_entity_relationship($user_guid, ENLIGHTN_FOLLOW, $discussion_guid);
		add_to_river('river/relationship/member/create','quit',$user->guid,$discussion->guid);
	} else {
		if (add_entity_relationship($user_guid, 'member', $discussion->guid)) {
			remove_entity_relationship($discussion->guid, 'invited', $user_guid);
			system_message(elgg_echo("enlightn:joined"));
			add_to_river('river/relationship/member/create','join',$user->guid,$discussion->guid);
		}
	}
	$enlightn->flush_cache(array('user_guid' => $user_guid),'unreaded');
	$enlightn->flush_cache(array('user_guid' => $user_guid,'access_level' => ENLIGHTN_ACCESS_PR),'search');
	$enlightn->flush_cache(array('user_guid' => $user_guid,'access_level' => ENLIGHTN_ACCESS_PU),'search');
	$enlightn->flush_cache(array('user_guid' => $user_guid,'access_level' => ENLIGHTN_ACCESS_IN),'search');
exit;
?>
