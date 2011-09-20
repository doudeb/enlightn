<?php
include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
//Some basic var
gatekeeper();
global $enlightn;
$user_guid 				= get_loggedin_userid();
$user_ent				= get_user($user_guid);
$user_search			= get_input('userSearch');

if (!empty($user_search)) {
	$site_members			= search_for_user($user_search);
} else {
	$site_members			= get_site_members($CONFIG->site_guid,100000);
}
if (isset($collection_id)) {
	$site_members			= get_members_of_access_collection($collection_id);
}
$collections			= array();
$public_collection 		= get_user_access_collections(0);
$private_collection		= get_user_access_collections($user_ent->guid);
$collections			= array_merge($public_collection?$public_collection:array(),
										$private_collection?$private_collection:array());
$directory_top			= elgg_view('enlightn/directory/top',array(
																'user_ent' => $user_ent
																, 'user_search' => $user_search
																));
$left					= $directory_top;
unset($directory_top);

$directory_picker 		= elgg_view('enlightn/directory/picker',array(
																'user_ent' => $user_ent
																, 'entities' => $site_members
															, 'collections' => $collections
																));

$left					.= $directory_picker;
unset($directory_top);

$collection_list		= elgg_view('enlightn/directory/collection_list',array(
															'user_ent' => $user_ent
															, 'collections' => $collections
                                                            , 'collection_id' => $collection_id
															));
$right					= $collection_list;
unset($collection_list);
//Compile into a layout
$body = $left . $right;
// Display page
page_draw(elgg_echo('enlightn:directory'),$body);