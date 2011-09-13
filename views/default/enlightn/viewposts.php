<?php

    /**
	 * Elgg groups plugin display topic posts
	 *
	 * @package ElggGroups
	 */
//display follow up comments
$offset 		= (int) get_input('offset',0);
?>
<div id="topic_posts"><!-- open the topic_posts div -->
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