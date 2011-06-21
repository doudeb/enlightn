<?php
$is_follow		= check_entity_relationship($vars['user_guid'], ENLIGHTN_FOLLOW, $vars['entity']->guid);
$url 			= elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/follow?discussion_guid={$vars['entity']->guid}");
?>
<script language="javascript">
	$(document).ready(function(){
		$('#follow<?php echo $vars['entity']->guid?>').click( function(){
			loadContent("#follow_discussion<?php echo $vars['entity']->guid?>",'<?php echo $url ?>');
		});
	});
</script>
<div id="follow_discussion<?php echo $vars['entity']->guid?>">
	<div class="button" id="follow<?php echo $vars['entity']->guid?>"><strong><?php echo $is_follow?elgg_echo("enlightn:unfollow"):elgg_echo("enlightn:follow")?></strong></div>
</div>