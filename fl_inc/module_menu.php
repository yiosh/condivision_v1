<div id="corpo" class="open-corpo">

<div id="menu">

<div id="myslidemenu" class="jqueryslidemenu">
<ul class="stumenti_modulo">
 <li> </li>
 <?php if(isset($export)) { ?><li> <a href="./?action=13"><i class="fa fa-share-square-o" aria-hidden="true"></i></a></li><?php } ?>
 <li> <a href="javascript:window.print();"><i class="fa fa-print"></i></a></li>
</ul> 

<ul id="module_menu">
  	   <li style="margin-left: 10px"><a href="#" onclick="display_toggle('#menu_modulo');" title="Ricerca generica"><i class="fa fa-search"></i></a></li>
       <?php if(isset($module_menu)) echo ''.$module_menu.''; ?>

</ul>  
</div>



<div id="menu_modulo"   <?php if(@$toggleOn == 1) echo 'style="display: inline-block"'; ?>>
  <?php if(isset($searchbox)) { ?>

<form id="fm_cerca" name="fm_cerca" action="" method="get">
      <span id="cerca">
      <?php if(isset($_GET['action'])) echo '<input type="hidden" name="action" value="'.check($_GET['action']).'" />'; ?>
      <input name="cerca" type="text"  placeholder="<?php echo check($searchbox); ?>" <?php if(!isset($_GET['cerca'])) echo 'onclick="this.value=\'\'"'; ?> value="<?php if(isset($_GET['cerca'])) echo str_replace("\'","'",check($_GET['cerca'])); ?>"   maxlength="200" class="txt_cerca" />
      <input type="submit" class="button" value="Cerca" />
      </span>
    </form>
    
<?php } ?>

<?php //if(isset($module_menu)) echo '<ul id="modulo_list">'.$module_menu.'</ul>'; ?>
<?php if(isset($modulo_uid)) echo getMenu($modulo_uid); ?>

<br style="clear: both;"/>
</div>



</div>



<div id="content"> 

<?php if(isset($module_title) && $module_title != '') { ?>
	<h1 class="module_title">
	<?php echo $module_title.' '.$new_button; ?>
    </h1>
<?php } ?>



<?php if(isset($filtri)) { ?><a href="#" style="color: white;" class="filterToggle" title="Mostra Filtri Lista"><i class="fa fa-filter" aria-hidden="true"></i>
</a><?php } ?>
