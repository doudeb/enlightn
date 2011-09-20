<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$user_ent   = $vars['user_ent'];
$class      = $vars['class'];
?>
<a href="<?php echo $vars['url']?>pg/enlightn/profile/<?php echo $user_ent->username?>" target="_blank"><img class="<?php echo $class?>" src="<?php echo $user_ent->getIcon()?>" /></a>
