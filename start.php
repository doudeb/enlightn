<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function enlightn_init() {

    require_once("helper/config.php");
    require_once("helper/enlightn.php");
    require_once("model/enlightn.php");
    require_once("model/imap.class.php");
    $enlightn		= new enlightn();
    // Extend system CSS with our own styles
    //elgg_extend_view('css', 'enlightn/css');
    elgg_extend_view('page/elements/head','page_elements/header');
    elgg_extend_view('js/elgg','enlightn/cloud/js');
    elgg_extend_view('js/elgg','enlightn/js');
    elgg_extend_view('profile/editicon','enlightn/helper/redirect');
    // Try to remove the dashboard page
    elgg_register_plugin_hook_handler('validate', 'input', 'enlightn_filter_tags');
    elgg_unregister_plugin_hook_handler('validate', 'input', 'htmlawed_filter_tags');
    elgg_register_plugin_hook_handler('index','system','new_index');
    elgg_register_plugin_hook_handler('container_permissions_check', 'object', 'label_container_check');

    // register for search
    elgg_register_entity_type('enlightn','');
    // Register a page handler, so we can have nice URLs
    elgg_register_page_handler('enlightn','enlightn_page_handler');
    // Register some actions
    $action_path = elgg_get_plugins_path() . 'enlightn/actions/';
    elgg_register_action("enlightn/edit",$action_path . "discussion_edit.php");
    elgg_register_action("enlightn/addpost",$action_path . "addpost.php");
    elgg_register_action("enlightn/join",$action_path . "join.php");
    elgg_register_action("enlightn/invite",$action_path . "invite.php");
    elgg_register_action("enlightn/follow",$action_path . "follow.php");
    elgg_register_action("enlightn/read",$action_path . "read.php");
    elgg_register_action("enlightn/favorite",$action_path . "favorite.php");
    elgg_register_action("enlightn/upload",$action_path . "upload.php");
    elgg_register_action("enlightn/save_notifications",$action_path . "save_notifications.php");
    elgg_register_action("enlightn/profile_edit",$action_path . "profile_edit.php");
    //collection
    elgg_register_action("enlightn/collection/addcollection",$action_path . "collection/addcollection.php");
    elgg_register_action("enlightn/collection/removefromcollection",$action_path . "collection/removefromcollection.php");
    elgg_register_action("enlightn/collection/addtocollection",$action_path . "collection/addtocollection.php");
    //search cloud memo
    elgg_register_action("enlightn/cloud/saveSearch",$action_path . "cloud/saveSearch.php");
    elgg_register_action("enlightn/cloud/removeSearch",$action_path . "cloud/removeSearch.php");
    elgg_register_action("enlightn/cloud/addFilterToLabel",$action_path . "cloud/addFilterToLabel.php");
    elgg_register_action("enlightn/cloud/removeAttachedFilter",$action_path . "cloud/removeAttachedFilter.php");
    //for any objects
    elgg_register_action("enlightn/removeObject",$action_path . "removeObject.php");
    // Register entity type
    elgg_register_entity_type('object',ENLIGHTN_DISCUSSION);
    // register css
    elgg_register_external_file('css','discuss',$CONFIG->url . 'mod/enlightn/media/css/discuss.css','head');
    //elgg_register_external_file('js','discuss',$CONFIG->url . 'mod/enlightn/media/js/discuss.js','head');
    // Load profile settings
    $profile_settings = get_profile_settings();
    if (!empty($profile_settings['timezone'])) {
        $timezone = $profile_settings['timezone'];
    } else {
        $timezone = 'Europe/Paris';
    }
    date_default_timezone_set($timezone);
    //Register notification handler
    register_notification_handler(NOTIFICATION_EMAIL_INVITE,'email_invite_notify_handler');
    register_notification_handler(NOTIFICATION_EMAIL_MESSAGE_FOLLOWED,'email_message_followed_notify_handler');
    elgg_register_event_handler('shutdown','system', 'enlightn_purge_readed_queue',1000);
    elgg_register_event_handler('login', 'user','enlightn_verify_user_site_guid');
    // do we need to overrule default email notifications
    register_notification_handler("email", "html_email_handler_notification_handler");
    elgg_register_plugin_hook_handler('rest', 'init', 'enlightn_api_set_site_id');
    verify_last_forward();

}
function new_index($hook, $type, $return, $params) {
	if (elgg_is_logged_in()) {
		forward('enlightn/');
		return true;
	} else {
		$title = elgg_echo('enlightn:login');
		$content = elgg_view("account/forms/login");
        echo elgg_view_page($title, $content);
		return true;
	}
}


elgg_register_event_handler('init','system','enlightn_init');
// Look if required profile fiels have been created

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
			include(elgg_get_plugins_path() . "enlightn/invitations.php");
			break;
		case "discuss":
			set_input('entity_guid', $page[1]);
			elgg_set_context('discuss');
			include(elgg_get_plugins_path() . "enlightn/discuss.php");
			break;
 		case "discussV2":
			set_input('entity_guid', $page[1]);
			elgg_set_context('discuss');
			include(elgg_get_plugins_path() . "enlightn/discussV2.php");
			break;
		case "cloud":
			elgg_set_context('cloud');
			if ($page[1] == 'cloud_embed') {
				elgg_set_context('cloud_embed');
			}
			include(elgg_get_plugins_path() . "enlightn/cloud.php");
			break;
		case "upload":
			set_input('entity_guid', $page[1]);
			set_input('internal_id', $page[2]);
			include(elgg_get_plugins_path() . "enlightn/upload.php");
			break;
		case "collection":
	        if ($user = get_user_by_username($page[0])) {
                set_page_owner($user->getGUID());
	        }
			set_context('collection');
			$action = $page[1];
			include(elgg_get_plugins_path() . "enlightn/collection.php");
			break;
		case "directory":
			elgg_set_context('directory');
			$collection_id = $page[1];
			include(elgg_get_plugins_path() . "enlightn/directory.php");
			break;
		case "profile":
			elgg_set_context('profile');
			set_input('username', $page[1]);
			include(elgg_get_plugins_path() . "enlightn/profile.php");
			break;
		case "settings":
            elgg_set_context('enlightn:settings');
   			$page[1]?set_input('tab', $page[1]):set_input('tab', 'account');
            include(elgg_get_plugins_path() . "enlightn/settings.php");
			break;
		case "download":
            elgg_set_context('enlightn:download');
            set_input('file_guid', $page[1]);
			include(elgg_get_plugins_path() . "enlightn/download.php");
			break;
        case "home":
        default:
            elgg_set_context('home');
			set_input('discussion_type', $page[0]=='home'?ENLIGHTN_ACCESS_PU:$page[0]);
			include(elgg_get_plugins_path() . "enlightn/home.php");
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

function enlightn_verify_user_site_guid($login, $user, ElggUser $user) {
    $site = elgg_trigger_plugin_hook("siteid", "system");
    if ($site === null || $site === false) {
        $site = (int) datalist_get('default_site');
    }
    if ($user->site_guid == $site) {
        return true;
    }
    return false;
}

function enlightn_api_set_site_id () {
	global $CONFIG;
	elgg_unregister_event_handler('login', 'user','enlightn_verify_user_site_guid');
	$method = get_input('method');
	$token = get_input('auth_token');
	if ($method == 'auth.gettoken') {
		$username = get_input('username');
		$password = get_input('password');
		if (elgg_authenticate($username, $password)) {
			$user_ent = get_user_by_username($username);
		} else {
			return false;
		}
	} elseif (isset($token)) {
		$time = time();
		$user_session = get_data_row("SELECT * from {$CONFIG->dbprefix}users_apisessions
										where token='$token' And $time < expires");
		$user_guid = validate_user_token($token, $user_session->site_guid);
		$user_ent = get_entity($user_guid);
		// user token can also be used for user authentication
		register_pam_handler('pam_auth_usertoken');
	}
	if (isset($user_ent->site_guid)) {
		$CONFIG->site_guid = $CONFIG->site_id = $user_ent->site_guid;
		return true;
	}
	return false;
}
