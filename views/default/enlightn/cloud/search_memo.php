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
    <ul id="saved-search-list">
    <?php
    foreach ($saved_search as $search) {
        $params = $search->getMetadata(ENLIGHTN_FILTER_CRITERIA);
        $params = unserialize($params);
        $params = json_encode($params);
        echo "<li data-params='" . $params . "' data-name='" . $search->title . "' data-guid='" . $search->guid . "'><span class='saved-items'>" . $search->title . "</span><span class='close'>&times;</span></li>";
    }
    ?>
    </ul>
</div>