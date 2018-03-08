<?php

header("Access-Control-Allow-Origin: *");

ini_set('display_errors',0);
error_reporting(E_ALL);
//define('TESTING',1);

include('../fl_core/core.php'); // Variabili Modulo

if(isset($_GET['t'])){

  include_once('../fl_core/class/tokenauth.php');
  $tokenauth = new tokenauth();
  if($tokenauth->valToken($_GET['t'])){
    echo 'TRUE';
  }else{
    echo 'FALSE';
 
  }

}



exit;




?>
