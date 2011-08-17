<?php
/**
 * Elgg pageshell
 * The standard HTML header that displays across the site
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['config'] The site configuration settings, imported
 * @uses $vars['title'] The page title
 * @uses $vars['body'] The main content of the page
 */

// Set title
if (empty($vars['title'])) {
	$title = $vars['config']->sitename;
} else if (empty($vars['config']->sitename)) {
	$title = $vars['title'];
} else {
	$title = $vars['config']->sitename . ": " . $vars['title'];
}

global $autofeed;
if (isset($autofeed) && $autofeed == true) {
	$url = $url2 = full_url();
	if (substr_count($url,'?')) {
		$url .= "&view=rss";
	} else {
		$url .= "?view=rss";
	}
	if (substr_count($url2,'?')) {
		$url2 .= "&view=odd";
	} else {
		$url2 .= "?view=opendd";
	}
	$feedref = <<<END

	<link rel="alternate" type="application/rss+xml" title="RSS" href="{$url}" />
	<link rel="alternate" type="application/odd+xml" title="OpenDD" href="{$url2}" />

END;
} else {
	$feedref = "";
}

// we won't trust server configuration but specify utf-8
header('Content-type: text/html; charset=utf-8');

$version = get_version();
$release = get_version(true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="ElggRelease" content="<?php echo $release; ?>" />
	<meta name="ElggVersion" content="<?php echo $version; ?>" />
	<title><?php echo $title; ?></title>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/enlightn/media/js/jquery-1.6.1.min.js"></script>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/enlightn/media/js/jquery.form.js"></script>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>vendors/jquery/jquery-ui-1.7.2.min.js"></script>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>_css/js.php?lastcache=<?php echo $vars['config']->lastcache; ?>&js=initialise_elgg&viewtype=<?php echo $vars['view']; ?>"></script>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/enlightn/media/js/jquery.popin.js"></script>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/enlightn/media/js/jquery.rte.js"></script>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/enlightn/media/js/jquery.tokeninput.js"></script>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/enlightn/media/js/cal.js"></script>
<?php
	global $pickerinuse;
	if (isset($pickerinuse) && $pickerinuse == true) {
?>
	<!-- only needed on pages where we have friends collections and/or the friends picker -->
	<script type="text/javascript" src="<?php echo $vars['url']; ?>vendors/jquery/jquery.easing.1.3.packed.js"></script>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>_css/js.php?lastcache=<?php echo $vars['config']->lastcache; ?>&js=friendsPickerv1&viewtype=<?php echo $vars['view']; ?>"></script>
<?php
	}
?>
	<!-- include the default css file -->
	<link rel="stylesheet" href="<?php echo $vars['url']; ?>_css/css.css?lastcache=<?php echo $vars['config']->lastcache; ?>&viewtype=<?php echo $vars['view']; ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo $vars['url']; ?>mod/enlightn/media/css/token-input.css" type="text/css" />

	<?php
		echo $feedref;
		echo elgg_view('metatags',$vars);
	?>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
  		$('a[rel*=facebox]').facebox()
	});
	</script>
</head>

<body>

<script language="javascript">

function loadContent (divId,dataTo,method,anchor) {
	if (method == undefined || method == 'load') {
		if ($(divId).html().indexOf('loading.gif') == -1) {
			$(divId).prepend('<img src="<?php echo $vars['url'] ?>mod/enlightn/media/graphics/loading.gif" alt="loading">');
			 $(divId).load(dataTo, function(responseText, textStatus, XMLHttpRequest) {
			 	lastModified = XMLHttpRequest.getResponseHeader('Last-Modified');
			 	queryUid = XMLHttpRequest.getResponseHeader('Query-uid');
			 	if (typeof lastModified != undefined) {
			 		$('<input />', {
	            		'id' : 'lastModified' + queryUid
	    				,'type': 'hidden'
			 			,'value' : lastModified}).insertAfter(divId);
			 	}
			 	//alert($('#lastModified' + queryUid).val());
	  		return true;
			});
		}
	} else if (method == 'append') {
		$.get(dataTo, function(data){
			$(divId).append(data);
		});
	}
}

function get_search_criteria () {
	if (typeof $('#subtype_checked').val() == 'undefined') {
		var subtype = '';
	} else {
		var subtype = $('#subtype_checked').val();
	}

	if (typeof $('#searchInput').val() == 'undefined') {
		var words = '';
	} else {
		var words = $('#searchInput').val();
	}
	if (typeof $('#from_users').val() == 'undefined') {
		var from_users = '';
	} else {
		var from_users = $('#from_users').val();
	}
	if (typeof $('#date_end').val() == 'undefined') {
		var date_end = '';
	} else {
		var date_end = $('#date_end').val();
	}
	if (typeof $('#date_begin').val() == 'undefined') {
		var date_begin = '';
	} else {
		var date_begin = $('#date_begin').val();
	}
	if (typeof $('#discussion_type').val() == 'undefined') {
		var discussion_type = 1;
	} else {
		var discussion_type = $('#discussion_type').val();
	}
	if (typeof $('#entity_guid').val() == 'undefined') {
		var entity_guid = 0;
	} else {
		var entity_guid = $('#entity_guid').val();
	}
	if (typeof $('#unreaded_only').val() == 'undefined') {
		var unreaded_only = 0;
	} else {
		var unreaded_only = $('#unreaded_only').val();
	}
	if(words) {
		discussion_type = 4;
	}


	var search_criteria = '?q=' + encodeURIComponent(words)
							+ '&date_begin=' + date_begin
							+ '&date_end=' + date_end
							+ '&from_users=' + from_users
							+ '&offset=' + $('#see_more_discussion_list_offset').val()
							+ '&subtype=' + subtype
							+ '&discussion_type=' + discussion_type
							+ '&entity_guid=' + entity_guid
							+ '&unreaded_only=' + unreaded_only;
	return search_criteria;
}

	$(document).ready(function(){
		$('#search_submit').click( function(){
			changeMessageList('#discussion_selector_search',<?php echo ENLIGHTN_ACCESS_AL?>);
			return false;
		});
	});
	if (typeof $('#searchInput').val() != 'undefined') {
		var refreshSearch = setInterval(function() {
			if ($('#searchInput').val().length > 2) {
		    	if($('#searchInput').val() != $('#last_search').val()) {
		    		$('#last_search').val($('#searchInput').val());
					changeMessageList('#discussion_selector_search',$('#discussion_type_filter').val());
		    	}
			}
		}, 1500);
	}
	function changeMessageList (currElement, discussion_type) {
		if (typeof $('#discussion_list_container') == undefined) {
			window.location.replace("<?php echo $vars['url']; ?>home/" + discussion_type);
			return false;
		}
		if(typeof discussion_type == undefined) {
			discussion_type = 1;
		}
		$('#discussion_type').val(discussion_type);
		$('#see_more_discussion_list_offset').val(0);
		if (currElement == '#discussion_selector_sent') {
			$('#from_users').val('<?php echo get_loggedin_userid()?>');
		}
		loadContent('#discussion_list_container','<?php echo $vars['url']; ?>mod/enlightn/ajax/search.php' + get_search_criteria());
		$(currElement).addClass('current');
		$(currElement + '_tabs').addClass('current');
		$(".folders li").each(function () {
			if($(this).attr('id') != $(currElement).attr('id')) {
				$(this).removeClass('current');
				tabElement = '#' + $(this).attr('id') + '_tabs';
				if (typeof $(tabElement) != undefined) {
					$(tabElement).removeClass('current');
				}
			}
      	});
      	return false;
	}
$(document).ready(function(){
	$('.filters li input').click( function(){
		currElement = $(this);
		items_checked = [];
		$('#subtype_checked').val('"');
		if(currElement.parent().hasClass('checked')) {
			currElement.parent().removeClass('checked');
		} else {
			currElement.parent().addClass('checked');
		}
		$('.filters li input').each(function () {
			if(currElement.attr('id') == 'type_all'
			&& currElement.parent().hasClass('checked')
			&& $(this).attr('id') != 'type_all' ) {
				$(this).parent().removeClass('checked');
			} else if (currElement.attr('id') != 'type_all'
			&& currElement.parent().hasClass('checked')
			&& $(this).attr('id') == 'type_all') {
				$(this).parent().removeClass('checked');
			}
			if($(this).parent().hasClass('checked')) {
				items_checked.push($(this).val());
			}
		});
		$('#subtype_checked').val(items_checked.join("','"));
	});
});


	function reloader (url_to_check, element_id) {
		setInterval(function() {
			var offset = $('#see_more_discussion_list_offset').val();
			$.getJSON(url_to_check + get_search_criteria(),{fetch_modified: "1"}, function(data, textStatus, jqXHR) {
				lastModified = jqXHR.getResponseHeader('Last-Modified');
			 	queryUid = jqXHR.getResponseHeader('Query-uid');
			 	lastCalled = $('#lastModified' + queryUid).val();
			 	//alert(lastModified + ' != ' + lastCalled);
			 	if (lastModified != lastCalled) {
			 		loadContent (element_id, url_to_check + get_search_criteria());
			 	}

				/*$.each(data, function(i,item){

					if (i == 'last-modified' && offset == '0') {
						if (last_modified != item) {
							if (last_modified != '0') {
								loadContent (element_id, url_to_check + get_search_criteria());
							}
							last_modified = item;
						}
					}
				});*/
			});
		}, 5000);
	}
	$(document).ready(function(){
		$('#expandAll').click( function(){
			$("#discussion_list_container li").each(function () {
				$(this).addClass('open-msg');
			});
		});
		$('#collapseAll').click( function(){
			$("#discussion_list_container li").each(function () {
				$(this).removeClass('open-msg');
			});
		});
		$('#privacy_cursor').click( function(){
			if($(this).parent().hasClass('private')) {
				$(this).parent().removeClass('private');
				$(this).parent().addClass('public');
				$('#membership').val(<?php echo ACCESS_PUBLIC?>);
			} else {
				$(this).parent().removeClass('public');
				$(this).parent().addClass('private');
				$('#membership').val(<?php echo ACCESS_PRIVATE?>);
			}
		});
	});
    $(function() {
        var
            mdPageX = 0,
            mdPageY = 0,
            selectedCount = 1,
            dropAreas = [],
            formUserIds = [],

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
                    obj.id = $(this).attr('id').replace('area','');
                    dropAreas.push(obj);
                    n++;
                });
            },

            highLightDropArea = function() {
                var
                    n = 0,
                    done = false,
                    pos = $('#mover').position()
                ;
                while(n < dropAreas.length && !done) {
                    if((pos.left >= dropAreas[n].left && pos.left <= (dropAreas[n].left + dropAreas[n].width)) && (pos.top >= dropAreas[n].top && pos.top <= (dropAreas[n].top + dropAreas[n].height))) {
                        if(!$('#area' + dropAreas[n].id).hasClass('highlight')) {
                            $('#sidebar .highlight').removeClass('highlight');
                            $('#area' + dropAreas[n].id).addClass('highlight');
                            $('#mover').addClass('hover');
                        }
                        done = true;
                    }
                    n++;
                }
                if(!done) {
                    $('#sidebar .highlight').removeClass('highlight');
                    $('#mover').removeClass('hover');
                }
            },

            addNewList = function(name, isPrivate) {

                var privacyClass = isPrivate ? 'private-ico' : 'public-ico';

                /* APPEL AJAX DE CREATION */
                $.post('<?php echo elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/collection/addcollection");?>', {listName: name, userIds: formUserIds, isPrivate: isPrivate}, function(data) {

                    //var data = {id: Math.round(Math.random()*1000)}; /* REMOVE after Ajax implementation */

                    $('#sidebar .addform')
                        /* Add list and tag to users */
                        .before('<li id="area'+ data.id +'" class="dropable" style="display:none" data-listId="'+ data.id +'" data-listName="'+ name +'"><a class="cat" href="/list'+ data.id +'"><span class="count">'+ formUserIds.length +'</span>'+ name +'<span class="ico '+ privacyClass +'"></span></a></li>')
                        .find('.count').text('').end()
                        .find('.form').hide()
                            .find('input').val('').end()
                            .find('.ico').addClass('private-ico').removeClass('public-ico');

                        for(var i=0, len=formUserIds.length; i < len; i++) {
                            $('#user' + formUserIds[i]).append('<span class="tag tag'+ data.id +'" data-tagId="'+ data.id +'">'+ name +' <span class="del">&times;</span></span>');
                        }

                        /* Reset initial state */
                        formUserIds = []
                        $('#feed .selected-user').removeClass('selected-user');

                        /* Display effect */
                        $('#area'+ data.id).slideDown(function() {
                            updateDropAreas();
                        });

                });
            }
        ;

        updateDropAreas();

        $('#sidebar .addform')
            .click(function() {
                $(this).find('.form').show();
                $(this).find('.form input').focus();
            });

        $('#sidebar .addform input')
            .keyup(function(e) {
                if(e.keyCode == 13) {
                    addNewList($(this).val(), $('#sidebar .addform .ico').hasClass('private-ico'));
                }
            });

        $('#sidebar .addform .ico')
            .click(function() {
                $(this).toggleClass('private-ico').toggleClass('public-ico');
            });

        $('#feed .user')
            .click(function(e) {
                if($(e.target).hasClass('del')) {
                    var
                        tag = $(e.target).parent('.tag'),
                        userId = tag.parents('.user').attr('data-userId'),
                        listCount = $('#area'+ tag.attr('data-tagId') +' .count')
                    ;
                    listCount.text(parseInt(listCount.text()) - 1);
                    tag.remove();

                    /* APPEL AJAX DE SUPPRESSION */
                    $.post('<?php echo elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/collection/removefromcollection");?>', {listId: tag.attr('data-tagId'), userId: userId}, function(data) {/* ? */});
                }
            })
            .mousedown(function(e) {
                if(!$(e.target).hasClass('del')) {
                    var curUser = $(this);
                    mdPageX = e.pageX;
                    mdPageY = e.pageY;
                    selectedCount = $('#feed .selected-user').length;

                    preventSelection();

                    $(document).mousemove(function(e) {
                        if(!$('#sidebar .folders').hasClass('drop-folders')) $('#sidebar .folders').addClass('drop-folders');
                        if(!curUser.hasClass('selected-user') && (e.pageX != mdPageX) && (e.pageY != mdPageY)) {
                            curUser.addClass('selected-user');
                            selectedCount = $('#feed .selected-user').length;
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
                        if((e.pageX > (mdPageX-5)) && (e.pageX < (mdPageX+5)) && (e.pageY > (mdPageY-5)) && (e.pageY < (mdPageY+5))) curUser.toggleClass('selected-user');

                        /* Reset initial state */
                        stopPreventSelection();
                        $('#mover').fadeOut(1000, function() { $('#mover').remove() });
                        $('#sidebar .folders').removeClass('drop-folders');

                        if($('#sidebar .highlight').length > 0) {
                            if($('#sidebar .highlight').hasClass('addform')) {

                                /* List of userId added */
                                formUserIds = []
                                $('#feed .selected-user').each(function() {
                                    formUserIds.push($(this).attr('data-userId'));
                                    /*$(this).append('<span class="tag tag'+ listId +'" data-tagId="'+ listId +'">'+ listName +' <span class="del">&times;</span></span>');*/
                                });

                                /* Add form */
                                var folder = $('#sidebar .highlight');
                                folder.removeClass('highlight');
                                folder.find('.count').text(formUserIds.length);
                                folder.find('.form').show();
                                $(this).find('.form input').focus();

                            } else {
                                /* User list infos */
                                var
                                    listId = $('#sidebar .highlight').attr('data-listId'),
                                    listName = $('#sidebar .highlight').attr('data-listName')
                                ;

                                /* List of userId added */
                                var addedUserIds = []
                                $('#feed .selected-user').each(function() {
                                    if($(this).find('.tag' + listId).length == 0) {
                                        addedUserIds.push($(this).attr('data-userId'));
                                        $(this).append('<span class="tag tag'+ listId +'" data-tagId="'+ listId +'">'+ listName +' <span class="del">&times;</span></span>');
                                    }
                                });

                                /* Adding effect */
                                var
                                    folder = $('#sidebar .highlight'),
                                    oldCount = folder.find('.count')
                                ;
                                oldCount.addClass('oldCount');
                                folder.addClass('increased').removeClass('highlight');
                                oldCount.fadeOut(400, function() {
                                    oldCount.removeClass('oldCount').text(parseInt(oldCount.text()) + addedUserIds.length);
                                    oldCount.fadeIn(600);
                                });
                                $('#mover').removeClass('hover');
                                $('#feed .selected-user').removeClass('selected-user');

                                /* APPEL AJAX D'ENREGISTREMENT */
                                $.post('<?php echo elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/collection/addtocollection");?>', {listId: listId, userIds: addedUserIds}, function(data) {/* ? */});

                                setTimeout(function() {
                                    folder.removeClass('increased');
                                }, 1500);
                            }
                        }

                        $(document).unbind('mousemove');
                        $(document).unbind('mouseup');
                    });
                }
            });
    });
$(document).ready(function(){
	$('#selectNone').click( function(){
		$("#discussion_list_container li").each(function () {
			if($(this).find('.statusbar').find(':checkbox').is(':checked')) {
				$(this).find('.statusbar').find(':checkbox').attr('checked', 'false');
			}
		});

	});
	$('#selectUnread').click( function(){
		$("#discussion_list_container li").each(function () {
			if(!$(this).hasClass('read')) {
				$(this).find('.statusbar').find(':checkbox').attr('checked', !$(this).find('.statusbar').find(':checkbox').is(':checked'));
			}
		});

	});
	$('#selectRead').click( function(){
		$("#discussion_list_container li").each(function () {
			if($(this).hasClass('read')) {
				$(this).find('.statusbar').find(':checkbox').attr('checked', !$(this).find('.statusbar').find(':checkbox').is(':checked'));
			}
		});

	});
	$('#selectAll').click( function(){
		$("#discussion_list_container li").each(function () {
			$(this).find('.statusbar').find(':checkbox').attr('checked', !$(this).find('.statusbar').find(':checkbox').is(':checked'));
		});

	});
});
</script>