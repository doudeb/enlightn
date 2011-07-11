<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

//Some basic var
gatekeeper();
global $enlightn;
$user_guid 			= get_loggedin_userid();
$user_ent			= get_user($user_guid);
$offset 			= (int) get_input('offset',0);
$limit	 			= (int) get_input('limit',10);
$simpletype 		= get_input('simpletype','simpletype');
$types 				= get_tags(0,10,'simpletype','object','file',$user_guid);

elgg_get_access_object()->set_ignore_access(true);
$files = $enlightn->get_my_cloud($user_guid,$simpletype,$limit,$offset);
echo elgg_view('enlightn/cloud/media', array(
							'entities' => $files,
							'internalname' => $internalname,
							'offset' => $offset,
							'count' => $count,
							'simpletype' => $simpletype,
							'limit' => $limit,
							'simpletypes' => $types,
					   ));
