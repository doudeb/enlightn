<?php
$is_owner			= $vars['user_guid'] == $vars['entity']->owner_guid;
if ($is_owner) {
	$url_invite		= elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/invite?guid={$vars['entity']->guid}");?>
<div id="discussion_invite">
	<?php echo elgg_echo('enlightn:discussioninvite');?>
	<?php echo elgg_view("enlightn/helper/adduser",array(
													'internalname' => 'invite')); ?>
	<input type="submit" class="submit_button" value="<?php echo elgg_echo("send"); ?>" id="invite_button"/>
	<div id="invite_submission"></div>
</div>
<?php } ?>
<script>
$("#invite_button").click( function(){
	loadContent('#invite_submission','<?php echo $url_invite?>&invite='+$('#invite').val());
});
</script>
