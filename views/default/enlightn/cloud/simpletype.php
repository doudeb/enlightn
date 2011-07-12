	<select name="simpletype" id="cloud_simpletype_select">

<?php

		$all = new stdClass;
		$all->tag = "all";
		$vars['simpletypes'][] = $all;
		$vars['simpletypes'] = array_reverse($vars['simpletypes']);

		if (isset($vars['simpletypes']) && is_array($vars['simpletypes']))
			foreach($vars['simpletypes'] as $type) {

				if ($vars['simpletype'] == $type->tag || (empty($vars['simpletype']) && $type->tag == 'all')) {
					$selected = 'selected = "selected"';
				} else $selected = '';
				$tag = $type->tag;
				if ($tag != "all") {
					$label = elgg_echo("file:type:" . $tag);
				} else {
					$tag = 'simpletype';
					$label = elgg_echo('all');
				}

?>
				<option <?php echo $selected; ?> value="<?php echo $tag; ?>"><?php echo $label; ?></option>
<?php

			}
?>

	</select>
	<script type="text/javascript">
		$('#cloud_simpletype_select').change(function(){
			var simpletype = $('#cloud_simpletype_select').val();
	  		loadContent("#cloud_content",'<?php echo $vars['url'] ?>mod/enlightn/ajax/get_my_cloud.php?offset=' + $('#more_cloud_offset').val() + '&simpletype=' + simpletype);
			return false;
		});
	</script>
