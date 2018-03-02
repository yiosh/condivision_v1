<?php
  require('db.config.php');

  $evento_id = check($_GET['evento_id']);
  $evento_details = GRD('fl_eventi_hrc', $evento_id);

  // Create Query
  $queryTables = $conn->prepare('SELECT * FROM fl_tavoli WHERE evento_id = '.$evento_id);
  $queryTables->execute();
  // Fetch results
  $tables = $queryTables->fetchAll();

  $queryGuests = $conn->prepare('SELECT * FROM fl_tavoli_commensali WHERE evento_id = '.$evento_id);// WHERE tavolo_id<>0
  $queryGuests->execute();
  // Fetch results
  $guests = $queryGuests->fetchAll();