<script>
	function changeMessageList (currElement, discussion_type) {
		if(discussion_type == undefined) {
			discussion_type = 1;
		}
		$('#discussion_type').val(discussion_type);
		$('#see_more_discussion_list_offset').val(0);
		loadContent('#discussion_list_container','<?php echo $vars['url']; ?>mod/enlightn/ajax/search.php' + get_search_criteria());		
		$(currElement).addClass('selected');
		$("#list_selector li").each(function () {
			if($(this).attr('id') != $(currElement).attr('id')) {
				$(this).removeClass('selected');
			}
      	});
      	return false;
	}
</script>

<div id="elgg_horizontal_tabbed_nav">
	<ul id="list_selector">
		<li class="selected" id="discussion_selector_all"><a onclick="javascript:changeMessageList('#discussion_selector_all', 1);" href="#"><?php echo elgg_echo('PUBLIC'); ?></a></li>
		<li id="discussion_selector_follow"><a onclick="javascript:changeMessageList('#discussion_selector_follow',2);" href="#"><?php echo elgg_echo('enlightn:follow'); ?></a></li>
		<li id="discussion_selector_favorite"><a onclick="javascript:changeMessageList('#discussion_selector_favorite',3);" href="#"><?php echo elgg_echo('enlightn:favorite'); ?></a></li>
		<li id="discussion_selector_search" style="display:none"><a onclick="javascript:changeMessageList('#discussion_selector_search',4)" href="#"><?php echo elgg_echo('enlightn:search'); ?></a></li>
	</ul>
</div>
<div id="discussion_list_container"></div>
<input type="submit" name="<?php echo elgg_echo("enlightn:seemore")?>" class="submit_button" id="see_more_discussion_list" value="<?php echo elgg_echo("enlightn:seemore")?>">
<input type="hidden" name="see_more_discussion_list_offset" id="see_more_discussion_list_offset" value="0">
<input type="hidden" name="discussion_type" id="discussion_type" value="0">
<script language="javascript">
loadContent('#discussion_list_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/search.php?discussion_type=1');

$('#see_more_discussion_list').click(function () {
	$('#see_more_discussion_list_offset').val(parseInt($('#see_more_discussion_list_offset').val())+10);
	loadContent('#discussion_list_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/search.php'  + get_search_criteria(),'append');
});

</script>
<!-- Leftcontainer end -->
</div>