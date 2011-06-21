<?php
$unreaded = sort_unreaded_for_nav($vars['discussion_unreaded']);
?>
<div id="vertical_tabbed_nav">
	<div class="box_wrapper">
		<ul id="list_selector">
			<li class="selected" id="discussion_selector_all"><a onclick="$('#unreaded_only').val(0);changeMessageList('#discussion_selector_all', 1);" href="#"><?php echo elgg_echo('PUBLIC'); ?></a><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_PU)?></li>
			<li id="discussion_selector_follow"><a onclick="$('#unreaded_only').val(0);changeMessageList('#discussion_selector_follow',2);" href="#"><?php echo elgg_echo('enlightn:follow'); ?></a><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_PR)?></li>
			<li id="discussion_selector_invited"><a onclick="$('#unreaded_only').val(0);changeMessageList('#discussion_selector_invited',5)" href="#"><?php echo elgg_echo('enlightn:membershiprequest'); ?></a><?php echo echo_unreaded($unreaded, ENLIGHTN_INVITED)?></li>
			<li id="discussion_selector_favorite"><a onclick="$('#unreaded_only').val(0);changeMessageList('#discussion_selector_favorite',3);" href="#"><?php echo elgg_echo('enlightn:favorite'); ?></a><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_FA)?></li>
			<li id="discussion_selector_search" style="display:none"><a onclick="$('#unreaded_only').val(0);changeMessageList('#discussion_selector_search',4)" href="#"><?php echo elgg_echo('enlightn:search'); ?></a></li>
		</ul>
	</div>
</div>
<input type="hidden" name="discussion_type" id="discussion_type" value="1">
<script language="javascript">
setInterval(function() {
	$.getJSON('<?php echo $vars['url']; ?>mod/enlightn/ajax/discussion_unreaded.php', function(data) {
		$.each(data, function(i,item){
			var received_value = '(' + item + ')';
			var nav_element = $("#nav_unreaded_" + i);
			if(typeof nav_element == 'object') {
				if (received_value != '(0)' && nav_element.html() != received_value) {
					nav_element.html(received_value);
				}
			}
		});
	});
}, 15000);

</script>