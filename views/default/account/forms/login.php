<?php
/**
 * Elgg login form
 *
 * @package Elgg
 * @subpackage Core
 */
global $CONFIG;
$register_enabled = elgg_get_plugin_setting('register_enabled','enlightn');

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
            <p><?php echo elgg_view('input/submit', array('value' => elgg_echo('login'), 'class'=>'submit')); ?><input type="checkbox" name="persistent" value="true" />&nbsp;<label><?php echo elgg_echo('user:persistent')?></label></p>
            <br />
        </form>
        <p>
            <a href="<?php echo $vars['url']?>forgotpassword"><?php echo elgg_echo('user:password:lost')?></a>
            <?php echo ($register_enabled == 1) ? " | <a href=\"{$vars['url']}register/\"><span class=''>" . elgg_echo('register') . "</span></a> " : ""?>
        </p>
    </div>
    <div class="headline">
    </div>
</div>
<script>
$('input[name="username"]').focus();
</script>