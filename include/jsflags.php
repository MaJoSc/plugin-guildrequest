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

  global $bbcode, $tpl, $db, $eqdkp_root_path;

  $poll_query = $db->query("SELECT * FROM __guildrequest_config WHERE config_name = 'gr_poll_activated'");
  $poll = $db->fetch_record($poll_query);
  
  if ($poll['config_value'] == 'Y'){

 	  if ($user->check_auth('u_guildrequest_view', false)){

      $request_query = $db->query("SELECT * FROM __guildrequest WHERE activated='Y' AND closed='N'");
      while ($request = $db->fetch_record($request_query)) {
        $vote_query = $db->query("SELECT * FROM __guildrequest_poll WHERE query_id = '".$request['id']."' AND user_id ='".$user->data['user_id']."'");
        $vote = $db->fetch_record($vote_query);
        if (!isset($vote['id'])){
          if (strlen($request['text']) >= 35){
            $requesttext = substr($request['text'], 0, 35).'...';
          } else {
            $requesttext = $request['text'];
          }
          $requesttext = $bbcode->toHTML($requesttext);
          $bbcode->SetSmiliePath($eqdkp_root_path.'libraries/jquery/images/editor/icons');
          $requesttext = $bbcode->MyEmoticons($requesttext);
          $request_text = strip_tags($requesttext, '<br><img>');
          $request_text = '<a href="'.$eqdkp_root_path.'plugins/guildrequest/viewrequest.php?request_id='.$request['id'].'"><b>'.$request_text.'</b></a>';
          $request_from = '<a href="'.$eqdkp_root_path.'plugins/guildrequest/viewrequest.php?request_id='.$request['id'].'">'.$user->lang['gr_pu_new_query'].$request['username'].'</a>';
          
          System_Message($request_text, $request_from, 'default');
        }
      }

      $db->free_result($poll_query);
      $db->free_result($request_query);
      $db->free_result($votecheck_query); 
    }
  }
?>