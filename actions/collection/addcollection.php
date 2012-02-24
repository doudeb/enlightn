<?php
/**
 * Elgg collection add page
 *
 * @package Elgg
 * @subpackage Core
 */

$collection_name 		= get_input('listName');
$friends 				= get_input('userIds');
$owner_guid				= get_input('isPrivate')=='true'?elgg_get_logged_in_user_guid():'-1';

if (!$collection_name) {
	register_error(elgg_echo("friends:nocollectionname"));
	//forward(REFERER);
}

$id = create_access_collection($collection_name,$owner_guid);

if ($id) {
	$result = update_access_collection($id, $friends);
	if ($result) {
		echo json_encode(array('id'=>$id));
	}
}
exit();
