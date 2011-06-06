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

$class = "rte-zone";
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
$(document).ready(function(){
	//var uEditor = initEditor();
	$(".rte-zone").rte({
    	content_css_url: "<?php echo $vars['url']; ?>mod/enlightn/media/css/rte.css",
    	media_url: "<?php echo $vars['url']; ?>mod/enlightn/media/graphics/",
	});
});
$(document).ready(function(){
	var refreshId = setInterval(function() {
		var editor_value = $(".rte-zone").contents().find(".frameBody").html();
		if (editor_value) {
			url = extractUrl(editor_value);
	    	if(url && url[0] != $('#lastExtractedUrl').val()) {
	    		$('#lastExtractedUrl').val(url[0]);
	    		loadContent("#result_embed",'<?php echo $vars['url'] ?>/mod/enlightn/ajax/fetch_media.php?url='+ url[0]);
	    	}			
		}
	}, 3000);	

});
	function getCurrentImage() {
		return $('#imagePreview').attr('src');
	}

	function refreshInput(mediaType) {
		if (mediaType == 'url') {
			var strPut = '<div class="images"><img src="' + getCurrentImage()+ '" width="100"></div><div class="info">'+ $('#fetchResult').html() + '</div>';
			$("#discussion_subtype").val("<?php echo ENLIGHTN_LINK?>");
		} else if (mediaType == 'media') {
			var strPut = $('#fetch_results').html();
			$("#discussion_subtype").val("<?php echo ENLIGHTN_MEDIA?>");
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
</script>
<div id="publish_input">
	<div id="publish_text_input">
		<textarea class="<?php echo $class; ?>" name="<?php echo $vars['internalname']; ?>" <?php if (isset($vars['internalid'])) echo "id=\"{$vars['internalid']}\""; ?> <?php if ($disabled) echo ' disabled="yes" '; ?> <?php echo $vars['js']; ?>><?php echo htmlentities($value, ENT_QUOTES, 'UTF-8'); ?></textarea>
		<input type="hidden" name="lastExtractedUrl" id="lastExtractedUrl" value="">
		<input type="hidden" name="embedContent" id="embedContent" value="">
		<input type="hidden" name="discussion_subtype" id="discussion_subtype" value="<?php echo ENLIGHTN_DISCUSSION?>">
	</div>
</div>
<div id="result_embed"></div>