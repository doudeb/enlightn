<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");
require_once "../model/Embedly.php";
$api = new Embedly_API(array(
  'user_agent' => 'Mozilla/5.0 (compatible; embedly/example-app; support@embed.ly)'
));

//Some basic var
gatekeeper();
$user_guid = get_loggedin_userid();
//tying with embedly
$url = get_input('url');
$media_uid = md5($url);
$oembed = $api->oembed(array('url' => $url)); //, 'maxwidth' => 200));
if (!isset($oembed[0]->error_code)) {
	echo elgg_view('enlightn/fetched',array('type' => 'media'
									,'entity' => $oembed[0]
									,'media_uid' => $media_uid));
} else {
	require_once "../model/EmbedUrl.php";
	$embedUrl = new Embed_url(array('url' => $url));
	$embedUrl->embed();
	echo elgg_view('enlightn/fetched',array('type' => 'url'
											,'entity' => $embedUrl
											,'media_uid' => $media_uid));
											
}