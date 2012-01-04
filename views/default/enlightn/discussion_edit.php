    <div id="new-discussion">
        <form id="discussion_edit" action="<?php echo $vars['url']; ?>action/enlightn/edit" enctype="multipart/form-data" method="post">
            <?php echo elgg_view('input/securitytoken'); ?>
            <p><input class="title" type="text" name="title" id="title" placeholder="<?php echo elgg_echo("enlightn:title") ?>" value="" /></p>
            <div id="new-discussion-submission"></div>
            <?php echo elgg_view("input/longtext",array(
                                    'internalname' => 'description',
                                    'internalid' => 'description',
                                    'value' => $vars['entity']->description)); ?>
            <?php echo elgg_view("enlightn/discussion/clone_messages",array()); ?>
            <div class="privacy private">
                <span class="private-val value"><span class="ico"></span><?php echo elgg_echo('enlightn:buttonprivate') ?></span>

                <span class="cursor" id="privacy_cursor"></span>
                <span class="public-val value"><?php echo elgg_echo('enlightn:buttonpublic') ?></span>
                <?php echo elgg_view("input/hidden",array(
                                        'internalname' => 'membership',
                                        'internalid' => 'membership',
                                        'value' => ACCESS_PRIVATE)); ?>
            </div>
            <label><?php echo elgg_echo("enlightn:to") ?></label>
            <div class="dest">
                <?php echo elgg_view("enlightn/helper/adduser",array(
                                                                    'internalname' => 'invite',
                                                                    'placeholder' => elgg_echo("enlightn:to"),
                                                                    'internalid' => 'invite',
                                                                    'value' => $vars['entity']->invite,
                                                                    )); ?>
            </div>
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
            <div class="sending">
                <button type="reset" class="submit"><?php echo elgg_echo("enlightn:buttoncancel"); ?></button>
                <button type="submit" class="submit"><?php echo elgg_echo("enlightn:buttonpost"); ?></button>
            </div>
        </form>
    </div>