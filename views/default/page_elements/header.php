	<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/enlightn/media/js/jquery.form.js"></script>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/enlightn/media/js/jquery.tokeninput.js"></script>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/enlightn/media/js/strophe.js"></script>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/enlightn/media/js/cal.js"></script>
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
				if (in_array(elgg_get_context(),array('cloud','cloud_embed'))) {?>
                                        /*$(".search-memo").html('<span class="star ico"></span><?php echo elgg_echo('enlightn:searchmemo');?>');
                                        $(".search-memo").parent().removeClass('starred');
                                        $(".search-memo").css('display','block');*/
                                        $("#see_more_discussion_list_offset").val(0);
					loadContent('#cloud_content','<?php echo $vars['url']?>mod/enlightn/ajax/get_my_cloud.php' + get_search_criteria() + '&context=<?php echo elgg_get_context()?>');
                                <?php
				} else {
					echo "changeMessageList('#discussion_selector_search'," .ENLIGHTN_ACCESS_AL.");";
				}
			?>
			return false;
		});
	});
	</script>
