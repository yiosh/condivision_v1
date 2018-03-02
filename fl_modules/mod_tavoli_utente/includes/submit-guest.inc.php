<?php

require_once '../../../fl_core/autentication.php';


if(isset($_POST['submit-guest'])) {
  
  
  $tipo_commensale = 4;
  $evento_id = $_SESSION['evento_id'];
  
 
  foreach ($_POST as $key => $value) {
    $$key = check($value);
  }
  

  
  $query = "INSERT INTO fl_tavoli_commensali(nome, cognome, adulti, bambini, seggioloni,note_intolleranze,tipo_commensale,evento_id) 
  VALUES ('$nome', '$cognome', '$adulti', '$bambini', '$seggioloni','$note_intolleranze',$tipo_commensale,$evento_id)";
  
   if(!mysql_query($query)) echo mysql_error();

   mysql_close(CONNECT);
   header("Location: ".$_SERVER['HTTP_REFERER']); 
   exit;
 }

