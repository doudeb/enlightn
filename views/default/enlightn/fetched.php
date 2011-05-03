<div id="fetch_results">
	<?php if ($vars['type'] == 'media') { ?>
		<div class="video"><?php echo $vars['entity']->html; ?></div>
	<?php } elseif ($vars['type'] == 'url') { ?>
<script>
// next image
		$('#next').click( function() {
			var nextImg = parseInt($('#cur_image').val()) + 1;
			if(nextImg <= $('#total_images').val()) {
				$('#cur_image').val(nextImg);
				$('#imagePreview').attr("src", $('#imgsrc' + nextImg).val());
				refreshInput('url');
			}
		});
		$('#prev').click( function() {
			var prevImg = parseInt($('#cur_image').val()) - 1;
			if(prevImg <= $('#total_images').val()) {
				$('#cur_image').val(prevImg);
				$('#imagePreview').attr("src", $('#imgsrc' + prevImg).val());
				refreshInput('url');
			}
		});
</script>
		<div class="images">
		<?php
		if (is_array($vars['entity']->sortedImage)) {
			foreach ($vars['entity']->sortedImage as $key=>$image) {
				if ($key===1) {
					echo '<img src="' . $image . '" width="100px" alt="" id="imagePreview">';
				}
				echo '<input type="hidden" name="imgsrc['. $key . ']" value="' . $image . '" id="imgsrc'. $key . '">';
			}
		}
		?>
		</div>
	<?php } ?>
	<div class="info" id="fetchResult">
		<label class="title">
			<?php  echo $vars['entity']->title; ?>
		</label>
		<br />
		<label class="url">
			<?php  echo $vars['entity']->url; ?>
		</label>
		<br /><br />
		<label class="desc">
			<?php  echo $vars['entity']->description; ?>
		</label>
	</div>
	<?php if ($vars['type'] == 'url') { ?>
	<div>
		<br /><br />
			<input type="hidden" name="cur_image" id="cur_image" value="0" />
			<input type="hidden" name="total_images" id="total_images" value="<?php echo $key?>" />
			<label style="float:left"><img src="<?php echo $vars['url'];?>mod/enlightn/media/graphics/prev.png" id="prev" alt="<<" /><img src="http://enlightn_dev.doudeb/mod/enlightn/media/graphics/next.png" id="next" alt=">>" /></label>
		<br />
	</div>
	<script>refreshInput('url');</script>
	<?php } elseif ($vars['type'] == 'media') { ?>
	<script>refreshInput('media');</script>
	<?php } ?>
</div>