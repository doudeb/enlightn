<?php
	/**
	 * Elgg file browser uploader/edit action
	 *
	 * @package ElggFile
	 */
	global $CONFIG;

	gatekeeper();

	// Get variables
	$title = get_input("title");
	$desc = get_input("description");
	$access_id = (int) get_input("access_id",ENLIGHTN_ACCESS_PRIVATE);
	$container_guid = (int) get_input('container_guid', 0);
	$filter_id = (int) get_input('file_filter_id', 0);
	if ($container_guid == 0) {
		$container_guid = elgg_get_logged_in_user_guid();
	}
	$guid = (int) get_input('file_guid');
	$tags = get_input("filetags");

	// check whether this is a new file or an edit
	$new_file = true;
	if ($guid > 0) {
		$new_file = false;
	}

	if ($new_file) {
		// must have a file if a new file upload
		if (empty($_FILES['upload']['name'])) {
			// cache information in session
			$_SESSION['uploadtitle'] = $title;
			$_SESSION['uploaddesc'] = $desc;
			$_SESSION['uploadtags'] = $tags;
			$_SESSION['uploadaccessid'] = $access_id;

			register_error(elgg_echo('file:nofile'));
			forward($_SERVER['HTTP_REFERER']);
		}

		$file = new FilePluginFile();
		$file->subtype = "file";

		// if no title on new upload, grab filename
		if (empty($title)) {
			$title = $_FILES['upload']['name'];
		}

	} else {
		// load original file object
		$file = get_entity($guid);
		if (!$file) {
			register_error(elgg_echo('file:cannotload'));
			forward($_SERVER['HTTP_REFERER']);
		}

		// user must be able to edit file
		if (!$file->canEdit()) {
			register_error(elgg_echo('file:noaccess'));
			forward($_SERVER['HTTP_REFERER']);
		}
	}

	$file->title = $title;
	$file->access_id = $access_id;
	$file->container_guid = $container_guid;

	$tags = explode(",", $tags);
	$file->tags = $tags;

	// we have a file upload, so process it
	if (isset($_FILES['upload']['name']) && !empty($_FILES['upload']['name'])) {

		$prefix = "file/";

		// if previous file, delete it
		if ($new_file == false) {
			$filename = $file->getFilenameOnFilestore();
			if (file_exists($filename)) {
				unlink($filename);
			}

			// use same filename on the disk - ensures thumbnails are overwritten
			$filestorename = $file->getFilename();
			$filestorename = elgg_substr($filestorename, elgg_strlen($prefix));
		} else {
			$filestorename = elgg_strtolower(time().$_FILES['upload']['name']);
		}
		$file->setFilename($prefix.$filestorename);
		$file->setMimeType($_FILES['upload']['type']);
		$file->originalfilename = $_FILES['upload']['name'];
        $file->description = $file->originalfilename;
		$file->simpletype = file_get_simple_type($_FILES['upload']['type']);
		if (!in_array($file->simpletype,(array(ENLIGHTN_LINK,ENLIGHTN_MEDIA,ENLIGHTN_IMAGE,ENLIGHTN_DOCUMENT)))) {
			$file->simpletype = ENLIGHTN_DOCUMENT;
		}
		// Open the file to guarantee the directory exists
		$file->open("write");
		$file->close();
		// move using built in function to allow large files to be uploaded
		move_uploaded_file($_FILES['upload']['tmp_name'], $file->getFilenameOnFilestore());

		$guid = $file->save();

		// if image, we need to create thumbnails (this should be moved into a function)
		if ($guid && $file->simpletype == "image") {
			$thumbnail = get_resized_image_from_existing_file($file->getFilenameOnFilestore(),60,60, true);
			if ($thumbnail) {
				$thumb = new ElggFile();
				$thumb->setMimeType($_FILES['upload']['type']);

				$thumb->setFilename($prefix."thumb".$filestorename);
				$thumb->open("write");
				$thumb->write($thumbnail);
				$thumb->close();

				$file->thumbnail = $prefix."thumb".$filestorename;
				unset($thumbnail);
			}

			$thumbsmall = get_resized_image_from_existing_file($file->getFilenameOnFilestore(),153,153, true);
			if ($thumbsmall) {
				$thumb->setFilename($prefix."smallthumb".$filestorename);
				$thumb->open("write");
				$thumb->write($thumbsmall);
				$thumb->close();
				$file->smallthumb = $prefix."smallthumb".$filestorename;
				unset($thumbsmall);
			}

			$thumblarge = get_resized_image_from_existing_file($file->getFilenameOnFilestore(),600,600, false);
			if ($thumblarge) {
				$thumb->setFilename($prefix."largethumb".$filestorename);
				$thumb->open("write");
				$thumb->write($thumblarge);
				$thumb->close();
				$file->largethumb = $prefix."largethumb".$filestorename;
				unset($thumblarge);
			}
		}
	} else {
		// not saving a file but still need to save the entity to push attributes to database
		$file->save();
	}

	// make sure session cache is cleared
	unset($_SESSION['uploadtitle']);
	unset($_SESSION['uploaddesc']);
	unset($_SESSION['uploadtags']);
	unset($_SESSION['uploadaccessid']);

	// handle results differently for new files and file updates
	if ($new_file) {
		if ($guid) {
            $content        = doc_to_txt($file->getFilenameOnFilestore(),$file->mimetype);
            if ($content) {
                $file->annotate(ENLIGHTN_DISCUSSION, $content, $file->access_id);
                $file->save();
            }
            generate_preview($file->guid);
            add_to_river('river/object/file/create', 'create', elgg_get_logged_in_user_guid(), $file->guid);
            if($filter_id > 0) {
                add_entity_relationship($file->guid,ENLIGHTN_FILTER_ATTACHED,$filter_id);
            }
            echo elgg_view('enlightn/new_link', array('type' => $file->simpletype, 'link' => $file->filename . '?fetched=1', 'guid' => $file->guid, 'title'=>$file->title));
		} else {
          		// failed to save file object - nothing we can do about this
			register_error(elgg_echo("file:uploadfailed"));
		}

		$container_user = get_entity($container_guid);

	} else {
		if ($guid) {
            echo elgg_view('enlightn/new_link', array('type' => $file->simpletype, 'link' => $file->filename . '?fetched=1', 'guid' => $file->guid, 'title'=>$file->title));
		} else {
			register_error(elgg_echo("file:uploadfailed"));
		}
	}
	exit();