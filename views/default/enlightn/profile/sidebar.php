<?php
$user		= $vars['user'];
$settings	= $vars['settings'];
global $sn_linkers;
?>
		<div id="sidebar">
			<div id="profile_sidebar">
                <div class="linker">
                    <?php
                    foreach ($sn_linkers as $key => $name) {
                        if (isset($settings[$name]['value']) && !empty ($settings[$name]['value'])) {
                            echo elgg_view('enlightn/profile/sn_ico', array('settings'=>$settings,'needle'=>$name));
                        }
                    }
                    ?>
                </div>
				<div class="details">
					<span class="ico phone"><?php echo $settings['phone']['value']?></span>
					<span class="ico cellphone"><?php echo $settings['cellphone']['value']?></span>
					<span class="ico mail"><?php echo $user->email?></span>
                    <h1></h1>
					<span class="ico address"><?php echo $settings['direction']['value']?></span>
				</div><!-- end details -->
			</div><!-- end profile_sidebar -->
			<ol class="folders">
                <li class="current" id="lastMessage"><span class="arrow"></span><a class="cat" href="#" onclick="$('#current_url').val('<?php echo $vars['url'] ?>/mod/enlightn/ajax/search.php?');loadContent('#discussion_list_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/search.php?from_users=<?php echo $user->guid?>');$(this).parent().addClass('current');$('#lastCloud').removeClass('current');"><?php echo elgg_echo('enlightn:profilelastmessage')?></a></li>
                <li id="lastCloud"><span class="arrow"></span><a class="cat" href="#" onclick="$('#current_url').val('<?php echo $vars['url'] ?>/mod/enlightn/ajax/get_my_cloud.php?');loadContent('#discussion_list_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/get_my_cloud.php?from_users=<?php echo $user->guid?>');$(this).parent().addClass('current');$('#lastMessage').removeClass('current');"><?php echo elgg_echo('enlightn:profilecloud')?></a></li>
            </ol>
        </div><!-- end sidebar -->