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

// Set title
if (empty($vars['title'])) {
	$title = $vars['config']->sitename;
} else if (empty($vars['config']->sitename)) {
	$title = $vars['title'];
} else {
	$title = $vars['config']->sitename . ": " . $vars['title'];
}
echo elgg_view('page_elements/header', $vars);
if (get_context() === 'main') {
    echo $vars['body'];
    return;
}
echo elgg_view('page_elements/elgg_topbar', $vars);

if (get_context() !== 'cloud_embed') {
	echo elgg_view('page_elements/header_contents', $vars);
}

echo elgg_view('messages/list', array('object' => $vars['sysmessages'])); ?>
<div id="page">
<!-- main contents -->


<!-- canvas -->
<?php echo $vars['body']; ?>
</div><!-- end div id page-->
<!-- footer -->
<?php
if (get_context() !== 'cloud_embed') {
	echo elgg_view('page_elements/footer', $vars);
}
?>