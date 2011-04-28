<script language="javascript">
function loadContent (divId,dataTo) {
	javascript:$(divId).prepend('<img src="<?php echo $vars['url'] ?>/mod/enlightn/media/graphics/loading.gif" alt="loading">');
	javascript:$(divId).load(dataTo);
}
</script>
<div id="left_container">
	<div id="activity_container"></div>
	<script language="javascript">
	javascript:loadContent('#activity_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/activity.php');
	</script>