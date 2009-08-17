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
		
	if (!isset($eqdkp_root_path) ){
		$eqdkp_root_path = './';
	}
	include_once($eqdkp_root_path . 'common.php');
	
	/**
	* Framework include
	**/
	include_once($eqdkp_root_path . 'plugins/guildrequest/includes/libloader.inc.php');
	
	/**
	* Load the global Configuration
	*/
	$sql = 'SELECT * FROM __guildrequest_config';
	if (!($settings_result = $db->query($sql))) {
		message_die('Could not obtain configuration data', '', __FILE__, __LINE__, $sql);
	}
	while($roww = $db->fetch_record($settings_result)) {
		$conf[$roww['config_name']] = $roww['config_value'];
	}
	$db->free_result($settings_result);
	
	/**
	* Alpha/Beta Markup
	*/
	if(strtolower($pm->plugins['guildrequest']->vstatus) == 'alpha'){
		$tpl->assign_vars(array(
			'ALPHA_STATUS'   => true
		));
	}
	if(strtolower($pm->plugins['guildrequest']->vstatus) == 'beta'){
		$tpl->assign_vars(array(
			'BETA_STATUS'   => true
		));
	}
?>
