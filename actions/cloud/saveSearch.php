<?php
global $CONFIG;
$search_name                        = get_input('searchName');
$is_private_access                  = get_input('isPrivate');
$is_label                           = get_input('isLabel');
$parent_guid                        = get_input('parentId',0);
$userto                             = get_input('invite_users');
$userto                             = parse_user_to($userto);
$access_id                          = $is_private_access=='true'?ENLIGHTN_ACCESS_PRIVATE:ENLIGHTN_ACCESS_PUBLIC;
$user_guid                          = elgg_get_logged_in_user_guid();

if(strstr($search_name, 'tag_')) {
    $search_name = get_metastring((int)str_replace('tag_', '', $search_name));
} else {

}

$saved_search                       = new ElggObject();
$saved_search->subtype              = ENLIGHTN_FILTER;
$saved_search->owner_guid           = $user_guid;
$saved_search->access_id            = $access_id;
$saved_search->title                = $search_name;
$saved_search->tags                 = $saved_search->title;
$saved_search->container_guid       = $CONFIG->site_guid;
if((int)$parent_guid > 0) {
    $saved_search->container_guid   = $parent_guid;
}
$guid                               = $saved_search->save();
if (!$guid) {
    exit(json_encode(false));
}

//Add user to follower of this entry
add_entity_relationship($user_guid, ENLIGHTN_FOLLOW, $guid);
//Invite users
if (is_array($userto)) {
    add_folowers($userto, $saved_search);
}

$last_search                        = $is_label=='true'?serialize(array('subtype'=>'false')):$_SESSION['last_search_cloud'];
$saved_search->setMetaData(ENLIGHTN_FILTER_CRITERIA, $last_search);

echo json_encode(unserialize($last_search));
exit();