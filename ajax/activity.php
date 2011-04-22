<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");


//Some basic var
gatekeeper();
$user_guid = get_loggedin_userid();
sleep(1);
//retreive last activity
$offset = get_input('offset');
$activity_items = elgg_view_river_items(0,0,0,0,0,0,5);
echo $activity_items;