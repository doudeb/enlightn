<?php
	/**
	 * Elgg groups plugin
	 * 
	 * @package ElggGroups
	 */

	// new groups default to open membership
	
?>

<form action="<?php echo $vars['url']; ?>action/enlightn/invite" enctype="multipart/form-data" method="post">
           
<div class="contentWrapper">

	<?php echo elgg_view('input/securitytoken'); ?>

	<p>
		<label>
			<?php echo elgg_echo("enlightn:to") ?><br />
			<?php echo elgg_view("enlightn/helper/adduser",array(
															'internalname' => 'invite',
															'value' => $vars['entity']->invite,
															)); ?>
		</label>
	</p>
	<p>
		<input type="hidden" name="discussion_guid" value="<?php echo $vars['entity']->getGUID(); ?>" />
		<input type="submit" class="submit_button" value="<?php echo elgg_echo("send"); ?>" />
	</p>
</div>
</form>