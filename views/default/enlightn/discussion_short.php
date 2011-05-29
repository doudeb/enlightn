<?php

    /**
	 * Elgg groups plugin display topic posts
	 *
	 * @package ElggGroups
	 */


//retreive the last comment
if ($vars['entity'] instanceof ElggAnnotation) {
	$post = $vars['entity'];
} else {
	$post = $vars['entity']->getAnnotations('', 1, 0, "desc");
	$post = $post[0];
}
$flag_readed = check_entity_relationship($vars['user_guid'], ENLIGHTN_READED,$post->id);
$post_owner = get_entity($post->owner_guid);
?>
<!-- grab the topic title -->
<div class="discussion_short_container">
	<div id="short_friendly_time"><?php echo elgg_view_friendly_time($post->time_created) ?></div>
	<div id="<?php echo false===$flag_readed?'short_post_view_unread':'short_post_view'?>">
	<!-- start the topic_post -->
	<h2><a href="<?php echo $vars['url'] ?>/pg/enlightn/discuss/<?php echo $vars['entity']->guid; ?>" id="discussion_link_<?php echo $post->id ?>"><?php echo search_get_highlighted_relevant_substrings($vars['entity']->title,$vars['query']); ?></a></h2>
	   	<div class="post_icon" style="float:right"><?php echo elgg_view("profile/icon",array('entity' => $post_owner, 'size' => 'small')) ?></div>
	                <?php
	                    //get infomation about the owner of the comment
	                    if ($post_owner = get_user($post->owner_guid)) {
	                       echo "<p><b>" . $post_owner->name . "</b></p>";
	                    }
	                    if (!check_entity_relationship($vars['user_guid'], ENLIGHTN_FOLLOW, $vars['entity']->guid)) {
	                    	echo elgg_view("enlightn/follow", array('entity' => $vars['entity']
	    													, 'user_guid' => $vars['user_guid']));
	                    }
	                   //display the actual message posted
	                   if (isset($vars['query'])) {
	                   		echo elgg_view("output/longtext",array("value" => search_get_highlighted_relevant_substrings($post->value,$vars['query'])));
	                   } else {
	                   		echo parse_urls(elgg_view("output/longtext",array("value" => elgg_get_excerpt($post->value, 200))));
	                   }
	                ?>
	</div>
	<div style="clearfloat"></div>
</div><!-- end the topic_post -->