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
include_once($eqdkp_root_path . 'common.php');  // Must be set!

// Check if plugin is installed
if (!$pm->check(PLUGIN_INSTALLED, 'guildrequest')) { message_die('The guild request plugin is not installed.'); }

// Include the libraries
include_once($eqdkp_root_path . 'plugins/guildrequest/include/libloader.inc.php');

// ------- THE SOURCE PART - START -------
if (isset($_POST['gr_submit'])){
  if ($_POST['username'] != '' && $_POST['email'] != '' && $_POST['password'] != '' && $_POST['text'] != ''){
  
    // Check the Mail adress
    function check_email($email) { 
      $email = eregi('^[a-z0-9]+([-_\.]?[a-z0-9])+@[a-z0-9]+([-_\.]?[a-z0-9])+\.[a-z]{2,4}', $email); 
      return $email; 
    } 
 
    if (check_email($_POST['email'])){
      $usercheck_query = $db->query("SELECT * FROM __guildrequest");
      while ($usercheck = $db->fetch_record($usercheck_query)) {
        if ($usercheck['username'] == $_POST['username']) {
          $userdouble = true;
        	break;
        }
      }
    
      $username = htmlentities(strip_tags($_POST['username']), ENT_QUOTES);
      $password = htmlentities(strip_tags($_POST['password']), ENT_QUOTES);
      $email = htmlentities(strip_tags($_POST['email']), ENT_QUOTES);

      if (!$userdouble){
        $activationcode = md5(time().microtime());
        $insertquery = $db->query("INSERT INTO __guildrequest (username, email, password, text, activation) VALUES (
  				'".$username."', 
          '".$email."', 
          '".md5($password)."',
          '".$_POST['text']."',
          '".$activationcode."')");
        
        
        // Send Activation Mail
        $config_query = $db->query("SELECT * FROM __guildrequest_config");
        while ($gr_config_array = $db->fetch_record($config_query)){
          $gr_config[$gr_config_array['config_name']] = $gr_config_array['config_value'];
        }
    
        // ---- Mail Text Start - DO NOT CHANGE ----
      $mailtext = 
       $gr_config['gr_mail_text1'].'
        
http://'.$eqdkp->config['server_name'].$eqdkp->config['server_path'].'plugins/guildrequest/activate.php?activationcode='.$activationcode.'

  '.$user->lang['gr_username_f'].' '.$_POST['username'].'
  '.$user->lang['gr_password_f'].' '.$_POST['password'].'
  
'.$gr_config['gr_mail_text2'];
        // ---- Mail Text End ----
    
        $mailheader .= 'FROM:'.$eqdkp->config['admin_email'];
    
        mail($_POST["email"],
        $user->lang['gr_mail_topic'],
        $mailtext,
        $mailheader);
        System_Message($user->lang['gr_mailsent'], $user->lang['gr_write_succ'], 'green');
      } else {
        $gr_username = $_POST['username'];
        $gr_email = $_POST['email'];
        $gr_password = $_POST['password'];
        $gr_text = $_POST['text'];
        System_Message($user->lang['gr_user_double'], $user->lang['gr_write_error'], 'red');
      }
    } else {
      $gr_username = $_POST['username'];
      $gr_email = $_POST['email'];
      $gr_password = $_POST['password'];
      $gr_text = $_POST['text'];
      System_Message($user->lang['gr_write_incorrect_mail'], $user->lang['gr_write_error'], 'red');
    }
  } else {
    $gr_username = $_POST['username'];
    $gr_email = $_POST['email'];
    $gr_password = $_POST['password'];
    $gr_text = $_POST['text'];
    System_Message($user->lang['gr_write_allfields'], $user->lang['gr_write_error'], 'red');
  }
}

$config_query = $db->query("SELECT * FROM __guildrequest_config");
while ($config = $db->fetch_record($config_query)) {
	if ($config['config_name'] == 'gr_welcome_text'){
    $gr_write_welcome = nl2br($config['config_value']);
  }
}
// ------- THE SOURCE PART - END -------

   
// Send the Output to the template Files.
$tpl->assign_vars(array(
      'OUTPUT'        => $output,
      'GR_USERNAME'   => $gr_username,
      'GR_EMAIL'   => $gr_email,
      'GR_PASSWORD'   => $gr_password,
      'GR_TEXT'   => $gr_text,
      'GR_EDITOR'  => $jquery->wysiwyg('requesttext'),
      'GR_USERNAME_F' => $user->lang['gr_username_f'],
      'GR_EMAIL_F' => $user->lang['gr_email_f'],
      'GR_PASSWORD_F' => $user->lang['gr_password_f'],      
      'GR_TEXT_F' => $user->lang['gr_text_f'],
      'GR_WRITE_HEADLINE' => $user->lang['gr_write_headline'],
      'GR_WRITE_WELCOME'  => $gr_write_welcome,
      'GR_SENDREQUEST'    => $user->lang['gr_write_sendrequest'],
      'GR_RESET'          => $user->lang['gr_write_reset'],
      'GR_INFOBOX'        => $infobox, 
    ));

// Init the Template
$eqdkp->set_vars(array(
	    'page_title'             => $eqdkp->config['guildtag'].' - '.$user->lang['request'],
			'template_path' 	       => $pm->get_data('guildrequest', 'template_path'),
			'template_file'          => 'writerequest.html',
			'display'                => true)
    );

?>