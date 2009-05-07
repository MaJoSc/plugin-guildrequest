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

// include the Comment System
  $login_query = $db->query("SELECT * FROM __guildrequest WHERE username='".$_POST['username']."'");
  $login_check = $db->fetch_record($login_query);
  $attach_id = $login_check['id'];

	if(is_object($pcomments) && $pcomments->version > '1.0.3'){
      $comm_settings = array(
          'attach_id' => $attach_id, 
          'page'      => 'guildrequest',
      );
		$pcomments->SetVars($comm_settings);
		$tpl->assign_vars(array(
			'ENABLE_COMMENTS'     => true,
			'COMMENTS'            => $pcomments->Show(),
      ));
    }
    
// ------- THE SOURCE PART - START -------
$guestuser_query = $db->query("SELECT * FROM __users WHERE username = '".$user->lang['gr_user_aspirant']."'");
$guestuser = $db->fetch_record($guestuser_query);
$userid = $guestuser['user_id'];

$show_login = true;
$show_request = false;
$show_closed = false;
$insert_answer = false;
$show_answer = true;

if (isset($_POST['usercomment_submit'])) {
  if ($_POST['usercomment'] != ''){
  
    $htmlinsert = htmlentities(strip_tags($_POST['usercomment']), ENT_QUOTES); /*No html or javascript in comments*/
        
	  $comment_query = $db->query("INSERT INTO __comments (attach_id, userid, date, text, page) VALUES(
      '".$attach_id."',
      '".$userid."',
      '".time()."',
      '".$htmlinsert."',
      'guildrequest')");
    }
    $show_login = false;
    $show_request = true;
    $insert_answer = " <html>
      <head>
        <title></title>
        <script language='javascript'>
          function MyFormSubmit(){
            document.newanswer.submit();
          }
        </script> 
      </head>
      <body onload='MyFormSubmit()'> 
        <form action='login.php' method='POST' name='newanswer'>
          <input type='hidden' name='username' value='".$_POST['username']."' />
          <input type='hidden' name='password' value='".$_POST['password']."' />
          <input type='hidden' name='gr_submit' value='1' />
        </form>
      </body>
    </html>";
}


if (isset($_POST['gr_submit'])){
  if ($_POST['username'] != '' && $_POST['password'] != '') {
	  $login_query = $db->query("SELECT * FROM __guildrequest WHERE username='".htmlentities(strip_tags($_POST['username']), ENT_QUOTES)."'");
	  $login_check = $db->fetch_record($login_query);
	  
	  if (md5($_POST['password']) == $login_check['password']){
	    if ($login_check['activated'] != 'Y') {
        System_Message($user->lang['gr_login_not_activated'], $user->lang['gr_write_error'], 'red');
     	  $show_answer = false;
      } else {
        if ($login_check['closed'] == 'N') {
          $show_login = false;
          $show_request = true;
        } else {
          $settings_query = $db->query("SELECT * FROM __guildrequest_config");
          while ($settings = $db->fetch_record($settings_query)){
            $setting[$settings['config_name']] = $settings['config_value'];
          }
          if ($setting['gr_poll_activated'] == 'Y') {
            // --- the poll part - start ---
            $vote_sum_count_query = $db->query("SELECT * FROM __guildrequest_poll WHERE query_id='".$login_check['id']."'");
            $vote_sum_count = $db->num_rows($vote_sum_count_query);
    
            $vote_yes_count_query = $db->query("SELECT * FROM __guildrequest_poll WHERE query_id='".$login_check['id']."' AND poll_value='Y'");
            $vote_yes_count = $db->num_rows($vote_yes_count_querey);
    
            if ($vote_sum_count == 0){
  	          $poll_yes_bar = create_bar(0);
  	          $poll_no_bar = create_bar(0);            
            } else {
              $vote_yes = round(($vote_yes_count/$vote_sum_count)*100);
              $vote_no = (100 - $vote_yes);
    
  	          $poll_yes_bar = create_bar($vote_yes);
  	          $poll_no_bar = create_bar($vote_no);
  	          
              $poll_yes_f = $user->lang['gr_poll_yes'];
              $poll_no_f = $user->lang['gr_poll_no'];
  	          
  	        }
            // --- the poll part - end ---
          }  
          $show_login = false;
          $show_request = true;
          $show_closed = true;
          $show_answer = false;
        }
      }
    } else {
      System_Message($user->lang['gr_login_wrong'], $user->lang['gr_write_error'], 'red');
      $show_answer = false;
    }
  } else {
    System_Message($user->lang['gr_login_empty'], $user->lang['gr_write_error'], 'red');
    $show_answer = false;
  }
  $db->free_result($login_query);
}

// The BB-Code thing
  $requesttext = $bbcode->toHTML($login_check['text']);
  $bbcode->SetSmiliePath($eqdkp_root_path.'libraries/jquery/images/editor/icons');
  $requesttext = $bbcode->MyEmoticons($requesttext);

// ------- THE SOURCE PART - END -------

   
// Send the Output to the template Files.
$tpl->assign_vars(array(
      'GR_LOGIN_HEADLINE' => $user->lang['gr_login_headline'],
      'GR_EDITOR'  => $jquery->wysiwyg('requesttext'),
      'GR_USERNAME_F' => $user->lang['gr_username_f'],
      'GR_PASSWORD_F' => $user->lang['gr_password_f'],
      'GR_LOGIN_SUBMIT' => $user->lang['gr_login_submit'],
      'GR_LOGIN_RESET'  => $user->lang['gr_login_reset'],
      'GR_USERNAME'    =>  $login_check['username'],
      'GR_PASSWORD'     => $_POST['password'],
      'GR_SHOW_REQUEST'  => $show_request, 
      'GR_SHOW_CLOSED'   => $show_closed,
      'GR_CLOSED_HEADLINE' => $user->lang['gr_closed_headline'],
      'GR_SHOW_ANSWER' => $show_answer,
      'GR_SHOW_YES_F'   => $poll_yes_f,
      'GR_SHOW_YES_B'   => $poll_yes_bar,
      'GR_SHOW_NO_F'    => $poll_no_f,
      'GR_SHOW_NO_B'    => $poll_no_bar,
      'GR_SHOWREQUEST_HEADLINE' => $user->lang['gr_showrequest_headline'].$login_check['username'],
      'GR_SHOWREQUEST_TEXT' => $requesttext,
      'GR_SHOW_LOGIN' => $show_login,
      'OUTPUT'        => $output,
      'GR_ANSWER_F'   => $user->lang['gr_answer_f'],
      'GR_INSERT_ANSWER'  => $insert_answer, 
      'GR_INFOBOX'        => $infobox,
    ));

// Init the Template
$eqdkp->set_vars(array(
	    'page_title'             => $eqdkp->config['guildtag'].' - '.$user->lang['request'],
			'template_path' 	       => $pm->get_data('guildrequest', 'template_path'),
			'template_file'          => 'login.html',
			'display'                => true)
    );

?>  