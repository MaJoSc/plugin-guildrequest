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

		$row=1;
		for ($row=1; $row <= 255; $row++){
			if ($in->get($row.'_id') != ''){
				$db->query("UPDATE __guildrequest_appvalues SET :params WHERE id='".$row."'", array(
											'id'				=> $db->escape($in->get($row.'_id', 0)),
											'value'			=> $db->escape($in->get($row.'_value', '')),
											'type'			=> $db->escape($in->get($row.'_type', '')),
											'required'	=> $db->escape($in->get($row.'_required', '')),
											'sort'			=> $db->escape($in->get($row.'_sort', 0)),
							));
			}
		}
}

// Generate the Output
//	$form_output = '<table width="100%" border="0">';
	if ($in->get('form_preview')){
		for ($row=1; $row <= 1024; $row++){
			if ($in->get($row.'_id') != ''){
				$line[$row]['id']				= $in->get($row.'_id', 0);
				$line[$row]['value']		= $in->get($row.'_value', '');
				$line[$row]['type']			= $in->get($row.'_type', '');
				$line[$row]['required']	= $in->get($row.'_required', '');
				$line[$row]['sort']			= $in->get($row.'_sort', 0);
			}
		}
	} else {
		$form_sql = $db->query("SELECT * FROM __guildrequest_appvalues ORDER BY sort");
		$row = 1;
		while ($form_qry = $db->fetch_record($form_sql)){
			$line[$row]['id'] 			= $form_qry['id'];
			$line[$row]['value']		= $form_qry['value'];
			$line[$row]['type']			= $form_qry['type'];
			$line[$row]['required']	= $form_qry['required'];
			$line[$row]['sort']			= $form_qry['sort'];
			$row++;
		}
	}

	$form_output = '<table width="100%">';
	foreach ($line as $out){
		$form_output .= '<tr class="'.$eqdkp->switch_row_class().'">
											<td><input name="'.sanitize($out['id']).'_id" value="'.sanitize($out['id']).'" /></td>
											<td><input name="'.sanitize($out['id']).'_value" value="'.sanitize($out['value']).'" /></td>
											<td><input name="'.sanitize($out['id']).'_type" value="'.sanitize($out['type']).'" /></td>
											<td><input name="'.sanitize($out['id']).'_required" value="'.sanitize($out['required']).'" /></td>
											<td><input name="'.sanitize($out['id']).'_sort" value="'.sanitize($out['sort']).'" /></td>
										</tr>';
	}
	$form_output .= '</table>';

// Deliver the output to the template
$tpl->assign_vars(array (
	'GR_FILE'						=> 'formedit.php' . $SID,

	'GR_WELCOME'				=> $jquery->wysiwyg('welcometext').'<textarea name="welcometext" id="welcometext" class="jTagEditor">'.sanitize($conf['gr_welcome_text']).'</textarea>',
	'GR_FORM_OUTPUT'		=> $form_output,


	// Language Terms
	'GR_F_WELCOME'			=> $user->lang['gr_admin_f_welcome'],
	'GR_F_TITLE'				=> $user->lang['gr_admin_menu_formedit'],
	'GR_F_PREVIEW'			=> $user->lang['gr_admin_f_preview'],

	'GR_SAVE'						=> $user->lang['gr_save'],
	'GR_RESET'					=> $user->lang['gr_reset'],
));

$eqdkp->set_vars(array (
	'page_title' => sprintf($user->lang['admin_title_prefix'], $eqdkp->config['guildtag'], $eqdkp->config['dkp_name']).': '.$user->lang['guildrequest'],
	'template_path' => $pm->get_data('guildrequest', 'template_path'),
	'template_file' => 'admin/formedit.html', 'display' => true
	)
);
?>