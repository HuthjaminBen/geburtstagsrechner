<?php
  $database_host_name = 'XXXXXXXXXXX';
  $database_name = 'XXXXXXXXX';
  $database_user_name = 'XXXXXXXXXXX';
  $database_password = 'XXXXXXXXXXXXXXX';

  $db_connection = new mysqli($database_host_name, $database_user_name, $database_password, $database_name);

  if ($db_connection->connect_error) {
    die('<p>Verbindung zum MySQL Server fehlgeschlagen: '. $db_connection->connect_error .'</p>');
  } 
?>