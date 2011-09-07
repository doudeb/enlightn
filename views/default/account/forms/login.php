<?php
/**
 * Elgg login form
 *
 * @package Elgg
 * @subpackage Core
 */

global $CONFIG;

$form_body = "<p class=\"loginbox\">" . elgg_view('input/text', array('internalname' => 'username',  'placeholder'=>elgg_echo('username')));
$form_body .= "<br />" . elgg_view('input/password', array('internalname' => 'password',  'placeholder'=>elgg_echo('password')));
$form_body .= "<br /><input type=\"checkbox\" name=\"persistent\" value=\"true\" />&nbsp;".elgg_echo('user:persistent')."</label> | ";
$form_body .= "<a href=\"{$vars['url']}account/forgotten_password.php\">" . elgg_echo('user:password:lost') . "</a>";

$form_body .= elgg_view('login/extend');

$form_body .= "<br />" . elgg_view('input/submit', array('value' => elgg_echo('login'))) . "</p>";
$form_body .= (!isset($CONFIG->disable_registration) || !($CONFIG->disable_registration)) ? "<a href=\"{$vars['url']}pg/register/\">" . elgg_echo('register') . "</a> " : "";

$login_url = $vars['url'];
if ((isset($CONFIG->https_login)) && ($CONFIG->https_login)) {
	$login_url = str_replace("http://", "https://", $vars['url']);
}
?>

<div id="login-box">
	<?php
		echo elgg_view('input/form', array('body' => $form_body, 'action' => "{$login_url}action/login"));
	?>
</div>