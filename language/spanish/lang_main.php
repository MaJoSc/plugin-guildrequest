<?PHP
/********************************************\
* Guildrequest Plugin for EQdkp plus         *
* ------------------------------------------ *
* Project Start: 01/2009                     *
* Author: BadTwin                            *
* Copyright: Andreas (BadTwin) Schrottenbaum *
* Link: http://eqdkp-plus.com                *
* Version: 0.0.2                             *
\********************************************/

global $eqdkp;
$lang['guildrequest']                     = 'Solicitudes de Hermandad';
$lang['request'] 						  = 'Petición';
$lang['gr_short_desc']                    = 'Plugin de Reclutamiento';
$lang['gr_long_desc']                     = 'Un plugin para el reclutamiento';

// Userdaten für den Gastuser
$lang['gr_user_aspirant']                 = 'Aspirante';
$lang['gr_user_email']                    = 'Perfil del invitado para el plugin de Solicitudes de Hermandad';

//Editor
$lang['editor_language']	= 'es';

// Admin Menu
$lang['gr_manage']												= 'administrar';
$lang['gr_view']                          = 'Ver Peticiones';
$lang['gr_write']                         = 'Escribir petición';

// Bewerbung erstellen
$lang['gr_write_headline']                = 'Escribir petición';
$lang['gr_write_incorrect_mail']          = 'Has introducido una dirección de correo inválida';
$lang['gr_write_allfields']               = '¡Hay que rellenar todos los campos!';
$lang['gr_write_sendrequest']             = 'enviar petición';
$lang['gr_write_reset']                   = 'resetear';
$lang['gr_write_error']                   = 'Error';
$lang['gl_write_succ']                    = 'Correo enviado';
$lang['gr_mailsent']                      = 'Por favor, confirma tu Petición haciendo click en el enlace que encontrarás en el correo.';
$lang['gr_mail_topic']                    = 'Confirma tu petición en '.preg_replace("'", "\'", $eqdkp->config['guildtag']);
$lang['gr_mail_text1']                    = 'Por favor, confirma tu petición haciendo click en el siguiente enlace:';
$lang['gr_mail_text2']                    = '¡Esperamos que tengas un buen día! El Líder de la Hermandad.';
$lang['gr_username_f']                    = 'usuario:';
$lang['gr_email_f']                       = 'correo:';
$lang['gr_password_f']                    = 'contraseña:';
$lang['gr_text_f']                        = 'texto:';
$lang['gr_settings']                      = 'Ajustes';
$lang['gr_user_double']                   = 'Un usuario con el mismo nombre ha enviado ya una petición. Por favor, elige otro nombre.';
$lang['gr_welcome_text']                  = 'Gracias por tu interés en '.preg_replace("'", "\'", $eqdkp->config['guildtag']).'. Por favor, escribe la petición abajo:';

// Bestätigung
$lang['gr_activate_succ']                 = '¡Tu petición se ha enviado!';

// Login
$lang['gr_login_headline']                = 'Petición - Inicio de Sesión';
$lang['gr_login_succ']                    = 'Inicio de sesión correcto';
$lang['gr_login_not_activated']           = 'No has confirmado el correo de registro.';
$lang['gr_login_wrong']                   = 'Nombre de usuario o contraseña incorrecto.';
$lang['gr_login_empty']                   = '¡Por favor, rellena todos los campos!';
$lang['gr_login_submit']                  = 'login';
$lang['gr_login_reset']                   = 'resetear';
$lang['gr_showrequest_headline']          = 'Petición: ';
$lang['gr_answer_f']                      = 'Respuesta:';
$lang['gr_closed_headline']               = 'La petición se ha cerrado.';

// Member-Ansicht
$lang['gr_vr_not_voted']                  = '¡No has votado aun!';
$lang['gr_vr_voted']                      = '¡Tu voto ha sido aceptado!';
$lang['gr_goback']                        = 'atrás';
$lang['gr_poll_headline']                 = '¿Debería invitarse al candidato a la hermandad';
$lang['gr_poll_yes']                      = 'Si';
$lang['gr_poll_no']                       = 'No';
  // Admin-Ansicht
  $lang['gr_poll_ad_opened']              = 'Abierta';
  $lang['gr_poll_ad_closed']              = 'Cerrada';
  $lang['gr_poll_ad_save']                = 'Guardada';
  $lang['gr_ad_adminonly']                = 'peticiones cerradas - sólo los administradores pueden ver:';
  $lang['gr_ad_delete']                   = 'borrar';
  $lang['gr_ad_activate']                 = 'activar';
  $lang['gr_not_activated']               = 'Peticiones no actiadas:';
  $lang['gr_no_requests']                 = 'No hay peticiones existentes.';
  // Info-Boxen
  $lang['gr_vr_ad_opened_f']              = 'Abierta';
  $lang['gr_vr_ad_opened']                = 'La petición ha sido abierta';
  $lang['gr_vr_ad_closed_f']              = 'Cerrada';
  $lang['gr_vr_ad_closed']                = 'La petición ha sido cerrada';
  $lang['gr_vr_ad_activated_f']           = 'Activada';
  $lang['gr_vr_ad_activated']             = 'La petición ha sido activada';
  $lang['gr_vr_ad_deleted_f']             = 'Borrada';
  $lang['gr_vr_ad_deleted']               = 'La petición ha sido borrada';


// Administrationsbereich
$lang['gr_ad_config_headline']            = 'Peticiones - Ajustes';
$lang['gr_ad_poll_activated']             = 'Encuestas activadas';
$lang['gr_ad_headline_f']                 = 'texto de bienvenida:';
$lang['gr_ad_mail1_f']                    = 'primera parte del correo de registro:';
$lang['gr_ad_mail2_f']                    = 'segunda parte del correo de registro:';
$lang['gr_ad_update_succ']                = '¡los ajustes se han guardado!';
$lang['gr_ad_update_succ_hl']             = '¡Éxito!';

// Portal Module
$lang['gr_pm_one_not_voted']              = 'Hay una petición esperando tu voto.';
$lang['gr_pm_not_voted_1']                = '¡Hay ';
$lang['gr_pm_not_voted_2']                = ' peticiones esperando tus votos!';

$lang['gr_pu_new_query']                  = 'Nueva petición: ';




$lang['gr_form_manage']                   = 'Editar Formulario';
$lang['gr_ad_form_singletext']            = 'Texto único';
$lang['gr_ad_form_textfield']             = 'Campo de texto';
$lang['gr_ad_form_dropdown']              = 'Desplegable';
$lang['gr_ad_fieldname_f']                = 'Nombre del campo';
$lang['gr_ad_fieldtype_f']                = 'Tipo de campo';
$lang['gr_ad_requiredfield_f']            = 'Requerido';
$lang['gr_ad_editdropdown']               = 'Editar Opciones';
$lang['gr_ad_editoptions']                = 'Editar Opciones';
$lang['gr_ad_succ_head']                  = 'Cambios guardados';
$lang['gr_ad_succ_text']                  = 'Los cambios se guardaron conrrectamente';
$lang['gr_ad_err_dropdown']               = 'No has elegido un nombre de campo';
$lang['gr_ad_succ_del']                   = 'Campo borrado correctamente';
$lang['gr_ad_sort_f']                     = 'Ordenación';
$lang['gr_ad_preview_f']                  = 'Vista previa';
$lang['gr_vr_view']                       = 'Ver Solicitud';
$lang['gr_comment']                       = 'Escribir comentarios';
$lang['gr_ad_closingmail']                = 'Informar aspirante';
$lang['gr_ad_closingtext']                = 'Tu solicitud ha sido cerrada. Nuestros usuarios han votado de la siguiente manera:';
$lang['gr_ad_replyadress']                = 'Este es un correo generado automáticamente. Por favor, envía tu respuesta a: ';
$lang['gr_sendermail']                    = 'De:';
$lang['gr_ad_popup_activated']		  			= '¿Mostrar aviso cuando existan solicitudes inactivas? (sólo es necesario si el envío de correos no funciona)';
$lang['gr_ad_notactivated_popup']					= '¡Solicitud no activada!';
$lang['gr_poll_voted_yet']                = 'resultado intermedio ';
$lang['gr_vote']                          = 'Voto';
$lang['gr_ad_form_headline']              = 'Cabecera';
$lang['gr_ad_form_spaceline']             = 'línea vacía';
$lang['gr_ad_sm_submit']									= 'enviar';

$lang['gr_mailnotsent']										= 'Error al enviar correo de activación. Por favor, contacta con el administrador.';
$lang['gr_write_error']										= '¡Error!';
$lang['gr_closingmail_hl']								= 'Solicitud cerrada';
$lang['gr_closingmail_submit']						= 'Enviar';
$lang['gr_wrongcaptcha']									= '¡Has introducido un código de confirmación incorrecto!';
?>