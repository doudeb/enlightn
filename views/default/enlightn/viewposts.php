<?php

    /**
	 * Elgg groups plugin display topic posts
	 *
	 * @package ElggGroups
	 */
?>
<div id="elgg_topbar_container_search"><?php echo elgg_view('page_elements/searchbox'); ?></div>
<div class="clearfloat"></div>
<div id="topic_posts"><!-- open the topic_posts div -->
<?php
	//mark the discsussion as read
	if(!check_entity_relationship($vars['user_guid'], ENLIGHTN_READED,$vars['entity']->guid)) {
		add_entity_relationship($vars['user_guid'], ENLIGHTN_READED,$vars['entity']->guid);
	}
	$is_favorite 	= check_entity_relationship($vars['user_guid'], ENLIGHTN_FAVORITE,$vars['entity']->guid);
	$url_favorite	= elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/favorite?discussion_guid={$vars['entity']->guid}");
	$is_owner		= $vars['user_guid'] == $vars['entity']->owner_guid; 
    //display follow up comments
    $count 			= $vars['entity']->countAnnotations('group_topic_post');
    $offset 		= (int) get_input('offset',0);

    $baseurl 		= $vars['entity']->getURL();
    echo elgg_view('navigation/pagination',array(
    												'limit' => 50,
    												'offset' => $offset,
    												'baseurl' => $baseurl,
    												'count' => $count,
    											));?>
<!-- grab the topic title -->
    <div id="topic_header">
    	<h2><?php echo $vars['entity']->title; ?></h2>
    	<img src="<?php echo $vars['url']; ?>/mod/enlightn/media/graphics/cleardot.gif" class="<?php echo $is_favorite?'favorite':'add_to_favorite'?>" id="favorite<?php echo $vars['entity']->id; ?>"/>
    	<div id="load_favorite<?php echo $vars['entity']->id; ?>"></div>
<script language="javascript">
$("#favorite<?php echo $vars['entity']->id; ?>").click( function(){
	if ($("#favorite<?php echo $vars['entity']->id; ?>").hasClass("favorite")) {
		loadContent('#load_favorite<?php echo $vars['entity']->id; ?>','<?php echo $url_favorite?>');
		$("#favorite<?php echo $vars['entity']->id; ?>").addClass("add_to_favorite");
		$("#favorite<?php echo $vars['entity']->id; ?>").removeClass("favorite");
	} else {
		loadContent('#load_favorite<?php echo $vars['entity']->id; ?>','<?php echo $url_favorite?>');
		$("#favorite<?php echo $vars['entity']->id; ?>").addClass("favorite");	
		$("#favorite<?php echo $vars['entity']->id; ?>").removeClass("add_to_favorite");	
	}
});


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
<?php if ($is_owner) { ?>
<a href="<?php echo $vars['url']; ?>/mod/enlightn/ajax/discussion_invite.php?discussion_guid=<?php echo $vars['entity']->guid ?>" class="popin-discussion-invite"><?php echo elgg_echo('enlightn:discussioninvite');?></a>
<?php } 
    $members = get_discussion_members($vars['entity']->guid,12);
    foreach($members as $mem) {

        echo "<div class=\"member_icon\"><a href=\"".$mem->getURL()."\">" . elgg_view("profile/icon",array('entity' => $mem, 'size' => 'tiny', 'override' => 'true')) . "</a></div>";

    }
	echo "<div class=\"clearfloat\"></div>";
?>
    </div>
<?php

	// check to find out the status of the topic and act
    if($vars['entity']->status != "closed" /*&& page_owner_entity()->isMember($vars['user'])*/){

        //display the add comment form, this will appear after all the existing comments
	    echo elgg_view("enlightn/addpost", array('entity' => $vars['entity']
	    											, 'owner' => $vars['owner']));

    } elseif($vars['entity']->status == "closed") {

        //this topic has been closed by the owner
        echo "<h2>" . elgg_echo("groups:topicisclosed") . "</h2>";
        echo "<p>" . elgg_echo("groups:topiccloseddesc") . "</p>";

    }

	//must add this view, in order to make facebox reading...
	echo elgg_view('metatags',$vars);
    foreach($vars['entity']->getAnnotations('', 50, $offset, "desc") as $post) {
    	if(!check_entity_relationship($vars['user_guid'], ENLIGHTN_READED,$post->id)) {
    		add_entity_relationship($vars['user_guid'], ENLIGHTN_READED,$post->id);
    	}
    	//var_dump($post);
	    echo elgg_view("enlightn/topicpost",array('entity' => $post));
	}
?>
</div>