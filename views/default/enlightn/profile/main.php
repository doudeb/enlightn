<?php
$user		= $vars['user'];
$settings	= $vars['settings'];

?>

<div id="main">
	<div id="profile">
	    <img class="big-photo" src="<?php echo $user->getIcon('large')?>" />
	    <div class="header">
			<p><h2><?php echo $user->name?></h2></p>
			<p><h3><?php echo $settings['jobtitle']['value']?></h3></p>
			<div class="job_location"><?php echo $settings['department']['value']?>, <?php echo $settings['location']['value']?></div>
		</div> <!-- end header -->
		<div id="feed">
			<div class="actions">
				<ul>
				</ul>

				<ul class="right">
				    <li><a href="" id="next"><?php echo elgg_echo("enlightn:next")?></a></li>
				    <li><a href="" id="previous"><?php echo elgg_echo("enlightn:previous")?></a></li>
				</ul>
			</div>
   			<ol id="discussion_list_container"></ol>
		</div><!-- end feed -->
	</div><!-- end profile -->
</div><!-- end main -->
<input type="hidden" name="see_more_discussion_list_offset" id="see_more_discussion_list_offset" value="0" />
<input type="hidden" name="current_url" id="current_url" value="<?php echo $vars['url'] ?>/mod/enlightn/ajax/search.php?" />
<script language="javascript">
$(document).ready(function(){
    loadContent('#discussion_list_container',$('#current_url').val() + 'from_users=<?php echo $user->guid?>');
	$("#previous").click(function(){
		if ($('#see_more_discussion_list_offset').val() > 0) {
			$('#see_more_discussion_list_offset').val(parseInt($('#see_more_discussion_list_offset').val())-10);
  		loadContent("#discussion_list_container",$('#current_url').val() + 'from_users=<?php echo $user->guid?>&offset=' + $('#see_more_discussion_list_offset').val());
		}
	  	return false;
	});
	$("#next").click(function(){
		$('#see_more_discussion_list_offset').val(parseInt($('#see_more_discussion_list_offset').val())+10);
  		loadContent("#discussion_list_container",$('#current_url').val() + 'from_users=<?php echo $user->guid?>&offset=' + $('#see_more_discussion_list_offset').val());

	  	return false;
	});
});
</script>
