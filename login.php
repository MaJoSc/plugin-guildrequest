<?
/********************************************\
* Guildrequest Plugin for EQdkp plus         *
* ------------------------------------------ * 
* Project Start: 01/2009                     *
* Author: BadTwin                            *
* Copyright: Andreas (BadTwin) Schrottenbaum *
* Link: http://eqdkp-plus.com                *
* Version: 0.0.1a                            *
\********************************************/

// EQdkp required files/vars
define('EQDKP_INC', true);        // is it in the eqdkp? must be set!!
define('PLUGIN', 'guildrequest');   // Must be set!
$eqdkp_root_path = './../../';    // Must be set!
include_once($eqdkp_root_path . 'common.php');  // Must be set!

// Check if plugin is installed
if (!$pm->check(PLUGIN_INSTALLED, 'guildrequest')) { message_die('The guild request plugin is not installed.'); }

// include the Comment System
  $login_query = $db->query("SELECT * FROM __guildrequest WHERE username='".$_POST['username']."'");
  $login_check = $db->fetch_record($login_query);
  $attach_id = $login_check['id'];

	if(is_object($pcomments) && $pcomments->version > '1.0.3'){
      $comm_settings = array(
          'attach_id' => $attach_id, 
          'page'      => 'guildrequest',
          'auth'      => '63'
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

if (isset($_POST['usercomment_submit'])) {
  if ($_POST['usercomment'] != ''){
  
    $htmlinsert = ($pcomments->CheckUTF8($htmlinsert) == 1) ? utf8_decode($_POST['usercomment']) : $_POST['usercomment'];
    $htmlinsert = htmlentities(strip_tags($htmlinsert), ENT_QUOTES); /*No html or javascript in comments*/
    $htmlinsert = $bbcode->toHTML($htmlinsert);
        
	  $comment_query = $db->query("INSERT INTO __comments (attach_id, userid, date, text, page) VALUES(
      '".$attach_id."',
      '".$userid."',
      '".time()."',
      '".$htmlinsert."',
      'guildrequest')");
    }
    $show_login = false;
    $show_request = true;
}


if (isset($_POST['gr_submit'])){
  if ($_POST['username'] != '' && $_POST['password'] != '') {
	  $login_query = $db->query("SELECT * FROM __guildrequest WHERE username='".$_POST['username']."'");
	  $login_check = $db->fetch_record($login_query);
	  
	  if (md5($_POST['password']) == $login_check['password']){
	    if ($login_check['activated'] != 'Y') {
     	  $output = $user->lang['gr_login_not_activated'];
      } else {
        if ($login_check['closed' == 'N']) {
          $show_login = false;
          $show_request = true;
        } else{
        
          // --- the poll part - start ---
            $vote_sum_count_query = $db->query("SELECT * FROM __guildrequest_poll WHERE query_id='".$login_check['id']."'");
            $vote_sum_count = $db->num_rows($vote_sum_count_query);
    
            $vote_yes_count_query = $db->query("SELECT * FROM __guildrequest_poll WHERE query_id='".$login_check['id']."' AND poll_value='Y'");
            $vote_yes_count = $db->num_rows($vote_yes_count_querey);
    
            $vote_yes = round(($vote_yes_count/$vote_sum_count)*100);
            $vote_no = (100 - $vote_yes);
    
  	       $poll_yes_bar = create_bar($vote_yes);
  	       $poll_no_bar = create_bar($vote_no);
          // --- the poll part - end ---
  
          $show_login = false;
          $show_request = true;
          $show_closed = true;
        }
      }
    } else {
      $output = $user->lang['gr_login_wrong'];
    }
  } else {
    $output = $user->lang['gr_login_empty'];
  }
  $db->free_result($login_query);
}

// ------- THE SOURCE PART - END -------

   
// Send the Output to the template Files.
$tpl->assign_vars(array(
      'GR_LOGIN_HEADLINE' => $user->lang['gr_login_headline'],
      'GR_USERNAME_F' => $user->lang['gr_username_f'],
      'GR_PASSWORD_F' => $user->lang['gr_password_f'],
      'GR_LOGIN_SUBMIT' => $user->lang['gr_login_submit'],
      'GR_LOGIN_RESET'  => $user->lang['gr_login_reset'],
      'GR_USERNAME'    =>  $login_check['username'],
      'GR_SHOW_REQUEST'  => $show_request, 
      'GR_SHOW_CLOSED'   => $show_closed,
      'GR_CLOSED_HEADLINE' => $user->lang['gr_closed_headline'],
      'GR_SHOW_YES_F'   => $user->lang['gr_poll_yes'],
      'GR_SHOW_YES_B'   => $poll_yes_bar,
      'GR_SHOW_NO_F'    => $user->lang['gr_poll_no'],
      'GR_SHOW_NO_B'    => $poll_no_bar,
      'GR_SHOWREQUEST_HEADLINE' => $user->lang['gr_showrequest_headline'].$login_check['username'],
      'GR_SHOWREQUEST_TEXT' => nl2br($login_check['text']),
      'GR_SHOW_LOGIN' => $show_login,
      'OUTPUT'        => $output,
      'GR_ANSWER_F'   => $user->lang['gr_answer_f'], 
    ));

// Init the Template
$eqdkp->set_vars(array(
	    'page_title'             => 'This is the Header',
			'template_path' 	       => $pm->get_data('guildrequest', 'template_path'),
			'template_file'          => 'login.html',
			'display'                => true)
    );

?>  