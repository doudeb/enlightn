	<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/enlightn/media/js/jquery.form.js"></script>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/enlightn/media/js/jquery.tokeninput.js"></script>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/enlightn/media/js/cal.js"></script>
    <link rel="stylesheet" href="<?php echo $vars['url']; ?>mod/enlightn/media/css/token-input-facebook.css" type="text/css" />
    <link rel="shortcut icon" href="<?php echo $vars['url']; ?>mod/enlightn/media/graphics/favicon.ico">
    <link rel="icon" href="<?php echo $vars['url']; ?>mod/enlightn/media/graphics/favicon.ico">
</head>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
  		$('a[rel*=facebox]').facebox()
	});
	$(document).ready(function(){
		$('#search_submit').click( function(){
			<?php
				if (in_array(get_context(),array('cloud','cloud_embed'))) {
					echo "loadContent('#cloud_content','" . $vars['url'] . "mod/enlightn/ajax/get_my_cloud.php' + get_search_criteria() + '?context=" . get_context() . "');";
				} else {
					echo "changeMessageList('#discussion_selector_search'," .ENLIGHTN_ACCESS_AL.");";
				}
			?>
			return false;
		});
	});
	</script>
