<ol id="cloud_content"></ol>
<script>
var internal_id = '<?php echo $vars['internal_id']?>';
loadContent('#cloud_content','<?php echo $vars['url']; ?>mod/enlightn/ajax/get_my_cloud.php?' + get_search_criteria() + '&context=<?php echo elgg_get_context()?>');
</script>
