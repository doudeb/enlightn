<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");


//Some basic var
gatekeeper();
$user_guid = get_loggedin_userid();
//retreive last activity
$offset = get_input('offset',0);
$limit  = get_input('limit',5);
//$activity_items = elgg_view_river_items(0,0,0,0,0,0,5);
$activity_items = get_activity_items($user_guid, $limit, $offset);
if ($activity_items) {
	echo elgg_view('river/item/list',array(
				'limit' => $limit,
				'offset' => $offset,
				'items' => $activity_items,
				'pagination' => true
			));
}