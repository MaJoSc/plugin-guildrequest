<?PHP
  $new_version = '0.0.3';
  $updateFunction = false;
  $updateDESC = array('',	
                      'Add Table for the new application form',
                      'Insert default values \'Name\' for the new application form',
                      'Insert default values \'Class\' for the new application form',
                      'Insert default values \'Level\' for the new application form',
                      'Insert default values \'Text\' for the new application form',
                      'Add Table for application options');
  $updateSQL =  array("CREATE TABLE IF NOT EXISTS __guildrequest_appvalues(
                        ID INT AUTO_INCREMENT PRIMARY KEY,
                        value VARCHAR(255) NOT NULL,
                        type VARCHAR(255) NOT NULL,
                        required ENUM ('N', 'Y') NOT NULL DEFAULT 'N'
                      );",
                      "INSERT INTO __guildrequest_appvalues(value, type, required) 
                        VALUES ('Name', 'singletext', 'Y');",
                      "INSERT INTO __guildrequest_appvalues(value, type, required) 
                        VALUES ('Class', 'singletext', 'Y');",
                      "INSERT INTO __guildrequest_appvalues(value, type, required) 
                        VALUES ('Level', 'singletext', 'N');",
                      "INSERT INTO __guildrequest_appvalues(value, type, required) 
                        VALUES ('Text', 'textfield', 'Y');",
                      "CREATE TABLE IF NOT EXISTS __guildrequest_appoptions(
                        ID INT AUTO_INCREMENT PRIMARY KEY,
                        opt_ID INT NOT NULL,
                        appoption VARCHAR(255) NOT NULL
                      );",
                      );
?>