<?php echo elgg_view('metatags',$vars);
if (check_entity_relationship($vars['user_guid'], ENLIGHTN_FOLLOW, $vars['entity']->guid)) {
?>
<div id="new_discussion" class="box_wrapper">
		<div class="left" style="border:1px solid"><a href="<?php echo $vars['user_ent']->getURL(); ?>"><?php echo elgg_view("profile/icon",array('entity' => $vars['user_ent'], 'size' => 'small', 'override' => 'true')) ?></a></div>
		<div class="right"><?php echo elgg_view("input/text",array(
									'internalname' => 'fake_input',
									'internalid' => 'fake_input'
									)); ?></div>
		<div class="right" id="edit_discussion">
			<div id="pop_container_advanced">
				<div class="contentWrapper">
					<span id="close_new_discussion" class="mini-close"/></span>
					<form id="add_post" action="<?php echo $vars['url']; ?>action/enlightn/addpost" enctype="multipart/form-data" method="post">
					<?php echo elgg_view('input/longtext',array('internalname' => 'new_post',
										'internalid' => 'new_post')); ?>					
					<input type="hidden" name="topic_guid" value="<?php echo $vars['entity']->guid; ?>" />
					<input type="hidden" name="group_guid" value="<?php echo $vars['entity']->container_guid; ?>" />
					<?php echo elgg_view('input/securitytoken'); ?>
					<!-- display the post button -->
					<div id="submission"></div>
					<input type="submit" class="submit_button" value="<?php echo elgg_echo('post'); ?>" />
					</form>
				</div>
			</div>
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

	$(document).ready(function() {
	    var options = {
	        target:        '#submission',   // target element(s) to be updated with server response
	        beforeSubmit:  showLoading,  // pre-submit callback
	        success:       autoClose,  // post-submit callback
	        // other available options:
	        //url:       url         // override for form's 'action' attribute
	      	type:      'post',        // 'get' or 'post', override for form's 'method' attribute
	        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type)
	        clearForm: false,        // clear all form fields after successful submit
	        resetForm: false        // reset the form after successful submit
	        // $.ajax options can be used here too, for example:
	        //timeout:   3000
	    };
	    // bind to the form's submit event
	    $('#add_post').submit(function() {
	        // inside event callbacks 'this' is the DOM element so we first
	        // wrap it in a jQuery object and then invoke ajaxSubmit
	        $(this).ajaxSubmit(options);

	        // !!! Important !!!
	        // always return false to prevent standard browser submit and page navigation
	        return false;
	    });
	});

	function showLoading () {
		javascript:$('#submission').prepend('<img src="<?php echo $vars['url'] ?>/mod/enlightn/media/graphics/loading.gif" alt="loading">');
		return true;
	}

	function autoClose () {
		$('#edit_discussion').fadeOut();
		$('#fake_input').fadeIn();
		$(".rte-zone").contents().find(".frameBody").html('');
		$("#embedContent").val('');
		return true;
	}
</script>
<?php
}
?>