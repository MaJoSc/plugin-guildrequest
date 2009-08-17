<?PHP
  /**********************************************************************************\
  * Project:   GuildRequest2 for EQdkp-Plus                                          *
  * Licence:   Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported *
  * Link:      http://creativecommons.org/licenses/by-nc-sa/3.0/                     *
  *----------------------------------------------------------------------------------*
  * Rewrite:	 15.08.2009                                                            *
  *                                                                                  *
  * Author:    BadTwin                                                               *
  * Copyright: 2009 Andreas (BadTwin) Schrottenbaum                                  *
  * Link:      http://badtwin.dyndns.org                                             *
  * Package: Guildrequest                                                            *
  \**********************************************************************************/

	if (!defined('EQDKP_INC')) {
		header('HTTP/1.1 403 Forbidden');
		exit;
	}
  
  // Configuration
  $myPluginID       = 'guildrequest';
  $myPluginIncludes = 'includes';
  
	// EQDKP PLUS 0.7.x ++
	if(is_object($libloader)){
		$libloader->CheckLibVersion('Libraries', false, $pm->plugins[$myPluginID]->fwversion);
		$khrml = $html; $khrml->SetPluginName($myPluginID);
  
  // EQDKP PLUS 0.6.3.1 ++
	}else{
		if(!file_exists($eqdkp_root_path . 'libraries/libraries.php')) {
			message_die((($user->lang['libloader_notfound']) ? $user->lang['libloader_notfound'] : 'Library Loader not available! Check if the "eqdkp/libraries/" folder is uploaded correctly'));
		}
		require_once($eqdkp_root_path . 'libraries/libraries.php');
		$libloader  = new libraries();
		$libloader->CheckLibVersion('Libraries',false, $pm->plugins[$myPluginID]->fwversion);
		$jquery = $jqueryp; $khrml = new myHTML($myPluginID);
  }
?>