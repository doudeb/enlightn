<?php

$file 			= $vars['entity'];
$friendlytime 	= elgg_view_friendly_time($file->time_created);
$user_ent		= get_user($file->owner_guid);
$url            = get_file_link($file);
$tags			= $file->getTags();
?>
					<input type="hidden" name="embeder_content" id="embeder_content<?php echo $file->guid; ?>" value="<?php echo $vars['embeder_content']; ?>">
					<li id="embedFile<?php echo $file->guid; ?>" class="msg msg_home unread">
                            <div class="cloud_thumb"><?php echo elgg_view("enlightn/cloud/icon", array("mimetype" => $file->mimetype, 'thumbnail' => $file->thumbnail, 'file_guid' => $file->guid, 'size' => 'small')); ?></div>
                            <div class="excerpt" id="excerpt<?php echo $file->guid; ?>">
                                <h3><?php echo substr($file->title, 0, 107);?></h3>
                                <?php if(elgg_get_context() == 'cloud_embed') {?>
                                    <span class="follow send-msg embeder" id="<?php echo $file->guid; ?>">&nbsp;<?php echo elgg_echo('enlightn:attach')?></span>
                                <?php } else { ?>
                                    <span class="follow send-msg embederToNew" id="<?php echo $file->guid; ?>">&nbsp;<?php echo elgg_echo('enlightn:attachtoanewdiscussion')?></span>
                                <?php }?>
                                <!--<p class="cloudContent"><?php echo substr($file->originalfilename, 0, 107);?></p>-->
                                <span class="participants"><?php echo $user_ent->name?></span>
                                <span class="date"><?php echo elgg_view_friendly_time($file->time_created) ?></span>
                                <?php
                                    if (is_array($tags)) {
                                        echo "<div>";
                                        foreach ($tags as $tag) {
                                            echo "<span class='tag'>$tag</span>";
                                        }
                                        echo "</div>";
                                    }
                                    ?>
                            </div>
                    </li>
 <script>
		$("#excerpt<?php echo $file->guid; ?>").click( function(){
            window.open('<?php echo $url;?>', '_blank');
		});
</script>