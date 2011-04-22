<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function enlightn_init() {
	global $CONFIG;
	define('ENLIGHTN_DISCUSSION', 'enlightndiscussion');
	define('ENLIGHTN_FOLLOW', 'member');
	//Disable rights
	//elgg_get_access_object()->set_ignore_access(true);
	//require_once("model/enlightn.php");
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
    // Replace the default index page
    //register_plugin_hook('index','system','new_index');
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
			include($CONFIG->pluginspath . "enlightn/index.php");
			break;
		case "invitations":
			include($CONFIG->pluginspath . "enlightn/invitations.php");
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
	function get_discussion ($user_guid, $discussiontype) {
		$discussions = array();
		$discussion_options = array();
		$discussion_options['limit'] = "10";
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
?>
