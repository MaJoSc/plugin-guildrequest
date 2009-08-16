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

$guildrequestSQL = array(
	'uninstall'	=> array(
		'1'		=> 'DROP TABLE IF EXISTS __guildrequest_users',
		'2'		=> 'DROP TABLE IF EXISTS __guildrequest_config',
		'3'		=> 'DROP TABLE IF EXISTS __guildrequest_poll',
		'4'		=> 'DROP TABLE IF EXISTS __guildrequest_appvalues',
		'5'		=> 'DROP TABLE IF EXISTS __guildrequest_appoptions',
	),
	'install'		=> array(
		'1' => "CREATE TABLE IF NOT EXISTS __guildrequest_users (
						id INT PRIMARY KEY AUTO_INCREMENT,
						username varchar(255) NOT NULL default '0',
						email varchar(255) NOT NULL default '0',
						password varchar(255) NOT NULL default '0',
						`text` text NOT NULL,
						closed ENUM ( 'N', 'Y' ) NOT NULL DEFAULT 'N',
						activation varchar(255) NOT NULL default '0',
						activated ENUM ('N', 'Y') NOT NULL DEFAULT 'N'
						)TYPE=InnoDB;",
		'2' => "CREATE TABLE IF NOT EXISTS __guildrequest_config (
						config_name varchar(255) PRIMARY KEY NOT NULL default '0',
						config_value text NOT NULL
						)TYPE=InnoDB;",
		'3' => "CREATE TABLE IF NOT EXISTS __guildrequest_poll (
						id INT PRIMARY KEY AUTO_INCREMENT,
						query_id INT NOT NULL default '0',
						user_id INT NOT NULL default '0',
						poll_value varchar (255) NOT NULL default '0'
						)TYPE=InnoDB;",
		'4' => "CREATE TABLE IF NOT EXISTS __guildrequest_appvalues (
						id INT PRIMARY KEY AUTO_INCREMENT,
						value VARCHAR(255) NOT NULL default '0',
						type VARCHAR(255) NOT NULL default '0',
						required ENUM ('N', 'Y') NOT NULL default 'N',
						sort INT NOT NULL
						)TYPE=InnoDB;",
		'5' => "CREATE TABLE IF NOT EXISTS __guildrequest_appoptions(
						id INT PRIMARY KEY AUTO_INCREMENT,
						opt_ID INT NOT NULL,
						appoption VARCHAR(255) NOT NULL
						)TYPE=InnoDB;",
	)
);
?>