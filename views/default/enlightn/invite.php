<script>
	$(document).ready(function() {
	    var options = {
	        target:        '#invite_submission',   // target element(s) to be updated with server response
	        beforeSubmit:  showLoading,  // pre-submit callback
	        success:       autoClose,  // post-submit callback
	        // other available options:
	        //url:       url         // override for form's 'action' attribute
	      	type:      'post',        // 'get' or 'post', override for form's 'method' attribute
	        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type)
	        clearForm: true,        // clear all form fields after successful submit
	        resetForm: true        // reset the form after successful submit
	        // $.ajax options can be used here too, for example:
	        //timeout:   3000
	    };
	    // bind to the form's submit event
	    $('#invite_form').submit(function() {
	        $(this).ajaxSubmit(options);
	        return false;
	    });
	});

	function showLoading () {
		javascript:$('#invite_submission').prepend('<img src="<?php echo $vars['url'] ?>/mod/enlightn/media/graphics/loading.gif" alt="loading">');
		return true;
	}

	function autoClose () {
		return true;*
	}
</script>
<?php
$is_owner		= $vars['user_guid'] == $vars['entity']->owner_guid; 
if ($is_owner) { ?>
<div id="discussion_invite">
	<?php echo elgg_echo('enlightn:discussioninvite');?>
	<form action="<?php echo $vars['url']; ?>action/enlightn/invite" enctype="multipart/form-data" method="post" id="invite_form">
	<?php echo elgg_view('input/securitytoken'); ?>
	<?php echo elgg_view("enlightn/helper/adduser",array(
													'internalname' => 'invite',
													'value' => $vars['entity']->invite)); ?>
	<input type="hidden" name="discussion_guid" value="<?php echo $vars['entity']->getGUID(); ?>" />
	<input type="submit" class="submit_button" value="<?php echo elgg_echo("send"); ?>" />
	
	</form>
	<div id="invite_submission"></div>
</div>
<?php } ?>