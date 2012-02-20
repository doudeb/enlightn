<script>

$(document).ready(function(){

	$('.<?php echo ENLIGHTN_LINK?>').click( function(){
		showBubble (this, '<?php echo ENLIGHTN_LINK?>') ;
	});

	$('.<?php echo ENLIGHTN_MEDIA?>').click( function(){
		showBubble (this, '<?php echo ENLIGHTN_MEDIA?>') ;
	});
	$('.<?php echo ENLIGHTN_IMAGE?>').click( function(){
		showBubble (this, '<?php echo ENLIGHTN_IMAGE?>') ;
	});
	$('.<?php echo ENLIGHTN_DOCUMENT?>').click( function(){
		showBubble (this, '<?php echo ENLIGHTN_IMAGE?>') ;

	});

	$('#discussion_list_container li .excerpt').click( function(){
		$(this).parent().toggleClass('open-msg');
	});

    function showBubble (e, linkType) {
		elm = 'preview' + $(e).attr('id');
        pos = $(e).position();
        elmLeft = pos.left + 'px';
        bwidth = 'auto';
        if (linkType == '<?php echo ENLIGHTN_LINK?>') {
            bwidth = '300px';
        }
		if (!$('#' +elm).hasClass('bubble')) {
		    $('<span />', {
		            'id' : elm,
		            'style' : 'width : ' + bwidth + '; left : ' + elmLeft,
                    'html' : '<span class="close">&times;</span>',
		    'class': 'bubble'}).insertAfter(e);
			loadContent('#' + elm,'<?php echo $vars['url']; ?>mod/enlightn/ajax/embed_preview.php?guid=' + $(e).attr('id'),'append');
		} else {
			if (($('#' +elm).css('display')) == 'block') {
				$('#' +elm).css('display','none');
			} else {
				$('#' +elm).css('display','block');
			}
		}
		return false;
    }
});

</script>