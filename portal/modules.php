<?php
 /*
 * Project:     EQdkp RaidPlanner
 * License:     Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		    http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:       2005
 * Date:        $Date: 2008-07-29 13:41:36 +0200 (Di, 29 Jul 2008) $
 * -----------------------------------------------------------------------
 * @author      $Author: wallenium $
 * @copyright   2005-2008 Simon (Wallenium) Wallmann
 * @link        http://eqdkp-plus.com
 * @package     raidplan
 * @version     $Rev: 2454 $
 * 
 * $Id: modules.php 2454 2008-07-29 11:41:36Z wallenium $
 */
 
if ( !defined('EQDKP_INC') ){
  header('HTTP/1.0 404 Not Found');exit;
}

// The modules for this plugin to load by PLUS...
$pluginmodules = array(
  'guildrequest', 
);

?>