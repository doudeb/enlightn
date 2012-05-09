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
	$guid               = get_input('guid');
	$annotation_id	 	= get_input('annotation_id');
	$ignore_request	 	= get_input('ignore',false);
	$include_cascade	= get_input('cascade',false);


	if (!$guid && !empty ($annotation_id)) {
		$post 			= elgg_get_annotation_from_id($annotation_id);
		$discussion_guid= $post->entity_guid;
	}
    if ($include_cascade) {
        $label_ent = get_entity($guid);
        $children_ent = get_label_childrens($label_ent);
    }
	// @todo fix for #287
	// disable access to get entity.
	$is_follow			= check_entity_relationship($user_guid, ENLIGHTN_FOLLOW, $guid);
    if ($ignore_request == '1') {
		remove_entity_relationship($guid, ENLIGHTN_INVITED, $user_guid);
    } elseif ($is_follow) {
		remove_entity_relationship($user_guid, ENLIGHTN_FOLLOW, $guid);
		add_to_river('river/relationship/member/create','quit',$user->guid,$guid);
        if (is_array($children_ent) && $include_cascade) {
            foreach ($children_ent as $key => $children_guid) {
                remove_entity_relationship($user_guid, ENLIGHTN_FOLLOW, $children_guid);
            }
        }
	} else {
		if (add_entity_relationship($user_guid, ENLIGHTN_FOLLOW, $guid)) {
			remove_entity_relationship($guid, ENLIGHTN_INVITED, $user_guid);
			add_to_river('river/relationship/member/create','join',$user->guid,$guid);
            if (is_array($children_ent) && $include_cascade) {
                foreach ($children_ent as $key => $children_guid) {
                    add_entity_relationship($user_guid, ENLIGHTN_FOLLOW, $children_guid);
                }
            }
		}
	}
	$enlightn->flush_cache(array('user_guid' => $user_guid),'unreaded');
	$enlightn->flush_cache(array('user_guid' => $user_guid,'access_level' => ENLIGHTN_ACCESS_PR),'search');
	$enlightn->flush_cache(array('user_guid' => $user_guid,'access_level' => ENLIGHTN_ACCESS_PU),'search');
	$enlightn->flush_cache(array('user_guid' => $user_guid,'access_level' => ENLIGHTN_ACCESS_IN),'search');

exit;