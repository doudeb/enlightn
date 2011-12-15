<?php

    /**
	 * Elgg groups plugin display topic posts
	 *
	 * @package ElggGroups
	 */


//retreive the last comment
disable_right($vars['entity']->guid);
$post 				= get_annotation($vars['entity']->id);
$flag_readed 		= elgg_view("enlightn/message_unreaded", array('entity' => $vars['entity']));
$flag_folowed 		= check_entity_relationship($vars['user_guid'], ENLIGHTN_FOLLOW,$post->entity_guid);
$flag_favorite 		= check_entity_relationship($vars['user_guid'], ENLIGHTN_FAVORITE,$post->entity_guid);
$post_owner 		= get_entity($post->owner_guid);
$entity				= get_entity($post->entity_guid);
$url_read			= elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/read?discussion_guid={$post->id}");
$url_favorite		= elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/favorite?discussion_guid={$post->entity_guid}");
$short_description	= strip_tags($post->value);
$short_description	= substr($short_description,0,214);
$short_title    	= substr($entity->title,0,55);
?>
<!-- grab the topic title -->
                    <li id="msg<?php echo $post->entity_guid; ?>" class="msg msg_home <?php echo !empty($flag_readed)?'unread':'read' ?> <?php echo false===$flag_folowed?'':'followed'  ?>">
                        <div class="toolbar">
							<?php echo elgg_view("enlightn/follow", array('entity' => $vars['entity'], 'user_guid' => $vars['user_guid']));?>
                        </div>
                        <div class="statusbar<?php echo  false===$flag_favorite?'':' starred'?>">
                            <input class="checkbox" type="checkbox" value="<?php echo $post->id; ?>"/>
                            <span class="read ico" id="read<?php echo $post->id; ?>"></span>
                            <span class="star ico" id="favorite<?php echo $post->entity_guid; ?>"></span>
                        </div>
                        <div class="excerpt" id="excerpt<?php echo $post->entity_guid; ?>">
                            <?php echo elgg_view('input/user_photo',array('class'=>'thumb-photo','user_ent'=>$post_owner));?>
                            <h3><a href="<?php echo $vars['url'] ?>enlightn/discuss/<?php echo $vars['entity']->guid; ?>"><?php echo $short_title?></a><?php echo $flag_readed?></h3>
                            <span class="participants"><strong><?php echo $post_owner->name?></strong> <?php echo elgg_view("enlightn/discussion_members",array('entity' => $post
														, 'limit' => 3));?></span>
	                        <span class="date"><?php echo elgg_view_friendly_time($post->time_created) ?></span>

                            <p><?php echo enlightn_search_highlight_words($vars['query'],$short_description);?></p>
                        </div>
                    </li>
	<?php //echo elgg_view("enlightn/count_unreaded", array('entity' => $vars['entity'], 'discussion_unreaded' => $vars['discussion_unreaded']));?>


<script>
		$("#excerpt<?php echo $post->entity_guid; ?>").click( function(){
			$(location).attr('href','<?php echo $vars['url'] ?>enlightn/discuss/<?php echo $vars['entity']->guid; ?>');
		});
		$("#read<?php echo $post->id; ?>").click( function(){
			$("#read<?php echo $post->id; ?>").parent().parent().toggleClass("read unread");
			loadContent('#loader','<?php echo $url_read?>');
		});
		$("#favorite<?php echo $post->entity_guid; ?>").click( function(){
			$(this).parent().toggleClass("starred");
			loadContent('#loader','<?php echo $url_favorite?>');
		});
</script>
