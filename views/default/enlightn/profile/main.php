<?php
$user		= $vars['user'];
$settings	= $vars['settings'];
$jobtitle	= get_plugin_usersetting('jobtitle',$user->guid, 'profile');
$location	= get_plugin_usersetting('location',$user->guid, 'profile');

?>

<div id="main">
	<div id="profile">
	    <img class="big-photo" src="<?php echo $user->getIcon('large')?>" />
	    <div class="header">
			<p><h2><?php echo $user->name?></h2></p>
			<p><h3><?php echo $settings['jobtitle']?></h3></p>
			<div class="job_location"><?php echo $settings['location']?></div>
		</div> <!-- end header -->
		<div id="feed">
			<div class="actions">
				<ul>
				</ul>

				<ul class="right">
				</ul>
			</div>
   			<ol id="discussion_list_container"></ol>
		</div><!-- end feed -->
	</div><!-- end profile -->
</div><!-- end main -->
<script language="javascript">
loadContent('#discussion_list_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/search.php?from_users=<?php echo $user->guid?>');
</script>
