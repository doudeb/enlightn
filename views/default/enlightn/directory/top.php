<script>
    $(function() {
        var
            mdPageX = 0,
            mdPageY = 0,
            selectedCount = 1,
            dropAreas = [],
            formUserIds = [],

            preventSelection = function() {
        		$('body').addClass('unselectable');
        		document.onselectstart = function(){ return false; };
        		document.unselectable = "on";
        	},

        	stopPreventSelection = function() {
        		$('body').removeClass('unselectable');
        		document.onselectstart = null;
        		document.unselectable = "off";
        	},

            updateDropAreas = function() {
                dropAreas = [];
                var n=0;

                $('#sidebar .dropable').each(function() {
                    var obj = $(this).position();
                    obj.height = $(this).height();
                    obj.width = $(this).width();
                    obj.id = $(this).attr('id').replace('area','');
                    dropAreas.push(obj);
                    n++;
                });
            },

            highLightDropArea = function() {
                var
                    n = 0,
                    done = false,
                    pos = $('#mover').position()
                ;
                while(n < dropAreas.length && !done) {
                    if((pos.left >= dropAreas[n].left && pos.left <= (dropAreas[n].left + dropAreas[n].width)) && (pos.top >= dropAreas[n].top && pos.top <= (dropAreas[n].top + dropAreas[n].height))) {
                        if(!$('#area' + dropAreas[n].id).hasClass('highlight')) {
                            $('#sidebar .highlight').removeClass('highlight');
                            $('#area' + dropAreas[n].id).addClass('highlight');
                            $('#mover').addClass('hover');
                        }
                        done = true;
                    }
                    n++;
                }
                if(!done) {
                    $('#sidebar .highlight').removeClass('highlight');
                    $('#mover').removeClass('hover');
                }
            },

            addNewList = function(name, isPrivate) {

                var privacyClass = isPrivate ? 'private-ico' : 'public-ico';

                /* APPEL AJAX DE CREATION */
                $.post('<?php echo elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/collection/addcollection");?>', {listName: name, userIds: formUserIds, isPrivate: isPrivate}, function(data) {

                    //var data = {id: Math.round(Math.random()*1000)}; /* REMOVE after Ajax implementation */

                    $('#sidebar .addform')
                        /* Add list and tag to users */
                        .before('<li id="area'+ data.id +'" class="dropable" style="display:none" data-listId="'+ data.id +'" data-listName="'+ name +'"><a class="cat" href="/list'+ data.id +'"><span class="count">'+ formUserIds.length +'</span>'+ name +'<span class="ico '+ privacyClass +'"></span></a></li>')
                        .find('.count').text('').end()
                        .find('.form').hide()
                            .find('input').val('').end()
                            .find('.ico').addClass('private-ico').removeClass('public-ico');

                        for(var i=0, len=formUserIds.length; i < len; i++) {
                            $('#user' + formUserIds[i]).append('<span class="tag tag'+ data.id +'" data-tagId="'+ data.id +'">'+ name +' <span class="del">&times;</span></span>');
                        }

                        /* Reset initial state */
                        formUserIds = []
                        $('#feed .selected-user').removeClass('selected-user');

                        /* Display effect */
                        $('#area'+ data.id).slideDown(function() {
                            updateDropAreas();
                        });

                });
            }
        ;

        updateDropAreas();

        $('#sidebar .addform')
            .click(function() {
                $(this).find('.form').show();
                $(this).find('.form input').focus();
            });

        $('#sidebar .addform input')
            .keyup(function(e) {
                if(e.keyCode == 13) {
                    if($(this).val() == '') {
                        alert('<?php elgg_echo("enlightn:errorlistnoname"); ?>');
                        return false;
                    }
                    addNewList($(this).val(), $('#sidebar .addform .ico').hasClass('private-ico'));
                }
            });

        $('#sidebar .addform .ico')
            .click(function() {
                $(this).toggleClass('private-ico').toggleClass('public-ico');
            });

        $('#feed .user')
            .click(function(e) {
                if($(e.target).hasClass('del')) {
                    var
                        tag = $(e.target).parent('.tag'),
                        userId = tag.parents('.user').attr('data-userId'),
                        listCount = $('#area'+ tag.attr('data-tagId') +' .count')
                    ;
                    listCount.text(parseInt(listCount.text()) - 1);
                    tag.remove();

                    /* APPEL AJAX DE SUPPRESSION */
                    $.post('<?php echo elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/collection/removefromcollection");?>', {listId: tag.attr('data-tagId'), userId: userId}, function(data) {/* ? */});
                }
            })
            .mousedown(function(e) {
                if(!$(e.target).hasClass('del')) {
                    var curUser = $(this);
                    mdPageX = e.pageX;
                    mdPageY = e.pageY;
                    selectedCount = $('#feed .selected-user').length;

                    preventSelection();

                    $(document).mousemove(function(e) {
                        if(!$('#sidebar .folders').hasClass('drop-folders')) $('#sidebar .folders').addClass('drop-folders');
                        if(!curUser.hasClass('selected-user') && (e.pageX != mdPageX) && (e.pageY != mdPageY)) {
                            curUser.addClass('selected-user');
                            selectedCount = $('#feed .selected-user').length;
                        }
                        if($('#mover').length == 0) {
                            $('<div/>')
                                .attr('id', 'mover')
                                .css('top', e.pageY - 15)
                                .css('left', e.pageX - 25)
                                .text(selectedCount)
                                .appendTo('body');
                        } else {
                            $('#mover')
                                .css('top', e.pageY - 15)
                                .css('left', e.pageX - 25)
                                .text(selectedCount);
                        }

                        highLightDropArea();
                    })
                    .mouseup(function(e) {
                        if((e.pageX > (mdPageX-5)) && (e.pageX < (mdPageX+5)) && (e.pageY > (mdPageY-5)) && (e.pageY < (mdPageY+5))) curUser.toggleClass('selected-user');

                        /* Reset initial state */
                        stopPreventSelection();
                        $('#mover').fadeOut(1000, function() { $('#mover').remove() });
                        $('#sidebar .folders').removeClass('drop-folders');

                        if($('#sidebar .highlight').length > 0) {
                            if($('#sidebar .highlight').hasClass('addform')) {

                                /* List of userId added */
                                formUserIds = []
                                $('#feed .selected-user').each(function() {
                                    formUserIds.push($(this).attr('data-userId'));
                                    /*$(this).append('<span class="tag tag'+ listId +'" data-tagId="'+ listId +'">'+ listName +' <span class="del">&times;</span></span>');*/
                                });

                                /* Add form */
                                var folder = $('#sidebar .highlight');
                                folder.removeClass('highlight');
                                folder.find('.count').text(formUserIds.length);
                                folder.find('.form').show();
                                $(this).find('.form input').focus();

                            } else {
                                /* User list infos */
                                var
                                    listId = $('#sidebar .highlight').attr('data-listId'),
                                    listName = $('#sidebar .highlight').attr('data-listName')
                                ;

                                /* List of userId added */
                                var addedUserIds = []
                                $('#feed .selected-user').each(function() {
                                    if($(this).find('.tag' + listId).length == 0) {
                                        addedUserIds.push($(this).attr('data-userId'));
                                        $(this).append('<span class="tag tag'+ listId +'" data-tagId="'+ listId +'">'+ listName +' <span class="del">&times;</span></span>');
                                    }
                                });

                                /* Adding effect */
                                var
                                    folder = $('#sidebar .highlight'),
                                    oldCount = folder.find('.count')
                                ;
                                oldCount.addClass('oldCount');
                                folder.addClass('increased').removeClass('highlight');
                                oldCount.fadeOut(400, function() {
                                    oldCount.removeClass('oldCount').text(parseInt(oldCount.text()) + addedUserIds.length);
                                    oldCount.fadeIn(600);
                                });
                                $('#mover').removeClass('hover');
                                $('#feed .selected-user').removeClass('selected-user');

                                /* APPEL AJAX D'ENREGISTREMENT */
                                $.post('<?php echo elgg_add_action_tokens_to_url("{$vars['url']}action/enlightn/collection/addtocollection");?>', {listId: listId, userIds: addedUserIds}, function(data) {/* ? */});

                                setTimeout(function() {
                                    folder.removeClass('increased');
                                }, 1500);
                            }
                        }

                        $(document).unbind('mousemove');
                        $(document).unbind('mouseup');
                    });
                }
            });
    });
 </script>
 <div id="main">

            <div id="directory">
                <div class="header">
                    <form id="search" action="" method="post">
                        <div class="search-field">
                            <input type="text" placeholder="<?php echo elgg_echo('enlightn:directory:search');?>" name="userSearch" value="<?php echo $vars['user_search']?>"/>
                            <button class="submit" type="submit"></button>
                        </div>
                    </form>

                    <h2><?php echo elgg_echo('enlightn:directory');?></h2>
                </div>

                <div id="feed">
                    <div class="s-actions">
                        <ul></ul>
				</div>
