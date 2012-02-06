<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");


//Some basic var
gatekeeper();
$user_guid 			= elgg_get_logged_in_user_guid();
$discussion_type 	= get_input('discussion_type');
$discussion_id 		= get_input('discussion_id', false);
$offset				= get_input('offset');
//$discussion_items = enlightn::get_discussion($user_guid);
//var_dump($discussion_items);
$discussion_items 	= get_discussion($user_guid, $discussion_type, $offset);
elgg_get_access_object()->set_ignore_access(true);
foreach ($discussion_items as $key => $topic) {
    echo  elgg_view("enlightn/discussion_short", array('entity' => $topic
    													, 'current' => $key===0?true:false
    													, 'user_guid' => $user_guid
    													, 'discussion_id' => $discussion_id));
}
elgg_get_access_object()->set_ignore_access(false);