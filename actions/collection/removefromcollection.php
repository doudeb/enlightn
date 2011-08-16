<?php
/**
 * Elgg collection add page
 *
 * @package Elgg
 * @subpackage Core
 */

$collection_id 			= get_input('listId');
$user_id 				= get_input('userId');

$members_of_collection  = get_members_of_access_collection($collection_id);
foreach ($members_of_collection as $key => $member) {
	if ($member->guid != $user_id) {
		$members[] = $member->guid;
	}
}

if ($collection_id) {
	$result = update_access_collection($collection_id, $members);
	if ($result) {
		echo json_encode(array('id'=>$id));
	}
}
exit();
