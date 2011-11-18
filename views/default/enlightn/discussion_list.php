<?php
$url_read			= elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/read?");
$url_favorite		= elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/favorite?");
$url_follow			= elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/follow?");
?>
	<div id="feed">
                <div class="actions">
                    <ul>
                        <li><input class="checkbox" type="checkbox" id="selectAll"/><span class="arrow"></span>
                            <ul>
                                <li id="selectRead"><?php echo elgg_echo("enlightn:read")?></li>
                                <li id="selectUnread"><?php echo elgg_echo("enlightn:unread")?></li>
                            </ul>
                        </li>
                        <li><?php echo elgg_echo("enlightn:action")?><span class="arrow"></span>
                            <ul>
                                <li id="setReaded"><?php echo elgg_echo("enlightn:setasread")?></li>
                                <li id="setUnReaded"><?php echo elgg_echo("enlightn:removeasread")?></li>
                                <li id="setFollow"><?php echo elgg_echo("enlightn:setasfollow")?></li>
                                <li id="setUnFollow"><?php echo elgg_echo("enlightn:removeasfollow")?></li>
                                <li id="setFavorite"><?php echo elgg_echo("enlightn:setasfavorite")?></li>
                                <li id="removeFavorite"><?php echo elgg_echo("enlightn:removeasfavorite")?></li>
                            </ul>
                        </li>
                    </ul>

                    <ul class="right">
                        <li><?php echo elgg_echo("enlightn:showunread")?> <input class="checkbox" type="checkbox" id="showunread"/></li>
                    </ul>
                </div>
   				<ol id="discussion_list_container"></ol>
				<div class="more" id="see_more_discussion_list"><?php echo elgg_echo("enlightn:seemore")?> <span class="ico"></span></div>
</div>

   </div>
<input type="hidden" name="see_more_discussion_list_offset" id="see_more_discussion_list_offset" value="0">
<input type="hidden" name="unreaded_only" id="unreaded_only" value="0">
<script language="javascript">


$('#see_more_discussion_list').click(function () {
	$('#see_more_discussion_list_offset').val(parseInt($('#see_more_discussion_list_offset').val())+10);
	loadContent('#discussion_list_container','<?php echo $vars['url'] ?>mod/enlightn/ajax/search.php'  + get_search_criteria(),'append');
});

$(document).ready(function(){
    changeMessageList('#discussion_selector_<?php echo $vars['discussion_type']?>', '<?php echo $vars['discussion_type']?>');
    reloader("<?php echo $vars['url']; ?>mod/enlightn/ajax/search.php", '#discussion_list_container');

    function markAs (action) {
        $('#discussion_list_container li input[type=checkbox]:checked').each(function (key,item) {
			var elmId = $(item);
			if (elmId.val().length > 1) {
                switch (action) {
                    case 'setFollow' :
                        var url = '<?php echo $url_follow ?>&annotation_id=' + elmId.val();
                        var toggleElm = $(this).parent().parent().find('.toolbar span').eq(0);
                        var toggleClass = "unfollow";
                        if(toggleElm.hasClass("unfollow")) {
                            return false;
                        }
                    break;
                    case 'setUnFollow' :
                        var url = '<?php echo $url_follow ?>&annotation_id=' + elmId.val();
                        var toggleElm = $(this).parent().parent().find('.toolbar span').eq(0);
                        var toggleClass = "unfollow";
                        if(!toggleElm.hasClass("unfollow")) {
                            return false;
                        }
                    break;
                    case 'setFavorite' :
                        var url = '<?php echo $url_favorite ?>&annotation_id=' + elmId.val();
                        var toggleElm = $(this).parent();
                        var toggleClass = "starred";
                        if(toggleElm.hasClass("starred")) {
                            return false;
                        }
                    break;
                    case 'removeFavorite' :
                        var url = '<?php echo $url_favorite ?>&annotation_id=' + elmId.val();
                        var toggleElm = $(this).parent();
                        var toggleClass = "starred";
                        if(!toggleElm.hasClass("starred")) {
                            return false;
                        }
                    break;
                    case 'setReaded' :
                        var url = '<?php echo $url_read ?>&discussion_guid=' + elmId.val();
                        var toggleElm = $("#read" + elmId.val()).parent().parent();
                        var toggleClass = "unread";
                        if(!toggleElm.hasClass("unread")) {
                            return false;
                        }
                    break;
                    case 'setUnReaded' :
                        var url = '<?php echo $url_read ?>&discussion_guid=' + elmId.val();
                        var toggleElm = $("#read" + elmId.val()).parent().parent();
                        var toggleClass = "unread";
                        if(toggleElm.hasClass("unread")) {
                            return false;
                        }
                    break;
                    default : return false;
                }
				loadContent("#loader",url,'append');
   				toggleElm.toggleClass(toggleClass);
			}
		});
    }

	$('#setFollow').click(function () { markAs('setFollow') });
	$('#setUnFollow').click(function () { markAs('setUnFollow') });
	$('#setFavorite').click(function () { markAs('setFavorite') });
	$('#removeFavorite').click(function () { markAs('removeFavorite') });
	$('#setReaded').click(function () { markAs('setReaded') });
	$('#setUnReaded').click(function () { markAs('setUnReaded') });
});
</script>