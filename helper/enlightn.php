<?php
	/**
	 * Grabs groups by invitations
	 * Have to override all access until there's a way override access to getter functions.
	 *
	 * @param $user_guid
	 * @return unknown_type
	 */
	function get_invitations($user_guid, $return_guids = false) {
		$ia = elgg_set_ignore_access(TRUE);
		$invitations = elgg_get_entities_from_relationship(array('relationship' => 'invited', 'relationship_guid' => $user_guid, 'inverse_relationship' => TRUE, 'limit' => 9999));
		if ($return_guids) {
			$guids = array();
			foreach ($invitations as $invitation) {
				$guids[] = $invitation->getGUID();
			}

			return $guids;
		}

		return $invitations;
	}
	/**
	 * Grabs discussion by different way
	 * Have to override all access until there's a way override access to getter functions.
	 *
	 * @param int discussion tpye
	 * 	1 all public discussion
	 * 	2 private discussion
	 * 	3 favourite (one day...)
	 * 	7 all (like linux....)
	 * @return unknown_type
	 */
	function get_discussion ($user_guid, $discussiontype, $offset = 0) {
		$discussions = array();
		$discussion_options = array();
		$discussion_options['limit'] = "10";
		$discussion_options['offset'] = $offset;
		$discussion_options['types'] = "object";
		$discussion_options['subtypes'] = ENLIGHTN_DISCUSSION;
		switch ($discussiontype) {
			case 1:
				$discussions = elgg_get_entities($discussion_options);
				break;
			case 2:
				$discussion_options['relationship'] = ENLIGHTN_FOLLOW;
				$discussion_options['relationship_guid'] = $user_guid;
				$discussion_options['inverse_relationship'] = false;
				elgg_get_access_object()->set_ignore_access(true);
				$discussions = elgg_get_entities_from_relationship($discussion_options);
				elgg_get_access_object()->set_ignore_access(false);
				break;
			case 3:
				$discussion_options['relationship'] = ENLIGHTN_FAVORITE;
				$discussion_options['relationship_guid'] = $user_guid;
				$discussion_options['inverse_relationship'] = false;
				elgg_get_access_object()->set_ignore_access(true);
				$discussions = elgg_get_entities_from_relationship($discussion_options);
				elgg_get_access_object()->set_ignore_access(false);
				break;
			default:
				$discussions += get_discussion($user_guid,1);
				$discussions += get_discussion($user_guid,2);
				break;
		}

		return $discussions;
	}

/**
 * Return a list of this group's members.
 *
 * @param int $group_guid The ID of the container/group.
 * @param int $limit The limit
 * @param int $offset The offset
 * @param int $site_guid The site
 * @param bool $count Return the users (false) or the count of them (true)
 * @return mixed
 */
function get_discussion_members($discussion_guid, $limit = 10, $offset = 0, $site_guid = 0, $count = false) {

	// in 1.7 0 means "not set."  rewrite to make sense.
	if (!$site_guid) {
		$site_guid = ELGG_ENTITIES_ANY_VALUE;
	}

	return elgg_get_entities_from_relationship(array(
		'relationship' => ENLIGHTN_FOLLOW,
		'relationship_guid' => $discussion_guid,
		'inverse_relationship' => TRUE,
		'types' => 'user',
		'limit' => $limit,
		'offset' => $offset,
		'count' => $count,
		'site_guid' => $site_guid
	));
}

function get_activity_items ($user_guid, $limit = 10, $offset = 0) {
	$sql = "Select r.*
From river r
Left Join entity_relationships As rel On rel.guid_two In(r.object_guid, r.annotation_id) And rel.guid_one = $user_guid And rel.relationship = '" . ENLIGHTN_READED . "'
Where r.subject_guid != $user_guid
And rel.id Is Null
And
	Case When r.access_id = " . ACCESS_PRIVATE . " Then
		Exists (Select id
					From entity_relationships As rel
					Where r.object_guid = rel.guid_two
					And rel.guid_one = $user_guid
					And rel.relationship = '" . ENLIGHTN_FOLLOW . "')
		Else True
	End
Order By r.posted Desc
Limit $offset, $limit";
	return get_data($sql);
	/*global $activity_items;
	$nb_item 		= count($activity_items);
	if (count($activity_items) === 0) {
		$activity_items = array();
	}
	$activity_items = array_merge($activity_items, get_river_items(0,0,0,0,0,0,$limit - $nb_item,$offset));
	if (is_array($activity_items)) {
		foreach ($activity_items as $key=>$item) {
			if ($item->subject_guid === $user_guid) {
				unset($activity_items[$key]);
			}
			if (check_entity_relationship($user_guid,ENLIGHTN_READED,$item->object_guid)) {
				unset($activity_items[$key]);
			}
			if (check_entity_relationship($user_guid,ENLIGHTN_READED,$item->annotation_id)) {
				unset($activity_items[$key]);
			}
		}
	}
	$nb_item 		= count($activity_items);
	if ($nb_item < $limit) {
		$activity_items = get_activity_items($user_guid,$limit,$offset+$limit);
	}*/
	return $activity_items;
}

function sort_unreaded_for_nav ($discussion_unreaded) {
	$discussion_unreaded_nav = array();
	$discussion_unreaded_nav[ENLIGHTN_ACCESS_PU] = 0;
	$discussion_unreaded_nav[ENLIGHTN_ACCESS_PR] = 0;
	$discussion_unreaded_nav[ENLIGHTN_ACCESS_FA] = 0;
	$discussion_unreaded_nav[ENLIGHTN_ACCESS_IN] = 0;
	if (is_array($discussion_unreaded)) {
		foreach ($discussion_unreaded as $key => $discussion) {
			$discussion_unreaded_nav[$discussion->access_level]++;
		}
	}
	return  $discussion_unreaded_nav;
}

function echo_unreaded ($discussion_unreaded_nav,$type) {
	echo '<span id="nav_unreaded_'. $type .'" class="notif">';
	if (isset($discussion_unreaded_nav[$type]) && $discussion_unreaded_nav[$type] != 0) {
		echo $discussion_unreaded_nav[$type];
	}
	echo '</span>';
	switch ($type) {
		case ENLIGHTN_ACCESS_PU:
			$js_to_call = "'#discussion_selector_all', 1";
			break;
		case ENLIGHTN_ACCESS_PR:
			$js_to_call = "'#discussion_selector_follow',2";
			break;
		case ENLIGHTN_INVITED:
			$js_to_call = "'#discussion_selector_invited',5";
			break;
		case ENLIGHTN_ACCESS_FA:
			$js_to_call = "'#discussion_selector_favorite',3";
			break;
		default:
			break;
	}
	echo '<script>$("#nav_unreaded_' . $type . '").click(function () {$("#unreaded_only").val(1);changeMessageList(' . $js_to_call . ');});</script>';
}

function sort_entity_activities ($activities) {
	$sorted_activities = array();
	if (!is_array($activities)) {
		return false;
	}
	foreach ($activities as $activity) {
		if (in_array($activity->relationship, array('member','membership_request'))) {
			$sorted_activities[][$activity->time_created] = $activity;
		}
	}
	return $sorted_activities;
}

function get_activities_by_time ($activities,$time_created_max) {
	$sorted_activities = array();
	if (!is_array($activities)) {
		return false;
	}
	foreach ($activities as $time_created=>$activity) {
		if (key($activity) >= $time_created_max) {
			$sorted_activities[] = $activity;
			unset($activities[$time_created]);
		}
	}
	return $sorted_activities;
}

function regenerate_cache ($entity,$user_guid,$action_type) {
	global $enlightn;
	switch ($action_type) {
		case 'create':
		case 'annotate':
			$enlightn->flush_cache(array('access_level' => ENLIGHTN_ACCESS_PU),'search');
			$enlightn->flush_cache(array('user_guid' => $user_guid,'access_level' => ENLIGHTN_ACCESS_PR),'search');
			$followers = get_discussion_members($$entity->guid);
			foreach($followers as $follower) {
				$enlightn->flush_cache(array('user_guid' => $follower->guid,'access_level' => ENLIGHTN_ACCESS_PR),'search');
				$enlightn->flush_cache(array('user_guid' => $follower->guid,'access_level' => ENLIGHTN_ACCESS_IN),'search');
				$enlightn->flush_cache(array('user_guid' => $follower->guid,'access_level' => ENLIGHTN_ACCESS_FA),'search');
				$enlightn->flush_cache(array('user_guid' => $follower->guid),'unreaded');
			}
			break;
		case 'follow':
			break;
		case 'readed':
			break;
		case 'invited':
			break;
		case 'favorite':
			break;
		default:
			break;
	}
}

function get_http_link($message) {
	$regexp = "#\b(https|file|ftp|http)+(://|/)[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))+(\s|\n|$|\r|\t|</p>|<br/>|<br>|<p/>)#";
	if (preg_match_all($regexp, $message, $http_link)) {
		return $http_link[0];
	}
	return false;
}

function get_embeded_src ($message) {
	$regexp = "/id=\"(\d+)\"/";
	if (preg_match_all($regexp, $message, $embeded_src)) {
		return $embeded_src[1];
	}
	return false;
}

function get_embeded_type ($links) {
	global $CONFIG;
	if (!is_array($links)) {
		return false;
	}
	$links_type = array();
	foreach ($links as $key=>$link) {
		$link = trim($link);
		$link = strip_tags($link);
		switch ($link) {
			/**
			 * Remove enlightn internal doc
			 * And don't transform clouded docs...
			 */
			case false !== strstr($link,$CONFIG->url):
				break;
			//already in entities, we just have to link it
			case false !== strstr($link,'?fetched=1'):
				$links_type[ENLIGHTN_EMBEDED][]['link'] = str_replace('?fetched=1','',$link);
				break;
			case preg_match("/\.(bmp|jpeg|gif|png|jpg|pdf)$/i", $link) > 0:
				$links_type[ENLIGHTN_IMAGE][]['link'] = $link;
				break;
			case preg_match("/(dailymotion|vimeo|youtu)/i", $link) > 0:
				$links_type[ENLIGHTN_MEDIA][]['link'] = $link;
				break;
			default:
				$links_type[ENLIGHTN_LINK][]['link'] = $link;
				break;
		}
	}
	return $links_type;
}

function get_embeded_title ($links) {
	global $CONFIG;
	if (!is_array($links)) {
		return false;
	}
	require_once $CONFIG->pluginspath . "enlightn/model/EmbedUrl.php";
	foreach ($links as $type=>$links_by_type) {
		switch ($type) {
			case ENLIGHTN_IMAGE:
				foreach ($links_by_type as $key=>$link) {
					$title = parse_url($link['link'],PHP_URL_PATH);
					$title = basename($title);
					$links[$type][$key]['title'] = $title;
			}
				break;
			case ENLIGHTN_MEDIA:
			case ENLIGHTN_LINK:
				foreach ($links_by_type as $key=>$link) {
					$embedUrl = new Embed_url(array('url' => $link['link']));
					$embedUrl->get_page_title();
					$links[$type][$key]['title'] = utf8_encode($embedUrl->title);
				}
				break;
			case ENLIGHTN_EMBEDED:
				foreach ($links_by_type as $key=>$link) {
					$links[$type][$key]['title'] = false;
				}
				break;
			default:
				break;
		}
	}
	return $links;
}

function create_embeded_entities ($message,$entity) {
	$new_message = array();
	$new_message['message'] = $message;
	$new_message['guids'] = get_embeded_src($new_message['message']);
	if (!$entity instanceof ElggObject ) {
		return $new_message;
	}
	$links = get_http_link($message);
	if (!is_array($links)) {
		return $new_message;
	}
	$links = get_embeded_type($links);
	if (!is_array($links)) {
		return $new_message;
	}

	$links = get_embeded_title($links);
	if (!is_array($links)) {
		return false;
	}
	foreach ($links as $type=>$links_by_type) {
		foreach ($links_by_type as $key=>$link) {
			$title 				= $link["title"];
			$desc 				= $link["link"];
			$file				= elgg_get_entities_from_metadata(array('metadata_names' => 'filename', 'metadata_values' => $link["link"]));
			$access_id 			= $entity->access_id;

			if (!$file) {
				$container_guid 	= get_loggedin_userid();
				$file 				= new FilePluginFile();
				$file->subtype 		= "file";
				$file->title 		= $title;
				$file->description 	= $desc;
				$file->access_id 	= $access_id;
				$file->container_guid = $container_guid;
				$file->setFilename($link["link"]);
                if ($type === ENLIGHTN_IMAGE) {
                    $file->thumbnail = $link["link"];
                    $mime = 'link/image';
                } else {
                    $mime = 'text/html';
                }
                $file->setMimeType($mime);
				$file->originalfilename = $link["link"];
				$file->simpletype 	= $type;
				$guid 				= $file->save();
                generate_preview($file->guid);
			} else {
				$file 				= $file[0];
				$guid 				= true;
				$file->guid			= $file->entity_guid;
				if($file->access_id != $access_id) {
       				$file->access_id 	= $access_id;
                    $file->save();
                }
			}
			if ($guid) {
				$new_link = elgg_view('enlightn/new_link', array('guid'=>$file->guid,'type'=>$type,'link'=>$link["link"], 'title'=>$title));
				if($new_link && $type != ENLIGHTN_EMBEDED) {
					$new_message['message'] = str_replace($link["link"],$new_link,$new_message['message']);
					$new_link = '';
				}
				$guid = false;
				$new_message['guids'][] = $file->guid;
				//add_entity_relationship($file->guid,ENLIGHTN_EMBEDED,$entity->guid);
			}

		}
	}
	return $new_message;
}

/**
 * Adds collection submenu items
 *
 */
function enlightn_collections_submenu_items() {
        global $CONFIG;
        $user = get_loggedin_user();
        add_submenu_item(elgg_echo('friends:collections'), $CONFIG->wwwroot . "pg/enlightn/collection/" . $user->username);
        add_submenu_item(elgg_echo('friends:collections:add'), $CONFIG->wwwroot . "pg/enlightn/collection/add");
}

/**
 * Displays a user's access collections, using the friends/collections view
 *
 * @param int $owner_guid The GUID of the owning user
 * @return string A formatted rendition of the collections
 */
function enlightn_view_access_collections($owner_guid) {
	if ($collections = get_user_access_collections($owner_guid)) {
		foreach($collections as $key => $collection) {
			$collections[$key]->members = get_members_of_access_collection($collection->id, true);
			$collections[$key]->entities = get_site_members($CONFIG->site_guid,100000);
		}
	}

	return elgg_view('friends/collections',array('collections' => $collections));
}

function parse_user_to ($user_to) {
	$parsed_user_to = array();
	$user_to	= explode(",", $user_to);
	if (is_array($user_to)) {
		foreach ($user_to as $user_id) {
			if (strstr($user_id,'C_')) {
				$user_id = str_replace('C_','',$user_id);
				$collection = get_members_of_access_collection((int)$user_id,true);
				if (is_array($collection)) {
					foreach ($collection as $key => $val_id) {
						$parsed_user_to[] = $val_id;
					}
				}
			} elseif (!empty($user_id)) {
				$parsed_user_to[] = $user_id;
			}
		}
		return $parsed_user_to;
	}
	return false;
}

/**
 * Safely highlights the words in $words found in $string avoiding recursion
 *
 * @param array $words
 * @param string $string
 * @return string
 */
function enlightn_search_highlight_words($words, $string) {
	if (!$words) {
		return $string;
	}
	$i = 1;
	$replace_html = array(
		'strong' => rand(10000, 99999),
		'class' => rand(10000, 99999),
		'searchMatch' => rand(10000, 99999),
		'searchMatchColor' => rand(10000, 99999)
	);
	$words = explode(' ',$words);
	foreach ($words as $word) {
		// remove any boolean mode operators
		$word = preg_replace("/([\-\+~])([\w]+)/i", '$2', $word);

		// escape the delimiter and any other regexp special chars
		$word = preg_quote($word, '/');

		$search = "/($word)/i";

		// must replace with placeholders in case one of the search terms is
		// in the html string.
		// later, will replace the placeholders with the actual html.
		// Yeah this is hacky.  I'm tired.
		$strong = $replace_html['strong'];
		$class = $replace_html['class'];
		$searchMatch = $replace_html['searchMatch'];
		$searchMatchColor = $replace_html['searchMatchColor'];

		$replace = "<$strong $class=\"$searchMatch $searchMatchColor{$i}\">$1</$strong>";
		$string = preg_replace($search, $replace, $string);
		$i++;
	}
	foreach ($replace_html as $replace => $search) {
		$string = str_replace($search, $replace, $string);
	}

	return $string;
}

function get_last_search_value ($value) {
	if (isset($_SESSION['last_search'])) {
		$last_search = unserialize($_SESSION['last_search']);
		if (isset($last_search[$value])) {
			return $last_search[$value];
		}
	}
	return false;
}



function get_profile_settings ($user_guid = false) {
    $profile_defaults = array (
            'jobtitle' => 'text',
            'department' => 'text',
            'direction' => 'longtext',
            'location' => 'tags',
            'phone' => 'text',
            'cellphone' => 'text',
            'timezone' => 'text',
            'skype'=> 'text',
            'linkedin'=> 'text',
            'twitter'=> 'text',
            'viadeo'=> 'text',
            //'facebook'=> 'text',
            'google'=> 'text',
            'flickr'=> 'text',
            'youtube'=> 'text',
            'vimeo'=> 'text',
            'myspace'=> 'text',
            'netvibes'=> 'text');
    if (!$user_guid) {
        $user_guid = get_loggedin_userid();
    }
    foreach ($profile_defaults as $key => $fields) {
        $metadata = get_metadata_byname($user_guid, $key);
        $value = $metadata->value;
        $profile_settings[$key] = $value;
    }

    return $profile_settings;
}


function get_time_zone () {
    $timezone_identifiers = DateTimeZone::listIdentifiers();
    $timezone_list = array();
    foreach( $timezone_identifiers as $value ){
        if ( preg_match( '/^(America|Antartica|Arctic|Asia|Atlantic|Europe|Indian|Pacific)\//', $value ) ){
            $ex=explode("/",$value);//obtain continent,city
            $city=$ex[1];
            $timezone_list[$value] = $value;
        }
    }
    return $timezone_list;
}

/**
 * Depending of the relationship (followed, ressource embeded) this function will
 * disable access right control
 * @param type $guid
 *
 */
function disable_right ($guid) {
    global $enlightn;
    $user_guid = get_loggedin_userid();
    if (!$user_guid) {
        return false;
    }
    $is_followed = check_entity_relationship($user_guid, ENLIGHTN_FOLLOW,$guid);
    if ($is_followed) {
   		return elgg_set_ignore_access(true);
    }
    $is_invited = check_entity_relationship($guid, ENLIGHTN_INVITED,$user_guid);
    if ($is_invited) {
   		return elgg_set_ignore_access(true);
    }
    $is_embeded_and_followed = $enlightn->is_embeded_and_followed($guid);
    if(is_array($is_embeded_and_followed)) {
    	return elgg_set_ignore_access(true);
    }
    return false;
}



/**
 * htmLawed filtering of tags, called on a plugin hook
 *
 * @param mixed $var Variable to filter
 * @return mixed
 */
function enlightn_filter_tags($hook, $entity_type, $returnvalue, $params) {
	$return = $returnvalue;
	$var = $returnvalue;
    //echo $var;
    $htmlawed_config = '<a><img><span><p><p/><br><br/><ul><li><em><strong>';
	if (!is_array($var)) {
		$return = strip_tags($var, $htmlawed_config);
	} else {
			array_walk_recursive($var, 'strip_tags', $htmlawed_config);
			$return = $var;
	}

    $return = remove_href ($return);
	return $return;
}


function remove_href ($message) {
    $message = str_replace('</a>', '',$message);
    $message = str_replace('target="_blank"', '',$message);
    $message = preg_replace("/<a.*href=\"(.*)\".*>/i", " $1 ", $message);
    return $message;
}


function _convert($content) {
     if(!mb_check_encoding($content, 'UTF-8')
         OR !($content === mb_convert_encoding(mb_convert_encoding($content, 'UTF-32', 'UTF-8' ), 'UTF-8', 'UTF-32'))) {

         $content = mb_convert_encoding($content, 'UTF-8');

         if (mb_check_encoding($content, 'UTF-8')) {
             // log('Converted to UTF-8');
         } else {
             // log('Could not converted to UTF-8');
         }
     } else {
         $content = utf8_decode($content);
     }
     return $content;
 }

function get_file_link ($file) {
    switch ($file->mimetype) {
        case 'text/html'    :
        case 'link/image'    :
            $url = $file->originalfilename;
            break;
        default:
            $url = URL_DOWNLOAD .$file->guid;
            break;
    }
    return $url;
}


function generate_preview ($guid) {
    global $CONFIG;
    $file				= new ElggFile((int)$guid);
	switch ($file->simpletype) {
		case ENLIGHTN_MEDIA :
			require_once $CONFIG->pluginspath . "enlightn/model/Embedly.php";
			$api = new Embedly_API(array('user_agent' => 'Mozilla/5.0 (compatible; embedly/example-app; support@embed.ly)'));
			$oembed = $api->oembed(array('url' => $file->originalfilename));
			$media_uid = $file->guid;
			$file->description = elgg_view('enlightn/fetched_media',array('entity'=> $oembed[0],'media_uid' => $media_uid));
			$file->save();
            if ($oembed[0]->thumbnail_url) {
                $file->thumbnail =  $oembed[0]->thumbnail_url;
            }
			break;
		case ENLIGHTN_LINK:
			require_once $CONFIG->pluginspath . "enlightn/model/Embedly.php";
			require_once $CONFIG->pluginspath . "enlightn/model/EmbedUrl.php";
			$api = new Embedly_API(array('user_agent' => 'Mozilla/5.0 (compatible; embedly/example-app; support@embed.ly)'));
			$oembed = $api->oembed(array('url' => $file->originalfilename));
			if (!isset($oembed[0]->error_code)) {
				$media_uid = $file->entity_guid;
				$file->description = elgg_view('enlightn/fetched_media',array('entity'=> $oembed[0],'media_uid' => $media_uid));
				$file->save();
                if ($oembed[0]->thumbnail_url) {
                    $file->thumbnail = $oembed[0]->thumbnail_url;
                }
				break;
			}
			$embedUrl = new Embed_url(array('url' => $file->originalfilename));
			$embedUrl->embed();
			$file->description = elgg_view('enlightn/fetched_link',array('entity' => $embedUrl));
			$file->save();
            if ($embedUrl->sortedImage[0]) {
                $file->thumbnail = $embedUrl->sortedImage[0];
            }

			break;
		case ENLIGHTN_IMAGE:
			$file->description = elgg_view('enlightn/fetched_image',array('entity'=> $file));
			$file->save();
			break;
		case ENLIGHTN_DOCUMENT:
			$file->description = elgg_view('enlightn/fetched_document',array('link'=> $file->originalfilename, 'entity' => $file));
			//$file->save();
			break;
		default:
			break;
	}

}



function enlightn_purge_readed_queue () {
    global $enlightn;
    if(in_array(get_context(), array('home','discuss','profile'))) {
        $user_guid      = get_loggedin_userid();
        $readed_queue   = enlightn_get_relationships($user_guid , ENLIGHTN_QUEUE_READED);
        if(is_array($readed_queue)) {
            foreach ($readed_queue as $key => $relationship) {
                if(remove_entity_relationship($relationship->guid_one, $relationship->relationship, $relationship->guid_two)) {
                    add_entity_relationship($relationship->guid_one, ENLIGHTN_READED, $relationship->guid_two);
                    $enlightn->flush_cache(array('user_guid' => $user_guid),'unreaded');
                }
            }
        }
    }
}


/**
 * Return relationship(s) for an id and a relationship type
 *
 * @param int $guid_one The GUID of the entity "owning" the relationship
 * @param string $relationship The type of relationship

 */
function enlightn_get_relationships($guid_one, $relationship) {
	global $CONFIG;

	$guid_one = (int)$guid_one;
	$relationship = sanitise_string($relationship);
	if ($row = get_data("SELECT * FROM {$CONFIG->dbprefix}entity_relationships WHERE guid_one=$guid_one AND relationship='$relationship'")) {
		return $row;
	}

	return false;
}
