<div id="main">
	<div id="cloud">
	    <div class="header">
	    	<?php if (elgg_get_context() != 'cloud_embed') { ?>
                <div id="join">
                    <button class="submit" type="submit"><?php echo elgg_echo('enlightn:cloudnew');?></button>
                </div>
	        <?php } ?>
	        <h2><?php echo elgg_echo('enlightn:cloudmain');?></h2>
                <p><?php echo elgg_echo('enlightn:cloudheadline');?></p>
	    </div>
		<div id="feed" class="cloud_listing">
            <div class="search-memo">
                <span class="ico railsMenu home"></span>
                <ul class="railsMenu" id="railsMenu"></ul>
            </div>
            <!--<div class="actions">
                <ul class="right">
                    <li><a href="" id="cloud_next"><?php echo elgg_echo("enlightn:next")?></a></li>
                    <li><a href="" id="cloud_previous"><?php echo elgg_echo("enlightn:previous")?></a></li>
                    <li><span id="offset"></span> - <span id="limit"></span> <?php echo elgg_echo("on")?> <span id="found-rows"></span></li>
                </ul>
            </div>
            <div class="changeview">
                <ul class="right change-view-selector">
                    <li><span class="change-full ico" id="cloud_full">cloud_full</span></li>
                    <li><span class="change-mini ico selected" id="cloud_mini">cloud_mini</span></li>
                </ul>
            </div>-->
			<?php echo elgg_view('enlightn/cloud/cloud_content',array('internal_id' => $internal_id));?>
		</div>
<script>
$(document).ready(function(){
    $('#cloud_mini').click(function(){
        $('#feed').toggleClass('cloud_listing');
        $(this).toggleClass('selected');
        $('#cloud_full').toggleClass('selected');
        $('#list_limit').val('20');
        loadContent("#cloud_content",'<?php echo $vars['url'] ?>mod/enlightn/ajax/get_my_cloud.php' + get_search_criteria() + '&context=<?php echo elgg_get_context()?>');
        return false;
    });

    $('#cloud_full').click(function(){
        $('#feed').toggleClass('cloud_listing');
        $('#list_limit').val('10');
        $(this).toggleClass('selected');
        $('#cloud_mini').toggleClass('selected');
        loadContent("#cloud_content",'<?php echo $vars['url'] ?>mod/enlightn/ajax/get_my_cloud.php' + get_search_criteria() + '&context=<?php echo elgg_get_context()?>');
        return false;
    });

	$("#cloud_previous").click(function(){
		if ($('#see_more_discussion_list_offset').val() > 0) {
			$('#see_more_discussion_list_offset').val(parseInt($('#see_more_discussion_list_offset').val())-parseInt($('#list_limit').val()));
                        loadContent("#cloud_content",'<?php echo $vars['url'] ?>mod/enlightn/ajax/get_my_cloud.php' + get_search_criteria() + '&context=<?php echo elgg_get_context()?>');
		}
	  	return false;
	});
	$("#cloud_next").click(function(){
		$('#see_more_discussion_list_offset').val(parseInt($('#see_more_discussion_list_offset').val())+parseInt($('#list_limit').val()));
  		loadContent("#cloud_content",'<?php echo $vars['url'] ?>mod/enlightn/ajax/get_my_cloud.php' + get_search_criteria() + '&context=<?php echo elgg_get_context()?>');
	  	return false;
	});
 	$("#.railsMenu.home").click(function(){
        var railsMenu = $('#railsMenu');
        railsMenu.html('');
        $('#search').find('input, select, textarea, :hidden').not(':button, :submit, :reset').val('').removeAttr('checked').removeAttr('selected');
		$('#see_more_discussion_list_offset').val(0);
  		loadContent("#cloud_content",'<?php echo $vars['url'] ?>mod/enlightn/ajax/get_my_cloud.php?offset=0&limit=' + parseInt($('#list_limit').val()) +'context=<?php echo elgg_get_context()?>');
	  	return false;
	});
        $(".search-memo_old").click(function(){
            elm = $(this);
            elm.toggle();
            $('<input id="search-memo-name" placeholder="<?php echo elgg_echo("enlightn:enterlabelname")?>">').insertAfter(elm);
            $("#search-memo-name").keyup(function(e){
                if(e.keyCode == 13) {
                    newSearchName = $('#search-memo-name').val();
                    /* APPEL AJAX DE CREATION */
                    $.post('<?php echo elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/cloud/saveSearch");?>', {searchName: newSearchName, isPrivate: true}, function(result) {
                        //remove class current
                        if(result)  {
                            listElm = $('#saved-search-list');
                            listElm.append("<li data-params='" + JSON.stringify(result) + "' data-name='" + newSearchName + "'><span class='saved-items'>" + $('#search-memo-name').val() + "<span class='close'>&times;</span></span></li>");
                            elm.parent().find('input').remove();
                            elm.parent().addClass('starred');
                            elm.html('<span class="star ico"></span>' + newSearchName);
                            elm.toggle();
                            listElm.find('.saved-items').click(function() {
                                saveSearch($(this));
                            });
                            listElm.find('.close').click(function() {
                                searchRemove($(this));
                            });
                        }
                    },'json');
                 }
            });
        });
        $(".saved-search .saved-items").click(function() {
            saveSearch(this);
        });


        $(".saved-search .close").click(function(){
            searchRemove($(this));
        });
});
</script>
	</div><!-- end cloud -->
</div><!-- end main -->
