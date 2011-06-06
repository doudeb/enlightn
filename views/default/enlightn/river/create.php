<?php
/**
 * First post on a topic
 */

	$performed_by = get_entity($vars['item']->subject_guid); // $statement->getSubject();
	$object = get_entity($vars['item']->object_guid);
	//$url = $object->getURL();
	$forumtopic = $object->guid;
	$group_guid = $object->container_guid;
	$url = $object->getURL();
	$url_post = '<a href="' . $vars['url'] . 'pg/enlightn/discuss/' .$object->guid .'">';
	$comment = false;//$object->getAnnotations("group_topic_post", 1, 0, "asc");
	$contents = false;
	if ($comment) {
		foreach ($comment as $c) {
			$contents = $c->value;
		}
	}
	$contents = strip_tags($contents);//this is so we don't get large images etc in the activity river
	$url_user = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";
	$string = sprintf(elgg_echo("enlightn:river:postedtopic"),$url_user) . ": ";
	$string .= $url_post . $object->title . "</a>";
	if ($contents) {
		$string .= "<div class=\"river_content_display\">";
		$string .= elgg_get_excerpt($contents, 200);
		$string .= "</div>";		
	}
	


	echo $string;
?>
