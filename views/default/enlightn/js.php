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
	        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type)
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
	// pre-submit callback
	function showRequest(formData, jqForm, options) {
	    // formData is an array; here we use $.param to convert it to a string to display it
	    // but the form plugin does this for you automatically when it submits the data
	    var queryString = $.param(formData);

	    // jqForm is a jQuery object encapsulating the form element.  To access the
	    // DOM element for the form do this:
	    // var formElement = jqForm[0];

	    alert('About to submit: \n\n' + queryString);
	    // here we could return false to prevent the form from being submitted;
	    // returning anything other than false will allow the form submit to continue
	    return true;
	}

	// post-submit callback
	function showResponse(responseText, statusText, xhr, $form)  {
	    // for normal html responses, the first argument to the success callback
	    // is the XMLHttpRequest object's responseText property

	    // if the ajaxSubmit method was passed an Options Object with the dataType
	    // property set to 'xml' then the first argument to the success callback
	    // is the XMLHttpRequest object's responseXML property

	    // if the ajaxSubmit method was passed an Options Object with the dataType
	    // property set to 'json' then the first argument to the success callback
	    // is the json data object returned by the server

	    //alert('status: ' + statusText + '\n\nresponseText: \n' + responseText +
	    //    '\n\nThe output div should have already been updated with the responseText.');
	    popin.PPNclose();
		//return false;
	}
	function autoClose () {
		$('#new-post').removeClass('open');
		//changeMessageList('#discussion_selector_all');
	}
    function showNewDiscussionBox() {
        boxElm = $('#new-post');
        if (boxElm.addClass('open')) {

        }
       	$('button:[type="reset"] ').click( function(){
            $('#new-post').removeClass('open');
            $(".rte-zone").contents().find(".frameBody").html('');
            $("#new-post .textarea").css('height','85');
            $('#discussion_edit .dest').find("input").tokeninput("clear");
        });
        $('#add-tags').click(function () {
            $('#tags-input').toggle();
        });
    }
