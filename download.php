<?php
	/**
	 * Elgg file browser download action.
	 *
	 * @todo This action is deprecated.
	 *
	 * @package ElggFile
	 */
        gatekeeper();
	// Get the guid
	$file_guid = get_input("file_guid");

	// Get the file
        disable_right($file_guid);
	$file = get_entity($file_guid);
	if ($file) {
		$mime = $file->getMimeType();
		if (!$mime) $mime = "application/octet-stream";
                add_to_river('enlightn/helper/riverlog','download', elgg_get_logged_in_user_guid(),$file_guid,$file->access_id);
		$filename = $file->originalfilename;

		// fix for IE https issue
		header("Pragma: public");
		header("Content-type: $mime");
		if (strpos($mime, "image/")!==false)
			header("Content-Disposition: inline; filename=\"$filename\"");
		else
			header("Content-Disposition: attachment; filename=\"$filename\"");

		// allow downloads of large files.
		// see http://trac.elgg.org/ticket/1932
		ob_clean();
		flush();
		readfile($file->getFilenameOnFilestore());
		exit;
	}
	else
		register_error(elgg_echo("file:downloadfailed"));
?>