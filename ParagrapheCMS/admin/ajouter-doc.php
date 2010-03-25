<?php /* Date de cration: 19/01/2009 */
if ($numpara) {//on est en modification
   $modifDoc = new Documentation();
   $modifDoc->numpara=$numpara;
   $modifDoc->infosDoc();
}
/**mysql_query("INSERT INTO if_type_doc (type_doc,nom) VALUES (1,'fiche actions')");
mysql_query("INSERT INTO if_type_doc (type_doc,nom) VALUES (2,'article de revue \"Techniporc\"')");
mysql_query("INSERT INTO if_type_doc (type_doc,nom) VALUES (3,'article de revue \"Baromètre porc\"')");
mysql_query("INSERT INTO if_type_doc (type_doc,nom) VALUES (4,'article de revue \"PATHO-Gènes\"')");
mysql_query("INSERT INTO if_type_doc (type_doc,nom) VALUES (5,'ouvrage de référence')");
mysql_query("INSERT INTO if_type_doc (type_doc,nom) VALUES (6,'fiche repères techniques')");**/

?>

<div class="item" id="coltexteAdmin">
	<div class="sap-content">
		<div class="TabbedPanels">
 			 <div class="TabbedPanelsContentGroup">
  				  <div class="TabbedPanelsContent"> 
			<fieldset>
			<legend><?php if ($numpara) echo "Modifier la documentation"; else echo "Ajouter une documentation";?></legend>
			
				    
					<ol>
					<li>
				      <label for="name">Type de documentation :</label>
				      <select name="selectType">
					  	<option>Choisissez un type</option>
					<?php
					$TypeAIgnorer=array(
						13,14,17,18,19,
						20,21,22,23,24,25,26,27,28,29,
						30,31,32,33,34,35,36,37,38,39,
						40,41,42,43,44,45,46,47,48,49,
						50,51,52,53,54,55,56,57,58,59,
						60,61,62,63,64,66,67,68,69,
						70,71,72,73,74,75,76,77,78,79,
						80,82,83,83,84,85,86,87,88,89,
						90,91,92,93,94,95,96,97,98,99,
						100,101,102,103,104,105,106,107,108,109,
						110,111,112,113,114,115,117,118,119,
						120,121,122,123,124,125,126,127,128,129,
						131,134,136,137,138,
						142,143,144,145,147,150,151,152,153);
							
						$query.="SELECT * FROM if_type_doc WHERE (type_doc!='16'";
						reset($TypeAIgnorer);
						while (list(,$val)=each($TypeAIgnorer)) {
							$query.=" AND type_doc!='".$val."'";
						}
						$query.=") ORDER BY nom";						
						$result=mysql_query($query);
						/*
						$result=mysql_query("SELECT * FROM if_type_doc 
						WHERE (type_doc!='90' AND type_doc!='131' AND type_doc!='22' AND type_doc!='136' AND type_doc!='67' 
						AND type_doc!='89' AND type_doc!='123' AND type_doc!='16' AND type_doc!='97' AND type_doc!='125' 
						AND type_doc!='120' AND type_doc!='21' AND type_doc!='69' AND type_doc!='40' AND type_doc!='54' 
					    AND type_doc!='62' AND type_doc!='122' AND type_doc!='68' AND type_doc!='106' AND type_doc!='17' 
						AND type_doc!='23' AND type_doc!='99' AND type_doc!='80' AND type_doc!='92' AND type_doc!='52' 
						AND type_doc!='110' 
						ORDER BY nom");
						*/
						while ($row=mysql_fetch_array($result)) {
						?>
							<option value="<?=$row["type_doc"]?>" <?php if ($modifDoc->type_doc==$row["type_doc"]) echo "selected='selected'";?>><?=$row["nom"]?></option>
						<?php
						}//fin du wile
						?>
					  </select>
				    </li>
					<li>
				      <label for="name">Nouveau type de documentation :</label>
				      <input type="text" id="textNewType" name="textNewType" />
				    </li>
					<li>
				      <label for="name">Titre français :</label>
				      <textarea name="textTitreFr" id="textTitreFr" style="height:50px" ><?=$modifDoc->titrePara?></textarea>
				    </li>
					<li>
				      <label for="name">Titre anglais :</label>
				       <textarea name="textTitreEn"  id="textTitreEn" style="height:50px" ><?=$modifDoc->titre_en?></textarea>
				    </li>
				    <li>
				      <label for="name">Résumé français :</label>
				      <textarea name="textContFr"><?=miseEnFormeTextarea($modifDoc->contenuPara)?></textarea>
				    </li>
					 <li>
				      <label for="name">Résumé anglais :</label>
				      <textarea name="textContEn"><?=miseEnFormeTextarea($modifDoc->contenu_en)?></textarea>
				    </li>
					<li>
				      <label for="name">Auteur (Nom P et le séparateur est le &quot;;&quot;) :</label>
				      <input type="text" id="textAuteur" name="textAuteur" value="<?=$modifDoc->auteur?>"/>
				    </li>
					<li>
				      <label for="name">R&eacute;f&eacute;rence bibliographique :</label>
				      <input type="text" id="name" name="textRefBib" value="<?=$modifDoc->ref_biblio?>"/>
				    </li>
					<li>
				      <label for="name">R&eacute;f&eacute;rence (pour le panier):</label>
				      <input type="text" id="name" name="textRef" value="<?=$modifDoc->reference?>"/>
				    </li>
					 <li>
				      <label for="name">Mots clés (le séparateur est le ";") :</label>
				      <input type="text" id="name" name="textKeyw" value="<?=$modifDoc->keyw?>"/>
				    </li>
					<li>
				      <label for="name">Date (format jj/mm/aaaa) :</label>
				      <input type="text" id="name" name="textDate" value="<?php if ($modifDoc->date) echo $modifDoc->date;?>"/>
				    </li>
					<li>
				      <label for="name">Date (format libre) :</label>
				      <input type="text" id="name" name="textDateLibre" value="<?php if ($modifDoc->date_libre) echo $modifDoc->date_libre;?>"/>
				    </li>
					<li>
				      <label for="name">Tarif (Ne pas indiquer gratuit) :</label>
				      <input type="text" id="name" name="textTarif" value="<?=$modifDoc->tarif?>"/> 
				      €				    </li>
					<!-- en commentaire le 13/03/2009
					<li>
				      <label for="name">Mot de passe :</label>
				      <input type="text" id="name" name="textPwd" value="<?=$modifDoc->pwd?>"/>
				    </li>
					-->
					<li>
				      <label for="name">Pour les ouvrages de référence, indiquer son poids:</label>
				      <input type="text" id="name" name="textPoids" value="<?=$modifDoc->poids?>"/> grammes				    </li>
					<li>
				      <label for="name">Publi&eacute;e :</label>
				      <input type="radio" id="radio" name="radioPubliee" value="o" <?php if ($modifDoc->publiee=="o" || !$numpara) echo "checked='checked'";?> /> <span class="radio">oui</span>	<input type="radio" id="radio" name="radioPubliee" value="n" <?php if ($modifDoc->publiee=="n" ) echo "checked='checked'";?> /> <span class="radio">non</span>				    </li>
					<li>
				      <label for="name">Pour les ouvrages de référence, placer à la une :</label>
				      <input type="radio" id="radio" name="radioUne" value="o" <?php if ($modifDoc->une=="o" ) echo "checked='checked'";?> /> <span class="radio">oui</span>	<input type="radio" id="radio" name="radioUne" value="n" <?php if ($modifDoc->une=="n" || !$numpara) echo "checked='checked'";?> /> <span class="radio">non</span>				    </li>
					<li>
				      <label for="name">Accès réservé aux professionnels :</label>
				      <input type="radio" id="radio" name="radioAcces" value="o" <?php if ($modifDoc->acces_res=="o" ) echo "checked='checked'";?> /> <span class="radio">oui</span>	<input type="radio" id="radio" name="radioAcces" value="n" <?php if ($modifDoc->acces_res=="n" || !$numpara) echo "checked='checked'";?> /> <span class="radio">non</span>				    </li>
					<?php 
					// la fiche	
					if ($numpara) {
						$listfichiers=new ListeFichiers();
						$listfichiers->numpara= $modifDoc->numpara; 
						$nb_fichiers=$listfichiers->afficherListeFichiers();
						if ($nb_fichiers) {  
					?>
						 <li>
					      <label for="fichtitle">Le pdf:</label> 
						  </li>
						  <?php
							foreach ($listfichiers as $fichiers) {
								if ($fichiers->nomFichier) {
							?>
							     <li><label></label><!--<p class="liens" id="li_fichiers<?=$fichiers->numfichier?>">>--><a name="fich_name<?=$fichiers->numfichier?>" id="fich_id<?=$fichiers->numfichier?>" href="ouverturepdf.php?file=<?=$fichiers->nomFichier?>" target="_blank"> <?=$fichiers->nomFichier?></a>&nbsp;<a href="javascript:conf_supAssoc('pop_sup.php?index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numpara=<?=$modifDoc->numpara?>&numfichier=<?=$fichiers->numfichier?>&numparafichier=<?=$fichiers->numparafichier?>&div=li_fichiers<?=$fichiers->numfichier?>','un fichier')">supprimer l'association</a>&nbsp;&nbsp;
			<a href="javascript:popup('modifier_fich.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numfichier=<?=$fichiers->numfichier?>&numpara=<?=$modifDoc->numpara?>&numparafichier=<?=$fichiers->numparafichier?>&doc=1')">modifier</a></li>
			<!--</p>-->
								  
							<?php
								}//fin if ($fichiers->nomFichier)
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
						$listfichiers->afficherListeFichiers();
						//en commentaire le 13/03/2009 if ($b) { 
					  ?>
					  <!-- en commentaire le 13/03/2009
					  <label for="flegFich">Associer la fiche existante :</label>
					  <select name="selectFich">	
						  <option></option>
						  <?php
							foreach ($listfichiers as $fichiers) {
						  ?>
						  	   <option value="<?=$fichiers->numfichier?>"><?=$fichiers->nomFichier?></option>
						  <?php
						  }
						  ?> 
					  </select>	
					  -->
					  <?php
					  // en commentaire le 13/03/2009 }//fin if ($b)
					  ?>
					  <label for="ffichier"><?php echo "Ajouter un";?> PDF :</label>
				      <input type="file" name="fileFiche"  />	 
					</li>
					
					<?php 
					// la vignette	
					if ($numpara) {
						$listvignette=new ListePhotos();
						$listvignette->numpara= $modifDoc->numpara; 
						$nb_vignette=$listvignette->afficherListePhotos();
						if ($nb_vignette) {  
					?>
						 <li>
					      <label for="vignettetitle">La photo :</label> 
						  <?php
								foreach ($listvignette as $photos) {
							?>
							     <!--<p class="liens" id="li_photos<?=$photos->numphoto?>">>--><a name="ph_name<?=$photos->numphoto?>" id="ph_id<?=$photos->numphoto?>" href="photos/<?=$photos->nomPhoto?>" target="_blank"> <?=$photos->nomPhoto?></a>&nbsp;&nbsp;<a href="javascript:conf_supAssoc('pop_sup.php?index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numpara=<?=$modifDoc->numpara?>&numphoto=<?=$photos->numphoto?>&numparaphoto=<?=$photos->numparaphoto?>&div=li_photos<?=$photos->numphoto?>','une photo')">supprimer l'association</a>&nbsp;&nbsp;
			<a href="javascript:popup('modifier_fich.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numphoto=<?=$photos->numphoto?>&numpara=<?=$modifDoc->numpara?>&numparaphoto=<?=$photos->numparaphoto?>&doc=1')">mettre à jour</a><br /><!--</p>-->
								  
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
					    $listvignette=new ListePhotos(); 	   
						$b=$listvignette->afficherListePhotos();
						//en commentaire le 13/03/2009 if ($b) { 
					  ?>
					  <!-- en commentaire le 13/03/2009
					  <label for="flegPhoto">Associer la vignette existante :</label>
					  <select name="selectPhoto">	
						  <option></option>
						  <?php
							foreach ($listvignette as $photos) {
						  ?>
						  	   <option value="<?=$photos->numphoto?>"><?=$photos->nomPhoto?></option>
						  <?php
						  }
						  ?> 
					  </select>	
					  -->
					  <?php
					 //en commentaire le 13/03/2009  }//fin if ($b)
					  ?>
					  <label for="fphoto"><?php echo "Ajouter une";?> photo :</label>
				      <input type="file" name="filePhoto"  />	 
					</li>
					<?php
					 $list_categ=new ListeMenus();
					 $list_categ->type="categorie";
					 $list_categ->nomkey="numcateg";
					 $list_categ->ordre_req="nom";//requête triée par ordre alaphabétique du menu
					 $nb_categ=$list_categ->afficherListeMenus();
					 
					 $list_sscateg=new ListeMenus();
					 $list_sscateg->type="sscateg";   
					 $list_sscateg->nomkey="numsscateg";
					 $list_sscateg->ordre_req="nom";//requête triée par ordre alaphabétique du menu
					 $nb_sscateg=$list_sscateg->afficherListeMenus();
					 
					 if ($nb_categ) { 
					 	 if ($numpara) $modifDoc->afficherCateg();
					?>
					 <li>
					      <label for="alias">Associer ce document &agrave; une ou plusieurs cat&eacute;gories :</label>
						  <select name="selectCateg[]" size="15" multiple>					   
						  <?php
						  foreach ($list_categ as $menus) {
						  ?>
						  	 <option value="<?=$menus->nummenu?>"
							 <?php
							 for ($i=0;$i<count($modifDoc->listcateg);$i++) {	
							   	   $laCateg=$modifDoc->listcateg[$i];	  
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
						if ($numpara) $modifDoc->afficherSscateg();
					?>
					   <li>
					      <label for="alias">Associer ce document &agrave; une ou plusieurs sous-cat&eacute;gories :</label>
						  <select name="selectSscateg[]" size="16" multiple>
						  <?php
						  foreach ($list_sscateg as $menus) {
						  ?>
						  	 <option value="<?=$menus->nummenu?>"
							  <?php
							 for ($i=0;$i<count($modifDoc->listsscateg);$i++) {	
							   	   $laSscateg=$modifDoc->listsscateg[$i];	
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
				 
				 <br />	
				  <li>
				  <label>&nbsp;</label>
				  <input id="validerForma" name="validerForma" type="button" class="bouton" value="Valider" onClick="javascript:valideDoc()"/>&nbsp;<input id="boutonannuler" name="boutonannuler" type="button" value="Annuler" class="bouton" onClick="javascript:document.forms[0].annuler.value='1';document.forms[0].submit()"/>
				 </li>
				 </ol>
				  <input type="hidden" name="annuler" value="" /><!-- permet de ne pas enregistrer les modifications -->
				  <input type="hidden" name="numpara" value="<?=$numpara?>" />
				  <input type="hidden" name="suite" value="<?=$suite?>" />
				  <input type="hidden" name="pageactive" value="<?=$pageactive?>" />
				  <input type="hidden" name="touteladoc" value="<?=$touteladoc?>" />
				  <input type="hidden" name="critere" value="<?=$critere?>" />
				  <input type="hidden" name="type_doc" value="<?=$type_doc?>" />
				  <input type="hidden" name="rech" value="<?=$rech?>" />
				  <input type="hidden" name="rechauteur" value="<?=$rechauteur?>" />
				  <input type="hidden" name="dom" value="<?=$dom?>" />
                  <input type="hidden" name="anciennedate" value="<?=$anciennedate?>" />
				<input type="hidden" name="ssdom" value="<?=$ssdom?>" />
   		</fieldset>
		</div>
	</div>  
</div>
</div>  
</div>

