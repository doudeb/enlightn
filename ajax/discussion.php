<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");


	gatekeeper();	
    // get the entity from id
    $topic = get_entity(get_input('discussion_id'));
    if (!$topic) forward();
	
         
    // Display them
	echo elgg_view("enlightn/viewposts", array('entity' => $topic));