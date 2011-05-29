<?php
$is_favorite 	= check_entity_relationship($vars['user_guid'], ENLIGHTN_FAVORITE,$vars['entity']->guid);
$url_favorite	= elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/favorite?discussion_guid={$vars['entity']->guid}");
echo elgg_echo("enlightn:addasfavorite");
?>
<img src="<?php echo $vars['url']; ?>/mod/enlightn/media/graphics/cleardot.gif" class="<?php echo $is_favorite?'favorite':'add_to_favorite'?>" id="favorite<?php echo $vars['entity']->id; ?>"/>
<div id="load_favorite<?php echo $vars['entity']->id; ?>"></div>
<script language="javascript">
$("#favorite<?php echo $vars['entity']->id; ?>").click( function(){
	if ($("#favorite<?php echo $vars['entity']->id; ?>").hasClass("favorite")) {
		loadContent('#load_favorite<?php echo $vars['entity']->id; ?>','<?php echo $url_favorite?>');
		$("#favorite<?php echo $vars['entity']->id; ?>").addClass("add_to_favorite");
		$("#favorite<?php echo $vars['entity']->id; ?>").removeClass("favorite");
	} else {
		loadContent('#load_favorite<?php echo $vars['entity']->id; ?>','<?php echo $url_favorite?>');
		$("#favorite<?php echo $vars['entity']->id; ?>").addClass("favorite");	
		$("#favorite<?php echo $vars['entity']->id; ?>").removeClass("add_to_favorite");	
	}
});
</script>