<?php
include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
//Some basic var
gatekeeper();
global $enlightn;
$user_guid 				= get_loggedin_userid();
$user_ent				= get_user($user_guid);

$site_members			= get_site_members($CONFIG->site_guid,100000);

$directory_top			= elgg_view('enlightn/directory/top',array(
																'user_ent' => $user_ent
																));
$left					= $directory_top;
unset($directory_top);

$directory_picker 		= elgg_view('enlightn/directory/picker',array(
																'user_ent' => $user_ent
																, 'entities' => $site_members
																));

$left					.= $directory_picker;
unset($directory_top);

$collection_list		= elgg_view('enlightn/directory/collection_list',array(
															'user_ent' => $user_ent
															));
$right					= $collection_list;
unset($collection_list);
//Compile into a layout
$body = $left . $right;
// Display page
page_draw(elgg_echo('enlightn:directory'),$body);