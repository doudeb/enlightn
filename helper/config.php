<?php
	global $CONFIG,$enlightn,$site_guid,$sn_linkers,$profile_defaults,$profile_settings;

    //$CONFIG->site_guid = $site_guid;
	define('ENLIGHTN_DISCUSSION', 'enlightndiscussion');
	define('ENLIGHTN_LINK', 'enlightnlink');
	define('ENLIGHTN_MEDIA', 'enlightnmedia');
	define('ENLIGHTN_DOCUMENT', 'document');
	define('ENLIGHTN_IMAGE', 'image');
	define('ENLIGHTN_FOLLOW', 'member');
	define('ENLIGHTN_READED', 'readed');
	define('ENLIGHTN_EMBEDED', 'embeded');
	define('ENLIGHTN_INVITED', 'invited');
	define('ENLIGHTN_FAVORITE', 'favorite');
	define('ENLIGHTN_ACCESS_PU', '1');//Public access
	define('ENLIGHTN_ACCESS_PR', '2');//Private
	define('ENLIGHTN_ACCESS_FA', '3');//Favorite
	define('ENLIGHTN_ACCESS_AL', '4');//All ( Pu + Pr
	define('ENLIGHTN_ACCESS_IN', '5');//Invited aka requests
	define('ENLIGHTN_ACCESS_UN', '6');//Unreaded
	define('ENLIGHTN_ACCESS_PUBLIC', ACCESS_LOGGED_IN);
	define('ENLIGHTN_ACCESS_PRIVATE', ACCESS_PRIVATE);
	define('LIMIT_ANNOTATION', 50);
	define('NOTIFICATION_EMAIL_INVITE', 'email_invite');
	define('NOTIFICATION_EMAIL_MESSAGE_FOLLOWED', 'email_message_followed');
	define('URL_DOWNLOAD', $CONFIG->url . 'pg/enlightn/download/');

    $sn_linkers = array('skype','linkedin','twitter','viadeo','facebook','google','flickr','youtube','vimeo','myspace','netvibes');