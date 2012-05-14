<?php
session_start();

$form = $_GET['form'];
var_dump($_SESSION);
$progress = 100;

$key = ini_get("session.upload_progress.prefix") . $form;
if (!empty($_SESSION[$key])) {
	    $current    = $_SESSION[$key]["bytes_processed"];
        $total      = $_SESSION[$key]["content_length"];
	    $progress   = $current < $total ? ceil($current / $total * 100) : 100;
}

echo json_encode($_SESSION);