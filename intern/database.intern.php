<?php
  $database_host_name = 'db5001139501.hosting-data.io';
  $database_name = 'dbs975642';
  $database_user_name = 'dbu1373105';
  $database_password = 'Gr1.V.#AsIT-P.';

  $db_connection = new mysqli($database_host_name, $database_user_name, $database_password, $database_name);

  if ($db_connection->connect_error) {
    die('<p>Verbindung zum MySQL Server fehlgeschlagen: '. $db_connection->connect_error .'</p>');
  } 
?>