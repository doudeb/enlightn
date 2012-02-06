<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$user_ent       = $vars['user_ent'];
$class          = $vars['class'];
$online_user    = find_active_users(300);
$is_online      = false;
foreach ($online_user as $key => $user) {
    if ($user_ent->guid === $user->guid) {
        $is_online = true;
        break;
    }
}
if ($is_online) {
   $class       .= ' online';
}
?>

<a href="<?php echo $vars['url']?>enlightn/profile/<?php echo $user_ent->username?>" target="_blank">
    <img class="<?php echo $class?>" src="<?php echo $user_ent->getIconURL()?>" title="<?php echo $user_ent->name?><?php echo $is_online?' / Online':''?>" />
</a>
