<?php
/**
 * Any comment on original post
 */

	$performed_by = get_entity($vars['item']->subject_guid);
	$object = get_entity($vars['item']->object_guid);

	$forumtopic = $object->guid;
	$group_guid = $object->container_guid;
	//grab the annotation, if one exists
	if($vars['item']->annotation_id != 0) {
		$comment = false;//elgg_get_annotation_from_id($vars['item']->annotation_id)->value;
	}
	$comment = strip_tags($comment);//this is so we don't get large images etc in the activity river
	$url = $object->getURL();
	$url_post = '<a href="' . $vars['url'] . 'pg/enlightn/discuss/' .$object->guid .'">';
	//var_dump($url_post);
	$url_user = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";
	$string = sprintf(elgg_echo("enlightn:river:posted"),$url_user) . " ";
	$string .= elgg_echo("enlightn:river:annotate:create") . " | " . $url_post . $object->title . "</a>";
	if ($comment) {
		$string .= "<div class=\"river_content_display\">";
		$string .= elgg_get_excerpt($comment, 200);
		$string .= "</div>";
	}

	echo $string;
?>