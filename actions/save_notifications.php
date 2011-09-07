<?php

/**
 * Elgg notifications
 *
 * @package ElggNotifications
 */

$user = get_loggedin_user();

set_user_notification_setting($user->guid,NOTIFICATION_EMAIL_INVITE , (get_input(NOTIFICATION_EMAIL_INVITE) == '1') ? true : false);
set_user_notification_setting($user->guid,NOTIFICATION_EMAIL_MESSAGE_FOLLOWED , (get_input(NOTIFICATION_EMAIL_MESSAGE_FOLLOWED) == '1') ? true : false);
//remove_entity_relationships($user->guid, 'notify' . $method, false, 'user');


system_message(elgg_echo('notifications:subscriptions:success'));

forward($_SERVER['HTTP_REFERER']);
