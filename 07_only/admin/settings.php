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

define('EQDKP_INC', true);
define('IN_ADMIN', true);
define('PLUGIN', 'guildrequest');
$eqdkp_root_path = './../../../';

include_once('../includes/common.php');

// Check user permission
$user->check_auth('a_guildrequest_manage');

if (!$pm->check(PLUGIN_INSTALLED, 'guildrequest')) {
	message_die('The Guildrequest plugin is not installed.');
}

//Updater
$guildrequestupdater = new PluginUpdater('guildrequest', 'gr_', 'guildrequest_config', 'includes');

//Update check
// Check if the Update Check should ne enabled or disabled...
$updchk_enbled = ( $conf['gr_upd_check'] == 1 ) ? true : false;
// The Data for the Cache Table
$cachedb = array(
  'table' => 'guildrequest_config',
  'data' => $conf['vc_data'],
  'f_data' => 'vc_data',
  'lastcheck' => $config['vc_lastcheck'],
  'f_lastcheck' => 'vc_lastcheck'
);

// The Version Information
$versionthing   = array(
  'name' => 'guildrequest', 
  'version' => $pm->get_data('guildrequest', 'version'),
//  'build' => $pm->plugins['bosssuite']->build, 
//  'vstatus' => $pm->plugins['bosssuite']->vstatus,
  'enabled' => $updchk_enbled
);

// Start Output ?DO NOT CHANGE....
$guildrequestvcheck = new PluginUpdCheck($versionthing, $cachedb);
$guildrequestvcheck->PerformUpdateCheck();

// Save the settings
if ($in->get('settings_submit')){
	$db->query("UPDATE __guildrequest_config SET config_value='".$db->escape($in->get('mailtext1'))."' WHERE config_name='gr_mail_text1'");
	$db->query("UPDATE __guildrequest_config SET config_value='".$db->escape($in->get('mailtext2'))."' WHERE config_name='gr_mail_text2'");
	$db->query("UPDATE __guildrequest_config SET config_value='".$db->escape($in->get('poll', 'N'))."' WHERE config_name='gr_poll_activated'");
	$db->query("UPDATE __guildrequest_config SET config_value='".$db->escape($in->get('popup', 'N'))."' WHERE config_name='gr_popup_activated'");
	$db->query("UPDATE __guildrequest_config SET config_value='".$db->escape($in->get('upd_check', 0))."' WHERE config_name='gr_upd_check'");

	$conf['gr_mail_text1'] = $db->escape($in->get('mailtext1'));
	$conf['gr_mail_text2'] = $db->escape($in->get('mailtext2'));
	$conf['gr_poll_activated'] = $db->escape($in->get('poll', 'N'));
	$conf['gr_popup_activated'] = $db->escape($in->get('popup', 'N'));
	$conf['gr_upd_check'] = $db->escape($in->get('upd_check', 0));
}

// Deliver the output to the template
$tpl->assign_vars(array (
	'UPDATER'				=> $guildrequestupdater->OutputHTML(),
	'UPDCHECK_BOX'	=> $guildrequestvcheck->OutputHTML(),
	'F_CONFIG'			=> 'settings.php' . $SID,
	
	'GR_MAILTEXT1'	=> $jquery->wysiwyg('mailtext1').'<textarea name="mailtext1" rows="8" cols="69" id="mailtext1" class="jTagEditor">'.sanitize($conf['gr_mail_text1']).'</textarea>',
	'GR_MAILTEXT2'	=> $jquery->wysiwyg('mailtext2').'<textarea name="mailtext2" rows="8" cols="69" id="mailtext2" class="jTagEditor">'.sanitize($conf['gr_mail_text2']).'</textarea>',
	'GR_POLL'				=> ($conf['gr_poll_activated'] == 'Y') ? ' checked="checked"' : '',
	'GR_POPUP'			=> ($conf['gr_popup_activated'] == 'Y') ? ' checked="checked"' : '',
	'GR_UPD_CHECK'	=> ($conf['gr_upd_check'] == 1) ? ' checked="checked"' : '',
	'GR_CREDITS' 		=> $pm->get_data('guildrequest', 'version'),

	// Language Terms
	'GR_F_MAILTEXT1'	=> $user->lang['gr_admin_f_mailtext1'],
	'GR_F_MAILTEXT2'	=> $user->lang['gr_admin_f_mailtext2'],
	'GR_F_POLL'				=> $user->lang['gr_admin_f_poll'],
	'GR_F_POPUP'			=> $user->lang['gr_admin_f_popup'],
	'GR_F_UPD_CHECK'	=> $user->lang['gr_admin_f_upd_check'],
	
	'GR_SAVE'					=> $user->lang['gr_save'],
));

$eqdkp->set_vars(array (
	'page_title' => sprintf($user->lang['admin_title_prefix'], $eqdkp->config['guildtag'], $eqdkp->config['dkp_name']).': '.$user->lang['guildrequest'],
	'template_path' => $pm->get_data('guildrequest', 'template_path'),
	'template_file' => 'admin/settings.html', 'display' => true
	)
);
?>