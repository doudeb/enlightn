<script>

$(document).ready(function(){

	$('.<?php echo ENLIGHTN_LINK?>').click( function(){
		elm = 'preview' + $(this).attr('id');
		if (!$('#' +elm).hasClass('bubble')) {
		    $('<span />', {
		            'id' : elm,
		    'class': 'bubble'}).insertAfter(this);
			loadContent('#' + elm,'<?php echo $vars['url']; ?>mod/enlightn/ajax/embed_preview.php?guid=' + $(this).attr('id'));
		} else {
			if (($('#' +elm).css('display')) == 'block') {
				$('#' +elm).css('display','none');
			} else {
				$('#' +elm).css('display','block');
			}
		}
		return false;
	});

	$('.<?php echo ENLIGHTN_MEDIA?>').click( function(){
		elm = 'preview' + $(this).attr('id');
		if (!$('#' +elm).hasClass('bubble')) {
		    $('<span />', {
		            'id' : elm,
		    'class': 'bubble'}).insertAfter(this);
			loadContent('#' + elm,'<?php echo $vars['url']; ?>mod/enlightn/ajax/embed_preview.php?guid=' + $(this).attr('id'));
		} else {
			if (($('#' +elm).css('display')) == 'block') {
				$('#' +elm).css('display','none');
			} else {
				$('#' +elm).css('display','block');
			}
		}
		return false;
	});
	$('.<?php echo ENLIGHTN_IMAGE?>').click( function(){
		elm = 'preview' + $(this).attr('id');
		if (!$('#' +elm).hasClass('bubble')) {
		    $('<span />', {
		            'id' : elm,
		    'class': 'bubble'}).insertAfter(this);
			loadContent('#' + elm,'<?php echo $vars['url']; ?>mod/enlightn/ajax/embed_preview.php?guid=' + $(this).attr('id'));
		} else {
			if (($('#' +elm).css('display')) == 'block') {
				$('#' +elm).css('display','none');
			} else {
				$('#' +elm).css('display','block');
			}
		}
		return false;
	});
	$('.<?php echo ENLIGHTN_DOCUMENT?>').click( function(){
		elm = 'preview' + $(this).attr('id');
		if (!$('#' +elm).hasClass('bubble')) {
		    $('<span />', {
		            'id' : elm,
		    'class': 'bubble'}).insertAfter(this);
			loadContent('#' + elm,'<?php echo $vars['url']; ?>mod/enlightn/ajax/embed_preview.php?guid=' + $(this).attr('id'));
		} else {
			if (($('#' +elm).css('display')) == 'block') {
				$('#' +elm).css('display','none');
			} else {
				$('#' +elm).css('display','block');
			}
		}
		return false;
	});

	$('#discussion_list_container li .excerpt').click( function(){
		if(!$(this).parent().hasClass('open-msg')) {
			$(this).parent().addClass('open-msg');

		} else {
			$(this).parent().removeClass('open-msg');
		}
	});
});

</script>