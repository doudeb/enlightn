<?php
$unreaded           = sort_unreaded_for_nav($vars['discussion_unreaded']);
$discussion_type    = get_last_search_value('access_level');
?>
			<ol class="folders" id="list_selector">
                <li class="current" id="discussion_selector_<?php echo ENLIGHTN_ACCESS_PU?>"><span class="arrow"></span><a class="cat" onclick="$('#unreaded_only').val(0);changeShortCutList(<?php echo ENLIGHTN_ACCESS_PU?>,undefined,<?php echo $vars['discussion_id']?>);return false;" href="#"><?php echo elgg_echo('enlightn:public'); ?><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_PU)?></a></li>
				<li id="discussion_selector_<?php echo ENLIGHTN_ACCESS_IN?>"><span class="arrow"></span><a class="cat" onclick="$('#unreaded_only').val(0);changeShortCutList(<?php echo ENLIGHTN_ACCESS_IN?>,undefined,<?php echo $vars['discussion_id']?>);return false;" href="#"><?php echo elgg_echo('enlightn:request'); ?><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_IN)?></a></li>
				<li id="discussion_selector_<?php echo ENLIGHTN_ACCESS_PR?>"><span class="arrow"></span><a class="cat" onclick="$('#unreaded_only').val(0);changeShortCutList(<?php echo ENLIGHTN_ACCESS_PR?>,undefined,<?php echo $vars['discussion_id']?>);return false;" href="#"><?php echo elgg_echo('enlightn:follow'); ?><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_PR)?></a></li>
				<li id="discussion_selector_<?php echo ENLIGHTN_ACCESS_FA?>"><span class="arrow"></span><a class="cat" onclick="$('#unreaded_only').val(0);changeShortCutList(<?php echo ENLIGHTN_ACCESS_FA?>,undefined,<?php echo $vars['discussion_id']?>);return false;" href="#"><?php echo elgg_echo('enlightn:favorites'); ?><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_FA)?></a></li>
				<li id="discussion_selector_<?php echo ENLIGHTN_ACCESS_AL?>" style="display: none"><span class="arrow"></span><a class="cat" onclick="$('#unreaded_only').val(0);changeShortCutList(<?php echo ENLIGHTN_ACCESS_AL?>,undefined,<?php echo $vars['discussion_id']?>);return false;" href="#"><?php echo elgg_echo('enlightn:search'); ?><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_AL)?></a></li>
  			</ol>
        </div>
    </div>
</div>
<input type="hidden" name="discussion_type" id="discussion_type" value="<?php echo $discussion_type?$discussion_type:ENLIGHTN_ACCESS_PU;?>">
<script language="javascript">
changeShortCutList = function (accessLevel,offset,discussionId) {
    if ($('#discussion_type').val() != accessLevel) {
        $(location).attr('href','<?php echo $vars['url'] ?>enlightn/' + accessLevel);
        return true;
    }
	return false;
    currElement 	= $('#discussion_selector_' + accessLevel);
    if($('#loadingShortcut').hasClass('loading')) {
        return false;
    }
    $('<span />', {
			'id' : 'loadingShortcut',
    		'class': 'loading'}).prependTo(currElement);
    buffer.append(new Task(discussionId,'<?php echo $vars['url']; ?>mod/enlightn/ajax/discussion_shortcut.php',{
		offset: offset
		,access_level: accessLevel
	}, 'json',changeShortCutMenu));
}
getUnreadedDiscussion = function () {
    buffer.append(new Task(false, '<?php echo $vars['url']; ?>mod/enlightn/ajax/discussion_unreaded.php', false, 'json',checkUnreadedDiscussion));
 }

function checkUnreadedDiscussion (task, data, textStatus, XMLHttpRequest) {
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
}

function changeShortCutMenu (task, data, textStatus, XMLHttpRequest) {
    oldElement      = $('#shortcuted_messages');
    currElement 	= $('#discussion_selector_' + task.params.access_level);

	if (typeof accessLevel == 'undefined') {
		accessLevel = '';
	}

    if (typeof oldElement != 'undefined') {
        oldElement.html('');
    }

    fetchedRows = XMLHttpRequest.getResponseHeader('Fetch-rows');
    var items = [];
    if(fetchedRows >0 ) {
        items.push('<div class="menu"><span class="up" id="shortcuted_messages_previous"><span class="arrow"></span></span><ol>');
        $.each(data, function(i,item){
            if (i != 'access_level') {
                if (item.readed) {
                    classReaded = ' readed';
                } else {
                    classReaded = ' unreaded';
                }
                if(task.item == item.guid) {
                    liClass = ' class="selected' + classReaded +'"';
                } else {
                    liClass = ' class="' + classReaded +'"';
                }
                items.push('<li id="' + item.guid + '"' + liClass + '><a href="<?php echo $vars['url']; ?>enlightn/discuss/' + item.guid +'">' +  item.title + '</li>');
            }
        });
        items.push('</ol><span class="down" id="shortcuted_messages_next"><span class="arrow"></span></span></div>');
        $('<ul/>', {
            'id' : 'shortcuted_messages',
            'class': 'shortcuted_messages',
            html: items.join('')}).appendTo($(currElement));
    }
    oldElement.remove();
    $("#loadingShortcut").remove();

    $(currElement).addClass('current');
    $("#list_selector li").each(function () {
        if($(this).attr('id') != $(currElement).attr('id')) {
            $(this).removeClass('current');
        }
    });
    $('#shortcuted_messages_next').click( function(){
        if (typeof task.params.offset == 'undefined' || task.params.offset == '') {
            nextOffset = 10;
            changeShortCutList(task.params.access_level,nextOffset,task.item);
        } else if (parseInt(task.params.offset) >= 0) {
            nextOffset = parseInt(task.params.offset) + 10;
            changeShortCutList(task.params.access_level,nextOffset,task.item);
        }
        return false;
    });
    $('#shortcuted_messages_previous').click( function(){
        if (parseInt(task.params.offset) > 0) {
            nextOffset = parseInt(task.params.offset) - 10;
            changeShortCutList(task.params.access_level,nextOffset,task.item);
        }
        return false;
    });
}

$(document).ready(function(){
    loadContent('#discussion_list_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/search.php'  + get_search_criteria());
    $("#list_selector li").each(function () {
    	$(this).removeClass('current');            
    });
    $('#discussion_selector_<?php echo $discussion_type ?>').addClass('current');
    getUnreadedDiscussion();
    setInterval(function() {getUnreadedDiscussion()}, 7150);
    /*
    if ($('#discussion_type').val() != '<?php echo ENLIGHTN_ACCESS_AL?>') {
        getUnreadedDiscussion();
       	reloader("<?php echo $vars['url']; ?>mod/enlightn/ajax/search.php", '#discussion_list_container');
        setInterval(function() {getUnreadedDiscussion()}, 7150);
    } else {
        changeShortCutList($('#discussion_type').val(),undefined,<?php echo $vars['discussion_id']?>);
    }*/
});
</script>