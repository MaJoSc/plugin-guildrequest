<?PHP
/********************************************\
* Guildrequest Plugin for EQdkp plus         *
* ------------------------------------------ * 
* Project Start: 01/2009                     *
* Author: BadTwin                            *
* Copyright: Andreas (BadTwin) Schrottenbaum *
* Link: http://eqdkp-plus.com                *
* Version: 0.0.1                             *
\********************************************/



// EQdkp required files/vars
define('EQDKP_INC', true);        // is it in the eqdkp? must be set!!
define('PLUGIN', 'guildrequest');   // Must be set!
$eqdkp_root_path = './../../../';    // Must be set!
define('IN_ADMIN', true);         // Must be set if admin page
include_once($eqdkp_root_path . 'common.php');  // Must be set!
include_once('../include/common.php');  // Must be set!
$wpfccore->InitAdmin();

// Check if plugin is installed
if (!$pm->check(PLUGIN_INSTALLED, 'guildrequest')) { message_die('The guild request plugin is not installed.'); }

$user->check_auth('a_guildrequest_manage');

// ------- THE SOURCE PART - START -------
if ($_GET['delete']){
  $db->query("DELETE FROM __guildrequest_appvalues WHERE ID='".$_GET['delete']."'");
  $db->query("DELETE FROM __guildrequest_appoptions WHERE opt_ID='".$_GET['delete']."'");
  System_Message($user->lang['gr_ad_succ_del'], $user->lang['gr_ad_update_succ_hl'], 'green');
}

if ($_POST['welcometext']){
  $db->query("UPDATE __guildrequest_config SET config_value = '".$_POST['welcometext']."' WHERE config_name='gr_welcome_text'");

  $settings_qry = $db->query("SELECT * FROM __guildrequest_appvalues");
  while ($settings = $db->fetch_record($settings_qry)) {
    if ($_POST[$settings['value'].'_type'] != 'blankoption') {
      $appvalue = $_POST[$settings['value'].'_flag'];
      $apptype = $_POST[$settings['value'].'_type'];
      $apprequired = $_POST[$settings['value'].'_required'];
  	  $db->query("UPDATE __guildrequest_appvalues SET 
                  value = '".$appvalue."',
                  type = '".$apptype."',
                  required = '".$apprequired."' 
                WHERE value='".$settings['value']."'");
    } else {
      $succ = 'error';
    }
  }
  if ($succ != 'error'){
    System_Message($user->lang['gr_ad_succ_text'], $user->lang['gr_ad_succ_head'], 'green');
  } else {
    System_Message($user->lang['gr_ad_err_dropdown'], $user->lang['gr_write_error'], 'red');  
  }
}

if ($_POST['newfield']) {
	if ($_POST['newoption'] != 'blankoption'){
    $db->query("INSERT INTO __guildrequest_appvalues (value, type, required) VALUES ('".$_POST['newfield']."', '".$_POST['newoption']."', '".$_POST['newrequired']."')");
  } else {
    System_Message($user->lang['gr_ad_err_dropdown'], $user->lang['gr_write_error'], 'red');
  }
}

$settings_qry = $db->query("SELECT * FROM __guildrequest_config");
while ($settings = $db->fetch_record($settings_qry)) {
	$gr_set[$settings['config_name']] = $settings['config_value'];
}

// Output of the AppValues in the DB
$appvalues_qry = $db->query("SELECT * FROM __guildrequest_appvalues");
while ($appvalues = $db->fetch_record($appvalues_qry)){
  if ($appvalues['type'] == 'singletext'){
    $singletext = '<option selected="selected" value="singletext">'.$user->lang['gr_ad_form_singletext'].'</option>';
    $editdropdown = '';
  } else {
    $singletext = '<option value="singletext">'.$user->lang['gr_ad_form_singletext'].'</option>';
  }
  if ($appvalues['type'] == 'textfield'){
    $textfield = '<option selected="selected" value="textfield">'.$user->lang['gr_ad_form_textfield'].'</option>';
    $editdropdown = '';
  } else {
    $textfield = '<option value="textfield">'.$user->lang['gr_ad_form_textfield'].'</option>';
  }
  if ($appvalues['type'] == 'dropdown'){
    $dropdown = '<option selected="selected" value="dropdown">'.$user->lang['gr_ad_form_dropdown'].'</option>';
    $editdropdown = '<input type="button" name="add" value="'.$user->lang['gr_ad_editdropdown'].'" onclick="'.$jquery->Dialog_URL('EditForm'.rand(), $user->lang['gr_ad_editoptions'], 'addoptions.php?id='.$appvalues['ID'], '640', '450', 'formedit.php').'" class="mainoption" onmouseover="showWMTT(\'2\')" onmouseout="hideWMTT()"/>';
  } else {
    $dropdown = '<option value="dropdown">'.$user->lang['gr_ad_form_dropdown'].'</option>';
  }
  if ($appvalues['type'] == 'upload'){
    $upload = '<option selected="selected" value="upload">'.$user->lang['gr_ad_form_upload'].'</option>';
    $editdropdown = '';
  } else {
    $upload = '<option value="upload">'.$user->lang['gr_ad_form_upload'].'</option>';
  }

  if ($appvalues['required'] == 'Y') {
  	$req_yes = '<input checked="checked" type="radio" name="'.$appvalues['value'].'_required" value="Y">'.$user->lang['gr_poll_yes'];
  	$req_no = '<input type="radio" name="'.$appvalues['value'].'_required" value="N">'.$user->lang['gr_poll_no'];
  } else {
  	$req_yes = '<input type="radio" name="'.$appvalues['value'].'_required" value="Y">'.$user->lang['gr_poll_yes'];
  	$req_no = '<input checked="checked" type="radio" name="'.$appvalues['value'].'_required" value="N">'.$user->lang['gr_poll_no'];
  }
  $output .= '<tr class="'.$eqdkp->switch_row_class().'">
                <td><input name="'.$appvalues['value'].'_flag" value='.$appvalues['value'].'></td>
                <td><select name="'.$appvalues['value'].'_type">
                  <option value="blankoption">-----------</option>
                  '.$singletext.'
                  '.$textfield.'
                  '.$dropdown.'
                  '.$upload.'
                </td>
                <td>
                  '.$editdropdown.'
                </td>
                <td>
                  '.$req_yes.'
                  '.$req_no.'
                </td>
                <td>
                  <a href="formedit.php?delete='.$appvalues['ID'].'"><img src="'.$eqdkp_root_path.'images/global/delete.png" /></a>
                </td>
              </tr>';
}

// ------- THE SOURCE PART - END -------

   
// Send the Output to the template Files.
$tpl->assign_vars(array(
      'GR_WELCOMETEXT'    => $gr_set['gr_welcome_text'],
      'GR_OUTPUT'         => $output,

      'GR_TR_NEWCLASS'    => $eqdkp->switch_row_class(),

      'GR_EDITOR'        => $jquery->wysiwyg('welcometext'),
      
      'GR_AD_EDITFORM_F'     => $user->lang['gr_ad_editform_f'],
      'GR_WELCOMETEXT_F'  => $user->lang['gr_ad_headline_f'],
      'GR_FIELDNAME_F'      => $user->lang['gr_ad_fieldname_f'],
      'GR_FIELDTYPE_F'      => $user->lang['gr_ad_fieldtype_f'],
      'GR_REQUIREDFIELD_F'  => $user->lang['gr_ad_requiredfield_f'],
      
      //Options
      'GR_SINGLETEXT'       => $user->lang['gr_ad_form_singletext'],
      'GR_TEXTFIELD'        => $user->lang['gr_ad_form_textfield'],
      'GR_DROPDOWN'         => $user->lang['gr_ad_form_dropdown'],
      'GR_UPLOAD'           => $user->lang['gr_ad_form_upload'],
      'GR_YES'              => $user->lang['gr_poll_yes'],
      'GR_NO'               => $user->lang['gr_poll_no'],
    ));

// Init the Template
$eqdkp->set_vars(array(
	    'page_title'             => $eqdkp->config['guildtag'].' - '.$user->lang['request'],
			'template_path' 	       => $pm->get_data('guildrequest', 'template_path'),
			'template_file'          => 'admin/formedit.html',
			'display'                => true)
    );

?>