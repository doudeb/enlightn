<?php
/**
 * Elgg collection add page
 *
 * @package Elgg
 * @subpackage Core
 */

$guid               = get_input('guid');
$owner_guid         = elgg_get_logged_in_user_guid();

$search = get_entity($guid);
echo json_encode($search->disable());


exit();
