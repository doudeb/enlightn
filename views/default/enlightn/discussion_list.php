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
                                <li id="selectNone"><?php echo elgg_echo("enlightn:none")?></li>
                                <li id="selectRead"><?php echo elgg_echo("enlightn:read")?></li>
                                <li id="selectUnread"><?php echo elgg_echo("enlightn:unread")?></li>
                            </ul>
                        </li>
                        <li><?php echo elgg_echo("enlightn:action")?><span class="arrow"></span>
                            <ul>
                                <li id="setReaded"><?php echo elgg_echo("enlightn:setasreadunread")?></li>
                                <li id="setFollow"><?php echo elgg_echo("enlightn:setasfollowunfolow")?></li>
                                <li id="setFavorite"><?php echo elgg_echo("enlightn:setasfavorite")?></li>
                            </ul>
                        </li>
                    </ul>

                    <ul class="right">
                        <!--<li>Trier par : date<span class="arrow"></span></li>-->
                    </ul>
                </div>
   				<ol>
					<div id="discussion_list_container"></div>
				</ol>
				<div class="more" id="see_more_discussion_list"><?php echo elgg_echo("enlightn:seemore")?> <span class="ico"></span></div>
</div>

   </div>
<input type="hidden" name="see_more_discussion_list_offset" id="see_more_discussion_list_offset" value="0">
<input type="hidden" name="unreaded_only" id="unreaded_only" value="0">
<script language="javascript">
changeMessageList('#discussion_selector_all', 1);

$('#see_more_discussion_list').click(function () {
	$('#see_more_discussion_list_offset').val(parseInt($('#see_more_discussion_list_offset').val())+10);
	loadContent('#discussion_list_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/search.php'  + get_search_criteria(),'append');
});

$(document).ready(function(){
	reloader("<?php echo $vars['url']; ?>mod/enlightn/ajax/search.php", '#discussion_list_container');
	$('#setReaded').click(function () {
		$("#discussion_list_container li").each(function () {
			elmId = $(this).find('.statusbar').find(':checkbox').is(':checked')?$($(this).find('.statusbar').find(':checkbox')):false;
			if (elmId) {
				loadContent("#loader",'<?php echo $url_read ?>&discussion_guid=' + elmId.val());
				if ($("#read" + elmId.val()).parent().parent().hasClass("unread")) {
					$("#read" + elmId.val()).parent().parent().removeClass("unread");
				} else {
					$("#read" + elmId.val()).parent().parent().addClass("unread");
				}
			}
		});
	});
	$('#setFollow').click(function () {
		$("#discussion_list_container li").each(function () {
			elmId = $(this).find('.statusbar').find(':checkbox').is(':checked')?$($(this).find('.statusbar').find(':checkbox')):false;
			if (elmId) {
				loadContent("#loader",'<?php echo $url_follow ?>&annotation_id=' + elmId.val());
				if ($(this).hasClass("followed")) {
					$(this).removeClass("followed");
				} else {
					$(this).addClass("followed");
				}
			}
		});
	});
	$('#setFavorite').click(function () {
		$("#discussion_list_container li").each(function () {
			elmId = $(this).find('.statusbar').find(':checkbox').is(':checked')?$($(this).find('.statusbar').find(':checkbox')):false;
			if (elmId) {
				loadContent("#loader",'<?php echo $url_favorite ?>&annotation_id=' + elmId.val());
				if ($(this).hasClass("starred")) {
					$(this).removeClass("starred");
				} else {
					$(this).addClass("starred");
				}
			}
		});
	});
});
</script>