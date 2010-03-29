<?php /* Date de cration: 11/02/2009 */
if ($numpara) {//on est en modification
   $modifActu = new Actualite();
   $modifActu->numpara=$numpara;
   $modifActu->infosActu();
}
?>

<div class="item" id="coltexteAdmin">
	<div class="sap-content">
		<div class="TabbedPanels">
 			 <div class="TabbedPanelsContentGroup">
  				  <div class="TabbedPanelsContent"> 
  				  
		<fieldset>
			<legend><?php if ($numpara) echo "Modifier la brève d'actualité"; else echo "Ajouter une brève d'actualité :";?></legend>
			<ol>
				    <li>
				      <label for="titreActu">Titre<em>*</em> :</label>
				      <input type="text" id="titreActu" name="textTitre" value="<?=$modifActu->titrePara?>"/>
				    </li>
				    <li>
				      <label for="contenuActu">Contenu :</label>
				      <textarea id="contenuActu" name="textCont"><?=miseEnFormeTextarea($modifActu->contenuPara)?></textarea>
				    </li>
					<li>
				      <label for="dateActu">Date de l'actualité (format jj/mm/aaaa) :</label>
				      <input type="text" id="dateActu" name="textDate" value="<?php if ($modifActu->datebrut) echo $modifActu->date_actu;?>"/>
				    </li>	
					<li>		
						<label for="libActu">Libell&eacute; du lien :</label>
				      <input id="libActu" name="textLibLien"/> 
					</li>
					<li>   
					  <label for="lienTexteActu">Texte du lien :</label>
				      <textarea id="lienTexteActu" name="textTexteLien"></textarea>
					</li>
					<li>     
					  <label for="lienUrlActu">Url du lien :</label>
				      <input id="lienUrlActu" name="textUrlLien"/>	 
					</li>
					   
					<li>     
					  <label>Ouverture du lien dans une nouvelle fenêtre ? :</label>
					  <input type="radio" id="radio"  name="nvelleFenetre" value="o" >
					  		<span class="radio">oui</span> 	
					  <input type="radio" id="radio" name="radioFen" value="n" checked='checked'/> 
					  		<span class="radio">non</span>
					</li>
					<li>
					  <label for="vignetteLegendeActu">L&eacute;gende de la vignette :</label>
					  <input id="vignetteLegendeActu" name="textLegPh"/> 
					  <?php
						$listphotos=new ListePhotos(); 	   
						$b=$listphotos->afficherListePhotos();
						if ($b) { 
					  ?>
		  		  </li>
					 <?php
					 //le lien
						$listliens=new ListeLiens();
						$listliens->numpara= $modifActu->numpara;
						$nb_liens=$listliens->afficherListeLiens();
						if ($nb_liens) {
						?> 
						<li>
						  <label for="lienstitle" >Les liens :</label> 
						  <?php
							foreach ($listliens as $liens) {
							?>
								 <p class="liens" id="li_liens<?=$liens->numlien?>">&nbsp;&nbsp;<a name="lien_name<?=$liens->numlien?>" id="lien_id<?=$liens->numlien?>" href="<?=$liens->urlLien?>" target="_blank"><?=$liens->libLien?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:conf_supAssoc('pop_sup.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numlien=<?=$liens->numlien?>&div=li_liens<?=$liens->numlien?>','un lien')">supprimer le lien</a>&nbsp;&nbsp;<a href="javascript:popup('modifier_fich.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numlien=<?=$liens->numlien?>')">modifier le lien</a></p>
								  
							<?php
							}//fin du foreach ($listliens as $liens) 
							?>	
						</li>	
						<?php		  
						}//fin if ($nb_liens)
					 
				
					// la vignette	
					if ($numpara) {
						$listvignette=new ListePhotos();
						$listvignette->numpara= $modifActu->numpara; 
						$nb_vignette=$listvignette->afficherListePhotos();
						if ($nb_vignette) {  
					?>
						 <li>
					      <label for="fichtitle">La vignette :</label> 
						  <?php
								foreach ($listvignette as $photos) {
							?>
							     <span id="li_photos<?=$photos->numphoto?>"><a name="ph_name<?=$photos->numphoto?>" id="ph_id<?=$photos->numphoto?>" href="photos/<?=$photos->nomPhoto?>" target="_blank"> <?=$photos->nomPhoto?></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:conf_supAssoc('pop_sup.php?index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numpara=<?=$modifActu->numpara?>&numphoto=<?=$photos->numphoto?>&numparaphoto=<?=$photos->numparaphoto?>&div=li_photos<?=$photos->numphoto?>','une photo')">ne plus associer </a>&nbsp;&nbsp;
			<a href="javascript:popup('modifier_fich.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numphoto=<?=$photos->numphoto?>&numpara=<?=$modifActu->numpara?>&numparaphoto=<?=$photos->numparaphoto?>&doc=1')">modifier la vignette</a></span>
							<?php
								}//fin du foreach ($listfichiers as $fichiers)
								?> 
					    </li>	
					     <?php		  
						}//fin if ($nb_fichiers)  
					}//fin if ($numpara)
					?>
					 
					 <li>
					  <label for="fphot">Associer la vignette existante :</label>
					  <select id name="selectPhoto">	
						  <option></option>
						  <?php
							foreach ($listphotos as $photos) {
								$nb_photos=$photos->countPhotos();
						  ?>
							   <option value="<?=$photos->numphoto?>"><?php echo $photos->nomPhoto; if ($nb_photos>=1) echo " (déjà utilisée)";?></option>
						  <?php
						  }
						  ?> 
					  </select>	
					  
					  <?php
					  }//fin if ($b)
					  ?>
		    </li>
					  <li>
						  <label for="fphoto"><?php if ($b) echo "ou ajouter une ";?>	vignette :</label>
						  <input type="file" name="filePhoto"  />	   
					  </li>
					 
				
				 <li>
					  <label>Associer la brève à l'accueil :</label>
					  <input type="radio" id="radio" name="radioAccueil" value="o" <?php if ($modifActu->accueil=="o") echo "checked='checked'";?> /> <span class="radio">oui</span>	<input type="radio" id="radio" name="radioAccueil" value="n" <?php if ($modifActu->accueil=="n" || !$numpara) echo "checked='checked'";?>  /> <span class="radio">non</span>
		    </li>
				 <input type="hidden" name="numpara" value="<?=$numpara?>" />
				 <input id="button" name="validerActu" type="button" value="Valider" onClick="javascript:valideActu()"/> 
				 </li>
				 </ol> 
   		</fieldset>
		</div>
	</div>  
</div>
</div>  
</div>

