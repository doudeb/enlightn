 <script type="text/javascript" charset="utf-8">
$(document).ready(function() {
  $('#picker_<?php echo $vars['id']?>').farbtastic('#<?php echo $vars['id']?>');
  $('#<?php echo $vars['id']?>').click ( function() {
  		$('#picker_<?php echo $vars['id']?>').fadeIn();
  });
  $('#<?php echo $vars['id']?>').focusout ( function() {
  		$('#picker_<?php echo $vars['id']?>').fadeOut();
  });
});

 </script>
<input type="text" id="<?php echo $vars['id']?>" name="<?php echo $vars['name']?>" value="<?php echo $vars['value']?>" /><div id="picker_<?php echo $vars['id']?>" style="display:none"></div>