<?php
$is_follow		= check_entity_relationship($vars['user_guid'], ENLIGHTN_FOLLOW, $vars['entity']->guid);
$is_invited		= check_entity_relationship($vars['entity']->guid, ENLIGHTN_INVITED,$vars['user_guid']);
$url 			= elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/follow?guid={$vars['entity']->guid}");
$user_guid      = elgg_get_logged_in_user_guid();
$ent            = get_entity($vars['entity']->guid);
?>
<script language="javascript">
	$(document).ready(function(){
		$('#follow<?php echo $vars['entity']->guid?>').click( function(){
			loadContent("#loader",'<?php echo $url ?>');
			$(this).toggleClass("unfollow");
            $('input[name="lastModified"]').val('');
		});
		$('#ignore<?php echo $vars['entity']->guid?>').click( function(){
			loadContent("#loader",'<?php echo $url ?>&ignore=1');
			$(this).toggle();
            $('input[name="lastModified"]').val('');
		});
		$('#disable').click( function(){
			var url = '/action/enlightn/removeObject?__elgg_ts=' + elgg.security.token.__elgg_ts + '&__elgg_token=' + elgg.security.token.__elgg_token
				, guid = $(this).attr('data-guid');
			if (guid) {
				if(confirm("<?php echo elgg_echo('enlightn:prompt:disableentity')?>")) {
					$.post(url, {guid: guid}, function(result) {
						if(result) {
							$(location).attr('href','<?php echo $vars['url'] ?>enlightn/');
					    }
					},'json');
				}
			}
		});		
	});
</script>
<?php if ($is_follow && in_array(elgg_get_context(), array('discuss'))) {?>
<span class="discussion-action">
    <span class="discussion-action-val"></span>
    <span class="ico"></span>
    <ul class="discussion-action-menu">
        <li id="forwardAction"><?php echo elgg_echo("enlightn:forward")?></li>
        <!-- <li id="markAsUnreadAction"><?php echo elgg_echo("enlightn:removeasread")?></li>-->
        <?php if ($ent->owner_guid==$user_guid || elgg_is_admin_logged_in()) {?>
        <li id="disable" data-guid="<?php echo $vars['entity']->guid ?>"><?php echo elgg_echo('enlightn:discussionremove')?></li>
        <?php } ?>
    </ul>
</span>
<?php } ?>
<span class="follow<?php echo $is_follow?' unfollow':' '?>" id="follow<?php echo $vars['entity']->guid?>">
    <span class="ico"></span>
    <span class="follow-val"><?php echo elgg_echo("enlightn:buttonfollow"); ?></span>
    <span class="unfollow-val"><?php echo elgg_echo("enlightn:buttonunfollow"); ?></span>
    <span class="followed-val"><?php echo elgg_echo("enlightn:bunttonfollowed"); ?></span>
</span>
<?php
if ($is_invited && in_array(elgg_get_context(), array(ENLIGHTN_INVITED,'discuss'))) {?>
<span class="follow ignore" id="ignore<?php echo $vars['entity']->guid?>">
    <span class="ico"></span>
    <span class="unfollow-val"><?php echo elgg_echo("enlightn:buttonignore")?></span>
</span>
<?php
}