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
  
  if ($user->data['user_id'] != ANONYMOUS){
  	
    if ($poll['config_value'] == 'Y'){

 	    if ($user->check_auth('u_guildrequest_view', false)){

        $request_query = $db->query("SELECT * FROM __guildrequest WHERE activated='Y' AND closed='N'");
        while ($request = $db->fetch_record($request_query)) {
          $vote_query = $db->query("SELECT * FROM __guildrequest_poll WHERE query_id = '".$request['id']."' AND user_id ='".$user->data['user_id']."'");
          $vote = $db->fetch_record($vote_query);
          if (!isset($vote['id'])){
            $request_text = '<a href="'.$eqdkp_root_path.'plugins/guildrequest/viewrequest.php?request_id='.$request['id'].'"><b>'.$user->lang['gr_vr_view'].'</b></a>';
            $request_from = '<a href="'.$eqdkp_root_path.'plugins/guildrequest/viewrequest.php?request_id='.$request['id'].'">'.$user->lang['gr_pu_new_query'].'<i>'.$request['username'].'</i></a>';
          
            System_Message($request_text, $request_from, 'default');
          }
        }

        $db->free_result($poll_query);
        $db->free_result($request_query);
        $db->free_result($votecheck_query); 
      }
    }
}
?>