<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");


//Some basic var
gatekeeper();
$user_guid 		= elgg_get_logged_in_user_guid();
$text 			= get_input('text','');
$tags           = tag_text($text);
echo json_encode($tags);