<?PHP
  $new_version = '0.0.3';
  $updateFunction = false;
  $updateDESC = array('',	
                      'Add Table for the new application form',
                      'Insert default values \'Name\' for the new application form',
                      'Insert default values \'Class\' for the new application form',
                      'Insert default values \'Level\' for the new application form',
                      'Insert default values \'Text\' for the new application form',
                      'Add Table for application options',
                      'Add user Permission for Comments',
			'Add new Option for popup, when inactive applications exist');
  $updateSQL =  array("CREATE TABLE IF NOT EXISTS __guildrequest_appvalues(
                        ID INT AUTO_INCREMENT PRIMARY KEY,
                        value VARCHAR(255) NOT NULL,
                        type VARCHAR(255) NOT NULL,
                        required ENUM ('N', 'Y') NOT NULL DEFAULT 'N',
                        sort INT NOT NULL
                      );",
                      "INSERT INTO __guildrequest_appvalues(value, type, required, sort) 
                        VALUES ('Name', 'singletext', 'Y', '1');",
                      "INSERT INTO __guildrequest_appvalues(value, type, required, sort) 
                        VALUES ('Class', 'singletext', 'Y', '2');",
                      "INSERT INTO __guildrequest_appvalues(value, type, required, sort) 
                        VALUES ('Level', 'singletext', 'N', '3');",
                      "INSERT INTO __guildrequest_appvalues(value, type, required, sort) 
                        VALUES ('Text', 'textfield', 'Y', '4');",
                      "CREATE TABLE IF NOT EXISTS __guildrequest_appoptions(
                        ID INT AUTO_INCREMENT PRIMARY KEY,
                        opt_ID INT NOT NULL,
                        appoption VARCHAR(255) NOT NULL
                      );",
                      "INSERT INTO __auth_options(auth_id, auth_value, auth_default)
                        VALUES ('8957', 'u_guildrequest_comment', 'Y');",
		      "INSERT INTO __guildrequest_config (config_name, config_value)
			VALUES ('gr_popup_activated', 'N');",
                      );
?>
