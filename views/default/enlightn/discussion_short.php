<?php

    /**
	 * Elgg groups plugin display topic posts
	 * 
	 * @package ElggGroups
	 */

?>
  
    <!-- grab the topic title -->
<div id="content_area_group_title"><h2><a href="" onclick="javascript:$('#discussion').load('<?php echo $vars['url'] ?>/mod/enlightn/ajax/discussion.php?discussion_id=<?php echo $vars['entity']->guid; ?>'); return false;"><?php echo $vars['entity']->title; ?></a></h2></div>
<?php
											
    foreach($vars['entity']->getAnnotations('', 1, 0, "desc") as $post) {


	/**
	 * Elgg Topic individual post view. This is all the follow up posts on a particular topic
	 * 
	 * @package ElggGroups
	 * 
	 * @uses $vars['entity'] The posted comment to view
	 */
	 
?>

	<div class="topic_post"><!-- start the topic_post -->
	
	    <table width="100%">
            <tr>
                <td>
                	<a name="<?php echo $post->id; ?>"></a>
                    <?php
                        //get infomation about the owner of the comment
                        if ($post_owner = get_user($post->owner_guid)) {
	                        
	                        //display the user icon
	                        echo "<div class=\"post_icon\">" . elgg_view("profile/icon",array('entity' => $post_owner, 'size' => 'small')) . "</div>";
	                        
	                        //display the user name
	                        echo "<p><b>" . $post_owner->name . "</b><br />";
	                        
                        } else {
                        	echo "<div class=\"post_icon\"><img src=\"" . elgg_view('icon/user/default/small') . "\" /></div>";
                        	echo "<p><b>" . elgg_echo('profile:deleteduser') . "</b><br />";
                        }
                        
                        //display the date of the comment
                        echo "<small>" . elgg_view_friendly_time($post->time_created) . "</small></p>";
                    ?>
                </td>
                <td width="70%">       
                    <?php
                        //display the actual message posted
                       echo parse_urls(elgg_view("output/longtext",array("value" => elgg_get_excerpt($post->value, 200))));
                    ?>
                </td>
            </tr>
        </table>		
	</div><!-- end the topic_post -->	     
<?php		
	}
	if ($vars['current'] === true) {
?>
<script language="javascript">
$('#discussion').load('<?php echo $vars['url'] ?>/mod/enlightn/ajax/discussion.php?discussion_id=<?php echo $vars['entity']->guid; ?>');
</script>
<?php
	}
?>