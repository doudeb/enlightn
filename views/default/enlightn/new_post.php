            <div class="forward" id="forwardActionButton">
                <span class="forwardMessage"><?php echo elgg_echo("enlightn:selectparttoforward"); ?></span>
                <button type="reset" class="submit" id="forwardCancel"><?php echo elgg_echo("enlightn:buttoncancel"); ?></button>
                <button type="submit" class="submit" id="forwardParts"><?php echo elgg_echo('enlightn:buttonforward'); ?></button>
            </div>
            <div id="new-post" class="fixed">
				<?php
				$url_cloud = $vars['url'] . 'enlightn/cloud/' . $vars['entity']->guid . '/new_post';
				echo elgg_view('input/longtext',array('name' => 'new_post',
									'id' => 'new_post'
									, 'url_cloud' => $url_cloud)); ?>
				<input type="hidden" name="guid" id="guid" value="<?php echo $vars['entity']->guid; ?>" />
				<!-- display the post button -->
				<div id="submission"></div>
	            <div class="sending">
	            	<!--<input class="checkbox" type="checkbox" id="autoReply"/><span class="reply ico"></span>-->
	                <button type="submit" class="submit"><?php echo elgg_echo('enlightn:buttonsend'); ?></button>
	            </div>
			</div>
<script>
	$(document).ready(function() {
		$('#new-post .submit').click( function () {
			var url = '/action/enlightn/addpost?__elgg_ts=' + elgg.security.token.__elgg_ts + '&__elgg_token=' + elgg.security.token.__elgg_token
				, content = $(".rte-zone").contents().find(".frameBody")
				, guid = $('#guid').val();
			$('#submission').prepend('<img src="<?php echo $vars['url'] ?>/mod/enlightn/media/graphics/loading.gif" alt="loading">');
			$.post(url,{content:content.html(),guid:guid},function(data) {
				$('#submission').html(data.message);
				if (data.success) {
					content.html('').css('height','85').focus();
		            $("#post .textarea").css('height','85');
		            $('#viewDiscussion').triggerHandler("click");
				}
			},'json');
		});
	});
</script>