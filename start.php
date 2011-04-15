<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function enlightn_init() {
	global $CONFIG;
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
		$page[0] = 'all';
	}

	switch ($page[0]) {
		case "world":
		case "all":
		case "home":
			include($CONFIG->pluginspath . "enlightn/index.php");
			break;
	}
}
?>
