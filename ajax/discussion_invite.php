<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");


//Some basic var
gatekeeper();
$user_guid = get_loggedin_userid();
$discussion_guid = get_input('discussion_guid');
$topic = get_entity($discussion_guid);
//retreive last activity
echo elgg_view('enlightn/discussion_invite',array('entity' => $topic));