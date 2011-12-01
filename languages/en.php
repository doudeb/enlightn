<?php
	/**
	 * Elgg groups plugin language pack
	 *
	 * @package ElggGroups
	 */

	$english = array(

		/**
		 * Menu items and titles
		 */

			//GENERAL
			'systemmessages:dismiss' => 'Close'

			//REGISTRATION FORM
			,'register' => 'Register' //title of the page AND label of the register button: keep it short!
			,'name' => 'Name'
			,'email' => 'Email'
			,'username' => 'Username'
			,'password' => 'Password'
			,'passwordagain' => 'Confirm Password'
			,'RegistrationException:PasswordMismatch' => 'Please, be careful to enter the same password in both boxes.'
			,'registerok' => 'Welcome to Enlighn, the mail 2.0. We have send you a confirmation email. Please click on the link to get started...'
			,'registerbad' => 'Oops, we are sorry we cannot create your account for the moment. Please try again.'
			,'registration:emailnotvalid' => 'Oops, incorrect email address. Please try again.'
			,'registration:passwordnotvalid' => 'For security reason, your password must contain at least 6 characters.'
			,'registration:usernamenotvalid' => 'Your username should not contain spaces nor specific characters.'
			,'registration:userexists' => 'Username already exists. Please choose another username.'
			,'registration:dupeemail' => ''

			//LOG IN
			,'username' => 'Username'
			,'password' => 'Password'
			,'login' => 'Log in'
			,'loginerror' => 'Log in error; your username or password is incorrect. Please try again.'
			,'loginok' => ''
			,'user:persistent' => 'Keep me logged in'
			,'user:password:lost' => 'Forgotten your password?'
			,'request' => 'Send'
			,'register' => 'Register'
			,'user:password:text' => ''
			,'enlightn:loginboxheadline' => 'Email 2.0 for your company'

			//HEADER
			,'enlightn' => ""
			,'enlightn:title:discussions' => "Discussions"
			,'enlightn:title:cloud' => "Cloud"
			,'enlightn:title:directory' => "Directory"
			,'enlightn:myprofile' => 'My Profil'
			,'enlightn:editprofile' => 'Edit profil'
			,'enlightn:settings' => 'Settings'
			,'enlightn:logout' => 'Log out'

			//HOME - NEW TOPIC
			,'enlightn:newdiscussion' => "New discussion"
			,'enlightn:title' => 'Subject'
			,'enlightn:title:bold' => 'Bold'
			,'enlightn:title:italic' => 'Italic'
			,'enlightn:title:bulletpoints' => 'List'
			,'enlightn:title:link' => 'Link'
			,'enlightn:title:video' => 'Video'
			,'enlightn:prompt:link' => 'Enter the link you like to share:'
			,'enlightn:prompt:video' => 'Enter an Youtube/Dailymotion link...'
			,'enlightn:prompt:picure' => 'Attach a picture...'
			,'enlightn:title:picture' => 'Picture'
			,'enlightn:title:document' => 'Document'
			,'enlightn:buttonpublic' => 'Public'
			,'enlightn:buttonprivate' => 'Private'
			,'enlightn:to' => 'To'
			,'enlightn:tags' => 'Tags'
			,'enlightn:buttoncancel' => 'Cancel'
			,'enlightn:buttonpost' => 'Post'
			,'enlightn:missingData' => 'Oops, do you want to sent your post without subject?'
			,'enlightn:discussion_sucessfully_created' => ''

			//HOME - NEW TOPIC - UPLOAD
			,'enlightn:uploadyourfile' => 'Upload your file'
			,'enlightn:uploadcloud' => 'Has your file been uploaded into the cloud?'
			,'enlightn:titlefile' => 'File title'
			,'enlightn:tagsfile' => 'Tags'
			,'enlightn:uploadembed' => 'Upload a document to the discussion'

			//HOME - ACTIONS
			,'enlightn:read' => 'Read'
			,'enlightn:unread' => 'Unread'
			,'enlightn:action' => 'Action'
			,'enlightn:setasread' => 'Mark as read'
			,'enlightn:removeasread' => 'Mark as unread'
			,'enlightn:setasfollow' => 'Follow'
			,'enlightn:removeasfollow' => 'Unfollow'
			,'enlightn:setasfavorite' => 'Add to favorite'
			,'enlightn:removeasfavorite' => 'Remove from favorite'
            ,'enlightn:showunread' => 'Unread only'

			//HOME - SEARCH
			,'enlightn:search' => 'Search'
			,'enlightn:searchindiscussion' => 'Search in this discussion'
			,'enlightn:buttonall' => 'All'
			,'enlightn:title:buttonall' => 'All sort of messages'
			,'enlightn:title:text' => 'Text'
			,'enlightn:title:link' => 'Link'
			,'enlightn:title:video' => 'Video'
			,'enlightn:title:picture' => 'Picture'
			,'enlightn:title:document' => 'Document'
			,'enlightn:datefrom' => 'From'
			,'enlightn:dateto' => 'To'
			,'enlightn:fromuser' => 'From:'
			,'enlightn:typeforsearch' => 'Enter a name'
			,'enlightn:searchforuser' => 'Searching...'
            ,'enlightn:togglemorefilters' => 'Advanced search'

			//HOME - RIGHT COLUMN
			,'enlightn:public' => 'Public discussions'
			,'enlightn:follow' => 'My discussions'
			,'enlightn:request' => 'Request'
			,'enlightn:favorites' => 'My favorites'
			,'enlightn:sent' => 'Sent'

			//HOME - LEFT COLUMN
			,'enlightn:seemore' => 'See more'
			,'enlightn:buttonfollow' => 'Follow' //short text please (button)
			,'enlightn:buttonunfollow' => 'Unfollow' //short text please (button)
			,'enlightn:bunttonfollowed' => 'Following' // short texte please (button)

			//REQUESTS - LEFT COLUMN
			,'enlightn:buttonignore' => 'Ignore'

			//DETAILS OF A DISCUSSION
			,'enlightn:andothers' => ' and others'
			,'enlightn:invitedusers' => 'Invite users:'
			,'enlightn:userinvited' => 'Your invitation has been successfully sent.'
			,'enlightn:discussioninvite' => 'Invite people'
			,'enlightn:followers' => 'Followers:'
			,'enlightn:buttonsend' => 'Send'
			,'enlightn:postcreated' => 'By:'
			//,'enlightn:newpost' => 'Add a message'
			//,'enlightn:message_sucessfully_created' => "Your message has been added to the discussion."
			,'enlightn:messageempty' => "Oops, your message is empty..."
			,'enlightn:expandall' => " Expand all" //don't forget to add a space first
			,'enlightn:collapseall' => " Collapse all" //don't forget to add a space first
			,'enlightn:readmore' => 'Read more'
			,'enlightn:viewvideo' => 'Watch the video'
			,'enlightn:viewimage' => 'Enlarge'
			,'enlightn:downloaddocument' => 'Download'
			,'enlightn:attachmentlist' => ''
			,'enlightn:activity:member' => ' has now join the discussion'
			,'enlightn:activity:membership_request' => ' has received an invite to join a discussion'

			//PROFILE
			,'enlightn:profilelastmessage' => 'Discussions'
			,'enlightn:profilecloud' => 'Cloud'
			,'enlightn:previous' => 'Previous'
			,'enlightn:next' => 'Next'

			//DIRECTORY
			,'enlightn:directory' => 'Directory'
			,'*' => 'All' //4 characters max please
			,'enlightn:taball' => 'All'
			,'enlightn:directory:search' => 'Last name, First name'
			,'enlightn:seehisprofil' => 'See his profil'
			,'enlightn:createanewlist' => '+ Create a new list' //don't forget the "+"
			,'enlightn:listname' => 'Title' //short text please
			,'enlightn:privatepublic' => 'private/public'
			,'enlightn:errorlistnoname' => 'Please add a title to the list'

			//CLOUD
			,'enlightn:cloudmain' => 'Cloud'
			,'enlightn:cloudnew' => 'Add a document'
			,'enlightn:file:type:all' => 'Tous' //don't translate please
			,'enlightn:file:type:video' => 'Videos' //don't translate please
			,'enlightn:file:type:image' => 'Images' //don't translate please
			,'enlightn:file:type:doc' => 'Documents' //don't translate please
			,'enlightn:file:type:link' => 'Articles' //don't translate please
            ,'enlightn:attach' => 'Attach'
            ,'enlightn:attachtoanewdiscussion' => 'Attach'

			//SETTINGS
            ,'enlightn:settingsheader' => '%s' //don't translate please
			,'enlightn:account' => 'My account'
			,'user:name:label' => 'Last name First name'
			,'email:address:label' => 'email'
			,'user:language:label' => 'Language'

			,'enlightn:password' => 'Change my password'
			,'user:current_password:label' => 'Current password'
			,'user:password:label' => 'New password'
			,'user:password2:label' => 'Retype your new password'

			,'enlightn:profile' => 'Modify my profil'
			,'profile:jobtitle' => 'Job title'
			,'profile:department' => 'Department'
			,'profile:location' => 'City'
			,'profile:timezone' => 'Time zone'
			,'profile:addasociallink' => 'Add a link to a social network'
			,'profile:linkhelper:skype' => 'skype:username?call'
			,'profile:linkhelper:linkedin' => 'linkedin.com/in/username'
			,'profile:linkhelper:twitter' => 'twitter.com/#!/username'
			,'profile:linkhelper:viadeo' => 'viadeo.com/fr/profile/username'
			,'profile:linkhelper:google' => 'plus.google.com/user'
			,'profile:linkhelper:flickr' => 'flickr.com/people/username'
			,'profile:linkhelper:youtube' => 'youtube.com/user/username'
			,'profile:linkhelper:vimeo' => 'vimeo.com/user'
			,'profile:linkhelper:myspace' => 'myspace.com/username'
			,'profile:linkhelper:netvibes' => 'netvibes.com/username'
			,'profile:selectasociallink' => 'Select a social network'
			,'profile:phone' => 'Main phone'
			,'profile:cellphone' => 'Mobile'
			,'profile:direction' => 'Address'

			,'enlightn:picture' => 'Picture'
			,'profile:profilepictureinstructions' => ''
			,'profile:currentavatar' => 'Current picture'
			,'profile:editicon' => 'Change my picture'
			,'upload' => 'Validate'
			,'profile:profilepicturecroppingtool' => ''
			,'profile:createicon:instructions' => 'Drag the corner of the box to crop this photo into your profile picture.'
			,'profile:preview' => 'Preview:'
			,'profile:createicon' => 'Validate'

			,'enlightn:notification' => 'Email notification'
			,'enlightn:notificationheadline' => 'Send me a notification when:'
			,'enlightn:notifyoninvite' => 'I\'m invited to a discussion'
			,'enlightn:notifyonnewmsg' => 'There is a new message in my discussions'

			,'enlightn:statistics' => 'Statistics'
			,'usersettings:statistics:yourdetails' => 'My details'
			,'usersettings:statistics:label:name' => 'Name'
			,'usersettings:statistics:label:email' => 'email'
			,'usersettings:statistics:label:membersince' => 'Member since'
			,'usersettings:statistics:label:lastlogin' => 'Last connexion'
			,'usersettings:statistics:label:numentities' => 'My activities'
			,'item:object:enlightndiscussion' => 'Created discussions'
			,'item:object:file' => 'My cloud'

			//FOOTER
			,'expages:about' => 'Policies'
			,'expages:terms' => 'Terms and conditions'
			,'expages:privacy' => 'Privacy'
			,'expages:help' => 'Help'
			,'expages:FAQ' => 'FAQ'

			//DATES
			,'friendlytime:justnow' => "just now"
			,'friendlytime:minutes' => "few minutes ago"
			,'friendlytime:minutes:singular' => "one minute ago "
			,'friendlytime:hours' => "%s hours ago"
			,'friendlytime:hours:singular' => "an hour ago"
			,'friendlytime:days' => "%s days ago"
			,'friendlytime:days:singular' => "yesterday"
			,'friendlytime:date_format' => 'd M Y at H:i'

			//LOG OUT
			,'logoutsucceed' => 'See you soon'

            //MAIL
			//New message
			,'enlightn:newmessage:subject' => 'Re: %s '
			,'enlightn:newmessage:body' => 'Hi %s,

%s add a new message to the discussion "%s" :
%s

<a href="%s">Access the discussion</a>'

			//$follower (to)  $user (from)  $topic (title)  $url

			//Confirm email
			,'uservalidation:email:validate:subject' => '%s, please confirm your email to access %s'
			,'uservalidation:email:validate:body' => 'Hi %s,

You have successfully registered to the platform %s.
To access your profil, please confirm your email following the link below:
%s

See you on %s,
Team Enlightn'

			//Email validated
			,'email:validate:success:subject' => 'Welcome on %s'
			,'email:validate:success:body' => 'Hi %s,

Your account has successfully been created on %s.

See you on %s,
Team Enlightn'

            //Invite
			,'enlightn:invite:subject' => '%s'
			,'enlightn:invite:body' => 'Hi %s,
%s has invited to follow the discussion
<p><strong>"%s"</strong></p>
<p><a href="%s"><span class="tag">View discussion</span></a></p>'

	);
	add_translation("en",$english);
?>