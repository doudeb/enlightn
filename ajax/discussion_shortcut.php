<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");


//Some basic var
gatekeeper();
$user_guid 		= elgg_get_logged_in_user_guid();
global $enlightn;
/**
 * @todo set it to cache
 */

$last_search 	= unserialize($_SESSION['last_search']);


$words 			= $last_search['words'];
$date_begin 	= $last_search['date_begin'];
$date_end 		= $last_search['date_end'];
$from_users 	= $last_search['from_users'];
$subtype	 	= $last_search['subtype'];
$offset			= get_input('offset');
$limit			= $last_search['limit'];
$access_level	= get_input('access_level',$last_search['access_level']);
$entity_guid	= 0;
$fetch_modified	= 0;
$unreaded_only	= $last_search['unreaded_only'];

//Filtering some datas and disable the cache in some case.

$date_begin 	= strtotime($date_begin);


$date_end 		= strtotime($date_end);

if (empty($offset)) {
	$offset = 0;
}
if (empty($limit)) {
	$limit = 10;
}

//var_dump($user_guid,$entity_guid,$access_level,$unreaded_only,$words,$from_users,$date_begin,$date_end,$subtype,$offset,$limit);
$search_results 		= $enlightn->search($user_guid,$entity_guid,$access_level,$unreaded_only,$words,$from_users,$date_begin,$date_end,$subtype,$tag,$offset,$limit);
$nb_results = count($search_results);
if ($nb_results > 0) {
	header("Last-Modified: " . gmdate("D, d M Y H:i:s",$search_results[0]->created) . " GMT");
	header("Query-uid: " . md5($user_guid.$entity_guid.$access_level.$unreaded_only.$words.$from_users.$date_begin.$date_end.$subtype.$offset.$limit));
	header("Fetch-rows: " . $nb_results);
	if ($fetch_modified === '1') {
		//echo json_encode(array('last-modified' => $search_results[0]->created));
		return;
	}
	foreach ($search_results as $key => $topic) {
        disable_right($topic->guid);
		$flag_readed = check_entity_relationship($user_guid, ENLIGHTN_READED,$topic->id);
		$topic = get_entity($topic->guid);
		$results[$key] = array('guid'=>$topic->guid
							, 'readed' => $flag_readed?true:false
							, 'title' => $topic->title);
	}
} else {
    header("Fetch-rows: 0");
}
echo json_encode($results);