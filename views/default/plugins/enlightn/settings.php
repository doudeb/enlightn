<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/enlightn/media/js/farbtastic.js"></script>
<link rel="stylesheet" href="<?php echo $vars['url']; ?>mod/enlightn/media/css/farbtastic.css" type="text/css" />
<p><?php
$shinx_enabled = $vars['entity']->sphinx_enabled=='1'?'1':'0';
echo  elgg_echo('enlightn:sphinx_enabled') . ' : <br />';
		echo elgg_view('input/radio', array(
			'name' => 'params[sphinx_enabled]',
			'options' => array(
				elgg_echo('option:no') => '0',
				elgg_echo('option:yes')=>'1'
			),
			'value' => $shinx_enabled
		));
?>
</p>
<p><?php
$register_enabled = $vars['entity']->register_enabled=='1'?'1':'0';
echo  elgg_echo('enlightn:register_enabled') . ' : <br />';
		echo elgg_view('input/radio', array(
			'name' => 'params[register_enabled]',
			'options' => array(
				elgg_echo('option:no') => '0',
				elgg_echo('option:yes')=>'1'
			),
			'value' => $register_enabled
		));
?>
</p>
<p><?php
$disable_registration_email = $vars['entity']->disable_registration_email=='1'?'1':'0';
echo  elgg_echo('enlightn:disable_registration_email') . ' : <br />';
		echo elgg_view('input/radio', array(
			'name' => 'params[disable_registration_email]',
			'options' => array(
				elgg_echo('option:no') => '0',
				elgg_echo('option:yes')=>'1'
			),
			'value' => $disable_registration_email
		));
?>
</p>
<p><?php
$email_activated = $vars['entity']->email_activated=='1'?'1':'0';
echo  elgg_echo('enlightn:email_activated') . ' : <br />';
		echo elgg_view('input/radio', array(
			'name' => 'params[email_activated]',
			'options' => array(
				elgg_echo('option:no') => '0',
				elgg_echo('option:yes')=>'1'
			),
			'value' => $email_activated
		));
?>
</p>
<p>
<?php
$css_sidebar_folders = $vars['entity']->css_sidebar_folders!=''?$vars['entity']->css_sidebar_folders:'#2D87E1';
echo  elgg_echo('enlightn:css_sidebar_folders') . ' : <br />';
		echo elgg_view('input/colorpicker', array(
			'name' => 'params[css_sidebar_folders]',
			'internalid' => 'css_sidebar_folders',
			'value' => $css_sidebar_folders
		));
?>
</p>