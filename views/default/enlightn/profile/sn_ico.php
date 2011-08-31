<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$settings       = $vars['settings'];
$needle         = $vars['needle'];

if(!is_array($settings)) {
    return false;
}

if(!isset ($settings[$needle]['value'])) {
    return false;
}
?>
<a href="<?php echo $settings[$needle]['value']?>" target="_blank"><img class="photo_linker" src="<?php echo $vars['url'] ?>mod/enlightn/media/graphics/linker/<?php echo $needle?>.png" title="<?php echo $needle?>" /></a>

