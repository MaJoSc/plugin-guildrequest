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

if (!defined('EQDKP_INC') ){
    header('HTTP/1.0 404 Not Found');
    exit;
}

class guildrequest_plugin_class extends EQdkp_Plugin {
  var $version    = '0.0.4';
  var $copyright  = 'BadTwin';
  var $vstatus    = 'Stable';
  var $build      = '3601';

  function guildrequest_plugin_class($pm){

    global $eqdkp_root_path, $user, $SID, $table_prefix, $db, $eqdkp;
        
    $this->eqdkp_plugin($pm);
		
    $this->pm->get_language_pack('guildrequest');

    $this->add_data(array(
      'name'					=> 'Guild Request',
      'code'					=> 'guildrequest',
      'path'					=> 'guildrequest',
      'contact'				=> 'andreas.schrottenbaum@gmx.at',
      'template_path'	=> 'plugins/guildrequest/templates/',
      'version'				=> $this->version,)
    );
        
    // Addition Information for eqdkpPLUS
    $this->additional_data = array(
      'author'            => 'BadTwin',
      'description'       => $user->lang['gr_short_desc'],
      'long_description'  => $user->lang['gr_long_desc'],
      'homepage'          => 'http://www.eqdkp-plus.com/',
      'manuallink'        => '',
    );
        
		// Register the permissions... 
    $this->add_permission('8955', 'a_guildrequest_manage',  'N', $user->lang['gr_manage']);
    $this->add_permission('8956', 'u_guildrequest_view',    'Y', $user->lang['gr_view']);
    $this->add_permission('8957', 'u_guildrequest_comment', 'Y', $user->lang['gr_comment']);
    $this->add_permission('8958', 'u_guildrequest_vote', 'Y', $user->lang['gr_vote']);
      
    // Add Menus (configuration of the menu entries, see below)
		$this->add_menu('main_menu1', $this->gen_main_menu1());      // This is the main Menu
		$this->add_menu('admin_menu', $this->gen_admin_menu());      // This is the admin Menu

    // Define installation. 
		$sql = "CREATE TABLE IF NOT EXISTS " . $table_prefix . "guildrequest (
			`id` INT PRIMARY KEY AUTO_INCREMENT,
		  `username` varchar(255) NOT NULL default '',
		  `email` varchar(255) NOT NULL default '',
		  `password` varchar(255) NOT NULL default '',
      `text` text NOT NULL default '',
      `closed` ENUM ( 'N', 'Y' ) NOT NULL DEFAULT 'N',
      `activation` varchar(255) NOT NULL default'',
      `activated` ENUM ('N', 'Y') NOT NULL DEFAULT 'N')";
		$this->add_sql(SQL_INSTALL, $sql);
		
		$sql = "CREATE TABLE IF NOT EXISTS " . $table_prefix . "guildrequest_config (
		  `config_name` varchar(255) PRIMARY KEY NOT NULL default '',
		  `config_value` text NOT NULL default '')";
		$this->add_sql(SQL_INSTALL, $sql);
    $this->InsertIntoTable('gr_mail_text1', $user->lang['gr_mail_text1']);
    $this->InsertIntoTable('gr_mail_text2', $user->lang['gr_mail_text2']);
    $this->InsertIntoTable('gr_welcome_text', $user->lang['gr_welcome_text']);
    $this->InsertIntoTable('gr_poll_activated', 'Y');
    $this->InsertIntoTable('gr_popup_activated', 'N');
    $this->InsertIntoTable('gr_inst_version', $this->version);
        
		$sql = "CREATE TABLE IF NOT EXISTS " . $table_prefix . "guildrequest_poll (
		  `id` INT PRIMARY KEY AUTO_INCREMENT,
      `query_id` INT NOT NULL,
      `user_id` INT NOT NULL,
		  `poll_value` varchar (255) NOT NULL)";
		$this->add_sql(SQL_INSTALL, $sql);

		$sql = "CREATE TABLE IF NOT EXISTS " . $table_prefix . "guildrequest_appvalues (
                        ID INT AUTO_INCREMENT PRIMARY KEY,
                        value VARCHAR(255) NOT NULL,
                        type VARCHAR(255) NOT NULL,
                        required ENUM ('N', 'Y') NOT NULL DEFAULT 'N',
                        sort INT NOT NULL)";
		$this->add_sql(SQL_INSTALL, $sql);
    $this->InsertIntoAppvalues('Name', 'singletext', 'Y', '1');
    $this->InsertIntoAppvalues('Class', 'singletext', 'Y', '2');
    $this->InsertIntoAppvalues('Level', 'singletext', 'N', '3');
    $this->InsertIntoAppvalues('Text', 'textfield', 'Y', '4');

    $sql = "CREATE TABLE IF NOT EXISTS __guildrequest_appoptions(
                        ID INT AUTO_INCREMENT PRIMARY KEY,
                        opt_ID INT NOT NULL,
                        appoption VARCHAR(255) NOT NULL
                      );";
    $this->add_sql(SQL_INSTALL, $sql);
                      
                      
    // Create a new User for the Guest's comments
    $user_exist_check_qry = $db->query("SELECT * FROM __users WHERE username = '".$user->lang['gr_user_aspirant']."'");
    $user_exist_check = $db->fetch_record($user_exist_check_qry);
    if($pm->installed['guildrequest']){
      if ($user_exist_check['username'] != $user->lang['gr_user_aspirant']) {
    	

        $query = $db->build_query('INSERT', array(
            'username'       => $user->lang['gr_user_aspirant'],
            'user_password'  => md5(time().microtime()),
            'user_email'     => $user->lang['gr_user_email'],
            'user_alimit'    => $eqdkp->config['default_alimit'],
            'user_elimit'    => $eqdkp->config['default_elimit'],
            'user_ilimit'    => $eqdkp->config['default_ilimit'],
            'user_nlimit'    => $eqdkp->config['default_nlimit'],
            'user_rlimit'    => $eqdkp->config['default_rlimit'],
            'user_style'     => $eqdkp->config['default_style'],
            'user_lang'      => $eqdkp->config['default_lang'],
            'first_name'     => 'Guildrequest',
            'user_key'       => '',
            'user_active'    => '0',
            'user_lastvisit' => time())
        );
        $sql = 'INSERT INTO __users ' . $query;
        $this->add_sql(SQL_INSTALL, $sql);
        
        if ( !($db->query($sql)) )
        {
            System_Message('Could not add user information', 'Error', 'red');
        }
        $user_id = $db->insert_id();
        
      }
    } else {
      if ($user_exist_check['username'] == $user->lang['gr_user_aspirant']) {
        $sql = "DELETE from __users WHERE username ='".$user->lang['gr_user_aspirant']."' LIMIT 1";
        $db->query($sql);
      }    
    }

    // Insert the permission for the installing person
    $perm_array = array('8955', '8956'. '8957', '8958');
		$this->set_permissions($perm_array);
			
    // Define uninstallation
    $this->add_sql(SQL_UNINSTALL, "DROP TABLE IF EXISTS " . $table_prefix . "guildrequest");
    $this->add_sql(SQL_UNINSTALL, "DROP TABLE IF EXISTS " . $table_prefix . "guildrequest_config");
    $this->add_sql(SQL_UNINSTALL, "DROP TABLE IF EXISTS " . $table_prefix . "guildrequest_poll");
    $this->add_sql(SQL_UNINSTALL, "DROP TABLE IF EXISTS " . $table_prefix . "guildrequest_appvalues");
    $this->add_sql(SQL_UNINSTALL, "DELETE FROM ".$table_prefix."comments WHERE page='guildrequest'");
    
    if ($this->pm->check(PLUGIN_INSTALLED, 'guildrequest')) {
      if (file_exists($eqdkp_root_path.'plugins/guildrequest/include/jsflags.php')) {
        include_once($eqdkp_root_path.'plugins/guildrequest/include/jsflags.php');	
      }
    }
  }

  /* GENERATE THE MENUS - START */
  
  // generate the Main Menu
  function gen_main_menu1(){
    global $user, $SID, $db, $eqdkp, $tpl;
    
    // check if its enabled
    if ($this->pm->check(PLUGIN_INSTALLED, 'guildrequest')){
      // Start the Menu array
      if ($user->data['user_id'] != ANONYMOUS){
        $counter_query = $db->query("SELECT * FROM __guildrequest WHERE closed='N' AND activated='Y'");
        $counter = $db->num_rows($counter_query);
        if ($counter != 0){
          $counter_out = ' ('.$counter.')';
        }
        $main_menu1 = array(array(
      		'link' => 'plugins/guildrequest/viewrequest.php' . $SID,
  	   		'text' => $user->lang['gr_view'].$counter_out,
  		  	'check' => 'u_guildrequest_view'
    	  ));
    	} else {
        $main_menu1 = array(array(
      		'link' => 'plugins/guildrequest/writerequest.php' . $SID,
  	   		'text' => $user->lang['gr_write'],
    	  ));
      }
      return $main_menu1;
    }
    return;
  }
  
	// Generate admin menu
  function gen_admin_menu(){
    global $user, $SID, $eqdkp, $eqdkp_root_path;
  	$url_prefix = ( EQDKP_VERSION < '1.3.2' ) ? $eqdkp_root_path : '';
    if ($this->pm->check(PLUGIN_INSTALLED, 'guildrequest')){
      global $db, $user, $eqdkp_root_path;
    	$admin_menu = array(
      	'guildrequest' => array(
    			0 => $user->lang['guildrequest'],
    			1 => array(
    				'link' => $url_prefix . 'plugins/guildrequest/admin/admin.php' . $SID,
    				'text' => $user->lang['gr_manage'],
    				'check' => 'a_guildrequest_manage'
          ),
          2 => array(
            'link' => $url_prefix . 'plugins/guildrequest/admin/formedit.php' . $SID,
            'text' => $user->lang['gr_form_manage'],
            'check' => 'a_guildrequest_manage'
          ),
    			99 => './../../plugins/guildrequest/images/write.png',
        ),
      );
      return $admin_menu;
    }
    return;
  }
   
  /* GENERATE THE MENUS - END */

  // Function for saving the settings from the installing person
  function set_permissions($perm_array, $perm_setting='Y'){
		global $table_prefix, $db, $user;
		$userid = ( $user->data['user_id'] != ANONYMOUS ) ? $user->data['user_id'] : '';
		if($userid){
		  foreach ($perm_array as $value) {
		    $sql = "INSERT INTO `".$table_prefix."auth_users` VALUES('".$userid."', '".$value."', '".$perm_setting."');";
    		$this->add_sql(SQL_INSTALL, $sql);
    		$sql = "UPDATE `".$table_prefix."auth_users` SET auth_setting='".$perm_setting."' WHERE user_id='".$userid."' AND auth_id='".$value."';";
    		$this->add_sql(SQL_INSTALL, $sql);
  		}
		} 
	}
	
	// Instert Standard Values in the Table
  function InsertIntoTable($fieldname,$insertvalue){
		global $eqdkp_root_path, $user, $SID, $table_prefix;
    $sql = "INSERT INTO " . $table_prefix . "guildrequest_config VALUES ('".$fieldname."', '".$insertvalue."');";
	  $this->add_sql(SQL_INSTALL, $sql);
  }

  function InsertIntoAppvalues($fieldname,$insertvalue,$required,$sort){
		global $eqdkp_root_path, $user, $SID, $table_prefix;
    $sql = "INSERT INTO " . $table_prefix . "guildrequest_appvalues (value, type, required, sort) VALUES ('".$fieldname."', '".$insertvalue."', '".$required."', '".$sort."');";
	  $this->add_sql(SQL_INSTALL, $sql);
  }

}
?>
