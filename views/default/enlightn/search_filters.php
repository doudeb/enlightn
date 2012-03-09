    <div id="sidebar">

            <form id="search">
                <div class="search-field">
                    <!--<input type="text" placeholder="<?php echo elgg_echo("enlightn:search")?>" id="searchInput" name="q" value="<?php echo (get_last_search_value('words') && elgg_get_context() != 'home')?get_last_search_value('words'):'';?>" />-->
                    <?php echo elgg_view("enlightn/helper/addtags",array(
                                                                    'placeholder' => elgg_echo('enlightn:search'),
                                                                    'name' => 'q',
                                                                    'id' => 'searchInput',
                                                                    )); ?>
                    <input type="hidden" id="last_search">
                    <input type="hidden" name="search_tags" id="search_tags" value="<?php echo $vars['tags']?>">
                    <input type="hidden" name="search_tags" id="filter_id" value="<?php echo $vars['filter_id']?>">
                    <button class="submit" type="submit" id="search_submit"></button>
                </div>
                <div class="s-actions"><?php echo elgg_echo("enlightn:togglemorefilters"); ?><span class="arrow"></span></div>
                <div class="toggle-search-filters">
                    <input type="hidden" name="subtype_checked" id="subtype_checked" value="" />
                    <ul class="filters">
                        <li class="checked" style="width:83px" title="<?php echo elgg_echo("enlightn:title:buttonall")?>"><input id="type_all" name="subtype[]" type="checkbox" value="" checked /><label for="type_all"><?php echo elgg_echo("enlightn:buttonall")?></label></li>
                        <li title="<?php echo elgg_echo("enlightn:title:text")?>"><input id="type_text" name="subtype[]" type="checkbox" value="<?php echo ENLIGHTN_DISCUSSION;?>"/><label class="ico text" for="type_text"><?php echo elgg_echo('enlightn:'. ENLIGHTN_DISCUSSION);?></label></li>
                        <li title="<?php echo elgg_echo("enlightn:title:link")?>"><input id="type_link" name="subtype[]" type="checkbox" value="<?php echo ENLIGHTN_LINK;?>" /><label class="ico link" for="type_link"><?php echo elgg_echo('enlightn:'. ENLIGHTN_LINK);?></label></li>
                        <li title="<?php echo elgg_echo("enlightn:title:video")?>"><input id="type_video" name="subtype[]" type="checkbox" value="<?php echo ENLIGHTN_MEDIA;?>" /><label class="ico video" for="type_video"><?php echo elgg_echo('enlightn:'. ENLIGHTN_MEDIA);?></label></li>
                        <li title="<?php echo elgg_echo("enlightn:title:picture")?>"><input id="type_photo" name="subtype[]" type="checkbox" value="<?php echo ENLIGHTN_IMAGE;?>" /><label class="ico pict" for="type_photo">Photo</label></li>
                        <li title="<?php echo elgg_echo("enlightn:title:document")?>"><input id="type_doc" name="subtype[]" type="checkbox" value="<?php echo ENLIGHTN_DOCUMENT;?>" /><label class="ico doc" for="type_doc"><?php echo elgg_echo('enlightn:'. ENLIGHTN_DOCUMENT);?></label></li>
                    </ul>
                    <div class="dates">
                        <input id="date_begin" type="text" class="date" placeholder="<?php echo elgg_echo('enlightn:datefrom')?>" />
                        <span style="width:14px;display:inline-block"></span>
                        <input id="date_end" type="text" class="date" placeholder="<?php echo elgg_echo('enlightn:dateto')?>" />
                    </div>
                    <div class="author">
                        <label for="from_users"><?php echo elgg_echo('enlightn:fromuser'); ?></label>
                        <?php echo elgg_view("enlightn/helper/adduser",array(
                                                                    'placeholder' => elgg_echo('enlightn:fromuser'),
                                                                    'name' => 'from_users',
                                                                    'id' => 'from_users',
                                                                    )); ?>
                    </div>
                </div>
            </form>
<script type="text/javascript">
jQuery(document).ready(function () {
	$('input.date').simpleDatepicker({x: -55, y: 20});
});
</script>