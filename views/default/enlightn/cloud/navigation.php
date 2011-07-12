<div class="cloud navigation">
	<a href="" id="cloud_previous"><?php echo elgg_echo("enlightn:previous")?></a>
	<a href id="cloud_next" class="more"><?php echo elgg_echo("enlightn:next")?></a></div>
</div>
<input type="hidden" name="more_cloud_offset" id="more_cloud_offset" value="0">
<script>
$(document).ready(function(){
	$("#cloud_previous").click(function(){
		if ($('#more_cloud_offset').val() > 0) {
			var simpletype = $('#cloud_simpletype_select').val();
			$('#more_cloud_offset').val(parseInt($('#more_cloud_offset').val())-10);
	  		loadContent("#cloud_content",'<?php echo $vars['url'] ?>mod/enlightn/ajax/get_my_cloud.php?offset=' + $('#more_cloud_offset').val() + '&simpletype=' + simpletype);

		}
	  	return false;
	});
	$("#cloud_next").click(function(){
		var simpletype = $('#cloud_simpletype_select').val();
		$('#more_cloud_offset').val(parseInt($('#more_cloud_offset').val())+10);
  		loadContent("#cloud_content",'<?php echo $vars['url'] ?>mod/enlightn/ajax/get_my_cloud.php?offset=' + $('#more_cloud_offset').val() + '&simpletype=' + simpletype);

	  	return false;
	});
});
</script>