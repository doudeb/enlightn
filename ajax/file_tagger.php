<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");


//Some basic var
gatekeeper();
$user_guid 		= elgg_get_logged_in_user_guid();
if (isset($_FILES['upload']['name']) && !empty($_FILES['upload']['name'])) {
    $text       = doc_to_txt($_FILES['upload']['tmp_name'],$_FILES['upload']['type']);
}
$text 			= str_replace('&nbsp;',' ',$text);
$text 			= str_replace('<br>',' ',$text);
$text 			= strip_tags($text);
$tags           = tag_text($text);
echo json_encode($tags);