<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

//Some basic var
gatekeeper();
global $enlightn;
$user_guid		= get_loggedin_userid();
$tags           = get_input('tags',false);
if ($tags)
    $tags           = explode(',',$tags);

$json_return    = false;

if (is_array($tags)) {
    $results = $enlightn->get_tags(false,$tags,false,5);
    foreach ($results as $key => $tag) {
        $user   = get_user($tag->owner_guid);
        $json_return[$tag->owner_guid] = $user->name;
    }
}

echo json_encode($json_return);