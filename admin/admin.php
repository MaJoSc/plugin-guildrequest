<?PHP
/********************************************\
* Guildrequest Plugin for EQdkp plus         *
* ------------------------------------------ * 
* Project Start: 01/2009                     *
* Author: BadTwin                            *
* Copyright: Andreas (BadTwin) Schrottenbaum *
* Link: http://eqdkp-plus.com                *
* Version: 0.0.1c                            *
\********************************************/

// EQdkp required files/vars
define('EQDKP_INC', true);        // is it in the eqdkp? must be set!!
define('PLUGIN', 'guildrequest');   // Must be set!
$eqdkp_root_path = './../../../';    // Must be set!
include_once($eqdkp_root_path . 'common.php');  // Must be set!

// Check if plugin is installed
if (!$pm->check(PLUGIN_INSTALLED, 'guildrequest')) { message_die('The guild request plugin is not installed.'); }

$user->check_auth('a_guildrequest_manage');

// ------- THE SOURCE PART - START -------
if (isset($_POST['gr_ad_submit'])) {
	$db->query("UPDATE __guildrequest_config SET config_value = '".$_POST['header']."' WHERE config_name='gr_welcome_text'");
	$db->query("UPDATE __guildrequest_config SET config_value = '".$_POST['mail1']."' WHERE config_name='gr_mail_text1'");
	$db->query("UPDATE __guildrequest_config SET config_value = '".$_POST['mail2']."' WHERE config_name='gr_mail_text2'");
	$db->query("UPDATE __guildrequest_config SET config_value = '".$_POST['poll']."' WHERE config_name='gr_poll_activated'");
	$success = $user->lang['gr_ad_update_succ'];
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
// ------- THE SOURCE PART - END -------

   
// Send the Output to the template Files.
$tpl->assign_vars(array(
      'GR_AD_CONFIG_HEADLINE' => $user->lang['gr_ad_config_headline'],
      'GR_AD_HEADLINE'        => $setting['gr_welcome_text'],
      'GR_AD_POLL_ACTIVATED'  => $user->lang['gr_ad_poll_activated'],
      'GR_POLL_YES_S'         => $gr_poll_yes_s,
      'GR_POLL_YES_F'         => $user->lang['gr_poll_yes'],
      'GR_POLL_NO_S'          => $gr_poll_no_s,
      'GR_POLL_NO_F'          => $user->lang['gr_poll_no'],
      'GR_AD_MAIL_1'          => $setting['gr_mail_text1'],
      'GR_AD_MAIL_2'          => $setting['gr_mail_text2'],
      'GR_AD_HEADLINE_F'      => $user->lang['gr_ad_headline_f'],
      'GR_AD_MAIL_1_F'        => $user->lang['gr_ad_mail1_f'],
      'GR_AD_MAIL_2_F'        => $user->lang['gr_ad_mail2_f'],
      'GR_AD_UPDATE_SUCC'     => $success,
    ));

// Init the Template
$eqdkp->set_vars(array(
	    'page_title'             => $eqdkp->config['guildtag'].' - '.$user->lang['request'],
			'template_path' 	       => $pm->get_data('guildrequest', 'template_path'),
			'template_file'          => 'admin/admin.html',
			'display'                => true)
    );

?> 