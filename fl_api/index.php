<?php 

header("Access-Control-Allow-Origin: *");
/*
ini_set('display_errors',0);
error_reporting(E_ALL);
//define('NOSSL',1);
*/

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../fl_core/core.php'); // Variabili Modulo
 
include "webservice.php";
$webservice = new webservice;

$dataset = $_REQUEST; 
$message = $_SERVER['REQUEST_URI']."\r\n\r\n<br>";


foreach($dataset as $chiave=>$valore){ $message .= $chiave." = ".$valore."\r\n<br>"; }
//mail('michelefazio@aryma.it','APP',$message,intestazioni);

function mandatory_fileds ($array){
$dataset = $_REQUEST;
foreach($array as $chiave=>$valore){
if(!isset($dataset[$valore])) { echo json_encode(array('esito'=>0,'info_txt'=>"Left mandatory field $valore"));  exit; } 
}
}


if(isset($dataset['usr_sign_up'])){
sleep(3);
$webservice->token = check($dataset['token']);
$webservice->signup();

}

$template = '<body><div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee"><div class="adM">
    </div><table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#eeeeee">
    <tbody>
        <tr>
            <td>
                <table align="center" width="750px" border="0" cellspacing="0" cellpadding="0" bgcolor="#eeeeee" style="width:750px!important">
                <tbody>
                    <tr>
                        <td>
                            <table style="margin-top: 50px" width="570" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#eeeeee">
                            <tbody>
                                <tr  bgcolor="#219bd9">
                                    <td colspan="3" height="80" align="center" border="0" cellspacing="0" cellpadding="0" bgcolorbgcolor="#219bd9"" style="padding:0;margin:0;font-size:0;line-height:0">
                                        <table width="570" align="center" border="0" cellspacing="0" cellpadding="0">
                                        <tbody>
                                            <tr>
                                                <td width="30"></td>
                                                <td align="center" valign="middle" style="padding:0;margin:0;font-size:0;line-height:0"><a href="http://www.escapecampusuk.com/" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=en-GB&amp;q=http://www.escapecampusuk.com/&amp;source=gmail&amp;ust=1508494906152000&amp;usg=AFQjCNHWjKkPgO3beWNJDa0RN5c1JtxRyA"><img src="http://www.escapecampusuk.com/images/Ecampus_logo_header.png" ></a></td>
                                                <td width="30"></td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr bgcolor="#219bd9">
                                    <td colspan="3" align="center">
                                   
                                </td>
                            </tr>
                            
                            <tr bgcolor="#ffffff">
                                <td width="30" bgcolor="#eeeeee"></td>
                                <td>
                                    <table width="570" align="center" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                        <tr>
                                            <td colspan="4" align="center"><!-- img template_email --></td>
                                        </tr>
                                           <tr>
                                            <td colspan="4" align="center"><h3 style="font-size:24px"></h3></td>
                                        </tr>
                                           <tr>
                                            <td colspan="4" align="center"><h3 style="font-size:24px"></h3></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" align="center"><h3>{{body}}</h3>
                                           </td>

                                           
                                        </tr>
                                          <tr>
                                            <td colspan="5" height="30" style="padding:0;margin:0;font-size:0;line-height:0"></td>
                                        </tr>
                                              <tr>
                                            <td colspan="4" align="center"><h4 style="font-size:14px; font-weight: normal;">
                                            Click to navigate to us: https://goo.gl/xthkMT<br><br>
                                            Please come to reception at 4th floor, <strong style="color: #00a3df !important;"> 37-39 Oxford Street.</strong></strong><br> 
                                            
                                             <br> <br> Please call reception on <br> 07511 989062 or 07598 472368 <br>
                                             if you are unable to come or would like to change the day.<br></h4>

                                           </td>

                                            "
                                        </tr>
                                       
                                        <tr>
                                            <td colspan="5" height="40" style="padding:0;margin:0;font-size:0;line-height:0"></td>
                                        </tr>
                                        <tr>
                                            
                                        </tr>
                                        
                                       
                                        <tr>
                                            <td colspan="4">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                    </table>
                                    <table width="570" align="center" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h2 style="color:#404040;font-size:22px;font-weight:bold;line-height:26px;padding:0;margin:0">&nbsp;</h2>
                                                <div style="color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0;text-align: center; font-family: arial;">Would you like to join us on our amazing trips? Dont miss the opportunity !</div>
                                            </td>
                                        </tr>
                                                            <tr><td colspan="2" height="40"></td></tr>
                                        <tr>

                                            <td >
                                            
                                                    <tr style="margin-bottom: 50px;">
                                                            <td align="center" style="margin:0;"><a href="http://www.escapecampusuk.com/videotrips.php" style="font-size:18px;font-family:HelveticaNeue-Light,Arial,sans-serif;line-height:22px;text-decoration:none;color:#ffffff;font-weight:bold;border-radius:2px;background-color:#00a3df;display:block; margin-top: 20px; width: 30%;    height: 50px;padding-top: 5%;padding-left: 10%;padding-right: 10%;" target="_blank">TRIPS VIDEOS</a></td>
                                                        </tr>
                                                         <tr><td colspan="2" height="5"></td></tr>
                                                     
                                                         <tr><td colspan="2" height="10"></td></tr>
                                                  
                                                      <tr><td colspan="2" height="20"></td></tr>
                                                        
                                              
                                            </td>
                                      </tr>
                                        <tr>
                                            <td colspan="5" height="30" style="padding:0;margin:0;font-size:0;line-height:0"></td>
                                        </tr>
                                            <tr>
                                                  <td align="center" style="margin-top: 50px;" valign="top">
                                       <span style="line-height:20px;font-size:10px;"><a href="https://www.facebook.com/escapenetworkuk" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=en-GB&amp;q=https://www.facebook.com/escapenetworkuk&amp;source=gmail&amp;ust=1508494906152000&amp;usg=AFQjCNEUYo4n2_fo5FQpYyXcJA7p5rSLFg"><img src="http://www.escapecampusuk.com/images/Facebook.png" alt="fb" class="CToWUd"></a>&nbsp;</span>
     <span style="line-height:20px;font-size:10px;"><a href="https://instagram.com/escapenetworkuk" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=en-GB&amp;q=https://twitter.com/escapenetworkuk&amp;source=gmail&amp;ust=1508494906152000&amp;usg=AFQjCNH2VtEhwvL0lFPZ_J-cwCAto6_Prg"><img src="http://www.escapecampusuk.com/images/Insta.png"  alt="twit" class="CToWUd"></a>&nbsp;</span>
       <span style="line-height:20px;font-size:10px"><a href="https://twitter.com/escapenetworkuk" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=en-GB&amp;q=https://plus.google.com/%escapenetworkuk&amp;source=gmail&amp;ust=1508494906152000&amp;usg=AFQjCNFA2_zq55JIecsi04RCi7J6FMWg5g"><img src="http://www.escapecampusuk.com/images/Twitter.png"  alt="Twitter" class="CToWUd"></a>&nbsp;</span>
   <span style="line-height:20px;font-size:10px"><a href="https://www.linkedin.com/company/4984210/" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=en-GB&amp;q=https://plus.google.com/%escapenetworkuk&amp;source=gmail&amp;ust=1508494906152000&amp;usg=AFQjCNFA2_zq55JIecsi04RCi7J6FMWg5g"><img src="http://www.escapecampusuk.com/images/Linkedin.png"  alt="Linkedin" class="CToWUd"></a>&nbsp;</span>
     <span style="line-height:20px;font-size:10px"><a href="https://www.youtube.com/channel/UCVDpEoSY_hjuFk2kK1NGuTw" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=en-GB&amp;q=https://plus.google.com/%escapenetworkuk&amp;source=gmail&amp;ust=1508494906152000&amp;usg=AFQjCNFA2_zq55JIecsi04RCi7J6FMWg5g"><img src="http://www.escapecampusuk.com/images/youtube.png"  alt="youtube" class="CToWUd"></a>&nbsp;</span>
                      </td>
                                                    </tr>

                                                      <tr>
                                            <td colspan="5" height="50" style="padding:0;margin:0;font-size:0;line-height:0"></td>
                                        </tr>

                                      <tr><td>&nbsp;</td>
                                      </tr></tbody></table></td>
                                <td width="30" bgcolor="#eeeeee"></td>
                            </tr>
                            </tbody>
                            </table>
                            <table align="center" width="570px" border="0" cellspacing="0" cellpadding="0" bgcolor="#303030" style="width:630px !important">
                            <tbody>
                                <tr>
                                    <td>
                                        <table width="570" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#303030">
                                        <tbody>
                                            <tr><td colspan="2" height="30"></td></tr>
                                            <tr>
                                                <td align="center" width="360" valign="top">
                                                    <div style="color:#ffffff;font-size:12px;line-height:12px;padding:0;margin:0;margin-left: 10px;">© 2017 Escape Network. All rights reserved.</div>
                                                    <div style="line-height:5px;padding:0;margin:0">&nbsp;</div>
                                                    <div style="color:#ffffff;font-size:12px;line-height:12px;padding:0;margin:0;margin-left: 10px;"></div>
                                                </td>
                                          
                                            </tr>
                                            <tr><td colspan="2" height="5"></td></tr>

                                             <tr><td colspan="2" height="5"></td></tr>
                                           <tr><td colspan="2" height="5"></td></tr>
                                        </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
                </table>
            </td>
        </tr>
    </tbody>
    </table></div>
</body>';
define('template_email',$template);


if(isset($dataset['app_login'])){
mandatory_fileds(array('time','request_id'));

session_cache_limiter( 'private_no_expire' );
session_cache_expire(time()+5259200); 
session_start();		

$time = check($dataset['time']);
$request_id = check($dataset['request_id']);

$correct = sha1($time.$webservice->secret);
if($request_id != $correct && !isset($_GET['demo']) && $webservice->demo == true) {
echo json_encode(array('esito'=>0,'info_txt'=>"Request Id Wrong"));
exit;
}


$deviceuid = check($dataset['request_id']);
$_SESSION['deviceuid'] = $deviceuid;
echo json_encode(array('token'=>session_id(),'esito'=>1,'info_txt'=>'OK'));
exit;

}





if(isset($dataset['usr_login']) || isset($dataset['usrLogin'])){
mandatory_fileds(array('token','user','password','uid'));
$webservice->user = check($dataset['user']);
$webservice->password = check($dataset['password']);
$webservice->uid = check($dataset['uid']);
$webservice->token = check($dataset['token']);

mail('michelefazio@aryma.it','TOKEN: '.$dataset['fcmToken']);
$webservice->fcmToken = (isset($dataset['fcmToken'])) ? check($dataset['fcmToken']) : 0;
$webservice->do_login();
foreach($webservice->contenuto as $chiave => $valore) { $_SESSION[$chiave] = $valore; } ;
exit;
}



if(isset($dataset['usrLogout'])){

mandatory_fileds(array('token','userId'));
if(isset($dataset['token'])) $webservice->token =  $webservice->check($dataset['token']);
$webservice->userId = check($dataset['userId']);
$webservice->fcmToken = (isset($dataset['fcmToken'])) ? $webservice->check($dataset['fcmToken']) : 0;
$webservice->session_id = (isset($dataset['session_id'])) ?  $webservice->check($dataset['session_id']) : session_id();

$webservice->do_logout();


}



if(isset($dataset['lead_info'])){
mandatory_fileds(array('token'));
$webservice->token = check($dataset['token']);
$webservice->lead_info(check($dataset['user_id']));
}

if(isset($dataset['get_items'])){
mandatory_fileds(array('token','item_rel'));
$webservice->token = check($dataset['token']);
$webservice->get_items(check($dataset['item_rel']));
}



if(isset($dataset['getStaticItems'])){
mandatory_fileds(array('token','staticDataset'));
include('../fl_core/dataset/array_statiche.php'); 
$staticDataset = check($dataset['staticDataset']);

echo json_encode(array('esito'=>1,'results'=>$$staticDataset));
exit;
}


if(isset($dataset['getMeetings'])){
mandatory_fileds(array('token'));
$webservice->token = check($dataset['token']);
$webservice->table = 'fl_meeting_agenda';

$webservice->where = 'id > 1 AND meeting_date = CURDATE()  ';
$webservice->where .= (isset($dataset['proprietario'])) ? ' AND proprietario = '.check($dataset['proprietario']) : '  ' ;
$webservice->where .= (isset($dataset['marchio'])) ? ' AND marchio = '.check($dataset['marchio']) : ' AND  marchio < 2 ' ;
$webservice->where .= 'ORDER BY meeting_date ASC, meeting_time ASC;';

$webservice->getMeetings();
}




if(isset($dataset['getPayments'])){
mandatory_fileds(array('token'));
$webservice->token = check($dataset['token']);
$webservice->table = 'fl_pagamenti';

$webservice->where = 'id > 1 AND data_operazione >= \'2017-01-01\' ';
$webservice->where .= (isset($dataset['status_pagamento'])) ? ' AND status_pagamento = '.check($dataset['status_pagamento']) : ' AND status_pagamento = 1 ' ;
$webservice->where .= (isset($dataset['marchio'])) ? ' AND marchio = '.check($dataset['marchio']) : ' AND  marchio < 2 ' ;
$webservice->where .= 'ORDER BY scadenza_pagamento DESC, metodo_di_pagamento ASC, customer_rel ASC;';

$webservice->getPayments();
}


if(isset($dataset['registerPayments'])){
mandatory_fileds(array('token'));
$webservice->token = check($dataset['token']);
$webservice->table = 'fl_pagamenti';
$operatore = (isset($dataset['operatore'])) ? check($dataset['operatore']) : 1;
$esito = $x = 1;
foreach($dataset as $key => $val){
$x .=  $key.'-'.$val;
}

foreach($dataset['payments'] as $key => $val){
$updatePayment = 'UPDATE '.$webservice->table .' SET status_pagamento = 4 , data_aggiornamento = NOW() , operatore = '.$operatore.' WHERE id = '.$val.' LIMIT 1';
$issue = $webservice->query($updatePayment);
$paymentDetails = GRD($webservice->table,$val);  

if($paymentDetails['tipo_pagamento'] == 0)  {
	$customer_rel = $paymentDetails['customer_rel'];
 	$attiva = "UPDATE fl_customers_cv SET status_profilo = 2 WHERE id = $customer_rel AND status_profilo = 0; ";
	$webservice->query($attiva);
}

if(mysql_error() && $esito == 1) $esito = mysql_error() ;

}

echo json_encode(array('esito'=>$esito ,'info_txt'=>$x));
exit;
}


if(isset($dataset['savePayment'])){
mandatory_fileds(array('token'));
$webservice->token = check($dataset['token']);
$webservice->table = 'fl_pagamenti';
$recordId = (isset($_REQUEST['id'])) ? $webservice->check($_REQUEST['id']) : 1;
$esito = $webservice->insertUpdate($recordId);
echo json_encode(array('esito'=>$esito ,'info_txt'=>$esito ));
exit;
}

if(isset($dataset['checkinLesson'])){
mandatory_fileds(array('token','customer_rel','course_rel','date_join'));
$webservice->token = check($dataset['token']);
$recordId = (isset($_REQUEST['id'])) ? $webservice->check($_REQUEST['id']) : 1;
$esito = $webservice->checkSubcription($dataset['customer_rel'],$dataset['course_rel']);
$_REQUEST['lesson_id'] = $_REQUEST['course_rel'];


if($esito > 0){
$webservice->table = 'fl_course_checkin';
$esito = $webservice->insertUpdate($recordId);
$info = "Checkin Done";
$webservice->query('UPDATE fl_course_checkin SET date_join = NOW() WHERE id = '.$esito);
} else { 
$esito = 0;
$info = "Subscription not active";
$webservice->smail('michelefazio@aryma.it',$info,'Check Subscription: <a href="https://app.escapenetwork.com/condivision/fl_modules/mod_anagrafica/mod_contracts.php?id='.$dataset['customer_rel'].'">https://app.escapenetwork.com/condivision/fl_modules/mod_anagrafica/mod_contracts.php?id='.$dataset['customer_rel'].'</a>');
}

echo json_encode(array('esito'=>$esito ,'info_txt'=>$info ));
exit;
}



if(isset($dataset['getLessons'])){
mandatory_fileds(array('token'));
$webservice->token = check($dataset['token']);
$webservice->table = 'fl_course_lessons AS lesson LEFT JOIN fl_course_classes AS class ON lesson.classroom = class.id ';
$day = (isset($dataset['day'])) ? check($dataset['day']) : date('N') ;

$timestamp1 = strtotime(date('H:i:00')) - 60*60;
$inizio =  date('H:i:00',$timestamp1);
$timestamp2 = strtotime($inizio) + 60*120;
$fine = date('H:i:00', $timestamp2);

$webservice->where = 'attivo = 1 AND week_day = '.$day.' ORDER BY `from` ASC ';
$webservice->what = 'lesson.*, class.class_seats  AS max_subcriptions, description AS course_title' ;
$webservice->getRows();
}




if(isset($dataset['getStudentsBooking'])){
mandatory_fileds(array('token','lesson_id'));
$webservice->token = check($dataset['token']);
$webservice->table = 'fl_course_booking 
LEFT JOIN fl_customers ON fl_course_booking.customer_rel = fl_customers.id
LEFT JOIN `fl_course_checkin` ON (fl_course_booking.customer_rel = `fl_course_checkin`.customer_rel 
AND  DATE(fl_course_booking.date_join) = DATE(`fl_course_checkin`.date_join) AND fl_course_booking.lesson_id = fl_course_checkin.lesson_id) 
';
$day = (isset($dataset['day'])) ? check($dataset['day']) : date('Y-m-d') ;
$lesson_id = check($dataset['lesson_id']);
$webservice->what = ' DATE_FORMAT( fl_course_booking.data_creazione, \'%e/%c/%Y (%H:%i)\' ) AS data_prenotazione, fl_course_booking.customer_rel AS id_studente, fl_customers.nome, fl_customers.cognome, fl_course_booking.lesson_id, fl_course_checkin.id AS checked';

$webservice->where = 'fl_course_booking.lesson_id = '.$lesson_id .' AND DATE(fl_course_booking.date_join) = \''.$day.'\' ORDER BY `nome` ASC ';


$webservice->getRows();
}



if(isset($dataset['getStudentsCheckin'])){
mandatory_fileds(array('token','lesson_id'));
$webservice->token = check($dataset['token']);
$webservice->table = 'fl_course_checkin LEFT JOIN fl_customers ON fl_course_checkin.customer_rel = fl_customers.id ';
$day = (isset($dataset['day'])) ? check($dataset['day']) : date('Y-m-d') ;
$lesson_id = check($dataset['lesson_id']);

$webservice->where = 'lesson_id = '.$lesson_id .' AND DATE(date_join) = \''.$day.'\' ORDER BY `nome` ASC ';
$webservice->what = 'fl_course_checkin.data_creazione AS data_checkin, fl_customers.nome,fl_customers.cognome,fl_course_checkin.course';
$webservice->getRows();
}


if(isset($dataset['getTotali'])){
mandatory_fileds(array('token','lesson_id'));
$webservice->token = check($dataset['token']);

$day = (isset($dataset['day'])) ? check($dataset['day']) : date('Y-m-d');
$lesson_id = check($dataset['lesson_id']);

$webservice->table = 'fl_course_checkin';
$webservice->where = 'lesson_id = '.$lesson_id .' AND DATE(date_join) = \''.$day.'\' ';
$webservice->what = 'id';
$totaleChekin = $webservice->getCount();

$webservice->table = 'fl_course_booking';
$totaPrenotazioni = $webservice->getCount();


$webservice->doTotali($totaleChekin,$totaPrenotazioni);



}






if(isset($dataset['getAccounts'])){
mandatory_fileds(array('token'));
$webservice->token = check($dataset['token']);
$webservice->table = 'fl_admin';
$webservice->where = 'attivo = 1 ';
$webservice->what = 'id,nominativo ';
$webservice->getRows();
}

if(isset($dataset['getUserData'])){
mandatory_fileds(array('token','id'));
$webservice->token = check($dataset['token']);

$webservice->recordId = check($dataset['id']);
$webservice->table = 'fl_customers';
$webservice->what = 'nome,cognome,email,telefono,indirizzo,cap';

$esito = $webservice->getRecordData();
echo json_encode(array('esito'=>1,'results'=>$esito ));
exit;
}


if(isset($dataset['getLeads2'])){
mandatory_fileds(array('token'));
$webservice->token = check($dataset['token']);
$webservice->table = 'fl_leads';
$webservice->where = 'status_pagamento = 4 ';
$webservice->getRows();
}


if(isset($dataset['get_data_values'])){
mandatory_fileds(array('token','path'));
$webservice->token = check($dataset['token']);
$webservice->path = check($dataset['path']);
$webservice->get_data_values();
}

/*
if(isset($dataset['get_data_values_second'])){
mandatory_fileds(array('token','path','start_Date','end_Date'));
$webservice->token = check($dataset['token']);
$webservice->path = check($dataset['path']);
$webservice->start_Date = check($dataset['start_Date']);
$webservice->start_Date = check($dataset['end_Date']);
$webservice->get_data_values();
}*/

if(isset($dataset['get_data_rows'])){
mandatory_fileds(array('token','path'));
$webservice->token = check($dataset['token']);
$webservice->path = check($dataset['path']);
$webservice->get_data_rows();
}




if(isset($dataset['insertCustomerData'])){
mandatory_fileds(array('token'));
$webservice->token = check($dataset['token']);
$webservice->table = 'fl_customers';
$recordId = (isset($_REQUEST['id'])) ? $webservice->check($_REQUEST['id']) : 1;
$esito = $webservice->insertUpdate($recordId);
if($esito > 0){
$accountRel = (isset($_REQUEST['account_rel'])) ? $webservice->check($_REQUEST['account_rel']) : 0;
$webservice->query('UPDATE fl_potentials SET is_customer = '.$esito.' WHERE id = '.$accountRel );
}
echo json_encode(array('esito'=>$esito ,'info_txt'=>$esito));
exit;
}



if(isset($dataset['getRecordData'])){
mandatory_fileds(array('token'));
$webservice->token = check($dataset['token']);
$webservice->table = $tables[check($_GET['gtx'])];
$webservice->recordId = (isset($_REQUEST['id'])) ? $webservice->check($dataset['id']) : 1;

$recordData = $webservice->getRecordData();

if(isset($recordData['cover_letter'])) $recordData['cover_letter'] = strip_tags(converti_txt($recordData['cover_letter']));
if(isset($recordData['note'])) $recordData['note'] = strip_tags(converti_txt($recordData['note']));
unset($recordData['password']); //To don't send any password fields
echo json_encode(array('recordData'=>$recordData));
exit;
}


if(isset($dataset['updateCustomerCV'])){
mandatory_fileds(array('token'));
$webservice->token = check($dataset['token']);
$webservice->table = 'fl_customers_cv';
$recordId = (isset($_REQUEST['id'])) ? $webservice->check($_REQUEST['id']) : 1;
if($recordId > 1){
$esito = $webservice->insertUpdate($recordId);
} else {
echo json_encode(array('esito'=>0,'info_txt'=>"There is a problem with user matching on CV ".$recordId  ));
exit;
}
echo json_encode(array('esito'=>$esito ,'info_txt'=>$esito ));
exit;
}


if(isset($dataset['insertBookMeeting'])){
mandatory_fileds(array('token'));
$webservice->token = $webservice->check($dataset['token']);
$recordId = (isset($_REQUEST['id'])) ? $webservice->check($_REQUEST['id']) : 1;

if($recordId <= 1){
$webservice->table = 'fl_potentials';
$esito = $webservice->insertUpdate($recordId);
} else { $esito = $recordId; }

if($esito > 0){
$webservice->table = 'fl_meeting_agenda';
$meeting = $webservice->insertUpdate(1);
$webservice->query('UPDATE fl_meeting_agenda SET potential_rel = '.$esito.' WHERE id = '.$meeting);
mail('potentials@escapenetwork.com','App Lead inserted id: '.$esito,'Inserted into database on '.date('d/m/Y H:i'));

}

echo json_encode(array('esito'=>$esito ,'info_txt'=>$meeting));
exit;
}


if(isset($dataset['insertLead'])){
	
mandatory_fileds(array('token','telefono','source_potential','email','nome','referer','marchio','referer','privacy-policy'));
$webservice->token = $webservice->check($dataset['token']);
$recordId = 1;
$messaggio = '';

foreach($_POST as $chiave => $valore){
$messaggio .= "".check($chiave)."=".check($valore)."&";
}

$message = 'Problems while sending form';
$webservice->table = 'fl_potentials';

$email = $webservice->check($dataset['email']);
$telefono = $webservice->check($dataset['telefono']);
$nome = $webservice->check($dataset['nome']);
$source_potential = $webservice->check($dataset['source_potential']);

if (!is_numeric($telefono) || strlen($telefono) < 5 ) {
$message = "Please insert a valid phone";
echo json_encode(array('esito'=>0 ,'info_txt'=>$message));
exit;
}

$checkLead = "SELECT id,email,telefono FROM ".$webservice->table." WHERE (`email` LIKE '%$email%' OR `telefono` LIKE '%$telefono%') AND data_creazione > DATE_SUB(NOW() , INTERVAL 1 MONTH);";
$duplicate = $webservice->query($checkLead);
$duplicate = mysql_fetch_assoc($duplicate);


if(!isset($duplicate['id'])){

	$esito = $webservice->insertUpdate($recordId);
	
	if($esito > 1) {


	$message = "Thanks for applying";
	$webservice->query('UPDATE '.$webservice->table.' SET data_aggiornamento = NOW() WHERE id = '.$esito);





	mail('potentials@escapenetwork.com','New Lead '.$nome.' from '.$source_potential.' id: '.$esito,"Raw lead data: ".$messaggio.'Inserted into database on '.date('d/m/Y H:i'));
	mail('administration@escapenetwork.com','New Lead '.$nome.' from '.$source_potential.' id: '.$esito,"Raw lead data: ".$messaggio.'Inserted into database on '.date('d/m/Y H:i'));
	//mail('support@aryma.it','New Lead '.$nome.' from '.$source_potential.' id: '.$esito,'Inserted into database on '.date('d/m/Y H:i'));
	} 

} else {

	$esito = $duplicate['id'];
	$webservice->query('UPDATE '.$webservice->table.' SET status_potential = 0 , nome = \''.$dataset['nome'].'\', telefono = \''.$dataset['telefono'].'\', source_potential = \''.$dataset['source_potential'].'\', referer = CONCAT(\''.$dataset['referer'].' AND  \',referer) ,data_creazione = NOW(), note =  CONCAT(\'Applied again \',note) WHERE id = '.$esito);
	$message = "Thanks for applying $email.";
	mail('potentials@escapenetwork.com',$nome.' has applied 2 times from '.$source_potential,' Not Inserted into database on '.date('d/m/Y H:i').'<br> Old customer data: '.$duplicate['id'].' '.$duplicate['email'].' '.$duplicate['telefono'].' New data received '.$messaggio);
	//mail('support@aryma.it',$nome.' has applied 2 times from '.$source_potential,' Not Inserted into database on '.date('d/m/Y H:i').'<br> Old customer data: '.$duplicate['id'].' '.$duplicate['email'].' '.$duplicate['telefono'].' New data received '.$messaggio);

}


echo json_encode(array('esito'=>$esito ,'info_txt'=>$message));

exit;
}






if(isset($dataset['insertLesson'])){
	
mandatory_fileds(array('token','potential_rel','lesson_date','lesson_time'));
$webservice->token = $webservice->check($dataset['token']);
$recordId = 1;
$lesson_date = $webservice->check($dataset['lesson_date']);
$lesson_time = $webservice->check($dataset['lesson_time']);

$potential = GRD('fl_potentials',$dataset['potential_rel']);
$to = $potential['telefono'];
$email = $potential['email'];
$nome = $potential['nome'];

$message = 'Problems while sending form';
$webservice->table = 'fl_lessons_agenda';
$esito = $webservice->insertUpdate($recordId);

if($esito > 1) { 
	$message = "Thanks $nome. We have received your lesson booking!";
	mail('potentials@escapenetwork.com','FREE lesson booking ','Inserted into database on '.date('d/m/Y H:i'));
	$confirmText = "Hi $nome , we confirm your lesson booking on ".mydate(@$lesson_date)." at ".@substr($lesson_time,0,5).".";
	//$webservice->sms($to,$confirmText,crm_number);
 	$confirmText = str_replace('{{body}}', $confirmText,template_email);

	$webservice->smail($email,"FREE Lesson Confirmation for $nome",$confirmText);
	$webservice->smail('vitomichele.fazio@gmail.com','FREE lesson booking '.$nome,$confirmText);

}

echo json_encode(array('esito'=>$esito ,'info_txt'=>$message));
exit;
}


if(isset($dataset['insertMeeting'])){
	
mandatory_fileds(array('token','potential_rel','meeting_date','meeting_time'));
$webservice->token = $webservice->check($dataset['token']);
$recordId = 1;
$meeting_date = $webservice->check($dataset['meeting_date']);
$meeting_time = $webservice->check($dataset['meeting_time']);

$potential = GRD('fl_potentials',$dataset['potential_rel']);
$to = $potential['telefono'];
$email = $potential['email'];
$nome = $potential['nome'];

$message = 'Problems while sending form';
$webservice->table = 'fl_meeting_agenda';
$esito = $webservice->insertUpdate($recordId);

if($esito > 1) { 
	$message = "Thanks $nome. We have received your booking";
	mail('potentials@escapenetwork.com','New meeting auto-created','Inserted into database on '.date('d/m/Y H:i'));
	$webservice->query('UPDATE fl_potentials SET status_potential = 2 WHERE id = '.$dataset['potential_rel']);
	$webservice->query('UPDATE '.$webservice->table.' SET data_aggiornamento = NOW() WHERE id = '.$esito);
	$confirmText = "Hi $nome , we confirm your meeting at our office 4th Floor, 37/39 Oxford Street, W1D 2DU on ".mydate(@$meeting_date)." at ".@substr($meeting_time,0,5).". Looking forward to seeing you.Click to navigate to us: https://goo.gl/xthkMT";
	$webservice->sms($to,$confirmText,crm_number);
	$webservice->smail($email,"Confirmation of meeting for $nome",$confirmText.' Follow us on: https://www.facebook.com/EscapeNetworkUK/');
	//mail('support@aryma.it','New meeting auto-created for '.$nome,$confirmText);

}

echo json_encode(array('esito'=>$esito ,'info_txt'=>$message));
exit;
}


if(isset($dataset['subcribeNewsletter'])){
	
mandatory_fileds(array('token','email'));
$webservice->token = $webservice->check($dataset['token']);
$recordId = 1;

$message = 'Problems while subcribing';
$webservice->table = 'fl_newsletter';
$esito = $webservice->insertUpdate($recordId);

if($esito > 1) { $message = "Thanks for subcribing"; }


echo json_encode(array('esito'=>$esito ,'info_txt'=>$message));
exit;
}


if(isset($dataset['insertExperience'])){
mandatory_fileds(array('token','profile_rel'));
$webservice->token = $webservice->check($dataset['token']);
$webservice->table = 'fl_work_exp';
$recordId = (isset($_REQUEST['id'])) ? $webservice->check($_REQUEST['id']) : 1;
$esito = $webservice->insertUpdate($recordId);
echo json_encode(array('esito'=>$esito ,'info_txt'=>$esito));
exit;
}


if(isset($dataset['insertEducation'])){
mandatory_fileds(array('token','profile_rel'));
$webservice->token = $webservice->check($dataset['token']);
$webservice->table = 'fl_studies';
$recordId = (isset($_REQUEST['id'])) ? $webservice->check($_REQUEST['id']) : 1;
$esito = $webservice->insertUpdate($recordId);
echo json_encode(array('esito'=>$esito ,'info_txt'=>$esito));
exit;
}



if(isset($dataset['getExperiences'])){
mandatory_fileds(array('token','userId'));
$webservice->token = $webservice->check($dataset['token']);
$webservice->userId = $webservice->check($dataset['userId']);
$webservice->table = 'fl_work_exp';
$esito = $webservice->getExperiences();
echo json_encode(array('esito'=>$esito ,'info_txt'=>$esito ));
exit;
}



if(isset($dataset['getStudies'])){
mandatory_fileds(array('token','userId'));
$webservice->token = $webservice->check($dataset['token']);
$webservice->userId = $webservice->check($dataset['userId']);
$webservice->table = 'fl_studies';
$esito = $webservice->getStudies();
echo json_encode(array('esito'=>$esito ,'info_txt'=>$esito ));
exit;
}




if(isset($dataset['get_page'])){

mandatory_fileds(array('token','page_id'));
$webservice->token = check($dataset['token']);
$webservice->page_id = check($dataset['page_id']);
$webservice->get_page();

}

if(isset($dataset['lost_password'])){
mandatory_fileds(array('token','email'));
if(isset($dataset['token'])) $webservice->token = check($dataset['token']);
if(isset($dataset['email'])) $webservice->email = check($dataset['email']);
$webservice->send_login();
exit;
}


echo json_encode(array('esito'=>0,'info_txt'=>"Specifica un metodo o autentica client"));
exit;

?>
