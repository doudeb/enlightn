<?php
global $enlightn;
$unreaded = sort_unreaded_for_nav($vars['discussion_unreaded']);
$tags       = $enlightn->get_tags(elgg_get_logged_in_user_guid(),false,'trending');
?>
  			<ol class="folders">
       			<li id="discussion_selector_<?php echo ENLIGHTN_ACCESS_PU?>"><span class="arrow"></span><a class="cat" onclick="$('#unreaded_only').val(0);changeMessageList('#discussion_selector_<?php echo ENLIGHTN_ACCESS_PU?>', <?php echo ENLIGHTN_ACCESS_PU?>);" href="#"><?php echo elgg_echo('enlightn:public'); ?><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_PU)?></a></li>
				<li id="discussion_selector_<?php echo ENLIGHTN_ACCESS_IN?>"><span class="arrow"></span><a class="cat"  onclick="$('#unreaded_only').val(0);changeMessageList('#discussion_selector_<?php echo ENLIGHTN_ACCESS_IN?>',<?php echo ENLIGHTN_ACCESS_IN?>)" href="#"><?php echo elgg_echo('enlightn:request'); ?><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_IN)?></a></li>
				<li id="discussion_selector_<?php echo ENLIGHTN_ACCESS_PR?>"><span class="arrow"></span><a class="cat"  onclick="$('#unreaded_only').val(0);changeMessageList('#discussion_selector_<?php echo ENLIGHTN_ACCESS_PR?>',<?php echo ENLIGHTN_ACCESS_PR?>);" href="#"><?php echo elgg_echo('enlightn:follow'); ?><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_PR)?></a></li>
				<li id="discussion_selector_<?php echo ENLIGHTN_ACCESS_FA?>"><span class="arrow"></span><a class="cat"  onclick="$('#unreaded_only').val(0);changeMessageList('#discussion_selector_<?php echo ENLIGHTN_ACCESS_FA?>',<?php echo ENLIGHTN_ACCESS_FA?>);" href="#"><?php echo elgg_echo('enlightn:favorites'); ?><?php echo echo_unreaded($unreaded, ENLIGHTN_ACCESS_FA)?></a></li>
				<li id="discussion_selector_sent"><span class="arrow"></span><a class="cat"  onclick="$('input[name=from_users]').val('<?php echo elgg_get_logged_in_user_guid()?>');$('#unreaded_only').val(0);changeMessageList('#discussion_selector_sent',<?php echo ENLIGHTN_ACCESS_PR?>);" href="#"><?php echo elgg_echo('enlightn:sent'); ?></a></li>
				<li id="discussion_selector_<?php echo ENLIGHTN_ACCESS_AL?>" style="display:none"><span class="arrow"></span><a class="cat"  onclick="$('#unreaded_only').val(0);changeMessageList('#discussion_selector_<?php echo ENLIGHTN_ACCESS_AL?>',<?php echo ENLIGHTN_ACCESS_AL?>)" href="#"><?php echo elgg_echo('enlightn:search'); ?></a></li>
                <li id="discussion_selector_tags">
                    <span class="arrow"></span>
                    <a class="cat" href="#"><?php echo elgg_echo('enlightn:trendingtopic');?> (beta)</a>
                       <?php
                            if (is_array($tags)) {
                                echo "<p>";
                                foreach ($tags as $tag) {
                                    echo "<span class='tag' data-keyword='" . $tag->tag . "'>" . $tag->tag . "</span>";
                                }
                                echo "</p>";
                            }
                       ?>
                    </li>
            </ol>
        </div>
    </div>
<input type="hidden" name="discussion_type" id="discussion_type" value="<?php echo $vars['discussion_type']?>">
<input type="hidden" name="search_tags" id="search_tags" value="<?php echo $vars['tags']?>">
<script language="javascript">
var oldTitle = document.title;
setInterval(function() {
    buffer.append(new Task(oldTitle, '<?php echo $vars['url']; ?>mod/enlightn/ajax/discussion_unreaded.php',false, 'json',updateDiscussionUnread));
}, 15000);
</script>