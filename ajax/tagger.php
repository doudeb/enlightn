<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");


//Some basic var
gatekeeper();
$user_guid 		= get_loggedin_userid();
$text 			= get_input('text','');
$text 			= str_replace('&nbsp;',' ',$text);
$text 			= str_replace('<br>',' ',$text);
$text 			= strip_tags($text);
$tags           = tag_text($text);
echo json_encode($tags);