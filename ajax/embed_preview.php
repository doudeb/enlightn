<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

gatekeeper();
$user_guid = get_loggedin_userid();
global $CONFIG;
$guid 		= get_input('guid');
disable_right($guid);

//is description already loaded
$to_fetch = $file->description === $file->originalfilename;
if ($to_fetch) {
    generate_preview($guid);
}
$file				= new ElggFile((int)$guid);
echo $file->description;