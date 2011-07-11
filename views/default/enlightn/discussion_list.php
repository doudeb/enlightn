   <div id="feed">
                <div class="actions">
                    <ul>
                        <li><input class="checkbox" type="checkbox" /><span class="arrow"></span></li>
                        <li>Label<span class="arrow"></span>
                            <ul>
                                <li>Travail</li>
                                <li>Perso</li>
                                <li>Publicit�s</li>
                            </ul>
                        </li>
                        <li>Autres actions<span class="arrow"></span></li>
                    </ul>

                    <ul class="right">
                        <li>Trier par : date<span class="arrow"></span></li>
                    </ul>
                </div>
   				<ol>
					<div id="discussion_list_container"></div>
				</ol>
				<div class="more" id="see_more_discussion_list"><?php echo elgg_echo("enlightn:seemore")?> <span class="ico"></span></div>
</div>

   </div>
<input type="hidden" name="see_more_discussion_list_offset" id="see_more_discussion_list_offset" value="0">
<input type="hidden" name="unreaded_only" id="unreaded_only" value="0">
<script language="javascript">
changeMessageList('#discussion_selector_all', 1);

$('#see_more_discussion_list').click(function () {
	$('#see_more_discussion_list_offset').val(parseInt($('#see_more_discussion_list_offset').val())+10);
	loadContent('#discussion_list_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/search.php'  + get_search_criteria(),'append');
});

$(document).ready(function(){
	reloader("<?php echo $vars['url']; ?>mod/enlightn/ajax/search.php", '#discussion_list_container');
});
</script>