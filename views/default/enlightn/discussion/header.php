<?php

$post				= $vars['entity'];
$flag_readed 		= check_entity_relationship($vars['user_guid'], ENLIGHTN_READED,$post->id);
$flag_folowed 		= check_entity_relationship($vars['user_guid'], ENLIGHTN_FOLLOW,$post->guid);
$flag_favorite 		= check_entity_relationship($vars['user_guid'], ENLIGHTN_FAVORITE,$post->guid);
$post_owner 		= get_entity($post->owner_guid);
$members            = get_discussion_members($post->guid,12);
$invited_members	= elgg_get_entities_from_relationship(array(
															'relationship' => ENLIGHTN_INVITED,
															'relationship_guid' => $post->guid,
															'inverse_relationship' => FALSE,
															'types' => 'user'));
if (!$invited_members) {
	$invited_members = array();
}
$tags               = $post->getTags();
$url_favorite		= elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/favorite?discussion_guid={$post->guid}");
$url_follow         = elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/follow?guid={$post->guid}");
$url_invite         = elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/invite?guid={$post->guid}");
?>
        <div id="wrapper" class="no-js">
			<div id="main">
				<div id="content">

					<div class="details">

						<div class="right_menu">
							<a href="#dropdown" class="btn dropdown"> <span class="ico_dropdown"></span> </a>
							<div id="dropdown">
								<span></span>
								<a href="#"><?php echo elgg_echo("enlightn:forward")?></a>
								<a href="#"><?php echo elgg_echo("enlightn:removeasread")?></a>
								<a href="#invite" class="invite"><?php echo elgg_echo("enlightn:discussioninvite")?></a>
							</div>
						</div>

						<div class="wrap" data-height="90">
							<div class="header">
								<h2 id="discussionTitle"><?php echo $post->title; ?></h2>

								<div class="state">
									<!-- état active des favoris, à mettre quand nécéssaire -->
									<!-- <span class="ico_favorit_active"> </span> -->

									<span class="<?php echo  false===$flag_favorite?'ico_favorit':'ico_favorit_active'?>"> </span>
									<span class="<?php echo $post->access_id==ACCESS_PRIVATE?'ico_locked':''; ?>"> </span>
								</div>

								<div class="follow">
									<a href="#" class="btn <?php echo $is_follow?'following':'not_following';?>"> <?php echo $is_follow?'<span class="ico_good_mark"></span>' . elgg_echo("enlightn:bunttonfollowed"):elgg_echo("enlightn:buttonfollow");?> </a>

									<!-- bouton s'abonner, à mettre quand nécéssaire -->
									<!-- <a href="#" class="btn not_following"> <?php echo elgg_echo("enlightn:buttonfollow"); ?> </a> -->
								</div>
							</div>

							<div class="participants">
								<div class="thumbs">
                                   <?php
                                    foreach($members as $mem) {
                                        echo elgg_view('input/user_photo',array('user_ent'=>$mem, 'class'=>'users_small'));
                                    }
                                    ?>
								</div>

								<a href="#invite" class="btn invite "> <span class="ico_plus"></span> <?php echo elgg_echo("enlightn:discussioninvite")?> </a>
							</div>

							<p class="signature"> <?php echo elgg_echo('enlightn:postcreated')?> <strong><?php echo $post_owner->name ?></strong> <?php echo elgg_view_friendly_time($post->time_created) ?> </p>

							<div class="tags">
                                <?php
                                    if (is_array($tags)) {
                                        foreach ($tags as $key=>$tag) {
                                            echo "<a href='#'>" . $tag . "</a>\n";
                                            if ($key >= 10) break;
                                        }
                                    }
                                ?>
							</div>
						</div>

						<a href="#" class="see_more" title="<?php echo elgg_echo('open')?>"> </a>
					</div>

					<div class="fixed_details">
						<div class="header">
							<h2><?php echo $post->title; ?></h2>

							<div class="state">
								<!-- état active des favoris, à mettre quand nécéssaire -->
								<!-- <span class="ico_favorit_active"> </span> -->

                                <a class="<?php echo  false===$flag_favorite?'ico_favorit':'ico_favorit_active'?>"> </a>
                                <span class="<?php echo $post->access_id==ACCESS_PRIVATE?'ico_locked':''; ?>"> </span>
							</div>

							<div class="follow">
									<a href="#" class="btn <?php echo $is_follow?'following':'not_following';?>"> <?php echo $is_follow?'<span class="ico_good_mark"></span>' . elgg_echo("enlightn:bunttonfollowed"):elgg_echo("enlightn:buttonfollow");?> </a>

									<!-- bouton s'abonner, à mettre quand nécéssaire -->
									<!-- <a href="#" class="btn not_following"> <?php echo elgg_echo("enlightn:buttonfollow"); ?> </a> -->
							</div>
						</div>

						<a href="#new_message" class="new_message btn_secondary">Nouveau Message</a>
						<div class="right_menu">
							<a href="#dropdown2" class="btn dropdown"> <span class="ico_dropdown"></span> </a>
							<div id="dropdown2">
								<span></span>
								<a href="#"><?php echo elgg_echo("enlightn:forward")?></a>
								<a href="#"><?php echo elgg_echo("enlightn:removeasread")?></a>
								<a href="#invite" class="invite"><?php echo elgg_echo("enlightn:discussioninvite")?></a>
							</div>
						</div>
					</div>
                    <script>
                        $("#favorite<?php echo $post->guid; ?>").click( function(){
                            if ($("#detail").hasClass("starred")) {
                                $("#detail").removeClass("starred");
                            } else {
                                $("#detail").addClass("starred");
                            }
                            loadContent('#loader','<?php echo $url_favorite?>');
                        });
                    </script>
