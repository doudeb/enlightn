<?php
$discussion 	= elgg_get_annotation_from_id($vars['entity']->id);
$flag_readed	= $vars['flag_readed'];
$post_owner 	= get_user($discussion->owner_guid);
$has_words		= stripos($discussion->value,$vars['query']);
$url_read		= elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/read?discussion_guid={$discussion->id}");
$src_embeded	= elgg_get_entities_from_relationship(array(
															'relationship' => ENLIGHTN_EMBEDED,
															'relationship_guid' => $discussion->id,
															'inverse_relationship' => true));
?>
                                    <div class="item<?php echo $flag_readed?'':' active'?>">

										<div class="thumb">
                                            <?php echo elgg_view('input/user_photo',array('class'=>'thumb-photo','user_ent'=>$post_owner));?>
										</div>

										<div class="message">
											<div class="wrap" data-height="210">
												<div class="header">
													<h3> <?php echo $post_owner->name;?> </h3>

													<p class="date"> <?php echo elgg_view_friendly_time($discussion->time_created)?> </p>
												</div>

												<div class="body">

													<div class="row3">
														<?php echo $discussion->value; ?>
													</div>
                                                <?php
                                                if (is_array($src_embeded)) {
                                                    foreach ($src_embeded as $key => $media) {
                                                        if ($media instanceof ElggFile) {
                                                            echo '<div class="media row1">
                                                            <a href="' . $media->thumbnail . '" class="img_wrap" target="_blank">
                                                                <img src="' . $media->thumbnail . '" />
                                                                <span class="overlay overlay_img"></span>
                                                            </a>
                                                            <h4><a href="' . $media->filename . '" target="_blank">' . $media->title . '</a></h4>
                                                        </div>';
                                                        }
                                                    }
                                                }
                                                ?>
												</div>
											</div>

											<a href="#" class="see_more" title="Ouvrir"></a>
											<span class="speak"></span>
										</div>

									</div>