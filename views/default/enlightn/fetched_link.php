<?php
if (is_array($vars['entity']->sortedImage)) {
	foreach ($vars['entity']->sortedImage as $key=>$image) {
		if ($key===0) {
			$img = $image;
		}
		//echo '<input type="hidden" name="imgsrc['. $key . ']" value="' . $image . '" id="imgsrc'. $key . '">';
	}
}
?>
<span class="arrow"></span>
<img class="photo" src="<?php echo $img?>">
<span class="col">
    <strong><?php  echo utf8_encode($vars['entity']->title);?></strong>
    <span class="headline">	<?php  echo utf8_encode($vars['entity']->description); ?></span>
    <span class="button"><a href="<?php echo $vars['entity']->url?>" target="_blank"><?php echo elgg_echo('enlightn:readmore')?></a></span>
</span>