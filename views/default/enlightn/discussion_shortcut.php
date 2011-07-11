<?php
$unreaded = sort_unreaded_for_nav($vars['discussion_unreaded']);
?>
<div id="vertical_tabbed_nav">
	<div class="box_wrapper">
		<ul id="list_selector">
			<li class="selected" id="discussion_selector_<?php echo ENLIGHTN_ACCESS_PU?>"><a onclick="$('#unreaded_only').val(0);changeShortCutList(<?php echo ENLIGHTN_ACCESS_PU?>);return false;" href="#"><?php echo elgg_echo('PUBLIC'); ?></a><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_PU)?></li>
			<li id="discussion_selector_<?php echo ENLIGHTN_ACCESS_PR?>"><a onclick="$('#unreaded_only').val(0);changeShortCutList(<?php echo ENLIGHTN_ACCESS_PR?>);return false;" href="#"><?php echo elgg_echo('enlightn:follow'); ?></a><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_PR)?></li>
			<li id="discussion_selector_<?php echo ENLIGHTN_ACCESS_IN?>"><a onclick="$('#unreaded_only').val(0);changeShortCutList(<?php echo ENLIGHTN_ACCESS_IN?>);return false;" href="#"><?php echo elgg_echo('enlightn:membershiprequest'); ?></a><?php echo echo_unreaded($unreaded, ENLIGHTN_INVITED)?></li>
			<li id="discussion_selector_<?php echo ENLIGHTN_ACCESS_FA?>"><a onclick="$('#unreaded_only').val(0);changeShortCutList(<?php echo ENLIGHTN_ACCESS_FA?>);return false;" href="#"><?php echo elgg_echo('enlightn:favorite'); ?></a><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_FA)?></li>
			<li id="discussion_selector_<?php echo ENLIGHTN_ACCESS_AL?>"><a onclick="$('#unreaded_only').val(0);changeShortCutList(<?php echo ENLIGHTN_ACCESS_AL?>);return false;" href="#"><?php echo elgg_echo('enlightn:search'); ?></a></li>
		</ul>
	</div>
</div>
<input type="hidden" name="discussion_type" id="discussion_type" value="1">
<div id="shortcuted_messages"></div>
<script language="javascript">
setInterval(function() {
	$.getJSON('<?php echo $vars['url']; ?>mod/enlightn/ajax/discussion_unreaded.php', function(data) {
		$.each(data, function(i,item){
			var received_value = '(' + item + ')';
			var nav_element = $("#nav_unreaded_" + i);
			if(typeof nav_element == 'object') {
				if (received_value != '(0)' && nav_element.html() != received_value) {
					nav_element.html(received_value);
					//changeShortCutList(i);
				}
			}
		});
	});
}, 15000);

function changeShortCutList (accessLevel,offset) {
	toElement		= $('#shortcuted_messages');
	if (typeof accessLevel == 'undefined') {
		accessLevel = '';
	}
	if (typeof offset == 'undefined') {
		offset = '';
	}
	$.getJSON('<?php echo $vars['url']; ?>mod/enlightn/ajax/discussion_shortcut.php'
	,{
		offset: offset
		,access_level: accessLevel
	}
	,function(data) {
		var items = [];
		if (typeof toElement != 'undefined') {
			toElement.fadeOut();
			toElement.remove();
		}
		items.push('<a id="shortcuted_messages_previous">-</a>');
		$.each(data, function(i,item){
			if (item.readed) {
				classReaded = 'readed';
			} else {
				classReaded = 'unreaded';
			}
			if (i != 'access_level') {
				items.push('<li id="' + item.guid + '" class="' + classReaded + '"><a href="<?php echo $vars['url']; ?>pg/enlightn/discuss/' + item.guid +'">' + item.time_created + ' - ' +  item.title + '</li>');
			} else {
				accessLevel = item;
			}
		});
		currElement 	= $('#discussion_selector_' + accessLevel);
		items.push('<a id="shortcuted_messages_next">+</a>');
		$('<ul/>', {
			'id' : 'shortcuted_messages',
    		'class': 'shortcuted_messages',
    		html: items.join('')}).appendTo(currElement);
		$(currElement).addClass('selected');
		$("#list_selector li").each(function () {
			if($(this).attr('id') != $(currElement).attr('id')) {
				$(this).removeClass('selected');
			}
      	});
		$('#shortcuted_messages_next').click( function(){
			alert(offset);
			if (offset == '') {
				nextOffset = 10;
				changeShortCutList(accessLevel,nextOffset);
			} else if (parseInt(offset) >= 0) {
				nextOffset = parseInt(offset) + 10;
				changeShortCutList(accessLevel,nextOffset);
			}
		});
		$('#shortcuted_messages_previous').click( function(){
			alert(offset);
			if (parseInt(offset) > 0) {
				nextOffset = parseInt(offset) - 10;
				changeShortCutList(accessLevel,nextOffset);
			}
		});
	});
}
changeShortCutList();

</script>