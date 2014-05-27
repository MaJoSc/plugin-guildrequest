<?php
/*
 * Project:     EQdkp GuildRequest
 * License:     Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:        http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:       2008
 * Date:        $Date: 2011-11-05 17:50:34 +0100 (Sa, 05. Nov 2011) $
 * -----------------------------------------------------------------------
 * @author      $Author: hoofy $
 * @copyright   2008-2011 Aderyn
 * @link        http://eqdkp-plus.com
 * @package     GuildRequest
 * @version     $Rev: 11425 $
 *
 * $Id: update_guildrequest_019.class.php 11425 2011-11-05 16:50:34Z hoofy $
 */

if (!defined('EQDKP_INC'))
{
  header('HTTP/1.0 404 Not Found');exit;
}


include_once(registry::get_const('root_path').'maintenance/includes/sql_update_task.class.php');

if (!class_exists('update_guildrequest_019'))
{
  class update_guildrequest_019 extends sql_update_task
  {

    public $author      = 'GodMod';
    public $version     = '0.1.9';    // new version
    public $name        = 'Guildrequest 0.1.9 Update';
    public $type        = 'plugin_update';
    public $plugin_path = 'guildrequest'; // important!

    /**
     * Constructor
     */
    public function __construct()
    {
      parent::__construct();

      // init language
      $this->langs = array(
        'english' => array(
          'update_guildrequest_019' => 'GuildRequest 0.1.9 Update Package',
		  1 => 'Change guildrequest_visits table',
        ),
        'german' => array(
          'update_guildrequest_019' => 'GuildRequest 0.1.9 Update Paket',
		  1 => 'Ändere guildrequest_visits Tabelle',
        ),
      );

      // init SQL querys
      $this->sqls = array(
		  1 => "ALTER TABLE `__guildrequest_visits`
	DROP PRIMARY KEY,
	ADD PRIMARY KEY (`request_id`, `user_id`);",
      );
    }

  }
}
?>
