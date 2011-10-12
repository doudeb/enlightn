<span class="arrow"></span>
<span class="player">
    <?php echo (!empty($vars['entity']->html)?$vars['entity']->html:$vars['entity']->display); ?>
</span>
<a class="redirect" href="<?php echo $vars['entity']->url; ?>" target="_blank"><?php echo elgg_echo('enlightn:viewvideo')?></a>