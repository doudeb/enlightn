<?php
$user               = $vars['user'];
$settings           = $vars['settings'];
$current            = $vars['current'];
$email_activated    = elgg_get_plugin_setting('email_activated','enlightn');
global $sn_linkers;
$sn_linkers_select[0] = elgg_echo('enlightn:selectasociallink');
foreach ($sn_linkers as $key => $name) {
    if (!$settings[$name]) {
        $sn_linkers_select[$name] = $name;
    }
}
?>
	<div id="settings">
        <img class="big-photo" src="<?php echo $user->getIconURL('large')?>" />
	    <div class="header">
            <p><h1><?php echo sprintf(elgg_echo('enlightn:settingsheader'),$user->name)?></h1></p>
        </div>
        <div id="settings_tabs">
            <ul class="settings_tabs">
                <?php
                foreach (array('account','password','profile','picture','notification'/*,'statistics'*/) as $key => $value) {
                    echo '<li id="' . $value . '" class="' . ($current===$value?'current':'') . '">' . elgg_echo('enlightn:'. $value) . "</li>\n";
                }
                if ($email_activated == 1) {
                    echo '<li id="email1" class="' . ($current==='email1'?'current':'') . '">' . elgg_echo('enlightn:email1') . "</li>\n";
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
                $form_body .= elgg_view("input/dropdown", array('name' => 'language', 'value' => $value, 'options_values' => get_installed_translations())) . '</p>';
                $form_body .= '<p><button type="submit" class="submit">' . elgg_echo("enlightn:buttonpost") . '</button></p>';

                echo elgg_view('input/form', array('action' => "{$vars['url']}action/usersettings/save", 'body' => $form_body));

                ?>
            </div>
            <div id="tabpassword" style="display: none">
                <?php
                $form_body = '<p><label>' . elgg_echo('user:current_password:label') . '</label> <input type="password" name="current_password" /></p>
                <p><label>' . elgg_echo('user:password:label') . '</label> <input type="password" name="password" /></p>
                <p><label>' . elgg_echo('user:password2:label') . '</label> <input type="password" name="password2" /></p>
                    <input type="hidden" name="name" value="' . $user->name .'" />
                    <input type="hidden" name="email" value="' . $user->email .'" />
                    <input type="hidden" name="language" value="' . $user->language .'" />';
                $form_body .= '<p><button type="submit" class="submit">' . elgg_echo("enlightn:buttonpost") . '</button></p>';

                echo elgg_view('input/form', array('action' => "{$vars['url']}action/usersettings/save", 'body' => $form_body));

                ?>
            </div>
             <div id="tabprofile" style="<?php echo ($current==='profile'?'':'display: none;')?>">
                <?php
                $form_body = '<p><label>' . elgg_echo('profile:jobtitle') . '</label> <input type="text" name="jobtitle" value="' . $settings['jobtitle'] . '" /></p>
                <p><label>' . elgg_echo('profile:department') . '</label> <input type="text" name="department"  value="' . $settings['department'] . '" /></p>
                <p><label>' . elgg_echo('profile:location') . '</label> <input type="text" name="location"  value="' . $settings['location'] . '" /></p>';

                $form_body .= '<p><label>' . elgg_echo('profile:timezone') . '</label>' . elgg_view("input/dropdown", array('name' =>  'timezone', 'options_values' => get_time_zone(), 'value'=>$settings['timezone'])) . '</p>';
                $form_body .= '<p><label>' . elgg_echo('profile:addasociallink') . '</label>' . elgg_view("input/dropdown", array('name' => 'socialLinkAdd','id' => 'socialLinkAdd', 'options_values' => $sn_linkers_select)) . '</p>';
                foreach ($sn_linkers as $key => $name) {
                    if (isset($settings[$name]) && !empty ($settings[$name])) {
                        $form_body .= '<p><label><img class="photo_linker" src="' .  $vars['url'] . 'mod/enlightn/media/graphics/linker/' . $name . '.png"  /></label> <input type="text" name="' . $name . '" value="' . $settings[$name] . '" /></p>';
                    }
                }
                $form_body .= '<p><label>' . elgg_echo('profile:phone') . '</label> <input type="text" name="phone"  value="' . $settings['phone'] . '" /></p>
                <p><label>' . elgg_echo('profile:cellphone') . '</label> <input type="text" name="cellphone"  value="' . $settings['cellphone'] . '" /></p>
                <p><label>' . elgg_echo('profile:direction') . '</label> <textarea name="direction" rows="5">' . $settings['direction'] . '</textarea></p>';
                $form_body .= '<p><button type="submit" class="submit">' . elgg_echo("enlightn:buttonpost") . '</button></p>';
                echo elgg_view('input/form', array('action' => "{$vars['url']}action/enlightn/profile_edit", 'body' => $form_body));
                ?>
            </div>
            <div id="tabpicture" style="display: none;">
               <?php echo elgg_view("enlightn/profile/editicon", array('user' => $user));?>
            </div>
            <div id="tabnotification" style="display: none;">
               <?php
               echo elgg_echo('enlightn:notificationheadline');
               $form_body = '<p><label>' . elgg_echo('enlightn:notifyoninvite') . '<input type="checkbox" name="' . NOTIFICATION_EMAIL_INVITE. '"' . ($user->{"notification:method:".NOTIFICATION_EMAIL_INVITE} == '1'||$user->{"notification:method:".NOTIFICATION_EMAIL_INVITE} === null?' checked=checked':'') . ' value="1"/></label></p>
                <p><label>' .elgg_echo('enlightn:notifyonnewmsg'). '<input type="checkbox" name="' .NOTIFICATION_EMAIL_MESSAGE_FOLLOWED. '" ' . ($user->{"notification:method:".NOTIFICATION_EMAIL_MESSAGE_FOLLOWED} == '1'?' checked=checked':'') . ' value="1"/></label></p>
                <p><button type="submit" class="submit">' . elgg_echo("enlightn:buttonpost") . '</button></p>';
                echo elgg_view('input/form', array('action' => "{$vars['url']}action/enlightn/save_notifications", 'body' => $form_body));
                ?>
            </div>
            <div id="tabstatistics" style="display: none;">
               <?php  echo elgg_view("usersettings/statistics");?>
            </div>
            <div id="tabemail1" style="display: none;">
                <?php
                $form_body = '
                     <p><label>' . elgg_echo('enlightn:emaillogin') . '</label><input type="text" name="emaillogin" id="user" value="' . $settings['emaillogin'] . '"/></p>
                     <input type="hidden" name="domainnum" value="0" id="domainnum" />
                     <p><label>' . elgg_echo('enlightn:emailpassword') . '</label> <input type="password" name="emailpasswd" id="passwd" value="' . $settings['emailpasswd'] . '"/></p>
                     <p><label>' . elgg_echo('enlightn:emailserver') . '</label> <input type="text" name="emailserver" id="server" value="' . ($settings['emailserver']?$settings['emailserver']:'mail.example.com') . '" />
                     <p><label>' . elgg_echo('enlightn:emailservertype') . '</label>
                     <select name="emailservtype" onchange="updateLoginPort()" id="emailservtype">
                        <option value="imap">IMAP</option>
                        <option value="notls">IMAP (no TLS)</option>
                        <option value="ssl">IMAP SSL</option>
                        <option value="ssl/novalidate-cert">IMAP SSL (self signed)</option>
                        <option value="pop3">POP3</option>
                        <option value="pop3/notls">POP3 (no TLS)</option>
                        <option value="pop3/ssl">POP3 SSL</option>
                        <option value="pop3/ssl/novalidate-cert">POP3 SSL (self signed)</option>
                     </select>
                     <input type="text" size="4" name="emailport"  id="emailport" value="' . ($settings['emailport']?$settings['emailport']:'143') . '" style="width:25px"/></p></p>
                     <p><button type="submit" class="submit">' . elgg_echo("enlightn:buttonpost") . '</button></p>';
                     echo elgg_view('input/form', array('action' => "{$vars['url']}action/enlightn/profile_edit", 'body' => $form_body, 'id' => 'email1'));
                     ?>
            </div>
	</div><!-- end profile -->