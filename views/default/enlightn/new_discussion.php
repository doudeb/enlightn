   <div id="page">
        <div id="main">

            <div id="post">
                <img class="photo" src="<?php echo $vars['user_ent']->getIcon('small')?>" />
                <div class="status-box"><?php echo elgg_echo('enlightn:newpost')?></div>
               	<?php echo elgg_view('enlightn/discussion_edit',array()); ?>
            </div>
<script>
$(document).ready(function(){
	$('.status-box').click( function(){
		$('#post').addClass('open');
	});
	$('#close_new_discussion').click( function(){
		$('#post').removeClass('open');
	});
});
</script>