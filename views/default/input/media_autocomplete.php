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
<div class="mediaAutocomplete">
<?php
echo elgg_view("enlightn/helper/adduser",array(
                                'placeholder' => elgg_echo(''),
                                'internalname' => 'mediaAutocomplete',
                                'internalid' => 'mediaAutocomplete',
                                'unique_id' => 'mediaAutocomplete')); ?>
</div>