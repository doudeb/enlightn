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
		<input type="hidden" name="see_more_discussion_list_offset" id="see_more_discussion_list_offset" value="0">
		<input type="hidden" name="list_limit" id="list_limit" value="20">
		<div id="feed" class="cloud_listing">
                    <div class="actions">
                        <div class="search-memo"><span class="star ico"></span><?php echo elgg_echo('enlightn:searchmemo');?></div>
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
                    </div>
			<?php echo elgg_view('enlightn/cloud/cloud_content',array('internal_id' => $internal_id));?>
		</div>
<script>
$(document).ready(function(){
        $('#cloud_mini').click(function(){
            $('#feed').toggleClass('cloud_listing');
            $(this).toggleClass('selected');
            $('#cloud_full').toggleClass('selected');
            $('#list_limit').val('20');
            loadContent("#cloud_content",'<?php echo $vars['url'] ?>mod/enlightn/ajax/get_my_cloud.php?context=<?php echo elgg_get_context()?>' + get_search_criteria());
            return false;
        });

         $('#cloud_full').click(function(){
            $('#feed').toggleClass('cloud_listing');
            $('#list_limit').val('10');
            $(this).toggleClass('selected');
            $('#cloud_mini').toggleClass('selected');
            loadContent("#cloud_content",'<?php echo $vars['url'] ?>mod/enlightn/ajax/get_my_cloud.php?context=<?php echo elgg_get_context()?>' + get_search_criteria());
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
            });
        });
        $(".saved-search .saved-items").click(function() {
            saveSearch(this);
        });
        saveSearch = function(e){
            elm = $(e).parents();
            params = eval('(' + elm.attr('data-params') + ')')
                ,filter_id = elm.attr('data-guid')
                ,title = elm.attr('data-name');
            $(".search-memo").html('<span class="star ico"></span>' + title).css('display','block');
            $(".search-memo").parent().addClass('starred');
            $('#see_more_discussion_list_offset').val(0);
            token_elm  = $('input[name="q"]');
            token_elm.tokenInput("clear");
            $('#search_tags').val('');
            $('#filter_id').val(filter_id);
            $.each(params,function (field,value) {
                switch(field) {
                    case 'words':
                        if(!value) break;
                        token_elm  = $('input[name="q"]');
                        token_elm.tokenInput("add", {id: value, name: value});
                        changeElm = $('input[name="q"]');
                        break;
                    case 'tags':
                        if(!value) break;
                        $('#search_tags').val('');
                        token_elm  = $('input[name="q"]');
                        $.each(value,function (key,tag_id) {
                            $.get('<?php echo elgg_add_action_tokens_to_url("{$vars['url']}mod/enlightn/ajax/get_tag_data.php");?>', {tag_id: tag_id}, function(tag_ent) {
                                if(tag_ent)  {
                                    token_elm.tokenInput("add", {id: 'tag_' + tag_id, name: tag_ent.name});
                                }
                            },'json');
                            value[key] = 'tag_' + tag_id;
                        });
                        value = value.join(',');
                        changeElm = $('input[name="q"]');
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
                    case 'filter_id':
                        if(value == 0) break;
                        changeElm = $("#" + field);
                        break;
                    case 'subtype':
                        changeElm = $("#subtype_checked");
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
        }

        $(".saved-search .close").click(function(){
            searchRemove($(this));
        });
        searchRemove = function(e){
            elm = $(e).parent();
            guid = elm.attr('data-guid');
            if(confirm("<?php echo elgg_echo('enlightn:prompt:cloudremovesavedsearch')?>")) {
                $.post('<?php echo elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/cloud/removeSearch");?>', {guid: guid}, function(result) {
                    if(result)  {
                        elm.remove();
                    }
                },'json');
            }
        };
        $('.expand').click( function() {
            alert('pan');
            //$(this).parent().find('.tag_list').toggle();
        });
});
</script>
	</div><!-- end cloud -->
</div><!-- end main -->
