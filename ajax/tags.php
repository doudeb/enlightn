<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");


//Some basic var
gatekeeper();
global $enlightn;
$user_guid = elgg_get_logged_in_user_guid();

/**
 * @todo set it to cache
 */
$tag = get_input('q');
$i = -1;

$tags_found = false;
$tags_found[++$i]['id'] 	= $tag;
$tags_found[$i]['group'] 	= 'Free text';
$tags_found[$i]['name'] 	= $tag;
$tags_found[$i]['count']        = '';


$results = $enlightn->get_tags(false, $tag, false, 3);
foreach ($results as $tag_found) {
    $tags_found[++$i]['id'] 	= 'tag_' . $tag_found->tag_id;
    $tags_found[$i]['group'] 	= 'Most used tags';
    $tags_found[$i]['name'] 	= $tag_found->tag;
    $tags_found[$i]['count']    = $tag_found->total;
}

echo json_encode($tags_found);