<?PHP
/*********************************************\
*            Gallery 4 EQdkp-Plus             *
* ------------------------------------------- *
* Project Start: 09/2008                      *
* Author: BadTwin                             *
* Copyright: Andreas (BadTwin) Schrottenbaum  *
* Link: http:// bloody-midnight.eu            *
* Version: 0.0.1                              *
* ------------------------------------------- *
* Based on the HelloWorld Plugin by Wallenium *
\*********************************************/


	
if ( !defined('EQDKP_INC') ){
    header('HTTP/1.0 404 Not Found');exit;
}


// You have to define the Module Information
$portal_module['guildrequest'] = array(        			    // the same name as the folder!
			'name'			   => 'Guild Request Warning',   						// The name to show
			'path'			   => 'guildrequest',                 // Folder name again
			'version'		   => '0.0.1',            							// Version
			'author'       => 'BadTwin',             						// Author
			'contact'		   => 'andreas.schrottenbaum@gmx.at',   		// email adress
			'description'  => 'Display a Warning, if new requests exitst',     			// Detailed Description
			'positions'    => array('left1', 'middle', 'left2', 'right'), // Which blocks should be usable? left1 (over menu), left2 (under menu), right, middle
      'signedin'     => '0',								              // 0 = all users, 1 = signed in only
      'install'      => array(
			                   'autoenable'        => '1',      // 0 = disable on install , 1 = enable on install
			                   'defaultposition'   => 'middle',  // see blocks above
			                   'defaultnumber'     => '2',      // default ordering number
			                   ),
    );

// The output function
// the name MUST be FOLDERNAME_module, if not an error will occur
if(!function_exists(guildrequest_module)){
  function guildrequest_module(){
  global $eqdkp , $db , $eqdkp_root_path , $user , $tpl, $db, $plang, $conf_plus, $comments;
 	if ($user->check_auth('u_guildrequest_view', false)){

    $request_query = $db->query("SELECT * FROM __guildrequest WHERE activated='Y' AND closed='N'");
    $notvoted_count = 0;
    while ($request = $db->fetch_record($request_query)) {
    	$votecheck_query = $db->query("SELECT * FROM __guildrequest_poll WHERE query_id='".$request['id']."' AND user_id = '".$user->data['user_id']."'");
      $votecheck = $db->num_rows($votecheck_query);
      if ($votecheck != 1){
        $notvoted_count = $notvoted_count + 1; 
      }
    }
    
   if ($notvoted_count == 1) {
      $guildrequest_output = $image.'<a href="'.$eqdkp_root_path.'plugins/guildrequest/viewrequest.php"><b><font class="negative">'.$user->lang['gr_pm_one_not_voted'].'</font></b></a>';
   } elseif ($notvoted_count >= 1){
      $guildrequest_output = $image.'<a href="'.$eqdkp_root_path.'plugins/guildrequest/viewrequest.php"><b><font class="negative">'.$user->lang['gr_pm_not_voted_1'].$notvoted_count.$user->lang['gr_pm_not_voted_2'].'</font></b></a>';   
   }

   $image = '<img src="'.$eqdkp_root_path.'plugins/guildrequest/images/write-document-64x64.png">';
   
   $gr_out = '<table align="center">
    <tr>
      <td>
        '.$image.'
      </td>
      <td>
        '.$guildrequest_output.'
      </td>
    </tr>
   </table>'; 
    
    // return the output for module manager
		return $gr_out;
 	}
  }
}
?>