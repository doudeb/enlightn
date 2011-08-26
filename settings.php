<?php
include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");


//Some basic var
gatekeeper();
global $enlightn;
$user_guid 				= get_loggedin_userid();
$user   				= get_user($user_guid);

$profile_settings		= array();
//Retrveive all defined profile settings
foreach ($CONFIG->profile as $key => $fields) {
	if ($metadata = get_metadata_byname($user->guid, $key)) {
		$value = $metadata->value;
		$value_name = elgg_echo('profile:' . $metadata->name);
		$profile_settings[$value_name]['value'] = $value;
		$profile_settings[$value_name]['original_name'] = $key;
	}
}
if (!$user_guid || !$user) {
	forward();
}

set_page_owner($user_guid);

$left  =  elgg_view('enlightn/settings/main',array('user' => $user, 'settings'=>$profile_settings));

$search_filters = elgg_view('enlightn/settings/sidebar',array('user' => $user, 'settings'=>$profile_settings));
$right .= $search_filters ."</div>";
unset($search_filters);
$body = $left . $right;

page_draw(elgg_echo('enlightn:settings'),$body);
