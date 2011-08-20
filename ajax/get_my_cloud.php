<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

//Some basic var
gatekeeper();
global $enlightn;
$user_guid		= get_loggedin_userid();
$user_ent		= get_user($user_guid);
$words 			= get_input('q','');
$date_begin 	= get_input('date_begin');
$date_end 		= get_input('date_end');
$from_users 	= get_input('from_users');
$from_users		= parse_user_to($from_users);
$subtype	 	= get_input('subtype');
$offset			= get_input('offset', 0);
$limit			= get_input('limit', 10);
$types 			= get_tags(0,10,'simpletype','object','file',$user_guid);
$context		= get_input('context');

if ($context) {
	set_context($context);
}

$date_begin 	= strtotime($date_begin);
$date_end 		= strtotime($date_end);

elgg_get_access_object()->set_ignore_access(true);
$files = $enlightn->get_my_cloud($user_guid,$subtype,$words,$from_users,$date_begin, $date_end,$limit,$offset);
echo elgg_view('enlightn/cloud/media', array(
							'entities' => $files,
							'internalname' => $internalname,
							'offset' => $offset,
							'count' => $count,
							'simpletype' => $simpletype,
							'limit' => $limit,
							'simpletypes' => $types,
					   ));
