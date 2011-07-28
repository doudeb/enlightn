<?php
if (is_array($vars['activities'])) {
	$activity_stream = '';
	foreach ($vars['activities'] as $time_created=>$activity) {
		$activity = $activity[key($activity)];
		$user = get_entity($activity->guid_one);
		$activity_stream .= "<li class=\"join\"><a href=\"{$user->getURL()}\">{$user->name}</a>";
		$activity_stream .= "<span class=\"ico\"></span> " . elgg_echo('enlightn:activity:'.$activity->relationship);
		$activity_stream .= " " . elgg_view_friendly_time($activity->time_created);
		$activity_stream .= "</li>";
	}
}
echo $activity_stream;
