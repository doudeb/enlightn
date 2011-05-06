<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");
require_once "../model/EmbedUrl.php";

//Some basic var
gatekeeper();
$user_guid = get_loggedin_userid();

$url = get_input('url');

$embedUrl = new Embed_url(array('url' => $url));
$embedUrl->embed();
echo elgg_view('enlightn/fetched',array('type' => 'url'
										,'entity' => $embedUrl));