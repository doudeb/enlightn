<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

gatekeeper();
$user_guid = get_loggedin_userid();
global $CONFIG;
$embed_guid 		= get_input('guid');
$file				= new ElggFile((int)$embed_guid);

//is description already loaded
$to_fetch = $file->description === $file->originalfilename;
if ($to_fetch) {
	switch ($file->simpletype) {
		case ENLIGHTN_MEDIA :
			require_once $CONFIG->pluginspath . "enlightn/model/Embedly.php";
			$api = new Embedly_API(array('user_agent' => 'Mozilla/5.0 (compatible; embedly/example-app; support@embed.ly)'));
			$oembed = $api->oembed(array('url' => $file->originalfilename));
			$media_uid = $file->entity_guid;
			$file->description = elgg_view('enlightn/fetched_media',array('entity'=> $oembed[0],'media_uid' => $media_uid));
			$file->save();
			break;
		case ENLIGHTN_LINK:
			require_once $CONFIG->pluginspath . "enlightn/model/Embedly.php";
			require_once $CONFIG->pluginspath . "enlightn/model/EmbedUrl.php";
			$api = new Embedly_API(array('user_agent' => 'Mozilla/5.0 (compatible; embedly/example-app; support@embed.ly)'));
			$oembed = $api->oembed(array('url' => $file->originalfilename));
			if (!isset($oembed[0]->error_code)) {
				$media_uid = $file->entity_guid;
				$file->description = elgg_view('enlightn/fetched_media',array('entity'=> $oembed[0],'media_uid' => $media_uid));
				$file->save();
				break;
			}
			$embedUrl = new Embed_url(array('url' => $file->originalfilename));
			$embedUrl->embed();
			$file->description = elgg_view('enlightn/fetched_link',array('entity' => $embedUrl));
			$file->save();
			break;
		case ENLIGHTN_IMAGE:
			$file->description = elgg_view('enlightn/fetched_image',array('url'=> $file->originalfilename));
			$file->save();
			break;
		default:
			break;
	}
}


die($file->description);


require_once "../model/Embedly.php";
$api = new Embedly_API(array(
  'user_agent' => 'Mozilla/5.0 (compatible; embedly/example-app; support@embed.ly)'
));

//Some basic var
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