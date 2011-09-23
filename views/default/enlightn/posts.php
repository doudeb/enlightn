			<div id="feed" class="detail">
                <div class="s-actions">
                    <ul>

                        <li id="expandAll"><span class="arrow"></span><?php echo elgg_echo("enlightn:expandall"); ?></li>
                        <li id="collapseAll"><span class="arrow arrow-top"></span><?php echo elgg_echo("enlightn:collapseall"); ?></li>
                    </ul>
                </div>
                <ol id="discussion_list_container"></ol>
				<input type="hidden" name="see_more_discussion_list_offset" id="see_more_discussion_list_offset" value="0">
				<input type="hidden" name="entity_access_id" id="entity_access_id" value="<?php echo $vars['entity']->access_id?>">
				<input type="hidden" name="entity_guid" id="entity_guid" value="<?php echo $vars['entity']->guid?>">
                <div class="more" id="see_more_discussion_list"><?php echo elgg_echo("enlightn:seemore")?> <span class="ico"></span></div>
            </div>
<script>
$('#see_more_discussion_list').click(function () {
	$('#see_more_discussion_list_offset').val(parseInt($('#see_more_discussion_list_offset').val())+10);
	loadContent('#discussion_list_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/search.php'  + get_search_criteria(),'append');
});

$(document).ready(function() {
	loadContent('#discussion_list_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/search.php'  + get_search_criteria());
});
</script>
	</div>