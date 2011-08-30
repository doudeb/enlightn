<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function enlightn_init() {

	//Disable rights
	//elgg_get_access_object()->set_ignore_access(true);

	require_once("helper/config.php");
	require_once("helper/enlightn.php");
	require_once("model/enlightn.php");
	$enlightn		= new enlightn();
    // Extend system CSS with our own styles
    //elgg_extend_view('css', 'enlightn/css');
    elgg_extend_view('js/initialise_elgg','enlightn/cloud/js');
    elgg_extend_view('js/initialise_elgg','enlightn/js');
    elgg_extend_view('profile/editicon','enlightn/helper/redirect');
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

    // Register entity type
    register_entity_type('object',ENLIGHTN_DISCUSSION);

}
function new_index($hook, $type, $return, $params) {
	if (isloggedin()) {
		forward('pg/enlightn/');
		return true;
	} else {
		$title = elgg_view_title(elgg_echo('enlightn:login'));
		set_context('main');
		$content = elgg_view("account/forms/login");
        page_draw($title, $content);
		return true;
	}
}


function set_site_id() {
	$site_guid = getenv('site_guid');
	if ($site_guid) {
		return $site_guid;
	}
	return false;
}

register_elgg_event_handler('init','system','enlightn_init');
// Look if required profile fiels have been created
register_elgg_event_handler('init','system','init_enlightn_profile_fields', 10001); // Ensure this runs after other plugins

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
		case "invitations":
			include($CONFIG->pluginspath . "enlightn/invitations.php");
			break;
		case "discuss":
			set_input('entity_guid', $page[1]);
			include($CONFIG->pluginspath . "enlightn/discuss.php");
			break;
		case "cloud":
			set_context('cloud');
			if ($page[1] == 'cloud_embed') {
				set_context('cloud_embed');
			}
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
			$collection_id = $page[1];
			include($CONFIG->pluginspath . "enlightn/directory.php");
			break;
		case "profile":
			set_input('username', $page[1]);
			include($CONFIG->pluginspath . "enlightn/profile.php");
			break;
		case "settings":
            set_context('enlightn:settings');
            set_input('current', $page[1]);
			include($CONFIG->pluginspath . "enlightn/settings.php");
			break;
        case "home":
        default:
			set_input('discussion_type', $page[1]);
			include($CONFIG->pluginspath . "enlightn/home.php");
			break;
		}
}

function init_enlightn_profile_fields () {
    global $profile_defaults,$CONFIG;
    foreach ($CONFIG->profile as $name=>$value) {
        $display_name =  elgg_echo('profile:' . $name);
        if (isset($profile_defaults[$display_name])) {
            unset($profile_defaults[$display_name]);
        }
    }
    $fields = $profile_defaults;
    $n = 0;
    foreach ($fields as $label => $type) {
        elgg_log("ENLIGHTN: Profile fields created :: " . $label, 'NOTICE');
        while (get_plugin_setting("admin_defined_profile_$n", 'profile')) {$n++;} // find free space

        if ( (set_plugin_setting("admin_defined_profile_$n", $label, 'profile')) &&
            (set_plugin_setting("admin_defined_profile_type_$n", $type, 'profile'))) {
                set_plugin_setting('user_defined_fields', TRUE, 'profile');
        }
    }
}