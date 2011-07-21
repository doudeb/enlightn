 <script type="text/javascript" charset="utf-8">
$(document).ready(function() {
  $('#picker_<?php echo $vars['internalid']?>').farbtastic('#<?php echo $vars['internalid']?>');
  $('#<?php echo $vars['internalid']?>').click ( function() {
  		$('#picker_<?php echo $vars['internalid']?>').fadeIn();
  });
  $('#<?php echo $vars['internalid']?>').focusout ( function() {
  		$('#picker_<?php echo $vars['internalid']?>').fadeOut();
  });
});

 </script>
<input type="text" id="<?php echo $vars['internalid']?>" name="<?php echo $vars['internalname']?>" value="<?php echo $vars['value']?>" /><div id="picker_<?php echo $vars['internalid']?>" style="display:none"></div>