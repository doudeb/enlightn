<div id="left_container" style="border: 1px solid; width: 38%;float:left;">
<div id="activity_container" style="border: 1px solid; padding: 3px">
<img src="<?php echo $vars['url'] ?>/mod/enlightn/media/graphics/loading.gif" alt="loading">
</div>
<script language="javascript">
javascript:$('#activity_container').load('<?php echo $vars['url'] ?>/mod/enlightn/ajax/activity.php');
</script>