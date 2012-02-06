<?php
/**
 * Manage group invitation requests.
 *
 * @package ElggGroups
 */

include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");
gatekeeper();

set_page_owner(elgg_get_logged_in_user_guid());

$user = get_loggedin_user();

if ($user) {
	// @todo temporary workaround for exts #287.
	$invitations = get_invitations($user->getGUID());
	
	$area2 .= elgg_view('enlightn/invitationrequests',array('invitations' => $invitations));
	elgg_set_ignore_access($ia);
} else {
	$area2 .= elgg_echo("groups:noaccess");
}

echo $area2;