<?php
/*
 * Project:     EQdkp guildrequest_requests
 * License:     Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:        http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:       2008
 * Date:        $Date: 2011-11-01 13:38:39 +0100 (Di, 01. Nov 2011) $
 * -----------------------------------------------------------------------
 * @author      $Author: hoofy $
 * @copyright   2008-2011 Aderyn
 * @link        http://eqdkp-plus.com
 * @package     guildrequest_requests
 * @version     $Rev: 11419 $
 *
 * $Id: pdh_w_guildrequest_requests.class.php 11419 2011-11-01 12:38:39Z hoofy $
 */

if (!defined('EQDKP_INC'))
{
  die('Do not access this file directly.');
}

/*+----------------------------------------------------------------------------
  | pdh_w_guildrequest_requests
  +--------------------------------------------------------------------------*/
if (!class_exists('pdh_w_guildrequest_requests'))
{
  class pdh_w_guildrequest_requests extends pdh_w_generic
  {

  	private $arrLogLang = array(
  			'id'			=> "{L_ID}",
  			'tstamp'        => "{L_DATE}",
			'username'		=> "{L_USERNAME}",
			'email'			=> "{L_EMAIL}",
			'auth_key'		=> "Auth Key",
			'lastvisit'		=> "Last visit",
			'activation_key'=> "Activation Key",
			'status'		=> "Status",
			'activated'		=> "Activated",
			'closed'		=> "Closed",
			'content'		=> "Content",
  	);
  	
  	
  	public function add($strName, $strEmail, $strAuthKey, $strActivationKey, $strContent, $intActivated=1){
  		$arrQuery = array(
            'tstamp'        => $this->time->time,
			'username'		=> $strName,
			'email'			=> register('encrypt')->encrypt($strEmail),
			'auth_key'		=> $strAuthKey,
			'lastvisit'		=> 0,
			'activation_key'=> $strActivationKey,
			'status'		=> 0,
			'activated'		=> $intActivated,
			'closed'		=> 0,
			'content'		=> $strContent,
			'voting_yes'	=> 0,
			'voting_no'		=> 0,
			'voted_user'	=> '',
		);
		$objQuery = $this->db->prepare("INSERT INTO __guildrequest_requests :p")->set($arrQuery)->execute();
		
		$this->pdh->enqueue_hook('guildrequest_requests_update');
		if ($objQuery) {
			$id = $objQuery->insertId;
			$log_action = $this->logs->diff(false, $arrQuery, $this->arrLogLang);
			$this->log_insert("action_request_added", $log_action, $id, $arrQuery["username"], 0, 'guildrequest');
			
			return $id;
		}
		
		return false;
	}
	
	public function delete($intID){
		$arrOld = $this->pdh->get('guildrequest_requests', 'id', array($intID));
		$objQuery = $this->db->prepare("DELETE FROM __guildrequest_requests WHERE id=?")->execute($intID);
		
		$arrChanges = $this->logs->diff(false, $arrOld, $this->arrLang);
			
		if ($arrChanges){
			$this->log_insert('action_request_deleted', $arrChanges, $intID, $arrOldData["username"], 1, 'guildrequest');
		}
		
		$this->pdh->enqueue_hook('guildrequest_requests_update');
		return true;
	}
	
	public function set_lastvisit($intID){
		$objQuery = $this->db->prepare("UPDATE __guildrequest_requests :p WHERE id=?")->set(array(
			'lastvisit'		=> $this->time->time,
		))->execute($intID);
		
		$this->pdh->enqueue_hook('guildrequest_requests_update');
		if ($objQuery) return $intID;
		
		return false;
	}
	
	public function truncate(){
		$this->db->query("TRUNCATE __guildrequest_requests");
		$this->pdh->enqueue_hook('guildrequest_requests_update');
		
		$this->log_insert('action_requests_truncated', array(), 0, 'all', 1, 'guildrequest');
		return true;
	}
	
	public function update_voting($intID, $intYes, $intNo, $arrVotedUser){
		$objQuery = $this->db->prepare("UPDATE __guildrequest_requests :p WHERE id=?")->set(array(
			'voting_yes'	=> $intYes,
			'voting_no'		=> $intNo,
			'voted_user'	=> serialize($arrVotedUser),
		))->execute($intID);
		
		if ($objQuery) return $intID;
		
		return false;
	}
	
	public function close($intID){
		$objQuery = $this->db->prepare("UPDATE __guildrequest_requests :p WHERE id=?")->set(array(
			'closed'	=> 1,
		))->execute($intID);
		
		$this->log_insert('action_request_closed', array(), $intID, $this->pdh->get('guildrequest_requests', 'username', $intID), 1, 'guildrequest');
		
		$this->pdh->enqueue_hook('guildrequest_requests_update');
		if ($objQuery) return $intID;
		
		return false;
	}
	
	public function open($intID){
		$objQuery = $this->db->prepare("UPDATE __guildrequest_requests :p WHERE id=?")->set(array(
			'closed'	=> 0,
		))->execute($intID);
		
		$this->log_insert('action_request_opened', array(), $intID, $this->pdh->get('guildrequest_requests', 'username', $intID), 1, 'guildrequest');
		
		
		$this->pdh->enqueue_hook('guildrequest_requests_update');
		if ($objQuery) return $intID;
		
		return false;
	}
	
	public function update_status($intID, $intStatus){
		$objQuery = $this->db->prepare("UPDATE __guildrequest_requests :p WHERE id=?")->set(array(
			'status'	=> $intStatus,
		))->execute($intID);
		
		$this->log_insert('action_status_changed', array('status' => $intStatus), $intID, $this->pdh->get('guildrequest_requests', 'username', $intID), 1, 'guildrequest');
		
		
		$this->pdh->enqueue_hook('guildrequest_requests_update');
		if ($objQuery) return $intID;
		
		return false;
	}

  } //end class
} //end if class not exists

?>