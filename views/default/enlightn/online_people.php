<div class="box_wrapper">
	<?php echo elgg_echo('admin:statistics:label:onlineusers'); ?>
	<div id="online_people"></div>
</div>
<script language="javascript">
loadContent('#online_people','<?php echo $vars['url'] ?>/mod/enlightn/ajax/online_people.php');
</script>