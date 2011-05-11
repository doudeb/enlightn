<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

//Some basic var
gatekeeper();
$user_guid = get_loggedin_userid();

$url = get_input('url');

