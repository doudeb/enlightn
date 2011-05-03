<script language="javascript">
$(document).ready(function() {
	$("a.popin-discussion").popin({
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
			loadContent('#discussion_list_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/discussion_short.php?discussion_type=1&discussion_id=' + discussion_id);

		}
	});
});
</script>
<a href="<?php echo $vars['url']; ?>/mod/enlightn/ajax/discussion_edit.php" class="popin-discussion"><?php echo elgg_echo('enlightn:newdiscussion');?></a>