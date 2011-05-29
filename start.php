<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function enlightn_init() {
	global $CONFIG;
	define('ENLIGHTN_DISCUSSION', 'enlightndiscussion');
	define('ENLIGHTN_LINK', 'enlightnlink');
	define('ENLIGHTN_MEDIA', 'enlightnmedia');
	define('ENLIGHTN_DOCUMENT', 'document');
	define('ENLIGHTN_FOLLOW', 'member');
	define('ENLIGHTN_READED', 'readed');
	define('ENLIGHTN_FAVORITE', 'favorite');
	//Disable rights
	//elgg_get_access_object()->set_ignore_access(true);
	require_once("model/enlightn.php");
    // Extend system CSS with our own styles
    //extend_view('css','enlightn/css');
    elgg_extend_view('css', 'enlightn/css');
	// register for search
	register_entity_type('enlightn','');
	// Register a page handler, so we can have nice URLs
	register_page_handler('enlightn','enlightn_page_handler');
	// Register some actions
	register_action("enlightn/edit",false, $CONFIG->pluginspath . "enlightn/actions/discussion_edit.php");
	register_action("enlightn/addpost",false, $CONFIG->pluginspath . "enlightn/actions/addpost.php");
	register_action("enlightn/join",false, $CONFIG->pluginspath . "enlightn/actions/join.php");
	register_action("enlightn/invite",false, $CONFIG->pluginspath . "enlightn/actions/discussion_invite.php");
	register_action("enlightn/follow",false, $CONFIG->pluginspath . "enlightn/actions/follow.php");
	register_action("enlightn/favorite",false, $CONFIG->pluginspath . "enlightn/actions/favorite.php");
    // Replace the default index page
    //register_plugin_hook('index','system','new_index');
    // Register entity type
    // ALTER TABLE annotations ORDER BY id DESC
    register_entity_type('object',ENLIGHTN_DISCUSSION);

}

register_elgg_event_handler('init','system','enlightn_init');


/**
 * Group page handler
 *
 * @param array $page Array of page elements, forwarded by the page handling mechanism
 */
function enlightn_page_handler($page) {
	global $CONFIG;

	if (!isset($page[0])) {
		$page[0] = 'home';
	}
	switch ($page[0]) {
		case "home":
			include($CONFIG->pluginspath . "enlightn/home.php");
			break;
		case "invitations":
			include($CONFIG->pluginspath . "enlightn/invitations.php");
			break;
		case "discuss":
			set_input('discussion_id', $page[1]);
			include($CONFIG->pluginspath . "enlightn/discuss.php");
			break;
	}
}

	/**
	 * Grabs groups by invitations
	 * Have to override all access until there's a way override access to getter functions.
	 *
	 * @param $user_guid
	 * @return unknown_type
	 */
	function get_invitations($user_guid, $return_guids = false) {
		$ia = elgg_set_ignore_access(TRUE);
		$invitations = elgg_get_entities_from_relationship(array('relationship' => 'invited', 'relationship_guid' => $user_guid, 'inverse_relationship' => TRUE, 'limit' => 9999));
		if ($return_guids) {
			$guids = array();
			foreach ($invitations as $invitation) {
				$guids[] = $invitation->getGUID();
			}

			return $guids;
		}

		return $invitations;
	}
	/**
	 * Grabs discussion by different way
	 * Have to override all access until there's a way override access to getter functions.
	 *
	 * @param int discussion tpye
	 * 	1 all public discussion
	 * 	2 private discussion
	 * 	3 favourite (one day...)
	 * 	7 all (like linux....)
	 * @return unknown_type
	 */	
	function get_discussion ($user_guid, $discussiontype, $offset = 0) {
		$discussions = array();
		$discussion_options = array();
		$discussion_options['limit'] = "10";
		$discussion_options['offset'] = $offset;
		$discussion_options['types'] = "object";
		$discussion_options['subtypes'] = ENLIGHTN_DISCUSSION;		
		switch ($discussiontype) {
			case 1:
				$discussions = elgg_get_entities($discussion_options);				
				break;
			case 2:
				$discussion_options['relationship'] = ENLIGHTN_FOLLOW;
				$discussion_options['relationship_guid'] = $user_guid;
				$discussion_options['inverse_relationship'] = false;
				elgg_get_access_object()->set_ignore_access(true);
				$discussions = elgg_get_entities_from_relationship($discussion_options);
				elgg_get_access_object()->set_ignore_access(false);
				break;
			case 3:
				$discussion_options['relationship'] = ENLIGHTN_FAVORITE;
				$discussion_options['relationship_guid'] = $user_guid;
				$discussion_options['inverse_relationship'] = false;
				elgg_get_access_object()->set_ignore_access(true);
				$discussions = elgg_get_entities_from_relationship($discussion_options);
				elgg_get_access_object()->set_ignore_access(false);
				break;				
			default:
				$discussions += get_discussion($user_guid,1);
				$discussions += get_discussion($user_guid,2);
				break;
		}
		
		return $discussions;
	}
	
/**
 * Return a list of this group's members.
 *
 * @param int $group_guid The ID of the container/group.
 * @param int $limit The limit
 * @param int $offset The offset
 * @param int $site_guid The site
 * @param bool $count Return the users (false) or the count of them (true)
 * @return mixed
 */
function get_discussion_members($discussion_guid, $limit = 10, $offset = 0, $site_guid = 0, $count = false) {

	// in 1.7 0 means "not set."  rewrite to make sense.
	if (!$site_guid) {
		$site_guid = ELGG_ENTITIES_ANY_VALUE;
	}

	return elgg_get_entities_from_relationship(array(
		'relationship' => 'member',
		'relationship_guid' => $discussion_guid,
		'inverse_relationship' => TRUE,
		'types' => 'user',
		'limit' => $limit,
		'offset' => $offset,
		'count' => $count,
		'site_guid' => $site_guid
	));
}

function get_activity_items ($user_guid, $limit = 10, $offset = 0) {
	$sql = "Select r.* 
From river r
Left Join entity_relationships As rel On rel.guid_two In(r.object_guid, r.annotation_id) And rel.guid_one = $user_guid And rel.relationship = '" . ENLIGHTN_READED . "'
Where r.subject_guid != $user_guid
And rel.id Is Null
Order By r.posted Desc
Limit $offset, $limit";
	return get_data($sql);
	/*global $activity_items;
	$nb_item 		= count($activity_items);
	if (count($activity_items) === 0) {
		$activity_items = array();
	}	
	$activity_items = array_merge($activity_items, get_river_items(0,0,0,0,0,0,$limit - $nb_item,$offset));
	if (is_array($activity_items)) {
		foreach ($activity_items as $key=>$item) {
			if ($item->subject_guid === $user_guid) {
				unset($activity_items[$key]);
			}
			if (check_entity_relationship($user_guid,ENLIGHTN_READED,$item->object_guid)) {
				unset($activity_items[$key]);
			}
			if (check_entity_relationship($user_guid,ENLIGHTN_READED,$item->annotation_id)) {
				unset($activity_items[$key]);
			}
		}
	}
	$nb_item 		= count($activity_items);
	if ($nb_item < $limit) {
		$activity_items = get_activity_items($user_guid,$limit,$offset+$limit);
	}*/
	return $activity_items;
}

?>