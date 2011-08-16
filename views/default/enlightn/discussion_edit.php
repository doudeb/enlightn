<?php
	/**
	 * Elgg groups plugin
	 *
	 * @package ElggGroups
	 */

	// new groups default to open membership

?>
	<form id="discussion_edit" action="<?php echo $vars['url']; ?>action/enlightn/edit" enctype="multipart/form-data" method="post">
		<span id="close_new_discussion" class="mini-close"/></span>
		<?php echo elgg_view('input/securitytoken'); ?>
		<div class="privacy private">
			<span class="private-val value"><span class="ico"></span><?php echo elgg_echo('private') ?></span>

			<span class="cursor" id="privacy_cursor"></span>
			<span class="public-val value"><?php echo elgg_echo('public') ?></span>
			<?php echo elgg_view("input/hidden",array(
									'internalname' => 'membership',
									'internalid' => 'membership',
									'value' => ACCESS_PRIVATE)); ?>
		</div>
		<input class="title" type="text" name="title" id="title" placeholder="<?php echo elgg_echo("enlightn:title") ?>" value="" />
		<?php echo elgg_view("input/longtext",array(
								'internalname' => 'description',
								'internalid' => 'description',
								'value' => $vars['entity']->description)); ?>
        <div class="dest">
            <label><?php echo elgg_echo("enlightn:to") ?> :</label>
            <?php echo elgg_view("enlightn/helper/adduser",array(
																'internalname' => 'invite',
																'internalid' => 'invite',
																'value' => $vars['entity']->invite,
																)); ?>
        </div>
        <div class="tags">
            <span class="add">
                <span class="ico"></span>
                <span class="caption"><?php echo elgg_echo("enlightn:tags") ?></span>
                <?php echo elgg_view("input/tags",array(
													'internalname' => 'interests',
													'internalid' => 'interests',
													'value' => $vars['entity']->interests,
													)); ?>
            </span>
        </div>
        <div class="sending">

            <button type="submit" class="submit"><?php echo elgg_echo("post"); ?></button>
        </div>
		<div id="submission"></div>
	</form>
	<script type="text/javascript">
	// prepare the form when the DOM is ready
	$(document).ready(function() {
	    var options = {
	        target:        '#submission',   // target element(s) to be updated with server response
	        beforeSubmit:  showLoading,  // pre-submit callback
	        success:       autoClose,  // post-submit callback

	        // other available options:
	        //url:       url         // override for form's 'action' attribute
	      	type:      'post',        // 'get' or 'post', override for form's 'method' attribute
	        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type)
	        clearForm: true        // clear all form fields after successful submit
	        //resetForm: true        // reset the form after successful submit

	        // $.ajax options can be used here too, for example:
	        //timeout:   3000
	    };

	    // bind to the form's submit event
	    $('#discussion_edit').submit(function() {
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
		$('#post').removeClass('open');
		return true;
	}
	// pre-submit callback
	function showRequest(formData, jqForm, options) {
	    // formData is an array; here we use $.param to convert it to a string to display it
	    // but the form plugin does this for you automatically when it submits the data
	    var queryString = $.param(formData);

	    // jqForm is a jQuery object encapsulating the form element.  To access the
	    // DOM element for the form do this:
	    // var formElement = jqForm[0];

	    alert('About to submit: \n\n' + queryString);
	    // here we could return false to prevent the form from being submitted;
	    // returning anything other than false will allow the form submit to continue
	    return true;
	}

	// post-submit callback
	function showResponse(responseText, statusText, xhr, $form)  {
	    // for normal html responses, the first argument to the success callback
	    // is the XMLHttpRequest object's responseText property

	    // if the ajaxSubmit method was passed an Options Object with the dataType
	    // property set to 'xml' then the first argument to the success callback
	    // is the XMLHttpRequest object's responseXML property

	    // if the ajaxSubmit method was passed an Options Object with the dataType
	    // property set to 'json' then the first argument to the success callback
	    // is the json data object returned by the server

	    //alert('status: ' + statusText + '\n\nresponseText: \n' + responseText +
	    //    '\n\nThe output div should have already been updated with the responseText.');
	    popin.PPNclose();
		//return false;
	}
	function autoClose () {
		$('#post').removeClass('open');
		//changeMessageList('#discussion_selector_all');
	}
    </script>