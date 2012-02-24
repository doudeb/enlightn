<?php
include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");


//Some basic var
gatekeeper();
global $enlightn;
$user_guid 				= elgg_get_logged_in_user_guid();
$user_ent				= get_user($user_guid);
if (!$user_guid || !$user_ent) {
	forward();
}

$left  =  elgg_view('enlightn/cloud/navigation',array());

$search_filters = elgg_view('enlightn/search_filters',array());
$memo_search    = elgg_view('enlightn/cloud/search_memo',array('user_ent'=>$user_ent));
$right .= $search_filters . $memo_search . "</div>";
unset($search_filters);
$body = $left . $right;

echo elgg_view_page(elgg_echo('enlightn:cloud'),$body,'enlightn');