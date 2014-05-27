<?php
/*
 * Project:     EQdkp guildrequest
 * License:     Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:        http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:       2008
 * Date:        $Date: 2012-10-13 22:48:23 +0200 (Sa, 13. Okt 2012) $
 * -----------------------------------------------------------------------
 * @author      $Author: godmod $
 * @copyright   2008-2011 Aderyn
 * @link        http://eqdkp-plus.com
 * @package     guildrequest
 * @version     $Rev: 12273 $
 *
 * $Id: archive.php 12273 2012-10-13 20:48:23Z godmod $
 */

// EQdkp required files/vars
class addrequest_pageobject extends pageobject
{
  /**
   * __dependencies
   * Get module dependencies
   */
  public static function __shortcuts()
  {
    $shortcuts = array('email' => 'MyMailer');
   	return array_merge(parent::__shortcuts(), $shortcuts);
  }  
  
  private $data = array();

  /**
   * Constructor
   */
  public function __construct()
  {
    // plugin installed?
    if (!$this->pm->check('guildrequest', PLUGIN_INSTALLED))
      message_die($this->user->lang('gr_plugin_not_installed'));

    $handler = array(
      'save' => array('process' => 'save', 'csrf' => true, 'check' => 'u_guildrequest_add'),
    );
    parent::__construct('u_guildrequest_add', $handler);

    $this->process();
  }

  public function save(){
	//Build Field-Array
	$arrFields = $this->pdh->get('guildrequest_fields', 'id_list', array());
	$arrInput = $arrValues = array();
	foreach($arrFields as $id){
		$row = $this->pdh->get('guildrequest_fields', 'id', array($id));
		if ($row['type'] == 3 || $row['type'] == 4){
			continue;
		}
		$arrInput[$row['id']] = array(
			'id'		=> $row['id'],
			'name'		=> $row['name'],
			'input' 	=> $this->in->get('gr_field_'.$row['id']),
			'required'	=> ($row['required']),
			'dep_field' => $row['dep_field'],
			'dep_value' => $row['dep_value'],
		);
		
		$arrValues[$row['id']] = $this->in->get('gr_field_'.$row['id']);
		
		//Checkboxes
		if ($row['type'] == 5){
			$arrInput[$row['id']] = array(
				'id'		=> $row['id'],
				'name'		=> $row['name'],
				'input' 	=> serialize($this->in->getArray('gr_field_'.$row['id'], 'int')),
				'required'	=> ($row['required']),
				'dep_field' => $row['dep_field'],
				'dep_value' => $row['dep_value'],
			);
			$arrValues[$row['id']] = $this->in->getArray('gr_field_'.$row['id'], 'int');
		}
	}
	
	$arrInput['email'] = array(
		'input' 	=> $this->in->get('gr_email'),
		'name'		=> $this->user->lang('email'),
		'required'	=> true,
	);
	$arrInput['name'] = array(
		'input' 	=> $this->in->get('gr_name'),
		'name'		=> $this->user->lang('name'),
		'required'	=> true,
	);

	$this->data = $arrInput;

	//Check Captcha
	require($this->root_path.'libraries/recaptcha/recaptcha.class.php');
	$captcha = new recaptcha;
	$response = $captcha->recaptcha_check_answer ($this->config->get('lib_recaptcha_pkey'), $this->env->ip, $this->in->get('recaptcha_challenge_field'), $this->in->get('recaptcha_response_field'));
	if (!$response->is_valid) {
		$this->core->message($this->user->lang('lib_captcha_wrong'), $this->user->lang('error'), 'red');
		$this->display;
		return;
	}
	
	
	//Check email
	if (!preg_match("/^([a-zA-Z0-9])+([\.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+/",$this->in->get('gr_email'))){
		$this->core->message($this->user->lang('fv_invalid_email'), $this->user->lang('error'), 'red');
		$this->display();
		return;
	}
	
	//Check Required
	$arrRequired = array();
	foreach ($arrInput as $val){
		if (!$val['required']) continue;
		
		if (isset($val['dep_field']) && $val['dep_field'] && $val['dep_field'] != 999999999){
			$intDepField = $val['dep_field'];
			if (!isset($arrValues[$intDepField])) continue;
			
			if (is_array($arrValues[$intDepField])){
				if (!isset($arrValues[$intDepField][$val['dep_value']])) continue;
			} else {		
				if ($arrValues[$intDepField] != $val["dep_value"]) continue;
			}
		}
		
		if ($val['input'] == '' || $val['input'] == 'a:0:{}') $arrRequired[] = $val['name'];
	}

	if (count($arrRequired) > 0) {
		$this->core->message(implode(', ', $arrRequired), $this->user->lang('missing_values'), 'red');
		$this->display();
		return;
	}
	
	

	//Insert into DB
	
	$strName = $arrInput['name']['input'];
	$strEmail = $arrInput['email']['input'];
	$strAuthKey = random_string(false, 40);
	$strActivationKey = random_string(false, 32);
	$arrInput['email']['input'] = register('encrypt')->encrypt($arrInput['email']['input']);
	$arrToSave = array();
	foreach($arrInput as $val){
		$arrToSave[$val['id']] = $val['input'];
	}	
	$strContent = serialize($arrToSave);
	
	$blnResult = $this->pdh->put('guildrequest_requests', 'add', array($strName, $strEmail, $strAuthKey, $strActivationKey, $strContent));
	
	$this->pdh->process_hook_queue();
	if (!$blnResult){
		$this->core->message($this->user->lang('error'), $this->user->lang('error'), 'red');
		$this->display();
		return;
	}
	
	//Send Email to User with auth key
	$server_url = $this->env->link.$this->routing->build('ViewApplication', $strName, $blnResult, false, true);
	$bodyvars = array(
		'USERNAME'		=> sanitize($strName),
		'U_ACTIVATE' 	=> $server_url .'?key=' . $strAuthKey,
		'GUILDTAG'		=> $this->config->get('guildtag'),
	);
	
	if(!$this->email->SendMailFromAdmin($strEmail, $this->user->lang('gr_viewlink_subject'), $this->root_path.'plugins/guildrequest/language/'.$this->user->data['user_lang'].'/email/request_viewlink.html', $bodyvars)){
		$this->core->message($this->user->lang('email_subject_send_error'), $this->user->lang('error'), 'red');
		$this->display();
		return;
	} else {
		//Send Notification Mail to everyone who wants it
		$bodyvars = array(
			'U_VIEW' 		=> $server_url,
			'REQUEST_USER'	=> sanitize($strName),
			'GUILDTAG'		=> $this->config->get('guildtag'),
		);
		
		$arrUserIDs = $this->pdh->get('user', 'id_list', array());
		foreach($arrUserIDs as $userid){
			$arrGuildrequestSettings = $this->pdh->get('user', 'plugin_settings', array($userid, 'guildrequest'));
			if (isset($arrGuildrequestSettings['gr_send_notification_mails']) && $arrGuildrequestSettings['gr_send_notification_mails']){
				$strEmail = $this->pdh->get('user', 'email', array($userid, true));
				if ($strEmail != '' && $this->user->check_auth('u_guildrequest_view', false, $userid)){
					$bodyvars['USERNAME'] = $this->pdh->get('user', 'name', array($userid));
					$this->email->SendMailFromAdmin($strEmail, $this->user->lang('gr_notification_subject'), $this->root_path.'plugins/guildrequest/language/'.$this->user->data['user_lang'].'/email/request_notification.html', $bodyvars);
				}
			}
		}
	
	
		//Redirect to viewrequest page
		redirect($this->routing->build('ViewApplication', $strName, $blnResult, false, true).'?key=' . $strAuthKey.'&msg=success');
	}
  }
  
  
  public function display()
  {
	
	$arrFields = $this->pdh->get('guildrequest_fields', 'id_list', array());
	$intGroup = 0;
	$blnGroupOpen = true;
	$this->tpl->assign_block_vars('tabs', array(
	));
	
	$this->add_personal_group();
		
	foreach($arrFields as $id){
		$row = $this->pdh->get('guildrequest_fields', 'id', array($id));
		$row['options'] = unserialize($row['options']);
		
		//Dependency
		if ($row['dep_field'] && ((strlen($row['dep_value']) && in_array($row['dep_field'], $arrFields)) || $row['dep_field'] == 999999999)) $this->gen_dependency($row);
		
		//Close previous group
		if ($row['type'] == 3){
			$blnGroupOpen = false;
			$intGroup++;
		}
		
		//Input
		if ($row['type'] == 0){
			if (!$blnGroupOpen){
				$this->tpl->assign_block_vars('tabs.fieldset', array(
					'NAME'	=> $this->user->lang('gr_default_grouplabel'),
					'ID'	=> 'information',
				));
				$blnGroupOpen = true;
			}
			

			$this->tpl->assign_block_vars('tabs.fieldset.field', array(
				'NAME'		=> $row['name'],
				'FIELD'		=> new htext('gr_field_'.$row['id'], array('js' => 'style="width:95%"', 'value' => (isset($this->data[$row['id']]) ? $this->data[$row['id']]['input'] : ''))),
				'REQUIRED'	=> ($row['required']),
				'HELP'		=> $row['help'],
				'ID'		=> 'dl_'.$row['id'],
			));
			
		}
		
		//Textarea
		if ($row['type'] == 1){
			if (!$blnGroupOpen){
				$this->tpl->assign_block_vars('tabs.fieldset', array(
					'NAME'	=> $this->user->lang('gr_default_grouplabel'),
					'ID'	=> 'information',
				));
				$blnGroupOpen = true;
			}

			$this->tpl->assign_block_vars('tabs.fieldset.field', array(
				'NAME'		=> $row['name'],
				'FIELD'		=> new htextarea('gr_field_'.$row['id'], array('js' => 'style="width:95%"', 'rows' => 10, 'value' => (isset($this->data[$row['id']]) ? $this->data[$row['id']]['input'] : ''))),
				'REQUIRED'	=> ($row['required']),
				'HELP'		=> $row['help'],
				'ID'		=> 'dl_'.$row['id'],
			));
		}
		
		//Select
		if ($row['type'] == 2){
			if (!$blnGroupOpen){
				$this->tpl->assign_block_vars('tabs.fieldset', array(
					'NAME'	=> $this->user->lang('gr_default_grouplabel'),
					'ID'	=> 'information',
				));
				$blnGroupOpen = true;
			}
			
			$arrOptions = array();
			$arrOptions[''] = $this->user->lang('cl_ms_noneselected');
			foreach($row['options'] as $val){
				$val = trim(str_replace(array("\n", "\r"), "", $val));
				$arrOptions[$val] = $val;
			}
			
			$this->tpl->assign_block_vars('tabs.fieldset.field', array(
				'NAME'		=> $row['name'],
				'FIELD'		=> new hdropdown('gr_field_'.$row['id'], array('options' => $arrOptions, 'value' => (isset($this->data[$row['id']]) ? $this->data[$row['id']]['input'] : ''))),
				'REQUIRED'	=> ($row['required']),
				'HELP'		=> $row['help'],
				'ID'		=> 'dl_'.$row['id'],
			));
		}
		
		//Group Label
		if ($row['type'] == 3){
			if (!$blnGroupOpen){
				$this->tpl->assign_block_vars('tabs.fieldset', array(
					'NAME'	=> $row['name'],
					'ID'	=> utf8_strtolower(str_replace(' ', '', $row['name'])),
					'FID'	=> 'dl_'.$row['id'],
				));
				$blnGroupOpen = true;
			}
		}
		
		//Plain text
		if ($row['type'] == 4){
			if (!$blnGroupOpen){
				$this->tpl->assign_block_vars('tabs.fieldset', array(
					'NAME'	=> $this->user->lang('gr_default_grouplabel'),
					'ID'	=> 'information',
				));
				$blnGroupOpen = true;
			}
			
			$this->tpl->assign_block_vars('tabs.fieldset.field', array(
					'NAME'			=> $row['name'],
					'S_NO_DIVIDER' => true,
					'ID'		=> 'dl_'.$row['id'],
			));
		}
		
		//Checkboxes
		if ($row['type'] == 5){
			if (!$blnGroupOpen){
				$this->tpl->assign_block_vars('tabs.fieldset', array(
					'NAME'	=> $this->user->lang('gr_default_grouplabel'),
					'ID'	=> 'information',
				));
				$blnGroupOpen = true;
			}
			
			$field = '';
			
			$selected = isset($this->data[$row['id']]) ? unserialize($this->data[$row['id']]['input']) : array();
			
			foreach($row['options'] as $val){
				$field .= new hcheckbox('gr_field_'.$row['id'].'['.trim($val).']', array('options' => trim($val), 'value' => (isset($selected[trim($val)]) ? $selected[trim($val)] : ''))).'&nbsp;&nbsp;&nbsp;';
			}
			

			$this->tpl->assign_block_vars('tabs.fieldset.field', array(
				'NAME'		=> $row['name'],
				'FIELD'		=> $field,
				'REQUIRED'	=> ($row['required']),
				'HELP'		=> $row['help'],
				'ID'		=> 'dl_'.$row['id'],
			));
		}
		
		//Radioboxes
		if ($row['type'] == 6){
			if (!$blnGroupOpen){
				$this->tpl->assign_block_vars('tabs.fieldset', array(
					'NAME'	=> $this->user->lang('gr_default_grouplabel'),
					'ID'	=> 'information',
				));
				$blnGroupOpen = true;
			}
			
			$arrOptions = array();
			foreach($row['options'] as $val){
				$arrOptions[trim($val)] = trim($val);
			}
			
			$this->tpl->assign_block_vars('tabs.fieldset.field', array(
				'NAME'		=> $row['name'],
				'FIELD'		=> new hradio('gr_field_'.$row['id'], array('value' => (isset($this->data[$row['id']]) ? $this->data[$row['id']]['input'] : ''), 'options' => $arrOptions)),
				'REQUIRED'	=> ($row['required']),
				'HELP'		=> $row['help'],
				'ID'		=> 'dl_'.$row['id'],
			));
		}
		
		//BBCode Editor
		if ($row['type'] == 7){
			if (!$blnGroupOpen){
				$this->tpl->assign_block_vars('tabs.fieldset', array(
					'NAME'	=> $this->user->lang('gr_default_grouplabel'),
					'ID'	=> 'information',
				));
				$blnGroupOpen = true;
			}

			$this->tpl->assign_block_vars('tabs.fieldset.field', array(
				'NAME'		=> $row['name'],
				'FIELD'		=> new hbbcodeeditor('gr_field_'.$row['id'], array('rows' => 6, 'value' => (isset($this->data[$row['id']]) ? $this->data[$row['id']]['input'] : ''))),
				'REQUIRED'	=> ($row['required']),
				'HELP'		=> $row['help'],
				'ID'		=> 'dl_'.$row['id'],
			));
		}
	}
	
	require($this->root_path.'libraries/recaptcha/recaptcha.class.php');
	$captcha = new recaptcha;
	$this->tpl->assign_vars(array(
		'CAPTCHA'				=> $captcha->recaptcha_get_html($this->config->get('lib_recaptcha_okey')),
		'S_DISPLAY_CATPCHA'		=> true,
	));
	
    // -- EQDKP ---------------------------------------------------------------
    $this->core->set_vars(array (
      'page_title'    => $this->user->lang('gr_add'),
      'template_path' => $this->pm->get_data('guildrequest', 'template_path'),
      'template_file' => 'addrequest.html',
      'display'       => true
    ));
	
	
  }
  
  private function gen_dependency($row){
  	$arrTypes = $this->pdh->aget('guildrequest_fields', 'type', 0, array( $this->pdh->get('guildrequest_fields', 'id_list', array())));

  	if ($row['dep_field'] == 999999999){
		$expr = html_entity_decode($row['dep_value']);
		
		$expr = preg_replace("/[^a-zA-Z0-9=&|?\"'() ]/", "", $expr);
		$expr = preg_replace("#FIELD([0-9]*)#", "field_data[\"gr_field_$1\"]", $expr);
  		
  		$this->tpl->assign_block_vars("gr_listener_row", array(
  				'TARGET' => "dl_".$row['id'],
  				'EXPR'	 => $expr,
  		));
  		
  	} else {
  	
	  	$intType = $arrTypes[$row['dep_field']];
	
	  	if ($intType == 2){
	  		//Select
	  		$this->tpl->add_js('
				$(document).on("change", "#gr_field_'.$row['dep_field'].'", function () {
					gr_dep_check_value("gr_field_'.$row['dep_field'].'", "'.$row['dep_value'].'", "dl_'.$row['id'].'");
				});
				gr_dep_check_value("gr_field_'.$row['dep_field'].'", "'.$row['dep_value'].'", "dl_'.$row['id'].'");
			', 'docready');
	  	}elseif($intType == 5){
	  		//Checkbox
	  		$this->tpl->add_js('
	  			$(document).on("change", "input[name^=\'gr_field_'.$row['dep_field'].'\']", function () {
					gr_dep_check_cb("gr_field_'.$row['dep_field'].'", "'.$row['dep_value'].'", "dl_'.$row['id'].'");
				});
				gr_dep_check_cb("gr_field_'.$row['dep_field'].'", "'.$row['dep_value'].'", "dl_'.$row['id'].'");
			', 'docready');
	  	}elseif($intType == 6){
	  		//Radio
	  		$this->tpl->add_js('
			$(document).on("change", "input[name=\'gr_field_'.$row['dep_field'].'\']", function () {
					gr_dep_check_radio("gr_field_'.$row['dep_field'].'", "'.$row['dep_value'].'", "dl_'.$row['id'].'");
				});
				gr_dep_check_radio("gr_field_'.$row['dep_field'].'", "'.$row['dep_value'].'", "dl_'.$row['id'].'");
			', 'docready');
	  	}
  	}
  	
  }
  
  private function add_personal_group(){
	$this->tpl->assign_block_vars('tabs.fieldset', array(
		'NAME'	=> $this->user->lang('gr_personal_information'),
		'ID'	=> 'personal_information',
	));

	$this->tpl->assign_block_vars('tabs.fieldset.field', array(
		'NAME'		=> $this->user->lang('name'),
		'FIELD'		=> new htext('gr_name', array('js' => 'style="width:95%"', 'value' => (isset($this->data['name']) ? $this->data['name']['input'] : ''))),
		'REQUIRED'	=> true,
	));
	

	$this->tpl->assign_block_vars('tabs.fieldset.field', array(
		'NAME'		=> $this->user->lang('email'),
		'FIELD'		=> new htext('gr_email', array('js' =>'style="width:95%"', 'value' => (isset($this->data['email']) ? $this->data['email']['input'] : ''))),
		'REQUIRED'	=> true,
		'HELP'		=> $this->user->lang('gr_email_help'),
	));
  }
}
?>