<?php
	/**
	 * Elgg groups plugin
	 * 
	 * @package ElggGroups
	 */

	// new groups default to open membership
	
?>
<div id="discussion_invite">
<form action="<?php echo $vars['url']; ?>action/enlightn/invite" enctype="multipart/form-data" method="post">
	<?php echo elgg_view('input/securitytoken'); ?>
	<label><?php echo elgg_echo("enlightn:to") ?></label>
		<?php echo elgg_view("enlightn/helper/adduser",array(
														'internalname' => 'invite',
														'internalid' => 'invite',
														'value' => $vars['entity']->invite,
														)); ?>
	<input type="hidden" name="discussion_guid" value="<?php echo $vars['entity']->getGUID(); ?>" />
	<input type="submit" class="submit_button" name ="<?php echo elgg_echo("enlightn:discussioninvite"); ?>" value="<?php echo elgg_echo("enlightn:discussioninvite"); ?>" />
</form>
</div>