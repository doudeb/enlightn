<?php
if (is_array($vars['entity']->sortedImage)) {
	foreach ($vars['entity']->sortedImage as $key=>$image) {
		if ($key===0) {
			$img = '<img src="' . $image . '" width="100px" alt="" id="imagePreview">';
		}
		//echo '<input type="hidden" name="imgsrc['. $key . ']" value="' . $image . '" id="imgsrc'. $key . '">';
	}
}
?>
<span class="bubble">
<span class="arrow"></span>
<img class="photo" src="<?php echo $img?>">
<span class="col">
	<strong><?php  echo $vars['entity']->title;?></strong>
	<span class="headline">	<?php  echo $vars['entity']->description; ?></span>
    <span class="button"><a href="<?php echo $vars['entity']->url?>"><?php echo elgg_echo('enlightn:readmore')?></a></span>
</span>
</span>