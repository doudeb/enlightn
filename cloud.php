<?php
include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");


//Some basic var
gatekeeper();
global $enlightn;
$user_guid 				= get_loggedin_userid();
$user_ent				= get_user($user_guid);
if (!$user_guid || !$user_ent) {
	forward();
}

$left  =  elgg_view('enlightn/cloud/navigation',array());

$search_filters = elgg_view('enlightn/search_filters',array());
$right .= $search_filters ."</div>";
unset($search_filters);
$body = $left . $right;

page_draw(elgg_echo('enlightn:cloud'),$body);