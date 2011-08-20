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
$collections			= array();
$public_collection 		= get_user_access_collections(0);
$private_collection		= get_user_access_collections($user_guid);
$collections			= array_merge($public_collection?$public_collection:array(),
										$private_collection?$private_collection:array());
if (is_array($collections)) {
	foreach ($collections as $key => $collection) {
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