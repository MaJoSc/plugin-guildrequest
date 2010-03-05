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
  * Package:   Guildrequest                                                          *
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
	* Load the global Configuration
	**/
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
	**/
	if(strtolower($pm->plugins['guildrequest']->vstatus) == 'alpha'){
		$tpl->assign_vars(array(
			'STATUS'   => '	<table style="border: 4px red solid;" cellpadding="30" width="100%" bgcolor="white">
												<tr>
													<td>
														<h1><font color="red"><center>
															DIES IST EINE ALPHA-VERSION UND NOCH IM ENTWICKLUNGSSTADIUM!<br />
															DIESE VERSION IST KEINESFALLS F&Uuml;R DEN PRODUKTIVEN EINSATZ GEDACHT!
														</center></font></h1>
													</td>
												</tr>
											</table>'
		));
	} elseif(strtolower($pm->plugins['guildrequest']->vstatus) == 'beta'){
		$tpl->assign_vars(array(
			'STATUS'   => '	<table style="border: 4px red solid;" cellpadding="30" width="100%" bgcolor="white">
												<tr>
													<td>
														<h1><font color="red"><center>
															DIES IST EINE BETA-VERSION!<br />
															WENN DU BUGS ENTDECKST, MELDE DIE BITTE AUF <a style="color: red; text-decoration: underline;" href="http://www.eqdkp-plus.com/forum">EQdkp-PLUS.com</a>!
														</center></font></h1>
													</td>
												</tr>
											</table>'
		));
	}

	
	/**
	* The Footer with Credits
	**/
	$tpl->assign_vars(array(
		'GR_FOOTER'	=> '<script language="JavaScript" type="text/javascript">
											function aboutDialog(){
												'.$jquery->Dialog_URL('GRAbout', $user->lang['gr_about_header'], $eqdkp_root_path . 'plugins/guildrequest/about.php', '400', '300').'
											}
										</script>
										<table width="100%" cellpadding="20">
											<tr>
												<td align="center">
													<a onclick="javascript:aboutDialog()" style="cursor:pointer;" onmouseover="style.textDecoration=\'underline\';" onmouseout="style.textDecoration=\'none\';">
      											<img src="'.$eqdkp_root_path . 'plugins/guildrequest/images/credits/info.png" alt="Credits" border="0" /> Credits
													</a>
													<br />Guildrequest '.$pm->get_data('guildrequest', 'version').' &copy; 2009 BadTwin
												</td>
											</tr>
										</table>'
	));
?>