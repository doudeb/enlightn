<div id="elgg_horizontal_tabbed_nav">
	<ul>
		<li class="selected" id="discussion_selector_all"><a onclick="javascript:loadContent('#discussion_list_container','<?php echo $vars['url']; ?>mod/enlightn/ajax/discussion_short.php?discussion_type=1'); $('#discussion_selector_follow').removeClass('selected'); $('#discussion_selector_all').addClass('selected'); return false;" href="?display="><?php echo elgg_echo('PUBLIC'); ?></a></li>
		<li id="discussion_selector_follow"><a onclick="javascript:loadContent('#discussion_list_container','<?php echo $vars['url']; ?>mod/enlightn/ajax/discussion_short.php?discussion_type=2'); $('#discussion_selector_all').removeClass('selected'); $('#discussion_selector_follow').addClass('selected'); return false;" href="?display=friends"><?php echo elgg_echo('enlightn:follow'); ?></a></li>
	</ul>
</div>
<div id="discussion_list_container"></div>
<script language="javascript">
javascript:loadContent('#discussion_list_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/discussion_short.php?discussion_type=1');
</script>
<!-- Leftcontainer end -->
</div>