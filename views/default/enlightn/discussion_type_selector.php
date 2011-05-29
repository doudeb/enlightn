<div id="vertical_tabbed_nav">
	<div class="box_wrapper">
		<ul id="list_selector">
			<li class="selected" id="discussion_selector_all"><a onclick="javascript:changeMessageList('#discussion_selector_all', 1);" href="#"><?php echo elgg_echo('PUBLIC'); ?></a></li>
			<li id="discussion_selector_follow"><a onclick="javascript:changeMessageList('#discussion_selector_follow',2);" href="#"><?php echo elgg_echo('enlightn:follow'); ?></a></li>
			<li id="discussion_selector_favorite"><a onclick="javascript:changeMessageList('#discussion_selector_favorite',3);" href="#"><?php echo elgg_echo('enlightn:favorite'); ?></a></li>
			<li id="discussion_selector_search" style="display:none"><a onclick="javascript:changeMessageList('#discussion_selector_search',4)" href="#"><?php echo elgg_echo('enlightn:search'); ?></a></li>
		</ul>
	</div>
</div>
<input type="hidden" name="discussion_type" id="discussion_type" value="1">