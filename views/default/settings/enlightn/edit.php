<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/enlightn/media/js/farbtastic.js"></script>
<link rel="stylesheet" href="<?php echo $vars['url']; ?>mod/enlightn/media/css/farbtastic.css" type="text/css" />
<p><?php
$shinx_enabled = $vars['entity']->sphinx_enabled=='1'?'1':'0';
echo  elgg_echo('enlightn:sphinx_enabled') . ' : <br />';
		echo elgg_view('input/radio', array(
			'internalname' => 'params[sphinx_enabled]',
			'options' => array(
				elgg_echo('option:no') => '0',
				elgg_echo('option:yes')=>'1'
			),
			'value' => $shinx_enabled
		));
?>
</p>
<p>
<?php
$css_sidebar_folders = $vars['entity']->css_sidebar_folders!=''?$vars['entity']->css_sidebar_folders:'#2D87E1';
echo  elgg_echo('enlightn:css_sidebar_folders') . ' : <br />';
		echo elgg_view('input/colorpicker', array(
			'internalname' => 'params[css_sidebar_folders]',
			'internalid' => 'css_sidebar_folders',
			'value' => $css_sidebar_folders
		));
?>
</p>