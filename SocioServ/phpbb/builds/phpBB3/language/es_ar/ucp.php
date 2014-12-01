<?php
/** 
*
* ucp.php [Spanish [es_AR]]
*
* @package language
* @version $Id: $
* @copyright (c) 2007 phpBB Group 
* @author 2007-07-31 - Larveando Team (team@larveando.com.ar)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

/**
* DO NOT CHANGE
*/
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// TRANSLATORS NOTE FOR ES_AR LANGUAGE (by Larveando Team)
// There are some translation issues were taken having in mind a better user navigation experience. I.e:
// 'You' was translated as a coloquial 'Vos' instead a more serious 'Su'. Idem 'Your'. In general, a coloquial style was adopted.
// The board speaks in first person. 'Avatar could not be uploaded' was translated as 'No puedo subir el avatar', instead 'No se puede subir el avatar'
// Some common used expressions like Topic, Post (as context used), Ban, Cookies, FAQ, OnLine, Home, Login (as context used), logs etc 
// where _not_ translated in lack of a better common word to use.
// Board was translated 'Sitio' (Site) with uppercase in alussion to the entire system in lack of a better common word to use.
//

$lang = array_merge($lang, array(
	'TERMS_OF_USE_CONTENT'	=> 'Al ingresar a “%1$s” (de aquí en más “nosotros”, “nos”, “nuestro”, “%1$s”, “%2$s”), <strong>acuerdas</strong> estar legalmente sometido a los siguientes términos. Caso contrario por favor no ingreses y/o emplees “%1$s”. Podemos cambiar estos términos en cualquier momento y haremos nuestro mejor esfuerzo por avisarte, sin embargo seria prudente que los revises por tu cuenta periódicamente. Seguir ingresando a  “%1$s” después de esos cambios significa que <strong>acuerdas</strong> estar legalmente sometido a esos nuevos términos tal como fueron actualizados y/o reformados.<br />
	<br />
	Nuestros foros están potenciados por phpBB (de aquí en más “ellos”, “sus”, “software phpBB”, “www.phpbb.com”, “phpBB Group”, “phpBB Teams”) el cual es una solucion de tablón de anuncios liberada bajo la “<a href="http://www.gnu.org/licenses/gpl.html">Licencia Pública General (General Public License en inglés)</a>” (de aquí en más “GPL”) y puede ser bajada de <a href="http://www.phpbb.com/">www.phpbb.com</a>. El software phpBB solamente facilita discusiones basadas en Internet y la GPL estrictamente los excluye de lo que aprobamos y/o desaprobamos como conductas y/o contenido permisible. Para más información sobre phpBB, por favor ve a: <a href="http://www.phpbb.com/">http://www.phpbb.com/</a>.<br />
	<br />
	<strong>Acuerdas</strong> no enviar ningun contenido abusivo, obsceno, vulgar, difamatorio, insalubre, amenazante, sexualmente-orientado o cualquier otro material que pueda violar cualquier ley de tu país, el país donde “%1$s” está instalado o Leyes Internacionales. Hacer eso provocará que seas inmediata y permanentemente expulsado y, si lo creemos oportuno, con notificación a tu Proveedor de Servicios de Internet. Las direcciones IP de todos los envíos son registradas como ayuda para reforzar estas condiciones. <strong>Acuerdas</strong> que “%1$s” tiene derecho a remover, editar, mover o cerrar cualquier topic en cualquier momento que lo creamos conveniente. Como usuario <strong>acuerdas</strong> que cualquier información que hayas ingresado será almacenada en una base de datos. Dado que esta información no será compartida con ninguna tercer parte sin tu consentimiento, ni “%1$s” o phpBB podrán considerarse responsables por cualquier intento de hacking que conlleve a que los datos sean comprometidas
	',
	'PRIVACY_POLICY'	=> 'Esta política explica en detalle cómo “%1$s” junto con sus empresas asociadas (de aquí en mas “nosotros”, “nos”, “nuestro”, “%1$s”, “%2$s”) y phpBB (de aquí en más “ellos”, “sus”, “software phpBB”, “www.phpbb.com”, “phpBB Group”, “phpBB Teams”) emplean cualquier información obtenida durante cualquier sesión de uso por usted (de aquí en más “su información”).<br />
	<br />
	Su información es obtenida por dos vías. Primeramente, navegar “%1$s” hará al software phpBB crear un número de cookies, las cuales son un pequeño archivo de texto que se descargan en los archivos temporales del navegador de su computadora. Las primeras dos cookies sólo contienen un identificador de usuario (de aquí en más “user-id”) y un identificador de sesión anónima (de aquí en más “session-id”), automáticamente asignada a usted por el software phpBB. Una tercer cookie se creará una vez que haya navegado topics en “%1$s” y se emplea para registrar cuales han sido leídos, en orden de optimizar su experiencia de usuario.<br />
	<br />
	Además podemos crear cookies externas al software phpBB mientras navega “%1$s”, las cuales exceden el alcance de este documento que solamente se refiere a las páginas creadas por el software phpBB. La segunda vía mediante la que obtenemos su información es mediante lo que usted envía. Esto puede ser, y no limitado a: envíos como usuario anónimo (de aquí en más “envíos anonimos”), su registro en “%1$s” (de aquí en más “su cuenta”) y posts enviados por usted después de registrarse y mientras haya ingresado (de aquí en más “sus posts”).<br />
	<br />
	Su cuenta como mínimo constará de un nombre único de identificación (de aquí en más “su nombre de usuario”), una clave personal empleada para el ingreso (de aquí en más “su clave”) y una dirección de email personal válida (de aquí en más “su email”). La información de su cuenta en “%1$s” está protegida por las leyes de proteccion de datos aplicables en el país en el que estamos instalados. Cualquier información mas allá de su nombre de usuario, su clave y su email requerida por “%1$s” durante el proceso de registración está a nuestra disgresión qué es obligatorio y qué es opcional. En todos los casos, usted tiene la opción de qué información en su cuenta será publicamente exhibida. Además, en su cuenta, usted tiene la opcion de activar o desactivar los emails automáticamente generados por el software phpBB.<br />
	<br />
	Su clave está encriptada (cifrado de una vía) por lo tanto está segura. Sin embargo, se recomienda que no emplee la misma clave en diferentes websites. Su clave garantiza su acceso a su cuenta en “%1$s”, por favor guardela cuidadosamente y bajo ninguna circunstancia ningún asociado a “%1$s”, phpBB u otra tercer parte, legítimamente le preguntará su clave. Si olvidó su clave para su cuenta, puede usar el servicio “Olvidé mi clave” provisto por el software phpBB. Este proceso le solicitará enviar su nombre de usuario y su email, luego el software phpBB generará una nueva clave para recuperar su cuenta.<br />
	',
	'ACCOUNT_ACTIVE'	=> 'Tu cuenta ha sido activada. Gracias por registrarte',
	'ACCOUNT_ACTIVE_ADMIN'	=> 'La cuenta ha sido activada',
	'ACCOUNT_ADDED'	=> 'Gracias por registrarte, tu cuenta ha sido creada. Ahora podés ingresar con tu nombre de usuario y tu clave',
	'ACCOUNT_COPPA'	=> 'Tu cuenta ha sido creada pero no aprobada, por favor revisa tu email para más detalles.',
	'ACCOUNT_INACTIVE'	=> 'Tu cuenta ha sido creada. Sin embargo, este foro requiere activación de cuenta, una clave de activación ha sido enviada a la dirección de email que ingresaste. Por favor revisa tu email para más información',
	'ACCOUNT_INACTIVE_ADMIN'	=> 'Tu cuenta ha sido creada. Sin embargo, este foro requiere activación de cuenta por el administrador. Un email le ha sido enviado y se te informará cuando tu cuenta haya sido activada',
	'ACTIVATION_EMAIL_SENT'	=> 'El email de activación ha sido enviado a tu dirección de email',
	'ADD'	=> 'Agregar',
	'ADD_BCC'	=> 'Agregar [CCO]',
	'ADD_FOES'	=> 'Agregar nuevos indeseables',
	'ADD_FOES_EXPLAIN'	=> 'Podés ingresar varios nombres de usuario cada uno en una nueva línea',
	'ADD_FOLDER'	=> 'Agregar carpeta',
	'ADD_FRIENDS'	=> 'Agregar nuevos amigos',
	'ADD_FRIENDS_EXPLAIN'	=> 'Podés ingresar varios nombres de usuario cada uno en una nueva línea',
	'ADD_NEW_RULE'	=> 'Agregar nueva regla',
	'ADD_RULE'	=> 'Agregar regla',
	'ADD_TO'	=> 'Agregar [Para]',
	'ADMIN_EMAIL'	=> 'Administradores pueden informarme por email',
	'AGREE'	=> 'Estoy de acuerdo',
	'ALLOW_PM'	=> 'Permitir a los usuarios enviarte mensajes privados',
	'ALLOW_PM_EXPLAIN'	=> 'Nota que administradores y moderadores siempre podran enviarte mensajes.',
	'ALREADY_ACTIVATED'	=> 'Ya habías activado tu cuenta',
	'ATTACHMENTS_EXPLAIN'	=> 'Esta es un lista de adjuntos que has posteado a este foro.',
	'ATTACHMENTS_DELETED'	=> 'Adjuntos exitosamente borrados.',
	'ATTACHMENT_DELETED'	=> 'Adjunto exitosamente borrado.',
	'AVATAR_CATEGORY'	=> 'Categoría',
	'AVATAR_EXPLAIN'	=> 'Dimensiones máximas; ancho %1$d pixels, alto %2$d pixels, tamaño %3$dkB.',
	'AVATAR_GALLERY'	=> 'Galería local',
	'AVATAR_GENERAL_UPLOAD_ERROR'	=> 'No puedo subir avatar a %s',
	'AVATAR_PAGE'	=> 'Página',
	'BACK_TO_DRAFTS'	=> 'Volver a borradores guardados',
	'BACK_TO_LOGIN'	=> 'Volver a ingreso',
	'BIRTHDAY'	=> 'Cumpleaños',
	'BIRTHDAY_EXPLAIN'	=> 'Ingresar el año mostrará tu edad cuando sea tu cumpleaños.',
	'BOARD_DATE_FORMAT'	=> 'Mi formato de fecha',
	'BOARD_DATE_FORMAT_EXPLAIN'	=> 'La sintaxis usada es idéntica a la función <a href="http://www.php.net/date">date()</a> en PHP',
	'BOARD_DST'	=> 'Horario de Ahorro de Energía en uso',
	'BOARD_LANGUAGE'	=> 'Mi idioma',
	'BOARD_STYLE'	=> 'Mi estilo',
	'BOARD_TIMEZONE'	=> 'Mi zona horaria',
	'BOOKMARKS'	=> 'Señaladores',
	'BOOKMARKS_EXPLAIN'	=> 'Podés señalar topics para referencia futura. Selecciona el checkbox para el señalador que quieras borrar, luego click en el botón <em>Remover señaladores marcados</em>.',
	'BOOKMARKS_DISABLED'	=> 'Los señaladores están deshabilitados en este Sitio',
	'BOOKMARKS_REMOVED'	=> 'Señaladores removidos satisfactoriamente',
	'CANNOT_EDIT_MESSAGE_TIME'	=> 'Ya no podés editar o borrar este mensaje',
	'CANNOT_MOVE_TO_SAME_FOLDER'	=> 'Los mensajes no pueden ser movidos a la carpeta que querés borrar.',
	'CANNOT_RENAME_FOLDER'	=> 'Esta carpeta no puede ser renombrada.',
	'CANNOT_REMOVE_FOLDER'	=> 'Esta carpeta no puede ser removida.',
	'CHANGE_DEFAULT_GROUP'	=> 'Cambiar grupo por omisión',
	'CHANGE_PASSWORD'	=> 'Cambiar clave',
	'CLICK_RETURN_FOLDER'	=> '%1$sVolver a tu  carpeta de “%3$s” %2$s',
	'CONFIRMATION'	=> 'Confirmación de registración',
	'CONFIRM_CHANGES'	=> 'Confirmar cambios',
	'CONFIRM_EMAIL'	=> 'Confirmar dirección de email',
	'CONFIRM_EMAIL_EXPLAIN'	=> 'Necesitas especificar esto sólo si vas a cambiar tu dirección de email.',
	'CONFIRM_EXPLAIN'	=> 'Para prevenir registraciones automáticas el administrador del Sitio requiere que ingreses un código de confirmación. El código se muestra en la imagen que deberías ver debajo. Si estás visualmente impedido o no podés ver el código por favor contacta con el %sAdministrador del Sitior%s.',
	'CONFIRM_PASSWORD'	=> 'Confirmar clave',
	'CONFIRM_PASSWORD_EXPLAIN'	=> 'Necesitas confirmar tu clave sólo si la has cambiado arriba',
	'COPPA_BIRTHDAY'	=> 'Para continuar con el proceso de registración por favor decinos cuando naciste.',
	'COPPA_COMPLIANCE'	=> 'APPCO (COPPA en inglés) compliance',
	'COPPA_EXPLAIN'	=> 'Por favor nota que hacer click en Enviar creará tu cuenta. Sin embargo no podrá ser activada hasta que un padre o tutor apruebe tu registración. Se te enviará una copia por email del formulario necesario con detalles de cómo enviarlo.',
	'CREATE_FOLDER'	=> 'Agregar carpeta…',
	'CURRENT_IMAGE'	=> 'Imagen actual',
	'CURRENT_PASSWORD'	=> 'Clave actual',
	'CURRENT_PASSWORD_EXPLAIN'	=> 'Tenés que confirmar tu clave actual si querés cambiarla, alterar tu dirección de email o nombre de usuario.',
	'CUR_PASSWORD_ERROR'	=> 'La clave actual que ingresaste es incorrcta.',
	'CUSTOM_DATEFORMAT'	=> 'Personalizar…',
	'DEFAULT_ACTION'	=> 'Acción por omisión',
	'DEFAULT_ACTION_EXPLAIN'	=> 'Esta acción se activará si ninguna de las anteriores es aplicable',
	'DEFAULT_ADD_SIG'	=> 'Insertar mi firma por omisión',
	'DEFAULT_BBCODE'	=> 'Habilitar BBCode por omisión',
	'DEFAULT_NOTIFY'	=> 'Notificarme respuestas por omisión',
	'DEFAULT_SMILIES'	=> 'Habilitar smilies por omisión',
	'DEFINED_RULES'	=> 'Reglas definidas',
	'DELETED_TOPIC'	=> 'El topic ha sido removido',
	'DELETE_ATTACHMENT'	=> 'Borrar adjunto',
	'DELETE_ATTACHMENTS'	=> 'Borrar adjuntos',
	'DELETE_ATTACHMENT_CONFIRM'	=> '¿Estás seguro que querés borrar este adjunto?',
	'DELETE_ATTACHMENTS_CONFIRM'	=> '¿Estás seguro que querés borrar estos adjuntos?',
	'DELETE_AVATAR'	=> 'Borrar imagen',
	'DELETE_COOKIES_CONFIRM'	=> '¿Estás seguro que querés borrar todas las cookies de este Sitio?',
	'DELETE_MARKED_PM'	=> 'Borrar mensajes marcados',
	'DELETE_MARKED_PM_CONFIRM'	=> '¿Estás seguro que querés borrar todos los mensajes marcados?',
	'DELETE_OLDEST_MESSAGES'	=> 'Borrar mensajes viejos',
	'DELETE_MESSAGE'	=> 'Borrar mensaje',
	'DELETE_MESSAGE_CONFIRM'	=> '¿Estás seguro que querés borrar este mensaje privado?',
	'DELETE_MESSAGES_IN_FOLDER'	=> 'Borrar todos los mensajes en la carpeta removida',
	'DELETE_RULE'	=> 'Borrar regla',
	'DELETE_RULE_CONFIRM'	=> '¿Estás seguro que querés borrar esta regla?',
	'DEMOTE_SELECTED'	=> 'Demote Seleccionado',
	'DISABLE_CENSORS'	=> 'Habilitar palabras censuradas',
	'DISPLAY_GALLERY'	=> 'Mostrar galería',
	'DOMAIN_NO_MX_RECORD_EMAIL'	=> 'El dominio del email ingresado no tiene un registro MX válido.',
	'DOWNLOADS'	=> 'Descargas',
	'DRAFTS_DELETED'	=> 'Todos los borradores seleccionados fueron exitosamente borrados.',
	'DRAFTS_EXPLAIN'	=> 'Acá podés ver, editar o borrar tus borradores guardados.',
	'DRAFT_UPDATED'	=> 'Borrador exitosamente actualizado.',
	'EDIT_DRAFT_EXPLAIN'	=> 'Acá podrás editar tu borrador. Los borradores no contienen adjuntos ni encuestas.',
	'EMAIL_BANNED_EMAIL'	=> 'La dirección de email que ingresaste está excluida.',
	'EMAIL_INVALID_EMAIL'	=> 'La dirección de email que ingresaste es inválida.',
	'EMAIL_REMIND'	=> 'Esta debe ser la dirección de email que ingresaste al registrarte.',
	'EMAIL_TAKEN_EMAIL'	=> 'La dirección de email ingresada ya está en uso',
	'EMPTY_DRAFT'	=> 'Debes ingresar un mensaje para enviar los cambios',
	'EMPTY_DRAFT_TITLE'	=> 'Debés ingresar un título para el borrador',
	'EXPORT_AS_XML'	=> 'Exportar como XML',
	'EXPORT_AS_CSV'	=> 'Exportar como CSV',
	'EXPORT_AS_CSV_EXCEL'	=> 'Exportar como CSV (Excel)',
	'EXPORT_AS_TXT'	=> 'Exportar como TXT',
	'EXPORT_AS_MSG'	=> 'Exportar como MSG',
	'EXPORT_FOLDER'	=> 'Exportar folder',
	'FIELD_REQUIRED'	=> 'Debes completar el campo “%s”.',
	'FIELD_TOO_SHORT'	=> 'El campo “%1$s” es muy corto, se requiere un mínimo de %2$d caracteres.',
	'FIELD_TOO_LONG'	=> 'El campo “%1$s” es muy largo, se permite un máximo de %2$d caracteres.',
	'FIELD_TOO_SMALL'	=> 'El valor de “%1$s” es muy pequeño, se requiere un valor mínimo de %2$d.',
	'FIELD_TOO_LARGE'	=> 'El valor de “%1$s” es muy grande, se permite un valor máximo de %2$d.',
	'FIELD_INVALID_CHARS_NUMBERS_ONLY'	=> 'El campo “%s” tiene caracteres inválidos, se permiten sólo números.',
	'FIELD_INVALID_CHARS_ALPHA_ONLY'	=> 'El campo “%s” tiene caracteres inválidos, se permiten sólo caracteres alfanuméricos.',
	'FIELD_INVALID_CHARS_SPACERS_ONLY'	=> 'El campo “%s” tiene caracteres inválidos, se permiten sólo caracteres alfanuméricos, espacio ó -+_[].',
	'FIELD_INVALID_DATE'	=> 'El campo “%s” tiene una fecha inválida.',
	'FOE_MESSAGE'	=> 'Mensaje de un indeseable',
	'FOES_EXPLAIN'	=> 'Indeseables son usuarios que serán ignorados por omisión. Los posts de esos usuarios no serán visibles en su totalidad y no se permitirán mensajes personales. Por favor nota que no puedes ignorar moderadores o administradores.',
	'FOES_UPDATED'	=> 'Tu lista de indeseables ha sido actualizada exitosamente',
	'FOLDER_ADDED'	=> 'Carpeta agregada exitosamente',
	'FOLDER_MESSAGE_STATUS'	=> '%1$d de %2$d mensajes guardados',
	'FOLDER_NAME_EXIST'	=> 'La carpeta <strong>%s</strong> ya existe',
	'FOLDER_OPTIONS'	=> 'Opciones de carpeta',
	'FOLDER_RENAMED'	=> 'Carpeta exitosamente renombrada',
	'FOLDER_REMOVED'	=> 'Carpeta exitosamente removida',
	'FOLDER_STATUS_MSG'	=> 'La carpeta está %1$d%% llena (%2$d de %3$d mensajes guardados)',
	'FORWARD_PM'	=> 'Reenviar MP',
	'FORCE_PASSWORD_EXPLAIN'	=> 'Antes de continuar navegando el Sitio se requiere que cambies tu clave',
	'FRIEND_MESSAGE'	=> 'Mensaje de un amigo',
	'FRIENDS'	=> 'Amigos',
	'FRIENDS_EXPLAIN'	=> 'Amigos te permite rápido acceso a usuarios con los que te comunicas frecuentemente. Si la plantilla lo soporta, los posts hechos por amigos serán resaltados.',
	'FRIENDS_OFFLINE'	=> 'Desconectado',
	'FRIENDS_ONLINE'	=> 'Conectado',
	'FRIENDS_UPDATED'	=> 'Tu lista de amigos ha sido actualizado exitosamente',
	'FULL_FOLDER_OPTION_CHANGED'	=> 'La acción a tomar cuando una carpeta llena ha sido cambiada exitosamente',
	'FWD_ORIGINAL_MESSAGE'	=> '-------- Mensaje Original --------',
	'FWD_SUBJECT'	=> 'Tema: %s',
	'FWD_DATE'	=> 'Fecha: %s',
	'FWD_FROM'	=> 'De: %s',
	'FWD_TO'	=> 'Para: %s',
	'GLOBAL_ANNOUNCEMENT'	=> 'Anuncio global',
	'HIDE_ONLINE'	=> 'Ocultar mi status online',
	'HOLD_NEW_MESSAGES'	=> 'No aceptar nuevos mensajes (Nuevos mensajes aguardarán hasta que haya suficiente espacio disponible)',
	'HOLD_NEW_MESSAGES_SHORT'	=> 'Nuevos mensajes deberán aguardar',
	'IF_FOLDER_FULL'	=> 'Si la carpeta está llena',
	'IMPORTANT_NEWS'	=> 'Anuncios importantes',
	'INVALID_CHARS_USERNAME'	=> 'El nombre de usuario contiene caracteres prohibidos.',
	'INVALID_CHARS_NEW_PASSWORD'	=> 'La clave no contiene los caracteres requeridos.',
	'ITEMS_REQUIRED'	=> 'Los ítems marcados con * son campos requeridos del perfil y deben ser completados',
	'JOIN_SELECTED'	=> 'Ingresar seleccionados',
	'LANGUAGE'	=> 'Idioma',
	'LINK_REMOTE_AVATAR'	=> 'Enlace externo',
	'LINK_REMOTE_AVATAR_EXPLAIN'	=> 'Ingresa la URL del sitio que contiene la imagen del avatar que deseas enlazar.',
	'LINK_REMOTE_SIZE'	=> 'Dimensiones de avatar',
	'LINK_REMOTE_SIZE_EXPLAIN'	=> 'Especifica el ancho y alto del avatar, dejalo en blanco para intentar una verificación automática.',
	'LOGIN_EXPLAIN_UCP'	=> 'Por favor ingresa para acceder al Panel de Control de Usuario',
	'LOGIN_REDIRECT'	=> 'Ingresaste exitosamente.',
	'LOGOUT_REDIRECT'	=> 'Saliste exitosamente.',
	'MARK_IMPORTANT'	=> 'Marcar como importante',
	'MARKED_MESSAGE'	=> 'Mensaje marcado',
	'MAX_FOLDER_REACHED'	=> 'Alcanzado el número máximo carpetas definidas por el usuario permitido',
	'MESSAGE_BY_AUTHOR'	=> 'por',
	'MESSAGE_COLOURS'	=> 'Colores de mensaje',
	'MESSAGE_DELETED'	=> 'Mensaje borrado exitosamente',
	'MESSAGE_HISTORY'	=> 'Historial de mensajes',
	'MESSAGE_REMOVED_FROM_OUTBOX'	=> 'Este mensaje ha sido removido por su autor antes de ser despachado',
	'MESSAGE_SENT_ON'	=> 'en',
	'MESSAGE_STORED'	=> 'Este mensaje ha sido enviado exitosamente',
	'MESSAGE_TO'	=> 'Para',
	'MESSAGES_DELETED'	=> 'Mensajes borrados exitosamente',
	'MOVE_DELETED_MESSAGES_TO'	=> 'Mover mensajes de la carpeta removida a',
	'MOVE_DOWN'	=> 'Bajar',
	'MOVE_MARKED_TO_FOLDER'	=> 'Mover marcados a %s',
	'MOVE_PM_ERROR'	=> 'Ha ocurrido un error mientras movía los mensajes a la carpeta nueva, sólo %1d de %2d mensajes fueron movidos.',
	'MOVE_TO_FOLDER'	=> 'Mover a carpeta',
	'MOVE_UP'	=> 'Subir',
	'NEW_EMAIL_ERROR'	=> 'La dirección de email que ingresaste no coincide.',
	'NEW_FOLDER_NAME'	=> 'Nuevo nombre',
	'NEW_PASSWORD'	=> 'Nueva clave',
	'NEW_PASSWORD_ERROR'	=> 'Las claves que ingresaste no coinciden.',
	'NOTIFY_METHOD'	=> 'Método de notificación',
	'NOTIFY_METHOD_BOTH'	=> 'Ambos',
	'NOTIFY_METHOD_EMAIL'	=> 'Sólo email',
	'NOTIFY_METHOD_EXPLAIN'	=> 'Método para enviar mensajes empleado por este Sitio.',
	'NOTIFY_METHOD_IM'	=> 'Sólo Jabber',
	'NOTIFY_ON_PM'	=> 'Notificarme de nuevos mensajes privados',
	'NOT_ADDED_FRIENDS_ANONYMOUS'	=> 'No podés agregar usuarios anónimos a tu lista de amigos.',
	'NOT_ADDED_FRIENDS_FOES'	=> 'No podés agregar usuarios a tu lista de amigos mientras estén en tu lista de enemigos',
	'NOT_ADDED_FRIENDS_SELF'	=> 'No podés agregarte a tu lista de amigos',
	'NOT_ADDED_FOES_MOD_ADMIN'	=> 'No podés agregar administradores y moderadores a tu lista de enemigos.',
	'NOT_ADDED_FOES_ANONYMOUS'	=> 'No podés agregar usuarios anónimos a tu lista de enemigos.',
	'NOT_ADDED_FOES_FRIENDS'	=> 'No podés agregar usuarios a tu lista de enemigos mientras estén en tu lista de amigos.',
	'NOT_ADDED_FOES_SELF'	=> 'No podés agregarte a tu lista de enemigos.',
	'NOT_AGREE'	=> 'No estoy de acuerdo',
	'NOT_ENOUGH_SPACE_FOLDER'	=> 'La carpeta de destino “%s” parece estar llena. La acción requerida no se ha realizado.',
	'NOT_MOVED_MESSAGE'	=> 'Tenés 1 mensaje privado actualmente en espera porque tu carpeta está llena.',
	'NOT_MOVED_MESSAGES'	=> 'Tenés %d mensajes privados actualmente en espera porque tu carpeta está llena.',
	'NO_ACTION_MODE'	=> 'No se especificó una acción.',
	'NO_AUTHOR'	=> 'No se definió un autor para este mensaje',
	'NO_AVATAR_CATEGORY'	=> 'Ninguno',
	'NO_AUTH_DELETE_MESSAGE'	=> 'No estás autorizado a borrar mensajes privados.',
	'NO_AUTH_EDIT_MESSAGE'	=> 'No estás autorizado a editar mensajes privados.',
	'NO_AUTH_FORWARD_MESSAGE'	=> 'No estás autorizado a reenviar mensajes privados.',
	'NO_AUTH_GROUP_MESSAGE'	=> 'No estás autorizado a enviar mensajes privados a grupos.',
	'NO_AUTH_READ_MESSAGE'	=> 'No estás autorizado a leer mensajes privados.',
	'NO_AUTH_READ_REMOVED_MESSAGE'	=> 'No podés leer este mensaje porque fué removido por el autor.',
	'NO_AUTH_SEND_MESSAGE'	=> 'No estás autorizado a enviar mensajes privados.',
	'NO_AUTH_SIGNATURE'	=> 'No estás autorizado a definir una firma',
	'NO_BCC_RECIPIENT'	=> 'Ninguno',
	'NO_BOOKMARKS'	=> 'No tenés señaladores',
	'NO_BOOKMARKS_SELECTED'	=> 'No has seleccionado señaladores',
	'NO_EMAIL_USER'	=> 'No puedo encontrar al email/usuario enviado',
	'NO_FOES'	=> 'No hay enemigos definidos actualmente',
	'NO_FRIENDS'	=> 'No hay enemigos definidos actualmente',
	'NO_FRIENDS_OFFLINE'	=> 'No hay amigos desconectados',
	'NO_FRIENDS_ONLINE'	=> 'No hay amigos conectados',
	'NO_GROUP_SELECTED'	=> 'No se ha especificado un grupo',
	'NO_IMPORTANT_NEWS'	=> 'No hay anuncion importantes',
	'NO_MESSAGE'	=> 'No puedo encontrar un mensaje privado',
	'NO_NEW_FOLDER_NAME'	=> 'Debes especificar un nombre para la carpeta',
	'NO_NEWER_PM'	=> 'No hay mensajes nuevos',
	'NO_OLDER_PM'	=> 'No hay mensajes viejoss',
	'NO_RECIPIENT'	=> 'No se definió un destinatario',
	'NO_RULES_DEFINED'	=> 'No se definieron reglas',
	'NO_SAVED_DRAFTS'	=> 'No se guardaron borradores',
	'NO_TO_RECIPIENT'	=> 'Ninguno',
	'NO_WATCHED_FORUMS'	=> 'No estás monitoreando ningun Foro.',
	'NO_WATCHED_TOPICS'	=> 'No estás monitoreando ningun topic.',
	'PASS_TYPE_ALPHA_EXPLAIN'	=> 'Las claves deben tener entre %1$d y %2$d caracteres de longitud y deben ser alfanuméricos',
	'PASS_TYPE_ANY_EXPLAIN'	=> 'Debe tener entre %1$d y %2$d caracteres.',
	'PASS_TYPE_CASE_EXPLAIN'	=> 'Las claves deben tener entre %1$d y %2$d caracteres de longitud y mezclar mayúsculas y minúsculas',
	'PASS_TYPE_SYMBOL_EXPLAIN'	=> 'Las claves deben tener entre %1$d y %2$d caracteres de longitud y deben contener símbolos',
	'PASSWORD'	=> 'Clave',
	'PASSWORD_ACTIVATED'	=> 'Tu nueva clave ha sido activada',
	'PASSWORD_UPDATED'	=> 'TTTtu nueva clave ha sido enviada exitosamente a tu dirección de email.',
	'PERMISSIONS_RESTORED'	=> 'Permisos originales restaurados exitosamente.',
	'PERMISSIONS_TRANSFERRED'	=> 'Permisos de <strong>%s</strong> transferidos exitosamente, ahora podés navegar el foro con los permisos de ese usuario.<br />Por favor nota que los permisos administrativos no han sido transferidos. Podés volver a tus permisos anteriores en cualquier momento.',
	'PM_DISABLED'	=> 'Los mensajes privados han sido deshabilitados en este Sitio',
	'PM_FROM'	=> 'De',
	'PM_FROM_REMOVED_AUTHOR'	=> 'Este mensaje fué enviado por un usuario que ya no está registrado.',
	'PM_ICON'	=> 'Icono',
	'PM_INBOX'	=> 'Entrada',
	'PM_OUTBOX'	=> 'Salida',
	'PM_SENTBOX'	=> 'Mensajes enviados',
	'PM_SUBJECT'	=> 'Tema del mensaje',
	'PM_TO'	=> 'Enviado a',
	'POPUP_ON_PM'	=> 'Ver nuevos mensajes privados en un pop-up',
	'POST_EDIT_PM'	=> 'Editar mensaje',
	'POST_FORWARD_PM'	=> 'Reenviar mensaje',
	'POST_NEW_PM'	=> 'Enviar mensaje',
	'POST_PM_LOCKED'	=> 'El mensaje privado está bloqueado',
	'POST_PM_POST'	=> 'Citar post',
	'POST_QUOTE_PM'	=> 'Citar mensaje',
	'POST_REPLY_PM'	=> 'Responder mensaje',
	'PRINT_PM'	=> 'Vista de impresión',
	'PREFERENCES_UPDATED'	=> 'Tus preferencias han sido actualizadas.',
	'PROFILE_INFO_NOTICE'	=> 'Por favor nota que esta información será vista por otros usuarios. Sé cuidadoso cuando incluyas detalles personales. Campos marcados con * deben completarse.',
	'PROFILE_UPDATED'	=> 'Tu perfil ha sido actualizado.',
	'RECIPIENT'	=> 'Destinatario',
	'RECIPIENTS'	=> 'Destinatarios',
	'REGISTRATION'	=> 'Registración',
	'RELATIVE_DAYS'	=> 'Dias relativos',
	'RELEASE_MESSAGES'	=> '%sEnviar todos los mensajes en espera%s… serán reordenados en sus carpetas corerespondientes si hay suficiente espacio disponible.',
	'REMOVE_ADDRESS'	=> 'Remover dirección',
	'REMOVE_SELECTED_BOOKMARKS'	=> 'Remover señaladores seleccionados',
	'REMOVE_SELECTED_BOOKMARKS_CONFIRM'	=> '¿Estás seguro que querés borrar todos los señaladores seleccionados?',
	'REMOVE_BOOKMARK_MARKED'	=> 'Remover señaladores marcados',
	'REMOVE_FOLDER'	=> 'Remover carpeta',
	'REMOVE_FOLDER_CONFIRM'	=> '¿Estás seguro que querés remover esta carpeta?',
	'RENAME'	=> 'Renombrar',
	'RENAME_FOLDER'	=> 'Renombrar carpeta',
	'REPLIED_MESSAGE'	=> 'Mensaje respondido a',
	'RESIGN_SELECTED'	=> 'Renunciar seleccionados',
	'RETURN_FOLDER'	=> '%1$sVolver a carpeta previa%2$s',
	'RETURN_UCP'	=> '%sVolver a Panel de Control de Usuario%s',
	'RULE_ADDED'	=> 'Regla agregada exitosamente',
	'RULE_ALREADY_DEFINED'	=> 'Esta regla fué definida previamente',
	'RULE_DELETED'	=> 'Regla removida exitosamente',
	'RULE_NOT_DEFINED'	=> 'Regla no especificada correctamente',
	'RULE_REMOVED_MESSAGE'	=> 'Un mensaje privado ha sido removido debido a los filtros.',
	'RULE_REMOVED_MESSAGES'	=> '%d mensajes privados han sido removidos debido a los filtros.',
	'SAME_PASSWORD_ERROR'	=> 'La nueva clave que has ingresado es la misma que tu clave actual',
	'SEARCH_YOUR_POSTS'	=> 'Mostrar tus posts',
	'SEND_PASSWORD'	=> 'Enviar clave',
	'SENT_AT'	=> 'Enviado a',
	'SHOW_EMAIL'	=> 'Los usuarios pueden contactarme por email',
	'SIGNATURE_EXPLAIN'	=> 'Este es un bloque de texto que puede agregarse a tus posts. Hay un límite de %d caracteres',
	'SIGNATURE_PREVIEW'	=> 'Tu firma se verá así',
	'SIGNATURE_TOO_LONG'	=> 'Tu firma es muy larga.',
	'SORT'	=> 'Ordenar',
	'SORT_COMMENT'	=> 'Comentario',
	'SORT_DOWNLOADS'	=> 'Descargas',
	'SORT_EXTENSION'	=> 'Extensión',
	'SORT_FILENAME'	=> 'Nombre',
	'SORT_POST_TIME'	=> 'Fecha',
	'SORT_SIZE'	=> 'Tamaño',
	'TIMEZONE'	=> 'Zona de tiempo',
	'TO'	=> 'Para',
	'TOO_MANY_RECIPIENTS'	=> 'Demasiados destinatarios',
	'TOO_MANY_REGISTERS'	=> 'Has excedido el número máximo de intentos de registración para esta sesión. Por favor intenta mas tarde.',
	'UCP'	=> 'Panel de Control de Usuario',
	'UCP_ACTIVATE'	=> 'Activar cuenta',
	'UCP_ADMIN_ACTIVATE'	=> 'Por favor nota que necesitas ingresar una dirección de email válida antes que tu cuenta sea activada. El administrador revisará tu cuenta y si la aprueba recibirás un email en la direccion que ingresaste.',
	'UCP_AIM'	=> 'AOL Instant Messenger',
	'UCP_ATTACHMENTS'	=> 'Adjuntos',
	'UCP_COPPA_BEFORE'	=> 'Antes %s',
	'UCP_COPPA_ON_AFTER'	=> 'O después %s',
	'UCP_EMAIL_ACTIVATE'	=> 'Por favor nota que necesitas ingresar una dirección de email válida antes que tu cuenta sea activada. Recibirás un email en la direccion que ingresaste que contiene un enlace para la activación de la cuenta.',
	'UCP_ICQ'	=> 'Número de ICQ',
	'UCP_JABBER'	=> 'Dirección Jabber',
	'UCP_MAIN'	=> 'Principal',
	'UCP_MAIN_ATTACHMENTS'	=> 'Organizar adjuntos',
	'UCP_MAIN_BOOKMARKS'	=> 'Organizar señaladores',
	'UCP_MAIN_DRAFTS'	=> 'Organizar borradores',
	'UCP_MAIN_FRONT'	=> 'Página principal',
	'UCP_MAIN_SUBSCRIBED'	=> 'Organizar suscripciones',
	'UCP_MSNM'	=> 'MSN Messenger',
	'UCP_NO_ATTACHMENTS'	=> 'No has enviado adjuntos',
	'UCP_PREFS'	=> 'Preferencias de Foros',
	'UCP_PREFS_PERSONAL'	=> 'Editar pref. personales',
	'UCP_PREFS_POST'	=> 'Editar pref. de posts',
	'UCP_PREFS_VIEW'	=> 'Editar pref. de visualización',
	'UCP_PM'	=> 'Mensajes privados',
	'UCP_PM_COMPOSE'	=> 'Escribir mensaje',
	'UCP_PM_DRAFTS'	=> 'Organizar borradores',
	'UCP_PM_OPTIONS'	=> 'Editar opciones',
	'UCP_PM_POPUP'	=> 'Mensajes privados',
	'UCP_PM_POPUP_TITLE'	=> 'Titulo MP pop-up',
	'UCP_PM_UNREAD'	=> 'Mensajes sin leer',
	'UCP_PM_VIEW'	=> 'Ver mensajes',
	'UCP_PROFILE'	=> 'Perfil',
	'UCP_PROFILE_AVATAR'	=> 'Editar avatar',
	'UCP_PROFILE_PROFILE_INFO'	=> 'Editar perfil',
	'UCP_PROFILE_REG_DETAILS'	=> 'Editar opciones de cuenta',
	'UCP_PROFILE_SIGNATURE'	=> 'Editar firma',
	'UCP_USERGROUPS'	=> 'Grupos de Usuarios',
	'UCP_USERGROUPS_MEMBER'	=> 'Editar miembros',
	'UCP_USERGROUPS_MANAGE'	=> 'Administrar grupos',
	'UCP_REGISTER_DISABLE'	=> 'Crear una nueva cuenta no es posible actualmente.',
	'UCP_REMIND'	=> 'Enviar clave',
	'UCP_RESEND'	=> 'Enviar email de activación',
	'UCP_WELCOME'	=> 'Bienvenido al Panel de Control de Usuario. Desde aquí podés observar, ver y actualizar tu perfil, preferencias, suscripción a foros y topics. Tambien podés enviar mensajes a otros usuarios (si está permitido). Por favor asegúrate que has leído todos los anuncios antes de continuar.',
	'UCP_YIM'	=> 'Yahoo Messenger',
	'UCP_ZEBRA'	=> 'Amigos &amp; Enemigos',
	'UCP_ZEBRA_FOES'	=> 'Organizar enemigos',
	'UCP_ZEBRA_FRIENDS'	=> 'Organizar amigos',
	'UNKNOWN_FOLDER'	=> 'Carpeta desconocida',
	'UNWATCH_MARKED'	=> 'Desuscribir marcados',
	'UPLOAD_AVATAR_FILE'	=> 'Subir de tu máquina',
	'UPLOAD_AVATAR_URL'	=> 'Subir de una URL',
	'UPLOAD_AVATAR_URL_EXPLAIN'	=> 'Ingresa la URL del sitio que tiene la imágen, será copiada a este sitio.',
	'USERNAME_ALPHA_ONLY_EXPLAIN'	=> 'El nombre de usuario debe tener entre %1$d y %2$d caracteres de longitud y ser solamente alfanuméricos',
	'USERNAME_ALPHA_SPACERS_EXPLAIN'	=> 'El nombre de usuario debe tener entre %1$d y %2$d caracteres de longitud y ser solamente alfanuméricos, espacio o -+_[].',
	'USERNAME_ASCII_EXPLAIN'	=> 'El nombre de usuario debe tener entre %1$d y %2$d caracteres de longitud y ser solamente ASCII, sin símbolos especiales',
	'USERNAME_LETTER_NUM_EXPLAIN'	=> 'El nombre de usuario debe tener entre %1$d y %2$d caracteres de longitud y ser solamente letras o números',
	'USERNAME_LETTER_NUM_SPACERS_EXPLAIN'	=> 'El nombre de usuario debe tener entre %1$d y %2$d caracteres de longitud y ser solamente letras, números, espacio o -+_[].',
	'USERNAME_CHARS_ANY_EXPLAIN'	=> 'La longitud debe ser entre %1$d y %2$d caracteres.',
	'USERNAME_TAKEN_USERNAME'	=> 'El nombre de usuario que ingresaste ya está en uso, por favor elige otro.',
	'USERNAME_DISALLOWED_USERNAME'	=> 'El nombre de usuario que ingresaste ha sido excluido.',
	'USER_NOT_FOUND_OR_INACTIVE'	=> 'No puedo encontrar a ese usuario, o aún no ha sido activado.',
	'VIEW_AVATARS'	=> 'Mostrar avatares',
	'VIEW_EDIT'	=> 'Ver/Editar',
	'VIEW_FLASH'	=> 'Mostrar animaciones Flash',
	'VIEW_IMAGES'	=> 'Mostrar imágenes en los posts',
	'VIEW_NEXT_HISTORY'	=> 'Siguiente MP en historial',
	'VIEW_NEXT_PM'	=> 'Siguiente MP',
	'VIEW_PM'	=> 'Ver mensaje',
	'VIEW_PM_INFO'	=> 'Detalles',
	'VIEW_PM_MESSAGE'	=> '1 mensaje',
	'VIEW_PM_MESSAGES'	=> '%d mensajes',
	'VIEW_PREVIOUS_HISTORY'	=> 'MP previo en historial',
	'VIEW_PREVIOUS_PM'	=> 'MP previo ',
	'VIEW_SIGS'	=> 'Mostrar firmas',
	'VIEW_SMILIES'	=> 'Mostrar smiles como imágenes',
	'VIEW_TOPICS_DAYS'	=> 'Mostrar topics de días previos',
	'VIEW_TOPICS_DIR'	=> 'Mostrar ordenamiento de topics',
	'VIEW_TOPICS_KEY'	=> 'Mostrar topics ordenados por',
	'VIEW_POSTS_DAYS'	=> 'Mostrar posts de días previos',
	'VIEW_POSTS_DIR'	=> 'Mostrar ordenamiento de posts',
	'VIEW_POSTS_KEY'	=> 'Mostrar posts ordenados por',
	'WATCHED_EXPLAIN'	=> 'Debajo está la lista de foros y topics a los que estás suscripto. Serás notificado de nuevos posts en ellos. Para desuscribir marca el foro o topic y luego click en el botón <em>Desuscribir marcados</em>.',
	'WATCHED_FORUMS'	=> 'Foros suscriptos',
	'WATCHED_TOPICS'	=> 'Topics suscriptos',
	'WRONG_ACTIVATION'	=> 'La clave de activación proporcionada no coincide con ninguna en la base de datos',
	'YOUR_DETAILS'	=> 'Tu actividad',
	'YOUR_FOES'	=> 'Tus enemigos',
	'YOUR_FOES_EXPLAIN'	=> 'Para remover nombres de usuarios seleccionalos y luego haz click en Enviar',
	'YOUR_FRIENDS'	=> 'Tus amigos',
	'YOUR_FRIENDS_EXPLAIN'	=> 'Para remover nombres de usuarios seleccionalos y luego haz click en Enviar',
	'YOUR_WARNINGS'	=> 'Tus advertencias',

	'PM_ACTION'	=> array(
		'PLACE_INTO_FOLDER'	=> 'Poner en carpeta',
		'MARK_AS_READ'	=> 'Marcar como leído',
		'MARK_AS_IMPORTANT'	=> 'Marcar mensaje',
		'DELETE_MESSAGE'	=> 'Borrar mensaje',
	),


	'PM_CHECK'	=> array(
		'SUBJECT'	=> 'Tema',
		'SENDER'	=> 'Remitente',
		'MESSAGE'	=> 'Mensaje',
		'STATUS'	=> 'Estado',
		'TO'	=> 'Enviar a',
	),


	'PM_RULE'	=> array(
		'IS_LIKE'	=> 'contiene',
		'IS_NOT_LIKE'	=> 'no contiene',
		'IS'	=> 'es',
		'IS_NOT'	=> 'no es',
		'BEGINS_WITH'	=> 'comienza con',
		'ENDS_WITH'	=> 'termina con',
		'IS_FRIEND'	=> 'es amigo',
		'IS_FOE'	=> 'es enemigo',
		'IS_USER'	=> 'es usuario',
		'IS_GROUP'	=> 'está en grupo',
		'ANSWERED'	=> 'respondido',
		'FORWARDED'	=> 'reenviado',
		'TO_GROUP'	=> 'a mi grupo por omisión',
		'TO_ME'	=> 'a mi',
	),

	'GROUPS_EXPLAIN'	=> 'Los Grupos permiten a los administradores manejar mejor a los usuarios. Por omisión estarás en un grupo específico, este es tu grupo por omisión. Este grupo define como te ven los otros usuarios, por ejemplo color del nombre, avatar, rango, etc. Dependiendo de lo que el administrador permita podrás cambiar cambiar tu grupo por omisión. Tambien podras ser situado o permitirte ingresar a otros grupos. Algunos grupos pueden otorgarte derechos extra para ver contenido o aumentar tus capacidades en otras áreas.',
	'GROUP_LEADER'	=> 'Líderes',
	'GROUP_MEMBER'	=> 'Miembros',
	'GROUP_PENDING'	=> 'Membrecías pendientes',
	'GROUP_NONMEMBER'	=> 'No-miembros',
	'GROUP_DETAILS'	=> 'Detalles del Grupo',
	'NO_LEADER'	=> 'Sin líder',
	'NO_MEMBER'	=> 'Sin miembros',
	'NO_PENDING'	=> 'Sin membrecías pendientes',
	'NO_NONMEMBER'	=> 'Sin grupo de no-miembros',
	'ACCOUNT_ACTIVE_PROFILE'	=> 'Tu cuenta ha sido reactivada exitosamente.',
	'ACCOUNT_EMAIL_CHANGED'	=> 'Tu cuenta ha sido actualizada. Sin embargo, este Sitio requiere reactivación de cuenta si cambiás tu email. Una clave de activación se ha enviado a tu nueva dirección de email. Por favor verificá tu email para más información.',
	'ACCOUNT_EMAIL_CHANGED_ADMIN'	=> 'Tu cuenta ha sido actualizada. Sin embargo, este Sitio requiere reactivación de cuenta por los administradores si cambiás tu email. Se les ha notificado y te informarán cuando tu cuenta haya sido reactivada.',
	'AVATAR_FEATURES_DISABLED'	=> 'Los avatares están actualmente deshabilitados.',
	'LOGOUT_FAILED'	=> 'No has salido, porque la solicitud no coincide con tu sesión. Por favor contactá con el administrador del Sitio si seguís teniendo problemas.',
	'NO_PASSWORD_SUPPLIED'	=> 'No podés ingresar sin una clave.',
	'PM_NO_USERS'	=> 'Los usuarios solicitados para agregar no existen.',
	'PM_USERS_REMOVED_NO_PM'	=> 'Algunos usuarios no pueden ser agregados porque no quieren recibir mensajes privados.',
	'HIDE_ONLINE_EXPLAIN'		=> 'Cambiar este parámetro a "No" no tendrá efecto hasta tu próxima visita al Sitio.',
	'CANNOT_MOVE_FROM_SPECIAL'	=> 'Los mensajes no pueden ser movidos de la bandeja de salida.',
	'NO_EDIT_READ_MESSAGE'		=> 'El mensaje privado no puede ser editado porque ya ha sido leidos.',
));

?>
