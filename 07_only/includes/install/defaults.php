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
  * Package: Guildrequest                                                            *
  \**********************************************************************************/

if (!defined('EQDKP_INC')) {
	header('HTTP/1.1 403 Forbidden');
	exit;
}

$config_vars = array(
	'gr_inst_version'			=> $this->version,
	'gr_mail_text1'				=> $user->lang['gr_sett_mail_text1'],
	'gr_mail_text2'				=> $user->lang['gr_sett_mail_text2'],
	'gr_welcome_text'			=> $user->lang['gr_sett_welcome_text'],
	'gr_poll_activated'		=> 'Y',
	'gr_popup_activated'	=> 'N'
);

$appvalues_vars = array(
	'Name'	=> array('singletext', 'Y', '1'),
	'Class'	=> array('singletext', 'Y', '2'),
	'Level'	=> array('singletext', 'N', '3'),
	'Text'	=> array('textfield',  'Y', '4')
);
?>