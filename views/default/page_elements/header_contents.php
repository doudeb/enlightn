<?php

	/**
	 * Elgg header contents
	 * This file holds the header output that a user will see
	 *
	 * @package Elgg
	 * @subpackage Core
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd and customized by Juipo.com
	 * @copyright Curverider Ltd and customized by Juipo.com 2009
	 * @link http://elgg.org/  and  http://juipo.com/
	 **/
?>
    <div id="header">
        <div class="nav">
            <a href="<?php echo $vars['url']; ?>enlightn/" alt="<?php echo elgg_echo('PUBLIC')?>"><h1 class="logo">enlightn</h1></a>
			<?php if (elgg_is_logged_in()) { ?>
            <ul class="menus">
                <li class="account submenu">
                    <span class="user">
                        <img src="<?php echo $vars['user']->getIconURL('small')?>" />
                        <?php echo $vars['user']->username;?>
                        <span class="arrow"></span>
                    </span>
                    <ul>
                        <li><a href="<?php echo $vars['url']; ?>enlightn/profile/<?php echo $vars['user']->username;?>"><?php echo elgg_echo('enlightn:myprofile')?></a></li>
                        <li><a href="<?php echo $vars['url']; ?>enlightn/settings/profile"><?php echo elgg_echo('enlightn:editprofile')?></a></li>
                        <li><a href="<?php echo $vars['url']; ?>enlightn/settings/"><?php echo elgg_echo('enlightn:settings')?></a></li>
						<?php if ($vars['user']->isAdmin()) { ?>
						<li><a href="<?php echo $vars['url']; ?>admin/statistics/overview" ><?php echo elgg_echo("admin"); ?></a></li>
						<?php } ?>
                        <li><a href="<?php echo $vars['url']; ?>action/logout"><?php echo elgg_echo('enlightn:logout')?></a></li>
                    </ul>
                </li>
            </ul>
			<?php } ?>

            <ul class="tabs">
                <li class="home<?php echo (elgg_get_context()==='home'?' current':'')?>" id="discussion_selector_<?php echo ENLIGHTN_ACCESS_PU?>_tabs"><a href="<?php echo $vars['url']; ?>enlightn/" alt="<?php echo elgg_echo('PUBLIC')?>" title="<?php echo elgg_echo("enlightn:title:discussions"); ?>"><?php echo elgg_echo("home"); ?></a></li>
                <li class="cloud<?php echo (elgg_get_context()==='cloud'?' current':'')?>"><a href="<?php echo $vars['url']; ?>enlightn/cloud"  title="<?php echo elgg_echo("enlightn:title:cloud"); ?>"><?php echo elgg_echo("cloud"); ?></a></li>
                <li class="directory<?php echo (elgg_get_context()==='directory'?' current':'')?>"><a href="<?php echo $vars['url']; ?>enlightn/directory" title="<?php echo elgg_echo("enlightn:title:directory"); ?>"><?php echo elgg_echo("directory"); ?></a></li>
                <!--<li class="alert" id="discussion_selector_<?php echo ENLIGHTN_ACCESS_PR?>_tabs"><a href="" onclick="$('#unreaded_only').val(0);changeMessageList('#discussion_selector_<?php echo ENLIGHTN_ACCESS_PR?>', <?php echo ENLIGHTN_ACCESS_PR?>);return false;">Alert</a></li>
                <li class="favorites" id="discussion_selector_<?php echo ENLIGHTN_ACCESS_FA?>_tabs"><a href="" onclick="$('#unreaded_only').val(0);changeMessageList('#discussion_selector_<?php echo ENLIGHTN_ACCESS_PR?>', <?php echo ENLIGHTN_ACCESS_FA?>);return false;">Favorites</a></li>
                <li class="replies" id="discussion_selector_sent_tabs"><a href="" onclick="$('#unreaded_only').val(0);changeMessageList('#discussion_selector_sent', <?php echo ENLIGHTN_ACCESS_PR?>);return false;">Replies</a></li>-->
            </ul>
        </div>
    </div>
	<div class="loader" id="loader"></div>
