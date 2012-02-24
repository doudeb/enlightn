<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 */
$user_ent           = $vars['user_ent'];
$saved_search       = get_private_setting($user_ent->guid, 'search_cloud');
$saved_search       = unserialize($saved_search);


?>
<div class="saved-search starred">
    <span><?php echo elgg_echo("enlightn:savedsearch")?></span><span class="star ico"></span>
    <ul id="saved-search-list">
    <?php
    foreach ($saved_search as $search_name => $value) {
        $params = json_encode($value);
        echo "<li data-params='" . $params . "' data-name='" . $search_name . "'><span class='saved-items'>" . $search_name . "</span><span class='close'>&times;</span></li>";
    }
    ?>
    </ul>
</div>