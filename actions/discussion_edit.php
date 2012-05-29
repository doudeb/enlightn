<?php

// Make sure we're logged in; forward to the front page if not
gatekeeper();
if (!isloggedin()) forward();
global $enlightn;
// Get input data
$title 				= strip_tags(get_input('title'));
$message 			= get_input('content',null);
$tags 				= get_input('tags');
$access_id 			= get_input('access_id');
$user_guid			= elgg_get_logged_in_user_guid(); // you need to be logged in to comment on a group forum
$userto 			= get_input('to');
$cloned_ids			= get_input('cloned_ids');
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
   $message     .= ' ' . generate_cloned_message($cloned_ids);
   $json_return = create_enlightn_discussion ($user_guid, $access_id,$message, $title,$tags, $userto);
}
echo json_encode($json_return);
exit();