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
            <h1 class="logo">enlightn</h1>
			<?php if (isloggedin()) { ?>
            <ul class="menus">
                <li class="directory"><a class="link" href="<?php echo $vars['url']; ?>pg/members/"><span class="ico"></span><?php echo elgg_echo('enlightn:directory')?></a></li>
                <li class="account submenu">
                    <span class="user">
                        <img src="<?php echo $vars['user']->getIcon('small')?>" />
                        <?php echo $vars['user']->username;?>
                        <span class="arrow"></span>
                    </span>
                    <ul>
                        <li><a href="<?php echo $vars['url']; ?>pg/profile/<?php echo $vars['user']->username;?>"><?php echo elgg_echo('profil')?></a></li>
                        <li><a href="<?php echo $vars['url']; ?>pg/settings/"><?php echo elgg_echo('settings')?></a></li>
						<?php if ($vars['user']->admin || $vars['user']->siteadmin) { ?>
						<li><a href="<?php echo $vars['url']; ?>pg/admin/" ><?php echo elgg_echo("admin"); ?></a></li>
						<?php } ?>
                    </ul>
                </li>
            </ul>
			<?php } ?>

            <ul class="tabs">
                <li class="home current"><a href="<?php echo $vars['url']; ?>pg/enlightn/"><?php echo elgg_echo("home"); ?></a></li>
                <li class="alert"><a href="/alert">Alert</a></li>
                <li class="favorites"><a href="/favorites">Favorites</a></li>
                <li class="replies"><a href="/replies">Replies</a></li>
            </ul>
        </div>
    </div>

