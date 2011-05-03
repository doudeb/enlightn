<?php

    /**
	 * Elgg groups plugin display topic posts
	 *
	 * @package ElggGroups
	 */


//retreive the last comment
$post = $vars['entity']->getAnnotations('', 1, 0, "desc");
$post = $post[0];
$flag_readed = check_entity_relationship($vars['user_guid'], ENLIGHTN_READED,$post->id);
$post_owner = get_entity($post->owner_guid);
?>
<!-- grab the topic title -->
<div id="short_friendly_time"><small><?php echo elgg_view_friendly_time($post->time_created) ?></small></div>
<div id="<?php echo false===$flag_readed?'short_post_view_unread':'short_post_view'?>"><!-- start the topic_post -->
	<a href="" onclick="javascript:loadContent('#discussion','<?php echo $vars['url'] ?>/mod/enlightn/ajax/discussion.php?discussion_id=<?php echo $vars['entity']->guid; ?>'); return false;"><?php echo $vars['entity']->title; ?></a>
   	<a name="<?php echo $post->id; ?>"></a>
   	<div class="post_icon" style="float:right"><?php echo elgg_view("profile/icon",array('entity' => $post_owner, 'size' => 'small')) ?></div>
   	<div class="clearFloat"></div>
                <?php
                    //get infomation about the owner of the comment
                    if ($post_owner = get_user($post->owner_guid)) {
                       echo "<p><b>" . $post_owner->name . "</b><br />";
                    }
                   //display the actual message posted
                   echo parse_urls(elgg_view("output/longtext",array("value" => elgg_get_excerpt($post->value, 200))));
                ?>
</div><!-- end the topic_post -->
<?php
	if (isset($vars['discussion_id']) && $vars['discussion_id'] == $vars['entity']->guid) {
?>
<script language="javascript">
javascript:loadContent('#discussion','<?php echo $vars['url'] ?>/mod/enlightn/ajax/discussion.php?discussion_id=<?php echo $vars['entity']->guid; ?>');
</script>
<?php
	}
?>