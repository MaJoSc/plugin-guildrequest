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
  // check, if all user-defined required fields are filled
  $reqcheck_qry = $db->query("SELECT * FROM __guildrequest_appvalues WHERE required = 'Y'");
  $requiredfields = 'success';
  while ($reqcheck = $db->fetch_record($reqcheck_qry)){
    if ($_POST[$reqcheck['ID']] == '') {
    	$requiredfields = 'error';
    }
  }

  if ($_POST['username'] != '' && $_POST['email'] != '' && $_POST['password'] != '' && $requiredfields == 'success'){
  
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
    
      $username = htmlentities(strip_tags($in->get('username')), ENT_QUOTES);
      $password = htmlentities(strip_tags($in->get('password')), ENT_QUOTES);
      $email = htmlentities(strip_tags($in->get('email')), ENT_QUOTES);
      
      // Create the displayed text for the output

      $textblock_qry = $db->query("SELECT * FROM __guildrequest_appvalues");
      while ($textblk = $db->fetch_record($textblock_qry)){
        if ($_POST[$textblk['ID']] != ''){
          $textblock .= '<div style="float:left; margin:15px;" [b][i]'.$textblk['value'].':[/b][/i]</div><div style="padding:15px;">'.htmlentities(strip_tags($_POST[$textblk['ID']]), ENT_QUOTES).'</div>';
        }
      }

      if (!$userdouble){
        $activationcode = md5(time().microtime());
        $insertquery = $db->query("INSERT INTO __guildrequest (username, email, password, text, activation) VALUES (
  				'".$username."', 
          '".$email."', 
          '".md5($password)."',
          '".$textblock."',
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

  '.$user->lang['gr_username_f'].' '.$in->get('username').'
  '.$user->lang['gr_password_f'].' '.$in->get('password').'
  
'.$gr_config['gr_mail_text2'];
        // ---- Mail Text End ----
    
        $mailheader .= 'FROM:'.$eqdkp->config['admin_email'];
    
        mail($in->get('email'),
        $user->lang['gr_mail_topic'],
        $mailtext,
        $mailheader);
        System_Message($user->lang['gr_mailsent'], $user->lang['gr_write_succ'], 'green');
        $_POST = '';
      } else {
        $gr_username = $in->get('username');
        $gr_email = $in->get('email');
        $gr_password = $in->get('password');
        $gr_text = $textblock;
        System_Message($user->lang['gr_user_double'], $user->lang['gr_write_error'], 'red');
      }
    } else {
      $gr_username = $in->get('username');
      $gr_email = $in->get('email');
      $gr_password = $in->get('password');
      $gr_text = $textblock;
      System_Message($user->lang['gr_write_incorrect_mail'], $user->lang['gr_write_error'], 'red');
    }
  } else {
    $gr_username = $in->get('username');
    $gr_email = $in->get('email');
    $gr_password = $in->get('password');
    $gr_text = $textblock;
    System_Message($user->lang['gr_write_allfields'], $user->lang['gr_write_error'], 'red');
  }
}

$config_query = $db->query("SELECT * FROM __guildrequest_config WHERE config_name='gr_welcome_text'");
$config = $db->fetch_record($config_query);
$welcometext = $bbcode->toHTML($config['config_value']);
$bbcode->SetSmiliePath($eqdkp_root_path.'libraries/jquery/images/editor/icons');
$welcometext = $bbcode->MyEmoticons($welcometext);

// build the form
$form_qry = $db->query("SELECT * FROM __guildrequest_appvalues ORDER BY sort");
while ($form = $db->fetch_record($form_qry)) {

  if ($form['type'] == 'singletext') {
  	$inputfield = '<input type="text" name="'.$form['ID'].'" value="'.$_POST[$form['ID']].'">';
  } elseif ($form['type'] == 'textfield') {
    $inputfield = $jquery->wysiwyg($form['ID']).'<textarea name="'.$form['ID'].'" id="'.$form['ID'].'" class="jTagEditor">'.$_POST[$form['ID']].'</textarea>';
  } elseif ($form['type'] == 'dropdown') {
    //generate the dropdown

    $dropdown = '';
    $drpdwn_qry = $db->query("SELECT * FROM __guildrequest_appoptions WHERE opt_ID = '".$form['ID']."'");
    while ($drpdwn = $db->fetch_record($drpdwn_qry)) {
      $dropdown .= '<option>'.$drpdwn['appoption'].'</option>';
    }

    $inputfield = '<select name="'.$form['ID'].'">
                  <option value="">-----------</option>'.
                  $dropdown;
                  '</select>';  	
  }
  
  if ($form['required'] == 'Y') {
  	$reqstart = '<b>';
    $required = ':*</b>';
  } else {
    $reqstart = '';
    $required = ':';
  }
	$formblock .= '<tr class="'.$eqdkp->switch_row_class().'">
                  <td>&nbsp;</td>
                  <td align="right" valign="top">'.$reqstart.$form['value'].$required.'</td>
                  <td colspan="4">'.$inputfield.'</td>
                </tr>';
}

// ------- THE SOURCE PART - END -------

   
// Send the Output to the template Files.
$tpl->assign_vars(array(
      'OUTPUT'        => $output,
      'GR_USERNAME'   => $gr_username,
      'GR_EMAIL'   => $gr_email,
      'GR_PASSWORD'   => $gr_password,
      'GR_TEXT'   => $gr_text,
      'GR_FORMBLOCK'  => $formblock,
      'GR_USERNAME_F' => $user->lang['gr_username_f'],
      'GR_EMAIL_F' => $user->lang['gr_email_f'],
      'GR_PASSWORD_F' => $user->lang['gr_password_f'],      
      'GR_WRITE_HEADLINE' => $user->lang['gr_write_headline'],
      'GR_WRITE_WELCOME'  => $welcometext,
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