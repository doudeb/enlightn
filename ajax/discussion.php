<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");


	gatekeeper();	
    // get the entity from id
    elgg_get_access_object()->set_ignore_access(true);
    $topic = get_entity(get_input('discussion_id'));
    if (!$topic) forward();
	$owner = get_entity(get_loggedin_userid());
         
    // Display them
	echo elgg_view("enlightn/viewposts", array('entity' => $topic
												,'owner' => $owner));