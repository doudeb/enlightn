<?php
	global $CONFIG,$enlightn,$site_guid,$sn_linkers,$profile_defaults,$profile_settings;

	define('ENLIGHTN_DISCUSSION', 'enlightndiscussion');//subtype
	define('ENLIGHTN_FILTER', 'enlightnfilter');//subtype
	define('ENLIGHTN_FILTER_CRITERIA', 'enlightnfiltercriteria');//metadata for filter criterias
	define('ENLIGHTN_LINK', 'enlightnlink');
	define('ENLIGHTN_MEDIA', 'enlightnmedia');
	define('ENLIGHTN_DOCUMENT', 'document');
	define('ENLIGHTN_IMAGE', 'image');
	define('ENLIGHTN_FOLLOW', 'member');
	define('ENLIGHTN_READED', 'readed');
	define('ENLIGHTN_EMBEDED', 'embeded');
	define('ENLIGHTN_INVITED', 'invited');
	define('ENLIGHTN_FAVORITE', 'favorite');
	define('ENLIGHTN_FILTER_ATTACHED', 'filtered');
	define('ENLIGHTN_QUEUE_READED', 'queue_readed');
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
	define('URL_DOWNLOAD', $CONFIG->url . 'enlightn/download/');
	define('ENLIGHTN_THUMBNAIL', 'link_thumbnail');
        //email constant
        define('ENLIGHTN_EMAILMESSAGE_ID', 'email_message_id');
        define('ENLIGHTN_EMAILINREPLY_TO', 'email_in_reply_to');
        define('ENLIGHTN_EMAILREFERENCES', 'email_references');
        define('ENLIGHTN_EXTERNAL_USER', 'external_user');
        #regexp patern
	define('REG_LINK', '(https|file|ftp|http)+(://|/)[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))');
	define('REG_LINK_IN_MESSAGE', "#\b" . REG_LINK . "+(\s|\n|$|\r|\t|</p>|<br/>|<br>|<p/>)#");
	define('REG_HREF', "/<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>/siU");
        #bins
        define('PATH_TO_TREETAGGER','/usr/local/bin/treetagger/cmd/');
        define('PATH_TO_TMP','/tmp/');

        $sn_linkers = array('skype','linkedin','twitter','viadeo','facebook','google','flickr','youtube','vimeo','myspace','netvibes');