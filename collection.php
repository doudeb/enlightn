<?php
/**
 * Elgg add a collection of friends
 *
 * @package Elgg
 * @subpackage Core
 */

// You need to be logged in for this one
gatekeeper();

$left  = enlightn_collections_submenu_items();
switch ($action) {
	case 'add':
		$title = elgg_echo('friends:collections:add');
		$content = elgg_view_title($title);
		$content .= elgg_view('friends/forms/edit', array(
								'friends' => get_site_members($CONFIG->site_guid,100000)	)
								);
		break;
	default:
		$title = elgg_echo('friends:collections');
		$content = elgg_view_title($title);
		$content .= enlightn_view_access_collections(elgg_get_logged_in_user_guid());
	break;
}




$body = elgg_view_layout('two_column_left_sidebar', $left, $content);

page_draw($title, $body);