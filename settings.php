<?php
include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");


//Some basic var
gatekeeper();
global $enlightn, $profile_settings,$sn_linkers;
$user_guid 				= elgg_get_logged_in_user_guid();
$user   				= get_user($user_guid);
$current				= get_input('tab');

if (!$user_guid || !$user) {
	forward();
}

set_page_owner($user_guid);

$left  =  elgg_view('enlightn/settings/main',array('user' => $user, 'settings'=>$profile_settings, 'current'=>$current));

$search_filters = elgg_view('enlightn/settings/sidebar',array('user' => $user, 'settings'=>$profile_settings));
$right .= $search_filters ."</div>";
unset($search_filters);
$body = $left . $right;

echo elgg_view_page(elgg_echo('enlightn:settings'),$body,'enlightn');