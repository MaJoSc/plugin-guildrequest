<?php
/*
 * Project:     EQdkp guildrequest_fields
 * License:     Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:        http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:       2008
 * Date:        $Date: 2011-11-01 13:38:39 +0100 (Di, 01. Nov 2011) $
 * -----------------------------------------------------------------------
 * @author      $Author: hoofy $
 * @copyright   2008-2011 Aderyn
 * @link        http://eqdkp-plus.com
 * @package     guildrequest_fields
 * @version     $Rev: 11419 $
 *
 * $Id: pdh_w_guildrequest_fields.class.php 11419 2011-11-01 12:38:39Z hoofy $
 */

if (!defined('EQDKP_INC'))
{
  die('Do not access this file directly.');
}

/*+----------------------------------------------------------------------------
  | pdh_w_guildrequest_fields
  +--------------------------------------------------------------------------*/
if (!class_exists('pdh_w_guildrequest_fields'))
{
  class pdh_w_guildrequest_fields extends pdh_w_generic
  {
    /**
     * __dependencies
     * Get module dependencies
     */
    public static function __shortcuts()
    {
      $shortcuts = array('db', 'pdh', 'time');
      return array_merge(parent::$shortcuts, $shortcuts);
    }

	public function add($intID, $strType, $strName, $strHelp, $arrOptions, $intSortID, $intRequired, $intInList = 0, $dep_field='', $dep_value=''){
		$objQuery = $this->db->prepare("INSERT INTO __guildrequest_fields :p")->set(array(
			'id'		=> $intID,
			'type'		=> $strType,
			'name'		=> $strName,
			'help'		=> $strHelp,
			'options'	=> serialize($arrOptions),
			'sortid' 	=> $intSortID,
			'required' 	=> $intRequired,
			'in_list'	=> $intInList,
			'dep_field' => $dep_field,
			'dep_value' => $dep_value,
		))->execute();
		
		$this->pdh->enqueue_hook('guildrequest_fields_update');
		if ($objQuery) return $objQuery->insertId;
		
		return false;
	}
	
	public function update($intID, $strType, $strName, $strHelp, $arrOptions, $intSortID, $intRequired, $intInList = 0, $dep_field='', $dep_value=''){
		$objQuery = $this->db->prepare("UPDATE __guildrequest_fields :p WHERE id=?")->set(array(
			'type'		=> $strType,
			'name'		=> $strName,
			'help'		=> $strHelp,
			'options'	=> serialize($arrOptions),
			'sortid' 	=> $intSortID,
			'required' 	=> $intRequired,
			'in_list'	=> $intInList,
			'dep_field' => $dep_field,
			'dep_value' => $dep_value,
		))->execute($intID);
		
		$this->pdh->enqueue_hook('guildrequest_fields_update');
		if ($objQuery) return $intID;
		
		return false;
	}
	
	public function delete($intID){
		$this->db->prepare("DELETE FROM __guildrequest_fields WHERE id=?")->execute($intID);
		$this->pdh->enqueue_hook('guildrequest_fields_update');
		return true;
	}
	
	public function truncate(){
		$this->db->query("TRUNCATE __guildrequest_fields");
		$this->pdh->enqueue_hook('guildrequest_fields_update');
		return true;
	}

  } //end class
} //end if class not exists

?>