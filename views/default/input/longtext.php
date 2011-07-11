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
<a class="embed_media" href="<?php echo $vars['url']; ?>/pg/enlightn/cloud" rel="facebox"><?php echo elgg_echo("enlightn:cloud"); ?></a>
<script type="text/javascript">
$(document).ready(function(){
	//var uEditor = initEditor();
	$(".rte-zone").rte({
    	content_css_url: "<?php echo $vars['url']; ?>mod/enlightn/media/css/rte.css",
    	media_url: "<?php echo $vars['url']; ?>mod/enlightn/media/graphics/",
	});
});
</script>
<div id="publish_input">
	<div id="publish_text_input">
		<textarea class="<?php echo $class; ?>" name="<?php echo $vars['internalname']; ?>" <?php if (isset($vars['internalid'])) echo "id=\"{$vars['internalid']}\""; ?> <?php if ($disabled) echo ' disabled="yes" '; ?> <?php echo $vars['js']; ?>><?php echo htmlentities($value, ENT_QUOTES, 'UTF-8'); ?></textarea>
	</div>
</div>
<div id="result_embed"></div>