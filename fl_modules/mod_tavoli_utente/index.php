<?php

require_once '../../fl_core/autentication.php';
$_SESSION['evento_id'] = 449;

require 'config/query.config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Tableau Manager</title>
<link href="css/jquery-ui.min.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css">
<script defer src="js/fontawesome-all.js"></script>
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/script.js"></script>
</head>

<body>
<div class="container">
<div class="guest-section">
<!-- GUEST MENU SECTION -->
<div class="guest-menu">
<h1><?php echo $evento_details['titolo_ricorrenza']; ?></h1>

<div class="searchbox">
<input type="search" class="search-txt" placeholder="Search">
<button type="submit" class="search-btn">
<i class="fas fa-search"></i>
</button>
</div>
<div>
<button type="button" id="add-guest" class="btn add-guest">Aggiungi Ospite</button>
</div>
</div>

<div class="guest-list-header">
<label class="list-item list-name">Nome</label>
<abbr class="list-item" title="Adult">A</abbr>
<abbr class="list-item" title="Babies">B</abbr>
<abbr class="list-item" title="Highchair">H</abbr>
<abbr class="list-item" title="Intolerant">I</abbr>
<div></div>
</div>
<!-- GUEST LIST SECTION -->
<div id="guest-list" class="guest-list connectedSortable">

</div>

<div class="assign-btns">
<label for="to-assign">
<input type="radio" id="to-assign" name="toggle" checked>
<span class="btn toggle-btn">Assegnati</span>
</label>
<label for="assigned">
<input type="radio" id="assigned" name="toggle">
<span class="btn toggle-btn">Non assegnati</span>
</label>
</div>

</div>

<!-- TABLE SECTION -->
<div class="table-section">
<div class="table-btn">
<input type="button" class="btn btn-add-table" id="add-table" value="Add Table">
<input type="button" class="btn btn-sposo" id="btn-sposo" value="Sposo">
<input type="button" class="btn btn-sposa" id="btn-sposa" value="Sposa">
</div>
<div id="table-container" class="table-container">
<?php foreach ($tables as $table): ?>
<div class="table" data-name="<?php echo $table['nome_tavolo']; ?>">
<div class="table-header">
<p class="table-id" hidden><?php echo $table['id']; ?></p>
<p class="table-name"><strong><?php echo $table['nome_tavolo']; ?> <?php echo $table['numero_tavolo_utente']; ?> <?php echo $table['nome_tavolo_utente']; ?></strong></p>
<div class="table-body connectedSortable" data-rel="<?php echo $table['id'] ?>">
<?php
$rows = $queryGuests->rowCount();
foreach ($guests as $guest) {
    if ($guest['tavolo_id'] > 0) {
        if ($guest['tavolo_id'] == $table['id']) {
            echo '
      <div id="' . $guest['id'] . '" class="guest" >
      <p class="family-name">' . $guest['nome'] . ' ' . $guest['cognome'] . '</p>
      <p class="number-adults">' . $guest['adulti'] . '</p>
      <p class="number-babies">' . $guest['bambini'] . '</p>
      <p class="number-highchair">' . $guest['seggioloni'] . '</p>
      <p class="number-intolerant" title="'.$guest['note_intolleranze'].'">' . substr($guest['note_intolleranze'],0,15) . '</p>
      </div>
      ';
        }
    }
}
?>
</div>
</div>
</div>
<?php endforeach;?>
</div>
</div>
</div>

<!-- MODAL SECTION -->
<div id="modal-section">
<!-- GUEST MODAL -->
<div id="add-guest-modal" class="modal">
<div class="modal-content">
<i id="close1" class="close-btn fas fa-times"></i>
<!-- <span class="close-btn">&times;</span> -->
<form method="POST" action="includes/submit-guest.inc.php">
<h3><i class="far fa-address-card"></i> Aggiungi Ospite</h3>
<br>
<div id="message"></div>
<p class="form-input">
<label class="label" for="input-name">Nome</label>
<br>
<input id="input-name" name="nome" class="form-text" type="text" required >
</p>
<p class="form-input">
<label class="label" for="input-last-name">Cognome</label>
<br>
<input id="input-last-name" name="cognome" required class="form-text" type="text" >
</p>
<div class="numerical-textbox-container">
<p class="form-input-numbers">
<label class="label" for="input-adults">Adulti</label>
<input id="input-adults" name="adulti" required class="form-text" type="number" value="1" pattern="[0-9]">
</p>
<p class="form-input-numbers">
<label class="label" for="input-babies">Bambini</label>
<input id="input-babies" name="bambini" required class="form-text " type="number" value="0" pattern="[0-9]">
</p>
<p class="form-input-numbers">
<label class="label" for="input-highchair">Seggioloni</label>
<input id="input-highchair" name="seggioloni" required class="form-text" type="number" value="0" pattern="[0-9]">
</p>
</div>
<p class="form-input">
<label class="label" for="input-intolerant">Note Intolleranze</label>
<br>
<input id="input-intolerant" name="note_intolleranze" class="form-text" type="text" placeholder="Specificare se ci sono intolleranze da segnalare alla sala" >
</p>
<div class="submit">
<button id="submit-guest" name="submit-guest" class="btn" type="submit">Aggiungi</button>
</div>
</form>
</div>
</div>
<!-- TABLE MODAL -->
<div id="add-table-modal" class="modal">
<div class="modal-content">
<i id="close2" class="close-btn fas fa-times"></i>
<form method="POST" action="includes/submit-table.inc.php">
<h3><i class="fas fa-table"></i> Add Table</h3>
<div id="message"></div>
<p class="form-input">
<label class="label">Table Name</label>
<br>
<input class="form-text" id="input-table-name" name="nome_tavolo" required type="text">
</p>
<div class="submit">
<button type="submit" class="btn" id="submit-table" name="submit-table" >Submit</button>
</div>
</form>
</div>
</div>
</div>
</body>
</html>