<?php
/**
 * Elgg collection add page
 *
 * @package Elgg
 * @subpackage Core
 */

$search_name                        = get_input('searchName');
$is_private_access                  = get_input('isPrivate');
$is_label                           = get_input('isLabel');
$access_id                          = $is_private_access=='true'?ENLIGHTN_ACCESS_PRIVATE:ENLIGHTN_ACCESS_PUBLIC;
$user_guid                          = elgg_get_logged_in_user_guid();

$saved_search                       = new ElggObject();
$saved_search->subtype              = ENLIGHTN_FILTER;
$saved_search->owner_guid           = $user_guid;
$saved_search->access_id            = $access_id;
$saved_search->title                = $search_name;
if (!$saved_search->save()) {
    exit(json_encode(false));
}

$last_search                        = $is_label=='true'?serialize(array('subtype'=>'false')):$_SESSION['last_search_cloud'];
$saved_search->setMetaData(ENLIGHTN_FILTER_CRITERIA, $last_search);

echo json_encode($saved_search->guid);
exit();