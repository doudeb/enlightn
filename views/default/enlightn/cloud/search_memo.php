<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *
 */
$user_ent               = $vars['user_ent'];
$labels                 = get_labels ($user_ent);
?>
<div class="saved-search starred">
    <span><?php echo elgg_echo("enlightn:alllabels")?></span><span class="editlabel"><?php echo elgg_echo("enlightn:edit")?></span>
    <?php echo elgg_view("enlightn/helper/saved_search_list", array('list'=>$labels))?>
</div>
<script>
    $(".saved-search .editlabel").click(function () {
        $(".saved-search-select ul").toggle();
    });

    $(".saved-search .editlabel").click(function(){
        elm = $('#saved-search-list');
        $('.saved-search').find('.close').toggle();
        $('#new-label_inputs').remove();
        if ($(this).html() == '<?php echo elgg_echo("enlightn:edit")?>') {
            $(this).html('<?php echo elgg_echo("enlightn:close")?>');
            $(elm).prepend('<li id="new-label_inputs"><input id="search-memo-name" placeholder="<?php echo elgg_echo("enlightn:enterlabelname")?>"><input type="submit" value="<?php echo elgg_echo("enlightn:buttonpost")?>" id="search-memo-post"><span class="ico private-ico" title="<?php echo elgg_echo("enlightn:privatepublic"); ?>"/></li>');
            $('#new-label_inputs .ico')
            .click(function() {
                $(this).toggleClass('private-ico').toggleClass('public-ico');
            });
            $("#search-memo-post")
            .click(function(){
                var newSearchName = $('#search-memo-name').val(),
                    isPrivate = $('#new-label_inputs .ico').hasClass('private-ico');
                /* APPEL AJAX DE CREATION */
                $.post('<?php echo elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/cloud/saveSearch");?>', {searchName: newSearchName, isPrivate: isPrivate, isLabel:true}, function(result) {
                    //remove class current
                    if(result)  {
                        listElm = $('#saved-search-list');
                        listElm.append("<li data-params='" + JSON.stringify(result) + "'>" + $('#search-memo-name').val() + "<span class='ico " + (isPrivate?'private-ico':'public-ico') + "' title='<?php echo elgg_echo("enlightn:privatepublic"); ?>'/><span class='close'>&times;</span></li>");
                    }
                },'json');
            });
        } else {
             $(this).html('<?php echo elgg_echo("enlightn:edit")?>');
        }
    });
</script>