<?php
$user               = $vars['user'];
$settings           = $vars['settings'];
$settings['mail']   = $user->email;
global $sn_linkers;
?>
		<div id="sidebar">
			<div id="profile_sidebar">
                <div class="linker">
                    <?php
                    foreach ($sn_linkers as $key => $name) {
                        if (isset($settings[$name]) && !empty ($settings[$name])) {
                            echo elgg_view('enlightn/profile/sn_ico', array('settings'=>$settings,'needle'=>$name));
                        }
                    }
                    ?>
                </div>
				<div class="details">
                    <ul>
                    <?php
                    foreach (array('phone','cellphone','mail', 'direction') as $key => $name) {
                        if(!empty ($settings[$name])) {
                            if ($name == 'direction') echo '<li><h1></h1></li>';
                            echo '<li><span class="ico ' . $name . '">' . $settings[$name] .'</span></li>';
                        }
                    }
                    ?>
                    </ul>
				</div><!-- end details -->

			</div><!-- end profile_sidebar -->
			<ol class="folders">
                <li class="current" id="lastMessage"><span class="arrow"></span><a class="cat" href="#" onclick="$('#current_url').val('<?php echo $vars['url'] ?>/mod/enlightn/ajax/search.php?');loadContent('#discussion_list_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/search.php?from_users=<?php echo $user->guid?>');$(this).parent().addClass('current');$('#lastCloud').removeClass('current');"><?php echo elgg_echo('enlightn:profilelastmessage')?></a></li>
                <li id="lastCloud"><span class="arrow"></span><a class="cat" href="#" onclick="$('#current_url').val('<?php echo $vars['url'] ?>/mod/enlightn/ajax/get_my_cloud.php?');loadContent('#discussion_list_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/get_my_cloud.php?from_users=<?php echo $user->guid?>');$(this).parent().addClass('current');$('#lastMessage').removeClass('current');"><?php echo elgg_echo('enlightn:profilecloud')?></a></li>
            </ol>
        </div><!-- end sidebar -->