<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");


gatekeeper();
$discussion_options = array();
$discussion_options['types'] = "object";
$discussion_options['subtypes'] = "enlightndiscussion";

$discussion_items = elgg_get_entities($discussion_options);
foreach ($discussion_items as $key => $topic) {
    echo  elgg_view("enlightn/discussion_short", array('entity' => $topic, 'current' => $key===0?true:false));
}