<pre>
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
	$ignore_request	 	= get_input('ignore',false);

	if (!$discussion_guid && !empty ($annotation_id)) {
		$post 			= get_annotation($annotation_id);
		$discussion_guid= $post->entity_guid;
	}
	// @todo fix for #287
	// disable access to get entity.
	$is_follow			= check_entity_relationship($user_guid, ENLIGHTN_FOLLOW, $discussion_guid);
    if ($ignore_request == '1') {
		remove_entity_relationship($discussion_guid, ENLIGHTN_INVITED, $user_guid);
    } elseif ($is_follow) {
		remove_entity_relationship($user_guid, ENLIGHTN_FOLLOW, $discussion_guid);
		add_to_river('river/relationship/member/create','quit',$user->guid,$discussion_guid);
	} else {
		if (add_entity_relationship($user_guid, ENLIGHTN_FOLLOW, $discussion_guid)) {
			remove_entity_relationship($discussion_guid, ENLIGHTN_INVITED, $user_guid);
			add_to_river('river/relationship/member/create','join',$user->guid,$discussion_guid);
		}
	}
	$enlightn->flush_cache(array('user_guid' => $user_guid),'unreaded');
	$enlightn->flush_cache(array('user_guid' => $user_guid,'access_level' => ENLIGHTN_ACCESS_PR),'search');
	$enlightn->flush_cache(array('user_guid' => $user_guid,'access_level' => ENLIGHTN_ACCESS_PU),'search');
	$enlightn->flush_cache(array('user_guid' => $user_guid,'access_level' => ENLIGHTN_ACCESS_IN),'search');

exit;
?>
