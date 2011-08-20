<?php
$is_follow		= check_entity_relationship($vars['user_guid'], ENLIGHTN_FOLLOW, $vars['entity']->guid);
$url 			= elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/follow?discussion_guid={$vars['entity']->guid}");
?>
<script language="javascript">
	$(document).ready(function(){
		$('#follow<?php echo $vars['entity']->guid?>').click( function(){
			loadContent("#loader",'<?php echo $url ?>');
			if ($(this).parent().parent().hasClass("followed")) {
				$(this).parent().parent().removeClass("followed");
			} else {
				$(this).parent().parent().addClass("followed");
			}
		});
	});
</script>
<span class="follow" id="follow<?php echo $vars['entity']->guid?>">
    <span class="ico"></span> <?php echo $is_follow?elgg_echo("enlightn:buttonunfollow"):elgg_echo("enlightn:buttonfollow")?>
</span>