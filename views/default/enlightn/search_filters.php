<div id="search_filter">
	<div class="box_wrapper">
		<?php echo elgg_echo("enlightn:searchfilters") ?> | <?php echo elgg_echo("enlightn:searchfavourite") ?>
		<span id="close_search_filters" class="mini-close"/></span>
		<p><?php echo elgg_echo('enlightn:datefrom')?>
		<?php echo elgg_view('input/calendar',array('internalname'=>'date_begin')); ?></p>
		<p><?php echo elgg_echo('enlightn:dateto')?>
		<?php echo elgg_view('input/calendar',array('internalname'=>'date_end')); ?></p>
		<p><?php echo elgg_echo('enlightn:fromuser')?>
		<?php echo elgg_view("enlightn/helper/adduser",array(
																'internalname' => 'from_users',
																'internalid' => 'from_users',
																)); ?></p>
		<input type="submit" id="search_submit" value="<?php echo elgg_echo('enlightn:filter') ?>" class="submit_button">
	</div>
</div>
<script>
		$('#close_search_filters').click( function(){
			$('#activity_container').fadeIn();
			$('#new_discussion').fadeIn();
			$('#requests').fadeIn();
			$('#search_filter').fadeOut();
		});

		$('#search_submit').click( function(){
			//if ($('#searchInput').val().length >= 3) {
				$('#discussion_selector_search').css('display','block');
				changeMessageList('#discussion_selector_search');
				if(loadContent('#discussion_list_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/search.php?q=' + $('#searchInput').val() + '&date_begin=' + $('#date_begin').val() + '&date_end=' + $('#date_end').val() + '&from_users=' + $('#from_users').val())) {
					return true;
				}
			//}
		});
</script>