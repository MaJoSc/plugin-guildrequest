<?PHP
  $new_version = '0.0.2';
  $updateFunction = false;
  $updateDESC = array(
	'SD  ',
	'Nur zum Testen'
  );
  $updateSQL = array("ALTER TABLE __guildrequest_config ADD test_eintrag varchar(255);");
?>