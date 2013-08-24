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
 * $Id: update_guildrequest_020.class.php 11425 2011-11-05 16:50:34Z hoofy $
 */

if (!defined('EQDKP_INC'))
{
  header('HTTP/1.0 404 Not Found');exit;
}


include_once(registry::get_const('root_path').'maintenance/includes/sql_update_task.class.php');

if (!class_exists('update_guildrequest_020'))
{
  class update_guildrequest_020 extends sql_update_task
  {
    /**
	 * __dependencies
	 * Get module dependencies
	 */
	public static function __shortcuts()
	{
		$shortcuts = array('config');
		return array_merge(parent::__shortcuts(), $shortcuts);
	}

    public $author      = 'GodMod';
    public $version     = '0.2.0';    // new version
    public $name        = 'Guildrequest 0.2.0 Update';
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
          'update_guildrequest_020' => 'GuildRequest 0.2.0 Update Package',
		  1 => 'Alter guildrequest_fields table',
		  2 => 'Alter guildrequest_fields table',
        ),
        'german' => array(
          'update_guildrequest_020' => 'GuildRequest 0.2.0 Update Paket',
		  1 => 'Ändere guildrequest_fields Tabelle',
		  2 => 'Ändere guildrequest_fields Tabelle',
        ),
      );

      // init SQL querys
      $this->sqls = array(
		  1 => "ALTER TABLE `__guildrequest_fields` ADD COLUMN `dep_value` TEXT COLLATE utf8_bin NULL;",
		  2 => "ALTER TABLE `__guildrequest_fields` ADD COLUMN `dep_field` INT(10) UNSIGNED NULL DEFAULT '0';",
      );
    }

  }
}

if(version_compare(PHP_VERSION, '5.3.0', '<')) registry::add_const('short_update_guildrequest_020', update_guildrequest_020::__shortcuts());
?>
