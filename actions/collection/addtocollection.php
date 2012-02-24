<?php
/**
 * Elgg collection add page
 *
 * @package Elgg
 * @subpackage Core
 */

$collection_id 			= get_input('listId');
$users_id 				= get_input('userIds');
$members                = array();
$members_of_collection  = get_members_of_access_collection($collection_id);
foreach ($members_of_collection as $key => $member) {
	$members[] = $member->guid;
}

$members = array_merge($members,$users_id);

if ($collection_id) {
	$result = update_access_collection($collection_id, $members);
	if ($result) {
		echo json_encode(array('id'=>$id));
	}
}
exit();
