<?php /* Date de cration: 18/12/2008 */
if ($numpara) {//on est en modification
   $modifForm = New Formation();
   $modifForm->numpara=$numpara;
   $modifForm->infosFormation();
}
?>

<div class="item" id="coltexteAdmin">
	<div class="sap-content">
		<div class="TabbedPanels">
 			 <div class="TabbedPanelsContentGroup">
  				  <div class="TabbedPanelsContent"> 
			<fieldset>
			<legend><?php if ($numpara) echo "Modifier la formation"; else echo "Ajouter une formation";?></legend>
			<ol>
				    <li>
				      <label for="name">Titre<em>*</em> :</label>
				      <input type="text" id="name" name="textTitre" value="<?=$modifForm->titrePara?>"/>
				    </li>
				    <li>
				      <label for="name">Contenu :</label>
				      <textarea name="textCont"><?=miseEnFormeTextarea($modifForm->contenuPara)?></textarea>
				    </li>
					 <li>
				      <label for="name">Formation sur mesure :</label>
				      <input type="radio" id="radio" name="radioMesure" value="o" <?php if ($modifForm->surMesure=="o") echo "checked='checked'";?> /> <span class="radio">oui</span>	<input type="radio" id="radio" name="radioMesure" value="n" <?php if ($modifForm->surMesure=="n" || !$numpara) echo "checked='checked'";?> /> <span class="radio">non</span>
				    </li>
					<li>
				      <label for="name">En ligne :</label>
				      <input type="radio" id="radio" name="radioEnligne" value="o" <?php if ($modifForm->enligne=="o" || !$numpara) echo "checked='checked'";?> /> <span class="radio">oui</span>	<input type="radio" id="radio" name="radioEnligne" value="n" <?php if ($modifForm->enligne=="n" ) echo "checked='checked'";?> /> <span class="radio">non</span>
				    </li>
					<li>
				      <label for="name">Date de d&eacute;but (format jj/mm/aaaa) :</label>
				      <input type="text" id="name" name="textDateDeb" value="<?=$modifForm->datedeb_admin?>"/>
				    </li>	
					<li>
				      <label for="name">Date de fin (format jj/mm/aaaa) :</label>
				      <input type="text" id="name" name="textDateFin" value="<?php if ($modifForm->datefin!="01/01/1970") echo $modifForm->datefin_admin; ?>"/>
				    </li>
					<?php 
					// la fiche	
					if ($numpara) {
						$listfichiers=new ListeFichiers();
						$listfichiers->numpara= $modifForm->numpara; 
						$nb_fichiers=$listfichiers->afficherListeFichiers();
						if ($nb_fichiers) {  
					?>
						 <li>
					      <label for="fichtitle">La fiche formation :</label> 
						  <?php
								foreach ($listfichiers as $fichiers) {
							?>
							     <span id="li_fichiers<?=$fichiers->numfichier?>"> <?=$fichiers->nomFichier?>&nbsp;<a href="javascript:conf_supAssoc('pop_sup.php?index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numpara=<?=$modifForm->numpara?>&numfichier=<?=$fichiers->numfichier?>&numparafichier=<?=$fichiers->numparafichier?>&div=li_fichiers<?=$fichiers->numfichier?>','un fichier')">ne plus associer</a>&nbsp;&nbsp;
			<a href="javascript:popup('modifier_fich.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numfichier=<?=$fichiers->numfichier?>&numpara=<?=$modifForm->numpara?>&numparafichier=<?=$fichiers->numparafichier?>&forma=1')">modifier la fiche</a></span>
								  
							<?php
								}//fin du foreach ($listfichiers as $fichiers)
								?> 
					    </li>	
					<?php		  
						}//fin if ($nb_fichiers)  
					}//fin if ($numpara)
					?>
					<li>
				      <?php
					    $listfichiers=new ListeFichiers(); 	   
						$b=$listfichiers->afficherListeFichiers();
						if ($b) { 
					  ?>
					  <label for="flegFich">Associer la fiche existante :</label>
					  <select id="flegFich" name="selectFich">	
						  <option></option>
						  <?php
							foreach ($listfichiers as $fichiers) {
						  ?>
						  	   <option value="<?=$fichiers->numfichier?>"><?=$fichiers->nomFichier?></option>
						  <?php
						  }
						  ?> 
					  </select>	
					  <?php
					  }//fin if ($b)
					  ?>
					  <label for="ffichier"><?php if ($b) echo "ou ajouter une "; else echo "Ajouter une";?> fiche :</label>
				      <input id="ffichier" type="file" name="fileFiche"  />	 
					</li>
					<?php
					 $list_categ=new ListeMenus();
					 $list_categ->type="categorie";
					 $list_categ->nomkey="numcateg";
					 $list_categ->ordre_req="nom";//requête trié par ordre alaphabétique du menu
					 $nb_categ=$list_categ->afficherListeMenus();
					 
					 $list_sscateg=new ListeMenus();
					 $list_sscateg->type="sscateg";   
					 $list_sscateg->nomkey="numsscateg";
					 $list_sscateg->ordre_req="nom";//requête trié par ordre alaphabétique du menu
					 $nb_sscateg=$list_sscateg->afficherListeMenus();
					 
					 if ($nb_categ) { 
					 	 if ($numpara) $modifForm->afficherCateg();
					?>
					 <li>
					      <label for="alias">Associer cette formation &agrave; une ou plusieurs cat&eacute;gories :</label>
						  <select id="alias" name="selectCateg[]" size="15" multiple>					   
						  <?php
						  foreach ($list_categ as $menus) {
						  ?>
						  	 <option value="<?=$menus->nummenu?>"
							 <?php
							 for ($i=0;$i<count($modifForm->listcateg);$i++) {	
							   	   $laCateg=$modifForm->listcateg[$i];	  
								   if ($laCateg->nummenu==$menus->nummenu) echo " selected='selected'";
							   } 
							 ?>
							 ><?=$menus->nomMenu?></option>
						  <?php
						  }	//fin du foreach
						  ?>
					  	  </select>
					</li>
					<?php 
					} 
					
					if ($nb_sscateg) {
						if ($numpara) $modifForm->afficherSscateg();
					?>
					   <li>
					      <label for="alias">Associer cette formation &agrave; une ou plusieurs sous-cat&eacute;gories :</label>
						  <select id="alias" name="selectSscateg[]" size="15" multiple>
						  <?php
						  foreach ($list_sscateg as $menus) {
						  ?>
						  	 <option value="<?=$menus->nummenu?>"
							  <?php
							 for ($i=0;$i<count($modifForm->listsscateg);$i++) {	
							   	   $laSscateg=$modifForm->listsscateg[$i];	
								   //echo $laSscateg->nummenu."<br>";  
								   if ($laSscateg->nummenu==$menus->nummenu) echo " selected='selected'";
							   } 
							 ?>
							 ><?=$menus->nomMenu?></option>
						  <?php
						  }	//fin du foreach
						  ?>
				  	     </select>
					</li>
					<?php
					}
					?>
				 
				 <li>
				  <input type="hidden" name="numpara" value="<?=$numpara?>" />
				  </li>
				  <li>
				 <input id="button" name="validerForma" type="button" value="Valider" onClick="javascript:valideForma()"/>  
				 </li>
				 </ol>
   		</fieldset>
		</div>
	</div>  
</div>
</div>  
</div>
