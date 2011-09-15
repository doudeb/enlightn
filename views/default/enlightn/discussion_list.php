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
                                <li id="setReaded"><?php echo elgg_echo("enlightn:setasunread")?></li>
                                <li id="setFollow"><?php echo elgg_echo("enlightn:setasfollow")?></li>
                                <li id="setFollow"><?php echo elgg_echo("enlightn:setasunfolow")?></li>
                                <li id="setFavorite"><?php echo elgg_echo("enlightn:setasfavorite")?></li>
                                <li id="setFavorite"><?php echo elgg_echo("enlightn:setasunfavorite")?></li>
                            </ul>
                        </li>
                    </ul>

                    <ul class="right">
                        <!--<li>Trier par : date<span class="arrow"></span></li>-->
                    </ul>
                </div>
   				<ol id="discussion_list_container"></ol>
				<div class="more" id="see_more_discussion_list"><?php echo elgg_echo("enlightn:seemore")?> <span class="ico"></span></div>
</div>

   </div>
<input type="hidden" name="see_more_discussion_list_offset" id="see_more_discussion_list_offset" value="0">
<input type="hidden" name="unreaded_only" id="unreaded_only" value="0">
<script language="javascript">
changeMessageList('#discussion_selector_<?php echo ENLIGHTN_ACCESS_PU?>', '<?php echo ENLIGHTN_ACCESS_PU?>');

$('#see_more_discussion_list').click(function () {
	$('#see_more_discussion_list_offset').val(parseInt($('#see_more_discussion_list_offset').val())+10);
	loadContent('#discussion_list_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/search.php'  + get_search_criteria(),'append');
});

$(document).ready(function(){
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
                    break;
                    case 'setFavorite' :
                        var url = '<?php echo $url_favorite ?>&annotation_id=' + elmId.val();
                        var toggleElm = $(this).parent();
                        var toggleClass = "starred";
                    break;
                    case 'setReaded' :
                        var url = '<?php echo $url_read ?>&discussion_guid=' + elmId.val();
                        var toggleElm = $("#read" + elmId.val()).parent().parent();
                        var toggleClass = "unread";
                    break;
                    default : return false;
                }
				loadContent("#loader",url,'append');
   				toggleElm.toggleClass(toggleClass);
			}
		});
    }

	$('#setFollow').click(function () { markAs('setFollow') });
	$('#setFavorite').click(function () { markAs('setFavorite') });
	$('#setReaded').click(function () { markAs('setReaded') });
});
</script>