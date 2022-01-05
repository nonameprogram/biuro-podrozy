<?php

  $db_host = 'localhost';
  $db_username = 'root';
  $db_password = '';
  $db_name = 'biuro_podrozy';

  $polaczenie = mysqli_connect($db_host, $db_username, $db_password, $db_name) or die ("Błąd połączenia z bazą danych.");

 ?>
