<input type="text" id="<?php echo $vars['internalname']; ?>" name="<?php echo $vars['internalname']; ?>">
<script type="text/javascript">
	$(document).ready(function() {
		$("#<?php echo $vars['internalname']; ?>").tokenInput("<?php echo $vars['url']; ?>mod/enlightn/ajax/members.php");
	});
</script>