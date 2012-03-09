<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

//Some basic var
gatekeeper();
global $enlightn;
$user_guid		= elgg_get_logged_in_user_guid();
$tag_id   		= get_input('tag_id');
$json_return            = false;


$tag                   = get_metastring($tag_id);
if ($tag) {
    $json_return        = array('name'=>$tag);
}
echo json_encode($json_return);
exit();