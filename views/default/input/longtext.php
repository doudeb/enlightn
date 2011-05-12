<?php
/**
 * Elgg long text input
 * Displays a long text input field
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['value'] The current value, if any - will be html encoded
 * @uses $vars['js'] Any Javascript to enter into the input tag
 * @uses $vars['internalname'] The name of the input field
 * @uses $vars['internalid'] The id of the input field
 * @uses $vars['class'] CSS class
 * @uses $vars['disabled'] Is the input field disabled?
 */

$class = "input-textarea";
if (isset($vars['class'])) {
	$class = $vars['class'];
}

$disabled = false;
if (isset($vars['disabled'])) {
	$disabled = $vars['disabled'];
}

$value = '';
if (isset($vars['value'])) {
	$value = $vars['value'];
}
?>
<script type="text/javascript">
	$().ready(function() {
		$('#<?php echo $vars['internalid']?>').tinymce({
			// Location of TinyMCE script
			script_url : '<?php echo $vars['url']; ?>mod/enlightn/media/js/tinymce/tiny_mce.js',
			mode : "specific_textareas",
			editor_selector : "mceEditor",
			theme : "advanced",
			relative_urls : false,
			theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,bullist,numlist,undo,redo,link,unlink,image,blockquote,code",
			theme_advanced_buttons2 : "",
			theme_advanced_buttons3 : "",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "none",
			theme_advanced_resizing : true,
			extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|style],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"
		});
	});
	
	function getCurrentImage() {
		return $('#imagePreview').attr('src');
	}

	function refreshInput(mediaType) {
		if (mediaType == 'url') {
			var strPut = '<div class="images"><img src="' + getCurrentImage()+ '" width="100"></div><div class="info">'+ $('#fetchResult').html() + '</div>';
		} else if (mediaType == 'media') {
			var strPut = $('#fetch_results').html();
		}
		$('#embedContent').val(strPut);
	}

	function changePublishSettings (currElement, destElement) {
		if (currElement == '#publish_text') {
			$('#result_embed').css('display', 'none');
		} else {
			$('#result_embed').css('display', 'block');
		}
		$(currElement).addClass('selected');
		$(destElement).css('display', 'block');
		$("#publish_selector li").each(function () {
			if($(this).attr('id') != $(currElement).attr('id')) {
				$(this).removeClass('selected');
			}
      	});
		$("#publish_input div").each(function () {
			if($(this).attr('id') != $(destElement).attr('id') && $(this).attr('id').indexOf("publish_") != -1) {
				$(this).css('display', 'none');
			}
      	});
	}

	$(document).ready(function(){
		$('#attach_media').click( function(){
			loadContent("#result_embed",'<?php echo $vars['url'] ?>/mod/enlightn/ajax/fetch_media.php?url='+ $("#url_media").val());
		});
	});

	$(document).ready(function(){
		$('#attach_url').click( function(){
			loadContent("#result_embed",'<?php echo $vars['url'] ?>/mod/enlightn/ajax/fetch_url.php?url='+ $("#url").val());
		});
	});
	
function extractUrl(s) {
	var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
	var url =  s.match(regexp);
	return url;
}	
	
	var refreshId = setInterval(function() {
		if ($('#<?php echo $vars['internalid']?>').val()) {
			url = extractUrl($('#<?php echo $vars['internalid']?>').val());
	    	if(url && url[0] != $('#lastExtractedUrl').val()) {
	    		$('#lastExtractedUrl').val(url[0]);
	    		loadContent("#result_embed",'<?php echo $vars['url'] ?>/mod/enlightn/ajax/fetch_media.php?url='+ url[0]);
	    	}			
		}
	}, 3000);	
	
</script>
<!--
<div id="elgg_horizontal_tabbed_nav">
	<ul id="publish_selector">
		<li id="publish_text" class="selected"><a onclick="changePublishSettings('#publish_text','#publish_text_input'); return false;" href="?display="><?php echo elgg_echo('enlightn:publishtext'); ?></a></li>
		<li id="publish_url"><a onclick="changePublishSettings('#publish_url','#publish_url_input'); return false;" href="#"><?php echo elgg_echo('enlightn:publishurl'); ?></a></li>
		<li id="publish_media"><a onclick="changePublishSettings('#publish_media','#publish_media_input'); return false;" href="?display=friends"><?php echo elgg_echo('enlightn:publishmedia'); ?></a></li>
	</ul>
</div>
-->
<div id="publish_input">
	<div id="publish_text_input">
		<textarea class="<?php echo $class; ?>" name="<?php echo $vars['internalname']; ?>" <?php if (isset($vars['internalid'])) echo "id=\"{$vars['internalid']}\""; ?> <?php if ($disabled) echo ' disabled="yes" '; ?> <?php echo $vars['js']; ?>><?php echo htmlentities($value, ENT_QUOTES, 'UTF-8'); ?></textarea>
		<input type="hidden" name="lastExtractedUrl" id="lastExtractedUrl" value="">
		<input type="hidden" name="embedContent" id="embedContent" value="">
	</div>
	<!--<div id="publish_url_input" style="display:none">
		<input type="text" name="url" size="64" id="url" />
		<input type="button" name="attach_url"  class="submit_button" value="<?php echo elgg_echo("enlightn:attachtopost") ?>" id="attach_url" />
	</div>
	<div id="publish_media_input" style="display:none">
		<input type="text" name="url" size="64" id="url_media" />
		<input type="button" name="attach" class="submit_button" value="<?php echo elgg_echo("enlightn:attachtopost") ?>" id="attach_media" />
	</div>-->
</div>
<div id="result_embed"></div>