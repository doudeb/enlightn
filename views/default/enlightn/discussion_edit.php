<?php
	/**
	 * Elgg groups plugin
	 *
	 * @package ElggGroups
	 */

	// new groups default to open membership

?>
<form id="discussion_edit" action="<?php echo $vars['url']; ?>action/enlightn/edit" enctype="multipart/form-data" method="post">

<div class="contentWrapper">

	<?php echo elgg_view('input/securitytoken'); ?>

			<?php echo elgg_echo("enlightn:to") ?><br />
			<?php echo elgg_view("enlightn/helper/adduser",array(
															'internalname' => 'invite',
															'internalid' => 'invite',
															'value' => $vars['entity']->invite,
															)); ?>
			<?php echo elgg_echo("groups:name") ?><br />
			<?php echo elgg_view("input/text",array(
															'internalname' => 'title',
															'internalid' => 'title',
															'value' => $vars['entity']->name,
															)); ?>
			<?php echo elgg_echo("groups:description") ?><br />
			<?php echo elgg_view("input/longtext",array(
															'internalname' => 'description',
															'internalid' => 'description',
															'value' => $vars['entity']->description,
															)); ?>

			<?php echo elgg_echo("groups:interests") ?><br />
			<?php echo elgg_view("input/tags",array(
															'internalname' => 'interests',
															'internalid' => 'interests',
															'value' => $vars['entity']->interests,
															)); ?>
			<?php echo elgg_echo('groups:visibility'); ?><br />
			<?php

			$this_owner = $vars['entity']->owner_guid;
			if (!$this_owner) {
				$this_owner = get_loggedin_userid();
			}

			$access = array(ACCESS_FRIENDS => elgg_echo("access:friends:label"), ACCESS_LOGGED_IN => elgg_echo("LOGGED_IN"), ACCESS_PUBLIC => elgg_echo("PUBLIC"), ACCESS_PRIVATE => elgg_echo("PRIVATE"));
			$collections = get_user_access_collections($vars['entity']->guid);
			if (is_array($collections)) {
				foreach ($collections as $c)
					$access[$c->id] = $c->name;
			}

			$current_access = ($vars['entity']->access_id ? $vars['entity']->access_id : ACCESS_PUBLIC);
			echo elgg_view('input/access', array(
												'internalid' => 'membership',
												'internalname' => 'membership',
												'value' =>  $current_access,
												'options' => $access));


			?>
		<?php
			if ($vars['entity'])
			{
		?>
		<input type="hidden" name="group_guid" value="<?php echo $vars['entity']->getGUID(); ?>" />
		<?php
			}
		?>
		<div id="discussion_close" style="float: right;"><input type="button" class="submit_button popin-close" value="<?php echo elgg_echo("close"); ?>" /></div>
		<div id="submission"><input type="submit" class="submit_button" value="<?php echo elgg_echo("save"); ?>" /></div>
</form>
<script type="text/javascript">
// prepare the form when the DOM is ready
$(document).ready(function() {
    var options = {
        target:        '#submission',   // target element(s) to be updated with server response
        beforeSubmit:  showLoading,  // pre-submit callback
        success:       showClose,  // post-submit callback

        // other available options:
        //url:       url         // override for form's 'action' attribute
      	type:      'post'        // 'get' or 'post', override for form's 'method' attribute
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type)
        //clearForm: true        // clear all form fields after successful submit
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
function showClose () {
	//$("#submission").append('<span class="popin-close">Sur un span</span>');
}

    </script>
</div>
<?php
if ($vars['entity']) {
?>
<div class="contentWrapper">
<div id="delete_group_option">
	<form action="<?php echo $vars['url'] . "action/groups/delete"; ?>">
		<?php
			echo elgg_view('input/securitytoken');
				$warning = elgg_echo("groups:deletewarning");
			?>
			<input type="hidden" name="group_guid" value="<?php echo $vars['entity']->getGUID(); ?>" />
			<input type="submit" name="delete" value="<?php echo elgg_echo('groups:delete'); ?>" onclick="javascript:return confirm('<?php echo $warning; ?>')"/>
	</form>
</div><div class="clearfloat"></div>
</div>
<?php
}
?>