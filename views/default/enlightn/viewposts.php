<?php

    /**
	 * Elgg groups plugin display topic posts
	 * 
	 * @package ElggGroups
	 */

?>

<div id="topic_posts"><!-- open the topic_posts div -->
  
<?php
    //display follow up comments
    $count = $vars['entity']->countAnnotations('group_topic_post');
    $offset = (int) get_input('offset',0);
    
    $baseurl = $vars['entity']->getURL();
    echo elgg_view('navigation/pagination',array(
    												'limit' => 50,
    												'offset' => $offset,
    												'baseurl' => $baseurl,
    												'count' => $count,
    											));

?>
    <!-- grab the topic title -->
        <div id="content_area_group_title">
        	<h2><?php echo $vars['entity']->title; ?></h2>
<script language="javascript">
$(document).ready(function() {
	$("a.popin-discussion-invite").popin({
		width:800,
		height:500,
		className: "mypopin3",
		loaderImg : '<?php echo $vars['url']; ?>/mod/enlightn/media/graphics/loading.gif',
		opacity: .6,
		onStart: function() {
			
		},
		onComplete: function() {
			
		},
		onExit: function() {
			
		}
	});
});
</script>
<a href="<?php echo $vars['url']; ?>/mod/enlightn/ajax/discussion_invite.php?discussion_guid=<?php echo $vars['entity']->guid ?>" class="popin-discussion-invite"><?php echo elgg_echo('enlightn:discussioninvite');?></a>
<?php
    $members = get_discussion_members($vars['entity']->guid,12);
    foreach($members as $mem) {
           
        echo "<div class=\"member_icon\"><a href=\"".$mem->getURL()."\">" . elgg_view("profile/icon",array('entity' => $mem, 'size' => 'tiny', 'override' => 'true')) . "</a></div>";   
           
    }
	echo "<div class=\"clearfloat\"></div>";
	/*$more_url = "{$vars['url']}pg/groups/memberlist/{$vars['entity']->guid}/";
	echo "<div id=\"groups_member_link\"><a href=\"{$more_url}\">" . elgg_echo('groups:members:more') . "</a></div>";*/

?>
        </div>
<?php
	// check to find out the status of the topic and act
    if($vars['entity']->status != "closed" /*&& page_owner_entity()->isMember($vars['user'])*/){
        
        //display the add comment form, this will appear after all the existing comments
	    echo elgg_view("enlightn/addpost", array('entity' => $vars['entity']));
	    
    } elseif($vars['entity']->status == "closed") {
        
        //this topic has been closed by the owner
        echo "<h2>" . elgg_echo("groups:topicisclosed") . "</h2>";
        echo "<p>" . elgg_echo("groups:topiccloseddesc") . "</p>";
        
    } 										
    foreach($vars['entity']->getAnnotations('group_topic_post', 50, $offset, "desc") as $post) {   		    
	     echo elgg_view("forum/topicposts",array('entity' => $post));	
	}
?>
</div>