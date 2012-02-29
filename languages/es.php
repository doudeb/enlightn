<?php
	/**
	 * Elgg groups plugin language pack
	 *
	 * @package ElggGroups
	 */

	$spain = array(

		/**
		 * Menu items and titles
		 */

			//GENERAL
			'systemmessages:dismiss' => 'Cerrar'
            ,'avatar:upload:success' => 'Tu foto ha sido cargada exitosamente.'
            ,'avatar:upload:fail' => 'La operación ha fallado.'
            ,'avatar:resize:fail' => 'La operación ha fallado.'
            ,'avatar:crop:success' => 'Tu foto ha sido recortada exitosamente'
            ,'avatar:crop:fail' => 'La operación ha fallado.'

			//REGISTRATION FORM
			,'register' => 'Regístrate' //title of the page AND label of the register button: keep it short!
			,'name' => 'Nombre Apellido'
			,'email' => 'email'
			,'username' => 'Nombre de usuario'
			,'password' => 'Contraseña'
			,'passwordagain' => 'Reescribe tu contraseña'
			,'RegistrationException:PasswordMismatch' => 'Escribe la misma contraseña en los dos campos.'
			,'registerok' => 'Te hemos enviado un mail de confirmación. Por favor da click para validar tu inscripción.'
			,'registerbad' => 'Ups, no se pudo crear tu cuenta. Por favor inténtalo de nuevo.'
			,'registration:emailnotvalid' => 'Ups, tu email es incorrecto. Vuelve a intentarlo.'
			,'registration:passwordnotvalid' => 'Por razones de seguridad tu contraseña debe tener un mínimo de 6 caracteres.'
			,'registration:usernamenotvalid' => 'Tu nombre de usuario no debe contener ningún espacio ni caracteres especiales.'
			,'registration:userexists' => 'Este nombre de usuario ya existe, por favor elige otro.'
			,'registration:dupeemail' => ''

			//LOG IN
			,'username' => 'Nombre de usuario'
			,'password' => 'Contraseña'
			,'login' => 'Entrar'
			,'loginerror' => 'No puedes entrar a tu cuenta; nombre de usuario o contraseña incorrecto. Inténtalo de nuevo.'
			,'loginok' => ''
			,'user:persistent' => 'No cerrar sesión'
			,'user:password:lost' => '¿Olvidaste tu contraseña?'
			,'request' => 'Enviar'
			,'register' => 'Registrar'
			,'user:password:text' => ''
			,'enlightn:loginboxheadline' => 'Email 2.0 para tu empresa'

			//HEADER
			,'enlightn' => ""
			,'enlightn:title:discussions' => "Conversación"
			,'enlightn:title:cloud' => "Cloud"
			,'enlightn:title:directory' => "Directorio"
			,'enlightn:myprofile' => 'Perfil'
			,'enlightn:editprofile' => 'Modificar tu perfil'
			,'enlightn:settings' => 'Preferencias'
			,'enlightn:logout' => 'Salir'

			//HOME - NEW TOPIC
			,'enlightn:newdiscussion' => "Crear una nueva conversación"
			,'enlightn:title' => 'Título de la conversación'
			,'enlightn:title:bold' => 'Negritas'
			,'enlightn:title:italic' => 'Itálica'
			,'enlightn:title:bulletpoints' => 'Viñetas'
			,'enlightn:title:link' => 'Link'
			,'enlightn:title:video' => 'Video'
			,'enlightn:prompt:link' => 'Introduce el link que quieras compartir:'
			,'enlightn:prompt:video' => 'Introduce un link ej. Youtube...'
			,'enlightn:prompt:picure' => 'Introduce un link para cargar una imagen'
			,'enlightn:title:picture' => 'Imagen'
			,'enlightn:title:document' => 'Documento'
			,'enlightn:buttonpublic' => 'Pública'
			,'enlightn:buttonprivate' => 'Privada'
			,'enlightn:to' => 'A'
			,'enlightn:tags' => 'Tags'
			,'enlightn:buttoncancel' => 'Cancelar'
			,'enlightn:buttonpost' => 'Enviar'
			,'enlightn:missingData' => 'Ups, olvidaste el título de tu conversación.'
			,'enlightn:conversación_sucessfully_created' => ''
			,'enlightn:discussionusersuggest' => 'Sugerencia de contacto'

			//HOME - NEW TOPIC - UPLOAD
			,'enlightn:uploadyourfile' => 'Cargar tu archivo'
			,'enlightn:uploadcloud' => '¿Tu archivo se encuentra en el cloud?'
			,'enlightn:titlefile' => 'Título del archivo'
			,'enlightn:tagsfile' => 'Tags'
			,'enlightn:uploadembed' => 'Adjunta a la conversación'
			,'enlightn:editmytitle' => 'Editar titulo'
                        ,'enlightn:editkeyword' => 'Editar palabra clave'
                        ,'enlightn:savedsearch' => 'Búsqueda guardada'
                        ,'enlightn:searchmemo' => 'Guardar búsqueda'
                        ,'enlightn:prompt:cloudremovesavedsearch' => '¿Estas seguro que quieres borrar la búsqueda?'

			//HOME - ACTIONS
			,'enlightn:read' => 'Leída'
			,'enlightn:unread' => 'No leída'
			,'enlightn:action' => 'Acciones'
			,'enlightn:setasread' => 'Marcar como leída'
			,'enlightn:removeasread' => 'Marcar como no leída'
			,'enlightn:setasfollow' => 'Únete a la conversación'
			,'enlightn:removeasfollow' => 'Deja la conversación'
			,'enlightn:setasfavorite' => 'Marcar como favorito'
			,'enlightn:removeasfavorite' => 'Borrar de tus favoritos'
            ,'enlightn:showunread' => 'Solo no leídos'
            ,'enlightn:selectnone' => 'Ninguna'

			//HOME - SEARCH
			,'enlightn:search' => 'Buscar'
			,'enlightn:searchinconversación' => 'Buscar en esta conversación'
			,'enlightn:buttonall' => 'Todo'
			,'enlightn:title:buttonall' => 'Todo tipo de mensajes'
			,'enlightn:title:text' => 'Texto'
			,'enlightn:title:link' => 'Link'
			,'enlightn:title:video' => 'Video'
			,'enlightn:title:picture' => 'Imagen'
			,'enlightn:title:document' => 'Archivo'
			,'enlightn:datefrom' => 'Desde'
			,'enlightn:dateto' => 'Hasta'
			,'enlightn:fromuser' => 'De :'
			,'enlightn:typeinasearchterm' => 'Escribe un nombre'
			,'enlightn:searching' => 'buscando...'
            ,'enlightn:togglemorefilters' => 'Búsqueda avanzada'

			//HOME - RIGHT COLUMN
			,'enlightn:public' => 'Conversaciones públicas'
			,'enlightn:follow' => 'Mis conversaciones'
			,'enlightn:request' => 'Invitaciones recibidas'
			,'enlightn:favorites' => 'Mis favoritas'
			,'enlightn:sent' => 'Enviadas'
			,'enlightn:trendingtopic' => 'Tema de interés'

			//HOME - LEFT COLUMN
			,'enlightn:seemore' => 'Ver más'
			,'enlightn:buttonfollow' => 'Unir' //short text please (button)
			,'enlightn:buttonunfollow' => 'Dejar' //short text please (button)
			,'enlightn:bunttonfollowed' => 'Siguiendo ' // short texte please (button)

			//REQUESTS - LEFT COLUMN
			,'enlightn:buttonignore' => 'Declinar'

			//DETAILS OF A DISCUSSION
			,'enlightn:andothers' => ' y %s otros'
			,'enlightn:invitedusers' => 'Invitados:'
			,'enlightn:userinvited' => 'Tu invitatión ha sido enviada.'
			,'enlightn:discussioninvite' => 'Invitar participantes'
			,'enlightn:followers' => 'Participantes:'
			,'enlightn:buttonsend' => 'Enviar'
			,'enlightn:postcreated' => 'Creada por:'
			//,'enlightn:newpost' => 'Añadir un mensaje'
			//,'enlightn:message_sucessfully_created' => "Tu mensaje ha sido añadido correctamente a la conversación."
			,'enlightn:messageempty' => "Ups, olvidaste introducir tu mensaje..."
			,'enlightn:expandall' => " Expandir" //don't forget to add a space first
			,'enlightn:collapseall' => " Reducir" //don't forget to add a space first
			,'enlightn:readmore' => 'Más información'
			,'enlightn:viewvideo' => 'Ver en el sitio'
			,'enlightn:viewimage' => 'Expandir'
			,'enlightn:downloaddocument' => 'Descargar'
			,'enlightn:attachmentlist' => ''
			,'enlightn:activity:member' => ' se ha unido a la conversación'
			,'enlightn:activity:membership_request' => ' ha sido invitad@ a la conversación'
			,'enlightn:forward' => 'Reenviar mensajes'
			,'enlightn:selectparttoforward' => 'Seleccionar mensajes a reenviar'
			,'enlightn:buttonforward' => 'Forward'
			,'enlightn:viewcloud' => 'Ver cloud'
			,'enlightn:viewdiscussion' => 'Ver conversación'

			//PROFILE
			,'enlightn:profilelastmessage' => 'Sus conversacións'
			,'enlightn:profilecloud' => 'Su cloud'
			,'enlightn:previous' => 'Anterior '
			,'enlightn:next' => 'Siguiente'

			//DIRECTORY
			,'enlightn:directory' => 'Directorio'
			,'*' => 'Todos' //4 characters max please
			,'enlightn:taball' => 'Todos'
			,'enlightn:directory:search' => 'Nombre, Apellido'
			,'enlightn:seehisprofil' => 'Ver su perfil'
			,'enlightn:createanewlist' => '+ Crear una nueva lista' //don't forget the "+"
			,'enlightn:listname' => 'Lista' //short text please
			,'enlightn:privatepublic' => 'privada/pública'
			,'enlightn:errorlistnoname' => 'Nombra esta lista'

			//CLOUD
			,'enlightn:cloudmain' => 'Cloud'
                        ,'enlightn:cloudheadline' => 'Biblioteca virtual de la empresa'
			,'enlightn:cloudnew' => 'Adjuntar un documento'
			,'enlightn:file:type:all' => 'Tous' //don't translate please
			,'enlightn:file:type:video' => 'Videos' //don't translate please
			,'enlightn:file:type:image' => 'Images' //don't translate please
			,'enlightn:file:type:doc' => 'Documents' //don't translate please
			,'enlightn:file:type:link' => 'Articles' //don't translate please
            ,'enlightn:attach' => 'Adjuntar'
            ,'enlightn:attachtoanewdiscussion' => 'Adjuntar'

			//SETTINGS
            ,'enlightn:settingsheader' => '%s' //don't translate please
			,'enlightn:account' => 'Tu cuenta'
			,'user:name:label' => 'Nombre Apellido'
			,'email:address:label' => 'email'
			,'user:language:label' => 'Idioma'

			,'enlightn:password' => 'Cambiar tu contraseña'
			,'user:current_password:label' => 'Contraseña actual'
			,'user:password:label' => 'Nueva contraseña'
			,'user:password2:label' => 'Introduce tu nueva contraseña'

			,'enlightn:profile' => 'Modificar tu perfil'
			,'profile:jobtitle' => 'Puesto'
			,'profile:department' => 'Área'
			,'profile:location' => 'Ciudad'
			,'profile:timezone' => 'Zona horaria'
			,'profile:addasociallink' => 'Añadir un link a una red social'
			,'profile:linkhelper:skype' => 'skype:username?call'
			,'profile:linkhelper:linkedin' => 'linkedin.com/in/username'
			,'profile:linkhelper:twitter' => 'twitter.com/#!/username'
			,'profile:linkhelper:viadeo' => 'viadeo.com/es/profile/username'
			,'profile:linkhelper:google' => 'plus.google.com/user'
			,'profile:linkhelper:flickr' => 'flickr.com/people/username'
			,'profile:linkhelper:youtube' => 'youtube.com/user/username'
			,'profile:linkhelper:vimeo' => 'vimeo.com/user'
			,'profile:linkhelper:myspace' => 'myspace.com/username'
			,'profile:linkhelper:netvibes' => 'netvibes.com/username'
			,'profile:selectasociallink' => 'Elige'
			,'profile:phone' => 'Telefono oficina'
			,'profile:cellphone' => 'Celular profesional'
			,'profile:direction' => 'Dirección oficina'

			,'enlightn:picture' => 'Foto'
			,'profile:profilepictureinstructions' => ''
			,'profile:currentavatar' => 'Foto actual'
			,'profile:editicon' => 'Cambia tu foto'
			,'upload' => 'Subir'
			,'profile:profilepicturecroppingtool' => ''
			,'profile:createicon:instructions' => 'Selecciona la parte de la foto que quieres utilizar para tu perfil.'
			,'profile:preview' => 'Previsulizar:'
			,'profile:createicon' => 'Aceptar'

			,'enlightn:notification' => 'Alertas de email'
			,'enlightn:notificationheadline' => 'Alertar cuando:'
			,'enlightn:notifyoninvite' => 'Estás invitado a una conversación'
			,'enlightn:notifyonnewmsg' => 'Has recibido un mensaje en tus conversaciones'

			,'enlightn:statistics' => 'Estadísticas'
			,'usersettings:statistics:yourdetails' => 'Tus infos'
			,'usersettings:statistics:label:name' => 'Nombre'
			,'usersettings:statistics:label:email' => 'email'
			,'usersettings:statistics:label:membersince' => 'Usuario desde'
			,'usersettings:statistics:label:lastlogin' => 'Último acceso'
			,'usersettings:statistics:label:numentities' => 'Tus participaciones'
			,'item:object:enlightnconversación' => 'Conversaciones creadas'
			,'item:object:file' => 'Tu cloud'
            ,'user:language:success' => 'Tus ajustes de lenguaje se han actualizado'

			//FOOTER
			,'expages:about' => 'Acerca de'
			,'expages:terms' => 'Términos y condiciones'
			,'expages:privacy' => 'Política'
			,'expages:help' => 'Ayuda'
			,'expages:FAQ' => 'FAQ'

			//DATES
			,'friendlytime:justnow' => "ahora"
			,'friendlytime:minutes' => "hace %s minutos"
			,'friendlytime:minutes:singular' => "hace uno minuto"
			,'friendlytime:hours' => "hace %s horas"
			,'friendlytime:hours:singular' => "hace una hora"
			,'friendlytime:days' => "hace %s días"
			,'friendlytime:days:singular' => "ayer"
			,'friendlytime:date_format' => 'j F Y à H:i'

			//LOG OUT
			,'logoutsucceed' => 'Hasta pronto'

            //MAIL
			//New message
			,'enlightn:newmessage:subject' => 'Re: %s '
			,'enlightn:newmessage:body' => 'Hola %s,

Se ha añadido un mensaje a la conversación "%s"
%s

<a href="%s">Entrar a la conversación</a>'

			//$follower (to)  $user (from)  $topic (title)  $url

			//Confirm email
			,'uservalidation:email:validate:subject' => '%s, por favor confirma tu email para poder entrar a %s'
			,'uservalidation:email:validate:body' => 'Hola %s,

Te acabas de registrar en %s.
Para acceder, por favor confirma tu dirección de email haciendo click en el link de abajo:

%s

Si no puedes hacer click en el link, cópialo y pégalo en tu navegador manualmente.

Nos vemos en %s,
El equipo Enlightn'

			//Email validated
			,'email:validate:success:subject' => 'Bienvenid@ a %s'
			,'email:validate:success:body' => 'Hola %s,

Tu cuenta ha sido creada en %s.

Nos vemos en %s,
El equipo Enlightn'

            //Invite
			,'enlightn:invite:subject' => '%s'
			,'enlightn:invite:body' => 'Hola %s,

%s te invita a unirte a la conversación <p><strong>"%s"</strong></p>

<p><a href="%s"><span class="tag">Únete a la  conversación</span></a></p>'

	);
	add_translation("es",$spain);
?>