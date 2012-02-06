<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");


gatekeeper();
$user_guid 			= elgg_get_logged_in_user_guid();
// get the entity from id
elgg_get_access_object()->set_ignore_access(true);
$limit 				= get_input('limit',10);
$topic 				= get_entity(get_input('discussion_id'));
$owner 				= get_entity($user_guid);
if (!$topic) forward();
foreach($topic->getAnnotations('', $limit, $offset, "desc") as $post) {
	$flag_readed = check_entity_relationship($user_guid, ENLIGHTN_READED,$post->id);
	if(!$flag_readed) {
		//add_entity_relationship($vars['user_guid'], ENLIGHTN_READED,$post->id);
	}
    echo elgg_view("enlightn/topicpost",array('entity' => $post
    											, 'flag_readed' => $flag_readed));
}
