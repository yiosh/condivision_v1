<?php


class webservice{


	var $demo = false; // Se abilitare o meno il demo 
	var $datatype = "JSON";	
	var $contenuto = array();
	var $token;
	var $user;
	var $password;
	var $uid;
	var $userId; 
	var $accountId; //User that is connected
	var $obbligatorio = array('nome');
	var $numerici = array('telefono','cellulare');
	var $date = array();
	var $table = 'fl_leads';
	var $secret = 're56fdsfw285hfw5k3923k2ASYLWJ8tr3';
	var $push_type = 'post';
	var $fcmToken = 0;
	var $recordId = 1;
	var $what = '*';
	//var $start_Date = $_GET['start_Date'];
	//var $end_Date = $_GET['end_Date'] ;
	


function app_start(){
	session_cache_limiter( 'private_no_expire' );
	session_cache_expire(time()+5259200); 
    session_start();		
	if(session_id() != $this->token && $this->token != 'app') {	
	    $this->contenuto = '';
		$this->contenuto['esito'] = 0;
		$this->contenuto['info_txt'] = 'Not valid session. Please restart app';
		mysql_close(CONNECT);		
		echo json_encode($this->contenuto);
		exit;
	}

}

private function cnv_makedata(){
	
	mysql_close(CONNECT);		
	
	if($this->datatype == 'JSON') {
	echo json_encode($this->contenuto);
	exit;
	}
	
    if($this->datatype == 'OBJECT') {
	return $this->contenuto;
	}
	
	if($this->datatype == 'XML') {
	echo json_encode($this->contenuto);
	exit;
	}
	
}

function insertUpdate($recordId){

	$issue = 0;
	if($recordId == 0) mail('michelefazio@aryma.it','Record id 0 in insertUpdate',$recordId);
	$sql = 'DESCRIBE '.$this->table.';';
	$updateSQL = 'UPDATE '.$this->table.' SET ';
	$createSQL = 'INSERT INTO '.$this->table.' VALUES ();';
	$fields = $this->query($sql);
	
	sleep(1);
	
	while($FieldProp = mysql_fetch_array($fields)){ 
		
		$FieldName = $FieldProp['Field'];
		if($FieldName == 'data_aggiornamento' && $recordId != 1) $updateRecord = 1;
		if($FieldName != 'id' && $FieldName != 'data_creazione'){
		if(isset($_GET['explain'])) echo "VALUE EXPECTED: ".$FieldName.' ('.$FieldProp['Type'].','.$FieldProp['Null'].','.$FieldProp['Default'].')<br>';
			
			if(isset($_REQUEST[$FieldName])){
				$Field = $this->check($_REQUEST[$FieldName]); // Security Checl of the received string
				if(isset($comma)) { $updateSQL .=  ',';  }  else { $comma = 1; }
				$updateSQL .= $this->cherookee($Field,$FieldName,$FieldProp['Type'],$FieldProp['Null'],$FieldProp['Default']); //Formal type check of field
			}
		}
	}

	if(!isset($updateRecord) && $recordId == 1) $updateSQL .=  ', data_creazione = NOW() '; //Used only for new entries!
	if(isset($updateRecord)) $updateSQL .=  ', data_aggiornamento = NOW() '; 


	

	if($recordId == 1 && !isset($_GET['explain'])) { $this->query($createSQL); $recordId = mysql_insert_id();  } // if 1 create a new record	
	
	$updateSQL .= ' WHERE id = '.$recordId;
	$issue = (isset($_GET['explain'])) ? '(NO QUERY SENT IN DEBUG MODE) : '.$updateSQL : $this->query($updateSQL);
	if($issue < 1) mail('supporto@aryma.it','Query app error',$updateSQL);
	if($issue == 1) $issue = $recordId;
	
	return  $issue;//Issue of Update
	
}

function getRecordData(){ 

	$sql = 'SELECT '.$this->what.' FROM '.$this->table.' WHERE id = '.$this->recordId;
	$result = $this->query($sql);
	return ($result == true) ? mysql_fetch_assoc($result) : false;

}

function query($sql){ 
  $results = mysql_query($sql,CONNECT);
  if(mysql_affected_rows() < 0) mail('supporto@aryma.it','Query app error',$sql.mysql_error());
  return  (mysql_affected_rows() >= 0) ? $results : -1;

}

function checkDuplicate($sql){ 
  $results = mysql_query($sql,CONNECT);
  return  (mysql_affected_rows() >= 0) ? mysql_affected_rows() : -1;
}

function cherookee($Field,$FieldName,$Type,$Null=NULL,$Default=''){ 
  if($Type == 'date')  $Field = $this->determina_data($Field); 
  if(isset($_GET['explain'])) echo 'SENT: '.$FieldName.' = '.$Field.' '.$Type.'<br>'; 
  return  '`'.$FieldName.'` =  \''.$Field.'\''; //Per ora non fa nulla
}


public function determina_data($data){
	$str_array = preg_split('/[\/\-]/', $data);
	return (strlen($str_array[0]) == 4) ? $data : $this->convert_data($data,1);
}



function get_data_values(){ // source data service
	




$leads_daily = "SELECT count(*) as tot FROM fl_potentials WHERE   DAY(data_creazione) = DAY(CURDATE()) AND MONTH(data_creazione) = MONTH(CURDATE()) AND YEAR(data_creazione) = YEAR(CURDATE())";

$leads_monthly = "SELECT count(*) AS tot FROM fl_potentials WHERE MONTH(data_creazione) = MONTH(CURDATE())
  AND YEAR(data_creazione) = YEAR(CURDATE())";

$sales_monthly = "SELECT SUM( `price` ) AS tot
FROM `fl_contratti`
WHERE `marchio` =1
AND MONTH( `data_creazione` ) = MONTH( CURDATE( ) )
AND YEAR( `data_creazione` ) = YEAR( CURDATE( ) ) ";
  
$revenue_monthly = "SELECT SUM( `importo` ) AS tot
FROM `fl_pagamenti`
WHERE `marchio` =1 AND (status_pagamento = 4 OR status_pagamento = 7) AND causale BETWEEN 1 AND 5
AND MONTH( `data_operazione` ) = MONTH( CURDATE( ) )
AND YEAR( `data_operazione` ) = YEAR( CURDATE( ) ) ";

$potentialSBySourceMonthlyUK = "SELECT `source_potential` , count( * )
FROM `fl_potentials`
WHERE `marchio` =1
AND MONTH( `data_creazione` ) = MONTH( CURDATE( ) )
AND YEAR( `data_creazione` ) = YEAR( CURDATE( ) )
GROUP BY `source_potential`";

$potentialSBySourceDailyUK = "SELECT `source_potential` , count( * )
FROM `fl_potentials`
WHERE `marchio` =1
AND DAY(data_creazione) = DAY(CURDATE())  
AND MONTH( `data_creazione` ) = MONTH( CURDATE( ) )
AND YEAR( `data_creazione` ) = YEAR( CURDATE( ) )
GROUP BY `source_potential`";


$potentialSByStatusMonthlyUK = "SELECT `status_potential` , count( * )
FROM `fl_potentials`
WHERE `marchio` = 1
AND MONTH( `data_creazione` ) = MONTH( CURDATE( ) )
AND YEAR( `data_creazione` ) = YEAR( CURDATE( ) )
GROUP BY `status_potential`";

$morning_check = "SELECT tb1 . * , tb2.user
FROM `fl_contratti` AS tb1
LEFT JOIN fl_admin AS tb2 ON tb1.operatore = tb2.id
WHERE tb1.`data_creazione` = ( CURDATE( ) - INTERVAL 1
DAY )
LIMIT 0 , 100";

$customersTotalsMonthlyUK = "SELECT count( * ) AS tot
FROM `fl_customers`
WHERE `marchio` = 1
AND MONTH( `data_creazione` ) = MONTH( CURDATE( ) )
AND YEAR( `data_creazione` ) = YEAR( CURDATE( ) )";


  	$path = check($_GET['path']);
	$query = $$path;
	if($risultato = mysql_query($query,CONNECT)){
	
	$riga = mysql_fetch_array($risultato);
	
	$this->contenuto['total'] = $riga['tot'];
	
	} else { 
	$this->contenuto['class'] = 'red';
	$this->contenuto['esito'] = "Error 1102: Errore caricamento.".mysql_error();
	}
	
	$this->cnv_makedata();
}

/*function get_data_values_second(){ 

$leads_between = "SELECT count(*) as tot FROM fl_potentials WHERE  data_creazione between '.$start_Date.' AND '.$end_Date.' ";

$path = check($_GET['path']);
	$query = $$path;
	if($risultato = mysql_query($query,CONNECT)){
	
	$riga = mysql_fetch_array($risultato);
	
	$this->contenuto['total'] = $riga['tot'];

	} else { 
	$this->contenuto['class'] = 'red';
	$this->contenuto['esito'] = "Error 1102: Errore caricamento.".mysql_error();
	}
	
	$this->cnv_makedata();



}*/

function get_data_rows(){ // source data service


$data_da = date('Y-m-1');
$data_a = date('Y-m-d');

if(isset($_GET['data_da'])) $data_da = check($_GET['data_da']);
if(isset($_GET['data_a'])) $data_a = check($_GET['data_a']);


$potentialSLast7Days = "SELECT `data_creazione` , count( * ) as tot
FROM `fl_potentials`
WHERE `marchio` =1
AND  `data_creazione` > (NOW() - INTERVAL 7 DAY)
GROUP BY `data_creazione`
ORDER BY `data_creazione` DESC
";



$potentialSBySourceMonthlyUK = "SELECT `source_potential` , count( * ) as tot
FROM `fl_potentials`
WHERE `marchio` =1
AND MONTH( `data_creazione` ) = MONTH( CURDATE( ) )
AND YEAR( `data_creazione` ) = YEAR( CURDATE( ) )
GROUP BY `source_potential`
";

$potentialSBySourceDailyUK = "SELECT `source_potential` , count( * ) as tot
FROM `fl_potentials`
WHERE `marchio` =1
AND DAY(data_creazione) = DAY(CURDATE())  
AND MONTH( `data_creazione` ) = MONTH( CURDATE( ) )
AND YEAR( `data_creazione` ) = YEAR( CURDATE( ) )
GROUP BY `source_potential`
";

$potentialSBySource30daysUK = "SELECT `source_potential` , count( * ) as tot
FROM `fl_potentials`
WHERE `marchio` = 1
AND data_creazione > NOW() - INTERVAL 30 DAY 
GROUP BY `source_potential`
";

$potentialSBySource30daysPastYearUK = "SELECT `source_potential` , count( * ) as tot
FROM `fl_potentials`
WHERE `marchio` =1
AND data_creazione > NOW() - INTERVAL 365 DAY
GROUP BY `source_potential`
";

$issue = array('Booked','Arrived','In Contract','No Show','Not Interested','Pending','In meeting');
$issue = (isset($_GET['issue'])) ? ' AND issue = '.check($_GET['issue']) : '';
$meetingsLast7days = "
SELECT CONCAT(DAY(`meeting_date`),'/', MONTH(`meeting_date`)) AS day , count( * ) AS tot
FROM `fl_meeting_agenda` 
WHERE `meeting_date` BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW() $issue 
GROUP BY `meeting_date`
";


$potentialSByStatusMonthlyUK = "SELECT `status_potential` , count( * ) as tot
FROM `fl_potentials`
WHERE `marchio` = 1
AND MONTH( `data_creazione` ) = MONTH( CURDATE( ) )
AND YEAR( `data_creazione` ) = YEAR( CURDATE( ) )
GROUP BY `status_potential`
";

$potentialSByStatusDailyUK = "SELECT `status_potential` , count( * ) as tot
FROM `fl_potentials`
WHERE `marchio` = 1
AND DAY(data_creazione) = DAY(CURDATE())  
AND MONTH( `data_creazione` ) = MONTH( CURDATE( ) )
AND YEAR( `data_creazione` ) = YEAR( CURDATE( ) )
GROUP BY `status_potential`
";

$potentialSFunnel = "SELECT `status_potential` , count( * ) as tot
FROM `fl_potentials`
WHERE `marchio` = 1
AND MONTH( `data_creazione` ) = MONTH( CURDATE( ) )
AND YEAR( `data_creazione` ) = YEAR( CURDATE( ) )
AND status_potential IN(0,1,2,7)
GROUP BY `status_potential`
";


$potentialSByLanguageUK = "SELECT preferedlanguage, count( preferedlanguage ) AS tot
FROM fl_potentials
WHERE id > 1 AND preferedlanguage > 1 AND data_creazione > NOW() - INTERVAL 90 DAY 
GROUP BY preferedlanguage ORDER BY tot DESC
";

$potentialSByLanguageDailyUK = "SELECT preferedlanguage, count( preferedlanguage ) AS tot
FROM fl_potentials
WHERE id > 1 AND preferedlanguage > 1  AND DAY(data_creazione) = DAY(CURDATE())  
AND MONTH( `data_creazione` ) = MONTH( CURDATE( ) )
AND YEAR( `data_creazione` ) = YEAR( CURDATE( ) )
GROUP BY preferedlanguage ORDER BY tot DESC
";

$potentialSByLanguageMonthlyUK = "SELECT preferedlanguage, count( preferedlanguage ) AS tot
FROM fl_potentials
WHERE id > 1 AND preferedlanguage > 1 AND MONTH(`data_creazione` ) = MONTH( CURDATE( ) )
AND YEAR( `data_creazione` ) = YEAR( CURDATE( ) )
GROUP BY preferedlanguage ORDER BY tot DESC
";


$salesBySourceMonthlyUK = "SELECT tb1.source_id, SUM( tb2.price ) AS tot
FROM `fl_customers` AS tb1
LEFT JOIN fl_contratti AS tb2 ON tb1.id = tb2.customer_rel
WHERE tb1.marchio <2
AND MONTH( tb1. `data_creazione` ) = MONTH( CURDATE( ) )
AND YEAR( tb1. `data_creazione` ) = YEAR( CURDATE( ) )
GROUP BY tb1.`source_id` DESC  ORDER BY tot DESC";

$salesBySource3MonthsUK = "SELECT tb1.source_id, SUM( tb2.price ) AS tot
FROM `fl_customers` AS tb1
LEFT JOIN fl_contratti AS tb2 ON tb1.id = tb2.customer_rel
WHERE tb1.marchio <2
AND tb1.`data_creazione` > CURDATE( ) - INTERVAL 90
DAY
GROUP BY tb1.`source_id` DESC  ORDER BY tot DESC";

$salesBySourceYearsUK = "SELECT tb1.source_id, SUM( tb2.price ) AS tot
FROM `fl_customers` AS tb1
LEFT JOIN fl_contratti AS tb2 ON tb1.id = tb2.customer_rel
WHERE tb1.marchio <2
AND tb1.`data_creazione` > CURDATE( ) - INTERVAL 365
DAY
GROUP BY tb1.`source_id` DESC  ORDER BY tot DESC";

$salesBySourceWeekUK = "SELECT tb1.source_id, SUM( tb2.price ) AS tot
FROM `fl_customers` AS tb1
LEFT JOIN fl_contratti AS tb2 ON tb1.id = tb2.customer_rel
WHERE tb1.marchio <2
AND tb1.`data_creazione` > CURDATE( ) - INTERVAL 7
DAY
GROUP BY tb1.`source_id` DESC  ORDER BY tot DESC";



$productsByType = "SELECT `product_desc`,SUM(`price`) as totale, marchio FROM `fl_contratti` WHERE `marchio` = 1 AND MONTH( `data_creazione` ) = MONTH( CURDATE( ) )
AND YEAR( `data_creazione` ) = YEAR( CURDATE( ) ) GROUP BY product_desc ORDER BY totale DESC
";



$paymentBySource = "SELECT `source_id` , SUM( importo ) AS tot
FROM `fl_customers` AS `tb1`
LEFT JOIN `fl_pagamenti` AS `tb2` ON tb1.id = tb2.customer_rel
WHERE (
tb1.data_creazione
BETWEEN '$data_da'
AND '$data_a'
)
AND tb2.causale =1
GROUP BY source_id
ORDER BY tot DESC
LIMIT 0 , 1000
";

$newCurtomersByPeriod = "SELECT `tb1`.`source_id` , count( * ) AS total
FROM `fl_customers` AS `tb1`
LEFT JOIN `fl_customers_cv` AS `tb2` ON tb1.id = tb2.id
WHERE (tb1.data_creazione BETWEEN '$data_da' AND '$data_a')
AND tb2.status_profilo >0
GROUP BY `tb1`.`source_id`
ORDER BY `total` DESC
LIMIT 0 , 1000";


  	$path = check($_GET['path']);
	$query = $$path;
	$status_potential = array('New','Not Show','In Meeting','Not interested','Wrong','Hazardous','Archived','In contract');
	$preferedlanguage  = $this->get_items_key("languages");

	if($risultato = mysql_query($query,CONNECT)){
	
	while($riga = mysql_fetch_assoc($risultato)){
	
	if(isset($riga['status_potential'])) $riga['status_potential']  = $status_potential[$riga['status_potential']];
	if(isset($riga['preferedlanguage'])) $riga['preferedlanguage']  = $preferedlanguage[$riga['preferedlanguage']];
	if(isset($riga['source_potential'])) $value = $riga['source_potential'];
	if(isset($riga['source_id']) && check($riga['source_id']) == '' ) $value = 'UNKNOW 1';
	$this->contenuto[] = $riga;
	
	}

	} else { 
	$this->contenuto['class'] = 'red';
	$this->contenuto['esito'] = "Error 1102: Errore caricamento.".mysql_error();
	}
	
	$this->cnv_makedata();
}

function getCount(){
	
	$dataRows = array();

	$query = "SELECT ".$this->what." FROM ".$this->table."  WHERE ".$this->where;
	
	if($risultato = mysql_query($query,CONNECT)){
	


		return mysql_affected_rows();
	
	} else { 
		
		return mysql_affected_rows();
	
	}
	
}



function doTotali($totaleChekin,$totaPrenotazioni){
	

	$this->contenuto['class'] = 'green';
	$this->contenuto['esito'] = "OK";
	$this->contenuto['results'] = array('checkin'=>$totaleChekin,'prenotazioni'=>$totaPrenotazioni);
	
	
	$this->cnv_makedata();
}


function getRows(){
	
	$dataRows = array();

	$query = "SELECT ".$this->what." FROM ".$this->table."  WHERE ".$this->where;
	
	if($risultato = mysql_query($query,CONNECT)){
	
	while($riga = mysql_fetch_assoc($risultato)){

		$dataRows[] = $riga;
	}


	$this->contenuto['class'] = 'green';
	$this->contenuto['esito'] = "OK";
	$this->contenuto['results'] = $dataRows;
	
	} else { 
	$this->contenuto['class'] = 'red';
	$this->contenuto['esito'] = "Error 1102: Errore caricamento.".mysql_error();
	}
	
	$this->cnv_makedata();
}


function checkSubcription($customer,$lesson) {
    $lessonInfo = GRD('fl_course_lessons',$lesson);  //I take customer info
	$check = "SELECT * FROM `fl_subscriptions` WHERE `relation_id` = ".$lessonInfo['course']." AND `customer_rel` = $customer AND `data_inizio` <= CURDATE( ) AND `data_fine` >= CURDATE( ) AND attivo=1";
    $this->query($check);
	$esito = (mysql_affected_rows() > 0) ? 1 : 0;
	return $esito;

}

function getMeetings(){
	
	$dataMeetings = array();

	$query = "SELECT * FROM ".$this->table."  WHERE ".$this->where;
	
	if($risultato = mysql_query($query,CONNECT)){
	
	while($riga = mysql_fetch_assoc($risultato)){

	$issue = array('Booked','Arrived','In Contract','No Show','Not Interested','Pending','In meeting');



		$proprietario = GRD('fl_admin',$riga['proprietario']); // I take promoter data
		$potential_rel = GRD('fl_potentials',$riga['potential_rel']);  //I take customer info

		$riga['promoterName'] = $proprietario['nominativo'];
		$riga['customerName'] = $potential_rel['nome'].' '.$potential_rel['cognome'];
		$riga['source_potential'] = $potential_rel['source_potential'].' '.$potential_rel['referer'];
		$riga['NewCustomerId'] = ($potential_rel['is_customer'] > 1) ? $potential_rel['is_customer'] : 1;
		$riga['issue'] = $issue[$riga['issue']];
		$riga['meeting_date'] = $this->mydate($riga['meeting_date']);
		$riga['meeting_time'] = substr($riga['meeting_time'],0,5);

		$dataMeetings[] = $riga;
	}


	$this->contenuto['class'] = 'green';
	$this->contenuto['esito'] = "OK";
	$this->contenuto['results'] = $dataMeetings;
	
	} else { 
	$this->contenuto['class'] = 'red';
	$this->contenuto['esito'] = "Error 1102: Errore caricamento.".mysql_error();
	}
	
	$this->cnv_makedata();
}


function getPayments(){
	
	$dataPayments = array();

	$query = "SELECT * FROM ".$this->table."  WHERE ".$this->where;
	
	if($risultato = mysql_query($query,CONNECT)){
	
	while($riga = mysql_fetch_assoc($risultato)){

	$valuta = array('GBP','GBP','EUR');
	$metodo_di_pagamento = array('Not selected','Cash','BT Bank Transfert','Credit Card','Paypal','GoCardless','Credit Collection','Cheque');
	$status_pagamento = array('Waiting','Paid','Bill Asked','Executed','Registered','Canceled','Refunded');


		$proprietario = GRD('fl_admin',$riga['proprietario']); // I take promoter data
		$customer_rel = GRD('fl_customers',$riga['customer_rel']);  //I take customer info
		if($riga['tipo_pagamento'] == 1) $company_rel = GRD('fl_restaurants',$riga['customer_rel']);

		$riga['proprietario'] = $proprietario['nominativo'];
		$riga['customerName'] = ($riga['tipo_pagamento'] == 1) ? $company_rel['ragione_sociale'] : $customer_rel['nome'].' '.$customer_rel['cognome'];
		$riga['metodo_di_pagamento'] = $metodo_di_pagamento[$riga['metodo_di_pagamento']];
		$riga['valuta'] = $valuta[$riga['valuta']];
		$riga['status_pagamento'] = $status_pagamento[$riga['status_pagamento']];
		$riga['data_operazione'] = $this->mydate($riga['data_operazione']);

		$dataPayments[] = $riga;
	}


	$this->contenuto['class'] = 'green';
	$this->contenuto['esito'] = "OK";
	$this->contenuto['results'] = $dataPayments;
	
	} else { 
	$this->contenuto['class'] = 'red';
	$this->contenuto['esito'] = "Error 1102: Errore caricamento.".mysql_error();
	}
	
	$this->cnv_makedata();
}


function getExperiences(){
	
	$dataRows = array();

	$query = "SELECT * FROM ".$this->table."  WHERE profile_rel = ".$this->userId;
	
	if($risultato = mysql_query($query,CONNECT)){
	
	while($riga = mysql_fetch_assoc($risultato)){

		$dataRows[] = $riga;
	}


	$this->contenuto['class'] = 'green';
	$this->contenuto['esito'] = "OK";
	$this->contenuto['results'] = $dataRows;
	
	} else { 
	$this->contenuto['class'] = 'red';
	$this->contenuto['esito'] = "Error 1102: Errore caricamento.".mysql_error();
	}
	
	$this->cnv_makedata();
}


function getStudies(){
	
	$dataRows = array();

	$query = "SELECT * FROM ".$this->table."  WHERE profile_rel = ".$this->userId;
	
	if($risultato = mysql_query($query,CONNECT)){
	
	while($riga = mysql_fetch_assoc($risultato)){

		$dataRows[] = $riga;
	}


	$this->contenuto['class'] = 'green';
	$this->contenuto['esito'] = "OK";
	$this->contenuto['results'] = $dataRows;
	
	} else { 
	$this->contenuto['class'] = 'red';
	$this->contenuto['esito'] = "Error 1102: Errore caricamento.".mysql_error();
	}
	
	$this->cnv_makedata();
}

function get_items($item_rel,$condition=0) {
	$query = "SELECT * FROM `fl_items` WHERE id != 1 AND attiva > 0 AND item_rel = $item_rel ORDER BY label ASC";
	$dati = array();
	if($risultato = mysql_query($query,CONNECT)){
	
	while($riga = mysql_fetch_assoc($risultato)){
	$descrizione = (isset($riga['descrizione'])) ? $riga['descrizione'] : '';
	array_push($dati,array(
	
	'id'=>$riga['id'],
	'label'=>$riga['label'],
	'descrizione'=>$descrizione
	));
	
	}	
	$this->contenuto['class'] = 'green';
	$this->contenuto['esito'] = "OK";
	$this->contenuto['dati'] = $dati;
	
	} else { 
	$this->contenuto['class'] = 'red';
	$this->contenuto['esito'] = "Error 1102: Errore caricamento.".mysql_error();
	}
	
	$this->cnv_makedata();
}


/*Funzioni Globali e Utility */
function lead_info($lead_id) {
 	
	$this->app_start();
	$query = "SELECT * FROM `fl_leads` WHERE `id` = $lead_id LIMIT 1";
	$risultato = mysql_query($query,CONNECT);	
	$riga = @mysql_fetch_array($risultato); 
	
	if(mysql_affected_rows(CONNECT) < 1){			
	$this->contenuto =  array('id'=>$lead_id,'ragione_sociale'=>'Unknow','nome'=>'Unknow','cognome'=>'Unknow',"email"=>'Unknow',"telefono"=>'Unknow',"indirizzo"=>'Unknow',"cap"=>'Unknow',"localita"=>'Unknow',"citta"=>'Unknow');
	} else {
	$this->contenuto =  array('id'=>$riga['id'],'ragione_sociale'=>$riga['ragione_sociale'],'nome'=>$riga['nome'],'cognome'=>$riga['cognome'],"email"=>$riga['email'],"telefono"=>$riga['telefono'],"indirizzo"=>$riga['indirizzo'],"cap"=>$riga['cap'],"citta"=>$riga['citta']);
	}
	$this->cnv_makedata();

}

function get_page(){
		
		$query = "SELECT * FROM `fl_articles` WHERE `id`  = '".$this->page_id."' LIMIT 1";
		if($risultato = mysql_query($query,CONNECT)){
		$riga = mysql_fetch_array($risultato);
		
		$this->contenuto['esito'] = 1;
		$this->contenuto['info_txt'] = "Pagina";
		$this->contenuto['page_title'] = $riga['titolo'];
		$this->contenuto['page_content'] = $this->css.$this->convert($riga['articolo']);
		
		} else {
			
		$this->contenuto['esito'] = 0;
		$this->contenuto['info_txt'] = "Errore";
		
		}
		
		$this->cnv_makedata();
}

function do_login(){
		
		$this->app_start();

		/*$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
		if ($this->user != 'sistema' && !preg_match($regex,strtolower(trim($this->token)))){
		$this->contenuto['esito'] = 1;
		$this->contenuto['info_txt'] = "Per usare le api devi essere registrato";
		$this->cnv_makedata();
		}*/

		
		if(($this->user == "" || $this->password == "") && $this->uid == 0) {	
		$this->contenuto['esito'] = 0;
		$this->contenuto['info_txt'] = "Inserisci user e password!";
		$this->cnv_makedata();
		}
		
	
		
		$this->password = md5($this->password); 
		
		$query = "SELECT * FROM `fl_admin` WHERE `password`  = '".$this->password."' AND `user`  = '".trim(strtolower($this->user))."' LIMIT 1";
		if($this->uid != 0) $query = "SELECT * FROM `fl_admin` WHERE  `uid`  = '".$this->uid."' LIMIT 1";
		$risultato = mysql_query($query,CONNECT);
		
		$this->contenuto['esito'] = 0;
		$this->contenuto['info_txt'] = mysql_affected_rows();
	
	
		if(mysql_affected_rows(CONNECT) < 1){		
		$this->contenuto['esito'] = 0;
		$this->contenuto['info_txt'] = "Email o password errate o utente Fb non riconosciuto";
		$this->cnv_makedata();
		} 		
		
		$riga = mysql_fetch_array($risultato);

		if($riga['attivo'] == 0){		
		$this->contenuto['esito'] = 0;
		$this->contenuto['info_txt'] = "Utente non attivo.";
		$this->cnv_makedata();
		}
		
		$fcmToken =  ($this->fcmToken > 0) ? ", fcmToken = '".$this->fcmToken."'" : '';		
		$query = "UPDATE `fl_admin` SET `visite` = visite+1 $fcmToken WHERE `id` = '".$riga['id']."' LIMIT 1;";
		//mail('michelefazio@aryma.it',$this->user,$query);


		mysql_query($query,CONNECT);
		
		$_SESSION['user'] = $riga['user'];
		$_SESSION['operatore'] = $riga['user'];
		$_SESSION['userid'] = $riga['id'];
		$_SESSION['nome'] = $riga['nominativo'];
		$_SESSION['mail'] = $riga['email'];		
		$_SESSION['number'] = $riga['id'];			
		$_SESSION['usertype'] = $riga['tipo'];
		$_SESSION['time'] = time();	
		$_SESSION['idh'] = $_SERVER['REMOTE_ADDR'];
		$_SESSION['aggiornamento_password'] = $riga['aggiornamento_password'];
		$_SESSION['marchio'] = $riga['marchio'];
		// Fine Avvio Sessione			
		$agent = @$_SERVER['HTTP_USER_AGENT'];
		$referer = @$_SERVER['HTTP_REFERER'];
		$lang = @$_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $data = time();

		$this->contenuto['esito'] = $riga['attivo'];		
		$this->contenuto['info_txt'] = "Login OK";
		$this->contenuto['usertype'] = $_SESSION['usertype'];
		$this->contenuto['user'] = $_SESSION['user'];
		$this->contenuto['operatore'] = $_SESSION['user'];
		$this->contenuto['email'] = $_SESSION['mail'];
		$this->contenuto['usr_id'] = $_SESSION['number'];	
		$this->contenuto['token'] = session_id();
		$this->contenuto['nome'] = $_SESSION['nome'];	
		$this->contenuto['aggiornamento_password'] = $riga['aggiornamento_password'];	
		$this->contenuto['time'] = time();	
		$this->contenuto['idh'] = $_SERVER['REMOTE_ADDR'];
		$this->contenuto['marchio'] = $_SESSION['marchio'] ;
	
		$this->cnv_makedata();
} // Login



private function data_labels($item_rel,$condition=0) {
	$query = "SELECT * FROM `fl_items` WHERE id != 1 AND attiva > 0 AND item_rel = $item_rel ORDER BY label ASC";
	$risultato = mysql_query($query,CONNECT);
	$rel_info = array();
	
	while ($riga = @mysql_fetch_array($risultato)) {
	$rel_info[$riga['id']] = $riga['label'];
    }
	
	if($condition == 1){	
	$this->contenuto = 	array('dati'=>$rel_info,'esito'=>1,'info_txt'=>"dati caricati");	
	echo json_encode($this->contenuto);
	mysql_close(CONNECT);
	exit;	
	} else {
	return $rel_info;
	}
}
function html_to_text($stringa,$quot=0){
	$stringa = str_replace("&gt;", ">",str_replace("&lt;", "<",str_replace("'", "&rsquo;",$stringa)));
	//sostituisc i <br/>
	$stringa=preg_replace("/<br\W*?\/>/", "\r\n",$stringa);
	//elimino tutti i tag
	$stringa = strip_tags($stringa);
	return $stringa."\r\n\r\n\r\n\r\n\r\n\r\n\r\n";
}
function mydate($mysqldate){
	if($mysqldate != '0000-00-00') {
	$phpdate = strtotime( $mysqldate );
	return date( 'd/m/Y', $phpdate );
	} else { return '--'; }
}
function mydatetime($mysqldate){
	$phpdate = strtotime( $mysqldate );
	return date('H:i d/m/Y', $phpdate );
}
function convert($var,$quot=0){
$var =  str_replace("../../../",ROOT,str_replace("&gt;", ">",str_replace("&lt;", "<",str_replace("'", "&rsquo;",$var))));
if($quot==0) { $var =  str_replace("&quot;", '"',$var); }
str_replace('"', "&quot;",$var);
return $var;
}
	
function check($var){
$var =  trim(str_replace("<", "&lt;",str_replace(">", "&gt;",@addslashes(@stripslashes(@str_replace('"',"&quot;",str_replace("'", "&rsquo;", $var) ))))));
return $var;
} 


	
function convert_data($data,$mode=0){

if($mode == 0) {
$tempo = explode("/",$data);
$extra = "";
$data = @mktime(0,0,0,$tempo[1],$tempo[0],$tempo[2]);
} else if($mode == 1){ 
$tempo = explode("/",$data);
$extra = "";
$data = trim($tempo[2])."-".trim($tempo[1])."-".trim($tempo[0]);
 }
return $data;

}


function sms($to,$text,$from=0,$smsId='') {
if($to != ''){
	
require_once('../fl_set/librerie/twilio-php-master/Services/Twilio.php');
$client = new Services_Twilio(account_sid, auth_token);
$from = ($from==0) ? from : $from;

try{	

$client->account->messages->create(array( 
	'To' =>  $to, 
	'From' => $from,    
	'Body' =>  $text
)); 
return 1; 

} catch (Exception $e) {	
  return  $from.$e->getMessage(); 
}


} else {  return 'Destinatario non speficicato.'; }

}

public function get_items_key($chiave=""){
	
	$filtrocerca = " AND (";
	$chiave = explode(",",$chiave);
	$items_rel = array();

	foreach($chiave as $key => $valore){
	if(strstr($valore,"valore")) $valore = "valore";
	$filtrocerca .= " chiave LIKE '%[*$valore*]%' ";
	} $filtrocerca .= " OR chiave = '[*]') ";
	
	$tcat = "SELECT * FROM `fl_items` WHERE id != 1 AND attiva > 0 $filtrocerca ORDER BY label ASC;";
	
	$cat_res = mysql_query($tcat, CONNECT);
		
	while (@$riga_res = mysql_fetch_array($cat_res)) 
	{
	
	$items_rel = $this->data_get_items($riga_res['id']);	

	}		
	if(count($items_rel) < 1) $items_rel[0] = '--';
	return $items_rel;
			
}

public function data_get_items($item_rel=0){

  
	$items_rel = array();
	$items_rel[1] = "Non Selezionato";
	$filtro = "AND item_rel = $item_rel ";

	
	$tcat = "SELECT * FROM `fl_items` WHERE id != 1 AND attiva > 0 $filtro ORDER BY id ASC;";
	
	$cat_res = mysql_query($tcat, CONNECT);
		
	while (@$riga_res = mysql_fetch_array($cat_res)) 
	{
		
	$descrizione = (@$riga_res['descrizione'] == '')	? '' : ' - '.@$riga_res['descrizione'];
	$items_rel[$riga_res['id']] = $riga_res['label'].$descrizione;
	}		
	return $items_rel;
}

function smail($destinatario,$soggetto,$messaggio,$from='',$nameFrom='',$allegato='',$allname=''){

if(!defined('SMTPSecure')) define('SMTPSecure','');
if(!defined('Port')) define('Port','25');

require_once('../fl_set/librerie/PHPMailer/PHPMailerAutoload.php');
$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->SMTPDebug = 0;
$mail->Debugoutput = 'html';
$mail->Host = mail_host;
$mail->SMTPSecure = SMTPSecure; 
$mail->Port = Port; 
$mail->Username = mail_user;
$mail->Password = mail_password;
$mail->setFrom(mail_user, mail_name);
//if($from != '') { $mail->setFrom($from, $nameFrom);  } else { $mail->setFrom(mail_user, mail_name); }
($from != '') ? $mail->addReplyTo($from, $nameFrom) : $mail->addReplyTo(mail_user, mail_name);

$mail->addAddress($destinatario,$destinatario);
$mail->Subject = $soggetto;
$mail->Body = $messaggio; 
$mail->AltBody = 'To view this email please enable HTML';
if($allegato != '') $mail->addAttachment($allegato, $allname);


if(!$mail->send()) {
mail(mail_admin,'..:: Errore funzione smail '.mail_host.' port '.Port,$mail->ErrorInfo);
return $mail->ErrorInfo; 
} else {
return true;
}

$mail->clearAddresses();
$mail->clearAttachments();
	
}


}