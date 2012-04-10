<?php
include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");


//Some basic var
gatekeeper();
global $enlightn;
$user_guid 				= elgg_get_logged_in_user_guid();
$user_ent				= get_user($user_guid);
$username				= get_input('username');
$user 					= get_user_by_username($username);
$user_settings          = get_profile_settings($user->guid);
if (!$user_guid || !$user_ent) {
	forward();
}
add_to_river('enlightn/helper/riverlog','open', $user_guid,$user->guid);
$tags       = $enlightn->get_tags($user->guid,false,false);
$main  =  elgg_view('enlightn/profile/main',array('user' => $user, 'settings'=>$user_settings, 'tags'=> $tags));

$right = elgg_view('enlightn/profile/sidebar',array('user' => $user, 'settings'=>$user_settings));
$body = $main . $right;

echo elgg_view_page(elgg_echo('enlightn:profile'),$body,'enlightn');