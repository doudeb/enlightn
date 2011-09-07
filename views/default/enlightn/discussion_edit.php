<?php
	/**
	 * Elgg groups plugin
	 *
	 * @package ElggGroups
	 */

	// new groups default to open membership

?>
    <div class="new-post">
        <form id="discussion_edit" action="<?php echo $vars['url']; ?>action/enlightn/edit" enctype="multipart/form-data" method="post">
            <span id="close_new_discussion" class="mini-close"/><h2>&times;</h2></span>
            <?php echo elgg_view('input/securitytoken'); ?>
            <div class="privacy private">
                <span class="private-val value"><span class="ico"></span><?php echo elgg_echo('private') ?></span>

                <span class="cursor" id="privacy_cursor"></span>
                <span class="public-val value"><?php echo elgg_echo('public') ?></span>
                <?php echo elgg_view("input/hidden",array(
                                        'internalname' => 'membership',
                                        'internalid' => 'membership',
                                        'value' => ACCESS_PRIVATE)); ?>
            </div>
            <input class="title" type="text" name="title" id="title" placeholder="<?php echo elgg_echo("enlightn:title") ?>" value="" />
            <?php echo elgg_view("input/longtext",array(
                                    'internalname' => 'description',
                                    'internalid' => 'description',
                                    'value' => $vars['entity']->description)); ?>
            <div class="dest">
                <label><?php echo elgg_echo("enlightn:to") ?> :</label>
                <?php echo elgg_view("enlightn/helper/adduser",array(
                                                                    'internalname' => 'invite',
                                                                    'internalid' => 'invite',
                                                                    'value' => $vars['entity']->invite,
                                                                    )); ?>
            </div>
            <div class="tags">
                <span class="add">
                    <span class="ico"></span>
                    <span class="caption"><?php echo elgg_echo("enlightn:tags") ?></span>
                    <?php echo elgg_view("input/tags",array(
                                                        'internalname' => 'interests',
                                                        'internalid' => 'interests',
                                                        'value' => $vars['entity']->interests,
                                                        )); ?>
                </span>
            </div>
            <div class="sending">

                <button type="submit" class="submit"><?php echo elgg_echo("enlightn:post"); ?></button>
            </div>
            <div id="submission"></div>
        </form>
    </div>