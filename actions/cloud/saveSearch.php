<?php
/**
 * Elgg collection add page
 *
 * @package Elgg
 * @subpackage Core
 */

$search_name                        = get_input('searchName');
$access_id                          = get_input('access_id',ENLIGHTN_ACCESS_PRIVATE);
$user_guid                          = elgg_get_logged_in_user_guid();

$last_search                        = $_SESSION['last_search_cloud'];

$saved_search                       = new ElggObject();
$saved_search->subtype              = ENLIGHTN_FILTER;
$saved_search->owner_guid           = $user_guid;
$saved_search->access_id            = $access_id;
$saved_search->title                = $search_name;
if (!$saved_search->save()) {
    exit(json_encode(false));
}

$saved_search->setMetaData(ENLIGHTN_FILTER_CRITERIA, $last_search);

echo json_encode($saved_search->guid);
exit();