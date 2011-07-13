   <div id="page">
        <div id="main">

            <div id="post">
                <img class="photo" src="<?php echo $vars['user_ent']->getIcon('small')?>" />
                <div class="status-box">
                	<div id="fake_input"><?php echo elgg_echo('enlightn:newpost')?></div>
                	<div id="edit_discussion"><?php echo elgg_view('enlightn/discussion_edit',array()); ?></div>
                </div>
            </div>
<script>
$(document).ready(function(){
	$('#fake_input').click( function(){
		$('#fake_input').fadeOut();
		$(".status-box").css('height','350px');
		$('#edit_discussion').fadeIn();
	});
});
$(document).ready(function(){
	$('#close_new_discussion').click( function(){
		$('#edit_discussion').fadeOut();
		$(".status-box").css('height','36px');
		$('#fake_input').fadeIn();
	});
});
</script>