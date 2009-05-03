<?php
 /*
 * Project:     EQdkp RaidBanker
 * License:     Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		    http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:       2005
 * Date:        $Date: 2008-11-21 13:19:36 +0100 (Fr, 21. Nov 2008) $
 * -----------------------------------------------------------------------
 * @author      $Author: wallenium $
 * @copyright   2005-2008 Simon (Wallenium) Wallmann
 * @link        http://eqdkp-plus.com
 * @package     raidbanker
 * @version     $Rev: 3211 $
 * 
 * $Id: common.php 3211 2008-11-21 12:19:36Z wallenium $
 */

  if ( !defined('EQDKP_INC') ){
    header('HTTP/1.0 404 Not Found');exit;
  } 
  
  if (!isset($eqdkp_root_path)){
    $eqdkp_root_path = './';
  }
  include_once($eqdkp_root_path . 'common.php');
    
  /**
  * Framework include
  **/
  require_once($eqdkp_root_path . 'plugins/guildrequest/include/libloader.inc.php');
    
  /**
  * Load the global Configuration
  */
  $sql = 'SELECT * FROM __guildrequest_config';
  if (!($settings_result = $db->query($sql))) { message_die('Could not obtain configuration data', '', __FILE__, __LINE__, $sql); }
  while($roww = $db->fetch_record($settings_result)) {
    $conf[$roww['config_name']] = $roww['config_value'];
  }
  $db->free_result($settings_result);
  
?>
