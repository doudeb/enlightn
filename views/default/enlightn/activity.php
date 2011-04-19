<script type="text/javascript" src="<?php echo $vars['url']; ?>/mod/enlightn/media/js/jquery.popin.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $vars['url']; ?>mod/tinymce/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript">
function loadContent (divId,dataTo) {
	javascript:$(divId).prepend('<img src="<?php echo $vars['url'] ?>/mod/enlightn/media/graphics/loading.gif" alt="loading">');
	javascript:$(divId).load(dataTo);
}
</script>

<div id="left_container" style="border: 1px solid; width: 38%;float:left;">
<div id="activity_container" style="border: 1px solid; padding: 3px">
</div>
<script language="javascript">
javascript:loadContent('#activity_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/activity.php');
</script>