<?php
$user_ent           = elgg_get_logged_in_user_entity();
$options            = array('types'=>'object','subtypes'=>ENLIGHTN_FILTER,'owner_guids'=>$user_ent->guid);
$saved_search       = elgg_get_entities($options);
?>

<div id="embedContent" style="display:none">
	<form id="mediaUpload" action="<?php echo $vars['url']; ?>action/enlightn/upload" method="post" enctype="multipart/form-data">
	<div id="layer">
	    <span class="close" id="closeUploader">&times;</span>
	    <span class="caption">
            <?php echo elgg_echo('enlightn:uploadyourfile')?>
        </span>
            <?php
            if (elgg_get_context() != 'cloud') {
            ?>
            <span class="caption cloud_access"><a href="<?php echo $vars['url']; ?>enlightn/cloud/cloud_embed" rel="[facebox]" rev="iframe|1600" id="cloudLink"><?php echo elgg_echo("enlightn:uploadcloud"); ?></a></span>
            <?php
            }
            ?>
	    <input type="file" name="upload" id="upload"/>
	    <div id="uploader" style="display:none">
            <h2 id="filetitle_preview"></h2> <span id="editmytitle" class="caption cloud_access"><?php echo elgg_echo("enlightn:editmytitle"); ?></span>
			<input type="text" placeholder="<?php echo elgg_echo('enlightn:titlefile')?>" name="title" id="filetitle"/>
	        <?php
	        	echo elgg_view('input/hidden', array('name' => 'access_id','value' => ACCESS_PRIVATE));
	        	echo elgg_view('input/hidden', array('name' => 'file_filter_id','id'=> 'file_filter_id'));
   			echo elgg_view('input/securitytoken');
	        ?>
                <div class="new-bloc" id="submitBloc">
                    <div id="submissionUpload"></div>
                    <?php
                    if (elgg_get_context() == 'cloud') {
                    ?>
                    <div class="privacy private">
                        <span class="private-val value"><span class="ico"></span><?php echo elgg_echo('enlightn:buttonprivate') ?></span>
                        <span class="cursor" id="file_privacy_cursor"></span>
                        <span class="public-val value"><?php echo elgg_echo('enlightn:buttonpublic') ?></span>
                    </div>
                    <?php
                    }
                    ?>
                    <div class="saved-search-select">
                        <span class="ico"></span><span class="saved-search-label-apply"><?php echo elgg_echo("enlightn:applyfilter"); ?><span class="arrow"/></span><span id="selected_filter"></span></span>
                        <?php echo elgg_view("enlightn/helper/saved_search_list", array('list'=>$saved_search))?>
                    </div>
                    <div class="edit-keyword" id="editkeyword"><?php echo elgg_echo("enlightn:editkeyword"); ?><span class="arrow"/></div>
                    <div class="tags">
                        <span class="add">
                            <span class="ico"></span>
                            <span class="caption" id="add-tags-file"><?php echo elgg_echo("enlightn:tags") ?></span>
                            <span id="tags-input-file">&nbsp;<?php echo elgg_view("input/tags",array(
                                                                'name' => 'interests-file',
                                                                'id' => 'interests-file'));
                                                                echo elgg_view("input/hidden",array(
                                                                'name' => 'filetags',
                                                                'id' => 'filetags')); ?></span>
                        </span>
                        <div id="tags-result-file"></div>
                    </div>
                    <div class="sending"><button type="submit" class="submit"><?php echo elgg_echo('enlightn:buttonpost')?></button></div>
                </div>
	    </div>
	</div>
	</form>
</div>
<script>

	$('#upload').change(function() {
        var file_path = $('#upload').val(),
            filename =  file_path.substring(file_path.lastIndexOf("\\")+1);
        filename =  filename.substring(0,filename.lastIndexOf("."));
        $('#submissionUpload').val('');
       	$('#upload').css('display','none');
       	$('#uploader').css('display','block');
       	$('#filetitle').css('display','none');
       	$('#filetags').css('display','none');
       	$('#filetitle_preview').html(filename);
	});

    $('#editmytitle').click(function(){
        $('#filetitle_preview').html('');
        $('#editmytitle').toggle();
        $('#filetitle').toggle();
        $('#filetitle')
        .keydown(function(e) {
            if(e.keyCode == 13) {
                $('#filetitle_preview').html($('#filetitle').val());
                $('#filetitle').toggle();
                $('#editmytitle').toggle();
                return false;
            }
        });
    });

    $(".saved-search-select li").click(function(){
        elm = $(this)
                , destElm = $('#file_filter_id')
                , selectedElm = $('#selected_filter');
        filter_id = elm.attr('data-guid')
                , name = elm.attr('data-name');
        if (filter_id) {
            destElm.val(filter_id);
            selectedElm.html(name);
            elm.parent().toggle();
        }
    });
	$('#editkeyword').click(function() {
        $(this).find('span').toggleClass('arrow-top');
        $('#uploader .tags').toggle();
        if($('#uploader .tags').css('display') == 'none') {
            $('#tags-result-file').html('');
            return false;
        }
        addedKeywords = [];
        deletedKeywords = [];
        var text = $('#filetitle').val(),
            elm = $('#tags-result-file');

        if (elm.html().indexOf('loading.gif') != -1) {
            return false;
        }
        elm.prepend('<img src="<?php echo $vars['url'] ?>mod/enlightn/media/graphics/loading.gif">');
        var options = {
            url:            '<?php echo "{$vars['url']}mod/enlightn/ajax/file_tagger.php";?>'
            , dataType:     'json'
            , success:   processTags
        };
        $('#mediaUpload').ajaxSubmit(options);

        function processTags (data) {
            tags = $('#tags-result-file .tag');
            elm = $('#tags-result-file');
            tags.each(function() {
                if ($(this).attr('data-keyword')) addedKeywords.push($(this).attr('data-keyword'));
            });
            $.each(data, function(keyword, accurency) {
                if (accurency > 1 && keyword &&!addedKeywords.in_array(keyword) && !deletedKeywords.in_array(keyword)) {
                    elm.append('<span class="tag" data-keyword="' + keyword + '">'+ keyword +' <span class="del">&times;</span></span>');
                }
            });
            if (addedKeywords.length == 0) {
                tags = $('#tags-result-file .tag');
                tags.each(function() {
                    if ($(this).attr('data-keyword')) addedKeywords.push($(this).attr('data-keyword'));
                });
                $('#filetags').val(addedKeywords.join(','));
            }
            elm.find('img').remove();
        }

        $('#tags-result-file')
            .click(function(e) {
                if($(e.target).hasClass('del')) {
                    var
                        tag = $(e.target).parent('.tag'),
                        tags = $('#tags-result-file .tag'),
                        addedKeywords = [];
                    deletedKeywords.push(tag.attr('data-keyword'));
                    tag.remove();
                    tags.each(function() {
                        if ($(this).attr('data-keyword')) addedKeywords.push($(this).attr('data-keyword'));
                    });
                    $('#filetags').val(addedKeywords.join(','));
                }
            });
        $('#add-tags-file')
            .click(function () {
            $('#tags-input-file')
                .toggle();
        });
        $('#interests-file')
            .keydown(function(e) {
                    if(e.keyCode == 13) {
                        if($('#interests-file').val() == '') {
                            alert('<?php elgg_echo("enlightn:errorlistnoname"); ?>');
                            return false;
                        }
                        $('#tags-result-file').append('<span class="tag" data-keyword="' + $('#interests-file').val() + '">' + $('#interests-file').val() + ' <span class="del">&times;</span></span>').fadeIn(1000);
                        $('#filetags').val($('#filetags').val() + ',' + $('#interests-file').val());
                        $('#interests-file').val('');
                        return false;
                    }
        });
	});

	$('#closeUploader').click(function(){
       	$('#embedContent').css('display','none');
        $('#upload').css('display','block');
        $('#upload').val('');
        $('#tags-result-file').html('');
        $('#submissionUpload').val('');
        $('#filetitle_preview').html('');
        $('#access_id').val(<?php echo ENLIGHTN_ACCESS_PRIVATE?>);
        $('#filetags').val('');
        $('#filetitle').val('');
        $('#file_filter_id').val('');
        $('#selected_filter').html('');
	});

	$('#cloudLink').click(function(){
       	$('#embedContent').css('display','none');
       	$('#uploader').css('display','none');
	});

    // wait for the DOM to be loaded
    //$(document).ready(function() {
        // bind 'myForm' and provide a simple callback function
    $('#mediaUpload').submit(function() {
            var options = {
                beforeSubmit: showLoading,
                target: '#submissionUpload',
                clearForm: true,
                resetForm: true,
                success:    function(data) {
                    $('#uploader').css('display','none');
                    $('#embedContent').css('display','none');
                    $('#upload').css('display','block');
                    $('#filename').val('');
                    $('#filetags').val('');
                    $('#filetitle').val('');
                    $('#file_privacy_cursor');
                    $('#submissionUpload').val('');
                    $('#upload').val('');
                    $('#tags-result-file').html('');
                    $('#access_id').val(<?php echo ENLIGHTN_ACCESS_PRIVATE?>);
                    $('#file_privacy_cursor').parent().removeClass('public');
                    $('#file_privacy_cursor').parent().addClass('private');
                    $('#file_filter_id').val('');
                    $('#selected_filter').html('');
                    <?php if(elgg_get_context() == 'cloud') {?>
                    loadContent("#cloud_content",'<?php echo $vars['url'] ?>mod/enlightn/ajax/get_my_cloud.php?context=<?php echo elgg_get_context()?>&' + get_search_criteria());
                    $('#submissionUpload').val('');
                    <?php } else { ?>
                    updateRte(data);
                    <?php } ?>
                }
            };

            $(this).ajaxSubmit(options);
            return false;
    });
	function showLoading () {
		$('#submissionUpload').html('<img src="<?php echo $vars['url'] ?>/mod/enlightn/media/graphics/loading.gif" alt="loading">');
		return true;
	}
    $('#file_privacy_cursor').click( function(){
        if($(this).parent().hasClass('private')) {
            $(this).parent().removeClass('private');
            $(this).parent().addClass('public');
            $('#access_id').val(<?php echo ENLIGHTN_ACCESS_PUBLIC?>);
        } else {
            $(this).parent().removeClass('public');
            $(this).parent().addClass('private');
            $('#access_id').val(<?php echo ENLIGHTN_ACCESS_PRIVATE?>);
        }
    });
</script>