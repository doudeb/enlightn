<script language="javascript" type="text/javascript" src="<?php echo $vars['url']; ?>mod/tinymce/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<div id="discussion_list_container" style="border: 1px solid; padding: 3px">
<img src="<?php echo $vars['url'] ?>/mod/enlightn/media/graphics/loading.gif" alt="loading">
</div>
<script language="javascript">
javascript:$('#discussion_list_container').load('<?php echo $vars['url'] ?>/mod/enlightn/ajax/discussion_short.php');
</script>
<!-- Leftcontainer end -->
</div>