<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *
 */
$current                = 'saved-search';
?>
<div id="settings_tabs">
    <ul class="settings_tabs">
        <?php
        foreach (array('saved-search','tag-tree') as $key => $value) {
            echo '<li id="' . $value . '" class="' . ($current===$value?'current':'') . '">' . elgg_echo('enlightn:'. $value) . "</li>\n";
        }
        ?>
    </ul>
</div>
<div class="saved-search" id="tabsaved-search">
    <span class="editlabel"><span class="ico folder_add"></span><?php echo elgg_echo("enlightn:addnewfolder")?></span>
    <?php echo elgg_view("enlightn/helper/saved_search_list", array('show_invite'=>true,'elm'=>'saved-search-list','navcallback'=>'savedTreeNav'))?>
</div>
<div class="tag-tree" id="tabtag-tree">
    <?php if (elgg_is_admin_logged_in()) { ?><span class="addtotree"><span class="ico folder_add"></span><?php echo elgg_echo("enlightn:addnewfolder")?></span><?php }?>
    <?php echo elgg_view("enlightn/helper/suggested_search")?>
</div>
<div id="addtotreeinput" class="layer">
    <span class="caption">
        <p><?php echo elgg_echo("enlightn:tagtreeheadline")?></p>
        <p> <?php echo elgg_view("enlightn/helper/addtags",array(
                                                                    'placeholder' => elgg_echo('enlightn:enterlabelname'),
                                                                    'name' => 'tag-tree-name',
                                                                    'id' => 'tag-tree-name',
                                                                    'unique_id' => 'tag-tree-name'
                                                                    ));?></p>
        <?php if (elgg_is_admin_logged_in()) { ?>
        <p><span class="ico private-ico" title="<?php echo elgg_echo("enlightn:privatepublic"); ?>"></span><?php echo elgg_echo("enlightn:selectprivacy")?></p>
        <?php }?>
        <p><input type="checkbox" id="shareWith"><?php echo elgg_echo("enlightn:sharewith")?></p>
        <p id="shareWithInput"><?php echo elgg_view("enlightn/helper/adduser",array(
                                                                    'placeholder' => elgg_echo('enlightn:fromuser'),
                                                                    'name' => 'invite_users',
                                                                    'id' => 'invite_users',
                                                                    'unique_id' => 'invite_users',
                                                                    )); ?></p>
        <p><input type="checkbox" id="isChildrenOf"><?php echo elgg_echo("enlightn:ischildrenofanothertag")?><span id="selectedParent"></span></p>
        <p><ul id="isChildrenOfSelect" class="isChildrenOfSelect"></ul></p>
        <p class="submit">
            <button type="reset" class="submit" id='cancelnewlabel'><?php echo elgg_echo("enlightn:buttoncancel"); ?></button>
            <button type="submit" class="submit" id="submitnewlabel"><?php echo elgg_echo("enlightn:buttonpost"); ?></button>
        </p>
    </span>
</div>
<script>
    $(".saved-search .editlabel").click(function () {
        $(".saved-search-select ul").toggle();
    });

    $(".saved-search .editlabel").click(function(){
        $("#addtotreeinput").toggle();
        return true;
        elm = $('#saved-search-list');
        $('.saved-search').find('.close').toggle();
        $('#new-label_inputs').remove();
        if ($(this).html() == '<?php echo elgg_echo("enlightn:edit")?>') {
            $(this).html('<?php echo elgg_echo("enlightn:close")?>');
            $(elm).prepend('<li id="new-label_inputs"><input id="search-memo-name" placeholder="<?php echo elgg_echo("enlightn:enterlabelname")?>"><span class="ico private-ico" title="<?php echo elgg_echo("enlightn:privatepublic"); ?>"/></li>');
            $('#new-label_inputs .ico')
            .click(function() {
                $(this).toggleClass('private-ico').toggleClass('public-ico');
            });
            $("#search-memo-name")
            .keyup(function(e){
                if(e.keyCode == 13) {
                    var newSearchName = $('#search-memo-name').val(),
                        isPrivate = $('#new-label_inputs .ico').hasClass('private-ico');
                        if (newSearchName.length > 2) {
                            /* APPEL AJAX DE CREATION */
                            $.post('<?php echo elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/cloud/saveSearch");?>', {searchName: newSearchName, isPrivate: isPrivate, isLabel:true}, function(result) {
                                //remove class current
                                if(result)  {
                                    listElm = $('#saved-search-list');
                                    listElm.append("<li data-params='" + JSON.stringify(result) + "'>" + $('#search-memo-name').val() + "<span class='ico " + (isPrivate?'private-ico':'public-ico') + "' title='<?php echo elgg_echo("enlightn:privatepublic"); ?>'/><span class='close' style='display:block'>&times;</span></li>");

                                }
                            },'json');
                        }
                }
            });
        } else {
             $(this).html('<?php echo elgg_echo("enlightn:edit")?>');
        }
    });
    $("#cancelnewlabel").click(function(){
         $("#addtotreeinput").toggle();
    });
     $(".tag-tree .addtotree").click(function(){
         $("#addtotreeinput").toggle();
    });
    $('#addtotreeinput .ico')
        .click(function() {
            $(this).toggleClass('private-ico').toggleClass('public-ico');
    });
    $('#isChildrenOf')
        .click(function() {
            if (!$(this).is(':checked')) {
                $("#isChildrenOfSelect").html('');
                $("#selectedParent").html('');
                $(this).val('');
            } else {
                loadTagTree("#isChildrenOfSelect",'followed',false,childrenSelect);
            }
    });
     $('#shareWith')
        .click(function() {
             $("#shareWithInput").toggle();
             $("#invite_users").tokenInput('clear');
    });

    var childrenSelect = function() {
        elm = $(this)
                , destElm = $('#isChildrenOf')
                , selectedElm = $('#selectedParent')
                , filter_id = elm.attr('data-guid')
                , name = elm.attr('data-name')
                , newElm = 'tagSelectNav' + elm.attr('data-guid');;
        if (elm.hasClass('opened')) {
            elm.removeClass('opened');
            $('#' +newElm).remove();
            return true;
        } else if (filter_id) {
            elm.addClass('opened');
            destElm.val(filter_id);
            selectedElm.html(name);
            if(elm.attr('data-hasChildren')==='true') {
                $('<ul />', {'id' : newElm}).insertAfter(elm);
                loadTagTree('#' + newElm,'private',filter_id,childrenSelect);
            } else {
                $('#isChildrenOfSelect').html('');
            }
        }
     };
    $('#submitnewlabel')
        .click(function() {
            var newSearchName = $('#tag-tree-name').val()
                , parentId = $('#isChildrenOf').val()
                , invite_users = $('#invite_users').val()
                , isPrivate = $('#addtotreeinput .ico').hasClass('private-ico')?true:false;
                if (newSearchName.length <= 2) return false;
                    $.post('<?php echo elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/cloud/saveSearch");?>', {searchName: newSearchName, isPrivate: isPrivate, isLabel:true,parentId:parentId,invite_users:invite_users}, function(result) {
                        //remove class current
                        if(result)  {
                            $("#tag-tree-list").html('');
                            loadTagTree("#tag-tree-list",'suggest',false,tagTreeNav);
                            $("#saved-search-list").html('');
                            loadTagTree("#saved-search-list",'followed',false,savedTreeNav);
                            $("#addtotreeinput").toggle();
                            newSearchName.val('');
                            parentId.val('');
                            $('#isChildrenOfSelect').html('');
                            $('#invite_users').val('');
                        }
                    },'json');
    });
</script>