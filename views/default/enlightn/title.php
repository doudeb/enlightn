<?php
$post				= $vars['entity'];
$flag_readed 		= check_entity_relationship($vars['user_guid'], ENLIGHTN_READED,$post->id);
$flag_folowed 		= check_entity_relationship($vars['user_guid'], ENLIGHTN_FOLLOW,$post->guid);
$flag_favorite 		= check_entity_relationship($vars['user_guid'], ENLIGHTN_FAVORITE,$post->guid);
$post_owner 		= get_entity($post->owner_guid);
$members 			= get_discussion_members($post->guid,12);
$invited_members	= elgg_get_entities_from_relationship(array(
															'relationship' => ENLIGHTN_INVITED,
															'relationship_guid' => $post->guid,
															'inverse_relationship' => FALSE,
															'types' => 'user'));
if (!$invited_members) {
	$invited_members = array();
}
$tags				= $post->getTags();
$url_favorite		= elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/favorite?discussion_guid={$post->guid}");
$url_follow			= elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/follow?discussion_guid={$post->guid}");
$url_invite			= elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/invite?discussion_guid={$post->guid}");
?>
		<div id="main">
			<div id="detail" class="msg <?php echo false===$flag_readed?'unread':'read' ?> <?php echo  false===$flag_favorite?'':'starred'?>">
                <div class="header">
                    <span class="read ico"></span>
                    <h2><?php echo $post->title; ?></h2>
                    <span id="favorite<?php echo $post->guid; ?>" class="star ico"></span>
                    <span class="<?php echo $post->access_id==ACCESS_PRIVATE?'lock':'unlock'; ?> ico"></span>

                </div><!-- header -->

                <div class="actions">
                    <span id="follow" class="follow <?php echo false===$flag_folowed?'':'unfollow' ?>">
                        <span class="ico"></span>
                        <span class="follow-val">Follow</span>
                        <span class="unfollow-val">Unfollow</span>
                    </span>

                    <span class="tags">

                        <ul>
                        	<?php
                        	if (is_array($tags)) {
                        		foreach ($tags as $tag) {
                        			echo "<li>$tag</li>";
                        		}
                        	}
                        	?>
                        </ul>
                    </span>
                </div>

                <div class="users">
                    <span class="label"><?php echo elgg_echo('enlightn:followers');?> (<?php echo count($members);?>)</span>
					<?php
					foreach($members as $mem) {
						echo "<img src='" . $mem->getIcon('small') . "' />\n";
					}
					?>
                </div>
                <div class="users users-invited">
                    <span class="label"><?php echo elgg_echo('enlightn:invitedusers');?> (<?php echo count($invited_members);?>)</span>
					<?php
					foreach($invited_members as $mem) {
						echo "<img src='" . $mem->getIcon('small') . "' />\n";
					}
					?>
                    <span class="add">
                        <span class="ico"></span>
                        <span class="caption" id="invite"><?php echo elgg_echo('enlightn:discussioninvite');?></span>
                    </span>
                </div>

                <div class="users author">
                    <span class="label"><?php echo elgg_echo('enlightn:postcreated')?></span>
                    <img src="<?php echo $post_owner->getIcon('small')?>" />
                    <span class="date"><?php echo elgg_view_friendly_time($post->time_created) ?></span>
                </div>

            </div>
<script>
		$('#invite').click( function(){
			if (!$(this).hasClass('add-form')) {
				$(this).addClass('add-form');
				$('<span />', {
				'id' : 'close-invite',
				'style' : 'margin-top : -20px',
				'html' : '<h2>&times;</h2>',
	    		'class': 'mini-close'}).appendTo($(this));
	    		$("#close-invite").click( function(){
					$('#invite').html('<?php echo elgg_echo('enlightn:discussioninvite');?>');

				});

                $('<input />', {
				'type' : 'text',
				'id' : 'invite_to_folow',
	    		'class': ''}).appendTo($(this));
	    		$("#invite_to_folow").tokenInput("<?php echo $vars['url']?>mod/enlightn/ajax/members.php");


				$('<span />', {
				'id' : 'invite_button',
				'html' : '<?php echo elgg_echo("send"); ?>',
	    		'class': 'button'}).appendTo($(this));
	    		$("#invite_button").click( function(){
					loadContent($('#loader'),'<?php echo $url_invite?>&invite='+$('#invite_to_folow').val());
                    $('#invite').html('<?php echo elgg_echo('enlightn:discussioninvite');?>');

				});
			}
		});
		$("#favorite<?php echo $post->guid; ?>").click( function(){
			if ($("#detail").hasClass("starred")) {
				$("#detail").removeClass("starred");
			} else {
				$("#detail").addClass("starred");
			}
			loadContent('#loader','<?php echo $url_favorite?>');
		});
		$("#follow").click( function(){
			if ($("#follow").hasClass("unfollow")) {
				$("#follow").removeClass("unfollow");
			} else {
				$("#follow").addClass("unfollow");
			}
			loadContent('#loader','<?php echo $url_follow?>');
		});
</script>