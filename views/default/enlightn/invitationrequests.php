<div class="contentWrapper">

<?php

	if (!empty($vars['invitations']) && is_array($vars['invitations'])) {
		$user = get_loggedin_user();
		foreach($vars['invitations'] as $request) {
?>
	<div class="reportedcontent_content active_report">
		<div class="groups_membershiprequest_buttons">
			<?php
				echo "</a></div>{$request->title}<br />";

				echo str_replace('<a', '<a class="delete_report_button" ', elgg_view('output/confirmlink',array(
					'href' => $vars['url'] . "action/enlightn/killinvitation?user_guid={$user->getGUID()}&discussion_guid={$request->guid}",
					'confirm' => elgg_echo('groups:invite:remove:check'),
					'text' => elgg_echo('delete'),
				)));
			$url = elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/join?user_guid={$user->guid}&discussion_guid={$request->guid}");
			?>
			<a href="<?php echo $url; ?>" class="archive_report_button"><?php echo elgg_echo('accept'); ?></a>
			<br /><br />
		</div>
	</div>
<?php

			}
	}
?>
</div>
