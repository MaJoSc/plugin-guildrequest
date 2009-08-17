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

$lang['guildrequest']						= 'GuildRequest';
$lang['gr_class_short_desc']		= 'Bewerbungs-Plugin';
$lang['gr_class_long_desc']			= 'Plugin um Bewerbungen zu Verwalten, mit Abstimmungs-Funktion';
$lang['gr_class_perm_manage']		= 'Verwalten';
$lang['gr_class_perm_view']			= 'Ansehen';
$lang['gr_class_perm_comment']	= 'Kommentieren';
$lang['gr_class_perm_vote']			= 'Abstimmen';
$lang['gr_class_perm_offi']			= 'Offi-Kommentare';

$lang['gr_sett_mail_text1']			= 'Mailtext1';
$lang['gr_sett_mail_text2']			= 'Mailtext2';
$lang['gr_sett_welcome_text']		= 'Welcometext';

$lang['gr_user_aspirant']				= 'Bewerber';

$lang['gr_menu_view']						= 'Bewerbungen ansehen';
$lang['gr_menu_write']					= 'Bewerbung schreiben';

$lang['gr_admin_menu_manage']		= 'Einstellungen';
$lang['gr_admin_menu_formedit']	= 'Formular bearbeiten';

$lang['gr_admin_f_mailtext1']		= 'Mailtext 1 (oberer Teil)';
$lang['gr_admin_f_mailtext2']		= 'Mailtext 2 (unterer Teil)';
$lang['gr_admin_f_poll']				= 'Umfragen aktiviert?';
$lang['gr_admin_f_popup']				= 'Popup bei neuen Bewerbungen?<br />(nur notwendig, falls der Mailversand nicht funktioniert)';
$lang['gr_admin_f_upd_check']		= 'Updatecheck einschalten?';
$lang['gr_admin_f_close']				= 'Closetext';

$lang['gr_about_header']				= 'Impressum';
$lang['gr_save']								= 'speichern';
?>