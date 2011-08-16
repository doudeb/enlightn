<?php
$unreaded = sort_unreaded_for_nav($vars['discussion_unreaded']);
?>
			<ol class="folders" id="list_selector">
				<li class="current" id="discussion_selector_<?php echo ENLIGHTN_ACCESS_PU?>"><span class="arrow"></span><a class="cat" onclick="$('#unreaded_only').val(0);changeShortCutList(<?php echo ENLIGHTN_ACCESS_PU?>);return false;" href="#"><?php echo elgg_echo('PUBLIC'); ?><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_PU)?></a></li>
				<li id="discussion_selector_<?php echo ENLIGHTN_ACCESS_PR?>"><span class="arrow"></span><a class="cat" onclick="$('#unreaded_only').val(0);changeShortCutList(<?php echo ENLIGHTN_ACCESS_PR?>);return false;" href="#"><?php echo elgg_echo('enlightn:follow'); ?><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_PR)?></a></li>
				<li id="discussion_selector_<?php echo ENLIGHTN_ACCESS_IN?>"><span class="arrow"></span><a class="cat" onclick="$('#unreaded_only').val(0);changeShortCutList(<?php echo ENLIGHTN_ACCESS_IN?>);return false;" href="#"><?php echo elgg_echo('enlightn:membershiprequest'); ?><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_IN)?></a></li>
				<li id="discussion_selector_<?php echo ENLIGHTN_ACCESS_FA?>"><span class="arrow"></span><a class="cat" onclick="$('#unreaded_only').val(0);changeShortCutList(<?php echo ENLIGHTN_ACCESS_FA?>);return false;" href="#"><?php echo elgg_echo('enlightn:favorite'); ?><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_FA)?></a></li>
				<li id="discussion_selector_<?php echo ENLIGHTN_ACCESS_AL?>"><span class="arrow"></span><a class="cat" onclick="$('#unreaded_only').val(0);changeShortCutList(<?php echo ENLIGHTN_ACCESS_AL?>);return false;" href="#"><?php echo elgg_echo('enlightn:search'); ?></a></li>
  			</ol>
        </div>
    </div>
</div>
<input type="hidden" name="discussion_type" id="discussion_type" value="1">
<script language="javascript">
setInterval(function() {
	$.getJSON('<?php echo $vars['url']; ?>mod/enlightn/ajax/discussion_unreaded.php', function(data) {
		$.each(data, function(i,item){
			var received_value = item;
			var nav_element = $("#nav_unreaded_" + i);
			if(typeof nav_element == 'object') {
				if (received_value != '0' && nav_element.html() != received_value) {
					nav_element.html(received_value);
					//changeShortCutList(i);
				}
			}
		});
	});
}, 15000);

function changeShortCutList (accessLevel,offset,discussionId) {
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
		items.push('<div class="menu"><span class="up" id="shortcuted_messages_previous"><span class="arrow"></span></span><ol>');
		$.each(data, function(i,item){
			if (item.readed) {
				classReaded = 'readed';
			} else {
				classReaded = 'unreaded';
			}
			if (i != 'access_level') {
				if(discussionId == item.guid) {
					liClass = ' class="selected"';
				} else {
					liClass = '';
				}
				items.push('<li id="' + item.guid + '"' + liClass + '><a href="<?php echo $vars['url']; ?>pg/enlightn/discuss/' + item.guid +'">' +  item.title + '</li>');
			} else {
				accessLevel = item;
			}
		});
		currElement 	= $('#discussion_selector_' + accessLevel);
		items.push('</ol><span class="down" id="shortcuted_messages_next"><span class="arrow"></span></span></div>');
		$('<ul/>', {
			'id' : 'shortcuted_messages',
    		'class': 'shortcuted_messages',
    		html: items.join('')}).appendTo(currElement);
		$(currElement).addClass('current');
		$("#list_selector li").each(function () {
			if($(this).attr('id') != $(currElement).attr('id')) {
				$(this).removeClass('current');
			}
      	});
		$('#shortcuted_messages_next').click( function(){
			if (offset == '') {
				nextOffset = 10;
				changeShortCutList(accessLevel,nextOffset,discussionId);
			} else if (parseInt(offset) >= 0) {
				nextOffset = parseInt(offset) + 10;
				changeShortCutList(accessLevel,nextOffset,discussionId);
			}
			return false;
		});
		$('#shortcuted_messages_previous').click( function(){
			if (parseInt(offset) > 0) {
				nextOffset = parseInt(offset) - 10;
				changeShortCutList(accessLevel,nextOffset,discussionId);
			}
			return false;
		});
	});
}
changeShortCutList(undefined,undefined,<?php echo $vars['discussion_id']?>);

</script>