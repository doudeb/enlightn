<?php
/**
 * Elgg calendar input
 * Displays a calendar input field
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['value'] The current value, if any
 * @uses $vars['name'] The name of the input field
 *
 */
?>
<script>
	$(function() {
		$( "#<?php echo $vars['name']?>" ).datepicker({
			dateFormat: 'yy-mm-dd',
			showButtonPanel: true,
			showOn: "button",
			buttonImage: "<?php echo $vars['url']; ?>mod/enlightn/media/graphics/calendar.gif",
			buttonImageOnly: true			
		});
	});
</script>
<input type="text" name="<?php echo $vars['name']; ?>" id="<?php echo $vars['name']; ?>" value="<?php echo $val; ?>" />