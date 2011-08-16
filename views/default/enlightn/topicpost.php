<?php

	/**
	 * Elgg Topic individual post view. This is all the follow up posts on a particular topic
	 *
	 * @package ElggGroups
	 *
	 * @uses $vars['entity'] The posted comment to view
	 */
$discussion 	= get_annotation($vars['entity']->id);
$flag_readed	= $vars['flag_readed'];
$post_owner 	= get_user($discussion->owner_guid);
$url_read		= elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/read?discussion_guid={$discussion->id}");
$src_embeded	= elgg_get_entities_from_relationship(array(
															'relationship' => ENLIGHTN_EMBEDED,
															'relationship_guid' => $discussion->id,
															'inverse_relationship' => true));
?>
                    <li class="msg <?php echo false===$flag_readed?'unread open-msg':'' ?>">
                        <div class="toolbar">
                        	<?php if (is_array($src_embeded)) {
								echo '<span class="inclosed ico"></span>';
                        	}?>
                            <span class="date"><?php echo elgg_view_friendly_time($discussion->time_created)?></span>
                        </div>
                        <div class="statusbar">
                            <!--<span class="star ico"></span>-->
                            <span id="read<?php echo $discussion->id?>" class="read ico"></span>
                        </div>
                        <div class="excerpt">
                            <img class="thumb-photo" src="<?php echo $post_owner->getIcon('small')?>" />

                            <span class="participants"><strong><?php echo $post_owner->name?></strong></span>
                            <p><?php echo strip_tags($discussion->value); ?></p>
                        </div>
                        <div class="content">
                        	<?php echo $discussion->value;
                        if (is_array($src_embeded)) {
							echo '<div class="inclosed-list">
                                <h4>' . count($src_embeded) . ' ' . elgg_echo('enlightn:attachmentlist') . '</h4>
                                <a class="all" href="/download">' . elgg_echo('enlightn:downloadall') . '</a>
                                <ul>';
							foreach ($src_embeded as $key=>$file) {
								echo '<li><a class="' . $file->simpletype .'" href="">' . $file->title .'</a><span class="spec">(' . $file->size() .')</span></li>';
							}
                            echo '</ul>
                            </div>';
                        }?>
                        </div>
                    </li>
<script>
		$("#read<?php echo $discussion->id; ?>").click( function(){
			if ($("#read<?php echo $discussion->id; ?>").parent().parent().hasClass("unread")) {
				$("#read<?php echo $discussion->id; ?>").parent().parent().removeClass("unread");
			} else {
				$("#read<?php echo $discussion->id; ?>").parent().parent().addClass("unread");
			}
			loadContent('#loader','<?php echo $url_read?>');
		});
</script>