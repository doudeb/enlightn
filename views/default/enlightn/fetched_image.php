<?php
if (strstr($vars['entity']->getFilenameOnFilestore(),'file/')) {
	$imgsrc = URL_DOWNLOAD .$vars['entity']->guid;
} else {
	$imgsrc = $vars['entity']->originalfilename;
}
?>
    <span class="arrow"></span>
    <img src="<?php echo $imgsrc?>" width="150" />
    <a class="redirect" href="<?php echo $imgsrc?>" target="_blank"><?php echo elgg_echo('enlightn:viewimage')?></a>