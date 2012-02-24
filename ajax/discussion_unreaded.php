<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");


//Some basic var
gatekeeper();
global $enlightn;
$user_guid 				= elgg_get_logged_in_user_guid();
$discussion_unreaded	= $enlightn->count_unreaded_discussion($user_guid);
if (is_array($discussion_unreaded)) {
	echo json_encode(sort_unreaded_for_nav($discussion_unreaded));
} else {
    echo json_encode(false);
}