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
global $CONFIG,$enlightn;
$url = $CONFIG->wwwroot . "pg/enlightn";
// Get input data
$userto 			= get_input('invite');
$userto				= parse_user_to($userto);
$user 				= get_loggedin_userid();
$guid               = get_input('discussion_guid');
disable_right($guid);
$enlightndiscussion = get_entity($guid);
/*if (!$enlightndiscussion->guid || $enlightndiscussion->owner_guid != $user) {
	echo elgg_echo('enlightn:cantinvite');
}*/
//Invited user
add_folowers($userto, $enlightndiscussion);
echo elgg_echo("enlightn:userinvited");
exit();
?>