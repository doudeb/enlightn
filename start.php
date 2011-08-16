<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function enlightn_init() {
	global $CONFIG,$enlightn,$site_guid;
	//$CONFIG->site_guid = $site_guid;
	define('ENLIGHTN_DISCUSSION', 'enlightndiscussion');
	define('ENLIGHTN_LINK', 'enlightnlink');
	define('ENLIGHTN_MEDIA', 'enlightnmedia');
	define('ENLIGHTN_DOCUMENT', 'document');
	define('ENLIGHTN_IMAGE', 'image');
	define('ENLIGHTN_FOLLOW', 'member');
	define('ENLIGHTN_READED', 'readed');
	define('ENLIGHTN_EMBEDED', 'embeded');
	define('ENLIGHTN_INVITED', 'invited');
	define('ENLIGHTN_FAVORITE', 'favorite');
	define('ENLIGHTN_ACCESS_PU', '1');//Public access
	define('ENLIGHTN_ACCESS_PR', '2');//Private
	define('ENLIGHTN_ACCESS_FA', '3');//Favorite
	define('ENLIGHTN_ACCESS_AL', '4');//All ( Pu + Pr
	define('ENLIGHTN_ACCESS_IN', '5');//Invited aka requests
	define('ENLIGHTN_ACCESS_UN', '6');//Unreaded
	//Disable rights
	//elgg_get_access_object()->set_ignore_access(true);

	require_once("model/enlightn.php");
	$enlightn		= new enlightn();
	require_once("helper/enlightn.php");
    // Extend system CSS with our own styles
    //elgg_extend_view('css', 'enlightn/css');
    elgg_extend_view('js/initialise_elgg','enlightn/cloud/js');
	// Try to remove the dashboard page
    register_plugin_hook('index','system','new_index');
    //register_plugin_hook('siteid','system','set_site_id');
	// register for search
	register_entity_type('enlightn','');
	// Register a page handler, so we can have nice URLs
	register_page_handler('enlightn','enlightn_page_handler');
	// Register some actions
	register_action("enlightn/edit",false, $CONFIG->pluginspath . "enlightn/actions/discussion_edit.php");
	register_action("enlightn/addpost",false, $CONFIG->pluginspath . "enlightn/actions/addpost.php");
	register_action("enlightn/join",false, $CONFIG->pluginspath . "enlightn/actions/join.php");
	register_action("enlightn/invite",false, $CONFIG->pluginspath . "enlightn/actions/invite.php");
	register_action("enlightn/follow",false, $CONFIG->pluginspath . "enlightn/actions/follow.php");
	register_action("enlightn/read",false, $CONFIG->pluginspath . "enlightn/actions/read.php");
	register_action("enlightn/favorite",false, $CONFIG->pluginspath . "enlightn/actions/favorite.php");
	register_action("enlightn/upload",false, $CONFIG->pluginspath . "enlightn/actions/upload.php");
	//collection
	register_action("enlightn/collection/addcollection",false, $CONFIG->pluginspath . "enlightn/actions/collection/addcollection.php");
	register_action("enlightn/collection/removefromcollection",false, $CONFIG->pluginspath . "enlightn/actions/collection/removefromcollection.php");
	register_action("enlightn/collection/addtocollection",false, $CONFIG->pluginspath . "enlightn/actions/collection/addtocollection.php");

    // Replace the default index page
    //register_plugin_hook('index','system','new_index');
    // Register entity type
    // ALTER TABLE annotations ORDER BY id DESC
    register_entity_type('object',ENLIGHTN_DISCUSSION);

}
function new_index($hook, $type, $return, $params) {
	if (isloggedin()) {
		forward('pg/enlightn/');
		return true;
	}
	return false;
}


function set_site_id() {
	$site_guid = getenv('site_guid');
	if ($site_guid) {
		return $site_guid;
	}
	return false;
}

register_elgg_event_handler('init','system','enlightn_init');

/**
 * Group page handler
 *
 * @param array $page Array of page elements, forwarded by the page handling mechanism
 */
function enlightn_page_handler($page) {
	global $CONFIG,$enlightn;

	if (!isset($page[0])) {
		$page[0] = 'home';
	}
	switch ($page[0]) {
		case "home":
			set_input('discussion_type', $page[1]);
			include($CONFIG->pluginspath . "enlightn/home.php");
			break;
		case "invitations":
			include($CONFIG->pluginspath . "enlightn/invitations.php");
			break;
		case "discuss":
			set_input('entity_guid', $page[1]);
			include($CONFIG->pluginspath . "enlightn/discuss.php");
			break;
		case "cloud":
			set_input('entity_guid', $page[1]);
			set_input('annotation_id', $page[2]);
			include($CONFIG->pluginspath . "enlightn/cloud.php");
			break;
		case "upload":
			set_input('entity_guid', $page[1]);
			set_input('internal_id', $page[2]);
			include($CONFIG->pluginspath . "enlightn/upload.php");
			break;
		case "collection":
	        if ($user = get_user_by_username($page[0])) {
                set_page_owner($user->getGUID());
	        }
			$action = $page[1];
			include($CONFIG->pluginspath . "enlightn/collection.php");
			break;
		case "directory":
	        if ($user = get_user_by_username($page[0])) {
                set_page_owner($user->getGUID());
	        }
			$action = $page[1];
			include($CONFIG->pluginspath . "enlightn/directory.php");
			break;	}
}

?>