<?php
$file               = $vars['entity'];
$user_ent           = get_user($file->owner_guid);
$url                = get_file_link($file);
$tags               = $file->getTags();
$attached_filter    = elgg_get_entities_from_relationship(array(
															'relationship' => ENLIGHTN_FILTER_ATTACHED,
															'relationship_guid' => $file->guid,
															'inverse_relationship' => FALSE,
															'types' => 'object'));
$key                = $vars['key'];
?>
                            <input type="hidden" name="embeder_content" id="embeder_content<?php echo $file->guid; ?>" value="<?php echo $vars['embeder_content']; ?>">
                            <!--<li id="embedFile<?php echo $file->guid; ?>" class="msg msg_home unread" data-guid="<?php echo $file->guid; ?>">
                            <div class="cloud_thumb"><?php echo elgg_view("enlightn/cloud/icon", array("mimetype" => $file->mimetype, 'thumbnail' => $file->thumbnail, 'file_guid' => $file->guid, 'size' => 'small')); ?></div>
                            <div class="excerpt" id="excerpt<?php echo $file->guid; ?>">
                                <h3><a href="<?php echo $url?>" target="_blank"><?php echo substr($file->title, 0, 107);?></a><span class="ico <?php echo $file->access_id==0?'private':'public' ?>-ico"/></h3>
                                <?php if(elgg_get_context() == 'cloud_embed') {?>
                                    <span class="follow send-msg embeder" id="<?php echo $file->guid; ?>">&nbsp;<?php echo elgg_echo('enlightn:attach')?></span>
                                <?php } else { ?>
                                    <span class="follow send-msg embederToNew" id="<?php echo $file->guid; ?>">&nbsp;<?php echo elgg_echo('enlightn:attachtoanewdiscussion')?></span>
                                <?php }?>
                                <p class="cloudContent"><?php echo substr($file->originalfilename, 0, 107);?></p>
                                <span class="participants"><?php echo $user_ent->name?></span>
                                <span class="date"><?php echo elgg_view_friendly_time($file->time_created) ?></span>
                                <?php if($file->owner_guid==  elgg_get_logged_in_user_guid() || elgg_is_admin_logged_in()) {?>
                                <span class="disable_ent" data-guid="<?php echo $file->guid ?>">&times;</span>
                                <?php } ?>
                                <span class="expand ico"><?php echo elgg_echo('enlightn:clikexpandcloud') ?></span>
                                <?php if(elgg_get_context() == 'cloud_embed') {?>
                                    <span class="click-link ico embeder" id="<?php echo $file->guid; ?>">&nbsp;<?php echo elgg_echo('enlightn:attach')?></span>
                                <?php } else { ?>
                                    <span class="click-link ico embederToNew" id="<?php echo $file->guid; ?>">&nbsp;<?php echo elgg_echo('enlightn:attachtoanewdiscussion')?></span>
                                <?php } ?>
                                <?php
                                    if (count($attached_filter) > 0) {
                                        echo "<div class='filter_list'>";
                                        foreach ($attached_filter as $label) {
                                            echo "<span class='tag mlList' data-guid='$label->guid'>$label->title<span class='del'>&times;</span></span>";
                                        }
                                        echo "</div>";
                                    }
                                    if (count($tags) > 0) {
                                        echo "<div class='tag_list'>";
                                        foreach ($tags as $tag) {
                                            echo "<span class='tag'>$tag</span>";
                                        }
                                        echo "</div>";
                                    }
                                    ?>
                            </div>
                    </li>-->
                            <?php if(get_input('view_type','list') == 'list') {?>
                                    <li class="<?php echo ($key%2===0?'odd':'even')?>" id="embedFile<?php echo $file->guid; ?>" data-guid="<?php echo $file->guid; ?>">
											<div class="header">
												<div class="left">
													<?php echo elgg_view("enlightn/cloud/icon", array("mimetype" => $file->mimetype, 'thumbnail' => $file->thumbnail, 'file_guid' => $file->guid, 'size' => 'small')); ?>
                                                    <p><?php echo $file->title;?></p>
												</div>

												<div class="right">
													<p> <strong><?php echo $user_ent->name?></strong> <?php echo elgg_get_friendly_time($file->time_created) ?></p>

													<span class="<?php echo $file->access_id==ACCESS_PRIVATE?'ico_locked_small':''; ?>"></span>

													<a href="#"> <?php if(elgg_get_context() == 'cloud_embed') {
                                                                     echo elgg_echo('enlightn:attach');
                                                                } else {
                                                                     echo elgg_echo('enlightn:attachtoanewdiscussion');
                                                                 } ?> </a>
												</div>
											</div>

											<a href="#" class="collapse ico_collapse_close"><?php echo elgg_echo('enlightn:seemore')?></a>

											<div class="footer">
												<div class="left">
													<div class="tags">
                                                            <?php foreach ($tags as $tag) {
                                                                echo "<a href='#'>$tag</a>\n";
                                                            } ?>
													</div>
												</div>

												<div class="right">
													<?php if($file->owner_guid==  elgg_get_logged_in_user_guid() || elgg_is_admin_logged_in()) {?>
                                                    <a class="disable_ent" data-guid="<?php echo $file->guid ?>">&times;</a>
                                                    <?php } ?>
												</div>
											</div>
										</li>
                                         <?php } else { ?>
                                        <li>
											<a href="<?php echo $url?>" rel="url" class="popin img_wrap">
												<?php echo elgg_view("enlightn/cloud/icon", array("mimetype" => $file->mimetype, 'thumbnail' => $file->thumbnail, 'file_guid' => $file->guid, 'size' => 'medium')); ?>
												<span class="overlay"></span>
											</a>

											<p class="caption">
												<strong><a href="<?php echo $url?>" rel="url" class="popin"> <?php echo $file->title;?> </a></strong>
												<a href="<?php echo $url?>" rel="url"><?php echo $url?></a>
											</p>

											<a href="#" class="see_more">+</a>
											<div class="more">
												<p> <strong><?php echo $user_ent->name?></strong> <?php echo elgg_get_friendly_time($file->time_created) ?></p>
												<div class="tags">
                                                    <?php foreach ($tags as $tag) {
                                                        echo "<a href='#'>$tag</a>\n";
                                                    } ?>
												</div>
											</div>

											<div class="menu">
												<!--<a href="#"  class="ico_star_thumb"></a>-->
												<span class="<?php echo $file->access_id==ACCESS_PRIVATE?'ico_locked_thumb':''; ?>"></span>
											</div>
										</li>
                                         <?php } ?>
