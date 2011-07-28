<script>

$(document).ready(function(){
	$('.<?php echo ENLIGHTN_LINK?>').click( function(){
	    $('<div />', {
	            'id' : 'preview' + $(this).attr('id'),
	    'class': 'embeded_preview'}).insertAfter(this);
		loadContent('#preview' + $(this).attr('id'),'<?php echo $vars['url']; ?>mod/enlightn/ajax/embed_preview.php?guid=' + $(this).attr('id'));
		return false;
	});
	$('.<?php echo ENLIGHTN_IMAGE?>').click( function(){
	    $('<div />', {
	            'id' : 'preview' + $(this).attr('id'),
	    'class': 'embeded_preview'}).insertAfter(this);
		loadContent('#preview' + $(this).attr('id'),'<?php echo $vars['url']; ?>mod/enlightn/ajax/embed_preview.php?guid=' + $(this).attr('id'));
		return false;
	});
	$('.<?php echo ENLIGHTN_MEDIA?>').click( function(){
	    $('<div />', {
	            'id' : 'preview' + $(this).attr('id'),
	    'class': 'embeded_preview'}).insertAfter(this);
		loadContent('#preview' + $(this).attr('id'),'<?php echo $vars['url']; ?>mod/enlightn/ajax/embed_preview.php?guid=' + $(this).attr('id'));
		return false;
	});
	$('#discussion_list_container li').click( function(){
		if(!$(this).hasClass('open-msg')) {
			$(this).addClass('open-msg');

		} else {
			$(this).removeClass('open-msg');
		}
	});
});

</script>