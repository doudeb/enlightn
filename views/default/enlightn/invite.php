<script>
$(document).ready(function() {
	$("a.popin-discussion-invite").popin({
		width:800,
		height:500,
		className: "mypopin3",
		loaderImg : '<?php echo $vars['url']; ?>/mod/enlightn/media/graphics/loading.gif',
		opacity: .6,
		onStart: function() {

		},
		onComplete: function() {

		},
		onExit: function() {

		}
	});
});

</script>
<?php
$url_invite		= elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/invite?discussion_guid={$vars['entity']->guid}");
 
$is_owner		= $vars['user_guid'] == $vars['entity']->owner_guid; 
if ($is_owner) { ?>
<a href="<?php echo $vars['url']; ?>/mod/enlightn/ajax/discussion_invite.php?discussion_guid=<?php echo $vars['entity']->guid ?>" class="popin-discussion-invite"><?php echo elgg_echo('enlightn:discussioninvite');?></a>
<?php } ?>