<?php

$file 			= $vars['entity'];
$friendlytime 	= elgg_view_friendly_time($file->time_created);
$user_ent		= get_user($file->owner_guid);
?>

					<input type="hidden" name="embeder_content" id="embeder_content<?php echo $file->guid; ?>" value="<?php echo $vars['embeder_content']; ?>">
					<li id="id="embedFile<?php echo $file->guid; ?>" class="user">
                            <div class="cloud_thumb"><?php echo elgg_view("enlightn/cloud/icon", array("mimetype" => $file->mimetype, 'thumbnail' => $file->thumbnail, 'file_guid' => $file->guid, 'size' => 'small')); ?></div>
                            <a href="<?php echo $vars['url'] . 'mod/file/download.php?file_guid=' .$file->guid;?>" target="_blank"><?php echo $file->title?></a>
                            <p><?php echo $file->originalfilename;?></p>
                            <span class="bottom"><strong><?php echo $user_ent->name?></strong> <?php echo elgg_view_friendly_time($file->time_created) ?></span>
                            <?php
								if (get_context() == 'cloud_embed') {
							?>
                            <span class="follow send-msg embeder" id="<?php echo $file->guid; ?>">&nbsp;<?php echo elgg_echo('enlightn:attach')?></span>
                            <?php } else { ?>
                            <a href="<?php echo $vars['url'] . 'mod/file/download.php?file_guid=' .$file->guid;?>" target="_blank"><span class="follow send-msg" id="<?php echo $file->guid; ?>">&nbsp;<?php echo elgg_echo('enlightn:download')?></span></a>
                            <?php } ?>
                    </li>