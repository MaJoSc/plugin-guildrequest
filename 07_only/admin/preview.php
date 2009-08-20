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
  * Package:   Guildrequest                                                          *
  \**********************************************************************************/

define('EQDKP_INC', true);
define('IN_ADMIN', true);
define('PLUGIN', 'guildrequest');
$eqdkp_root_path = './../../../';

include_once('../includes/common.php');

// Check user permission
$user->check_auth('a_guildrequest_manage');

if (!$pm->check(PLUGIN_INSTALLED, 'guildrequest')) {
	message_die('The Guildrequest plugin is not installed.');
}

$line = unserialize($in->get('line'));

// Order Output by sorting
	foreach ($line as $key => $row) {
			$sort[$key] = $row['sort'];
	}
	array_multisort($sort, $line);

echo '<table width="100%">';
for ($row=0; $row <= 1024; $row++){
	if ($line[$row]['sort']) {
	echo '<tr>
					<td>'.$line[$row]['id'].'</td>
					<td>'.$line[$row]['value'].'</td>
					<td>'.$line[$row]['type'].'</td>
					<td>'.$line[$row]['required'].'</td>
					<td>'.$line[$row]['sort'].'</td>
					<td>'.$line[$row]['new'].'</td>
				</tr>';
	}
}
echo '</table>';
?>