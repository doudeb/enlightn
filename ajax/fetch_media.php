<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");
require_once "../model/Embedly.php";
$api = new Embedly_API(array(
  'user_agent' => 'Mozilla/5.0 (compatible; embedly/example-app; support@embed.ly)'
));

//Some basic var
gatekeeper();
$user_guid = get_loggedin_userid();

$url = get_input('url');
$oembed = $api->oembed(array('url' => $url, 'maxwidth' => 350)); //, 'maxwidth' => 200));
echo elgg_view('enlightn/fetched',array('type' => 'media'
										,'entity' => $oembed[0]));