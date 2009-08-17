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

class guildrequest_plugin_class extends EQdkp_Plugin {
  var $version    = '1.0.0';
  var $build      = '2892';
  var $copyright  = 'BadTwin';
  var $vstatus    = 'alpha';
  var $fwversion  = '1.0.2';  // required framework Version

	function guildrequest_plugin_class($pm) {
		global $eqdkp_root_path, $user, $db, $eqdkp;

		$this->eqdkp_plugin($pm);
		$this->pm->get_language_pack('guildrequest');

		$this->add_data(array(
			'name'							=>	$user->lang['guildrequest'],
			'code'							=>	'guildrequest',
			'path'							=>	'guildrequest',
			'contact'						=>	'badtwin@gmx.at',
			'template_path'			=>	'plugins/guildrequest/templates/',
			'imageurl'					=>	'plugins/guildrequest/images/screen.jpg',
			'version'						=>	$this->version,
			'author'						=>	$this->copyright,
			'description'				=>	$user->lang['gr_class_short_desc'],
			'long_description'	=>	$user->lang['gr_class_long_desc'],
			'homepage'					=>	'http://www.eqdkp-plus.com',
			'manuallink'				=>	false,
			'plus_version'			=>	'0.7',
		));

		$this->add_permission(8955, 'a_guildrequest_manage',	'N', $user->lang['gr_class_perm_manage']);
		$this->add_permission(8956, 'u_guildrequest_view', 		'Y', $user->lang['gr_class_perm_view']);
		$this->add_permission(8957, 'u_guildrequest_comment',	'Y', $user->lang['gr_class_perm_comment']);
		$this->add_permission(8958, 'u_guildrequest_vote',		'Y', $user->lang['gr_class_perm_vote']);
		$this->add_permission(8959, 'u_guildrequest_offi',		'N', $user->lang['gr_class_perm_offi']);

		// Add Menus
		$this->add_menu('main_menu1', $this->gen_main_menu1());
		$this->add_menu('admin_menu', $this->gen_admin_menu());

		include($eqdkp_root_path.'plugins/'.$this->get_data('path').'/includes/install/sql.php');

		// Install
		if (!($this->pm->check(PLUGIN_INSTALLED, 'guildrequest'))) {
			include ($eqdkp_root_path.'plugins/'.$this->get_data('path').'/includes/install/defaults.php');

			// Delete old tables, if existing and create the new ones
			for ($i = 1; $i <= count($guildrequestSQL['install']); $i++) {
				if ($guildrequestSQL['uninstall'][$i]) {
					$this->add_sql(SQL_INSTALL, $guildrequestSQL['uninstall'][$i]);
				}
				$this->add_sql(SQL_INSTALL, $guildrequestSQL['install'][$i]);
			}

			// Insert the default Values
			$this->InsertIntoConfig($config_vars);
			$this->InsertIntoAppvalues($appvalues_vars);
		}
		
		// Uninstall
		for ($i = 1; $i <= count($guildrequestSQL['uninstall']); $i++) {
			if ($guildrequestSQL['uninstall'][$i]) {
				$this->add_sql(SQL_UNINSTALL, $guildrequestSQL['uninstall'][$i]);
			}
		}

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

				if (!($db->query($sql))){
					System_Message('Could not add user information', 'Error', 'red');
				}
				$user_id = $db->insert_id();
			}
		} else {
			if ($user_exist_check['username'] == $user->lang['gr_user_aspirant']) {
				$sql = $db->query("DELETE from __users WHERE username ='".$user->lang['gr_user_aspirant']."' LIMIT 1");
				$db->free_result($sql);
			}
		}

		// Include the System Messages
		if ($this->pm->check(PLUGIN_INSTALLED, 'guildrequest')) {
			include_once($eqdkp_root_path.'plugins/'.$this->get_data('path').'/include/jsflags.php');
		}
	}

	// Generate the Main Menu
	function gen_main_menu1() {
		global $user, $SID, $db, $eqdkp_root_path;

		if ($this->pm->check(PLUGIN_INSTALLED, 'guildrequest')) {
			if ($user->data['user_id'] != ANONYMOUS){
				$counter_query = $db->query("SELECT * FROM __guildrequest_users WHERE closed='N' AND activated='Y'");
				$counter = $db->num_rows($counter_query);
				if ($counter != 0){
					$counter_out = ' ('.$counter.')';
				}
				$db->free_result($counter_query);

				$main_menu1 = array(
					array(
						'link'	=> 'plugins/' . $this->get_data('path') . '/viewrequest.php' . $SID,
						'text'	=> $user->lang['gr_menu_view'],
						'check'	=> 'u_guildrequest_view',
					)
				);
			} else {
				$main_menu1 = array(
					array(
						'link'	=> 'plugins/' . $this->get_data('path') . '/writerequest.php' . $SID,
						'text'	=> $user->lang['gr_menu_write'],
					)
				);
			}
			return $main_menu1;
		}
		return;
	}

	// Generate the Admin Menu
	function gen_admin_menu() {
		global $user, $SID, $eqdkp_root_path;
		$url_prefix = ( EQDKP_VERSION < '1.3.2' ) ? $eqdkp_root_path : '';

		if ($this->pm->check(PLUGIN_INSTALLED, 'guildrequest') && $user->check_auth('a_guildrequest_', false)) {
			$admin_menu = array(
				'guildrequest' => array(
					99	=> './../../plugins/guildrequest/images/write.png',
					0		=> $user->lang['guildrequest'],
					1		=> array(
						'link' => $url_prefix . 'plugins/guildrequest/admin/settings.php' . $SID,
						'text' => $user->lang['gr_admin_menu_manage'],
						'check' => 'a_guildrequest_manage'),
					2 => array(
						'link' => $url_prefix . 'plugins/guildrequest/admin/formedit.php' . $SID,
						'text' => $user->lang['gr_admin_menu_formedit'],
						'check' => 'a_guildrequest_manage'),
			));
			return $admin_menu;
		}
	return;
	}

	function InsertIntoConfig($tarray){
		foreach($tarray as $fieldname=>$insertvalue){
			$sql = "INSERT INTO __guildrequest_config VALUES ('".$fieldname."', '".$insertvalue."');";
			$this->add_sql(SQL_INSTALL, $sql);
		}
	}

	function InsertIntoAppvalues($tarray){
		foreach($tarray as $fieldname=>$insertvalue){
			$sql = "INSERT INTO __guildrequest_appvalues (value, type, required, sort) VALUES ('".$fieldname."', '".$insertvalue[0]."', '".$insertvalue[1]."', '".$insertvalue[2]."');";
			$this->add_sql(SQL_INSTALL, $sql);
		}
	}
}
?>