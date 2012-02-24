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
$guid   		= get_input('guid');
$json_return            = false;


$user_ent               = get_entity($guid);
if ($user_ent instanceof ElggUser) {
    $json_return        = array('name'=>$user_ent->name);
}
echo json_encode($json_return);
exit();