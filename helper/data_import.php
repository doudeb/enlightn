<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

global $CONFIG;
elgg_set_ignore_access(true);

define('DATA_PATH', '/home/doudeb/Documents/Chappuis/mig/');
define('PRIVATE_PATERN','/\/([^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4})/');
define('PRIVATE_PATERN_KEY', 1);
define('GET_ID_CALL','get_user_by_email');
define('DEBUG_ON', false);
define('DEFAULT_OWNER_ID', 3780);
define('SITE_GUID', 3742);

$_SERVER["SERVER_PORT"] = 443;
$_SERVER["HTTP_HOST"] = '';


$tree = glob_recursive(DATA_PATH . '*');
$get_id_call = GET_ID_CALL;
$prefix = "file/";
$CONFIG->site_guid = SITE_GUID;

$total_file = 0;
$total_imported = 0;
//detect mime type

foreach ($tree as $key => $filename) {
    //we don't care about directory
    if (!is_dir($filename)) {
        $total_file++;
        echo 'processing ' . $filename . '....';
        $access_id = ENLIGHTN_ACCESS_PUBLIC;
        $owner_guid = DEFAULT_OWNER_ID;
        $tags = array();
        //find each tags
        $tags_pattern = str_replace(DATA_PATH, '', $filename);
        $tags = explode('/', $tags_pattern);
        //prepare mandatory vars
        $title = clean_ms($tags[count($tags)-1]);
        $desc = false;
        $filestorename = elgg_strtolower(time().$title);
        //hack for pptx.... cause it's consider as a zip file....
        if (strstr($filename, '.pptx')) {
            $mime_type = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
        //same for ppt.....
        } elseif (strstr($filename, '.ppt')) {
            $mime_type = 'application/vnd.ms-powerpoint';
        } else {
            $mime_type = mime_content_type($filename);
        }
        //clean tag list
        unset($tags[0]);
        unset($tags[count($tags)]);
        //private or public
        if (preg_match(PRIVATE_PATERN, $filename, $private_id)) {
            $user_ent = $get_id_call($private_id[PRIVATE_PATERN_KEY]);
            if ($user_ent[0] instanceof ElggUser) {
                $owner_guid = $user_ent[0]->guid;
                $access_id = ENLIGHTN_ACCESS_PRIVATE;
            }
            //remove id from tags
            $tag_owner_key = array_search($private_id[PRIVATE_PATERN_KEY], $tags);
            unset($tags[$tag_owner_key]);
        }
        //process the file
        $file = new FilePluginFile();
        $file->subtype = "file";
        $file->title = $title;
        $file->access_id = $access_id;
        $file->container_guid = $owner_guid;
        $file->owner_guid = $owner_guid;
        $file->tags = $tags;
        $file->setFilename($prefix.$filestorename);

        $file->setMimeType($mime_type);
        $file->originalfilename = $title;
        $file->description = $file->originalfilename;
        $file->simpletype = file_get_simple_type($mime_type);
        if (!in_array($file->simpletype,(array(ENLIGHTN_LINK,ENLIGHTN_MEDIA,ENLIGHTN_IMAGE,ENLIGHTN_DOCUMENT)))) {
                $file->simpletype = ENLIGHTN_DOCUMENT;
        }
        //create tag tree
        $tag_tree = array();
        foreach ($tags as $key=>$folder) {
            //see if exist
            $options  = array('types'=>'object','subtypes'=>ENLIGHTN_FILTER,'limit'=>1);
            $options['joins']   = array("Inner join objects_entity obj_ent On e.guid = obj_ent.guid");
            $options['wheres']   = array("obj_ent.title = '" . sanitise_string($folder) . "'");
            $folder_ent = elgg_get_entities($options);
            if(!is_int($folder_ent[0]->guid)) {
                $saved_search                       = new ElggObject();
                $saved_search->subtype              = ENLIGHTN_FILTER;
                $saved_search->owner_guid           = $owner_guid;
                $saved_search->access_id            = $access_id;
                $saved_search->title                = $folder;
                $saved_search->tags                 = $saved_search->title;
                $saved_search->site_guid            = $CONFIG->site_guid;
                $saved_search->container_guid       = isset($tag_tree[$key-1]->guid)?$tag_tree[$key-1]->guid:$CONFIG->site_guid;
                if (!DEBUG_ON) {
                    $saved_search->save();
                    $saved_search->setMetaData(ENLIGHTN_FILTER_CRITERIA, serialize(array('subtype'=>'false')));
                    add_entity_relationship($owner_guid, ENLIGHTN_FOLLOW, $saved_search->guid);//user follow the folder

                }
                $folder_ent[0]                  = $saved_search;
            }
            $tag_tree[$key] = $folder_ent[0];
        }
        if (!DEBUG_ON) {
            // Open the file to guarantee the directory exists
            $file->open("write");
            $file->close();
            // move using built in function to allow large files to be uploaded
            copy($filename, $file->getFilenameOnFilestore());
            $guid = $file->save();
            if ($guid && $file->simpletype == "image") {
                $thumbnail = get_resized_image_from_existing_file($file->getFilenameOnFilestore(),60,60, true);
                if ($thumbnail) {
                        $thumb = new ElggFile();
                        $thumb->setMimeType($mime_type);
                        $thumb->setFilename($prefix."thumb".$filestorename);
                        $thumb->container_guid = $owner_guid;
                        $thumb->owner_guid = $owner_guid;
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
            $file->save();
            if ($guid) {
                //set folder relationship
                $filtered = end($tag_tree);
                if(isset($filtered->guid)) {
                    add_entity_relationship($file->guid,ENLIGHTN_FILTER_ATTACHED,$filtered->guid);//attach file to filter
                }
                $total_imported++;
                $content        = doc_to_txt($file->getFilenameOnFilestore(),$file->mimetype);
                if ($content) {
                    $file->annotate(ENLIGHTN_DISCUSSION, $content, $file->access_id);
                    $new_tags = tag_text($content);
                    if (is_array($new_tags)) {
                        $tags = array_merge($tags,  array_keys($new_tags));
                        $tags = array_unique($tags);
                        $file->tags = $tags;
                        $file->save();
                    }

                }
                generate_preview($file->guid);
                echo " OK \n";
            } else {
                echo " KO \n";
            }
            $file->save();
        } else {
            var_dump($tags);
        }

    }
}
echo 'total_file / imported : ' . $total_file . ' / ' . $total_imported . "\n";
