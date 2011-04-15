<?php

    /**
	 * Elgg groups plugin add topic action.
	 * 
	 * @package ElggGroups
	 */

	// Make sure we're logged in; forward to the front page if not
		if (!isloggedin()) forward();
		
    
	// Get input data
	    $title = strip_tags(get_input('name'));
		$message = get_input('description');
		$tags = get_input('interests');
		$access = get_input('membership');
		$user = $_SESSION['user']->getGUID(); // you need to be logged in to comment on a group forum
		$status = get_input('vis'); // sticky, resolved, closed
		$userto = get_input('invite');
	// Convert string of tags into a preformatted array
		$tagarray = string_to_tag_array($tags);
		
	// Make sure the title / message aren't blank
		if (empty($title) || empty($message)) {
			register_error(elgg_echo("grouptopic:blank"));
			forward("pg/groups/forum/{$group_guid}/");
			
	// Otherwise, save the topic
		} else {
			
	// Initialise a new ElggObject
			$enlightndiscussion = new ElggObject();
	// Tell the system it's a group forum topic
			$enlightndiscussion->subtype = "enlightndiscussion";
	// Set its owner to the current user
			$enlightndiscussion->owner_guid = $user;
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
	// add metadata
	        $enlightndiscussion->status = $status; // the current status i.e sticky, closed, resolved, open
	           
    // now add the topic message as an annotation
        	$enlightndiscussion->annotate('group_topic_post',$message,$access, $user);   
        	
    // add to river
	        add_to_river('enlightn/river/create','create',$_SESSION['user']->guid,$enlightndiscussion->guid);	        
	// Success message
			system_message(elgg_echo("grouptopic:created"));
	// Add users membership to the discussion
		//Current user
			add_entity_relationship($_SESSION['user']->guid, 'member', $enlightndiscussion->guid);
		//Invited user
			if (is_array($userto)) {
				foreach ($userto as $key => $usertoid) {
					$usertoid = get_entity($usertoid);
					if ($usertoid->guid) {
						if (!$usertoid->isFriend()) {
							add_entity_relationship($_SESSION['user']->guid, 'friend', $usertoid->guid);
						}
						if(add_entity_relationship($usertoid->guid, 'member', $enlightndiscussion->guid)) {
							// Send email
							$url = "{$CONFIG->url}pg/groups/invitations/{$usertoid->username}";
							if (notify_user($usertoid->getGUID(), $enlightndiscussion->owner_guid,
									sprintf(elgg_echo('groups:invite:subject'), $usertoid->name, $enlightndiscussion->name),
									sprintf(elgg_echo('groups:invite:body'), $usertoid->name, $_SESSION['user']->name, $enlightndiscussion->name, $url),
									NULL))
								system_message(elgg_echo("groups:userinvited"));
							else
								register_error(elgg_echo("groups:usernotinvited"));

						}
					}			
				}		
			}	
	// Forward to the group forum page
	        global $CONFIG;
	        $url = $CONFIG->wwwroot . "pg/enlightn/index/";
			forward($url);
			
				
		}
		
?>

