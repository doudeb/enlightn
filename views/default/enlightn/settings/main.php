<?php
$user		= $vars['user'];
$settings	= $vars['settings'];
$current	= $vars['current'];
global $sn_linkers;
$sn_linkers_select[0] = elgg_echo('enlightn:selectasociallink');
foreach ($sn_linkers as $key => $name) {
    if (!$settings[$name]) {
        $sn_linkers_select[$name] = $name;
    }
}
?>


	<div id="settings">
        <img class="big-photo" src="<?php echo $user->getIcon('large')?>" />
	    <div class="header">
            <p><h1><?php echo sprintf(elgg_echo('enlightn:settingsheader'),$user->name)?></h1></p>
        </div>
        <div id="settings_tabs">
            <ul class="settings_tabs">
                <?php
                foreach (array('account','password','profile','picture','notification','statistics') as $key => $value) {
                    echo '<li id="' . $value . '" class="' . ($current===$value?'current':'') . '">' . elgg_echo('enlightn:'. $value) . "</li>\n";
                }
                ?>
            </ul>
        </div>
        <div id="settings_edit">
            <div id="tabaccount" style="<?php echo ($current!='account'?'display: none;':'')?>">
                <?php
                $form_body = '<p><label>' . elgg_echo('user:name:label') . '</label> <input type="text" name="name" value="' . $user->name .'" placeholder="' . elgg_echo('user:name:label') . '"/></p>
                <p><label>' . elgg_echo('email:address:label') . '</label> <input type="text" name="email" value="' . $user->email .'" placeholder="' . elgg_echo('email:address:label') . '"/></p>
                <p><label>' . elgg_echo('user:language:label') . '</label>';
                $value = $CONFIG->language;
                if ($user->language) {
                    $value = $user->language;
                }
                $form_body .= elgg_view("input/pulldown", array('internalname' => 'language', 'value' => $value, 'options_values' => get_installed_translations())) . '</p>';
                $form_body .= '<p><button type="submit" class="submit">' . elgg_echo("enlightn:buttonpost") . '</button></p>';

                echo elgg_view('input/form', array('action' => "{$vars['url']}action/usersettings/save", 'body' => $form_body));

                ?>

            </div>
            <div id="tabpassword" style="display: none">
                <?php
                $form_body = '<p><label>' . elgg_echo('user:current_password:label') . '</label> <input type="password" name="current_password" /></p>
                <p><label>' . elgg_echo('user:password:label') . '</label> <input type="password" name="password" /></p>
                <p><label>' . elgg_echo('user:password2:label') . '</label> <input type="password" name="password2" /></p>';
                $form_body .= '<p><button type="submit" class="submit">' . elgg_echo("enlightn:buttonpost") . '</button></p>';

                echo elgg_view('input/form', array('action' => "{$vars['url']}action/usersettings/save", 'body' => $form_body));

                ?>
            </div>
             <div id="tabprofile" style="<?php echo ($current==='profile'?'':'display: none;')?>">
                <?php
                $form_body = '<p><label>' . elgg_echo('profile:jobtitle') . '</label> <input type="text" name="jobtitle" value="' . $settings['jobtitle'] . '" /></p>
                <p><label>' . elgg_echo('profile:department') . '</label> <input type="text" name="department"  value="' . $settings['department'] . '" /></p>
                <p><label>' . elgg_echo('profile:location') . '</label> <input type="text" name="location"  value="' . $settings['location'] . '" /></p>';

                $form_body .= '<p><label>' . elgg_echo('profile:timezone') . '</label>' . elgg_view("input/pulldown", array('internalname' =>  'timezone', 'options_values' => get_time_zone(), 'value'=>$settings['timezone'])) . '</p>';
                $form_body .= '<p><label>' . elgg_echo('profile:addasociallink') . '</label>' . elgg_view("input/pulldown", array('internalname' => 'socialLinkAdd','internalid' => 'socialLinkAdd', 'options_values' => $sn_linkers_select)) . '</p>';
                foreach ($sn_linkers as $key => $name) {
                    if (isset($settings[$name]) && !empty ($settings[$name])) {
                        $form_body .= '<p><label><img class="photo_linker" src="' .  $vars['url'] . 'mod/enlightn/media/graphics/linker/' . $name . '.png"  /></label> <input type="text" name="' . $name . '" value="' . $settings[$name] . '" /></p>';
                    }
                }
                $form_body .= '<p><label>' . elgg_echo('profile:phone') . '</label> <input type="text" name="phone"  value="' . $settings['phone'] . '" /></p>
                <p><label>' . elgg_echo('profile:cellphone') . '</label> <input type="text" name="cellphone"  value="' . $settings['cellphone'] . '" /></p>
                <p><label>' . elgg_echo('profile:direction') . '</label> <textarea name="direction">' . $settings['direction'] . '</textarea></p>';
                $form_body .= '<p><button type="submit" class="submit">' . elgg_echo("enlightn:buttonpost") . '</button></p>';
                echo elgg_view('input/form', array('action' => "{$vars['url']}action/enlightn/profile_edit", 'body' => $form_body));
                ?>
            </div>
            <div id="tabpicture" style="display: none;">
               <?php echo elgg_view("profile/editicon", array('user' => $user));?>
            </div>
            <div id="tabnotification" style="display: none;">
               <?php
               echo elgg_echo('enlightn:notificationheadline');
               $form_body = '<p><label>' . elgg_echo('enlightn:notifyoninvite') . '<input type="checkbox" name="' . NOTIFICATION_EMAIL_INVITE. '"' . ($user->{"notification:method:".NOTIFICATION_EMAIL_INVITE} == '1'?' checked=checked':'') . ' value="1"/></label></p>
                <p><label>' .elgg_echo('enlightn:notifyonnewmsg'). '<input type="checkbox" name="' .NOTIFICATION_EMAIL_MESSAGE_FOLLOWED. '" ' . ($user->{"notification:method:".NOTIFICATION_EMAIL_MESSAGE_FOLLOWED} == '1'?' checked=checked':'') . ' value="1"/></label></p>
                <p><button type="submit" class="submit">' . elgg_echo("enlightn:buttonpost") . '</button></p>';
                echo elgg_view('input/form', array('action' => "{$vars['url']}action/enlightn/save_notifications", 'body' => $form_body));
                ?>
            </div>
            <div id="tabstatistics" style="display: none;">
               <?php  echo elgg_view("usersettings/statistics");?>
            </div>
	</div><!-- end profile -->