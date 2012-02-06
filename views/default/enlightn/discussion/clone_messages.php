<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
            <div id="feed" class="detail">
                <ol id="clonedMessages"><?php echo $vars['cloned_content'] ?></ol>
                <?php echo elgg_view("input/hidden",array(
                                        'name' => 'cloned_ids',
                                        'id' => 'cloned_ids',
                                        'value' => false)); ?>
            </div>
