<?php

	/**
	 * Elgg Topic individual post view. This is all the follow up posts on a particular topic
	 *
	 * @package ElggGroups
	 *
	 * @uses $vars['entity'] The posted comment to view
	 */
$discussion = get_annotation($vars['entity']->id);
$post_owner = get_user($discussion->owner_guid);
$url_invite	= elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/read?discussion_guid={$discussion->id}");

?>
                    <li class="msg <?php echo false===$flag_readed?'read open-msg':'' ?>">
                        <div class="toolbar">
							<span class="inclosed ico"></span>
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
                        	<?php echo $discussion->value; ?>
                        </div>
                    </li>
<script>
		$("#read<?php echo $discussion->id; ?>").click( function(){
			if ($("#read<?php echo $discussion->id; ?>").hasClass("unread open-msg")) {
				$("#read<?php echo $discussion->id; ?>").removeClass("unread open-msg");
			} else {
				$("#read<?php echo $discussion->id; ?>").addClass("unread");
				$("#read<?php echo $discussion->id; ?>").addClass("open-msg");
			}
			loadContent('#loader','<?php echo $url_read?>');
		});
</script>