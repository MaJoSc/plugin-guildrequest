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
if ($_GET['id']) {
  $opt_id = $_GET['id'];
} elseif ($_POST['opt_id']) {
  $opt_id = $_POST['opt_id'];
}


if ($_GET['delete']) {
	$db->query("DELETE FROM __guildrequest_appoptions WHERE ID = '".$_GET['delete']."'");
	$db->free_result();
}


if ($_POST['opt_id']) {
	$opt_qry = $db->query("SELECT * FROM __guildrequest_appoptions WHERE opt_id='".$opt_id."'");
	while ($opt = $db->fetch_record($opt_qry)) {
 	  $db->query("UPDATE __guildrequest_appoptions SET appoption = '".$_POST['opt_'.$opt['ID']]."' WHERE ID='".$opt['ID']."'");
  }
}

if ($_POST['newoption']){
  $db->query("INSERT INTO __guildrequest_appoptions (opt_id, appoption) VALUES ('".$_POST['opt_id']."','".$_POST['newoption']."')");
}


$opt_qry = $db->query("SELECT * FROM __guildrequest_appoptions WHERE opt_id='".$opt_id."'");
while ($opt = $db->fetch_record($opt_qry)) {
	$output .= '<tr class="'.$eqdkp->switch_row_class().'">
                <td>
                  <input name="opt_'.$opt['ID'].'" value="'.$opt['appoption'].'">
                </td>
                <td>
                  <a href="addoptions.php?delete='.$opt['ID'].'&id='.$opt_id.'"><img src="'.$eqdkp_root_path.'images/global/delete.png" /></a>
                </td>
              </tr>';
}

// ------- THE SOURCE PART - END -------

   
// Send the Output to the template Files.
$tpl->assign_vars(array(
      'OUTPUT'        => $output,
      'OPT_ID'        => $opt_id,
      'NEXT_TR_CLASS' => $eqdkp->switch_row_class(),
    ));

// Init the Template
$eqdkp->set_vars(array(
	    'page_title'             => $eqdkp->config['guildtag'].' - '.$user->lang['request'],
			'template_path' 	       => $pm->get_data('guildrequest', 'template_path'),
			'template_file'          => 'admin/addoptions.html',
			'gen_simple_header'      => true,
      'display'                => true)
    );

?>