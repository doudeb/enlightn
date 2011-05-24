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
		<?php
			foreach (array(ENLIGHTN_DISCUSSION,ENLIGHTN_DOCUMENT,ENLIGHTN_LINK,ENLIGHTN_MEDIA) as $key => $subtype) {
				$subtype_radio_option[elgg_echo('enlightn:'.$subtype)] = $subtype;
				
			}
			echo elgg_view('input/radio', array('internalname' => 'subtype'
													, 'internalid' => 'subtype'
													, 'value' => ''
													, 'options' => $subtype_radio_option));
		?>
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
			//}
		});
</script>