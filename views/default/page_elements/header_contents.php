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
<div id="layout_header">
	<div id="logo"><a href="<?php echo $vars['url']; ?>"><img src="<?php echo $vars['url']; ?>mod/enlightn/media/graphics/logo.gif" alt="<?php echo $vars['config']->sitename; ?>" title="<?php echo $vars['config']->sitename; ?>" /></a></div>
	<?php if (isloggedin()) { ?>
	<div id="top_search_box"><br />
	<?php echo elgg_view('page_elements/searchbox');
		echo elgg_view('input/pulldown', array('internalname' => 'discussion_type_filter'
													, 'internalid' => 'discussion_type_filter'
													, 'value' => ''
													, 'options_values' => array(ENLIGHTN_ACCESS_AL=>elgg_echo('enlightn:all')
																				, ENLIGHTN_ACCESS_PU=>elgg_echo('enlightn:public')
																				, ENLIGHTN_ACCESS_PR=>elgg_echo('enlightn:follow')
																				, ENLIGHTN_ACCESS_FA=>elgg_echo('enlightn:favorite')										
																				)
										)); ?></div>
	<div class="clearFloat"></div>
	<div id="navBar">
		<br />
		<ul id="nav">
			<li><a href="<?php echo $vars['url']; ?>pg/enlightn/"><?php echo elgg_echo("home"); ?></a></li>
			<li><a href="<?php echo $vars['url']; ?>pg/profile/<?php echo $vars['user']->username;?>" title=""><?php echo $vars['user']->username;?></a></li>
			<li><a href="<?php echo $vars['url']; ?>pg/members/" title=""><?php echo elgg_echo("members"); ?></a></li>
			<li><a href="<?php echo $vars['url']; ?>pg/settings/" title=""><?php echo elgg_echo("settings"); ?></a></li>
			<?php if ($vars['user']->admin || $vars['user']->siteadmin) { ?>
			<li><a href="<?php echo $vars['url']; ?>pg/admin/" class="usersettings"><?php echo elgg_echo("admin"); ?></a></li>
			<?php } ?>			
			<li><?php echo elgg_view('output/url', array('href' => "{$vars['url']}action/logout", 'text' => elgg_echo('logout'), 'is_action' => TRUE)); ?></li></ul>
	</div>
	<?php } ?>	
</div>
<div id="page_container">
<div id="page_wrapper">
<br />