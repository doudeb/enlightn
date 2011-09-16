function loadContent (divId,dataTo,method) {
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
	if (typeof $('input:text[name=from_users]').val() == 'undefined') {
		var from_users = '';
	} else {
		var from_users = $('input:text[name=from_users]').val();
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
		$('#discussion_type').val(discussion_type);
		currElement = '#discussion_selector_<?php echo ENLIGHTN_ACCESS_AL?>';
		$(".folders li").each(function () {
			$(this).removeClass('current');
		});
		$(currElement).addClass('current');
		$(currElement).css('display','block');
	} else {
		currElement = '#discussion_selector_<?php echo ENLIGHTN_ACCESS_AL?>';
		$(currElement).removeClass('current');
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


	function changeMessageList (currElement, discussion_type) {
		if (typeof $('#discussion_list_container') == undefined) {
			window.location.replace("<?php echo $vars['url']; ?>home/" + discussion_type);
			return false;
		}
		if(typeof discussion_type == undefined) {
			discussion_type = 1;
		}
		if (discussion_type == 4) {
			currElement = '#discussion_selector_<?php echo ENLIGHTN_ACCESS_AL?>';
			$(currElement).css('display','block');
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
});


	function reloader (url_to_check, element_id) {
		setInterval(function() {
			var offset = $('#see_more_discussion_list_offset').val();
			$.getJSON(url_to_check + get_search_criteria(),{fetch_modified: "1"}, function(data, textStatus, jqXHR) {
				lastModified = jqXHR.getResponseHeader('Last-Modified');
			 	queryUid = jqXHR.getResponseHeader('Query-uid');
			 	lastCalled = $('#lastModified' + queryUid).val();
			 	//alert(lastModified + ' != ' + lastCalled);
			 	if (lastModified != lastCalled && offset == '0') {
                    //console.log(lastModified + ' != ' + lastCalled);
			 		loadContent (element_id, url_to_check + get_search_criteria());
			 	}
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

$(document).ready(function(){
 	$('#detail .toggle').click( function(){
        $('#detail').toggleClass('full');
	});
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

    $('#cloud .header button').click(function(){
    	pos = $(this).position();
    	elmTop = pos.top - 20 + 'px';
    	$('#layer').css('top',elmTop);
    	$('#layer').css('z-index',11000);
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
	    				,'type': 'text'
			 			,'value' : linkerUrl[elmSelected.text()]}));
    });
    $(".player").click(function () {
        elm = $(this);
        elm.html(elm.find('input').val()).fadeIn();

    });
	$('.status-box').click( function(){
        showNewDiscussionBox();
	});
	    var options = {
	        target:        '#submission',   // target element(s) to be updated with server response
	        beforeSubmit:  showLoading,  // pre-submit callback
	        success:       autoClose,  // post-submit callback

	        // other available options:
	        //url:       url         // override for form's 'action' attribute
	      	type:      'post',        // 'get' or 'post', override for form's 'method' attribute
	        dataType:  'json',        // 'xml', 'script', or 'json' (expected server response type)
	        clearForm: true        // clear all form fields after successful submit
	        //resetForm: true        // reset the form after successful submit

	        // $.ajax options can be used here too, for example:
	        //timeout:   3000
	    };

	    // bind to the form's submit event
	    $('#discussion_edit').submit(function() {
	        // inside event callbacks 'this' is the DOM element so we first
	        // wrap it in a jQuery object and then invoke ajaxSubmit
	        $(this).ajaxSubmit(options);

	        // !!! Important !!!
	        // always return false to prevent standard browser submit and page navigation
	        return false;
	    });
	});

	function showLoading () {
		$('#submission').prepend('<img src="<?php echo $vars['url'] ?>/mod/enlightn/media/graphics/loading.gif" alt="loading">');
		$('#post').removeClass('open');
		return true;
	}

	function autoClose (data) {
        if(data.success) {
        	$('#new-post').removeClass('open');
            $(".rte-zone").contents().find(".frameBody").html('');
            $("#new-post .textarea").css('height','85');
            tokenInputName = $('#discussion_edit input:text[name=invite]').attr('id');
            $('#submission').html('');
            $('#' + tokenInputName).tokenInput("clear");
            //changeMessageList('#discussion_selector_all');
        } else {
            $('#submission').html(data.message);
        }

	}
    function showNewDiscussionBox() {
        boxElm = $('#new-post');
        if (boxElm.addClass('open')) {

        }
       	$('button:[type="reset"] ').click( function(){
            $('#new-post').removeClass('open');
            $(".rte-zone").contents().find(".frameBody").html('');
            $("#new-post .textarea").css('height','85');
            tokenInputName = $('#discussion_edit input:text[name=invite]').attr('id');
            $('#submission').html(data.message);
            $('#' + tokenInputName).tokenInput("clear");
        });
        $('#add-tags').click(function () {
            $('#tags-input').toggle();
        });
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

            // Mozilla needs this to display caret
            /*if($.trim(content)=='') {
                content = '<br />';
            }*/

            // already created? show/hide
            if(iframe) {
                console.log("already created");
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

            var doc = "<html><head>"+css+"</head><body class='frameBody' id='ifram" + element_id + "'>"+content+"</body></html>";
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
	        <li class='bold' title=''><span class='ico'></span></li>\
	        <li class='italic' title=''><span class='ico'></span></li>\
	        <li id='unorderedlist' class='new-gp ul' title=''><span class='ico'></span></li>\
		    <li id='embedLink' class='new-gp link' title=''><span class='ico'></span></li>\
            <li class='video' title=''><span class='ico'></span></li>\
            <li class='pict' title=''><span class='ico'></span></li>\
            <li class='doc' title=''><span class='ico'></span></li>\
		    <!--<li><a href='#' class='disable'><img src='"+opts.media_url+"close.gif' alt='close rte' /></a></li>-->\
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
                var p=prompt("URL:");
                if(p)
                    formatText('insertHTML', p);
                return false; });
            $('.video', tb).click(function(){
                var p=prompt("URL:");
                if(p)
                    formatText('insertHTML', p);
                return false; });
            $('.pict', tb).click(function(){
                var p=prompt("URL:");
                if(p)
                    formatText('insertHTML', p);
                return false; });
            $('.disable', tb).click(function() {
                disableDesignMode();
                var edm = $('<a class="rte-edm" href="#">Enable design mode</a>');
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

            iframeDoc.keyup(function() {
                setSelectedType(getSelectionElement(), select);
                var body = $('body', iframeDoc);
               	var scrollHeight = $('body', iframeDoc)[0].scrollHeight;
               	//alert('height');
                if(scrollHeight > parseInt(body.css('height'))-14) {
                    $('.textarea').css('height',scrollHeight+28);
                    $('.rte-zone').css('height',scrollHeight);
                    //alert(h);
                }
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