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
$eqdkp_root_path = './../../';    // Must be set!
define('IN_ADMIN', true);         // Must be set if admin page
include_once($eqdkp_root_path . 'common.php');  // Must be set!
include_once('include/common.php');  // Must be set!

// Check if plugin is installed
if (!$pm->check(PLUGIN_INSTALLED, 'guildrequest')) { message_die('The guild request plugin is not installed.'); }

$user->check_auth('a_guildrequest_manage');

// ------- THE SOURCE PART - START -------
$opt_id = $in->get('id');;

if ($in->get('closing_submit') != ''){
  $appdetails_qry = $db->query("SELECT * FROM __guildrequest WHERE id='".$db->escape($in->get('id'))."'");
  $appdetails = $db->fetch_record($appdetails_qry);

  $requesttext = $bbcode->toHTML($in->get('answer'));
  $bbcode->SetSmiliePath($eqdkp_root_path.'libraries/jquery/images/editor/icons');
  $requesttext = $bbcode->MyEmoticons($requesttext);

  $requesttext = strip_tags($requesttext);

	$maileroptions = array(
		'sender_mail'			=> $in->get('sendermail', ''),
		'mail_type'				=> 'text',
		'template_type'		=> 'file',
		'sendmail_path'		=> $conf_plus['lib_email_sendmail_path'],
		'smtp_auth'				=> $conf_plus['lib_email_smtp_auth'],
		'smtp_host'				=> $conf_plus['lib_email_smtp_host'],
		'smtp_username'		=> $conf_plus['lib_email_smtp_user'],
		'smtp_password'		=> $conf_plus['lib_email_smtp_pw'],
	);
	$mailer = new MyMailer($maileroptions);

	$bodyvars = array(
			'MAILTEXT'   => $requesttext,
	);
	$mailer->SendMailFromAdmin($appdetails['email'], $user->lang['gr_closingmail_hl'], 'closingmail.txt', $bodyvars, $conf_plus['lib_email_method']);

  echo "<script>parent.window.location.href = 'viewrequest.php';</script>";
}

$settings_query = $db->query("SELECT * FROM __guildrequest_config");
while ($settings = $db->fetch_record($settings_query)){
  $setting[$settings['config_name']] = $settings['config_value'];
}

if ($setting['gr_poll_activated'] == 'Y') {
  $vote_sum_count_query = $db->query("SELECT * FROM __guildrequest_poll WHERE query_id='".$db->escape($in->get('id', 0))."'");
  $vote_sum_count = $db->num_rows($vote_sum_count_query);

  $vote_yes_count_query = $db->query("SELECT * FROM __guildrequest_poll WHERE query_id='".$db->escape($in->get('id', 0))."' AND poll_value='Y'");
  $vote_yes_count = $db->num_rows($vote_yes_count_query);

  $vote_yes = round(($vote_yes_count/$vote_sum_count)*100);
  if ($vote_sum_count){
		$vote_no = (100 - $vote_yes);
  } else {
		$vote_no = 0;
  }
}

	$answertext .= $user->lang['gr_ad_closingtext'].'

'.$user->lang['gr_poll_yes'].': '.$vote_yes.'%
'.$user->lang['gr_poll_no'].': '.$vote_no.'%';

  $inputfield = $jquery->wysiwyg('closingtext');

// ------- THE SOURCE PART - END -------


// Send the Output to the template Files.
$tpl->assign_vars(array(
      'GR_SENDERMAIL_F'     => $user->lang['gr_sendermail'],
      'GR_SENDERMAIL'       => $user->data['user_email'],
      'GR_ID'               => sanitize($in->get('id')),
      'GR_CM_ANSWER'        => $inputfield,
      'GR_ANSWERTEXT'       => $answertext,
      'GR_SUBMIT_F'					=> $user->lang['gr_closingmail_submit'],
    ));

// Init the Template
$eqdkp->set_vars(array(
	    'page_title'             => $eqdkp->config['guildtag'].' - '.$user->lang['request'],
			'template_path' 	       => $pm->get_data('guildrequest', 'template_path'),
			'template_file'          => 'closingmail.html',
			'gen_simple_header'      => true,
      'display'                => true)
    );

?>