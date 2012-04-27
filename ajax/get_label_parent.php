<?php

include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

//Some basic var
gatekeeper();
global $enlightn,$CONFIG;
$user_ent           = elgg_get_logged_in_user_entity();
$guid               = get_input('guid');
$json_return        = false;


if ($guid) {
    disable_right($guid);
    $label_ent      = get_entity($guid);
    $json_return    = get_label_parents ($label_ent);
}
echo json_encode($json_return);
exit();