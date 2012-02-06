<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

gatekeeper();
$user_guid = elgg_get_logged_in_user_guid();
global $CONFIG;
$guid 		= get_input('guid');
disable_right($guid);
$file				= new ElggFile((int)$guid);
//is description already loaded
//var_dump($file->description , $file->originalfilename);
$to_fetch = $file->description === $file->originalfilename;
if ($to_fetch) {
    generate_preview($guid);
}
echo $file->description;