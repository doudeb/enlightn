<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
gatekeeper();
global $CONFIG;
$user_guid              = elgg_get_logged_in_user_guid();
$current_settings       = get_profile_settings($user_guid);

foreach ($current_settings as $key => $value) {
    $new_value = get_input($key);
    if($new_value && !empty($new_value) && $value != $new_value) {
        create_metadata($user_guid, $key, $new_value, $value_type, $user_guid, ENLIGHTN_ACCESS_PUBLIC);
    }
}

forward($CONFIG->url . 'enlightn/settings/profile');
?>