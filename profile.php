<?php
include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");


//Some basic var
gatekeeper();
global $enlightn,$profile_settings;
$user_guid 				= get_loggedin_userid();
$user_ent				= get_user($user_guid);
$username				= get_input('username');
$user 					= get_user_by_username($username);


if (!$user_guid || !$user_ent) {
	forward();
}

$left  =  elgg_view('enlightn/profile/main',array('user' => $user, 'settings'=>$profile_settings));

$search_filters = elgg_view('enlightn/profile/sidebar',array('user' => $user, 'settings'=>$profile_settings));
$right .= $search_filters;
unset($search_filters);
$body = $left . $right;

page_draw(elgg_echo('enlightn:profile'),$body);