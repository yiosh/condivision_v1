<?php 

// Controllo Login
session_start(); 
if(!isset($_SESSION['user'])){ header("Location: ../../login.php"); exit; }
require('../../fl_core/core.php'); 



if(isset($_POST['etichetta'])) {

$etichetta = check($_POST['etichetta']);
$priorita = (isset($_POST['priorita'])) ? check($_POST['priorita']) : 0;
$_SESSION['livello_atteso'] = $livello_atteso = check($_POST['livello_atteso']);
$_SESSION['categoria'] =  $categoria = (isset($_POST['categoria'])) ? check($_POST['categoria']) : 0;
$parent_id = check($_POST['funzione_id']);


$query = "INSERT INTO `fl_competenze` (`id`, `funzione_id`, `categoria`, `etichetta`, `livello_atteso`, `priorita`, `data_creazione`, `operatore`) 
VALUES (NULL, '$parent_id ', '$categoria', '$etichetta', '$livello_atteso', '$priorita', NOW(), '".$_SESSION['number']."')";
mysql_query($query,CONNECT);

}

mysql_close(CONNECT);
header("Location: ".check($_SERVER['HTTP_REFERER'])); 
exit;
					
?>  

