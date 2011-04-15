<script type="text/javascript" src="<?php echo $vars['url']; ?>/mod/enlightn/media/js/jquery.popin.js"></script>
<script language="javascript">
$(document).ready(function() {
	$("a.popin-discussion").popin({
		width:700,
		height:500,
		className: "mypopin3",
		loaderImg : '<?php echo $vars['url']; ?>/mod/enlightn/media/graphics/loading.gif',
		opacity: .6,
		onStart: function() {
			alert("Start")
		},
		onComplete: function() {
			alert("Complete")
		},
		onExit: function() {
			alert("Exit")
		}
	});
});
</script>
<a href="<?php echo $vars['url']; ?>/mod/enlightn/ajax/discussion_edit.php" class="popin-discussion">Nouvelle discussion</a>