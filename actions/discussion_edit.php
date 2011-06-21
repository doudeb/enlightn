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
$message 			= get_input('description');
$embeded 			= get_input('embedContent',null,false);
$tags 				= get_input('interests');
$access 			= get_input('membership');
$user_guid			= get_loggedin_userid(); // you need to be logged in to comment on a group forum
$userto 			= get_input('invite');
$userto				= explode(",", $userto);
$discussion_subtype = get_input('discussion_subtype', ENLIGHTN_DISCUSSION);
global $CONFIG;
// Convert string of tags into a preformatted array
$tagarray = string_to_tag_array($tags);
if (!is_null($embeded)) {
	$message .= $embeded;
}
// Make sure the title / message aren't blank
if (empty($title) || empty($message)) {
	register_error(elgg_echo("grouptopic:blank"));
	echo elgg_echo('enlightn:missingData');

// Otherwise, save the topic
} else {
	// Initialise a new ElggObject
	$enlightndiscussion = new ElggObject();
	// Tell the system it's a simple post, url link, media,etc.
	$enlightndiscussion->subtype = ENLIGHTN_DISCUSSION;
	// Set its owner to the current user
	$enlightndiscussion->owner_guid = $user_guid;
	// Set the group it belongs to
	$enlightndiscussion->container_guid = $group_guid;
	// For now, set its access to public (we'll add an access dropdown shortly)
	$enlightndiscussion->access_id = $access;
	// Set its title and description appropriately
	$enlightndiscussion->title = $title;
	// Before we can set metadata, we need to save the topic
	if (!$enlightndiscussion->save()) {
		register_error(elgg_echo("grouptopic:error"));
		//forward("pg/groups/forum/{$group_guid}/");
	}
	// Now let's add tags. We can pass an array directly to the object property! Easy.
	if (is_array($tagarray)) {
		$enlightndiscussion->tags = $tagarray;
	}

	// now add the topic message as an annotation
	$annotationid = $enlightndiscussion->annotate($discussion_type,$message,$access, $user_guid);
	// add to river
	add_to_river('enlightn/river/create','create',$user_guid,$enlightndiscussion->guid,$access, 0, $post_id);
	// Success message
	system_message(elgg_echo("grouptopic:created"));
	// Remove cache for public access
	$enlightn->flush_cache(array('access_level' => ENLIGHTN_ACCESS_PU),'search');
	$enlightn->flush_cache(array('user_guid' => $user_guid,'access_level' => ENLIGHTN_ACCESS_PR),'search');
	// Add users membership to the discussion
	//Current user
	add_entity_relationship($user_guid, 'member', $enlightndiscussion->guid);
	//Invited user
	if (is_array($userto)) {
		foreach ($userto as $key => $usertoid) {
			// Remove cache for private acces, need to be deployed on user side
			if ($access == ACCESS_PRIVATE) {
				$enlightn->flush_cache(array('user_guid' => $usertoid),'unreaded');
				$enlightn->flush_cache(array('user_guid' => $usertoid,'access_level' => ENLIGHTN_ACCESS_PR),'search');
				$enlightn->flush_cache(array('user_guid' => $usertoid,'access_level' => ENLIGHTN_ACCESS_IN),'search');
			}			
			$usertoid = get_entity((int)$usertoid);
			if ($usertoid->guid) {
				/*if (!$usertoid->isFriend()) {
					add_entity_relationship($_SESSION['user']->guid, 'friend', $usertoid->guid);
				}*/
				if(add_entity_relationship($enlightndiscussion->guid, 'invited', $usertoid->guid)) {
					// Add membership requested
					add_entity_relationship($usertoid->guid, 'membership_request', $enlightndiscussion->guid);
					// Send email
					$url = "{$CONFIG->url}pg/enlightn";
					if (notify_user($usertoid->getGUID(), $enlightndiscussion->owner_guid,
							sprintf(elgg_echo('enlightn:invite:subject'), $usertoid->name, $enlightndiscussion->name),
							sprintf(elgg_echo('enlightn:invite:body'), $usertoid->name, $_SESSION['user']->name, $enlightndiscussion->name, $url),
							NULL))
						system_message(elgg_echo("groups:userinvited"));
					else
						register_error(elgg_echo("groups:usernotinvited"));

				}
			}
		}
	}
	//Mark the message as read
	//add_entity_relationship($user_guid, ENLIGHTN_READED, $enlightndiscussion->guid);
	add_entity_relationship($user_guid, ENLIGHTN_READED, $annotationid);
	echo elgg_echo('enlightn:discussion_sucessfully_created');
}
?>
<script language="javascript">
	var discussion_id = <?php echo $enlightndiscussion->guid?$enlightndiscussion->guid:'false' ?>;
	console.log('discussion_id inserted:: ' + discussion_id);
</script>

<?php
exit();

?>