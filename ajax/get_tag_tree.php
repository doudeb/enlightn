<?php

include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

//Some basic var
gatekeeper();
global $enlightn,$CONFIG;
$user_ent           = elgg_get_logged_in_user_entity();
$mode               = get_input('mode');
$parent_guid        = get_input('parentId')=='false'?false:get_input('parentId');
$json_return        = false;


$labeltree            = get_labels ($mode,$parent_guid);

if ($labeltree) {
    foreach ($labeltree as $key=>$label) {
        disable_right($label->container_guid);
        $parent_ent = get_entity($label->container_guid);
        $is_followed_parent = check_entity_relationship($user_ent->guid, ENLIGHTN_FOLLOW, $label->container_guid);
        if (($parent_ent instanceof ElggObject && $parent_guid) //asking for childs
             || (!$parent_guid && ($label->container_guid == $CONFIG->site_guid
                                    || (!$is_followed_parent && $mode != 'suggest')
                                    || ($mode = 'invited')
                                    )
                 )
            ) { //child not following parents
            $params = $label->getMetadata(ENLIGHTN_FILTER_CRITERIA);
            $params = unserialize($params);
            $params = json_encode($params);
            $children_ent = get_labels($mode,$label->guid);
            $container_guid = $label->container_guid;
            $is_followed = check_entity_relationship($user_ent->guid, ENLIGHTN_FOLLOW, $label->guid);
            $is_followed = isset($is_followed->id);
            $is_shared = get_entity_relationships($label->guid,true);
            $is_shared = $label->access_id==ENLIGHTN_ACCESS_PUBLIC;
            $json_return[$key] = array('guid'=>$label->guid
                                        ,'title'=>$label->title
                                        ,'owner_guid'=>$label->owner_guid
                                        ,'parent_guid'=>$container_guid
                                        ,'hasChildren'=>count($children_ent)>0
                                        ,'isFollowed'=>$is_followed
                                        ,'isShared'=>$is_shared
                                        ,'params'=>$params);
        }
    }
}
echo json_encode($json_return);
exit();