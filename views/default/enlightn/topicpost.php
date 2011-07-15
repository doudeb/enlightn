<?php

	/**
	 * Elgg Topic individual post view. This is all the follow up posts on a particular topic
	 *
	 * @package ElggGroups
	 *
	 * @uses $vars['entity'] The posted comment to view
	 */
$post_owner = get_user($vars['entity']->owner_guid);
$discussion = get_annotation($vars['entity']->id);
?>
<div class="post_container">
	<a id="discussion_post<?php echo $discussion->id; ?>"></a>
	<div id="short_friendly_time"><div class="post_icon"><?php echo elgg_view("profile/icon",array('entity' => $post_owner, 'size' => 'small')) ?></div></div>
	<div id="<?php echo false===$vars['flag_readed']?'short_post_view_unread':'short_post_view'?>">
		<b><?php echo $post_owner->name?></b>
		<small><?php echo elgg_view_friendly_time($discussion->time_created)?></small>
		<p><?php echo $discussion->value; ?></p>
	</div>
</div>