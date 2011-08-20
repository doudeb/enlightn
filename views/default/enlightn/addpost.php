<?php

	/**
	 * Elgg group forum post edit/add page
	 *
	 * @package ElggGroups
	 *
	 * @uses $vars['entity'] Optionally, the post to edit
	 */

?>
	<form action="<?php echo $vars['url']; ?>action/enlightn/addpost" method="post">
		<div class="member_icon"><a href="<?php echo $vars['owner']->getURL(); ?>"><?php echo elgg_view("profile/icon",array('entity' => $vars['owner'], 'size' => 'small', 'override' => 'true')) ?></a></div>
		<textarea onfocus="$('#reply').slideToggle('fast');$(this).css('display','none');" rows="1" cols="30"></textarea>
		<div class="collapsible_box" id="reply">
			<p class="longtext_editarea">
				<?php

					echo elgg_view("input/longtext",array(
										"internalname" => "topic_post"
										,"internalid" => "topic_post"));
				?>
			</p>
			<p>
			    <!-- pass across the topic guid -->
				<input type="hidden" name="topic_guid" value="<?php echo $vars['entity']->guid; ?>" />
				<input type="hidden" name="group_guid" value="<?php echo $vars['entity']->container_guid; ?>" />

	<?php
			echo elgg_view('input/securitytoken');
	?>
				<!-- display the post button -->
				<input type="submit" class="submit_button" value="<?php echo elgg_echo('enlightn:post'); ?>" />
			</p>
		</div>
	</form>