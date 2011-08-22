<?php
$members = get_discussion_members($vars['entity']->entity_guid);
$i = 0;
$members_summary = array(0=>'');
foreach($members as $mem) {
	++$i;
	if ($mem->guid != $vars['entity']->owner_guid && $i <= $vars['limit']) {
		$members_summary[] =  $mem->name;
	}
}
echo implode(', ',$members_summary);
if (($i - $vars['limit']) > 0) {
	echo sprintf(elgg_echo('enlightn:andothers'),($i - $vars['limit']));
}
?>