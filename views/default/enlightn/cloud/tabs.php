<h1 class="mediaModalTitle"><?php echo elgg_echo('enlighnt:cloudmain');?></h1>
<div id="embed_media_tabs">
	<ul>
		<li>
			<a href="#" <?php echo $embedselected; ?> onclick="javascript:$('.popup .content').load('<?php echo $vars['url'] . 'pg/enlightn/cloud'; ?>?internalname=<?php echo $vars['internalname']; ?>'); return false"><?php echo elgg_echo('embed:media'); ?></a>
		</li>
		<li>
			<a href="#" <?php echo $uploadselected; ?> onclick="javascript:$('.popup .content').load('<?php echo $vars['url'] . 'pg/enlightn/upload'; ?>?internalname=<?php echo $vars['internalname']; ?>'); return false"><?php echo elgg_echo('upload:media'); ?></a>
		</li>
	</ul>
</div>
<div class="clearfloat"></div>