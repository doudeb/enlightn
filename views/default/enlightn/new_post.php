			<div id="new-post" class="fixed">
				<form id="add_post" action="<?php echo $vars['url']; ?>action/enlightn/addpost" enctype="multipart/form-data" method="post">
					<?php
					$url_cloud = $vars['url'] . 'pg/enlightn/cloud/' . $vars['entity']->guid . '/new_post';
					echo elgg_view('input/longtext',array('internalname' => 'new_post',
										'internalid' => 'new_post'
										, 'url_cloud' => $url_cloud)); ?>
					<input type="hidden" name="topic_guid" value="<?php echo $vars['entity']->guid; ?>" />
					<input type="hidden" name="group_guid" value="<?php echo $vars['entity']->container_guid; ?>" />
					<?php echo elgg_view('input/securitytoken'); ?>
					<!-- display the post button -->
					<div id="submission"></div>
                    <div class="sending">
                        <input class="checkbox" type="checkbox" /><span class="reply ico"></span>
                        <button type="submit" class="submit">Post</button>
                    </div>
				</form>
			</div>
<script>
$(document).ready(function(){
	$('#fake_input').click( function(){
		$('#fake_input').fadeOut();
		$('#edit_discussion').fadeIn();
		var iframeRte = document.getElementsByTagName('iframe');
		iframeRte[0].contentWindow.focus();
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
		$(".rte-zone").contents().find(".frameBody").html('');
        $("#post .textarea").css('height','85');
		return true;
	}
</script>