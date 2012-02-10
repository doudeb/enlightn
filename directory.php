<?php
include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
//Some basic var
elgg_load_js('elgg.friendspicker');
gatekeeper();
global $enlightn, $CONFIG;
$user_guid 				= elgg_get_logged_in_user_guid();
$user_ent				= get_user($user_guid);
$user_search			= get_input('userSearch');
$site                   = $CONFIG->site;

if (!empty($user_search)) {
	$site_members		= elgg_trigger_plugin_hook('search','user',array('query' => $user_search, 'limit'=>100));
    $site_members       = $site_members["entities"];
} else {
	$site_members       = $site->getMembers(array("limit"=>1000));
}
if (isset($collection_id)) {
	$site_members		= get_members_of_access_collection($collection_id);
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
echo elgg_view_page(elgg_echo('enlightn:directory'),$body,'enlightn');