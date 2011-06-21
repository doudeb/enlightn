<div id="discussion_action" class="box_wrapper">
<?php
echo elgg_view("enlightn/follow", array('entity' => $vars['entity']
									, 'user_guid' => $vars['user_guid']));
echo elgg_view("enlightn/favorite", array('entity' => $vars['entity']
									, 'user_guid' => $vars['user_guid']));
echo elgg_view("enlightn/invite", array('entity' => $vars['entity']
									, 'user_guid' => $vars['user_guid']));
?>	                    
</div>