<div id="new_discussion" class="box_wrapper">
	<div class="member_icon"><a href="<?php echo $vars['user_ent']->getURL(); ?>"><?php echo elgg_view("profile/icon",array('entity' => $vars['user_ent'], 'size' => 'small', 'override' => 'true')) ?></a>
		<div class="floating_left" id="fake_input"><?php echo elgg_view("input/text",array(
									'internalname' => 'fake_input',
									'internalid' => 'fake_input'
									)); ?></div>
		<div class="floating_left" id="edit_discussion"><?php echo elgg_view('enlightn/discussion_edit',array()); ?></div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('#fake_input').click( function(){
		$('#fake_input').fadeOut();
		$('#edit_discussion').fadeIn();
	});
});
$(document).ready(function(){
	$('#close_new_discussion').click( function(){
		$('#edit_discussion').fadeOut();
		$('#fake_input').fadeIn();
	});
});
</script>