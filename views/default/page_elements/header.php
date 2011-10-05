<?php
/**
 * Elgg pageshell
 * The standard HTML header that displays across the site
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['config'] The site configuration settings, imported
 * @uses $vars['title'] The page title
 * @uses $vars['body'] The main content of the page
 */

// Set title
if (empty($vars['title'])) {
	$title = $vars['config']->sitename;
} else if (empty($vars['config']->sitename)) {
	$title = $vars['title'];
} else {
	$title = $vars['config']->sitename . ": " . $vars['title'];
}

global $autofeed;
if (isset($autofeed) && $autofeed == true) {
	$url = $url2 = full_url();
	if (substr_count($url,'?')) {
		$url .= "&view=rss";
	} else {
		$url .= "?view=rss";
	}
	if (substr_count($url2,'?')) {
		$url2 .= "&view=odd";
	} else {
		$url2 .= "?view=opendd";
	}
	$feedref = <<<END

	<link rel="alternate" type="application/rss+xml" title="RSS" href="{$url}" />
	<link rel="alternate" type="application/odd+xml" title="OpenDD" href="{$url2}" />

END;
} else {
	$feedref = "";
}

// we won't trust server configuration but specify utf-8
header('Content-type: text/html; charset=utf-8');

$version = get_version();
$release = get_version(true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="ElggRelease" content="<?php echo $release; ?>" />
	<meta name="ElggVersion" content="<?php echo $version; ?>" />
	<title><?php echo $title; ?></title>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/enlightn/media/js/jquery-1.6.1.min.js"></script>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/enlightn/media/js/jquery.form.js"></script>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>vendors/jquery/jquery-ui-1.7.2.min.js"></script>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>_css/js.php?lastcache=<?php echo $vars['config']->lastcache; ?>&js=initialise_elgg&viewtype=<?php echo $vars['view']; ?>"></script>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/enlightn/media/js/jquery.tokeninput.js"></script>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/enlightn/media/js/cal.js"></script>
<?php
	global $pickerinuse;
	if (isset($pickerinuse) && $pickerinuse == true) {
?>
	<!-- only needed on pages where we have friends collections and/or the friends picker -->
	<script type="text/javascript" src="<?php echo $vars['url']; ?>vendors/jquery/jquery.easing.1.3.packed.js"></script>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>_css/js.php?lastcache=<?php echo $vars['config']->lastcache; ?>&js=friendsPickerv1&viewtype=<?php echo $vars['view']; ?>"></script>
<?php
	}
?>
	<!-- include the default css file -->
	<link rel="stylesheet" href="<?php echo $vars['url']; ?>_css/css.css?lastcache=<?php echo $vars['config']->lastcache; ?>&viewtype=<?php echo $vars['view']; ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo $vars['url']; ?>mod/enlightn/media/css/token-input-facebook.css" type="text/css" />

	<?php
		echo $feedref;
		echo elgg_view('metatags',$vars);
	?>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
  		$('a[rel*=facebox]').facebox()
	});
	$(document).ready(function(){
		$('#search_submit').click( function(){
			<?php
				if (in_array(get_context(),array('cloud','cloud_embed'))) {
					echo "loadContent('#cloud_content','" . $vars['url'] . "mod/enlightn/ajax/get_my_cloud.php' + get_search_criteria() + '?context=" . get_context() . "');";
				} else {
					echo "changeMessageList('#discussion_selector_search'," .ENLIGHTN_ACCESS_AL.");";
				}
			?>
			return false;
		});
	});
	</script>
</head>

<body>