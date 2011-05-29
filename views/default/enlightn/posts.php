<div id="posts_container"></div>
<script>
loadContent('#posts_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/discussion.php?discussion_id=<?php echo $vars['entity']->guid?>');
</script>