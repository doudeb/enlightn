<?php
$cloud_discussion   = count($vars['cloud_discussion'])-1;
?>
                    <div class="contents">
						<div class="tabs">
							<a href="#messages" class="btn active left" id="viewDiscussion"> <?php echo elgg_echo("enlightn:viewdiscussion"); ?> </a>
							<a href="#cloud" class="btn right" id="viewDiscussionCloud"> <?php echo elgg_echo("enlightn:viewcloud"); ?> (<span><?php echo $cloud_discussion>0?$cloud_discussion:0;?></span>) </a>
						</div>

						<div class="tab_contents">
							<div id="messages">

								<a href="#new_message" class="new_message btn_secondary"><?php echo elgg_echo("enlightn:newpost"); ?></a>

								<form id="new_message" action="" method="post">
                                    <input type="hidden" name="entity_access_id" id="entity_access_id" value="<?php echo $vars['entity']->access_id?>">
                                    <input type="hidden" name="entity_guid" id="entity_guid" value="<?php echo $vars['entity']->guid?>">

									<p> <?php echo elgg_view('input/longtext',array('name' => 'new_post',
									'id' => 'new_post'
									, 'url_cloud' => $url_cloud)); ?>
                                        <input type="hidden" name="guid" id="guid" value="<?php echo $vars['entity']->guid; ?>" /> </p>

									<div class="actions">
										<!--<div class="medias">
											<a href="#add_link" class="add_link">  </a>
											<a href="#add_image" class="add_image">  </a>
											<a href="#add_file" class="add_file">  </a>
											<a href="#add_video" class="add_video">  </a>
										</div>-->

										<div class="buttons">
											<input type="reset" class="reset" value="Annuler" />
											<input type="submit" class="submit btn_secondary" value="Poster" />
										</div>
                                        <div id="submission"></div>
									</div>
								</form>
<script>
	$(document).ready(function() {
		$('#new_message .submit').click( function () {
			var url = '/action/enlightn/addpost?__elgg_ts=' + elgg.security.token.__elgg_ts + '&__elgg_token=' + elgg.security.token.__elgg_token
				, content = $(".rte-zone").contents().find(".frameBody")
				, guid = $('#guid').val();
			$('#submission').prepend('<img src="<?php echo $vars['url'] ?>/mod/enlightn/media/graphics/loading.gif" alt="loading">');
			$.post(url,{content:content.html(),guid:guid},function(data) {
				$('#submission').html(data.message);
				if (data.success) {
					content.html('').css('height','85').focus();
		            $("#new_message .textarea").css('height','85');
		            $('#viewDiscussion').triggerHandler("click");
				}
			},'json');
            return false;
		});
	});
</script>