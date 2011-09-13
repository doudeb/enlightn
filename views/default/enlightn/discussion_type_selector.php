<?php
$unreaded = sort_unreaded_for_nav($vars['discussion_unreaded']);
?>
  			<ol class="folders">
       			<li class="current" id="discussion_selector_<?php echo ENLIGHTN_ACCESS_PU?>"><span class="arrow"></span><a class="cat" onclick="$('#unreaded_only').val(0);changeMessageList('#discussion_selector_<?php echo ENLIGHTN_ACCESS_PU?>', <?php echo ENLIGHTN_ACCESS_PU?>);" href="#"><?php echo elgg_echo('PUBLIC'); ?><?php //echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_PU)?></a></li>
				<li id="discussion_selector_<?php echo ENLIGHTN_ACCESS_IN?>"><span class="arrow"></span><a class="cat"  onclick="$('#unreaded_only').val(0);changeMessageList('#discussion_selector_<?php echo ENLIGHTN_ACCESS_IN?>',<?php echo ENLIGHTN_ACCESS_IN?>)" href="#"><?php echo elgg_echo('enlightn:membershiprequest'); ?><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_IN)?></a></li>
				<li id="discussion_selector_<?php echo ENLIGHTN_ACCESS_PR?>"><span class="arrow"></span><a class="cat"  onclick="$('#unreaded_only').val(0);changeMessageList('#discussion_selector_<?php echo ENLIGHTN_ACCESS_PR?>',<?php echo ENLIGHTN_ACCESS_PR?>);" href="#"><?php echo elgg_echo('enlightn:follow'); ?><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_PR)?></a></li>
				<li id="discussion_selector_<?php echo ENLIGHTN_ACCESS_FA?>"><span class="arrow"></span><a class="cat"  onclick="$('#unreaded_only').val(0);changeMessageList('#discussion_selector_<?php echo ENLIGHTN_ACCESS_FA?>',<?php echo ENLIGHTN_ACCESS_FA?>);" href="#"><?php echo elgg_echo('enlightn:favorite'); ?><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_FA)?></a></li>
				<li id="discussion_selector_sent"><span class="arrow"></span><a class="cat"  onclick="$('#unreaded_only').val(0);changeMessageList('#discussion_selector_sent',<?php echo ENLIGHTN_ACCESS_PR?>);" href="#"><?php echo elgg_echo('enlightn:sent'); ?></a></li>
				<li id="discussion_selector_<?php echo ENLIGHTN_ACCESS_AL?>" style="display:none"><span class="arrow"></span><a class="cat"  onclick="$('#unreaded_only').val(0);changeMessageList('#discussion_selector_<?php echo ENLIGHTN_ACCESS_AL?>',<?php echo ENLIGHTN_ACCESS_AL?>)" href="#"><?php echo elgg_echo('enlightn:search'); ?></a></li>

            </ol>
        </div>
    </div>
<input type="hidden" name="discussion_type" id="discussion_type" value="<?php echo ENLIGHTN_ACCESS_PU?>">
<script language="javascript">
var oldTitle = document.title;
setInterval(function() {
	$.getJSON('<?php echo $vars['url']; ?>mod/enlightn/ajax/discussion_unreaded.php', function(data) {
        var totalUnreaded = 0;
		$.each(data, function(i,item){
			var received_value = item;
			var nav_element = $("#nav_unreaded_" + i);
            if (i != '<?php echo ENLIGHTN_ACCESS_PU;?>') {
                totalUnreaded += parseInt(received_value);
            }
			if(typeof nav_element == 'object') {
				if (received_value != '0' && nav_element.html() != received_value) {
					nav_element.html(received_value);
				}
			}
		});
        if (totalUnreaded > 0) {
            document.title = oldTitle + '(' + totalUnreaded + ')';
        }
	});
}, 15000);
</script>