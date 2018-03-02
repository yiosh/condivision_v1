<?php

  $DB_host = $host;
  $DB_user = $login;
  $DB_pass = $pwd;
  $DB_name = $db;


  // Create and check Connection
  try {
     $conn = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 } catch(PDOException $e) {
    // Connection failes
    echo "ERROR : ".$e->getMessage();
 }

?>