<div id="discussion_list_container"></div>
<input type="submit" name="<?php echo elgg_echo("enlightn:seemore")?>" class="submit_button" id="see_more_discussion_list" value="<?php echo elgg_echo("enlightn:seemore")?>">
<input type="hidden" name="see_more_discussion_list_offset" id="see_more_discussion_list_offset" value="0">

<script language="javascript">
changeMessageList('#discussion_selector_all', 1);

$('#see_more_discussion_list').click(function () {
	$('#see_more_discussion_list_offset').val(parseInt($('#see_more_discussion_list_offset').val())+10);
	loadContent('#discussion_list_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/search.php'  + get_search_criteria(),'append');
});

</script>
<!-- Leftcontainer end -->
</div>