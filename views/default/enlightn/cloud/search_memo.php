<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 */
$user_ent           = $vars['user_ent'];
$options            = array('types'=>'object','subtypes'=>ENLIGHTN_FILTER,'owner_guids'=>$user_ent->guid);
$saved_search       = elgg_get_entities($options);


?>
<div class="saved-search starred">
    <span><?php echo elgg_echo("enlightn:savedsearch")?></span><span class="star ico"></span>
    <?php echo elgg_view("enlightn/helper/saved_search_list", array('list'=>$saved_search))?>
</div>