<?php
$is_follow		= check_entity_relationship($vars['user_guid'], ENLIGHTN_FOLLOW, $vars['entity']->guid);
$is_invited		= check_entity_relationship($vars['entity']->guid, ENLIGHTN_INVITED,$vars['user_guid']);

$url 			= elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/follow?discussion_guid={$vars['entity']->guid}");
?>
<script language="javascript">
	$(document).ready(function(){
		$('#follow<?php echo $vars['entity']->guid?>').click( function(){
			loadContent("#loader",'<?php echo $url ?>');
			if ($(this).hasClass("unfollow")) {
				$(this).removeClass("unfollow");
			} else {
				$(this).addClass("unfollow");
			}
		});
		$('#ignore<?php echo $vars['entity']->guid?>').click( function(){
			loadContent("#loader",'<?php echo $url ?>&ignore=1');
			if ($(this).parent().parent().hasClass("followed")) {
				$(this).parent().parent().removeClass("followed");
			} else {
				$(this).parent().parent().addClass("followed");
			}
		});
	});
</script>
<span class="follow<?php echo $is_follow?' unfollow':' '?>" id="follow<?php echo $vars['entity']->guid?>">
    <span class="ico"></span>
    <span class="follow-val"><?php echo elgg_echo("enlightn:buttonfollow"); ?></span>
    <span class="unfollow-val"><?php echo elgg_echo("enlightn:buttonunfollow"); ?></span>
    <span class="followed-val"><?php echo elgg_echo("enlightn:bunttonfollowed"); ?></span>
</span>
<?php
if ($is_invited) {?>
<span class="follow ignore" id="ignore<?php echo $vars['entity']->guid?>">
    <span class="ico"></span>
    <span class="unfollow-val"><?php echo elgg_echo("enlightn:buttonignore")?></span>
</span>
<?php
}
