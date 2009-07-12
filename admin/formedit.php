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
  $db->query("DELETE FROM __guildrequest_appvalues WHERE ID='".$in->get('delete', 0)."'");
  $db->query("DELETE FROM __guildrequest_appoptions WHERE opt_ID='".$in->get('delete', 0)."'");
  System_Message($user->lang['gr_ad_succ_del'], $user->lang['gr_ad_update_succ_hl'], 'green');
}

if ($_POST['welcometext']){
  $db->query("UPDATE __guildrequest_config SET config_value = '".$in->get('welcometext')."' WHERE config_name='gr_welcome_text'");

  $settings_qry = $db->query("SELECT * FROM __guildrequest_appvalues");
  while ($settings = $db->fetch_record($settings_qry)) {
    if ($_POST[$settings['ID'].'_type'] != 'blankoption') {
      $appvalue = $_POST[$settings['ID'].'_flag'];
      $apptype = $_POST[$settings['ID'].'_type'];
      $apprequired = $_POST[$settings['ID'].'_required'];
  	  $db->query("UPDATE __guildrequest_appvalues SET 
                  value = '".$appvalue."',
                  type = '".$apptype."',
                  required = '".$apprequired."' 
                WHERE ID='".$settings['ID']."'");
    } else {
      $succ = 'error';
    }
  }
  if ($succ == 'error'){
    System_Message($user->lang['gr_ad_err_dropdown'], $user->lang['gr_write_error'], 'red');  
  }
}

if ($_POST['newfield']) {
	if ($_POST['newoption'] != 'blankoption'){
	  $lastcount_qry = $db->query("SELECT * FROM __guildrequest_appvalues ORDER BY sort DESC");
	  $lastcount = $db->fetch_record($lastcount_qry);
	  if ($_POST['newrequired'] == 'Y') {
   	  $required = 'Y';
    } else {
      $required = 'N';
    }
	  $newsort = $lastcount['sort'] + 1;
    $db->query("INSERT INTO __guildrequest_appvalues (value, type, required, sort) VALUES ('".$_POST['newfield']."', '".$_POST['newoption']."', '".$required."', '".$newsort."')");
  } else {
    System_Message($user->lang['gr_ad_err_dropdown'], $user->lang['gr_write_error'], 'red');
  }
}

$settings_qry = $db->query("SELECT * FROM __guildrequest_config");
while ($settings = $db->fetch_record($settings_qry)) {
	$gr_set[$settings['config_name']] = $settings['config_value'];
}

if ($_GET['moveup']){
  $oldsort_qry = $db->query("SELECT * FROM __guildrequest_appvalues WHERE ID=".$in->get('moveup'));
  $oldsort = $db->fetch_record($oldsort_qry);
  $newsort = $oldsort['sort']-1;
  $oldup_qry = $db->query("SELECT * FROM __guildrequest_appvalues WHERE sort=".$newsort." LIMIT 0, 1");
  $oldup = $db->fetch_record($oldup_qry);
  
  $db->query("UPDATE __guildrequest_appvalues SET sort='".$oldup['sort']."' WHERE ID='".$_GET['moveup']."'");
  $db->query("UPDATE __guildrequest_appvalues SET sort='".$oldsort['sort']."' WHERE ID='".$oldup['ID']."'");
  
} elseif ($_GET['movedown']){
  $oldsort_qry = $db->query("SELECT * FROM __guildrequest_appvalues WHERE ID=".$in->get('movedown', 0));
  $oldsort = $db->fetch_record($oldsort_qry);
  $newsort = $oldsort['sort']+1;
  $oldup_qry = $db->query("SELECT * FROM __guildrequest_appvalues WHERE sort=".$newsort." LIMIT 0, 1");
  $oldup = $db->fetch_record($oldup_qry);
  
  $db->query("UPDATE __guildrequest_appvalues SET sort='".$oldup['sort']."' WHERE ID='".$in->get('movedown', 0)."'");
  $db->query("UPDATE __guildrequest_appvalues SET sort='".$oldsort['sort']."' WHERE ID='".$oldup['ID']."'");
}

// Output of the AppValues in the DB
$appvalues_qry = $db->query("SELECT * FROM __guildrequest_appvalues ORDER BY sort");
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
  if ($appvalues['type'] == 'headline') {
    $headline = '<option selected="selected" value="headline">'.$user->lang['gr_ad_form_headline'].'</option>';
    $editdropdown = '';
  } else {
    $headline = '<option value="headline">'.$user->lang['gr_ad_form_headline'];
  }
  if ($appvalues['type'] == 'spaceline') {
    $spaceline = '<option selected="selected" value="spaceline">'.$user->lang['gr_ad_form_spaceline'].'</option>';
    $editdropdown = '';
  } else {
    $spaceline = '<option value="spaceline">'.$user->lang['gr_ad_form_spaceline'];  
  }
  if ($appvalues['required'] == 'Y') {
  	$req_yes = '<input checked="checked" type="radio" name="'.$appvalues['ID'].'_required" value="Y">'.$user->lang['gr_poll_yes'];
  	$req_no = '<input type="radio" name="'.$appvalues['ID'].'_required" value="N">'.$user->lang['gr_poll_no'];
  } else {
  	$req_yes = '<input type="radio" name="'.$appvalues['ID'].'_required" value="Y">'.$user->lang['gr_poll_yes'];
  	$req_no = '<input checked="checked" type="radio" name="'.$appvalues['ID'].'_required" value="N">'.$user->lang['gr_poll_no'];
  }
  
  $output .= '<tr class="'.$eqdkp->switch_row_class().'">
                <td><input name="'.$appvalues['ID'].'_flag" value="'.$appvalues['value'].'"></td>
                <td>
                  <select name="'.$appvalues['ID'].'_type">
                    <option value="blankoption">-----------</option>
                    '.$singletext.'
                    '.$textfield.'
                    '.$dropdown.'
                    '.$headline.'
                    '.$spaceline.'
                  </select>
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
                </td>';

  $firstid_qry = $db->query("SELECT * FROM __guildrequest_appvalues ORDER BY sort LIMIT 0,1");
  $firstid = $db->fetch_record($firstid_qry);
  if ($appvalues['ID'] == $firstid['ID']) {
  	$output .= '<td align="right">
  	             <img src="../images/uparrow_grey.png" />
                </td>';
  } else {
    $output .= '<td align="right">
                  <a href="formedit.php?moveup='.$appvalues['ID'].'"><img src="../images/uparrow.png" /></a>
                </td>';
  }
  $db->free_result($firstid_qry);

  $lastid_qry = $db->query("SELECT * FROM __guildrequest_appvalues ORDER BY sort DESC LIMIT 0,1");
  $lastid = $db->fetch_record($lastid_qry);
  if ($appvalues['ID'] == $lastid['ID']){
    $output .= '<td>
                  <img src="../images/downarrow_grey.png" />
                </td>
              </tr>';
  } else {
    $output .= '<td>
                  <a href="formedit.php?movedown='.$appvalues['ID'].'"><img src="../images/downarrow.png" /></a>
                </td>
              </tr>';
  }
}

// ------- THE SOURCE PART - END -------

   
// Send the Output to the template Files.
$tpl->assign_vars(array(
      'GR_WELCOMETEXT'      => $gr_set['gr_welcome_text'],
      'GR_OUTPUT'           => $output,

      'GR_TR_NEWCLASS'      => $eqdkp->switch_row_class(),

      'GR_EDITOR'           => $jquery->wysiwyg('welcometext'),
      
      'GR_AD_EDITFORM_F'    => $user->lang['gr_ad_editform_f'],
      'GR_WELCOMETEXT_F'    => $user->lang['gr_ad_headline_f'],
      'GR_FIELDNAME_F'      => $user->lang['gr_ad_fieldname_f'],
      'GR_FIELDTYPE_F'      => $user->lang['gr_ad_fieldtype_f'],
      'GR_REQUIREDFIELD_F'  => $user->lang['gr_ad_requiredfield_f'],
      'GR_AD_SORT_F'        => $user->lang['gr_ad_sort_f'],
      'GR_AD_PREVIEW_F'     => $user->lang['gr_ad_preview_f'],
      
      //Options
      'GR_SINGLETEXT'       => $user->lang['gr_ad_form_singletext'],
      'GR_TEXTFIELD'        => $user->lang['gr_ad_form_textfield'],
      'GR_DROPDOWN'         => $user->lang['gr_ad_form_dropdown'],
      'GR_HEADLINE'         => $user->lang['gr_ad_form_headline'],
      'GR_SPACELINE'        => $user->lang['gr_ad_form_spaceline'],
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
