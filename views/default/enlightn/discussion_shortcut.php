<?php
$unreaded = sort_unreaded_for_nav($vars['discussion_unreaded']);
?>
			<ol class="folders" id="list_selector">
				<li class="current" id="discussion_selector_<?php echo ENLIGHTN_ACCESS_PU?>"><span class="arrow"></span><a class="cat" onclick="$('#unreaded_only').val(0);changeShortCutList(<?php echo ENLIGHTN_ACCESS_PU?>);return false;" href="#"><?php echo elgg_echo('enlightn:public'); ?><!--<?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_PU)?>--></a></li>
				<li id="discussion_selector_<?php echo ENLIGHTN_ACCESS_PR?>"><span class="arrow"></span><a class="cat" onclick="$('#unreaded_only').val(0);changeShortCutList(<?php echo ENLIGHTN_ACCESS_PR?>);return false;" href="#"><?php echo elgg_echo('enlightn:follow'); ?><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_PR)?></a></li>
				<li id="discussion_selector_<?php echo ENLIGHTN_ACCESS_IN?>"><span class="arrow"></span><a class="cat" onclick="$('#unreaded_only').val(0);changeShortCutList(<?php echo ENLIGHTN_ACCESS_IN?>);return false;" href="#"><?php echo elgg_echo('enlightn:request'); ?><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_IN)?></a></li>
				<li id="discussion_selector_<?php echo ENLIGHTN_ACCESS_FA?>"><span class="arrow"></span><a class="cat" onclick="$('#unreaded_only').val(0);changeShortCutList(<?php echo ENLIGHTN_ACCESS_FA?>);return false;" href="#"><?php echo elgg_echo('enlightn:favorites'); ?><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_FA)?></a></li>
				<li id="discussion_selector_<?php echo ENLIGHTN_ACCESS_AL?>"><span class="arrow"></span><a class="cat" onclick="$('#unreaded_only').val(0);changeShortCutList(<?php echo ENLIGHTN_ACCESS_AL?>);return false;" href="#"><?php echo elgg_echo('enlightn:search'); ?></a></li>
  			</ol>
        </div>
    </div>
</div>
<input type="hidden" name="discussion_type" id="discussion_type" value="<?php echo get_last_search_value('access_level')?get_last_search_value('access_level'):ENLIGHTN_ACCESS_PU;?>">
<script language="javascript">
setInterval(function() {
	$.getJSON('<?php echo $vars['url']; ?>mod/enlightn/ajax/discussion_unreaded.php', function(data) {
		$.each(data, function(i,item){
			var received_value = item;
			var nav_element = $("#nav_unreaded_" + i);
			if(typeof nav_element == 'object') {
				if (received_value != '0' && nav_element.html() != received_value) {
					nav_element.html(received_value);
					if ($('#discussion_type').val() == i) {
						changeShortCutList(i,undefined,<?php echo $vars['discussion_id']?>);
					}
				}
			}
		});
	});
}, 15000);

function changeShortCutList  (accessLevel,offset,discussionId) {
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
		var count = 0;
		for ( results in data ) count++;
		if(count ==1 ) {
			//alert("Larousse est un gros sac....");
			changeShortCutList(accessLevel,offset-10,discussionId);
			return false;
		}
		items.push('<div class="menu"><span class="up" id="shortcuted_messages_previous"><span class="arrow"></span></span><ol>');
		$.each(data, function(i,item){
			if (i != 'access_level') {
				if (item.readed) {
					classReaded = '';
				} else {
					classReaded = ' unreaded';
				}
				if(discussionId == item.guid) {
					liClass = ' class="selected' + classReaded +'"';
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
changeShortCutList($('#discussion_type').val(),undefined,<?php echo $vars['discussion_id']?>);

</script>