<?php
	/**
	 * Elgg groups plugin
	 * 
	 * @package ElggGroups
	 */

	// new groups default to open membership
	
?>

<form action="<?php echo $vars['url']; ?>action/enlightn/edit" enctype="multipart/form-data" method="post">
           
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
		<label>
			<?php echo elgg_echo("groups:name") ?><br />
			<?php echo elgg_view("input/text",array(
															'internalname' => 'name',
															'value' => $vars['entity']->name,
															)); ?>
		</label>
	</p>
	<p>
		<label>
			<?php echo elgg_echo("groups:description") ?><br />
			<?php echo elgg_view("input/longtext",array(
															'internalname' => 'description',
															'value' => $vars['entity']->description,
															)); ?>
		</label>
	</p>
	<p>
		<label>
			<?php echo elgg_echo("groups:interests") ?><br />
			<?php echo elgg_view("input/tags",array(
															'internalname' => 'interests',
															'value' => $vars['entity']->interests,
															)); ?>
		</label>
	</p>

	<p>
		<label>
			<?php echo elgg_echo('groups:visibility'); ?><br />
			<?php 
			
			$this_owner = $vars['entity']->owner_guid;
			if (!$this_owner) {
				$this_owner = get_loggedin_userid();
			}
			
			$access = array(ACCESS_FRIENDS => elgg_echo("access:friends:label"), ACCESS_LOGGED_IN => elgg_echo("LOGGED_IN"), ACCESS_PUBLIC => elgg_echo("PUBLIC"), ACCESS_PRIVATE => elgg_echo("PRIVATE"));
			$collections = get_user_access_collections($vars['entity']->guid);
			if (is_array($collections)) {
				foreach ($collections as $c)
					$access[$c->id] = $c->name;
			}

			$current_access = ($vars['entity']->access_id ? $vars['entity']->access_id : ACCESS_PUBLIC);
			echo elgg_view('input/access', array('internalname' => 'membership', 
												'value' =>  $current_access,
												'options' => $access));
			
			
			?>
		</label>
	</p>
	<p>
		<?php
			if ($vars['entity'])
			{ 
		?>
		<input type="hidden" name="group_guid" value="<?php echo $vars['entity']->getGUID(); ?>" />
		<?php
			}
		?>
		<input type="submit" class="submit_button" value="<?php echo elgg_echo("save"); ?>" />
		
	</p>

</form>
</div>

<?php
if ($vars['entity']) {
?>
<div class="contentWrapper">
<div id="delete_group_option">
	<form action="<?php echo $vars['url'] . "action/groups/delete"; ?>">
		<?php
			echo elgg_view('input/securitytoken');
				$warning = elgg_echo("groups:deletewarning");
			?>
			<input type="hidden" name="group_guid" value="<?php echo $vars['entity']->getGUID(); ?>" />
			<input type="submit" name="delete" value="<?php echo elgg_echo('groups:delete'); ?>" onclick="javascript:return confirm('<?php echo $warning; ?>')"/>
	</form>
</div><div class="clearfloat"></div>
</div>
<?php
}
?>