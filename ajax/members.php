<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");


//Some basic var
gatekeeper();
$user_guid = get_loggedin_userid();		

/**
 * @todo set it to cache
 */
$username = get_input('tag');

set_context('search');
$userfound = (search_for_user($username));
if (is_array($userfound)) {
	foreach ($userfound as $key => $user) {
		$usertojson[$key]['value'] 	= $user->guid;
		$usertojson[$key]['key'] 	= $user->name;
	}
}
echo json_encode($usertojson);