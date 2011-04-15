<?php
include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");


//Some basic var
gatekeeper();
$user_guid = get_loggedin_userid();

//retreive last activity
$activity = elgg_view('enlightn/activity',array());
$body = $activity;
unset($activity);
//link for discussion creation
$discussion_new = elgg_view('enlightn/discussion_new',array());
$body .= $discussion_new;
unset($discussion_new);
//retreive last discussion subject
$discussion_list = elgg_view('enlightn/discussion_list',array('user_guid' => $user_guid
                                                    , 'discussion_items' => $discussion_items));

$body .= $discussion_list;
//Now lest's see what we are talking about
$discussion = elgg_view('enlightn/discussion',array());
$body .= $discussion;
page_draw(elgg_echo('enlightn:enlightn'),$body);

?>