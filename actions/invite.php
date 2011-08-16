<?php

    /**
	 * Elgg groups plugin add topic action.
	 *
	 * @package ElggGroups
	 */

	// Make sure we're logged in; forward to the front page if not
gatekeeper();
if (!isloggedin()) forward();
// Forward to the group forum page
global $CONFIG;
$url = $CONFIG->wwwroot . "pg/enlightn";

// Get input data
$userto 			= get_input('invite');
$userto				= parse_user_to($userto);
$user 				= $_SESSION['user']->getGUID();
$enlightndiscussion = get_entity(get_input('discussion_guid'));
/*if (!$enlightndiscussion->guid || $enlightndiscussion->owner_guid != $user) {
	echo elgg_echo('enlightn:cantinvite');
}*/
//Invited user
if (is_array($userto)) {
	foreach ($userto as $key => $usertoid) {
		$usertoid = get_entity($usertoid);
		if ($usertoid->guid) {
			add_entity_relationship($enlightndiscussion->guid, 'invited', $usertoid->guid);
			// Add membership requested
			add_entity_relationship($usertoid->guid, 'membership_request', $enlightndiscussion->guid);
			$enlightn->flush_cache(array('user_guid' => $usertoid->guid),'unreaded');

			// Send email
			$url = "{$CONFIG->url}pg/groups/invitations/{$usertoid->username}";
			if (notify_user($usertoid->getGUID(), $enlightndiscussion->owner_guid,
				sprintf(elgg_echo('groups:invite:subject'), $usertoid->name, $enlightndiscussion->name),
				sprintf(elgg_echo('groups:invite:body'), $usertoid->name, $_SESSION['user']->name, $enlightndiscussion->name, $url),NULL)) {
				system_message(elgg_echo("enlightn:userinvited"));
			} else {
				register_error(elgg_echo("groups:usernotinvited"));
			}
		}
	}
}
echo elgg_echo("enlightn:userinvited");
exit();
?>