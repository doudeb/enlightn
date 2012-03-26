            <div class="tags">
                <span class="add">
                    <span class="ico"></span>
                    <span class="caption" id="add-tags"><?php echo elgg_echo("enlightn:tags") ?></span>
                    <span id="tags-input">&nbsp;<?php echo elgg_view("enlightn/helper/addtags",array(
                                                                    'placeholder' => elgg_echo('enlightn:search'),
                                                                    'name' => 'interests',
                                                                    'id' => 'interests',
                                                                    'container' => 'tags-result',
                                                                    'values' => 'tags'
                                                                    ));
                                                        echo elgg_view("input/hidden",array(
                                                        'name' => 'tags',
                                                        'id' => 'tags')); ?></span>
                </span>
                <div id="tags-result"></div>
            </div>
