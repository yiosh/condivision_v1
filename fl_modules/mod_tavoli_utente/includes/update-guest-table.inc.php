<?php


require_once '../../../fl_core/autentication.php';

$tavolo_id = check($_REQUEST['tavolo_id']);
$user_id = check($_REQUEST['user_id']);


$query = "UPDATE fl_tavoli_commensali SET tavolo_id = $tavolo_id, data_aggiornamento = NOW() WHERE id = $user_id;";

if(mysql_query($query,CONNECT)) {
	echo json_encode(array('esito'=>true)); 
} else {  
	echo json_encode(array('esito'=>mysql_error())); 
}

mysql_close(CONNECT);
exit; 

?>