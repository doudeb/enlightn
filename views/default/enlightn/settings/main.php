<?php
$user		= $vars['user'];
$settings	= $vars['settings'];
global $sn_linkers;
    var_dump($CONFIG->profile);

?>


	<div id="settings">
        <img class="big-photo" src="<?php echo $user->getIcon('large')?>" />
	    <div class="header">
			<p><h1><?php echo $user->name?></h1></p>
        </div>
        <div id="settings_tabs">
            <ul class="settings_tabs">
                <li id="account" class="current"><?php echo elgg_echo('enlightn:account'); ?></li>
                <li id="password"><?php echo elgg_echo('enlightn:password'); ?></li>
                <li id="profile"><?php echo elgg_echo('enlightn:profile'); ?></li>
                <li id="picture"><?php echo elgg_echo('enlightn:picture'); ?></li>
                <li id="notification"><?php echo elgg_echo('enlightn:notification'); ?></li>
                <li id="statistics"><?php echo elgg_echo('enlightn:statistics'); ?></li>
            </ul>
        </div>
        <div id="settings_edit">
            <div id="tabaccount">
                <?php
                $form_body = '<p><label>' . elgg_echo('user:name:label') . '</label> <input type="text" name="name" value="' . $user->name .'" placeholder="' . elgg_echo('user:name:label') . '"/></p>
                <p><label>' . elgg_echo('email:address:label') . '</label> <input type="text" name="email" value="' . $user->email .'" placeholder="' . elgg_echo('email:address:label') . '"/></p>
                <p><label>' . elgg_echo('user:language:label') . '</label>';
                $value = $CONFIG->language;
                if ($user->language) {
                    $value = $user->language;
                }
                $form_body .= elgg_view("input/pulldown", array('internalname' => 'language', 'value' => $value, 'options_values' => get_installed_translations())) . '</p>';
                $form_body .= '<p><input type="submit" class="button" /></p>';

                echo elgg_view('input/form', array('action' => "{$vars['url']}action/usersettings/save", 'body' => $form_body));

                ?>

            </div>
            <div id="tabpassword" style="display: none">
                <?php
                $form_body = '<p><label>' . elgg_echo('user:current_password:label') . '</label> <input type="password" name="current_password" /></p>
                <p><label>' . elgg_echo('user:password:label') . '</label> <input type="password" name="password" /></p>
                <p><label>' . elgg_echo('user:password2:label') . '</label> <input type="password" name="password2" /></p>';
                $form_body .= '<p><input type="submit" class="button" /></p>';

                echo elgg_view('input/form', array('action' => "{$vars['url']}action/usersettings/save", 'body' => $form_body));

                ?>
            </div>
             <div id="tabprofile" style="display: none;">
                <?php
                $form_body = '<p><label>' . elgg_echo('profile:jobtitle') . '</label> <input type="text" name="' . $settings['jobtitle']['original_name'] . '" value="' . $settings['jobtitle']['value'] . '" /></p>
                <p><label>' . elgg_echo('profile:department') . '</label> <input type="text" name="' . $settings['department']['original_name'] .'"  value="' . $settings['department']['value'] . '" /></p>
                <p><label>' . elgg_echo('profile:location') . '</label> <input type="text" name="' . $settings['location']['original_name'] .'"  value="' . $settings['location']['value'] . '" /></p>';

                $form_body .= '<p><label>' . elgg_echo('profile:addasociallink') . '</label>' . elgg_view("input/pulldown", array('internalname' => 'language', 'options_values' => $sn_linkers)) . '</p>';

                $form_body .= '<p><label>' . elgg_echo('profile:phone') . '</label> <input type="text" name="' . $settings['phone']['original_name'] .'"  value="' . $settings['phone']['value'] . '" /></p>
                <p><label>' . elgg_echo('profile:cellphone') . '</label> <input type="text" name="' . $settings['cellphone']['original_name'] .'"  value="' . $settings['cellphone']['value'] . '" /></p>
                <p><label>' . elgg_echo('profile:direction') . '</label> <input type="text" name="' . $settings['direction']['original_name'] .'"  value="' . $settings['direction']['value'] . '" /></p>';
                $form_body .= '<p><input type="submit" class="button" /></p>';

                echo elgg_view('input/form', array('action' => "{$vars['url']}action/profile/edit", 'body' => $form_body));
                ?>
            </div>
            <div id="tabpicture" style="display: none;">
               <?php echo elgg_view("profile/editicon", array('user' => $user));?>
            </div>
	</div><!-- end profile -->

<?php echo elgg_view('input/hidden', array('internalname' => 'guid', 'value' => $user->guid));?>