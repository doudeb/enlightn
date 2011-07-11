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
	<script type="text/javascript" src="http://sd-26506.dedibox.fr/vendors/jquery/jquery-ui-1.7.2.min.js"></script>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>_css/js.php?lastcache=<?php echo $vars['config']->lastcache; ?>&amp;js=initialise_elgg&amp;viewtype=<?php echo $vars['view']; ?>"></script>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/enlightn/media/js/jquery.popin.js"></script>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/enlightn/media/js/jquery.rte.js"></script>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/enlightn/media/js/jquery.tokeninput.js"></script>
<?php
	global $pickerinuse;
	if (isset($pickerinuse) && $pickerinuse == true) {
?>
	<!-- only needed on pages where we have friends collections and/or the friends picker -->
	<script type="text/javascript" src="<?php echo $vars['url']; ?>vendors/jquery/jquery.easing.1.3.packed.js"></script>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>_css/js.php?lastcache=<?php echo $vars['config']->lastcache; ?>&amp;js=friendsPickerv1&amp;viewtype=<?php echo $vars['view']; ?>"></script>
<?php
	}
?>
	<!-- include the default css file -->
	<link rel="stylesheet" href="<?php echo $vars['url']; ?>_css/css.css?lastcache=<?php echo $vars['config']->lastcache; ?>&amp;viewtype=<?php echo $vars['view']; ?>" type="text/css" />
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
		}
 		$(divId).load(dataTo, function() {
 			//window.scrollTo(0, $(anchor).position().top);
	  		return true;
		});
	} else if (method == 'append') {
		$.get(dataTo, function(data){
			$(divId).append(data);
		});
	}
}

$('#search_submit').click( function(){
	//if ($('#searchInput').val().length >= 3) {
		$('#discussion_selector_search').css('display','block');
		changeMessageList('#discussion_selector_search');
	//}
});

function get_search_criteria () {
	if ($('#subtype_checked').val() == undefined) {
		var subtype = '';
	} else {
		var subtype = $('#subtype_checked').val();
	}

	if ($('#searchInput').val() == undefined) {
		var words = '';
	} else {
		var words = $('#searchInput').val();
	}
	if ($('#from_users').val() == undefined) {
		var from_users = '';
	} else {
		var from_users = $('#from_users').val();
	}
	if ($('#date_end').val() == undefined) {
		var date_end = '';
	} else {
		var date_end = $('#date_end').val();
	}
	if ($('#date_begin').val() == undefined) {
		var date_begin = '';
	} else {
		var date_begin = $('#date_begin').val();
	}
	if ($('#discussion_type').val() == undefined) {
		var discussion_type = 1;
	} else {
		var discussion_type = $('#discussion_type').val();
	}
	if ($('#entity_guid').val() == undefined) {
		var entity_guid = 0;
	} else {
		var entity_guid = $('#entity_guid').val();
	}
	if ($('#unreaded_only').val() == undefined) {
		var unreaded_only = 0;
	} else {
		var unreaded_only = $('#unreaded_only').val();
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
		$('#searchInput').click( function(){
		});
	});

	var refreshSearch = setInterval(function() {
		if ($('#searchInput').val() != '<?php echo elgg_echo('search')?>' && $('#searchInput').val().length > 2) {
	    	if($('#searchInput').val() != $('#last_search').val()) {
	    		$('#last_search').val($('#searchInput').val());
				changeMessageList('#discussion_selector_search',$('#discussion_type_filter').val());
	    	}
		}
	}, 1500);

	function changeMessageList (currElement, discussion_type) {
		if(discussion_type == undefined) {
			discussion_type = 1;
		}
		$('#discussion_type').val(discussion_type);
		$('#see_more_discussion_list_offset').val(0);
		loadContent('#discussion_list_container','<?php echo $vars['url']; ?>mod/enlightn/ajax/search.php' + get_search_criteria());
		$(currElement).addClass('current');
		$(".folders li").each(function () {
			if($(this).attr('id') != $(currElement).attr('id')) {
				$(this).removeClass('current');
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
		var last_modified = '0';
		setInterval(function() {
			var offset = $('#see_more_discussion_list_offset').val();
			$.getJSON(url_to_check + get_search_criteria(),{fetch_modified: "1"}, function(data) {
				$.each(data, function(i,item){
					if (i == 'last-modified' && offset == '0') {
						if (last_modified != item) {
							if (last_modified != '0') {
								loadContent (element_id, url_to_check + get_search_criteria());
							}
							last_modified = item;
						}
					}
				});
			});
		}, 5000);
	}
</script>