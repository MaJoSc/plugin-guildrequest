<?PHP
  /**********************************************************************************\
  * Project:   GuildRequest2 for EQdkp-Plus                                          *
  * Licence:   Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported *
  * Link:      http://creativecommons.org/licenses/by-nc-sa/3.0/                     *
  *----------------------------------------------------------------------------------*
  * Rewrite:	 15.08.2009                                                            *
  *                                                                                  *
  * Author:    BadTwin                                                               *
  * Copyright: 2009 Andreas (BadTwin) Schrottenbaum                                  *
  * Link:      http://badtwin.dyndns.org                                             *
  * Package:   Guildrequest                                                          *
  \**********************************************************************************/

if (!defined('EQDKP_INC')) {
	header('HTTP/1.1 403 Forbidden');
	exit;
}

global $eqdkp;

$lang['guildrequest']						= 'GuildRequest';
$lang['gr_class_short_desc']		= 'Bewerbungs-Plugin';
$lang['gr_class_long_desc']			= 'Plugin um Bewerbungen zu Verwalten, mit Abstimmungs-Funktion';
$lang['gr_class_perm_manage']		= 'Verwalten';
$lang['gr_class_perm_view']			= 'Ansehen';
$lang['gr_class_perm_comment']	= 'Kommentieren';
$lang['gr_class_perm_vote']			= 'Abstimmen';
$lang['gr_class_perm_offi']			= 'Offi-Kommentare';

$lang['gr_sett_mail_text1']			= 'Vielen Dank für dein Interesse an unserer Gilde,
bitte bestätige deine Bewerbung über folgenden Link:';
$lang['gr_sett_mail_text2']			= 'mit freundlichen Grüßen
Die Gildenleitung';
$lang['gr_sett_close_text']			= 'Deine Bewerbung wurde geschlossen.
Die Abstimmung ist wie folgt ausgegangen:';
$lang['gr_sett_welcome_text']		= 'Vielen Dank für dein Interesse bei '.sanitize($eqdkp->config['guildtag']).'. Bitte fülle die folgenden Felder aus:';

$lang['gr_user_aspirant']				= 'Bewerber';

$lang['gr_menu_view']						= 'Bewerbungen ansehen';
$lang['gr_menu_write']					= 'Bewerbung schreiben';

$lang['gr_admin_menu_manage']		= 'Einstellungen';
$lang['gr_admin_menu_formedit']	= 'Formular bearbeiten';

$lang['gr_admin_s_mailtext1']		= 'Mailtext 1 (oberer Teil)';
$lang['gr_admin_s_mailtext2']		= 'Mailtext 2 (unterer Teil)';
$lang['gr_admin_s_poll']				= 'Umfragen aktiviert?';
$lang['gr_admin_s_popup']				= 'Popup bei neuen Bewerbungen?<br />(nur notwendig, falls der Mailversand nicht funktioniert)';
$lang['gr_admin_s_upd_check']		= 'Updatecheck einschalten?';
$lang['gr_admin_s_close']				= 'Closetext';

$lang['gr_admin_f_welcome']			= 'Willkommensnachricht:';
$lang['gr_admin_f_preview']			= 'Vorschau';

$lang['gr_js_warning']					= 'Warnung';
$lang['gr_js_notsaved']					= 'Die &Auml;nderungen sind noch nicht gespeichert!';
$lang['gr_about_header']				= 'Impressum';
$lang['gr_save']								= 'speichern';
$lang['gr_reset']								= 'zurücksetzen';
?>