<?php /* Date de cration: 16/12/2008 */ 
if ($nummenu) {//on est en modification
   $modifMenu = New Menu();
   $modifMenu->type=$cont; 
   $modifMenu->nummenu=$nummenu;
   if ($cont=="rubrique") $modifMenu->nomkey="numrub";
   else if ($cont=="categorie") $modifMenu->nomkey="numcateg"; 
   else $modifMenu->nomkey="numsscateg"; 
   $modifMenu->infosMenu();	
}
?>
<div class="item" id="coltexteAdmin">
	<div class="sap-content">
		<div class="TabbedPanels">
 			 <div class="TabbedPanelsContentGroup">
  				  <div class="TabbedPanelsContent"> 
	<fieldset>

  <legend><?php if ($cont=="rubrique" && !$nummenu) echo "Nouvelle rubrique"; else if ($cont=="categorie" && !$nummenu) echo "Nouvelle cat&eacute;gorie"; else if ($cont=="sscateg" && !$nummenu) echo "Nouvelle sous-cat&eacute;gorie";
  else if ($cont=="rubrique" && $nummenu) echo "Modifier la rubrique"; else if ($cont=="categorie" && $nummenu) echo "Modifier la cat&eacute;gorie"; else if ($cont=="sscateg" && !$nummenu) echo "Modifier la sous-cat&eacute;gorie";
  ?>
  </legend>
  <ol>
    <li>
      <label for="name">Libell&eacute; du menu<em>*</em> :</label>
      <input type="text" id="name" name="textLibMenu" value="<?=$modifMenu->nomMenu?>"/>
    </li>
	<?php
	if ($cont!="sscateg") {
	?>	
		<li>
	      <label for="name">Zone :</label>
	      <select name="selectZoneMenu">
		  	  <option value="0" <?php if ($modifMenu->zone=="0") echo "selected='selected'";?> >zone 0</option>
			  <option value="1" <?php if ($modifMenu->zone=="1") echo "selected='selected'";?> >zone 1</option>
		  	  <option value="2" <?php if ($modifMenu->zone=="2") echo "selected='selected'";?>>zone 2</option>
			  <option value="3" <?php if ($modifMenu->zone=="3") echo "selected='selected'";?>>zone 3</option>
		  </select>
	    </li>
	<?php
	}//fin if ($cont!="sscateg")
	?>
	<li>
      <label for="name">Ordre :</label>
    	  <select id="ordre" name="selectOrdreMenu">
			  <?php 
			  for ($i=1; $i<=10; $i++) {	   
			  ?>
				<option value="<?=$i?>" <?php if ($modifMenu->ordre==$i) echo "selected='selected'";?>><?=$i?></option>
			 <?php
			  }
			  ?>
		  </select>	  	 
    </li>  
	<?php
	if ($cont=="categorie") {	  
		$listrub = new ListeMenus();
		$listrub->type="rubrique";
		$listrub->nomkey="numrub";
		$nb_rub=$listrub->afficherListeMenus();
		if ($nb_rub) {
	?>
	   <li>
	      <label for="name">Associer &agrave; la rubrique :</label>
		   <select name="selectRub">
	   		 <?php
			 foreach ($listrub as $menus) {	 
			 ?>
	   		 	<option value="<?=$menus->nummenu?>" <?php if ($modifMenu->numfkey==$menus->nummenu) echo "selected='selected'";?>><?=$menus->nomMenu?></option> 
			<?php
			}
			?>
	  	  </select>	  
		</li>
	<?php  
		}//fin if ($nb_rub) 
	} else if ($cont=="sscateg") {
		$listrub = new ListeMenus();
		$listrub->type="categorie";
		$listrub->nomkey="numcateg";
		$listrub->ordre_req="nom";
		$nb_rub=$listrub->afficherListeMenus();
		if ($nb_rub) {
	?>
	   <li>
	      <label for="name">Associer &agrave; la cat&eacute;gorie :</label>
		   <select name="selectCat">
	   		 <?php
			 foreach ($listrub as $menus) {	 
			 ?>
	   		 	<option value="<?=$menus->nummenu?>" <?php if ($modifMenu->numfkey==$menus->nummenu) echo "selected='selected'";?>><?=$menus->nomMenu?></option> 
			<?php
			}
			?>
	  	  </select>	  
		</li>
	<?php  
		}
	} //fin  else if ($cont=="sscateg")
	?> 
	<li>
      <label for="name">Afficher :</label>
      <input type="radio" id="radio" name="radioAffich" value="o" <?php if ($modifMenu->affiche=="o" || !$modifMenu->affiche) echo "checked='checked'";?> /> <span class="radio">oui</span> 	<input type="radio" id="radio" name="radioAffich" value="n" <?php if ($modifMenu->affiche=="n") echo "checked='checked'";?> /> <span class="radio">non</span>
    </li>	
	<li>
      <label for="name">Langue :</label>
      <select name="selectLg">
	  	  <option value="fr" <?php if ($modifMenu->lg=="fr") echo "selected='selected'";?>>fran&ccedil;ais</option>
		  <option value="en" <?php if ($modifMenu->lg=="en") echo "selected='selected'";?>>anglais</option>
	  </select>
    </li>	
 </ol> 
<br />		
 <input type="hidden" name="nummenu" value="<?=$nummenu?>" />
 <input id="button" name="validerMenu" type="button" value="Valider" onClick="javascript:ajouteMenu()"/>  
 </fieldset>
   </div>
  </div>
  </div>
</div>
</div>
