// Buffer class. Has a public append method that expects some kind of Task.
// Constructor expects a handler which is a method that takes a ajax task
// and a callback. Buffer expects the handler to deal with the ajax and run
// the callback when it's finished
function Buffer(handler) {
    var queue = [];

    function run() {
        var callback = function () {
             // when the handler says it's finished (i.e. runs the callback)
             // We check for more tasks in the queue and if there are any we run again
             if (queue.length > 0) {
                   run();
             }
        }
        // give the first item in the queue & the callback to the handler
        handler(queue.shift(), callback);
    }

    // push the task to the queue. If the queue was empty before the task was pushed
    // we run the task.
    this.append = function(task) {
        queue.push(task);
        if (queue.length === 1) {
            run();
        }
    }

}

// small Task containing item & url & optional callback
function Task(item, url, params, datatype, callback) {
    this.item = item;
    this.url = url;
    this.params = params;
    this.datatype = datatype;
    this.callback = callback;
}

Array.prototype.in_array = function(p_val) {
	for(var i = 0, l = this.length; i < l; i++) {
		if(this[i] == p_val) {
			return true;
		}
	}
	return false;
}

function ajaxGet(task, callback) {
        // call an option callback from the task
        $.get(task.url,task.params, function(data, textStatus, XMLHttpRequest){
            if (task.callback) task.callback(task, data, textStatus, XMLHttpRequest);
		}, task.datatype);
        /*elm = $('#debug');
        if(typeof elm != undefined) {
            $('<p/>', {
                'class': 'debug',
                html:  new Date() + JSON.stringify(task)}).appendTo(elm);
        }*/
        // call the buffer callback.
        callback();
}


loadContent = function (divId,dataTo,method) {
	if (typeof method == 'undefined' || method == 'load') {
		if ($(divId).html().indexOf('loading.gif') == -1) {
			$(divId).prepend('<img src="<?php echo $vars['url'] ?>mod/enlightn/media/graphics/loading.gif" alt="loading">');
            buffer.append(new Task(divId, dataTo, false,'html',loadResults));
		}
	} else if (method == 'append') {
		buffer.append(new Task(divId, dataTo, false, 'html',appendResults));
	}
    return false;
}

function loadResults (task, data, textStatus, XMLHttpRequest) {
    $(task.item).html(data);
    lastModified = XMLHttpRequest.getResponseHeader('Last-Modified');
    queryUid = XMLHttpRequest.getResponseHeader('Query-uid');
    fetchedRows = XMLHttpRequest.getResponseHeader('Fetch-rows');
    foundRows = XMLHttpRequest.getResponseHeader('found-rows');

    if (typeof lastModified != 'undefined') {
        $('<input />', {
            'id' : 'lastModified' + queryUid
            ,'name': 'lastModified'
            ,'type': 'hidden'
            ,'value' : lastModified}).insertAfter(task.item);
    }
    if (typeof fetchedRows != 'undefined') {
        $('#see_more_discussion_list').toggle(parseInt(fetchedRows) > 9);
    }
    if (typeof foundRows != 'undefined') {
        $('#found-rows').html(foundRows);
        $('#offset').html(parseInt($('#see_more_discussion_list_offset').val()) + 1);
        $('#limit').html(parseInt($('#see_more_discussion_list_offset').val()) + parseInt($('#list_limit').val()));
    }
}

function appendResults (task, data, textStatus, XMLHttpRequest) {
    fetchedRows = XMLHttpRequest.getResponseHeader('Fetch-rows');
    $(task.item).append(data);
    if (typeof fetchedRows != 'undefined') {
        $('#see_more_discussion_list').toggle(parseInt(fetchedRows) > 9);
    }
}

reloader = function (url_to_check, element_id) {
    setInterval(function() {
        buffer.append(new Task(element_id, url_to_check + get_search_criteria(),{fetch_modified: "1"}, 'json',loadIfModified));
    }, 5000);
}

function loadIfModified (task, data, textStatus, XMLHttpRequest) {
    var offset = $('#see_more_discussion_list_offset').val();
    lastModified = XMLHttpRequest.getResponseHeader('Last-Modified');
    queryUid = XMLHttpRequest.getResponseHeader('Query-uid');
    lastCalled = $('#lastModified' + queryUid).val();
    if (lastModified != lastCalled && offset == '0') {
        //console.log(lastModified + ' != ' + lastCalled);
        loadContent (task.item, task.url + get_search_criteria());
    }
}

function updateDiscussionUnread (task, data, textStatus, XMLHttpRequest) {
    var totalUnreaded = 0;
    $.each(data, function(i,item){
        var received_value = item;
        var nav_element = $("#nav_unreaded_" + i);
        if (i != '<?php echo ENLIGHTN_ACCESS_PU;?>') {
            totalUnreaded += parseInt(received_value);
        }
        if(typeof nav_element == 'object') {
            if (nav_element.html() != received_value) {
                if (received_value == '0') {
                    nav_element.html('');
                } else {
                    nav_element.html(received_value);
                }
            }
        }
    });
    if (totalUnreaded > 0) {
        document.title = task.item + '(' + totalUnreaded + ')';
    }
}


function get_search_criteria (fromLink) {
    if (fromLink) {
        $('#subtype_checked').val('');
        $('#searchInput').val('');
        $('input[name="from_users"]').val('');
        $('#date_end').val('');
        $('#date_begin').val('');
        $('#search_tags').val('');
        tags = $('#discussion_selector_tags .tag');
        tags.each(function() {
            $(this).css('font-weight','normal');
        });
    }
	if (typeof $('#subtype_checked').val() == 'undefined') {
		var subtype = '';
	} else {
		var subtype = $('#subtype_checked').val();
	}
	if (typeof $('input[name="q"]').val() == 'undefined') {
		var words = '';
	} else {
            tmp_words = $('input[name="q"]').val().split(',');
            $('#search_tags').val('');
            tmp_tag = [];
            tmp_word = [];
            for (i=0;i<tmp_words.length;i++) {
                if (tmp_words[i].indexOf('tag_') > -1) {
                    tmp_tag.push(tmp_words[i].replace('tag_',''));
                } else {
                    tmp_word.push(tmp_words[i]);
                }
            }
            if (tmp_tag.length>0) {
                $('#search_tags').val(tmp_tag.join(','));
            }
            words = tmp_word.join(' ');
	}
	if (typeof $('input[name="from_users"]').val() == 'undefined') {
		var from_users = '';
	} else {
		var from_users = $('input[name="from_users"]').val();
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
	if (typeof $('#showunread').val() == 'undefined') {
		var unreaded_only = 0;
	} else {
		var unreaded_only = $('#showunread').attr('checked')=='checked'?1:0;
	}
        if (typeof $('#search_tags').val() == 'undefined') {
		var search_tags = '';
	} else {
		var search_tags = $('#search_tags').val();
	}
        if (typeof $('#list_limit').val() == 'undefined') {
		var list_limit = 10;
	} else {
		var list_limit = $('#list_limit').val();
	}
        if (typeof $('#filter_id').val() == 'undefined') {
		var filter_id = '';
	} else {
		var filter_id = $('#filter_id').val();
	}
	if(words || subtype || date_begin || date_end || search_tags) {
		discussion_type = 4;
		$('#discussion_type').val(discussion_type);
        if (search_tags) {
            currElement = '#discussion_selector_tags';
        } else if(!fromLink) {
            currElement = '#discussion_selector_<?php echo ENLIGHTN_ACCESS_AL?>';
        } else  {
            currElement = '#discussion_selector_sent';
        }
        $(".folders li").each(function () {
            $(this).removeClass('current');
        });

        $(currElement).addClass('current');
        $(currElement).css('display','block');
	}

	var search_criteria = '?q=' + encodeURIComponent(words)
							+ '&date_begin=' + date_begin
							+ '&date_end=' + date_end
							+ '&from_users=' + from_users
							+ '&offset=' + $('#see_more_discussion_list_offset').val()
							+ '&subtype=' + subtype
							+ '&discussion_type=' + discussion_type
							+ '&entity_guid=' + entity_guid
							+ '&unreaded_only=' + unreaded_only
							+ '&limit=' + list_limit
							+ '&filter_id=' + filter_id
							+ '&tags=' + search_tags;

	return search_criteria;
}


	function changeMessageList (currElement, discussion_type) {
		if (typeof $('#discussion_list_container') == undefined) {
			window.location.replace("<?php echo $vars['url']; ?>home/" + discussion_type);
			return false;
		}
		if(typeof discussion_type == undefined) {
			discussion_type = $('#discussion_type').val();
		}

        if (currElement != '#discussion_selector_sent') {
            $('input[name="from_users"]').val('');
        }

		$('#discussion_type').val(discussion_type);
		$('#see_more_discussion_list_offset').val(0);
        fromLink = discussion_type=='tags'||discussion_type==<?php echo ENLIGHTN_ACCESS_AL?>?false:true;
        loadContent('#discussion_list_container','<?php echo $vars['url']; ?>mod/enlightn/ajax/search.php' + get_search_criteria(fromLink));

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
    function showHideForward () {
        $('#feed.detail .msg .checkbox').each(function (key,item) {
            $(item).toggle();
        });
        $('#new-post').fadeToggle();
        $('#forwardActionButton').fadeToggle();
    }
$(document).ready(function(){
    var deletedKeywords = [];
    $('#add-tags')
        .click(function () {
        $('#tags-input')
            .toggle();
    });
    $(".saved-search-label-apply").click(function () {
        $(".saved-search-select ul").toggle();
    });

    $('#tags-result')
        .click(function(e) {
            if($(e.target).hasClass('del')) {
                var
                    tag = $(e.target).parent('.tag'),
                    tags = $('#tags-result .tag'),
                    addedKeywords = [];
                deletedKeywords.push(tag.attr('data-keyword'));
                tag.remove();
                tags.each(function() {
                    addedKeywords.push($(this).attr('data-keyword'));
                });
                $('#tags').val(addedKeywords.join(','));
            }
        });
       $('.textarea')
        .mouseleave(function(e) {
                var text = $('#title').val() + '  ' + $(".rte-zone").contents().find(".frameBody").html(),
                    elm = $('#tags-result'),
                    tags = $('#tags-result .tag');
                    addedKeywords = [];
                tags.each(function() {
                    addedKeywords.push($(this).attr('data-keyword'));
                });
                if (text.length <= 10) {
                    return false;
                }
                if (elm.html().indexOf('loading.gif') != -1) {
                    return false;
                }
                elm.prepend('<img src="<?php echo $vars['url'] ?>mod/enlightn/media/graphics/loading.gif">');
                $.post('<?php echo "{$vars['url']}mod/enlightn/ajax/tagger.php";?>', {text: text}, function(data) {
                    $.each(data, function(keyword, accurency){
                        if (accurency > 1 && keyword && !addedKeywords.in_array(keyword) && !deletedKeywords.in_array(keyword)) {
                            elm.append('<span class="tag" data-keyword="' + keyword + '">'+ keyword +' <span class="del">&times;</span></span>');
                        }
                    });
                    if (addedKeywords.length == 0) {
                        tags = $('#tags-result .tag');
                        tags.each(function() {
                            addedKeywords.push($(this).attr('data-keyword'));
                        });
                        $('#tags').val(addedKeywords.join(','));
                    }
                    elm.find('img').remove();
                    //got keyword... let's suggest
                    $.get('<?php echo "{$vars['url']}mod/enlightn/ajax/get_user_by_tags.php";?>', {tags: $('#tags').val()}, function(data) {
                        if (data) {
                            user_elm = $('#user_suggest');
                            user_elm.html('');
                            user_elm.append('<?php echo elgg_echo('enlightn:discussionusersuggest')?> :');
                            $.each(data, function(user_guid, user_name){
                                user_elm.append('<span class="user_suggest" data-user-id="' + user_guid + '" data-user-name="' + user_name + '">'+ user_name +'</span>');
                            });
                            $(".user_suggest").click(function () {
                                var elm = $(this),
                                    token_elm  = $('input[name="invite"]');
                                token_elm.tokenInput("add", {id: elm.attr('data-user-id'), name: elm.attr('data-user-name')});
                                elm.remove();
                                return false;
                            });
                        }
                    },'json');
                },'json');
                $('#tags').val(addedKeywords.join(','));
            });


	$('#forwardParts').click( function() {
        var title = $("#discussionTitle").html(),
            entity_guid = $("#topic_guid").val(),
            cloned = new Array();

        $('#discussion_list_container li input[type=checkbox]:checked').each(function (key,item) {
            loadContent('#clonedMessages','<?php echo $vars['url']; ?>mod/enlightn/ajax/search.php?annotation_id=' + $(item).val() + '&entity_guid=' + entity_guid, 'append');
            cloned.push($(item).val());
        });
        showNewDiscussionBox(title, false, false, cloned);
    });
	$('#forwardAction').click( function() {
        if ($('#viewDiscussionCloud').hasClass('current')) {
            $('#viewDiscussion').triggerHandler("click");
        }
        showHideForward();
    });
	$('#forwardCancel').click( function() {
        showHideForward();
    });

    $('#discussion_selector_tags .tag').click( function() {
        tags = $('#discussion_selector_tags .tag');
        tags.each(function() {
            $(this).css('font-weight','normal');
        });

        if ($('#search_tags').val() != $(this).attr('data-id')) {
            $('#search_tags').val($(this).attr('data-keyword'));
            $(this).css('font-weight','bold');
        } else {
            $('#search_tags').val('');
        }
        token_elm  = $('input[name="q"]');
        token_elm.tokenInput("clear");
        token_elm.tokenInput("add", {id: 'tag_' + $(this).attr('data-id'), name: $(this).attr('data-name')});
    });
	$('#search .filters li input').click( function(){
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
    $('#viewDiscussionCloud').click( function(){
       $('#discussion_list_container').attr('id','cloud_content');
       loadContent('#cloud_content','<?php echo $vars['url'] ?>/mod/enlightn/ajax/get_my_cloud.php?limit=100&guid='  + $('#entity_guid').val());
       $('#viewDiscussion').toggleClass('current');
       $(this).toggleClass('current');
    });
    $('#viewDiscussion').click( function(){
        $('#cloud_content').html('');
        $('#cloud_content').attr('id','discussion_list_container');
        loadContent('#discussion_list_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/search.php'  + get_search_criteria());
        $('#viewDiscussionCloud').toggleClass('current');
        $(this).toggleClass('current');

    });
    $('#search .s-actions').click( function(){
        $('#search .toggle-search-filters').toggleClass('full');
        $(this).find('span').toggleClass('arrow-top');
    });
    $('#expand').click( function(){
        $('#expand span').toggleClass('arrow-top');
        $("#discussion_list_container li").each(function () {
            if ($('#expand span').hasClass('arrow-top')) {
                $(this).addClass('open-msg');
            } else {
                $(this).removeClass('open-msg');
            }
        });
    });
    $('#privacy_cursor').click( function(){
        if($(this).parent().hasClass('private')) {
            $(this).parent().removeClass('private');
            $(this).parent().addClass('public');
            $('#membership').val(<?php echo ENLIGHTN_ACCESS_PUBLIC?>);
        } else {
            $(this).parent().removeClass('public');
            $(this).parent().addClass('private');
            $('#membership').val(<?php echo ENLIGHTN_ACCESS_PRIVATE?>);
        }
    });
    $('#autoReply').click(function () {
        $('#add_post .sending .submit').toggle();
    });

    $('#detail .toggle').click( function(){
        $('#detail').toggleClass('full');
	});
	$('#selectNone').click( function(){
		$("#discussion_list_container li").each(function () {
            $(this).find('.statusbar').find(':checkbox').attr('checked', false);
		});

	});
	$('#selectUnread').click( function(){
		$("#discussion_list_container li").each(function () {
            $(this).find('.statusbar').find(':checkbox').attr('checked', false);
			if(!$(this).hasClass('read')) {
				$(this).find('.statusbar').find(':checkbox').attr('checked', !$(this).find('.statusbar').find(':checkbox').is(':checked'));
			}
		});

	});
	$('#selectRead').click( function(){
		$("#discussion_list_container li").each(function () {
            $(this).find('.statusbar').find(':checkbox').attr('checked', false);
			if($(this).hasClass('read')) {
				$(this).find('.statusbar').find(':checkbox').attr('checked', !$(this).find('.statusbar').find(':checkbox').is(':checked'));
			}
		});
	});
	$('#showunread').click( function(){
        currElement = '#discussion_selector_' + $('#discussion_type').val();
		changeMessageList(currElement,$('#discussion_type').val());
	});
	$('#selectAll').click( function(){
        var toCheck = $(this).attr('checked')=='checked'?true:false;
		$("#discussion_list_container li").each(function () {
			$(this).find('.statusbar').find(':checkbox').attr('checked', toCheck);
		});

	});

    $('#cloud .header button').click(function(){
    	pos = $(this).position();
    	elmTop = pos.top - 20 + 'px';
    	$('#layer').css('top',elmTop);
    	$('#layer').css('z-index',10000);
    	$('#embedContent').css('display','block');
        return false;
    });

    $("#settings_tabs .settings_tabs li").click(function () {
        elm = $(this);
        toShowElm = $('#tab' + $(this).attr('id'));
        elm.addClass('current');
        toShowElm.css('display','block');
        $("#settings_tabs .settings_tabs li").each(function () {
            if ($(this).attr('id') != elm.attr('id')) {
                $(this).removeClass('current');
                $('#tab' + $(this).attr('id')).css('display','none');
            }
        });
    });
    $("#socialLinkAdd").change(function () {
        var linkerUrl = new Array();
        <?php
        global $sn_linkers;
        foreach ($sn_linkers as $key => $name) {
            echo "\t\tlinkerUrl['" . $name . "'] = '" . elgg_echo('profile:linkhelper:' . $name) . "';\n";
        }
        ?>
        elm = $(this);
        elmSelected = $('#socialLinkAdd option:selected');
        newElmId = elm.attr('value');
        $('<p />',{ 'id' : newElmId}).insertAfter(elm.parent());
        newElm = $('#' + newElmId);
        newElm.append('<label><img class="photo_linker" src="<?php echo $vars['url'] ?>mod/enlightn/media/graphics/linker/' + elmSelected.text() + '.png"  /></label>');
        newElm.append($('<input />', {
	            		'name' : elm.attr('value')
	    				,'type': 'text'}));
        newElm.append(' ' + '<em>' + linkerUrl[elmSelected.text()] + '</em>');
    });
    $(".player").click(function () {
        elm = $(this);
        elm.html(elm.find('input').val()).fadeIn();

    });
	$('.status-box').click( function(){
        showNewDiscussionBox();
	});
	    var options = {
	        target:        '#new-discussion-submission',   // target element(s) to be updated with server response
	        beforeSubmit:  loading,  // pre-submit callback
	        success:       autoClose,  // post-submit callback
                type:      'post',        // 'get' or 'post', override for form's 'method' attribute
	        dataType:  'json'
	    };

	    // bind to the form's submit event
	    $('#discussion_edit').submit(function() {
	        $(this).ajaxSubmit(options);
	        return false;
	    });
	});

	function loading () {
		$('#new-discussion-submission').prepend('<img src="<?php echo $vars['url'] ?>mod/enlightn/media/graphics/loading.gif" alt="loading">');
	}

	function autoClose (data) {
        if(data.success) {
        	$('#new-discussion').removeClass('open');
            $(".rte-zone").contents().find(".frameBody").html('');
            $("#new-discussion .textarea").css('height','185');
       		$(".rte-zone").contents().find(".frameBody").css('height','185');
            tokenInputName = $('#discussion_edit input:text[name=invite]').attr('id');
            $('#new-discussion-submission').html('');
            $('#clonedMessages').html('');
            $('#' + tokenInputName).tokenInput("clear");
            $('#privacy_cursor').parent().removeClass('public');
			$('#privacy_cursor').parent().addClass('private');
			$('#membership').val(<?php echo ENLIGHTN_ACCESS_PRIVATE?>);
            $(".dialog-overlay").css('display','none');
            $('#user_suggest').html('');
            $('#tags-result .tags').html('');
            if ($('#forwardActionButton').css('display') === 'block') {
                showHideForward();
            } else {
                changeMessageList();
            }
        } else {
            $('#new-discussion-submission').html(data.message);
        }

	}
    function showNewDiscussionBox(title,message,dest,cloned) {
        var boxElm = $('#new-discussion');
        if (boxElm.addClass('open')) {
            boxElm.draggable();
            $("#new-discussion .textarea").css('height','185');
            $(".dialog-overlay").css('display','block');
            if (title) {
                $("#title").val(title);
            }
            if (cloned) {
                clonedIds = cloned.join(',');
                $('#cloned_ids').val(clonedIds);
            }
        }
       	$('button:[type="reset"] ').click( function(){
            $('#new-discussion').removeClass('open');
            $(".rte-zone").contents().find(".frameBody").html('');
            tokenInputName = $('#discussion_edit input:text[name=invite]').attr('id');
            $('#new-discussion-submission').html('');
            $('#' + tokenInputName).tokenInput("clear");
            $('#privacy_cursor').parent().removeClass('public');
			$('#privacy_cursor').parent().addClass('private');
			$('#membership').val(<?php echo ENLIGHTN_ACCESS_PRIVATE?>);
            $('#clonedMessages').html('');
            $('#tags-result').html('');
            $(".dialog-overlay").css('display','none');
            $('#user_suggest').html('');
            $('#tags-result .tags').html('');
        });
    }

    function getEmbedPreview (fileGuid) {
        alert("abouttofetch");
        $.get("<?php echo $vars['url'] ?>mod/enlightn/ajax/embed_preview.php?guid=" + fileGuid);
    }

    function updateRte (content) {
        elm = $(".rte-zone").contents().find(".frameBody");
        if (elm) {
            elm.html(elm.html() + "<br/>" + content + "<br/><br/>");
        }
    }

/*
* jQuery RTE plugin 0.5.1 - create a rich text form for Mozilla, Opera, Safari and Internet Explorer
*
* Copyright (c) 2009 Batiste Bieler
* Distributed under the GPL Licenses.
* Distributed under the MIT License.
*/

// define the rte light plugin
(function($) {

if(typeof $.fn.rte === "undefined") {

    var defaults = {
        media_url: "",
        content_css_url: "rte.css",
        dot_net_button_class: null,
        max_height: 350
    };

    $.fn.rte = function(options) {

    var complete_mode = false;

    $.fn.rte.html = function(iframe) {
        return iframe.contentWindow.document.getElementsByTagName("body")[0].innerHTML;
    };

    // build main options before element iteration
    var opts = $.extend(defaults, options);

    // iterate and construct the RTEs
    return this.each( function() {
        var textarea = $(this);
        var iframe;
        var element_id = textarea.attr("id");

        // enable design mode
        function enableDesignMode() {

            var content = textarea.val();


            // already created? show/hide
            if(iframe) {
                textarea.hide();
                $(iframe).contents().find("body").html(content);
                $(iframe).show();
                $("#toolbar-" + element_id).remove();
                textarea.before(toolbar());
                return true;
            }

            // for compatibility reasons, need to be created this way
            iframe = document.createElement("iframe");
            iframe.frameBorder=0;
            iframe.frameMargin=0;
            iframe.framePadding=0;
            iframe.height=0;
            if(textarea.attr('class'))
                iframe.className = textarea.attr('class');
            if(textarea.attr('id'))
                iframe.id = element_id;
            if(textarea.attr('name'))
                iframe.title = textarea.attr('name');
            textarea.after(iframe);

            var css = "";
            if(opts.content_css_url) {
                css = "<link type='text/css' rel='stylesheet' href='" + opts.content_css_url + "' />";
            }
            var doc = "<html><head>"+css+"</head><body class='frameBody' id='iframe" + element_id + "'>"+content+"</body></html>";
            tryEnableDesignMode(doc, function() {
                $("#toolbar-" + element_id).remove();
                textarea.before(toolbar());
                // hide textarea
                textarea.hide();

            });

        }

        function tryEnableDesignMode(doc, callback) {
            if(!iframe) { return false; }

            try {
                iframe.contentWindow.document.open();
                iframe.contentWindow.document.write(doc);
                iframe.contentWindow.document.close();
            } catch(error) {
                //console.log(error);
            }
            if (document.contentEditable) {
                iframe.contentWindow.document.designMode = "On";
                callback();
                return true;
            }
            else if (document.designMode != null) {
                try {
                    iframe.contentWindow.document.designMode = "on";
                    callback();
                    return true;
                } catch (error) {
                    //console.log(error);
                }
            }
            setTimeout(function(){tryEnableDesignMode(doc, callback)}, 500);
            return false;
        }

        function disableDesignMode(submit) {
            var content = $(iframe).contents().find("body").html();

            if($(iframe).is(":visible")) {
                textarea.val(content);
            }

            if(submit !== true) {
                textarea.show();
                $(iframe).hide();
            }
        }

        // create toolbar and bind events to it's elements
        function toolbar() {
            var tb = $("<ul class='toolbar' id='toolbar-"+ element_id +"'>\
			<!--<li>\
		        <select>\
		            <option value=''>Block style</option>\
		            <option value='p'>Paragraph</option>\
		            <option value='h3'>Title</option>\
		            <option value='address'>Address</option>\
		        </select>\
		    </li>-->\
	        <li class='bold' title='<?php echo elgg_echo('enlightn:title:bold')?>'><span class='ico'></span></li>\
	        <li class='italic' title='<?php echo elgg_echo('enlightn:title:italic')?>'><span class='ico'></span></li>\
	        <li id='unorderedlist' class='new-gp ul' title='<?php echo elgg_echo('enlightn:title:bulletpoints')?>'><span class='ico'></span></li>\
		    <li id='embedLink' class='new-gp link' title='<?php echo elgg_echo('enlightn:title:link')?>'><span class='ico'></span></li>\
            <li class='video' title='<?php echo elgg_echo('enlightn:title:video')?>'><span class='ico'></span></li>\
            <li class='pict' title='<?php echo elgg_echo('enlightn:title:picture')?>'><span class='ico'></span></li>\
            <li class='doc' title='<?php echo elgg_echo('enlightn:title:document')?>'><span class='ico'></span></li>\
		    <li class='disable'><a href='#' class='disable'>&times;</a></li>\
    </ul>");

            $('select', tb).change(function(){
                var index = this.selectedIndex;
                if( index!=0 ) {
                    var selected = this.options[index].value;
                    formatText("formatblock", '<'+selected+'>');
                }
            });
            $('.bold', tb).click(function(){ formatText('bold');return false; });
            $('.italic', tb).click(function(){ formatText('italic');return false; });
            $('.ul', tb).click(function(){ formatText('insertunorderedlist');return false; });
            $('.doc', tb).click(function(){
            	pos = $(this).position();
            	elmTop = pos.top + 'px';
            	$('#layer').css('top',elmTop);
            	$('#embedContent').css('display','block');
            });
            $('.link', tb).click(function(){
                var p=prompt("<?php echo elgg_echo('enlightn:prompt:link')?>");
                if(p)
                    formatText('insertHTML', p);
                return false; });
            $('.video', tb).click(function(){
                var p=prompt("<?php echo elgg_echo('enlightn:prompt:video')?>");
                if(p)
                    formatText('insertHTML', p);
                return false; });
            $('.pict', tb).click(function(){
                var p=prompt("<?php echo elgg_echo('enlightn:prompt:picture')?>");
                if(p)
                    formatText('insertHTML', p);
                return false; });
            $('.disable', tb).click(function() {
                disableDesignMode();
                var edm = $('<a class="rte-edm" href="#"><?php echo elgg_echo('enlightn:enabledesignmode')?></a>');
                tb.empty().append(edm);
                edm.click(function(e){
                    e.preventDefault();
                    enableDesignMode();
                    // remove, for good measure
                    $(this).remove();
                });
                return false;
            });

            // .NET compatability
            if(opts.dot_net_button_class) {
                var dot_net_button = $(iframe).parents('form').find(opts.dot_net_button_class);
                dot_net_button.click(function() {
                    disableDesignMode(true);
                });
            // Regular forms
            } else {
                $(iframe).parents('form').submit(function(){
                    disableDesignMode(true);
                });
            }

            var iframeDoc = $(iframe.contentWindow.document);

            var select = $('select', tb)[0];
            iframeDoc.mouseup(function(){
                setSelectedType(getSelectionElement(), select);
                return true;
            });

            iframeDoc.keyup(function(e) {
                var body = $('body', iframeDoc);
               	var scrollHeight = $('body', iframeDoc)[0].scrollHeight;
                if(scrollHeight > (parseInt(body.css('height'))-14) && scrollHeight < 300) {
                    $('.textarea').css('height',scrollHeight+28);
                    $('.rte-zone').css('height',scrollHeight);
                }
                if(e.keyCode == 13) {
                    if($('#autoReply').attr('checked')=='checked') {
                        $('#add_post').submit();
                        $(iframe).contents().find("body").html('');
                        $(iframe).contents().find("body").focus();
                        $(iframe).contents().find("body").select();
                        return true;
                    }
                }
                /*if(e.keyCode == 50) {
                    complete_mode = true;
                }
                if (complete_mode) {
                    var content = $(iframe).contents().find("body"),
                    elm = parent.$('.mediaAutocomplete'),
                    attach_elm = $('#'+element_id).parent().position(),
                    complete_elm = parent.$('#token-input-mediaAutocomplete'),
                    to_search = content.html().substring((content.html().indexOf("@")+1),content.html().length);
                    elm
                        .css('top',(attach_elm.top) + "px")
                        .css('left',attach_elm.left + "px");
                    complete_elm
                        .val(to_search)
                        .parent().find('tester').html(to_search);
                    complete_elm.triggerHandler("keydown");
                }*/

                setSelectedType(getSelectionElement(), select);
                return true;
            });

            return tb;
        };

        function formatText(command, option) {
            iframe.contentWindow.focus();
            try{
                iframe.contentWindow.document.execCommand(command, false, option);
            }catch(e){
                //console.log(e)
            }
            iframe.contentWindow.focus();
        };

        function setSelectedType(node, select) {
            //disable this part, select removed from the toolbar..
            /*while(node.parentNode) {
                var nName = node.nodeName.toLowerCase();
                for(var i=0;i<select.options.length;i++) {
                    if(nName==select.options[i].value){
                        select.selectedIndex=i;
                        return true;
                    }
                }
                node = node.parentNode;
            }
            select.selectedIndex=0;*/
            return true;
        };

        function getSelectionElement() {
            if (iframe.contentWindow.document.selection) {
                // IE selections
                selection = iframe.contentWindow.document.selection;
                range = selection.createRange();
                try {
                    node = range.parentElement();
                }
                catch (e) {
                    return false;
                }
            } else {
                // Mozilla selections
                try {
                    selection = iframe.contentWindow.getSelection();
                    range = selection.getRangeAt(0);
                }
                catch(e){
                    return false;
                }
                node = range.commonAncestorContainer;
            }
            return node;
        };

        // enable design mode now
        enableDesignMode();

    }); //return this.each

    }; // rte

} // if

})(jQuery);

// create a buffer object with a taskhandler
var buffer = new Buffer(ajaxGet);

/**
 * Update "Port" textbox at login page.
 */

function updateLoginPort() {
  var servtype = $('#emailservtype option:selected').val();
  if (servtype == 'imap') {
    $('#emailport').val('143');
  }
  else if (servtype == 'notls') {
    $('#emailport').val('143');
  }
  else if (servtype == 'ssl') {
    $('#emailport').val('993');
  }
  else if (servtype == 'ssl/novalidate-cert') {
    $('#emailport').val('993');
  }
  else if (servtype == 'pop3') {
    $('#emailport').val('110');
  }
  else if (servtype == 'pop3/notls') {
    $('#emailport').val('110');
  }
  else if (servtype == 'pop3/ssl') {
    $('#emailport').val('995');
  }
  else if (servtype == 'pop3/ssl/novalidate-cert') {
    $('#emailport').val('995');
  }
}


function setCookie(name,value,days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function deleteCookie(name) {
    setCookie(name,"",-1);
}