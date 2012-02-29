<?php
	/**
	 * Elgg file icons.
	 * Displays an icon, depending on its mime type, for a file.
	 * Optionally you can specify a size.
	 *
	 * @package ElggFile
	 */

	global $CONFIG;

	$mime = $vars['mimetype'];

	// is this request for an image thumbnail
	if (isset($vars['thumbnail'])) {
		$thumbnail = $vars['thumbnail'];
	} else {
		$thumbnail = false;
	}

	// default size is small for thumbnails
	if (isset($vars['size'])) {
		$size = $vars['size'];
	} else {
		$size = 'small';
	}
	// Handle
    switch ($mime)
	{
		case 'image/jpg' 	:
		case 'image/jpeg' 	:
		case 'image/pjpeg' 	:
		case 'image/png' 	:
		case 'image/x-png'	:
		case 'image/gif' 	:
		case 'image/bmp' 	:
			if ($thumbnail) {
				echo "<img class=\"photo\" src=\"" . URL_DOWNLOAD . $vars['file_guid'] ."\" border=\"0\" />";
			} else {
				if (!empty($mime) && elgg_view_exists("file/icon/{$mime}")) {
					echo elgg_view("file/icon/{$mime}", $vars);
				} else if (!empty($mime) && elgg_view_exists("file/icon/" . substr($mime,0,strpos($mime,'/')) . "/default")) {
					echo elgg_view("file/icon/" . substr($mime,0,strpos($mime,'/')) . "/default", $vars);
				} else {
					echo "<img src=\"". elgg_view('file/icon/default',$vars) ."\" border=\"0\" class=\"thumb-photo\"/>";
				}
			}

		break;
        case 'text/html'    :
        case 'link/image'   :
            $is_document = preg_match("/\.(doc|xls|pdf|csv|txt|php)$/i", $thumbnail);
            if ($thumbnail && !$is_document) {
				echo "<img class=\"photo\" src=\"" . $thumbnail ."\" border=\"0\" />";
			} else {
				echo "<img class=\"photo\" src=\"". $vars['url'] ."mod/enlightn/media/graphics/link.jpg\" border=\"0\" />";
			}
        break;
		default :
             $mapping = array(
                        'application/excel' => 'excel',
                        'application/msword' => 'word',
                        'application/pdf' => 'pdf',
                        'application/powerpoint' => 'ppt',
                        'application/vnd.ms-excel' => 'excel',
                        'application/vnd.ms-powerpoint' => 'ppt',
                        'application/vnd.oasis.opendocument.text' => 'openoffice',
                        'application/x-gzip' => 'archive',
                        'application/x-rar-compressed' => 'archive',
                        'application/x-stuffit' => 'archive',
                        'application/zip' => 'archive',

                        'text/directory' => 'vcard',
                        'text/v-card' => 'vcard',

                        'application' => 'application',
                        'audio' => 'music',
                        'text' => 'text',
                        'video' => 'video',
                );

                if ($mime) {
                        $base_type = substr($mime, 0, strpos($mime, '/'));
                } else {
                        $mime = 'none';
                        $base_type = 'none';
                }

                if (isset($mapping[$mime])) {
                        $type = $mapping[$mime];
                } elseif (isset($mapping[$base_type])) {
                        $type = $mapping[$base_type];
                } else {
                        $type = 'general';
                }

                if ($size == 'large') {
                        $ext = '_lrg';
                } else {
                        $ext = '';
                }

                $url = $vars['url'] . "mod/file/graphics/icons/{$type}{$ext}.gif";
                echo "<img class=\"photo\" src=\"" . $url ."\" border=\"0\" />";
		break;
	}

?>