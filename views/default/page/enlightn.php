<?php
/**
 * Elgg pageshell
 * The standard HTML page shell that everything else fits into
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['config'] The site configuration settings, imported
 * @uses $vars['title'] The page title
 * @uses $vars['body'] The main content of the page
 * @uses $vars['messages'] A 2d array of various message registers, passed from system_messages()
 */

// Set the content type
header("Content-type: text/html; charset=UTF-8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<?php

// Set title
if (empty($vars['title'])) {
	$title = $vars['config']->sitename;
} else if (empty($vars['config']->sitename)) {
	$title = $vars['title'];
} else {
	$title = $vars['config']->sitename . ": " . $vars['title'];
}
echo elgg_view('page/elements/head', $vars);
//echo elgg_view('page_elements/header', $vars);
?>
	<div class="elgg-page-messages">
		<?php echo elgg_view('page/elements/messages', array('object' => $vars['sysmessages'])); ?>
	</div>
<?php
if (elgg_get_context() === 'main') {
    echo $vars['body'];

    return;
}

if (elgg_get_context() !== 'cloud_embed') {
	echo elgg_view('page_elements/header_contents', $vars);
}
?>
<div id="page">
<!-- main contents -->
<?php

echo $vars['body']; ?>
</div><!-- end div id page-->
<!-- footer -->
<?php
if (elgg_get_context() !== 'cloud_embed') {
	echo elgg_view('page_elements/footer', $vars);
}
?>