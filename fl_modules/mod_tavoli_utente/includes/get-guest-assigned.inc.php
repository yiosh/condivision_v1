<?php

  require_once '../../../fl_core/autentication.php';

  $tables =  GQD('fl_tavoli_commensali','*',' tavolo_id  > 0 AND evento_id = '.$_SESSION['evento_id']); 
  echo json_encode($tables);
  mysql_close(CONNECT);

 ?>