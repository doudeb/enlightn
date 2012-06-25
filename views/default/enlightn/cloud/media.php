<script>
$(".embeder").click(function(){
        content = $('#embeder_content' + $(this).attr('id')).val();
        window.parent.updateRte(content);
        window.parent.faceboxClose();
        return false;
});
$(".embederToNew").click(function(){
        content = $('#embeder_content' + $(this).attr('id')).val();
        if (content) {
            showNewDiscussionBox();
            window.parent.updateRte(content);
        }
        return false;
});
$('.expand').click( function() {
    $(this).parent().find('.tag').toggle();
});
$(".disable_ent").click( function() {
    elm = $(this);
    guid = elm.attr('data-guid');
    if(confirm("<?php echo elgg_echo('enlightn:prompt:disableentity')?>")) {
        $.post('<?php echo elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/removeObject");?>', {guid: guid}, function(result) {
            if(result)  {
                loadContent("#cloud_content",'<?php echo $vars['url'] ?>mod/enlightn/ajax/get_my_cloud.php' + get_search_criteria() + '&context=<?php echo elgg_get_context()?>');
            }
        },'json');
    }
});
$("#cloud_content .del").click( function() {
    elm = $(this);
    guid = elm.parent().parent().parent().parent().attr('data-guid');
    destLabelGuid = elm.parent().attr('data-guid');
    if(guid && destLabelGuid && confirm("<?php echo elgg_echo('enlightn:prompt:disableattachedfilter')?>")) {
        $.post('<?php echo elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/cloud/removeAttachedFilter");?>', {guid: guid,labelGuid:destLabelGuid}, function(result) {
            if(result)  {
                elm.parent().remove();
            }
        },'json');
    }
});

$(function() {
    var
        mdPageX = 0,
        mdPageY = 0,
        selectedCount = 1,
        dropAreas = [],

        preventSelection = function() {
            $('body').addClass('unselectable');
            document.onselectstart = function(){ return false; };
            document.unselectable = "on";
        },

        stopPreventSelection = function() {
            $('body').removeClass('unselectable');
            document.onselectstart = null;
            document.unselectable = "off";
        },

        updateDropAreas = function() {
                dropAreas = [];
                var n=0;

                $('#sidebar .dropable').each(function() {
                    var obj = $(this).position();
                    obj.height = $(this).height();
                    obj.width = $(this).width();
                    obj.id = $(this).attr('data-guid');
                    dropAreas.push(obj);
                    n++;
                });
                console.log(dropAreas.length);
            },

        highLightDropArea = function() {
            var
                n = 0,
                done = false,
                pos = $('#mover').position()
            ;
            while(n < dropAreas.length && !done) {
                if((pos.left >= dropAreas[n].left && pos.left <= (dropAreas[n].left + dropAreas[n].width)) && (pos.top >= dropAreas[n].top && pos.top <= (dropAreas[n].top + dropAreas[n].height))) {
                    dropElm = $('#' + dropAreas[n].id);
                    if(!dropElm.hasClass('highlight')) {
                        $('#sidebar .highlight').removeClass('highlight');
                        dropElm.addClass('highlight');
                        $('#mover').addClass('hover');
                        if (dropElm.attr('data-hasChildren')==='true') {
                            dropElm.trigger('click');
                        }
                        updateDropAreas();
                    }
                    done = true;
                }
                n++;
            }
            if(!done) {
                $('#sidebar .highlight').removeClass('highlight');
                $('#mover').removeClass('hover');
            }
        }

        $('#cloud_content li')
            .mousedown(function(e) {
                var curFile = $(this);
                mdPageX = e.pageX;
                mdPageY = e.pageY;
                selectedCount =  $('#cloud_content .selected-user').length;
                preventSelection();
                updateDropAreas();
                $(document).mousemove(function(e) {
                    if(!$('#sidebar .folders').hasClass('drop-folders')) $('#sidebar .folders').addClass('drop-folders');
                    if(!curFile.hasClass('selected-user') && (e.pageX != mdPageX) && (e.pageY != mdPageY)) {
                        curFile.addClass('selected-user');
                        selectedCount =  $('#cloud_content .selected-user').length;
                    }
                    if($('#mover').length == 0) {
                        $('<div/>')
                            .attr('id', 'mover')
                            .css('top', e.pageY - 15)
                            .css('left', e.pageX - 25)
                            .text(selectedCount)
                            .appendTo('body');
                    } else {
                        $('#mover')
                            .css('top', e.pageY - 15)
                            .css('left', e.pageX - 25)
                            .text(selectedCount);
                    }
                    highLightDropArea();

                })
                .mouseup(function(e) {
                    if((e.pageX > (mdPageX-5)) && (e.pageX < (mdPageX+5)) && (e.pageY > (mdPageY-5)) && (e.pageY < (mdPageY+5))) curFile.toggleClass('selected-user');

                    /* Reset initial state */
                    stopPreventSelection();
                    if($('#sidebar .highlight').length > 0) {
                        var destLabelGuid = $('#sidebar .highlight').attr('data-guid');
                        $('#cloud_content .selected-user').each(function() {
                            //selectedFileGuids.push($(this).attr('data-guid'));
                            $(this).removeClass('selected-user');
                            console.log('add to label ',destLabelGuid,$(this).attr('data-guid'));
                            var url = '/action/enlightn/cloud/addFilterToLabel?__elgg_ts=' + elgg.security.token.__elgg_ts + '&__elgg_token=' + elgg.security.token.__elgg_token;
                            $.get(url, {guid:$(this).attr('data-guid'),labelGuid:destLabelGuid}, function(data){

                            },'json');
                        });
                        $('#sidebar .highlight').removeClass('highlight');
                        destLabelGuid = false;
                        updateDropAreas();
                    }
                    $('#mover').fadeOut(1000, function() { $('#mover').remove() });
                    $(document).unbind('mousemove');
                    $(document).unbind('mouseup');
                })
        });
        $('#cloud_mini').click(function(){
            $(this).toggleClass('list_active');
            $('#cloud_full').toggleClass('thumbs_active');
            $('#list_limit').val('20');
            loadContent("#cloud",'<?php echo $vars['url'] ?>mod/enlightn/ajax/get_my_cloud.php' + get_search_criteria() + '&context=<?php echo elgg_get_context()?>&view_type=list&guid='  + $('#guid').val());
            return false;
        });

        $('#cloud_full').click(function(){
            $('#list_limit').val('100');
            $(this).toggleClass('thumbs_active');
            $('#cloud_mini').toggleClass('list_active');
            loadContent("#cloud",'<?php echo $vars['url'] ?>mod/enlightn/ajax/get_my_cloud.php' + get_search_criteria() + '&context=<?php echo elgg_get_context()?>&view_type=thumbs&guid='  + $('#guid').val());
            return false;
        });
// cloud thumbs
	(function (){
		$('#cloud .see_more').each(function (){
			var button = $(this), content = button.next(), hidden = true;

			button.click(function (){
				if(hidden) {
					button.html('-');
					content.show();
					hidden = false;
				}
				else {
					button.html('+');
					content.hide();
					hidden = true;
				}

				return false;
			});
		});
	})();
});
$(document).ready(function(){
	$(".prev").click(function(){
		if ($('#see_more_discussion_list_offset').val() > 0) {
			$('#see_more_discussion_list_offset').val(parseInt($('#see_more_discussion_list_offset').val())-parseInt($('#list_limit').val()));
            loadContent("#cloud",'<?php echo $vars['url'] ?>mod/enlightn/ajax/get_my_cloud.php' + get_search_criteria() + '&context=<?php echo elgg_get_context()?>&view_type=<?php echo get_input('view_type','list')?>&guid='  + $('#guid').val());
		}
	  	return false;
	});
	$(".next").click(function(){
		$('#see_more_discussion_list_offset').val(parseInt($('#see_more_discussion_list_offset').val())+parseInt($('#list_limit').val()));
  		loadContent("#cloud",'<?php echo $vars['url'] ?>mod/enlightn/ajax/get_my_cloud.php' + get_search_criteria() + '&context=<?php echo elgg_get_context()?>&view_type=<?php echo get_input('view_type','list')?>&guid='  + $('#guid').val());
	  	return false;
	});
});

</script>
                            <input type="hidden" name="see_more_discussion_list_offset" id="see_more_discussion_list_offset" value="<?php echo get_input('offset',0)?>">
                            <input type="hidden" name="list_limit" id="list_limit" value="20">
                            <div class="pagination">
                                <p class="pages"> <a id="offset"></a> - <a id="limit"></a> <?php echo elgg_echo('on') ?> <a id="found-rows"></a> </p>
									<p>
										<a href="#" class="prev"> « <?php echo elgg_echo("enlightn:previous")?> </a>
										<a href="#" class="next"> <?php echo elgg_echo("enlightn:next")?> » </a>
									</p>
								</div>

								<div class="controls">
									<p class="left"></p>

									<p class="right">
										<a href="#cloud_list" class="list<?php echo (get_input('view_type','list') == 'list'?' list_active active':'')?>" id="cloud_mini"> list </a>
										<a href="#cloud_thumbs" class="thumbs<?php echo (get_input('view_type','list') == 'thumbs'?' thumbs_active active':'')?>" id="cloud_full"> thumbs </a>
									</p>
								</div>

								<div class="display">

									<ul id="<?php echo (get_input('view_type','list') == 'list'?'cloud_list':'cloud_thumbs')?>">
<?php
	$context    = elgg_get_context();
	$entities   = $vars['entities'];
	if (is_array($entities) && !empty($entities)) {
		foreach($entities as $key=>$entity) {
			if ($entity instanceof ElggEntity) {
				$mime = $entity->mimetype;
				$enttype = $entity->getType();
				$entsubtype = $entity->getSubtype();

				$content = elgg_view('enlightn/new_link', array('type' => $entity->simpletype, 'link' => $entity->filename . '?fetched=1', 'guid' => $entity->guid, 'title'=>$entity->title));
				$content = str_replace("\n","", $content);
				$content = str_replace("\r","", $content);
				//$content = htmlentities($content,null,'utf-8');
				$content = htmlentities($content, ENT_COMPAT, "UTF-8");

				if ($entity instanceof ElggObject) { $title = $entity->title; $mime = $entity->mimetype; } else { $title = $entity->name; $mime = ''; }
				$entview = elgg_view("enlightn/cloud/embedlist",array('entity' => $entity, 'embeder_content'=>$content, 'key'=>$key));
				echo $entview;

			}
		}
	}

?>
                                    </ul>
                                </div>