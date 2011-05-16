<script>
	function changeMessageList (currElement) {
		$(currElement).addClass('selected');
		$("#list_selector li").each(function () {
			if($(this).attr('id') != $(currElement).attr('id')) {
				$(this).removeClass('selected');
			}
      	});
	}
</script>

<div id="elgg_horizontal_tabbed_nav">
	<ul id="list_selector">
		<li class="selected" id="discussion_selector_all"><a onclick="javascript:changeMessageList('#discussion_selector_all'); loadContent('#discussion_list_container','<?php echo $vars['url']; ?>mod/enlightn/ajax/discussion_short.php?discussion_type=1');return false;" href="#"><?php echo elgg_echo('PUBLIC'); ?></a></li>
		<li id="discussion_selector_follow"><a onclick="javascript:changeMessageList('#discussion_selector_follow');loadContent('#discussion_list_container','<?php echo $vars['url']; ?>mod/enlightn/ajax/discussion_short.php?discussion_type=2'); return false;" href="#"><?php echo elgg_echo('enlightn:follow'); ?></a></li>
		<li id="discussion_selector_favorite"><a onclick="javascript:changeMessageList('#discussion_selector_favorite');loadContent('#discussion_list_container','<?php echo $vars['url']; ?>mod/enlightn/ajax/discussion_short.php?discussion_type=3'); return false;" href="#"><?php echo elgg_echo('enlightn:favorite'); ?></a></li>
		<li id="discussion_selector_search" style="display:none"><a onclick="javascript:changeMessageList('#discussion_selector_favorite');loadContent('#discussion_list_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/search.php?q=' + $('#searchInput').val() + '&date_begin=' + $('#date_begin').val() + '&date_end=' + $('#date_end').val() + '&from_users=' + $('#from_users').val()); return false;" href="#"><?php echo elgg_echo('enlightn:search'); ?></a></li>
	</ul>
</div>
<div id="discussion_list_container"></div>
<input type="submit" name="<?php echo elgg_echo("enlightn:seemore")?>" class="submit_button" id="see_more_discussion_list" value="<?php echo elgg_echo("enlightn:seemore")?>">
<input type="hidden" name="see_more_discussion_list_offset" id="see_more_discussion_list_offset" value="0">
<script language="javascript">
javascript:loadContent('#discussion_list_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/discussion_short.php?discussion_type=1&discussion_id=<?php echo $vars['discussion_id']?>');

$('#see_more_discussion_list').click(function () {
	$('#see_more_discussion_list_offset').val(parseInt($('#see_more_discussion_list_offset').val())+10);
	loadContent('#discussion_list_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/discussion_short.php?discussion_type=1&discussion_id=<?php echo $vars['discussion_id']?>&offset=' + $('#see_more_discussion_list_offset').val(),'append');
});

</script>
<!-- Leftcontainer end -->
</div>