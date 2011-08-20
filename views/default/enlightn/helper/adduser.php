<?php
$unique_id = md5($vars['internalname'] . time());
?>

<input type="text" id="<?php echo $unique_id; ?>" name="<?php echo $vars['internalname']; ?>">
<script type="text/javascript">
	$(document).ready(function() {
		$("#<?php echo $unique_id; ?>").tokenInput("<?php echo $vars['url']; ?>mod/enlightn/ajax/members.php");
	});
</script>