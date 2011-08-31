<span class="arrow"></span>
<span class="player">
    <span class="ico"></span>
    <img src="<?php echo $vars['entity']->thumbnail_url; ?>" height="100" width="150" />
    <input type="hidden" value='<?php echo $vars['entity']->html; ?>'>
</span>
<a class="redirect" href="<?php echo $vars['entity']->url; ?>" target="_blank"><?php echo elgg_echo('enlightn:viewvideo')?></a>