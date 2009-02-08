<?PHP
/********************************************\
* Guildrequest Plugin for EQdkp plus         *
* ------------------------------------------ * 
* Project Start: 01/2009                     *
* Author: BadTwin                            *
* Copyright: Andreas (BadTwin) Schrottenbaum *
* Link: http://eqdkp-plus.com                *
* Version: 0.0.2                             *
\********************************************/

// EQdkp required files/vars
define('EQDKP_INC', true);        // is it in the eqdkp? must be set!!
define('PLUGIN', 'guildrequest');   // Must be set!
$eqdkp_root_path = './../../';    // Must be set!
include_once($eqdkp_root_path . 'common.php');  // Must be set!

// Check if plugin is installed
if (!$pm->check(PLUGIN_INSTALLED, 'guildrequest')) { message_die('The guild request plugin is not installed.'); }

$user->check_auth('u_guildrequest_view');

// ------- THE SOURCE PART - START -------
// --- Open/Close the request - start ---
if (isset($_POST['admin'])){
  $db->query("UPDATE __guildrequest SET closed='".$_POST['newstatus']."' WHERE id='".$_POST['request_id']."'");
  if ($_POST['newstatus'] == 'N') {
    System_Message($user->lang['gr_vr_ad_opened'], $user->lang['gr_vr_ad_opened_f'], 'green');  	
  } else {
    System_Message($user->lang['gr_vr_ad_closed'], $user->lang['gr_vr_ad_closed_f'], 'red');  	
  }

}
// --- Open/Close the request - end ---
if (isset($_POST['act_submit'])){
  $db->query("UPDATE __guildrequest SET activated='Y' WHERE id='".$_POST['not_act_id']."'");
  System_Message($user->lang['gr_vr_ad_activated'], $user->lang['gr_vr_ad_activated_f'], 'green');  	
}

if (isset($_POST['del_submit'])) {
  $db->query("DELETE FROM __guildrequest WHERE id='".$_POST['request_id']."'");
  System_Message($user->lang['gr_vr_ad_deleted'], $user->lang['gr_vr_ad_deleted_f'], 'red');
}

if (isset($_POST['del_not_act'])) {
  $db->query("DELETE FROM __guildrequest WHERE id='".$_POST['not_act_id']."'");
  System_Message($user->lang['gr_vr_ad_deleted'], $user->lang['gr_vr_ad_deleted_f'], 'red');
}

// Display the Overview
if (!isset($_GET['request_id'])){
  $listrequest_query = $db->query("SELECT * FROM __guildrequest WHERE closed='N' AND activated='Y' ORDER BY id desc");
  while($listquery = $db->fetch_record($listrequest_query)){
    // Check, if already voted
    $votecheck_query = $db->query("SELECT * FROM __guildrequest_poll WHERE query_id = '".$listquery['id']."' AND user_id = '".$user->data['user_id']."'");
    $votecheck = $db->num_rows($votecheck_query);
    $db->free_result($votecheck_query);

    if ($votecheck != '1'){
      $votecheck = '<font class="negative"><b>'.$user->lang['gr_vr_not_voted'].'</b></font>';
    } else {
      $votecheck = '<font class="positive">'.$user->lang['gr_vr_voted'].'</font>';
    }

    $requesttext = $bbcode->toHTML($listquery['text']);
    $bbcode->SetSmiliePath($eqdkp_root_path.'libraries/jquery/images/editor/icons');
    $requesttext = $bbcode->MyEmoticons($requesttext);
    $requesttext = strip_tags($requesttext, '<br><img>');

    $tpl->assign_block_vars('request_list', array(
			'GR_ROW_CLASS'	=> $eqdkp->switch_row_class(),
      'GR_USERNAME'   => $listquery['username'],
      'GR_TEXT'       => $requesttext,
      'GR_REQUEST_ID' => $listquery['id'],
      'GR_VOTECHECK'  => $votecheck,
		));
	}
	
	// --- the admin part - start ---
  if ($user->check_auth('a_guildrequest_manage', false)){
    $adminlistrequest_query = $db->query("SELECT * FROM __guildrequest WHERE closed='Y' AND activated='Y' ORDER BY id desc");
    while($adminlistquery = $db->fetch_record($adminlistrequest_query)){    
      $requesttext = $bbcode->toHTML($adminlistquery['text']);
      $bbcode->SetSmiliePath($eqdkp_root_path.'libraries/jquery/images/editor/icons');
      $requesttext = $bbcode->MyEmoticons($requesttext);
      $requesttext_closed = strip_tags($requesttext, '<br><img>');
    
      $tpl->assign_block_vars('admin_request_list', array(
			  'GR_ROW_CLASS'	=> $eqdkp->switch_row_class(),
        'GR_USERNAME'   => '<a href="viewrequest.php?request_id='.$adminlistquery['id'].'">'.$adminlistquery['username'].'</a>',
        'GR_TEXT'       => '<a href="viewrequest.php?request_id='.$adminlistquery['id'].'">'.$requesttext_closed.'</a>',
        'GR_REQUEST_ID' => $adminlistquery['id'],
		  ));
		  $admin_user_f = $user->lang['gr_username_f'];
		  $admin_text_f = $user->lang['gr_text_f'];
      $adminonly = $user->lang['gr_ad_adminonly'];
      $admin_not_activated = $user->lang['gr_not_activated'];
    }
    
    if (!isset($requesttext_closed)) {
      $tpl->assign_block_vars('admin_request_list', array(
			  'GR_ROW_CLASS'	=> $eqdkp->switch_row_class(),
        'GR_TEXT'       => $user->lang['gr_no_requests'],
		  ));    	
    }
    
    $adminlistrequest_query = $db->query("SELECT * FROM __guildrequest WHERE activated='N' ORDER BY id desc");
    while($adminlistquery = $db->fetch_record($adminlistrequest_query)){    
      $requesttext = $bbcode->toHTML($adminlistquery['text']);
      $bbcode->SetSmiliePath($eqdkp_root_path.'libraries/jquery/images/editor/icons');
      $requesttext = $bbcode->MyEmoticons($requesttext);
      $requesttext_not_act = strip_tags($requesttext, '<br><img>');
    
      $tpl->assign_block_vars('admin_not_activated_list', array(
			  'GR_ROW_CLASS'	=> $eqdkp->switch_row_class(),
        'GR_USERNAME'   => '<a href="viewrequest.php?request_id='.$adminlistquery['id'].'">'.$adminlistquery['username'].'</a>',
        'GR_TEXT'       => '<a href="viewrequest.php?request_id='.$adminlistquery['id'].'">'.$requesttext_not_act.'</a>',
        'GR_REQUEST_ID' => $adminlistquery['id'],
		  ));
		  $admin_user_f = $user->lang['gr_username_f'];
		  $admin_text_f = $user->lang['gr_text_f'];
      $adminonly = $user->lang['gr_ad_adminonly'];
      $admin_not_activated = $user->lang['gr_not_activated'];
    }

    if (!isset($requesttext_not_act)) {
      $tpl->assign_block_vars('admin_not_activated_list', array(
			  'GR_ROW_CLASS'	=> $eqdkp->switch_row_class(),
        'GR_TEXT'       => $user->lang['gr_no_requests'],
		  ));    	
    }


  }
  // --- the admin part - end ---
  
  $listrequests = true;
  $showrequest = false;
  
// View the Request
} else {
  
  // --- comment system - start ---
	if(is_object($pcomments) && $pcomments->version > '1.0.3'){
    $comm_settings = array(
      'attach_id' => $_GET['request_id'], 
      'page'      => 'guildrequest',
      'auth'      => '_u_guildrequest'
    );
		$pcomments->SetVars($comm_settings);
		$tpl->assign_vars(array(
			'ENABLE_COMMENTS'     => true,
			'COMMENTS'            => $pcomments->Show(),
      ));
    }
  // --- comment system - end ---
  
  // --- the admin part - start ---
  if ($user->check_auth('a_guildrequest_manage', false)){
  $change_query = $db->query("SELECT * FROM __guildrequest WHERE id='".$_GET['request_id']."'");
  $change = $db->fetch_record($change_query);
  
  if ($change['closed'] == 'Y') {
    $yes_sel = ' checked';
  } elseif ($change['closed'] == 'N'){
    $no_sel = ' checked';
  }

  $changestatus = '<form action="viewrequest.php" method="POST">
    <input type="hidden" name="request_id" value="'.$_GET['request_id'].'">
    <input type="radio" name="newstatus" value="N"'.$no_sel.'>'.$user->lang['gr_poll_ad_opened'].'<br>
    <input type="radio" name="newstatus" value="Y"'.$yes_sel.'>'.$user->lang['gr_poll_ad_closed'].'<br>
		<input type="submit" name="admin" value="'.$user->lang['gr_poll_ad_save'].'" class="mainoption">
		</form>';
	}
  // --- the admin part - end ---  
  
  // Get the settings
  $settings_query = $db->query("SELECT * FROM __guildrequest_config");
  while ($settings = $db->fetch_record($settings_query)) {
  	$setting[$settings['config_name']] = $settings['config_value'];
  }
  // --- the poll part - start ---
  if ($setting['gr_poll_activated'] == 'Y'){
    $not_voted = true;
    $already_voted = false;
    
    $pollcheck_query = $db->query("SELECT * FROM __guildrequest_poll WHERE query_id='".$_GET['request_id']."' AND user_id='".$user->data['user_id']."'");
    $pollcheck = $db->num_rows($pollcheck_query);

    $pollclosed_query = $db->query("SELECT * FROM __guildrequest WHERE id='".$_GET['request_id']."'");
    $pollclosed = $db->fetch_record($pollclosed_query);

      if ($pollcheck != 0) {
       	$not_voted = false;
      	$already_voted = true;
      }
  
      if ($not_voted == true) {
        if ($pollclosed['closed'] == 'N'){
          if (isset($_GET['accept'])){
            $vote_sql = $db->query("INSERT INTO __guildrequest_poll (query_id, user_id, poll_value) VALUES ('".$_GET['request_id']."', '".$user->data['user_id']."', 'Y')");
            $not_voted = false;
            $already_voted = true;
          } elseif (isset($_GET['decline'])){
            $vote_sql = $db->query("INSERT INTO __guildrequest_poll (query_id, user_id, poll_value) VALUES ('".$_GET['request_id']."', '".$user->data['user_id']."', 'N')");
            $not_voted = false;
            $already_voted = true;
          }
        }
      }
  
      if ($already_voted == true) {
        $vote_sum_count_query = $db->query("SELECT * FROM __guildrequest_poll WHERE query_id='".$_GET['request_id']."'");
        $vote_sum_count = $db->num_rows($vote_sum_count_query);
    
        $vote_yes_count_query = $db->query("SELECT * FROM __guildrequest_poll WHERE query_id='".$_GET['request_id']."' AND poll_value='Y'");
        $vote_yes_count = $db->num_rows($vote_yes_count_querey);
    
        $vote_yes = round(($vote_yes_count/$vote_sum_count)*100);
        $vote_no = (100 - $vote_yes);
    
     	  $poll_yes_bar = create_bar($vote_yes);
    	  $poll_no_bar = create_bar($vote_no);
      }
    } else {
      $not_voted = false;
      $already_voted = false;
    }  
  // --- the poll part - end ---
  

  $request_query = $db->query("SELECT * FROM __guildrequest WHERE id='".$_GET['request_id']."'");
  $request = $db->fetch_record($request_query);

  $listrequests = false;
  $showrequest = true;
  
  $requesttext = $bbcode->toHTML($request['text']);
  $bbcode->SetSmiliePath($eqdkp_root_path.'libraries/jquery/images/editor/icons');
  $requesttext = $bbcode->MyEmoticons($requesttext);
}

// ------- THE SOURCE PART - END -------

   
// Send the Output to the template Files.
$tpl->assign_vars(array(
      'GR_USERNAME'   => $request['username'],
      'GR_VIEWREQUEST' => $user->lang['gr_view'], 
      'GR_TEXT'       => $requesttext,
      'GR_USERNAME_F' => $user->lang['gr_username_f'],
      'GR_TEXT_F'     => $user->lang['gr_text_f'],
      'GR_ADMIN_ONLY' => $adminonly,
      'GR_ADMIN_USER_F' => $admin_user_f,
      'GR_ADMIN_TEXT_F' => $admin_text_f,
      'GR_ADMIN_NOT_ACTIVATED_F' => $admin_not_activated,
      'GR_REQUEST_ID' => $_GET['request_id'],
      'GR_AD_DELETE'  => $user->lang['gr_ad_delete'],
      'GR_AD_ACTIVATE'  => $user->lang['gr_ad_activate'],
      'GR_LISTREQUESTS' => $listrequests,
      'GR_SHOWREQUEST' => $showrequest,
      'GR_SHOWREQUEST_HEADLINE' => $user->lang['gr_showrequest_headline'],
      'GR_GOBACK'     => $user->lang['gr_goback'],
      'GR_ALREADY_VOTED' => $already_voted,
      'GR_POLL_HEADLINE'  => $user->lang['gr_poll_headline'],
      'GR_POLL_YES_F'   => $user->lang['gr_poll_yes'],
      'GR_POLL_YES_B'   => $poll_yes_bar,
      'GR_POLL_NO_F'   => $user->lang['gr_poll_no'],
      'GR_POLL_NO_B'   => $poll_no_bar,
      'GR_NOT_VOTED'  => $not_voted,
      'GR_AD_CHANGE_STATUS'  => $changestatus,
      'GR_INFOBOX'          => $infobox,
    ));

// Init the Template
$eqdkp->set_vars(array(
	    'page_title'             => $eqdkp->config['guildtag'].' - '.$user->lang['request'],
			'template_path' 	       => $pm->get_data('guildrequest', 'template_path'),
			'template_file'          => 'viewrequest.html',
			'display'                => true)
    );

?> 