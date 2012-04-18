<?php
	/**
	 * Elgg groups plugin language pack
	 *
	 * @package ElggGroups
	 */

	$french = array(

		/**
		 * Menu items and titles
		 */

			//GENERAL
			'systemmessages:dismiss' => 'Fermer'

			//REGISTRATION FORM
			,'register' => 'Inscription' //title of the page AND label of the register button: keep it short!
			,'name' => 'Nom Prénom'
			,'email' => 'email'
			,'username' => 'Nom d\utilisateur'
			,'password' => 'Mot de passe'
			,'passwordagain' => 'Resaisissez votre mot de passe'
			,'RegistrationException:PasswordMismatch' => 'Attention! Tapez bien le même mot de passe dans les deux champs.'
			,'registerok' => 'Bienvenue sur Enlightn, le mail 2.0. Nous vous avons envoyé un email de confirmation. Merci de cliquer sur le lien pour valider votre inscription.'
			,'registerbad' => 'Oups, nous ne pouvons créer votre compte pour le moment. Veuillez réessayer.'
			,'registration:emailnotvalid' => 'Oups, votre adresse email est invalide. Veuillez réessayer.'
			,'registration:passwordnotvalid' => 'Pour des raisons de sécurité, votre mot de passe doit contenir au minimum 6 caractères.'
			,'registration:usernamenotvalid' => 'Votre nom d\'utilisateur ne doit contenir aucun espace ni caractères spéciaux.'
			,'registration:userexists' => 'Ce nom d\'utilisateur est déjà utilisé. Veuillez en choisir un autre.'
			,'registration:dupeemail' => ''

			//LOG IN
			,'username' => 'Nom d\'utilisateur'
			,'password' => 'Mot de passe'
			,'login' => 'Connexion'
			,'loginerror' => 'Impossible de vous connecter; votre nom d\'utilisateur ou votre mot de passe est erroné. Veuillez essayer à nouveau.'
			,'loginok' => ''
			,'user:persistent' => 'Rester connecté'
			,'user:password:lost' => 'Mot de passe oublié?'
			,'request' => 'Envoyer'
			,'register' => 'Inscription'
			,'user:password:text' => ''
            ,'enlightn:loginboxheadline' => 'Email 2.0 for your company'

			//HEADER
			,'enlightn' => ""
			,'enlightn:title:discussions' => "Discussions"
			,'enlightn:title:cloud' => "Cloud"
			,'enlightn:title:directory' => "Trombinoscope"
			,'enlightn:myprofile' => 'Profil'
			,'enlightn:editprofile' => 'Modifier mon profil'
			,'enlightn:settings' => 'Préférences'
			,'enlightn:logout' => 'Déconnexion'

			//HOME - NEW TOPIC
			,'enlightn:newdiscussion' => "Créer une nouvelle discussion"
			,'enlightn:title' => 'Titre de la discussion'
			,'enlightn:title:bold' => 'Gras'
			,'enlightn:title:italic' => 'Italique'
			,'enlightn:title:bulletpoints' => 'Liste'
			,'enlightn:title:link' => 'Lien'
			,'enlightn:title:video' => 'Vidéo'
			,'enlightn:prompt:link' => 'Saisissez le lien que vous souhaitez partager:'
			,'enlightn:prompt:video' => 'Saisissez un lien Youtube/Dailymotion...'
			,'enlightn:prompt:picure' => 'Saisissez un lien vers une image...'
			,'enlightn:title:picture' => 'Image'
			,'enlightn:title:document' => 'Document'
			,'enlightn:buttonpublic' => 'Publique'
			,'enlightn:buttonprivate' => 'Privée'
			,'enlightn:to' => 'A'
			,'enlightn:tags' => 'Mots-clés'
			,'enlightn:buttoncancel' => 'Annuler'
			,'enlightn:buttonpost' => 'Envoyer'
			,'enlightn:missingData' => 'Oups, il manque un titre à votre discussion.'
			,'enlightn:discussion_sucessfully_created' => ''
                        ,'enlightn:discussionusersuggest' => 'Suggestion de participant'

			//HOME - NEW TOPIC - UPLOAD
			,'enlightn:uploadcloud' => 'Votre fichier se trouve dans le cloud?'
			,'enlightn:titlefile' => 'Titre du document'
			,'enlightn:tagsfile' => 'Mots-clés'
			,'enlightn:uploadembed' => 'Joindre à la discussion'
                        ,'enlightn:editmytitle' => 'Modifier'
                        ,'enlightn:editkeyword' => 'Editer les mots cléfs'
                        ,'enlightn:savedsearch' => 'Recherches mémorisées'
                        ,'enlightn:searchmemo' => 'Mémoriser la recherche'
                        ,'enlightn:prompt:cloudremovesavedsearch' => 'êtes-vous sûr de vouloir supprimer cette recherche?'
                        ,'enlightn:prompt:disableentity' => 'êtes-vous sûr de vouloir supprimer ?'
                        ,'enlightn:applyfilter' => 'Appliquer le libélé'

			//HOME - ACTIONS
			,'enlightn:read' => 'Lus'
			,'enlightn:unread' => 'Non lus'
			,'enlightn:action' => 'Actions'
			,'enlightn:setasread' => 'Marquer comme lu'
			,'enlightn:removeasread' => 'Marquer comme non lu'
			,'enlightn:setasfollow' => 'Rejoindre la discussion'
			,'enlightn:removeasfollow' => 'Quitter la discussion'
			,'enlightn:setasfavorite' => 'Mettre en favori'
			,'enlightn:removeasfavorite' => 'Supprimer de mes favoris'
			,'enlightn:showunread' => 'Afficher non lus'
			,'enlightn:selectnone' => 'Aucun'

			//HOME - SEARCH
			,'enlightn:search' => 'Recherche'
			,'enlightn:searchindiscussion' => 'Recherche dans cette discussion'
			,'enlightn:buttonall' => 'Tous'
			,'enlightn:title:buttonall' => 'Tous types de messages'
			,'enlightn:title:text' => 'Texte'
			,'enlightn:title:link' => 'Lien'
			,'enlightn:title:video' => 'Vidéo'
			,'enlightn:title:picture' => 'Image'
			,'enlightn:title:document' => 'Document'
			,'enlightn:datefrom' => 'du'
			,'enlightn:dateto' => 'au'
			,'enlightn:fromuser' => 'De:'
			,'enlightn:typeinasearchterm' => 'Saisir un nom'
			,'enlightn:searching' => 'recherche...'
			,'enlightn:togglemorefilters' => 'Recherche avancée'

			//HOME - RIGHT COLUMN
			,'enlightn:public' => 'Discussions publiques'
			,'enlightn:follow' => 'Mes discussions'
			,'enlightn:request' => 'Invitations reçues'
			,'enlightn:favorites' => 'Mes favoris'
			,'enlightn:sent' => 'Envoyés'
			,'enlightn:trendingtopic' => 'Trending topic'

			//HOME - LEFT COLUMN
			,'enlightn:seemore' => 'Voir plus'
			,'enlightn:buttonfollow' => 'Rejoindre' //short text please (button)
			,'enlightn:buttonunfollow' => 'Quitter' //short text please (button)
			,'enlightn:bunttonfollowed' => 'Abonné' // short texte please (button)

			//REQUESTS - LEFT COLUMN
			,'enlightn:buttonignore' => 'Ignorer'

			//DETAILS OF A DISCUSSION
			,'enlightn:andothers' => ' et %s autres'
			,'enlightn:invitedusers' => 'Invités:'
			,'enlightn:userinvited' => 'Votre invitation a bien été envoyée.'
			,'enlightn:discussioninvite' => 'Inviter des participants'
			,'enlightn:followers' => 'Participants:'
			,'enlightn:buttonsend' => 'Envoyer'
			,'enlightn:postcreated' => 'Créée par:'
			//,'enlightn:newpost' => 'Ajouter un message'
			//,'enlightn:message_sucessfully_created' => "Votre message a bien été ajouté à la discussion."
			,'enlightn:messageempty' => "Oups, vous avez oublié de saisir votre message..."
			,'enlightn:expandall' => " Agrandir" //don't forget to add a space first
			,'enlightn:collapseall' => " Réduire" //don't forget to add a space first
			,'enlightn:readmore' => 'Plus d\'infos'
			,'enlightn:viewvideo' => 'Voir sur le site'
			,'enlightn:viewimage' => 'Agrandir'
			,'enlightn:downloaddocument' => 'Télécharger'
			,'enlightn:activity:member' => ' a rejoint la discussion'
			,'enlightn:activity:membership_request' => ' a été invité à rejoindre la discussion'
			,'enlightn:forward' => 'Faire suivre'
			,'enlightn:selectparttoforward' => 'Transférer'
			,'enlightn:buttonforward' => 'Valider'
			,'enlightn:viewcloud' => 'Cloud'
			,'enlightn:viewdiscussion' => 'Messages'

			//PROFILE
			,'enlightn:profilelastmessage' => 'Ses discussions'
			,'enlightn:profilecloud' => 'Son cloud'
			,'enlightn:previous' => 'Précédent'
			,'enlightn:next' => 'Suivant'

			//DIRECTORY
			,'enlightn:directory' => 'Trombinoscope'
			,'*' => 'Tous' //4 characters max please
			,'enlightn:taball' => 'Tous'
			,'enlightn:directory:search' => 'Nom, Prénom'
			,'enlightn:seehisprofil' => 'Voir son profil'
			,'enlightn:createanewlist' => '+ Créer une nouvelle liste' //don't forget the "+"
			,'enlightn:listname' => 'Intitulé' //short text please
			,'enlightn:privatepublic' => 'privée/publique'
			,'enlightn:errorlistnoname' => 'Veuillez attribuer un nom pour cette liste'

			//CLOUD
			,'enlightn:cloudmain' => 'Cloud'
                        ,'enlightn:cloudheadline' => 'Bibliothèque virtuelle de votre entreprise'
			,'enlightn:cloudnew' => 'Ajouter un document'
			,'enlightn:file:type:all' => 'Tous' //don't translate please
			,'enlightn:file:type:video' => 'Videos' //don't translate please
			,'enlightn:file:type:image' => 'Images' //don't translate please
			,'enlightn:file:type:doc' => 'Documents' //don't translate please
			,'enlightn:file:type:link' => 'Articles' //don't translate please
			,'enlightn:attach' => 'Attacher' //Attach a doc to a dissucssion
			,'enlightn:attachtoanewdiscussion' => 'Envoyer' //Create a discussion with the doc

			//SETTINGS
            ,'enlightn:settingsheader' => '%s' //don't translate please
			,'enlightn:account' => 'Mon compte'
			,'user:name:label' => 'Nom Prénom'
			,'email:address:label' => 'email'
			,'user:language:label' => 'Langue'

			,'enlightn:password' => 'Changer mon mot de passe'
			,'user:current_password:label' => 'Mot de passe actuel'
			,'user:password:label' => 'Nouveau mot de passe'
			,'user:password2:label' => 'Saisissez de nouveau votre mot de passe'

			,'enlightn:profile' => 'Modifier mon profil'
			,'profile:jobtitle' => 'Fonction'
			,'profile:department' => 'Département'
			,'profile:location' => 'Ville'
			,'profile:timezone' => 'Fuseau horaire'
			,'profile:addasociallink' => 'Ajouter un lien vers un profil social'
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
			,'profile:selectasociallink' => 'Choisissez'
			,'profile:phone' => 'Téléphone professionnel'
			,'profile:cellphone' => 'Mobile'
			,'profile:direction' => 'Adresse professionnelle'

			,'enlightn:picture' => 'Photo'
			,'profile:profilepictureinstructions' => ''
			,'profile:currentavatar' => 'Photo actuelle'
			,'profile:editicon' => 'Changer ma photo'
			,'upload' => 'Valider'
			,'profile:profilepicturecroppingtool' => ''
			,'profile:createicon:instructions' => 'Sélectionnez la partie de l\'image que vous souhaitez utiliser comme photo pour votre profil.'
			,'profile:preview' => 'Prévisualisation:'
			,'profile:createicon' => 'Valider'

			,'enlightn:notification' => 'Alertes email'
			,'enlightn:notificationheadline' => 'M\'alerter quand:'
			,'enlightn:notifyoninvite' => 'Je suis invité à une discussion'
			,'enlightn:notifyonnewmsg' => 'Quand il y a un nouveau message dans mes discussions'

			,'enlightn:statistics' => 'Statistiques'
			,'usersettings:statistics:yourdetails' => 'Mes infos'
			,'usersettings:statistics:label:name' => 'Nom'
			,'usersettings:statistics:label:email' => 'email'
			,'usersettings:statistics:label:membersince' => 'Inscrit le'
			,'usersettings:statistics:label:lastlogin' => 'Dernière connexion'
			,'usersettings:statistics:label:numentities' => 'Mes participations'
			,'item:object:enlightndiscussion' => 'Discussions créées'
			,'item:object:file' => 'Mon cloud'

			//FOOTER
			,'expages:about' => 'Charte d\'utilisation'
			,'expages:terms' => 'Politique de Confidentialité'
			,'expages:privacy' => 'CGU'
			,'expages:help' => 'Aide'
			,'expages:FAQ' => 'FAQ'

			//DATES
			,'friendlytime:justnow' => "à l'instant"
			,'friendlytime:minutes' => "il y a %s minutes"
			,'friendlytime:minutes:singular' => "il y a une minute"
			,'friendlytime:hours' => "il y a %s heures"
			,'friendlytime:hours:singular' => "il y a une heure"
			,'friendlytime:days' => "il y a %s jours"
			,'friendlytime:days:singular' => "hier"
			,'friendlytime:date_format' => 'j F Y à H:i'

			//LOG OUT
			,'logoutsucceed' => 'A bientôt'

            //MAIL
			//New message
			,'enlightn:newmessage:subject' => 'Re: %s '
			,'enlightn:newmessage:body' => 'Bonjour %s,

%s a ajouté un nouveau message à la discussion <strong>"%s" :</strong>
%s

<p><a href="%s"><span class="tag">Accéder à la discussion</a></span></a></p>
<p>A tout de suite sur ' . $CONFIG->sitename . '</p>'

			//$follower (to)  $user (from)  $topic (title)  $url

			//Confirm email
			,'uservalidation:email:validate:subject' => '%s, veuillez confirmer votre email pour accéder à %s'
			,'uservalidation:email:validate:body' => 'Bonjour %s,

Vous venez de vous inscrire à la plateforme %s.
Pour y accéder, veuillez confirmer votre adresse email en cliquant sur le lien ci-dessous:
%s

A tout de suite sur ' . $CONFIG->sitename

			//Email validated
			,'email:validate:success:subject' => 'Bienvenue sur %s'
			,'email:validate:success:body' => 'Bonjour %s,

Votre compte a bien été créé sur la plateforme %s.

A tout de suite sur %s,
L\'équipe Enlightn'

            //Invite
			,'enlightn:invite:subject' => '%s'
			,'enlightn:invite:body' => 'Bonjour %s,

%s vous invite à rejoindre la discussion <strong>"%s".</strong>

<p><a href="%s"><span class="tag">Accéder la discussion</span></a></p>
<p>A tout de suite sur ' . $CONFIG->sitename . '</p>'

            );
	add_translation("fr",$french);
?>