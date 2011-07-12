<?php
include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");


//Some basic var
gatekeeper();
$types = get_tags(0,10,'simpletype','object','file',$SESSION['user']->guid);
echo elgg_view('enlightn/cloud/tabs',array('tab' => 'media', 'internalname' => $vars['internalname']));?>
	<div id='mediaEmbed'>
<?php
echo elgg_view('enlightn/cloud/navigation',array());
echo elgg_view('enlightn/cloud/simpletype',array(
												'internalname' => $vars['internalname'],
												'simpletypes' => $types,
											));
echo elgg_view('enlightn/cloud/cloud_content',array('internal_id' => $internal_id));