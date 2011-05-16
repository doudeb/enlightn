<?php
/**
 * Elgg calendar input
 * Displays a calendar input field
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['value'] The current value, if any
 * @uses $vars['internalname'] The name of the input field
 *
 */
?>
<script>
	$(function() {
		$( "#<?php echo $vars['internalname']?>" ).datepicker({
			dateFormat: 'yy-mm-dd',
			showButtonPanel: true,
			showOn: "button",
			buttonImage: "<?php echo $vars['url']; ?>mod/enlightn/media/graphics/calendar.gif",
			buttonImageOnly: true			
		});
	});
</script>
<input type="text" name="<?php echo $vars['internalname']; ?>" id="<?php echo $vars['internalname']; ?>" value="<?php echo $val; ?>" />