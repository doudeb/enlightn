<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");


//Some basic var
gatekeeper();
$user_guid = get_loggedin_userid();

/**
 * @todo set it to cache
 */
$username = get_input('q');
$i = -1;
$collection_found = get_user_access_collections ($user_guid);
if (is_array($collection_found)) {
	foreach ($collection_found as $key => $collection) {
		$usertojson[++$i]['id'] 	= 'C_'.$collection->id;
		$usertojson[$i]['name'] 	= $collection->name;
	}
}
set_context('search');
$userfound = (search_for_user($username));
if (is_array($userfound)) {
	foreach ($userfound as $key => $user) {
		$usertojson[++$i]['id'] 	= $user->guid;
		$usertojson[$i]['name'] 	= $user->name;
	}
}
echo json_encode($usertojson);