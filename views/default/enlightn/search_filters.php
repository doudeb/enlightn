		<?php //echo elgg_view('input/calendar',array('internalname'=>'date_end')); ?>
		<div id="sidebar">

            <form id="search">
                <div class="search-field">
                    <input type="text" placeholder="<?php echo elgg_echo("search")?>" id="searchInput" name="q"/>
                    <input type="hidden" id="last_search">
                    <button class="submit" type="submit" id="search_submit"></button>
                </div>
                <input type="hidden" name="subtype_checked" id="subtype_checked" value="" />
                <ul class="filters">
                    <li class="checked"><input id="type_all" name="subtype[]" type="checkbox" value="" checked /><label for="type_all">All</label></li>
                    <li><input id="type_text" name="subtype[]" type="checkbox" value="<?php echo ENLIGHTN_DISCUSSION;?>"/><label class="ico text" for="type_text"><?php echo elgg_echo('enlightn:'. ENLIGHTN_DISCUSSION);?></label></li>
                    <li><input id="type_link" name="subtype[]" type="checkbox" value="<?php echo ENLIGHTN_LINK;?>" /><label class="ico link" for="type_link"><?php echo elgg_echo('enlightn:'. ENLIGHTN_LINK);?></label></li>
                    <li><input id="type_video" name="subtype[]" type="checkbox" value="<?php echo ENLIGHTN_MEDIA;?>" /><label class="ico video" for="type_video"><?php echo elgg_echo('enlightn:'. ENLIGHTN_MEDIA);?></label></li>
                    <li><input id="type_photo" name="subtype[]" type="checkbox" value="<?php echo ENLIGHTN_IMAGE;?>" /><label class="ico pict" for="type_photo">Photo</label></li>
                    <li><input id="type_doc" name="subtype[]" type="checkbox" value="<?php echo ENLIGHTN_DOCUMENT;?>" /><label class="ico doc" for="type_doc"><?php echo elgg_echo('enlightn:'. ENLIGHTN_DOCUMENT);?></label></li>
                </ul>
                <div class="dates">
                    <label for="date_begin"><?php echo elgg_echo('enlightn:datefrom')?></label><input id="date_begin" type="text" class="date" />
                    <label for="date_end"><?php echo elgg_echo('enlightn:dateto')?></label><input id="date_end" type="text" class="date" />
                </div>
                <div class="author">
                	<label for="from_users"><?php echo elgg_echo('enlightn:fromuser')?></label>
					<?php echo elgg_view("enlightn/helper/adduser",array(
																'internalname' => 'from_users',
																'internalid' => 'from_users',
																)); ?>
                </div>
            </form>
<script type="text/javascript">
jQuery(document).ready(function () {
	$('input.date').simpleDatepicker({x: -55, y: 20});
});
</script>