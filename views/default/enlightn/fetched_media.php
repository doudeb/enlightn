<span class="arrow"></span>
<span class="player">
    <span class="ico"></span>
    <img id="thumb<?php echo $vars['media_uid']; ?>" src="<?php echo $vars['entity']->thumbnail_url; ?>" height="100" width="150" />
    <div class="view" id="view<?php echo $vars['media_uid']; ?>"><?php echo $vars['entity']->html; ?></div>

</span>
<a class="redirect" href="<?php echo $vars['entity']->link; ?>" onclick="javascript:$('#thumb<?php echo $vars['media_uid']; ?>').fadeOut();$('#view<?php echo $vars['media_uid']; ?>').fadeIn();return false;"><?php echo elgg_echo('enlightn:view')?></a>