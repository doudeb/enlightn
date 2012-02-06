    <div id="new-discussion">
        <form id="discussion_edit" action="<?php echo $vars['url']; ?>action/enlightn/edit" enctype="multipart/form-data" method="post">
            <?php echo elgg_view('input/securitytoken'); ?>
            <p><input class="title" type="text" name="title" id="title" placeholder="<?php echo elgg_echo("enlightn:title") ?>" value="" /></p>
            <div id="new-discussion-submission"></div>
            <?php echo elgg_view("input/longtext",array(
                                    'name' => 'description',
                                    'id' => 'description',
                                    'value' => $vars['entity']->description)); ?>
            <?php echo elgg_view("enlightn/discussion/clone_messages",array()); ?>
            <div class="privacy private">
                <span class="private-val value"><span class="ico"></span><?php echo elgg_echo('enlightn:buttonprivate') ?></span>

                <span class="cursor" id="privacy_cursor"></span>
                <span class="public-val value"><?php echo elgg_echo('enlightn:buttonpublic') ?></span>
                <?php echo elgg_view("input/hidden",array(
                                        'name' => 'membership',
                                        'id' => 'membership',
                                        'value' => ACCESS_PRIVATE)); ?>
            </div>
            <label><?php echo elgg_echo("enlightn:to") ?></label>
            <div class="dest">
                <?php echo elgg_view("enlightn/helper/adduser",array(
                                                                    'name' => 'invite',
                                                                    'placeholder' => elgg_echo("enlightn:to"),
                                                                    'id' => 'invite',
                                                                    'value' => $vars['entity']->invite,
                                                                    )); ?>
                <div id="user_suggest"></div>
            </div>
            <?php echo elgg_view("enlightn/tags/tags_input",array());?>
            <div class="sending">
                <button type="reset" class="submit"><?php echo elgg_echo("enlightn:buttoncancel"); ?></button>
                <button type="submit" class="submit"><?php echo elgg_echo("enlightn:buttonpost"); ?></button>
            </div>
        </form>
    </div>