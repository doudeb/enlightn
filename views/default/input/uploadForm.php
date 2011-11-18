<div id="embedContent" style="display:none">
	<form id="mediaUpload" action="<?php echo $vars['url']; ?>action/enlightn/upload" method="post" enctype="multipart/form-data">
	<div id="layer">
	    <span class="close" id="closeUploader">&times;</span>
	    <span class="caption">
            <?php echo elgg_echo('enlightn:uploadyourfile')?>
        </span>
            <?php
            if (get_context() != 'cloud') {
            ?>
            <span class="caption cloud_access"><a href="<?php echo $vars['url']; ?>/pg/enlightn/cloud/cloud_embed" rel="[facebox]" rev="iframe|1600" id="cloudLink"><?php echo elgg_echo("enlightn:uploadcloud"); ?></a></span>
            <?php
            }
            ?>
	    <input type="file" name="upload" id="upload"/>
	    <div id="uploader" style="display:none">
			<input type="text" placeholder="<?php echo elgg_echo('enlightn:titlefile')?>" name="title" id="filetitle"/>
	        <input type="text" placeholder="<?php echo elgg_echo('enlightn:tagsfile')?>" name="tags" id="filetags"/>
	        <?php
	        	echo elgg_view('input/hidden', array('internalname' => 'access_id','value' => $access_id));
   				echo elgg_view('input/securitytoken');
	        ?>
	        <div class="new-bloc" id="submitBloc">
                 <div id="submissionUpload"></div>
	           	<input type="submit" value="<?php echo elgg_echo('enlightn:buttonpost')?>" name="<?php echo elgg_echo('enlightn:upload')?>">
	        </div>
	    </div>
	</div>
	</form>
</div>
<script>

	$('#upload').change(function(){
       	$('#uploader').css('display','block');
	});

	$('#closeUploader').click(function(){
       	$('#embedContent').css('display','none');
       	$('#uploader').css('display','none');
	});

	$('#cloudLink').click(function(){
       	$('#embedContent').css('display','none');
       	$('#uploader').css('display','none');
	});

	if (typeof $('#entity_access_id') != undefined) {
		$('#access_id').val($('#entity_access_id').val());
	}
	if (typeof $('#membership') != undefined) {
		$('#access_id').val($('#membership').val());
	}
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
		            	$('#filename').val('');
		            	$('#filetags').val('');
		            	$('#filetitle').val('');
		            	$('#upload').val('');
                        <?php if(get_context() == 'cloud') {?>
		            	loadContent("#cloud_content",'<?php echo $vars['url'] ?>mod/enlightn/ajax/get_my_cloud.php?context=<?php echo get_context()?>&' + get_search_criteria());
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
</script>