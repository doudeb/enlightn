<?php

    /**
	 * Elgg groups plugin add topic action.
	 *
	 * @package ElggGroups
	 */

// Make sure we're logged in; forward to the front page if not
gatekeeper();
if (!isloggedin()) forward();
global $enlightn;
// Get input data
$title 				= strip_tags(get_input('title'));
$message 			= get_input('description',null);
$tags 				= get_input('interests');
$access_id 			= get_input('membership');
$user_guid			= get_loggedin_userid(); // you need to be logged in to comment on a group forum
$userto 			= get_input('invite');
$discussion_subtype = get_input('discussion_subtype', ENLIGHTN_DISCUSSION);
$json_return        = array();
$json_return['success'] = false;
global $CONFIG;
// Convert string of tags into a preformatted array
$tagarray = string_to_tag_array($tags);
// Make sure the title / message aren't blank
if (empty($title) || empty($message)) {
	$json_return['message'] = elgg_echo('enlightn:missingData');
    // Otherwise, save the topic
} else {
   $json_return = create_enlightn_discussion ($user_guid, $access_id,$message, $title,$tags, $userto);
}
echo json_encode($json_return);
exit();