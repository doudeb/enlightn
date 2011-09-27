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
$has_words		= stripos($discussion->value,$vars['query']);
$url_read		= elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/read?discussion_guid={$discussion->id}");
$src_embeded	= elgg_get_entities_from_relationship(array(
															'relationship' => ENLIGHTN_EMBEDED,
															'relationship_guid' => $discussion->id,
															'inverse_relationship' => true));
?>
                    <li class="msg<?php echo false===$flag_readed?' unread open-msg':' read' ?><?php echo $has_words?' open-msg':'' ?>">
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
                            <?php echo elgg_view('input/user_photo',array('class'=>'thumb-photo','user_ent'=>$post_owner));?>
                            <span class="participants"><strong><?php echo $post_owner->name?></strong></span>
                            <p><?php echo strip_tags($discussion->value); ?></p>
                        </div>
                        <div class="content">
                        	<?php echo enlightn_search_highlight_words($vars['query'],$discussion->value);
                        if (is_array($src_embeded)) {
							echo '<div class="inclosed-list">
                                <h4>' . count($src_embeded) . ' ' . elgg_echo('enlightn:attachmentlist') . '</h4>
                                <p>';
							foreach ($src_embeded as $key=>$file) {
                                $url = get_file_link($file);
								echo '<a href="' . $url . '" target="_blank" title="' . $file->title. '">' . elgg_view("enlightn/cloud/icon", array("mimetype" => $file->mimetype, 'thumbnail' => $file->thumbnail, 'file_guid' => $file->guid, 'size' => 'small')) . "</a>";
							}
                            echo '</p></div>';
                        }?>
                        </div>
                    </li>
<script>
		$("#read<?php echo $discussion->id; ?>").click( function(){
			$("#read<?php echo $discussion->id; ?>").parent().parent().toggleClass("read unread open-msg");
			loadContent('#loader','<?php echo $url_read?>');
		});
</script>