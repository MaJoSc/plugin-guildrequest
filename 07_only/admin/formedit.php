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

define('EQDKP_INC', true);
define('IN_ADMIN', true);
define('PLUGIN', 'guildrequest');
$eqdkp_root_path = './../../../';

include_once('../includes/common.php');

// Check user permission
$user->check_auth('a_guildrequest_manage');

if (!$pm->check(PLUGIN_INSTALLED, 'guildrequest')) {
	message_die('The Guildrequest plugin is not installed.');
}

// Save the settings
if ($in->get('form_submit')){
	$db->query("UPDATE __guildrequest_config SET config_value='".$db->escape($in->get('welcometext', ''))."' WHERE config_name='gr_welcome_text'");

	$conf['gr_welcome_text'] = $in->get('welcometext', '');

		$db->query("TRUNCATE TABLE `eqdkp_guildrequest_appvalues");
		$row=1;
		for ($row=1; $row <= 1024; $row++){
			if ($in->get($row.'_id') != ''){
				$db->query("INSERT INTO __guildrequest_appvalues :params", array(
											'id'				=> $db->escape($in->get($row.'_id', 0)),
											'value'			=> $db->escape($in->get($row.'_value', '')),
											'type'			=> $db->escape($in->get($row.'_type', '')),
											'required'	=> $db->escape($in->get($row.'_required', '')),
											'sort'			=> $db->escape($in->get($row.'_sort', 0)),
							));
			}
		}
		System_Message('<center>'.$user->lang['gr_js_saved'].'<br />&nbsp;</center>', '<H2><center>'.$user->lang['gr_js_saved_head'].'</center></H2>', 'green');
}

// Generate the Output
	if (($in->get('form_preview', '')) or ($in->get('form_addrow')) or ($in->get('delrow'))){
		for ($row=1; $row <= 1024; $row++){
			if (($in->get($row.'_id', 0)) && ($in->get('delrow', '') != $row)){
				$line[$row]['id']				= $in->get($row.'_id', 0);
				$line[$row]['value']		= $in->get($row.'_value', '');
				$line[$row]['type']			= $in->get($row.'_type', '');
				$line[$row]['required']	= $in->get($row.'_required', '');
				$line[$row]['sort']			= $in->get($row.'_sort', 0);
				$line[$row]['new']			= $in->get($row.'_new', 0);
			}
		}
		if ($in->get('form_addrow', '')){
			$row++;
			$line[$row]['id']				= $in->get('new_id', '');
			$line[$row]['value']		= $in->get('new_value', '');
			$line[$row]['type']			= $in->get('new_type', '');
			$line[$row]['required']	= $in->get('new_required', '');
			$line[$row]['sort']			= $in->get('new_sort', 0);
			$line[$row]['new']			= 1;
		} else {
			if (!$in->get('delrow')){
				$tpl->assign_vars(array (
					'PREVIEW'		=> '<script language="JavaScript" type="text/javascript">
												function preview(){
													'.$jquery->Dialog_URL('GRPreview', $user->lang['gr_admin_f_preview'], $eqdkp_root_path . 'plugins/guildrequest/admin/preview.php?line='.addslashes(serialize($line)), '800', '600').'
												}
											</script>
											<body onload="javascript:preview()">
											</body>',
				));
			}
		}
		$core->message('<center>'.$user->lang['gr_js_notsaved'].'<br />&nbsp;</center>', '<H2><center>'.$user->lang['gr_js_warning'].'</center></H2>', 'red');
	} else {
		$form_sql = $db->query("SELECT * FROM __guildrequest_appvalues");
		$row = 1;
		while ($form_qry = $db->fetch_record($form_sql)){
			$line[$row]['id'] 			= $form_qry['id'];
			$line[$row]['value']		= $form_qry['value'];
			$line[$row]['type']			= $form_qry['type'];
			$line[$row]['required']	= $form_qry['required'];
			$line[$row]['sort']			= $form_qry['sort'];
			$line[$row]['new']			= 0;
			$row++;
		}
	}


	// Order Output by sorting
	foreach ($line as $key => $row) {
			$sort[$key] = $row['sort'];
	}
	array_multisort($sort, $line);

	$form_output = '';
	foreach ($line as $out){

		// Check the 'required' fields
		if ($out['required'] == 'Y'){
			$req_yes = ' checked="checked"';
			$req_no = '';
		} else {
			$req_yes = '';
			$req_no = ' checked="checked"';
		}


		switch($out['type']){
			case 'singletext':
				$selbox = '<select name="'.sanitize($out['id']).'_type">
										<option value="singletext" selected="selected">Einfache Zeile</option>
										<option value="textfield">Textfeld</option>
										<option value="dropdown">Auswahlliste</option>
									</select>';
				break;
			case 'textfield':
				$selbox = '<select name="'.sanitize($out['id']).'_type">
										<option value="singletext">Einfache Zeile</option>
										<option value="textfield" selected="selected">Textfeld</option>
										<option value="dropdown">Auswahlliste</option>
									</select>';
				break;
			case 'dropdown':
				$selbox = '<select name="'.sanitize($out['id']).'_type">
										<option value="singletext">Einfache Zeile</option>
										<option value="textfield">Textfeld</option>
										<option value="dropdown" selected="selected">Auswahlliste</option>
									</select><input type="submit" value="dropdown" />';
				break;
			default:
				$selbox = $out['type'];
		}
		$form_output .= '<tr class="'.$core->switch_row_class().'">
											<td>
												<input type="hidden" name="'.sanitize($out['id']).'_id" value="'.sanitize($out['id']).'" />
												<input type="text" name="'.sanitize($out['id']).'_value" value="'.sanitize($out['value']).'" />
											</td>
											<td>'.$selbox.'</td>
											<td>
												<input type="radio" name="'.sanitize($out['id']).'_required" value="Y"'.$req_yes.' />'.$user->lang['gr_yes'].'
												<input type="radio" name="'.sanitize($out['id']).'_required" value="N"'.$req_no.' />'.$user->lang['gr_no'].'
											</td>
											<td>
												<input type="text" name="'.sanitize($out['id']).'_sort" size="5" value="'.sanitize($out['sort']).'" />
												<input type="hidden" name="'.sanitize($out['id']).'_new" value="'.sanitize($out['new']).'" />
											</td>
											<td>
												<input type="image" src="./../images/delete.png" name="delrow" value="'.$out['id'].'" />
											</td>
										</tr>';
	}

// Deliver the output to the template
$tpl->assign_vars(array (
	'GR_FILE'						=> 'formedit.php' . $SID,

	'GR_WELCOME'				=> $jquery->wysiwyg('welcometext').'<textarea name="welcometext" id="welcometext" class="jTagEditor">'.sanitize($conf['gr_welcome_text']).'</textarea>',
	'GR_FORM_OUTPUT'		=> $form_output,

	'GR_NEW_ID'					=> $out['id']+1,
	'GR_NEW_SORT'				=> $out['sort']+1,

	// Language Terms
	'GR_F_WELCOME'			=> $user->lang['gr_admin_f_welcome'],
	'GR_F_TITLE'				=> $user->lang['gr_admin_menu_formedit'],
	'GR_F_PREVIEW'			=> $user->lang['gr_admin_f_preview'],
	'GR_F_NEWLINE'			=> $user->lang['gr_admin_f_newline'],

	'GR_F_HL_TITLE'			=> $user->lang['gr_admin_f_hl_title'],
	'GR_F_HL_TYPE'			=> $user->lang['gr_admin_f_hl_type'],
	'GR_F_HL_REQUIRED'	=> $user->lang['gr_admin_f_hl_required'],
	'GR_F_HL_SORT'			=> $user->lang['gr_admin_f_hl_sort'],

	'GR_YES'						=> $user->lang['gr_yes'],
	'GR_NO'							=> $user->lang['gr_no'],
	'GR_SAVE'						=> $user->lang['gr_save'],
	'GR_RESET'					=> $user->lang['gr_reset'],
));

$core->set_vars(array (
	'page_title' => sprintf($user->lang['admin_title_prefix'], $core->config['guildtag'], $core->config['dkp_name']).': '.$user->lang['guildrequest'],
	'template_path' => $pm->get_data('guildrequest', 'template_path'),
	'template_file' => 'admin/formedit.html', 'display' => true
	)
);
?>