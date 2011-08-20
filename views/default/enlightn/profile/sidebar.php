<?php
$user		= $vars['user'];
$settings	= $vars['settings'];

?>
		<div id="sidebar">
			<div id="profile_sidebar">
	            <ul class="linker">
	            	<li>Skype</li>
	            	<li>LinkedIn</li>
	            	<li>Twitter</li>
	            	<li>Viadeo</li>
				</ul>
				<div class="details">
					<span class="phone"></span><p><?php echo $settings['phone']?></p>
					<span class="cellphone"></span><p><?php echo $settings['cellphone']?></p>
					<span class="mail"></span><p><?php echo $user->email?></p>
					<span class="address"></span><p><?php echo $settings['address']?></p>
				</div><!-- end details -->
			</div><!-- end profile_sidebar -->
			<ol class="folders">
                <li class="current" id="lastMessage"><span class="arrow"></span><a class="cat" href="#" onclick="loadContent('#discussion_list_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/search.php?from_users=<?php echo $user->guid?>');$(this).parent().addClass('current');$('#lastCloud').removeClass('current');"><?php echo elgg_echo('enlightn:profilelastmessage')?></a></li>
                <li id="lastCloud"><span class="arrow"></span><a class="cat" href="#" onclick="loadContent('#discussion_list_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/get_my_cloud.php?from_users=<?php echo $user->guid?>');$(this).parent().addClass('current');$('#lastMessage').removeClass('current');"><?php echo elgg_echo('enlightn:profilecloud')?></a></li>
            </ol>