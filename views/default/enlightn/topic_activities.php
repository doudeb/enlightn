<?php
$activity_stream  = array();
if (is_array($vars['activities'])) {
	foreach ($vars['activities'] as $activity_type=>$activity) {
        foreach ($activity as $key=>$relation_ship) {
            $user = get_entity($relation_ship->guid_one);
            $activity_stream[$activity_type][] = "<a href=\"{$user->getURL()}\">{$user->name}</a>";
            //$activity_stream .= elgg_echo('enlightn:activity:'.$activity->relationship);
            //$activity_stream .= " " . elgg_view_friendly_time($activity->time_created);
            //$activity_stream .= "<li class=\"join\"></li>";
        }
	}
}

foreach ($activity_stream as $activity_type=>$users_link) {
    echo '<li class="join">' . implode(', ', $activity_stream[$activity_type]) . elgg_echo('enlightn:activity:'.$activity_type) . '</li>';
}
