<?php
$unreaded = sort_unreaded_for_nav($vars['discussion_unreaded']);
?>
  			<ol class="folders">
       			<li class="current" id="discussion_selector_all"><span class="arrow"></span><a class="cat" onclick="$('#unreaded_only').val(0);changeMessageList('#discussion_selector_all', 1);" href="#"><?php echo elgg_echo('PUBLIC'); ?><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_PU)?></a></li>
				<li id="discussion_selector_follow"><span class="arrow"></span><a class="cat"  onclick="$('#unreaded_only').val(0);changeMessageList('#discussion_selector_follow',2);" href="#"><?php echo elgg_echo('enlightn:follow'); ?><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_PR)?></a></li>
				<li id="discussion_selector_invited"><span class="arrow"></span><a class="cat"  onclick="$('#unreaded_only').val(0);changeMessageList('#discussion_selector_invited',5)" href="#"><?php echo elgg_echo('enlightn:membershiprequest'); ?><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_IN)?></a></li>
				<li id="discussion_selector_favorite"><span class="arrow"></span><a class="cat"  onclick="$('#unreaded_only').val(0);changeMessageList('#discussion_selector_favorite',3);" href="#"><?php echo elgg_echo('enlightn:favorite'); ?><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_FA)?></a></li>
				<li id="discussion_selector_search" style="display:none"><span class="arrow"></span><a class="cat"  onclick="$('#unreaded_only').val(0);changeMessageList('#discussion_selector_search',4)" href="#"><?php echo elgg_echo('enlightn:search'); ?></a></li>

            </ol>
        </div>
    </div>
<input type="hidden" name="discussion_type" id="discussion_type" value="1">
<script language="javascript">
setInterval(function() {
	$.getJSON('<?php echo $vars['url']; ?>mod/enlightn/ajax/discussion_unreaded.php', function(data) {
		$.each(data, function(i,item){
			var received_value = item;
			var nav_element = $("#nav_unreaded_" + i);
			if(typeof nav_element == 'object') {
				if (received_value != '0' && nav_element.html() != received_value) {
					nav_element.html(received_value);
				}
			}
		});
	});
}, 15000);
</script>