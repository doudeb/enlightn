<span class="arrow"></span>

<span class="icon">
    <?php echo elgg_view("file/icon", array("mimetype" => $vars['entity']->mimetype, 'thumbnail' => $vars['entity']->thumbnail, 'file_guid' => $vars['entity']->guid, 'size' => 'tiny'))?>
    <span class="spec">(<?php echo $vars['entity']->size();?>)</span>
</span>
<span class="col">
    <strong><?php echo $vars['entity']->title;?></strong>
    <span class="button download"><span class="ico"></span><a href="<?php echo URL_DOWNLOAD .$vars['entity']->guid;?>" target="_blank"><?php  echo elgg_echo('download')?></a></span>
</span>