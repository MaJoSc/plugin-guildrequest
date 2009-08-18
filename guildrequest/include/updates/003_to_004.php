<?PHP
  $new_version = '0.0.4';
  $updateFunction = false;
  $updateDESC = array('',	
                      'Add a new user right to place votings');
  $updateSQL =  array("INSERT INTO __auth_options(auth_id, auth_value, auth_default)
                        VALUES ('8958', 'u_guildrequest_vote', 'Y');",
                      );
?>
