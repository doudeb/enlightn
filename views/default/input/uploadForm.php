<div id="embedContent" style="display:none">
	<form id="mediaUpload" action="<?php echo $vars['url']; ?>action/enlightn/upload" method="post" enctype="multipart/form-data">
	<div id="layer">
	    <span class="close" id="closeUploader">&times;</span>
	    <span class="caption"><?php echo elgg_echo('enlightn:uploadyourfile')?><small> <a href="<?php echo $vars['url']; ?>/pg/enlightn/cloud" rel="facebox" id="cloudLink"><?php echo elgg_echo("enlightn:cloud"); ?></a>
	    <input type="file" name="upload" id="upload"/>
	    <div id="uploader" style="display:none">
			<input type="text" placeholder="<?php echo elgg_echo('enlightn:title')?>" name="title" id="title"/>
	        <input type="text" placeholder="<?php echo elgg_echo('enlightn:keywords')?>" name="tags" id="tags"/>
	        <?php
	        	echo elgg_view('input/hidden', array('internalname' => 'access_id','value' => $access_id));
   				echo elgg_view('input/securitytoken');
	        ?>
	        <div class="new-bloc" id="submitBloc">
	           	<input type="submit" value="<?php echo elgg_echo('enlightn:upload')?>" name="<?php echo elgg_echo('enlightn:upload')?>">
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
	            	beforeSubmit:  showLoading,
				    success:    function(data) {
				       	$('#uploader').css('display','none');
		            	$('#embedContent').css('display','none');
		            	$('#filename').val('');
		            	$('#tags').val('');
		            	$('#title').val('');
				       	$(".rte-zone").contents().find(".frameBody").html($(".rte-zone").contents().find(".frameBody").html() + ' ' + data);
				    }
				};

	        	$(this).ajaxSubmit(options);
	            return false;
    });
	function showLoading () {
		$('#submitBloc').html('<img src="<?php echo $vars['url'] ?>/mod/enlightn/media/graphics/loading.gif" alt="loading">');
		return true;
	}
</script>