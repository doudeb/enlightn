   <div id="page">
        <div id="main">

            <div id="post">
                <img class="photo" src="<?php echo $vars['user_ent']->getIcon('small')?>" />
                <div class="status-box"><?php echo elgg_echo('enlightn:newpost')?></div>
               	<?php echo elgg_view('enlightn/discussion_edit',array()); ?>
            </div>