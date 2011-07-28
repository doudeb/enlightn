<?php
$private_collections 	= get_user_access_collections($vars['user_ent']->guid);
$public_collections 	= get_user_access_collections(0);
$collections			= array_merge($private_collections,$public_collections);
?>
			</div>

        </div>
        <div id="sidebar">
			<ol class="folders">
                <li ><a id="memberDrop"><?php echo elgg_echo('enlightn:newlist'); ?></a></li>
                <li><a href="/followed">Followed<span class="notif">2</span></a></li>
                <li><a href="/requests">Requests<span class="notif lnotif">22</span></a></li>
                <li><a href="/favorites">Favorites</a></li>
                <li><a href="/sent">Sent</a></li>
            </ol>
        </div>
    </div>