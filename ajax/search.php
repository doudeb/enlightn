<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");


//Some basic var
gatekeeper();
$user_guid 		= get_loggedin_userid();		

/**
 * @todo set it to cache
 */
$words 			= get_input('q','');
$date_begin 	= get_input('date_begin', date('Y-m-d H:i:s'));
$date_end 		= get_input('date_end', date('Y-m-d H:i:s'));
$from_users 	= get_input('from_users');
$subtype	 	= get_input('subtype');
$offset			= get_input('offset', 0);
$limit			= get_input('limit', 10);
$access_level	= get_input('discussion_type', 4);

//var_dump($access_level,$subtype,$from_users,$date_begin,$date_end);


if($from_users == 'null') {
	$from_users = null;
}
if (empty($date_begin) || $date_begin == $date_end) {
	$date_begin = strtotime("-5 week");
} else {
	$date_begin 	= strtotime($date_begin);
}

if (empty($date_end)) {
	$date_end = strtotime("now");
} else {
	$date_end 	= strtotime($date_end);
}
//echo "<pre>";
//var_dump($from_users,$date_begin,$date_end);

$searchResults = enlightn::search($user_guid,$access_level,$words,$from_users,$date_begin,$date_end,$subtype,$offset,$limit);
if (is_array($searchResults)) {
	foreach ($searchResults as $key => $topic) {
    	echo  elgg_view("enlightn/discussion_short", array('entity' => $topic
    													, 'current' => $key===0?true:false
    													, 'user_guid' => $user_guid
    													, 'query' => $words
    													, 'discussion_id' => $discussion_id));		
	}
}