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
 * @uses $vars['name'] The name of the input field
 * @uses $vars['id'] The id of the input field
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
	$("<?php echo isset($vars['id'])?'#'.$vars['id']:'textarea[name=' .$vars['name'] .']'?>").rte({
    	content_css_url: "<?php echo $vars['url']; ?>css/elgg.<?php echo $vars['config']->lastcache; ?>.css?viewtype=<?php echo $vars['view']; ?>",
    	media_url: "<?php echo $vars['url']; ?>mod/enlightn/media/graphics/"
	});
});
</script>
<div id="post" class="open">
	<div class="textarea">
		<textarea class="<?php echo $class; ?>" name="<?php echo $vars['name']; ?>" <?php if (isset($vars['id'])) echo "id=\"{$vars['id']}\""; ?> <?php if ($disabled) echo ' disabled="yes" '; ?> <?php echo $vars['js']; ?>><?php echo htmlentities($value, ENT_QUOTES, 'UTF-8'); ?></textarea>
	</div>
</div>