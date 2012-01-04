<?php
$cloud_discussion   = count($vars['cloud_discussion']);
?>
        <div id="feed" class="detail">
                <div class="s-actions">
                    <ul>
                        <li id="viewDiscussion"><?php echo elgg_echo("enlightn:viewdiscussion"); ?></li>
                        <li>|</li>
                        <li id="viewDiscussionCloud"><?php echo elgg_echo("enlightn:viewcloud"); ?> (<?php echo $cloud_discussion>0?$cloud_discussion:0;?>)</li>
                        <li id="expand" class="right"><?php echo elgg_echo("enlightn:expandall"); ?> / <?php echo elgg_echo("enlightn:collapseall"); ?> <span class="arrow"></span></li>
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
</script>
	</div>