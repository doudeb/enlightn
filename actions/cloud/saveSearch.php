<?php
/**
 * Elgg collection add page
 *
 * @package Elgg
 * @subpackage Core
 */

$search_name        = get_input('searchName');
$owner_guid         = elgg_get_logged_in_user_guid();

$last_search        = $_SESSION['last_search_cloud'];
$last_search        = unserialize($last_search);



$saved_search       = get_private_setting($owner_guid, 'search_cloud');
$saved_search       = unserialize($saved_search);

$saved_search[$search_name] = $last_search;
$saved_search       = serialize($saved_search);

$result             = set_private_setting($owner_guid,'search_cloud',$saved_search);
if ($result) {
    echo json_encode($last_search);
} else {
    echo json_encode(false);
}
exit();
