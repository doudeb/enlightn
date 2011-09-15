<?php

$file 			= $vars['entity'];
$friendlytime 	= elgg_view_friendly_time($file->time_created);
$user_ent		= get_user($file->owner_guid);
?>
					<input type="hidden" name="embeder_content" id="embeder_content<?php echo $file->guid; ?>" value="<?php echo $vars['embeder_content']; ?>">
					<li id="embedFile<?php echo $file->guid; ?>" class="msg msg_home read">
                            <div class="cloud_thumb"><?php echo elgg_view("enlightn/cloud/icon", array("mimetype" => $file->mimetype, 'thumbnail' => $file->thumbnail, 'file_guid' => $file->guid, 'size' => 'small')); ?></div>
                            <div class="excerpt" id="excerpt<?php echo $file->guid; ?>">
                                <h3><a href="<?php echo URL_DOWNLOAD .$file->guid;?>" target="_blank"><?php echo $file->title?></a></h3>
                                <span class="participants"><strong><?php echo $user_ent->name?></strong></span>
                                <span class="date"><?php echo elgg_view_friendly_time($file->time_created) ?></span>
                                <?php if(get_context() == 'cloud_embed') {?><span class="follow send-msg embeder" id="<?php echo $file->guid; ?>">&nbsp;<?php echo elgg_echo('enlightn:attach')?></span><?php } ?>
                                <p><?php echo $file->originalfilename;?></p>
                            </div>
                    </li>
 <script>
		$("#excerpt<?php echo $file->guid; ?>").click( function(){
            window.open('<?php echo URL_DOWNLOAD .$file->guid;?>', '_blank');
		});
</script>