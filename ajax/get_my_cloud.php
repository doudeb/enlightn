<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

//Some basic var
gatekeeper();
global $enlightn;
$user_guid		= elgg_get_logged_in_user_guid();
$user_ent		= get_user($user_guid);
$words 			= get_input('q','');
$date_begin             = get_input('date_begin');
$date_end 		= get_input('date_end');
$from_users             = get_input('from_users');
$from_users		= parse_user_to($from_users);
$subtype	 	= sanitise_string(get_input('subtype'));
$offset			= (int)get_input('offset', 0);
$limit			= (int)get_input('limit', 10);
$context		= sanitise_string(get_input('context'));
$guid   		= (int)get_input('guid');
$tags 			= sanitise_string(get_input('tags'));
$filter_id      	= (int)get_input('filter_id');
if ($context) {
    elgg_set_context($context);
}

$date_begin             = strtotime($date_begin);
$date_end 		= strtotime($date_end);


if (strlen($tags) > 0) {
    $tags       = explode(',',$tags);
}

$_SESSION['last_search_cloud']= serialize(array('user_guid'=>$user_guid,'subtype'=>$subtype,'words'=>$words,'from_users'=>$from_users,'date_begin'=>$date_begin, 'date_end'=>$date_end,'guid'=>$guid,'tags'=>$tags,'filter_id'=>$filter_id,'limit'=>$limit,'offset'=>$offset));

elgg_set_ignore_access(TRUE);
$files = $enlightn->get_my_cloud($user_guid,$subtype,$words,$from_users,$date_begin, $date_end,$guid,$tags,$filter_id,$limit,$offset);
echo elgg_view('enlightn/cloud/media', array(
							'entities' => $files,
							'internalname' => $internalname,
							'offset' => $offset,
							'count' => $count,
							'simpletype' => $simpletype,
							'limit' => $limit,
							'simpletypes' => $types,
					   ));
