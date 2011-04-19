<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");


//Some basic var
gatekeeper();
$user_guid = get_loggedin_userid();
$discussion_type = get_input('discussion_type');
echo $user_guid;
//$discussion_items = enlightn::get_discussion($user_guid);
//var_dump($discussion_items);
$discussion_items = get_discussion($user_guid, $discussion_type);
foreach ($discussion_items as $key => $topic) {
    echo  elgg_view("enlightn/discussion_short", array('entity' => $topic, 'current' => $key===0?true:false));
}