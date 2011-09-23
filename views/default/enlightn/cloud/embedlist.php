<?php

$file 			= $vars['entity'];
$friendlytime 	= elgg_view_friendly_time($file->time_created);
$user_ent		= get_user($file->owner_guid);
switch ($file->mimetype) {
    case 'text/html'    :
        $url = $file->originalfilename;
        break;
    default:
        $url = URL_DOWNLOAD .$file->guid;
        break;
}
?>
					<input type="hidden" name="embeder_content" id="embeder_content<?php echo $file->guid; ?>" value="<?php echo $vars['embeder_content']; ?>">
					<li id="embedFile<?php echo $file->guid; ?>" class="msg msg_home unread">
                            <div class="cloud_thumb"><?php echo elgg_view("enlightn/cloud/icon", array("mimetype" => $file->mimetype, 'thumbnail' => $file->thumbnail, 'file_guid' => $file->guid, 'size' => 'small')); ?></div>
                            <div class="excerpt" id="excerpt<?php echo $file->guid; ?>">
                                <h3><?php echo $file->title?></h3>
                                <p><?php echo substr($file->originalfilename, 0, 107);?></p>
                                <p></p>
                                <span class="participants"><?php echo $user_ent->name?>
                                    <span class="date"><?php echo elgg_view_friendly_time($file->time_created) ?></span>
                                </span>
                                <?php if(get_context() == 'cloud_embed') {?><span class="follow send-msg embeder" id="<?php echo $file->guid; ?>">&nbsp;<?php echo elgg_echo('enlightn:attach')?></span><?php } ?>
                                <p></p>
                            </div>
                    </li>
 <script>
		$("#excerpt<?php echo $file->guid; ?>").click( function(){
            window.open('<?php echo $url;?>', '_blank');
		});
</script>