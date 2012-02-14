<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");


//Some basic var
gatekeeper();
global $enlightn;
$user_guid = elgg_get_logged_in_user_guid();

/**
 * @todo set it to cache
 */
$username = get_input('q');
$i = -1;
//$usertojson[++$i]['id'] 	= $username;
//$usertojson[$i]['name'] = $username;

$collections			= array();
$public_collection 		= get_user_access_collections(0);
$private_collection		= get_user_access_collections($user_guid);
$collections			= array_merge($public_collection?$public_collection:array(),
										$private_collection?$private_collection:array());
//$userfound = search_for_user($username);
$CONFIG->search_info['min_chars']   = 10;
$userfound                          = elgg_trigger_plugin_hook('search','user',array('query' => $username, 'limit'=>10));
$userfound                          = $userfound["entities"];
if (is_array($userfound)) {
	foreach ($userfound as $key => $user) {
		$usertojson[++$i]['id'] 	= $user->guid;
		$usertojson[$i]['name'] 	= $user->name;
		$usertojson[$i]['pic']      = elgg_view('input/user_photo',array('class'=>'users_small','user_ent'=>$user));
	}
}
$userfound = $enlightn->get_tags(false,array($username),false,2);
if (is_array($userfound)) {
    foreach ($userfound as $key => $tag) {
        $user                       = get_user($tag->owner_guid);
		$usertojson[++$i]['id'] 	= $user->guid;
		$usertojson[$i]['name'] 	= $user->name;
		$usertojson[$i]['pic']      = elgg_view('input/user_photo',array('class'=>'users_small','user_ent'=>$user));
    }
}
if (is_array($collections)) {
	foreach ($collections as $key => $collection) {
        if (strstr(strtolower($collection->name), strtolower($username))) {
    		$usertojson[++$i]['id'] 	= 'C_'.$collection->id;
        	$usertojson[$i]['name'] 	= $collection->name;
            $usertojson[$i]['pic']      = '<div class="users_small list_select"></div>';
        }
	}
}

echo json_encode($usertojson);