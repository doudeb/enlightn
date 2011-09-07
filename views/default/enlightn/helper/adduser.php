<?php
$unique_id = md5($vars['internalname'] . time());
?>

<input type="text" id="<?php echo $unique_id; ?>" name="<?php echo $vars['internalname']; ?>" placeholder="<?php echo $vars['placeholder']; ?>"/>
<script type="text/javascript">
	$(document).ready(function() {
		$("#<?php echo $unique_id; ?>").tokenInput("<?php echo $vars['url']; ?>mod/enlightn/ajax/members.php",{
                 hintText : "<?php echo elgg_echo('enlightn:typeforsearch'); ?>"
                 , searchingText : "<?php echo elgg_echo('enlightn:searchforuser'); ?>"
                 , preventDuplicates: true
                 , placeholder: '<?php echo $vars['placeholder']; ?>'
        });
	});
</script>