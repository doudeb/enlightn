<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");


//Some basic var
gatekeeper();
$user_guid = elgg_get_logged_in_user_guid();

$users_online = get_online_users();
echo $users_online;