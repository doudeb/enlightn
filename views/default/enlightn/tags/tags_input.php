            <div class="tags">
                <span class="add">
                    <span class="ico"></span>
                    <span class="caption" id="add-tags"><?php echo elgg_echo("enlightn:tags") ?></span>
                    <span id="tags-input">&nbsp;<?php echo elgg_view("input/tags",array(
                                                        'internalname' => 'interests',
                                                        'internalid' => 'interests',
                                                        'value' => $vars['entity']->interests,
                                                        ));
                                                        echo elgg_view("input/hidden",array(
                                                        'internalname' => 'tags',
                                                        'internalid' => 'tags')); ?></span>
                </span>
                <div id="tags-result"></div>
            </div>
