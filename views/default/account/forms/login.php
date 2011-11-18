<?php
/**
 * Elgg login form
 *
 * @package Elgg
 * @subpackage Core
 */
global $CONFIG;
$register_enabled = get_plugin_setting('register_enabled','enlightn');
/*
$form_body = "<p class=\"loginbox\">" . elgg_view('input/text', array('internalname' => 'username',  'placeholder'=>elgg_echo('username')));
$form_body .= "<br />" . elgg_view('input/password', array('internalname' => 'password',  'placeholder'=>elgg_echo('password')));
$form_body .= "<br /><input type=\"checkbox\" name=\"persistent\" value=\"true\" />&nbsp;".elgg_echo('user:persistent')."</label> | ";
$form_body .= "<a href=\"{$vars['url']}account/forgotten_password.php\">" . elgg_echo('user:password:lost') . "</a>";

$form_body .= elgg_view('login/extend');

$form_body .= "<br />" . elgg_view('input/submit', array('value' => elgg_echo('login'))) . "</p>";
$form_body .= (!isset($CONFIG->disable_registration) || !($CONFIG->disable_registration)) ? "<a href=\"{$vars['url']}pg/register/\">" . elgg_echo('register') . "</a> " : "";
*/

$login_url = $vars['url'];
if ((isset($CONFIG->https_login)) && ($CONFIG->https_login)) {
	$login_url = str_replace("http://", "https://", $vars['url']);
}
?>
<style>
body, #body {
    background-color: #fff;
    font-size: 13px;
 }
</style>
<div id="login">
    <div class="box">
        <form action="<?php echo $login_url?>action/login" method="post">
            <?php echo elgg_view('input/securitytoken'); ?>
            <p><h2><?php echo elgg_echo('username');?> :</h2></p>
            <p><?php echo elgg_view('input/text', array('internalname' => 'username',  'placeholder'=>elgg_echo(''))); ?></p>
            <p><h2><?php echo elgg_echo('password');?> :</h2></p>
            <p><?php echo elgg_view('input/password', array('internalname' => 'password',  'placeholder'=>elgg_echo(''))); ?></p>
            <p><?php echo elgg_view('input/submit', array('value' => elgg_echo('login'))); ?><input type="checkbox" name="persistent" value="true" />&nbsp;<label><?php echo elgg_echo('user:persistent')?></label></p>
            <br />
        </form>
        <p>
            <a href="<?php echo $vars['url']?>account/forgotten_password.php"><?php echo elgg_echo('user:password:lost')?></a>
            <?php echo ($register_enabled == 1) ? " | <a href=\"{$vars['url']}pg/register/\"><span class=''>" . elgg_echo('register') . "</span></a> " : ""?>
        </p>
    </div>
    <div class="headline">
    </div>
</div>
<script>
$('input[name="username"]').focus();
</script>