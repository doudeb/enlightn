<div id="main">
	<div id="cloud">
	    <div class="header">
	    	<?php if (elgg_get_context() != 'cloud_embed') { ?>
                <div id="join">
                    <button class="submit" type="submit"><?php echo elgg_echo('enlightn:cloudnew');?></button>
                </div>
	        <?php } ?>
	        <h2><?php echo elgg_echo('enlightn:cloudmain');?></h2>
	    </div>
		<input type="hidden" name="see_more_discussion_list_offset" id="see_more_discussion_list_offset" value="0">
		<div id="feed">
			<div class="actions">
                            <span class="star ico"></span><div class="search-memo"><?php echo elgg_echo('enlightn:searchmemo');?></div>
                            <ul class="right">
                                <li><a href="" id="cloud_next"><?php echo elgg_echo("enlightn:next")?></a></li>
                                <li><a href="" id="cloud_previous"><?php echo elgg_echo("enlightn:previous")?></a></li>
                            </ul>
			</div>
			<?php echo elgg_view('enlightn/cloud/cloud_content',array('internal_id' => $internal_id));?>
		</div>
<script>
$(document).ready(function(){
	$("#cloud_previous").click(function(){
		if ($('#see_more_discussion_list_offset').val() > 0) {
			$('#see_more_discussion_list_offset').val(parseInt($('#see_more_discussion_list_offset').val())-10);
  		loadContent("#cloud_content",'<?php echo $vars['url'] ?>mod/enlightn/ajax/get_my_cloud.php?context=<?php echo elgg_get_context()?>' + get_search_criteria());
		}
	  	return false;
	});
	$("#cloud_next").click(function(){
		$('#see_more_discussion_list_offset').val(parseInt($('#see_more_discussion_list_offset').val())+10);
  		loadContent("#cloud_content",'<?php echo $vars['url'] ?>mod/enlightn/ajax/get_my_cloud.php?context=<?php echo elgg_get_context()?>' + get_search_criteria());
	  	return false;
	});
        $(".search-memo").click(function(){
            elm = $(this);
            elm.toggle();
            $('<input id="search-memo-name"><input type="submit" value="<?php echo elgg_echo("enlightn:buttonpost")?>" id="search-memo-post">').insertAfter(elm);
            $("#search-memo-post").click(function(){
                newSearchName = $('#search-memo-name').val();
                /* APPEL AJAX DE CREATION */
                $.post('<?php echo elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/cloud/saveSearch");?>', {searchName: newSearchName}, function(result) {
                    //remove class current                      
                    if(result)  {
                        listElm = $('#saved-search-list');
                        listElm.append("<li data-params='" + JSON.stringify(result) + "'>" + $('#search-memo-name').val() + "<span class='close'>&times;</span></li>");
                        elm.parent().find('input').remove();
                        elm.parent().addClass('starred');
                        $('<span>' + newSearchName + '</span>').insertAfter(elm);
            
                    }                        
                },'json');
            });
        });
        $(".saved-search .saved-items").click(function(){
            elm = $(this).parents();
            params = eval('(' + elm.attr('data-params') + ')')
                ,title = elm.attr('data-name');
            $(".search-memo").html(title);
            $(".search-memo").parent().addClass('starred');
            $.each(params,function (field,value) {
                switch(field) {
                    case 'words':
                        changeElm = $('#searchInput');
                        break;
                    case 'from_users':
                        token_elm  = $('input[name="from_users"]');
                        token_elm.tokenInput("clear");
                        $.each(value,function (key,user_guid) {
                            $.get('<?php echo elgg_add_action_tokens_to_url("{$vars['url']}mod/enlightn/ajax/get_user_data.php");?>', {guid: user_guid}, function(user_ent) {
                                if(user_ent)  {
                                    token_elm.tokenInput("add", {id: user_guid, name: user_ent.name}); 
                                }                        
                            },'json');
                        });
                        value = value.join(',');
                        changeElm = $('input[name="from_users"]');
                        break;
                    case 'date_begin':
                    case 'date_end':
                        if(!value) {
                            value = '';
                            changeElm = $("#" + field);
                            break;
                        }
                        var newDate = new Date(parseInt(value)*1000);
                        value = newDate.getFullYear() + '-' + (newDate.getMonth()+1) + '-' + newDate.getDate();
                        changeElm = $("#" + field);
                        break;
                    default :
                        changeElm = $("#" + field);                         
                        break;
                }
                if (typeof changeElm != undefined) {
                    changeElm.val(value);
                }
            });
            loadContent("#cloud_content",'<?php echo $vars['url'] ?>mod/enlightn/ajax/get_my_cloud.php' + get_search_criteria() + '&context=<?php echo elgg_get_context()?>');
        });
        
        $(".saved-search .close").click(function(){
            elm = $(this).parent();
            title = elm.attr('data-name');
            if(confirm("<?php echo elgg_echo('enlightn:prompt:cloudremovesavedsearch')?>")) {
                $.post('<?php echo elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/cloud/removeSearch");?>', {searchName: title}, function(result) {
                    if(result)  {
                        elm.remove();
                    }                        
                },'json');                
            }
        });
});
</script>
	</div><!-- end cloud -->
</div><!-- end main -->
