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
	foreach ($activities as $relation_ship) {
		if (in_array($relation_ship->relationship, array('member','membership_request'))) {
            //echo '<pre>' . $relation_ship->relationship . ':' . $relation_ship->guid_one . '/' . elgg_view_friendly_time($relation_ship->time_created);
			$sorted_activities[$relation_ship->relationship][] = $relation_ship;
		}
	}
	return $sorted_activities;
}

function get_activities_by_time ($activities,$current_date,$previous_date) {
	$sorted_activities  = array();
	if (!is_array($activities)) {
		return false;
	}
	foreach ($activities as $activity_type=>$activity) {
        foreach ($activity as $key=>$relation_ship) {
            //echo "<pre>";
            //var_dump($time_created_max < $relation_ship->time_created, $time_created_min > $relation_ship->time_created);
            //echo '<pre>' . $relation_ship->relationship . ':' . $relation_ship->guid_one . '/' . elgg_view_friendly_time($relation_ship->time_created) . ' current : ' . elgg_view_friendly_time($current_date) . ' | next : ' . elgg_view_friendly_time($previous_date);

            if (($current_date <= $relation_ship->time_created && !$previous_date)
                    || ($previous_date && $relation_ship->time_created >= $previous_date && $relation_ship->time_created >= $current_date)) {
                $sorted_activities[$activity_type][] = $relation_ship;
                unset($activities[$activity_type][$key]);
            }
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
	$regexp = REG_LINK_IN_MESSAGE;
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

function get_and_format_href (&$message) {
    return false;
    $formated_links = array();
	$regexp         = REG_HREF;

    if (preg_match_all($regexp, $message, $links)) {
        if(is_array($links[2])) {
            foreach ($links[2] as $key => $value) {
                if(isset($links[3][$key])) {
                    $formated_links[$value] = $links[3][$key];
                }
            }
        }
        $message = preg_replace($regexp, " $2 ", $message);
		return $formated_links;
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
        if (empty($links[$type][$key]['title'])) {
            $links[$type][$key]['title'] = $link['link'];
        }
	}
	return $links;
}

function create_embeded_entities ($message,$entity) {
	if (!$entity instanceof ElggObject ) {
		return $new_message;
	}
	$formated_links         = get_and_format_href($message);
	$new_message            = array();
	$new_message['message'] = $message;
	$new_message['guids']   = get_embeded_src($new_message['message']);
	$links                  = get_http_link($message);
	$links                  = get_embeded_type($links);
    if (!is_array($links)) {
        return $new_message;
    }
	$links                  = get_embeded_title($links);
    $access_id              = $entity->access_id;
	foreach ($links as $type=>$links_by_type) {
		foreach ($links_by_type as $key=>$link) {
			$title 			= $link["title"];
			$desc 			= $link["link"];
			$file			= elgg_get_entities_from_metadata(array('metadata_names' => 'filename', 'metadata_values' => $link["link"]));
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
				$new_link = elgg_view('enlightn/new_link', array('guid'=>$file->guid,'type'=>$type,'link'=>$link["link"], 'title'=>isset($formated_links[$link['link']])?$formated_links[$link['link']]:$title));
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
        add_submenu_item(elgg_echo('friends:collections'), $CONFIG->wwwroot . "enlightn/collection/" . $user->username);
        add_submenu_item(elgg_echo('friends:collections:add'), $CONFIG->wwwroot . "enlightn/collection/add");
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
            'emaillogin' => 'text',
            'emailpasswd' => 'text',
            'emailserver' => 'text',
            'emailport' => 'text',
            'emailservtype' => 'text',
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

	return $return;
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
            try {
                require_once $CONFIG->pluginspath . "enlightn/model/Embedly.php";
                $api = new Embedly_API(array('user_agent' => 'Mozilla/5.0 (compatible; embedly/example-app; support@embed.ly)'));
                $oembed = $api->oembed(array('url' => $file->originalfilename));
                $media_uid = $file->guid;
                $file->description = elgg_view('enlightn/fetched_media',array('entity'=> $oembed[0],'media_uid' => $media_uid));
                if ($oembed[0]->thumbnail_url) {
                    $file->thumbnail =  $oembed[0]->thumbnail_url;
                }
                $file->save();
            } catch (Exception $e) {

            }
			break;
		case ENLIGHTN_LINK:
			require_once $CONFIG->pluginspath . "enlightn/model/Embedly.php";
			require_once $CONFIG->pluginspath . "enlightn/model/EmbedUrl.php";
            try {
                $api = new Embedly_API(array('user_agent' => 'Mozilla/5.0 (compatible; embedly/example-app; support@embed.ly)'));
                $oembed = $api->oembed(array('url' => $file->originalfilename));
                if (!isset($oembed[0]->error_code)) {
                    $media_uid = $file->entity_guid;
                    $file->description = elgg_view('enlightn/fetched_media',array('entity'=> $oembed[0],'media_uid' => $media_uid));
                    if ($oembed[0]->thumbnail_url) {
                        $file->thumbnail = $oembed[0]->thumbnail_url;
                    }
                    $file->save();
                    break;
                }
            } catch (Exception $e) {

            }
			$embedUrl = new Embed_url(array('url' => $file->originalfilename));
			$embedUrl->embed();
			$file->description = elgg_view('enlightn/fetched_link',array('entity' => $embedUrl));
            if ($embedUrl->sortedImage[0]) {
                $file->thumbnail = $embedUrl->sortedImage[0];
            }
			$file->save();
			break;
		case ENLIGHTN_IMAGE:
			$file->description = elgg_view('enlightn/fetched_image',array('entity'=> $file));
			$file->save();
			break;
		case ENLIGHTN_DOCUMENT:
			$file->description = elgg_view('enlightn/fetched_document',array('link'=> $file->originalfilename, 'entity' => $file));
			$file->save();
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

function count_unreaded_messages ($guid) {
    $user_guid = get_loggedin_userid();
    $query = "Select Count(a.id) as messages_unreaded
                From annotations a
                Where Not Exists(Select rel.id
                            From entity_relationships As rel
                            Where a.id = rel.guid_two
                            And rel.guid_one = $user_guid
                            And rel.relationship = '". ENLIGHTN_READED . "')
                And a.entity_guid = " . $guid;
    return get_data($query);
}


function update_entity_access ($guid ,$access_id) {
    $entity = get_entity($guid);
    if ($access_id != $entity->access_id) {
        update_entity($guid, $entity->owner_guid, $access_id);
    }
}

function create_enlightn_discussion ($user_guid, $access_id,$message, $title,$tags, $userto, $guid = false) {
    global $enlightn;

    $return        = array();
    $return['success'] = false;

    $tagarray = string_to_tag_array($tags);
    if (!$guid) {
        // Initialise a new ElggObject
        $enlightndiscussion = new ElggObject();
        // Tell the system it's a simple post, url link, media,etc.
        $enlightndiscussion->subtype = ENLIGHTN_DISCUSSION;
        // Set its owner to the current user
        $enlightndiscussion->owner_guid = $user_guid;
        // For now, set its access to public (we'll add an access dropdown shortly)
        $enlightndiscussion->access_id = $access_id;
        // Set its title and description appropriately
        $enlightndiscussion->title = $title;
        // Before we can set metadata, we need to save the topic
        if (!$enlightndiscussion->save()) {
            $return['message'] = elgg_echo("grouptopic:error");
            //forward("groups/forum/{$group_guid}/");
        }
    } else {
        $enlightndiscussion = get_entity($guid);
    }
    // Now let's add tags. We can pass an array directly to the object property! Easy.
    if (is_array($tagarray)) {
        $enlightndiscussion->tags = $tagarray;
    }
    $return['guid'] = $enlightndiscussion->guid;
    $message 	= create_embeded_entities($message,$enlightndiscussion);
	$post		= $message['message'];

	// now add the topic message as an annotation
	$annotationid = $enlightndiscussion->annotate(ENLIGHTN_DISCUSSION,$post,$enlightndiscussion->access_id, $user_guid);
    $return['success'] = $annotationid;
    $enlightndiscussion->save();//trigger entities save, in order to update the update_time;
	//link attachement
	if (is_array($message['guids'])) {
		foreach ($message['guids'] as $embeded_guids) {
			add_entity_relationship($embeded_guids,ENLIGHTN_EMBEDED,$annotationid);
            update_entity_access ($embeded_guids,$enlightndiscussion->access_id); //update access_id
		}
	}
	// add to river
	add_to_river('enlightn/river/create','create',$user_guid,$enlightndiscussion->guid,$enlightndiscussion->access_id, 0, $annotationid);
	// Success message
	// Remove cache for public access
	$enlightn->flush_cache(array('access_level' => ENLIGHTN_ACCESS_PU),'search');
	$enlightn->flush_cache(array('user_guid' => $user_guid,'access_level' => ENLIGHTN_ACCESS_PR),'search');
	// Add users membership to the discussion
	//Current user
	add_entity_relationship($user_guid, ENLIGHTN_FOLLOW, $enlightndiscussion->guid);
    //Remove invitation
    remove_entity_relationship($enlightndiscussion->guid, ENLIGHTN_INVITED, $user_guid);
	//Invited user
	$userto = parse_user_to($userto);
	if (is_array($userto)) {
        add_folowers ($userto,$enlightndiscussion);
	}
    add_entity_relationship($user_guid, ENLIGHTN_READED, $annotationid);
    $return['message'] = elgg_echo('enlightn:discussion_sucessfully_created');
    return $return;
}

function add_folowers ($userto,$enlightndiscussion) {
    global $enlightn,$CONFIG;
    $user = get_loggedin_user();
    foreach ($userto as $key => $usertoid) {
        // Remove cache for private access, need to be deployed on user side
        if ($enlightndiscussion->access_id == ACCESS_PRIVATE) {
            $enlightn->flush_cache(array('user_guid' => $usertoid),'unreaded');
            $enlightn->flush_cache(array('user_guid' => $usertoid,'access_level' => ENLIGHTN_ACCESS_PR),'search');
            $enlightn->flush_cache(array('user_guid' => $usertoid,'access_level' => ENLIGHTN_ACCESS_IN),'search');
        }
        $usertoid = get_entity((int)$usertoid);
        if ($usertoid->guid && $usertoid->guid != $enlightndiscussion->owner_guid) {
            /*if (!$usertoid->isFriend()) {
                add_entity_relationship($_SESSION['user']->guid, 'friend', $usertoid->guid);
            }*/
            if(add_entity_relationship($enlightndiscussion->guid, ENLIGHTN_INVITED, $usertoid->guid)) {
                // Add membership requested
                add_entity_relationship($usertoid->guid, 'membership_request', $enlightndiscussion->guid);
                // Send email
                $url = "{$CONFIG->url}enlightn/discuss/" . $enlightndiscussion->guid;
                if (!in_array($usertoid->{"notification:method:".NOTIFICATION_EMAIL_INVITE}, array(0))) {
                    notify_user($usertoid->getGUID(), $enlightndiscussion->owner_guid,
                            sprintf(elgg_echo('enlightn:invite:subject',$usertoid->language), $enlightndiscussion->title),
                            sprintf(elgg_echo('enlightn:invite:body',$usertoid->language), $usertoid->name, $user->name, $enlightndiscussion->title, $url),
                            NULL);
                }

            }
        }
    }
}


function create_external_user($email,$username,$name) {
    $password       = generate_random_cleartext_password();
	// Belts and braces
	// @todo Tidy into main unicode
	$blacklist = '\'/\\"*& ?#%^(){}[]~?<>;|¬`@-+=';
	for ($n=0; $n < strlen($blacklist); $n++) {
		$username = str_replace($blacklist[$n], '', $username);
	}
    $guid           = register_user($username, $password, $name, $email);
    create_metadata($guid, ENLIGHTN_EXTERNAL_USER, true, '', 0, ACCESS_PUBLIC);
    return $guid;
}

function create_attachement ($annotation_id, $filename, $content) {
    $prefix             = "file/";

    $file               = new FilePluginFile();
	$file->subtype      = "file";
    $file->title        = $filename;
	$file->access_id    = ENLIGHTN_ACCESS_PRIVATE;
    $filestorename      = elgg_strtolower(time().$filename);
    $file->setFilename($prefix.$filestorename);
    $file->setMimeType($content['mime_type']);
    $file->originalfilename = $filename;
    $file->description  = $file->originalfilename;
    $file->simpletype   = get_general_file_type($content['mime_type']);
    if (!in_array($file->simpletype,(array(ENLIGHTN_LINK,ENLIGHTN_MEDIA,ENLIGHTN_IMAGE,ENLIGHTN_DOCUMENT)))) {
        $file->simpletype = ENLIGHTN_DOCUMENT;
    }
    // Open the file to guarantee the directory exists
    $file->open("write");
    $file->close();
    // move using built in function to allow large files to be uploaded
    file_put_contents($file->getFilenameOnFilestore(), $content['content']);
    $guid = $file->save();
    // if image, we need to create thumbnails (this should be moved into a function)
    if ($guid && $file->simpletype == "image") {
        $thumbnail = get_resized_image_from_existing_file($file->getFilenameOnFilestore(),60,60, true);
        if ($thumbnail) {
            $thumb = new ElggFile();
            $thumb->setMimeType($content['mime_type']);

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

    generate_preview($file->guid);
    add_entity_relationship($file->guid,ENLIGHTN_EMBEDED,$annotation_id);
    return $guid;
}

	function html_email_handler_notification_handler(ElggEntity $from, ElggUser $to, $subject, $message, array $params = NULL){
		global $CONFIG;

		if (empty($from)) {
			throw new NotificationException(sprintf(elgg_echo('NotificationException:MissingParameter'), 'from'));
		}

		if (empty($to)) {
			throw new NotificationException(sprintf(elgg_echo('NotificationException:MissingParameter'), 'to'));
		}

		if(empty($message)){
			throw new NotificationException(sprintf(elgg_echo('NotificationException:MissingParameter'), 'message'));
		}

		if (empty($to->email)) {
			throw new NotificationException(sprintf(elgg_echo('NotificationException:NoEmailAddress'), $to->guid));
		}

		// To
		if(!empty($to->name)){
			$to = $to->name . " <" . $to->email . ">";
		} else {
			$to = $to->email;
		}

		// From
		// If there's an email address, use it - but only if its not from a user.
		if (!($from instanceof ElggUser) && !empty($from->email)) {
			if(!empty($from->name)){
				$from = $from->name . " <" . $from->email . ">";
			} else {
				$from = $from->email;
			}
		} elseif ($CONFIG->site && !empty($CONFIG->site->email)) {
			// Use email address of current site if we cannot use sender's email
			if(!empty($CONFIG->site->name)){
				$from = $CONFIG->site->name . " <" . $CONFIG->site->email . ">";
			} else {
				$from = $CONFIG->site->email;
			}
		} else {
			// If all else fails, use the domain of the site.
			if(!empty($CONFIG->site->name)){
				$from = $CONFIG->site->name . " <noreply@" . get_site_domain($CONFIG->site_guid) . ">";
			} else {
				$from = "noreply@" . get_site_domain($CONFIG->site_guid);
			}
		}

		// generate HTML mail body
		$html_message = elgg_view("html_email_handler/notification/body", array("title" => $subject, "message" => parse_urls($message)));
		if(defined("XML_DOCUMENT_NODE")){
			if($transform = html_email_handler_css_inliner($html_message)){
				$html_message = $transform;
			}
		}

		// set options for sending
		$options = array(
			"to" => $to,
			"from" => $from,
			"subject" => $subject,
			"html_message" => $html_message,
			"plaintext_message" => $message
		);

		return html_email_handler_send_email($options);
	}

	/**
	 *
	 * This function sends out a full HTML mail. It can handle several options
	 *
	 * This function requires the options 'to' and ('html_message' or 'plaintext_message')
	 *
	 * @param $options Array in the format:
	 * 		to => STR|ARR of recipients in RFC-2822 format (http://www.faqs.org/rfcs/rfc2822.html)
	 * 		from => STR of senden in RFC-2822 format (http://www.faqs.org/rfcs/rfc2822.html)
	 * 		subject => STR with the subject of the message
	 * 		html_message => STR with the HTML version of the message
	 * 		plaintext_message STR with the plaintext version of the message
	 * 		cc => NULL|STR|ARR of CC recipients in RFC-2822 format (http://www.faqs.org/rfcs/rfc2822.html)
	 * 		bcc => NULL|STR|ARR of BCC recipients in RFC-2822 format (http://www.faqs.org/rfcs/rfc2822.html)
	 *
	 * @return BOOL true|false
	 */
	function html_email_handler_send_email(array $options = null){
		global $CONFIG;
		$result = false;

		// make site email
		if(!empty($CONFIG->site->email)){
			if(!empty($CONFIG->site->name)){
				$site_from = $CONFIG->site->name . " <" . $CONFIG->site->email . ">";
			} else {
				$site_from = $CONFIG->site->email;
			}
		} else {
			// no site email, so make one up
			if(!empty($CONFIG->site->name)){
				$site_from = $CONFIG->site->name . " <noreply@" . get_site_domain($CONFIG->site_guid) . ">";
			} else {
				$site_from = "noreply@" . get_site_domain($CONFIG->site_guid);
			}
		}

		// set default options
		$default_options = array(
			"to" => array(),
			"from" => $site_from,
			"subject" => "",
			"html_message" => "",
			"plaintext_message" => "",
			"cc" => array(),
			"bcc" => array()
		);

		// merge options
		$options = array_merge($default_options, $options);

		// check options
		if(!empty($options["to"]) && !is_array($options["to"])){
			$options["to"] = array($options["to"]);
		}
		if(!empty($options["cc"]) && !is_array($options["cc"])){
			$options["cc"] = array($options["cc"]);
		}
		if(!empty($options["bcc"]) && !is_array($options["bcc"])){
			$options["bcc"] = array($options["bcc"]);
		}

		// can we send a message
		if(!empty($options["to"]) && (!empty($options["html_message"]) || !empty($options["plaintext_message"]))){
			// start preparing
			$boundary = uniqid($CONFIG->site->name);

			// start building headers
			if(!empty($options["from"])){
				$headers .= "From: " . $options["from"] . PHP_EOL;
			} else {
				$headers .= "From: " . $site_from . PHP_EOL;
			}
			$headers .= "X-Mailer: PHP/" . phpversion() . PHP_EOL;
			$headers .= "MIME-Version: 1.0" . PHP_EOL;
			$headers .= "Content-Type: multipart/alternative; boundary=\"" . $boundary . "\"" . PHP_EOL . PHP_EOL;

			// check CC mail
			if(!empty($options["cc"])){
				$headers .= "Cc: " . implode(", ", $options["cc"]) . PHP_EOL;
			}

			// check BCC mail
			if(!empty($options["bcc"])){
				$headers .= "Bcc: " . implode(", ", $options["bcc"]) . PHP_EOL;
			}

			// TEXT part of message
			if(!empty($options["plaintext_message"])){
				$message .= "--" . $boundary . PHP_EOL;
				$message .= "Content-Type: text/plain; charset=\"utf-8\"" . PHP_EOL;
				$message .= "Content-Transfer-Encoding: base64" . PHP_EOL . PHP_EOL;

				$message .= chunk_split(base64_encode($options["plaintext_message"])) . PHP_EOL . PHP_EOL;
			}

			// HTML part of message
			if(!empty($options["html_message"])){
				$message .= "--" . $boundary . PHP_EOL;
				$message .= "Content-Type: text/html; charset=\"utf-8\"" . PHP_EOL;
				$message .= "Content-Transfer-Encoding: base64" . PHP_EOL . PHP_EOL;

				$message .= chunk_split(base64_encode($options["html_message"])) . PHP_EOL;
			}

			// Final boundry
			$message .= "--" . $boundary . "--" . PHP_EOL;

			// convert to to correct format
			$to = implode(", ", $options["to"]);
			$result = mail($to, $options["subject"], $message, $headers);
		}

		return $result;
	}

	/**
	 * This function converts CSS to inline style, the CSS needs to be found in a <style> element
	 *
	 * @param $html_text => STR with the html text to be converted
	 * @return false | converted html text
	 */
	function html_email_handler_css_inliner($html_text){
        global $CONFIG;
		$result = false;
        // include CSS coverter if needed
        if(!class_exists("Emogrifier")){
            require_once $CONFIG->pluginspath . "enlightn/helper/emogrifier/emogrifier.php";
        }
		if(!empty($html_text) && defined("XML_DOCUMENT_NODE")){
			$css = "";

			$dom = new DOMDocument();
			$dom->loadHTML($html_text);

			$styles = $dom->getElementsByTagName("style");

			if(!empty($styles)){
				$style_count = $styles->length;

				for($i = 0; $i < $style_count; $i++){
					$css .= $styles->item($i)->nodeValue;
				}
			}

			$emo = new Emogrifier($html_text, $css);
			$result = $emo->emogrify();
		}

		return $result;
	}

function generate_cloned_message ($cloned_ids) {
    elgg_set_ignore_access(true);
    $cloned_content = '';
    if (strstr($cloned_ids, ',')) {
        $cloned_ids = explode(',', $cloned_ids);
        if (is_array($cloned_ids)) {
            foreach ($cloned_ids as $key => $annotation_id) {
                $annotation = elgg_get_annotation_from_id($annotation_id);
                $cloned_content .= elgg_view("enlightn/topicpost",array('entity' => $annotation
		    											, 'query' => false
		    											, 'flag_readed' => false));
            }
        }
        $cloned_content = elgg_view("enlightn/discussion/clone_messages",array('cloned_content' => $cloned_content));
    }
    return $cloned_content;
}

function enlightn_hook_forward_system($hook, $type, $returnvalue, $params) {
    $message = system_messages();
    if (isset($message['success']) && array_pop($message['success']) == elgg_echo('loginok')) {
        return elgg_get_site_url() . '/WHATEVERURL'; // replace this
    }

    return $returnvalue;
}

function tag_text ($text) {
    require_once 'Text/LanguageDetect.php';
    require_once elgg_get_plugins_path() . 'enlightn/model/treetagger.class.php';
    $tmp_text_path  = '/tmp/' . md5($text);
    file_put_contents($tmp_text_path, $text);
    $langage        = new Text_LanguageDetect();
    $langage        = $langage->detect($text, 1);
    $langage        = key($langage);
    $tagger         = new treeTagger($langage,$tmp_text_path);
    $tags           = $tagger->tag_text();
    unlink($tmp_text_path);

    return $tags;
}