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
$tags			= $post->getTags();
$url_favorite		= elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/favorite?discussion_guid={$post->guid}");
$url_follow		= elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/follow?discussion_guid={$post->guid}");
$url_invite		= elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/invite?discussion_guid={$post->guid}");
?>
		<div id="main">
			<div id="detail" class="msg <?php echo false===$flag_readed?'':'read' ?> <?php echo  false===$flag_favorite?'':'starred'?>">
                <div class="header">
    				<?php echo elgg_view("enlightn/follow", array('entity' => $vars['entity'], 'user_guid' => $vars['user_guid']));?>
                    <h2><span id="discussionTitle"><?php echo $post->title; ?></span></h2>
                    <span id="favorite<?php echo $post->guid; ?>" class="star ico"></span>
                    <span class="<?php echo $post->access_id==ACCESS_PRIVATE?'lock':'unlock'; ?> ico"></span>
                    <?php
                        if (is_array($tags)) {
                            echo "<p>";
                            foreach ($tags as $tag) {
                                echo "<span class='tag'>$tag</span>";
                            }
                            echo "</p>";
                        }
                        ?>
                </div><!-- header -->

                <div class="users">
                    <span class="label"><?php echo elgg_echo('enlightn:followers');?> (<?php echo count($members);?>)</span>
					<?php
					foreach($members as $mem) {
						echo elgg_view('input/user_photo',array('user_ent'=>$mem));
					}
					?>
                </div>
                <div class="users users-invited">
                    <span class="label"><?php echo elgg_echo('enlightn:invitedusers');?> (<?php echo count($invited_members);?>)</span>
					<?php
					foreach($invited_members as $mem) {
						echo elgg_view('input/user_photo',array('user_ent'=>$mem));
					}
					?>
                    <span class="add">
                        <span class="ico"></span>
                        <span class="caption" id="invite">
                            <?php echo elgg_echo('enlightn:discussioninvite');?>
                        </span>
                        <span class="caption" id="invite-form">
                            <?php echo elgg_view("enlightn/helper/adduser",array(
                                                                    'placeholder' => elgg_echo('enlightn:fromuser'),
                                                                    'name' => 'invite_to_folow',
                                                                    'id' => 'invite_to_folow',
                                                                    )); ?>
                            <span id="invite_button" class="button"><?php echo elgg_echo("enlightn:buttonsend"); ?></span>
                        </span>
                    </span>
                </div>

                <div class="users author">
                    <span class="label"><?php echo elgg_echo('enlightn:postcreated')?></span>
                    <?php echo elgg_view('input/user_photo',array('user_ent'=>$post_owner));?>
                    <span class="date"><?php echo elgg_view_friendly_time($post->time_created) ?></span>
                </div>
                <span class="toggle ico"></span>
            </div>
<script>
	$("#invite_button").click( function(){
        loadContent($('#loader'),'<?php echo $url_invite?>&invite='+$('input[name="invite_to_folow"]').val());
        $('#invite-form').toggle();
        $('#invite-form').toggleClass('add-form');
    });
    $('#invite').click(function () {
        $('#invite-form').toggleClass('add-form');
        $('#invite-form').toggle();
    });

		$("#favorite<?php echo $post->guid; ?>").click( function(){
			if ($("#detail").hasClass("starred")) {
				$("#detail").removeClass("starred");
			} else {
				$("#detail").addClass("starred");
			}
			loadContent('#loader','<?php echo $url_favorite?>');
		});
</script>