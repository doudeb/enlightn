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
$user 				= $_SESSION['user']->getGUID();
$enlightndiscussion = get_entity(get_input('discussion_guid'));
/*if (!$enlightndiscussion->guid || $enlightndiscussion->owner_guid != $user) {
	echo elgg_echo('enlightn:cantinvite');
}*/
//Invited user
if (is_array($userto)) {
	foreach ($userto as $key => $usertoid) {
		$usertoid = get_entity($usertoid);
		if ($usertoid->guid
                && $usertoid->guid != $enlightndiscussion->owner_guid
                && !check_entity_relationship($enlightndiscussion->guid, ENLIGHTN_INVITED, $usertoid->guid)) {
			add_entity_relationship($enlightndiscussion->guid, ENLIGHTN_INVITED, $usertoid->guid);
			// Add membership requested
			add_entity_relationship($usertoid->guid, 'membership_request', $enlightndiscussion->guid);
			$enlightn->flush_cache(array('user_guid' => $usertoid->guid),'unreaded');

            // Send email
            $url = "{$CONFIG->url}pg/enlightn";
            if ($usertoid->{"notification:method:".NOTIFICATION_EMAIL_INVITE} == '1') {
                notify_user($usertoid->getGUID(), $enlightndiscussion->owner_guid,
                        sprintf(elgg_echo('enlightn:invite:subject'), $enlightndiscussion->title),
                        sprintf(elgg_echo('enlightn:invite:body'), $usertoid->name, $_SESSION['user']->name, $enlightndiscussion->title, $url),
                        NULL);
            }
		}
	}
}
echo elgg_echo("enlightn:userinvited");
exit();
?>