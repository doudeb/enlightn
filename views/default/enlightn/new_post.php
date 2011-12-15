            <div class="forward" id="forwardActionButton">
                <span class="forwardMessage"><?php echo elgg_echo("enlightn:selectparttoforward"); ?></span>
                <button type="reset" class="submit" id="forwardCancel"><?php echo elgg_echo("enlightn:buttoncancel"); ?></button>
                <button type="submit" class="submit" id="forwardParts"><?php echo elgg_echo('enlightn:buttonforward'); ?></button>
            </div>
            <div id="new-post" class="fixed">
				<form id="add_post" action="<?php echo $vars['url']; ?>action/enlightn/addpost" enctype="multipart/form-data" method="post">
					<?php
					$url_cloud = $vars['url'] . 'enlightn/cloud/' . $vars['entity']->guid . '/new_post';
					echo elgg_view('input/longtext',array('internalname' => 'new_post',
										'internalid' => 'new_post'
										, 'url_cloud' => $url_cloud)); ?>
					<input type="hidden" name="topic_guid" value="<?php echo $vars['entity']->guid; ?>" />
					<input type="hidden" name="group_guid" value="<?php echo $vars['entity']->container_guid; ?>" />
					<?php echo elgg_view('input/securitytoken'); ?>
					<!-- display the post button -->
					<div id="submission"></div>
                    <div class="sending">
                        <input class="checkbox" type="checkbox" id="autoReply"/><span class="reply ico"></span>
                        <button type="submit" class="submit"><?php echo elgg_echo('enlightn:buttonsend'); ?></button>
                    </div>
				</form>
			</div>
<script>
	$(document).ready(function() {
	    var options = {
	        target:        '#submission',   // target element(s) to be updated with server response
	        beforeSubmit:  loadingNewPost,  // pre-submit callback
	        success:       autoCloseNewPost,  // post-submit callback
	        // other available options:
	        //url:       url         // override for form's 'action' attribute
	      	type:      'post',        // 'get' or 'post', override for form's 'method' attribute
	        dataType:  'json',        // 'xml', 'script', or 'json' (expected server response type)
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

	function loadingNewPost () {
		$('#submission').prepend('<img src="<?php echo $vars['url'] ?>/mod/enlightn/media/graphics/loading.gif" alt="loading">');
		return true;
	}

	function autoCloseNewPost (data) {
        if(data.success) {
            $(".rte-zone").contents().find(".frameBody").html('');
            $(".rte-zone").contents().find(".frameBody").css('height','85');
            $("#post .textarea").css('height','85');
            $(".rte-zone").contents().find(".frameBody").focus();
            $('#submission').html('');
            loadContent('#discussion_list_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/search.php'  + get_search_criteria());
            return true;
       } else {
            $('#submission').html(data.message);
       }
	}
</script>