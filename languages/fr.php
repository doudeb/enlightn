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


			//REGISTRATION FORM


			//LOG IN
			'enlightn:username' => 'Nom d\'utilisateur'
			,'enlightn:password' => 'Mot de passe'
			,'enlightn:buttonlogin' => 'Connexion'
			,'enlightn:errorlogin' => 'Impossible de vous connecter; votre nom d\'utilisateur ou votre mot de passe est erroné. Veuillez essayer à nouveau.'
			,'enlightn:loginsuccess' => ''
			,'enlightn:rememberme' => 'Rester connecté'
			,'enlightn:lostpassword' => 'Mot de passe oublié?'
			,'enlightn:buttonrequest' => 'Envoyer'

			//HEADER
			,'enlightn' => "Enlightn"
			,'enlightn:profile' => 'Profil'
			,'enlightn:settings' => 'Préférences'
			,'enlightn:logout' => 'Déconnexion'
			,'enlightn:directory' => 'Trombinoscope'

			//HOME - NEW TOPIC
			,'enlightn:newdiscussion' => "Créez une nouvelle discussion"
			,'enlightn:title' => 'Sujet'
			,'enlightn:buttonpublic' => "Publique"
			,'enlightn:buttonprivate' => "Privée"
			,'enlightn:to' => "A"
			,'enlightn:tags' => 'Mots-clé'
			,'enlightn:buttoncancel' => "Annuler"
			,'enlightn:buttonpost' => "Envoyer"
			,'enlightn:missingData' => "Oups, il manque une information"
			,'enlightn:discussion_sucessfully_created' => "Votre discussion a bien été créée."

			//HOME - NEW TOPIC - UPLOAD
			,'enlightn:uploadyourfile' => 'Joindre un fichier'
			,'enlightn:cloud' => 'Accéder au Cloud'
			,'enlightn:titlefile' => 'Titre du document'
			,'enlightn:tagsfile' => 'Mots-clé'
			,'enlightn:upload' => 'Joindre à la discussion'

			//HOME - ACTIONS
			,'enlightn:read' => 'Lus'
			,'enlightn:unread' => 'Non lus'
			,'enlightn:followed' => 'Suivies'
			,'enlightn:unfollowed' => 'Non suivies'
			,'enlightn:setasreadunread' => 'Lu / Non lu'
			,'enlightn:setasread' => 'Marquer comme lu'
			,'enlightn:setasunread' => 'Marquer comme non lu'
			,'enlightn:setasfollowunfollow' => 'Suivi'
			,'enlightn:setasfollow' => 'Suivre'
			,'enlightn:setasunfollow' => 'Se désabonner'
			,'enlightn:setasfavoriteunfavorite' => 'Favoris'
			,'enlightn:setasfavorite' => 'Mettre en favori'
			,'enlightn:setasunfavorite' => 'Supprimer de mes favoris'

			//HOME - SEARCH
			,'enlightn:search' => "Recherche"
			,'enlightn:buttonall' => "Tous"
			,'enlightn:datefrom' => 'Du'
			,'enlightn:dateto' => 'au'
			,'enlightn:fromuser' => 'Par'
			,'enlightn:typeinasearchterm' => "Nom"
			,'enlightn:searching' => "recherche..."

			//HOME - RIGHT COLUMN
			,'enlightn:public' => "Discussions publiques"
			,'enlightn:follow' => "Mes discussions"
			,'enlightn:request' => "Invitations"
			,'enlightn:buttonfollow' => "Suivre"
			,'enlightn:buttonunfollow' => "Quitter"
			,'enlightn:buttonignore' => "Ignorer"
			,'enlightn:bunttonfollowed' => "Suivi"
			,'enlightn:favorites' => "Favoris"
			,'enlightn:sent' => "Envoyés"

			//HOME - LEFT COLUMN
			,'enlightn:andothers' => ' et %s autres'
			,'enlightn:buttonfollow' => "Suivre"
			,'enlightn:seemore' => "Voir plus"

			//DETAILS OF A DISCUSSION
			,'enlightn:buttonunnfollow' => "Se désabonner"
			,'enlightn:followers' => "Participants:"
			,'enlightn:invitedusers' => "Invités:"
			,'enlightn:userinvited' => "Votre invitation a bien été envoyée."
			,'enlightn:discussioninvite' => "Inviter des participants"
			,'enlightn:buttonsend' => "Envoyer"
			,'enlightn:postcreated' => "Créée par:"
			,'enlightn:newpost' => 'Ajouter un message'
			,'enlightn:message_sucessfully_created' => "Votre message a bien été ajouté à la discussion."
			,'enlightn:messageempty' => "Oups, vous avez oublié de saisir votre message..."
			,'enlightn:expandall' => "Voir tout"
			,'enlightn:collapseall' => "Réduire"
			,'enlightn:readmore' => 'Plus d\'infos'
			,'enlightn:viewvideo' => 'Voir sur le site'
			,'enlightn:viewimage' => 'Agrandir'
			,'enlightn:viewdocument' => 'Ouvrir'
			,'enlightn:downloaddocument' => 'Télécharger'
			,'enlightn:activity:member' => ' a rejoint la discussion'
			,'enlightn:activity:membership_request' => ' a été invité à la discussion'

			//PROFILE
			,'enlightn:editprofileicon' => 'Modifier ma photo'
			,'enlightn:editprofile' => 'Modifier mon profil'

			//DIRECTORY
			,'enlightn:directoryall' => 'Tous'
			,'enlightn:createanewlist' => 'Créer une nouvelle liste'
			,'enlightn:listname' => 'Nom de la liste'
			,'enlightn:private/public' => 'privée/publique'
			,'enlightn:errorlistnoname' => 'Veuillez choisir un nom pour cette liste'

			//CLOUD
			,'enlightn:cloudmain' => 'Cloud'
			,'enlightn:download' => 'Télécharger'
			/*
			Attention tonton, il est écrit enlighnt en dev au lieu d'enlightn
			*/
			,'enlightn:previous' => 'Précédent'
			,'enlightn:next' => 'Suivant'
			,'enlightn:file:type:all' => 'Tous'
			,'enlightn:file:type:video' => 'Videos'
			,'enlightn:file:type:image' => 'Images'
			,'enlightn:file:type:doc' => 'Documents'
			,'enlightn:file:type:link' => 'Articles'

			//SETTINGS
            ,'enlightn:settingsheader' => '%s settings'

			//LOG OUT
			,'enlightn:logoutsucceed' => 'A bientôt'

            //MAIL
            //Invite
			,'enlightn:invite:subject' => 'Invitation à rejoindre la discussion : %s '
			,'enlightn:invite:body' => 'Bonjour %s,

Vous avez reçu de la part de %s une invitation à rejoindre la discussion "%s"

<a href="%s">Rejoindre la discussion</a>
%s'


	);
	add_translation("fr",$french);
?>