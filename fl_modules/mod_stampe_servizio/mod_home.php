
<?php $_SESSION['POST_BACK_PAGE'] = $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']; ?>


<div class="filtri" id="filtri">
	<form method="get" action="" id="fm_filtri">
		<h2>Filtri</h2>

<?php if(isset($_GET['action'])) echo '<input type="hidden" value="'.check($_GET['action']).'" name="action" />'; ?>
<?php if(isset($_GET['start'])) echo '<input type="hidden" value="'.check($_GET['start']).'" name="start" />'; ?>

   <?php 
 
	foreach ($campi as $chiave => $valore) 
	{		
			if(in_array($chiave,$basic_filters)){
			
			

			if((select_type($chiave) == 2 || select_type($chiave) == 23 ||  select_type($chiave) == 19 || select_type($chiave) == 9 || select_type($chiave) == 8 || select_type($chiave) == 12) && $chiave != 'id') {
				
								
				echo '<div class="filter_box">';
				echo '  <label>'.$valore.'</label>';
				echo '<select name="'.$chiave.'" class="select"><option value="-1">Non impostato</option>';
				foreach($$chiave as $val => $label) { $selected = (isset($_GET[$chiave]) && check(@$_GET[$chiave]) == $val) ? 'selected' : ''; echo '<option '.$selected.' value="'.$val.'">'.$label.'</option>'; }
				echo '</select>';
				echo '</div>';
			} else if( $chiave != 'id') { $valtxt = (isset($_GET[$chiave])) ? check($_GET[$chiave]) : ''; 
			echo '<div class="filter_box">';
			echo '<label>'.$valore.'</label><input type="text" name="'.$chiave.'" value="'.$valtxt.'" />'; echo '</div>';}

			
			
			} 
		
	}
	 ?>    

 <div style="width: 50%; margin: 0; float: left;">
      <label> da</label>
      <input type="text" name="data_da" onFocus="this.value='';" value="<?php  echo $data_da_t;  ?>"  class="calendar" size="8" />
    </div>
    <div style="width: 50%; margin: 0; float: left;">
      <label> a</label>
      <input type="text" name="data_a" onFocus="this.value='';" value="<?php  echo $data_a_t;  ?>" class="calendar" size="8" />
    </div>
		 <input type="submit" value="<?php echo SHOW; ?>" class="button" />

		</form>

	</div>



	<?php
	
	$promoter = $proprietario;

	if(isset($_GET['ordine'])) { if(!is_numeric($_GET['ordine'])){ exit; } else { $ordine = $ordine_mod[$_GET['ordine']]; }}
	
	$start = paginazione(CONNECT,$tabella,$step,$ordine,$tipologia_main,0);

	$query = "SELECT $select FROM `$tabella` $tipologia_main ORDER BY $ordine LIMIT $start,$step;";
	$risultato = mysql_query($query, CONNECT);

	?>




	<table class="dati" summary="Dati" style=" width: 100%;">
		<tr>
			<th scope="col"></th>
			<th scope="col">Ora/Data/Tipo</th>
			<th scope="col">Evento</th>
			<th scope="col">Stampe disponibili</th>
		</tr>
		<?php 

		while ($riga = mysql_fetch_array($risultato)) 
		{

			$colore = "class=\"tab_earl_gray\""; 
	
			$potential = GRD($tables[106],$riga['lead_id']);
			$ambienti_id = '';
			$ambienti_id = explode(',',$riga['ambienti']);

			$ambienti_txt = '';
			foreach ($ambienti_id as $key => $value) {
				$ambienti_txt .= '<span class="msg orange">'.@$ambienti[$value].'</span>';
			}
			
			$coloreEvento = @$colors[$riga['tipo_evento']];
			$add_calendar = 'https://calendar.google.com/calendar/render?action=TEMPLATE&text='.$riga['titolo_ricorrenza'].'&location='.$location_evento[$riga['location_evento']].'&details=Inserito da Condivision&dates='.substr(str_replace('-','',$riga['data_evento']),0,8).'T'.substr(str_replace(':','',$riga['data_evento']),11,8).'/'.substr(str_replace('-','',$riga['data_fine_evento']),0,8).'T'.substr(str_replace(':','',$riga['data_fine_evento']),11,8).'&sf=true&pli=1';

		  $tavoli = GQD('fl_tavoli','id,evento_id',' evento_id = '.$riga['id']);
		  $colorScheda = ($tavoli['id'] > 1) ? $coloreEvento : 'gray';

		  $menuPortate = GQD('fl_menu_portate','id,evento_id',' evento_id = '.$riga['id']);
		  $colorMenu = ($menuPortate['id'] > 1) ? $coloreEvento : 'gray';


			echo "<tr ><td $colore><span class=\"Gletter\"></span></td>"; 
			echo "<td><h2>".mydatetime($riga['data_evento'])."</h2> <span class=\"msg\" style=\"background: $coloreEvento\">".@$tipo_evento[$riga['tipo_evento']]."</span><span class=\"msg gray\">".$periodo_evento[$riga['periodo_evento']]."</span></td>"; 
			echo "<td><h2>".$riga['titolo_ricorrenza']."</h2>".@$location_evento[$riga['location_evento']]."</td>"; 
			echo "<td>";
			if($riga['multievento'] == 1) echo "<a data-fancybox-type=\"iframe\" class=\"fancybox_view \" href=\"mod_report/mod_prospettobeo.php?data=".substr(0,10,$riga['data_evento'])."\" title=\"Prospetto\" style=\"color:   $colorMenu\"><i class=\"fa fa-map\" aria-hidden=\"true\"></i> PROSPETTO</a>";			
			if($menuPortate['id'] > 1) echo "<a data-fancybox-type=\"iframe\" class=\"fancybox_view \" href=\"mod_menu_evento.php?evento_id=".$riga['id']."\" title=\"Lista ingresso\" style=\"color:   $colorMenu\"><i class=\"fa fa-map\" aria-hidden=\"true\"></i> MENU TAVOLI</a>";			
			if($tavoli['id'] > 1) echo "<a data-fancybox-type=\"iframe\" class=\"fancybox_view_small \" target='_blank'  href=\"mod_cavalieri.php?evento_id=".$riga['id']."\" title=\"Stampa Cavalieri\" style=\"color:   $colorScheda\"><i class=\"fa fa-bookmark\" aria-hidden=\"true\"></i>  CAVALIERI</i></a>";
			if($tavoli['id'] > 1) echo "<a data-fancybox-type=\"iframe\" class=\"fancybox_view \" href=\"mod_lista_ingresso.php?evento_id=".$riga['id']."\" title=\"Lista ingresso\" style=\"color:  $colorScheda\"><i class=\"fa fa-users\" aria-hidden=\"true\"></i></i>  LISTA INGRESSO</a>";
			if($tavoli['id'] > 1) echo "<a data-fancybox-type=\"iframe\" class=\"fancybox_view \" href=\"mod_lista_intolleranze.php?evento_id=".$riga['id']."\" title=\"Lista intolleranze\" style=\"color:  $colorScheda\"><i class=\"fa fa-leaf\" aria-hidden=\"true\"></i>  LISTA INTOLLERANZE</a>";
			echo "</tr>";
			
			
			
		}

		echo "</table>";

		$start = paginazione(CONNECT,$tabella,$step,$ordine,$tipologia_main,1); 
		?>
