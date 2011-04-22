<?php

    /**
	 * Elgg groups plugin display topic posts
	 * 
	 * @package ElggGroups
	 */
    
    
//retreive the last comment    
$post = $vars['entity']->getAnnotations('', 1, 0, "desc");
$post = $post[0];
?>
<!-- grab the topic title -->
<div id="short_friendly_time" style="float:left;width:90px;"><small><?php echo elgg_view_friendly_time($post->time_created) ?></small></div>   
<div id="short_post_view"><!-- start the topic_post -->	
	<a href="" onclick="javascript:loadContent('#discussion','<?php echo $vars['url'] ?>/mod/enlightn/ajax/discussion.php?discussion_id=<?php echo $vars['entity']->guid; ?>'); return false;"><?php echo $vars['entity']->title; ?></a>
   	<a name="<?php echo $post->id; ?>"></a>
   	<div class="post_icon" style="float:right"><?php echo elgg_view("profile/icon",array('entity' => $post_owner, 'size' => 'small')) ?></div>
   	<div class="clearFloat"></div>
                <?php
                    //get infomation about the owner of the comment
                    if ($post_owner = get_user($post->owner_guid)) {
                        
                       echo "<p><b>" . $post_owner->name . "</b><br />";
                        
                    } else {
                    	echo "<div class=\"post_icon\"><img src=\"" . elgg_view('icon/user/default/small') . "\" /></div>";
                    	echo "<p><b>" . elgg_echo('profile:deleteduser') . "</b><br />";
                    }
            
                   //display the actual message posted
                   echo parse_urls(elgg_view("output/longtext",array("value" => elgg_get_excerpt($post->value, 200))));
                ?>		
</div><!-- end the topic_post -->
<?php		
	if ($vars['current'] === true) {
?>
<script language="javascript">
javascript:loadContent('#discussion','<?php echo $vars['url'] ?>/mod/enlightn/ajax/discussion.php?discussion_id=<?php echo $vars['entity']->guid; ?>');
</script>
<?php
	}
?>