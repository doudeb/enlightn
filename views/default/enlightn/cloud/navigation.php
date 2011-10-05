<div id="main">
	<div id="cloud">
	    <div class="header">
	    	<?php if (get_context() != 'cloud_embed') { ?>
                <div id="join">
                    <button class="submit" type="submit"><?php echo elgg_echo('enlightn:cloudnew');?></button>
                </div>
	        <?php } ?>
	        <h2><?php echo elgg_echo('enlightn:cloudmain');?></h2>
	    </div>
		<input type="hidden" name="see_more_discussion_list_offset" id="see_more_discussion_list_offset" value="0">
		<div id="feed">
			<div class="actions">
				<ul>

				</ul>

				<ul class="right">
				    <li><a href="" id="cloud_next"><?php echo elgg_echo("enlightn:next")?></a></li>
				    <li><a href="" id="cloud_previous"><?php echo elgg_echo("enlightn:previous")?></a></li>
				</ul>
			</div>
			<?php echo elgg_view('enlightn/cloud/cloud_content',array('internal_id' => $internal_id));?>
		</div>
<script>
$(document).ready(function(){
	$("#cloud_previous").click(function(){
		if ($('#see_more_discussion_list_offset').val() > 0) {
			$('#see_more_discussion_list_offset').val(parseInt($('#see_more_discussion_list_offset').val())-10);
  		loadContent("#cloud_content",'<?php echo $vars['url'] ?>mod/enlightn/ajax/get_my_cloud.php?context=<?php echo get_context()?>' + get_search_criteria());
		}
	  	return false;
	});
	$("#cloud_next").click(function(){
		$('#see_more_discussion_list_offset').val(parseInt($('#see_more_discussion_list_offset').val())+10);
  		loadContent("#cloud_content",'<?php echo $vars['url'] ?>mod/enlightn/ajax/get_my_cloud.php?context=<?php echo get_context()?>' + get_search_criteria());

	  	return false;
	});
});
</script>
	</div><!-- end cloud -->
</div><!-- end main -->
