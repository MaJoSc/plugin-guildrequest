<?PHP
/********************************************\
* Guildrequest Plugin for EQdkp plus         *
* ------------------------------------------ * 
* Project Start: 01/2009                     *
* Author: BadTwin                            *
* Copyright: Andreas (BadTwin) Schrottenbaum *
* Link: http://eqdkp-plus.com                *
* Version: 0.0.1                             *
\********************************************/



// EQdkp required files/vars
define('EQDKP_INC', true);        // is it in the eqdkp? must be set!!
define('PLUGIN', 'guildrequest');   // Must be set!
$eqdkp_root_path = './../../../';    // Must be set!
define('IN_ADMIN', true);         // Must be set if admin page
include_once($eqdkp_root_path . 'common.php');  // Must be set!
include_once('../include/common.php');  // Must be set!
$wpfccore->InitAdmin();

// Check if plugin is installed
if (!$pm->check(PLUGIN_INSTALLED, 'guildrequest')) { message_die('The guild request plugin is not installed.'); }

$user->check_auth('a_guildrequest_manage');

// ------- UPDATECHECK - START -------

// Check if the Update Check should be enabled or disabled...
$updchk_enbled = ( $row['gl_updatecheck'] == 1 ) ? true : false;

// Include the Database Updater
$grupdater = new PluginUpdater('guildrequest', 'gr_', 'guildrequest_config', 'include');

// The Data for the Cache Table
$cachedb        = array(
      'table' => 'guildrequest_config',
      'data' => $conf['vc_data'],
      'f_data' => 'vc_data',
      'lastcheck' => $conf['vc_lastcheck'],
      'f_lastcheck' => 'vc_lastcheck'
      );

// The Version Information
$versionthing   = array(
      'name' => 'guildrequest',
      'version' => $pm->get_data('guildrequest', 'version'),
      'build' => $pm->plugins['guildrequest']->build,
      'vstatus' => $pm->plugins['guildrequest']->vstatus,
      'enabled' => $updchk_enbled
      );

// Start Output à DO NOT CHANGE....
$wpfccore->InitAdmin();
$rbvcheck = new PluginUpdCheck($versionthing, $cachedb);
$rbvcheck->PerformUpdateCheck();

// ------- UPDATE CHECK - END -------

// ------- THE SOURCE PART - START -------
if (isset($_POST['gr_ad_submit'])) {
	$db->query("UPDATE __guildrequest_config SET config_value = '".$_POST['mail1']."' WHERE config_name='gr_mail_text1'");
	$db->query("UPDATE __guildrequest_config SET config_value = '".$_POST['mail2']."' WHERE config_name='gr_mail_text2'");
	$db->query("UPDATE __guildrequest_config SET config_value = '".$_POST['poll']."' WHERE config_name='gr_poll_activated'");
	$db->query("UPDATE __guildrequest_config SET config_value = '".$_POST['popup']."' WHERE config_name='gr_popup_activated'");
  System_Message($user->lang['gr_ad_update_succ'], $user->lang['gr_ad_update_succ_hl'], 'green');
}

$settings_query = $db->query("SELECT * FROM __guildrequest_config");
while ($settings = $db->fetch_record($settings_query)){
  $setting[$settings['config_name']] = $settings['config_value'];
}

if ($setting['gr_poll_activated'] == 'Y'){
  $gr_poll_yes_s = ' checked';
} else {
  $gr_poll_no_s = ' checked';
}

if ($setting['gr_popup_activated'] == 'Y'){
  $gr_popup_yes_s = ' checked';
} else {
  $gr_popup_no_s = ' checked';
}

print_r($plus_settings);
// ------- THE SOURCE PART - END -------

   
// Send the Output to the template Files.
$tpl->assign_vars(array(
      'GR_AD_CONFIG_HEADLINE' => $user->lang['gr_ad_config_headline'],
      'GR_AD_POLL_ACTIVATED'  => $user->lang['gr_ad_poll_activated'],
	'GR_AD_POPUP_ACTIVATED'	=> $user->lang['gr_ad_popup_activated'],
      'GR_POLL_YES_S'         => $gr_poll_yes_s,
      'GR_POLL_YES_F'         => $user->lang['gr_poll_yes'],
      'GR_POLL_NO_S'          => $gr_poll_no_s,
      'GR_POLL_NO_F'          => $user->lang['gr_poll_no'],
	'GR_POPUP_YES_S'	=> $gr_popup_yes_s,
	'GR_POPUP_NO_S'		=> $gr_popup_no_s,
      'GR_AD_MAIL_1'          => $setting['gr_mail_text1'],
      'GR_AD_MAIL_2'          => $setting['gr_mail_text2'],
      'GR_AD_MAIL_1_F'        => $user->lang['gr_ad_mail1_f'],
      'GR_AD_MAIL_2_F'        => $user->lang['gr_ad_mail2_f'],

      'GR_POPUP'              => $success,
    	'UPDATE_BOX'            => $grupdater->OutputHTML(),
    	'UPDCHECK_BOX'     		  => $rbvcheck->OutputHTML(),
    ));

// Init the Template
$eqdkp->set_vars(array(
	    'page_title'             => $eqdkp->config['guildtag'].' - '.$user->lang['request'],
			'template_path' 	       => $pm->get_data('guildrequest', 'template_path'),
			'template_file'          => 'admin/admin.html',
			'display'                => true)
    );

?> 
