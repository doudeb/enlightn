<div class="images">
<?php
if (is_array($vars['entity']->sortedImage)) {
	foreach ($vars['entity']->sortedImage as $key=>$image) {
		if ($key===0) {
			echo '<img src="' . $image . '" width="100px" alt="" id="imagePreview">';
		}
		//echo '<input type="hidden" name="imgsrc['. $key . ']" value="' . $image . '" id="imgsrc'. $key . '">';
	}
}
?>
		</div>
<label class="title">
	<?php  echo $vars['entity']->title; ?>
</label>
<label class="desc">
	<?php  echo $vars['entity']->description; ?>
</label>
<a href="<?php echo $vars['entity']->url?>"><?php echo elgg_echo('enlightn:readmore')?></a>