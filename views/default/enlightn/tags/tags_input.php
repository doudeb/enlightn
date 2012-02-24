            <div class="tags">
                <span class="add">
                    <span class="ico"></span>
                    <span class="caption" id="add-tags"><?php echo elgg_echo("enlightn:tags") ?></span>
                    <span id="tags-input">&nbsp;<?php echo elgg_view("input/tags",array(
                                                        'name' => 'interests',
                                                        'id' => 'interests',
                                                        'value' => $vars['entity']->interests,
                                                        ));
                                                        echo elgg_view("input/hidden",array(
                                                        'name' => 'tags',
                                                        'id' => 'tags')); ?></span>
                </span>
                <div id="tags-result"></div>
            </div>
