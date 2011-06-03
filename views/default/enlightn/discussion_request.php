<?php if (count($vars['requests']) > 0) { ?><script language="javascript">
$(document).ready(function() {
	$("a.popin-request").popin({
		width:700,
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
<a href="<?php echo $vars['url']; ?>/mod/enlightn/ajax/invitations.php" class="popin-request">(<?php echo count($vars['requests']);?>)</a>
<?php } ?>