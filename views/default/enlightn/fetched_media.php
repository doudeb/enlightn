<div class="media_preview"><a href="" onclick="javascript:$(this).fadeOut();$('#view<?php echo $vars['media_uid']; ?>').fadeIn();return false;"><img src="<?php echo $vars['entity']->thumbnail_url; ?>" width="100px"></a></div>
<div class="view" id="view<?php echo $vars['media_uid']; ?>"><?php echo $vars['entity']->html; ?></div>
<label class="title">
	<?php  echo $vars['entity']->title; ?>
</label>
<label class="desc">
	<?php  echo $vars['entity']->description; ?>
</label>