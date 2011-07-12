<?php
	echo elgg_view('enlightn/cloud/tabs',array('tab' => 'upload', 'internalname'=>$vars['internalname']));
	if (!elgg_view_exists('file/upload')) {
		echo "<p>" . elgg_echo('embed:file:required') . "</p>";
	} else {
		$action = 'file/upload';
?>
	<form id="mediaUpload" action="<?php echo $vars['url']; ?>action/enlightn/upload" method="post" enctype="multipart/form-data">
		<p>
			<label for="upload"><?php echo elgg_echo("file:file"); ?><br />
		<?php
			echo elgg_view('input/securitytoken');
			echo elgg_view("input/file",array('internalname' => 'upload', 'js' => 'id="upload"'));
		?>
		</label></p>
		<p>
			<label><?php echo elgg_echo("title"); ?><br />
			<?php

				echo elgg_view("input/text", array(
									"internalname" => "title",
									"value" => $title,
													));

			?>
			</label>
		</p>
		<p>
		<label for="filedescription"><?php echo elgg_echo("description"); ?><br />
		<textarea class="input-textarea" name="description" id="filedescription"></textarea>
		</label></p>

		<p>
			<label><?php echo elgg_echo("tags"); ?><br />
			<?php
				echo elgg_view("input/tags", array(
									"internalname" => "tags",
									"value" => $tags,
													));

			?>
			</label>
		</p>
		<p>
			<label>
				<?php echo elgg_view('input/hidden', array('internalname' => 'access_id','value' => $access_id)); ?>
			</label>
		</p>

		<p>
			<?php

				if (isset($vars['container_guid']))
					echo "<input type=\"hidden\" name=\"container_guid\" value=\"{$vars['container_guid']}\" />";
				if (isset($vars['entity']))
					echo "<input type=\"hidden\" name=\"file_guid\" value=\"{$vars['entity']->getGUID()}\" />";

			?>
			<input type="submit" value="<?php echo elgg_echo("save"); ?>" />
		</p>
	</form>
	<script type="text/javascript">
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
				    success:    function() {
				        $('.popup .content').load('<?php echo $vars['url'] . 'pg/enlightn/cloud'; ?>');
				    }
				};
            	$(this).ajaxSubmit(options);
                return false;
            });
        //});
    </script>

<?php

	}

?>
