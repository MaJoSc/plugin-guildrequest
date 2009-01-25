<?php
 /*
 * Project:     eqdkpPLUS Library Manager
 * License:     Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		    http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:       2008
 * Date:        $Date: 2008-12-27 15:21:08 +0100 (Sa, 27. Dez 2008) $
 * ----------------------------------------------------------------------- 
 * @author      $Author: sz3 $
 * @copyright   2008 Simon (Wallenium) Wallmann
 * @link        http://eqdkp-plus.com
 * @package     libraries
 * @version     $Rev: 3528 $
 * 
 * $Id: libloader.inc.php 3528 2008-12-27 14:21:08Z sz3 $
 */
  
  // Configuration
  $myPluginID       = 'guildrequest';         // Plugin ID, p.e. 'raidplan'
  $myPluginIncludes = 'include';   // Includes Folder of Plugin
  
  // DO NOT CHANGE
  if ( !defined('EQDKP_INC') ){
    header('HTTP/1.0 404 Not Found');exit;
  } 
  
  // Do we need the Library or is it included with eqdkpPLUS 0.7++?
  if(!function_exists('CheckLibVersion')){
  
    // Check the php Version... php4 does not allow _autoloader
    $phpversionnr   = (version_compare(phpversion(), "5.0.0", ">=")) ? '5' : '4';
    $myLibraryPath  = $eqdkp_root_path . 'libraries/libraries.php'.$phpversionnr.'.php';
    
    // The library Loader is not available
    if(!file_exists($myLibraryPath)){
      $libnothere_txt = ($user->lang['libloader_notfound']) ? $user->lang['libloader_notfound'] : 'Library Loader not available! Check if the "eqdkp/libraries/" folder is uploaded correctly';
      message_die($libnothere_txt);
    }
    
    // Load the Plugin Core
    require_once($myLibraryPath);
    
    // Load the needed Plugin Core Library & check ifs needed Version..
    $wpfccore = new pluginCore();
    CheckLibVersion('pluginCore', $wpfccore->version, $pm->plugins[$myPluginID]->fwversion);

    $jquery   = new jquery(); 
    $khrml    = new myHTML($myPluginID, $myPluginIncludes);
    $tpl->assign_vars(array('JQUERY_INCLUDES'   => $jquery->Header()));
  }else{
    // Load the needed Plugin Core Library & check ifs needed Version..
    $wpfccore = new pluginCore();
    CheckLibVersion('pluginCore', $wpfccore->version, $pm->plugins[$myPluginID]->fwversion);
    $khrml    = new myHTML($myPluginID, $myPluginIncludes);
    $tpl->assign_vars(array('JQUERY_INCLUDES'   => ''));
  }
?>
