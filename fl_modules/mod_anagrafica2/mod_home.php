<?php

// Controlli di Sicurezza
if (!@$thispage) {echo "Accesso Non Autorizzato";exit;}
//if(!isset($_GET['associa_evento'])) $_SESSION['POST_BACK_PAGE'] = $_SERVER['REQUEST_URI'];
?>

<div class="filtri" id="filtri">

<form method="get" action="" id="fm_filtri">
<h2> Filtri</h2>
<?php if (isset($_GET['action'])) {
    echo '<input type="hidden" value="' . check($_GET['action']) . '" name="action" />';
}
?>

<?php if (ATTIVA_ACCOUNT_ANAGRAFICA == 1) {?>

  <div class="filter_box">
  <label>  Tipo account:</label>
    <select name="tipo_account" id="tipo_account">
      <option value="-1">Tutti </option>
  	<?php

    foreach ($tipo as $valores => $label) { // Recursione Indici di Categoria
        $selected = ($tipo_account_id == $valores) ? " selected=\"selected\"" : "";
        echo "<option value=\"$valores\" $selected>" . ucfirst($label) . "</option>\r\n";
    }
    ?>
    </select>
    </div>



  <div class="filter_box">
  <label>  Stato account:</label>
    <select name="status_account" id="status_account">
      <option value="-1">Tutti </option>
      <?php
$selected = (@$stato_account_id == 1) ? " selected=\"selected\"" : "";
    echo "<option value=\"1\" $selected>Attivi</option>\r\n";
    $selected = (@$stato_account_id == 0) ? " selected=\"selected\"" : "";
    echo "<option value=\"0\" $selected>Sospesi</option>\r\n";

    ?>
    </select>


    </div>

     <div class="filter_box">

      Saldi  <select name="status_saldi" id="status_saldi">
      <option value="-1">Tutti </option>
      <?php
$selected = (@$status_saldi_id == 1) ? " selected=\"selected\"" : "";
    echo "<option value=\"1\" $selected>Positivi</option>\r\n";
    $selected = (@$status_saldi_id == 0) ? " selected=\"selected\"" : "";
    echo "<option value=\"0\" $selected>Negativi</option>\r\n";

    ?>
    </select>

    </div>



<div class="filter_box">
<label>  Account:</label>
<input type="text" id="account" name="account" value="<?php if (isset($_GET['account'])) {echo check($_GET['account']);} else {}?>" onFocus="this.value='';" onkeydown=""  accesskey="a" tabindex="1"   onkeyup="return caricaProprietario(this.value,'contenuto-dinamico','account');" maxlength="200" class="txt_cerca" />
<div id="contenuto-dinamico"></div>
</div>
<?php }?>
   <?php

foreach ($campi as $chiave => $valore) {
    if (in_array($chiave, $basic_filters)) {

        if ((select_type($chiave) == 2 || select_type($chiave) == 19) && $chiave != 'id') {
            echo '<div class="filter_box">';
            echo '  <label>' . $valore . '</label>';
            echo '<select name="' . $chiave . '" class="select"><option value="-1">Tutti</option>';
            foreach ($$chiave as $val => $label) {$selected = (isset($_GET[$chiave]) && check(@$_GET[$chiave]) == $val) ? 'selected' : '';
                echo '<option ' . $selected . ' value="' . $val . '">' . $label . '</option>';}
            echo '</select>';
            echo '</div>';
        } else if ($chiave != 'id') {$cont = (isset($_GET[$chiave])) ? check($_GET[$chiave]) : '';
            echo '<div class="filter_box">';
            echo '<label>' . $valore . '</label><input type="text" name="' . $chiave . '" value="' . $cont . '" />';
            echo '</div>';}

    }

}
?>


<p><a href="?<?php echo $_SERVER['QUERY_STRING']; ?>&action=25">Ricerca Avanzata</a></p>
<input type="submit" value="Mostra" class="salva" id="filter_set" />

</form>


    </div>

 <?php if (isset($_GET['associa_evento'])) {
    echo '<h2>Inserisci una o più anagrafiche e poi <a class="button" style=" padding: 10px; background: red; color: white; " href="../mod_eventi/mod_inserisci.php?id=' . check($_GET['associa_evento']) . '&t=' . base64_encode(1) . '">torna all\'evento</a></h2>';
}
?>

<script type="text/javascript">

/*Avvio*/
$(document).ready(function() {

$('.sede_operativa').click(function () {
$(".info_sede_legale").hide();
$(".info_sede_operativa").show();
$(".sede_legale").css('font-weight','normal');
$(".sede_operativa").css('font-weight','bold');
});

$('.sede_legale').click(function () {
$(".info_sede_legale").show();
$(".info_sede_operativa").hide();
$(".sede_legale").css('font-weight','bold');
$(".sede_operativa").css('font-weight','normal');

});

});

</script>
<?php

if (isset($_GET['ordine'])) {if (!is_numeric($_GET['ordine'])) {exit;} else { $ordine = $ordine_mod[$_GET['ordine']];}}

$start = paginazione(CONNECT, $tabella, $step, $ordine, $tipologia_main, 0);

$query = "SELECT $select,tipo,acc.nominativo  FROM `$tabella` ana LEFT JOIN fl_account acc ON acc.anagrafica = ana.id WHERE ana.id > 1 ORDER BY $ordine LIMIT $start,$step;";

$risultato = mysql_query($query, CONNECT);
echo mysql_error();

?>


<table class="dati" summary="Dati" style=" width: 100%;">
<tr>
  <?php if (ATTIVA_ACCOUNT_ANAGRAFICA == 1) {?><th class="noprint"><a href="./?ordine=2&<?php echo $_SERVER['QUERY_STRING']; ?>">Account</a></th><?php }?>
  <th  class="desktop"><a href="./?ordine=3&<?php echo $_SERVER['QUERY_STRING']; ?>">Ragione Sociale</a></th>

  <th class="desktop"><a href="#" class="sede_legale">Sede Legale</a><?php if (!defined('ANAGRAFICA_SEMPLICE')) {?>/<a href="#" class="sede_operativa">Sede Operativa</a><?php }?> </th>
  <th>Contatti</th>
  <th class="noprint"></th>

</tr>


<?php


if (mysql_affected_rows() == 0) {echo "<tr><td colspan=\"9\">Nessun Record Inserito</td></tr>";}


while ($riga = mysql_fetch_assoc($risultato)) {
	
	// echo '<pre>';
	// print_r($riga);
	// echo '/<pre>';
    

	$htmlRiga = '<tr><td>'.@$riga['nominativo'].'</td>';
	$htmlRiga .= '<td>'.$riga['id'].' '.$riga['ragione_sociale'].'<br>P.Iva '.@$riga['partita_iva'].' <span class="msg orange">'.$tipo[@$riga['tipo']].'</span> </td>';
	$htmlRiga .= '<td>'.@$riga['comune_sede'].' '.@$riga['cap_sede'].'<br>'.@$riga['indirizzo_sede_legale'].'</td>';
    $htmlRiga .= '<td> <a href="tel:'.@$riga['cellulare'].' "><i class="fa fa-phone"></i> '.@$riga['telefono'].' <a href="tel:'.@$riga['cellulare'].' "><i class="fa fa-phone"></i> '.@$riga['cellulare'].' </a> <br> <a href="mailto:"><i class="fa fa-envelope"></i> '.@$riga['email'].'</a></td>';
    $htmlRiga .= '<td></td>';

	echo $htmlRiga;

}
?>

</table>

<h2>Totale risultati: <?php echo mysql_affected_rows(); ?></h2>