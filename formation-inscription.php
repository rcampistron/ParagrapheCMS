<?php /* Date de création: 29/01/2009*/ 
if ($numpara) {
	$laForma=new Formation();
	$laForma->numpara=$numpara;
	$laForma->infosFormation();

}

$laPage = new Page();
$laPage->numpage=$numpage;
$laPage->infosPage();
$laPage->infosColonnes();
 
//setlocale(LC_ALL, "french");
		
if ($laPage->nomPageGoogle) { 
?>
<div class="item" id="<?php if ($laPage->C0) echo "coltexte585"; else if ($laPage->C1) echo "coltexte385";?>"> 
		   <div class="sap-content">
				<!-- item 1 585 pixels wide -->
				<p class="<?php if ($laPage->C0) echo "titre585"; else if ($laPage->C1) echo "titre385";?>"><?=$laPage->titrePage?></p>
	<fieldset>
  <?php
  if (!$action)  {
  ?>
	  <legend>S'inscrire à la formation<br />
	"<?=$laForma->titrePara?>"</legend><br />
		   <label for="name"></label>
		   <strong>Vous avez un compte IFIP ? Identifiez-vous :</strong>
		<br />
		<br />
		  
		  <label for="name">Votre email de connexion :</label>
		  <input type="text" id="name" name="textEmailCpte" class="public"/>
		<br />
		  <label for="name">Votre mot de passe :</label>
		  <input type="password" id="name" name="textPwdCpte" class="public"/>
		 <br />
		  <label for="name"></label>
		 <a href="index.php?spec=oublie&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&lg=<?=$lg?>">mot de passe oublié ?</a>
		  <br /> 
		<label for="name"></label>	
		<input id="button" name="validerCpte" type="button" class="public" value="Valider" onClick="javascript:validerCpteForma()"/>  
		<br />
		<br /> 
		<br />
		<br />
		<label for="name"></label>
		   <strong>Vous n'avez pas de compte IFIP ? Inscrivez-vous :</strong>
		<br />
		<br />
		<label for="name">Civilité :</label>
		  <select name="selectCiv " class="public">
			<option>-</option>
			<option value="Mr">Mr</option>
			<option value="Mme">Mme</option>
			<option value="Mlle">Mlle</option>
		</select>
		<br />
		  <label for="name">Nom<em class="important">*</em> :</label>
		  <input type="text" name="textNom" class="public" />
		 <br />
		 <label for="name">Prénom<em class="important">*</em> :</label>
		  <input type="text" name="textPrenom" class="public"/>
		 <br />
		 <label for="textSociete">Société<em class="important">*</em> :</label>
		 <input type="text" name="textSociete" class="public" />
		 <br />
		 
		<label for="name">Email<em class="important">*</em> :</label>
		  <input type="text" name="textEmail" class="public"/>
		 <br />
		 <label for="name">Mot de passe<em class="important">*</em> :</label>
		  <input type="text" name="textPwd" class="public"/>
		<br /> 
		<label for="textAdr1">Adresse<em class="important">*</em> :</label>
		<input type="text" name="textAdr1" class="public" />
		<br />
		<label for="textAdr2"></label>
		<input type="text" name="textAdr2" class="public" />
		<br />
		<label for="textCp">Code Postal<em class="important">*</em> :</label>
		<input type="text" name="textCp" class="public" />
		<br />
		<label for="textVille">Ville<em class="important">*</em> :</label>
		<input type="text" name="textVille" class="public" />
		<br />
		<label for="selectPays">Pays<em class="important">*</em> :</label>
		<select name="selectPays" class="public">
		<option>Sélectionnez un pays</option>
		<option>------------------------------------------------------</option>
		<option value="247">France metropolitaine</option>
		<option>------------------------------------------------------</option>
		<?php
		$result = mysql_query("SELECT * FROM if_pays ORDER BY pays");
		while ($row=mysql_fetch_array($result)) {
		?>
			<option value="<?=$row['numpays']?>"><?=utf8_encode($row['pays'])?></option>
		<?php
		}//fin du while
		?>
		</select>
		<br />
		<label for="textTel">Tel<em class="important">*</em> :</label>
		<input type="text" name="textTel" class="public" />
		<br />
		<label for="textFax">Fax :</label>
		<input type="text" name="textFax" class="public" />
		<br />
		<label for="name"></label>	
		<input id="button" name="validerInscr" type="button" class="public" value="Valider" onClick="javascript:validerInscrForma('creerCompte')"/>  
	<?php
	} else if ($action=="seConnecter" || $action=="creerCompte") {//fin if (!$action)
	?>
		 <legend>S'inscrire à la formation "<?=$laForma->titrePara?>"</legend><br />
		  <label for="name"></label>	
		  <strong>Votre employeur :</strong>
		  <br /><br />
		   <label for="name">Raison sociale :</label>
		  <input type="text" name="textRaison" class="public" value="<?=$client->raison?>" />
		 <br />
		  <label for="name">Adresse :</label>
		  <input type="text" name="textAdr1" class="public" value="<?=$client->adr1?>"/>
		 <br />
		  <label for="name"></label>
		  &nbsp;<input type="text" name="textAdr2" class="public" value="<?=$client->adr2?>"/>
		 <br />
		  <label for="name">Code postal :</label>
		  <input type="text" name="textCp" class="public" value="<?=$client->cp?>"/>
		 <br />
		  <label for="name">Ville :</label>
		  <input type="text" name="textVille" class="public" value="<?=$client->ville?>" />
		 <br />
		 <label for="name">Pays :</label>
		 <select name="selectPays" class="public">	
		<?php
		$result = mysql_query("SELECT * FROM if_pays ORDER BY pays");
		while ($row=mysql_fetch_array($result)) {
		?>
			<option value="<?=$row['numpays']?>" <?php if ($client->pays==$row['numpays'] || (!$client->pays && $row['numpays']=="247")) echo "selected='selected'";?>><?=utf8_encode($row['pays'])?></option>
		<?php
		}//fin du while
		?>
		</select>
		 
		  <label for="name">Téléphone :</label>
		  <input type="text" name="textTel" class="public" value="<?=$client->tel?>"/>
		 <br />
		  <label for="name">Fax :</label>
		  <input type="text" name="textFax" class="public" value="<?=$client->fax?>"/>
		 <br /> <br /><br />
		 
		 <label for="name"></label>	
		  <strong>Renseignements concernant le stagiaire :</strong>
		  <br /><br /> 
		 <label for="name">Téléphone portable :</label>
		  <input type="text" name="textGsm" class="public" value="<?=$client->gsm?>"/>
		 <br />
		 <label for="name">Fonction :</label>
		 <br />
		  <label for="name">Ingénieur :</label>
		  <input type="radio" id="radio" name="radioFonct" value="ingénieur" <?php if ($client->fonction=="ingénieur") echo "checked='checked'";?>/>
		 <br />
		   <label for="name">Technicien :</label>
		  <input type="radio" id="radio" name="radioFonct" value="technicien" <?php if ($client->fonction=="technicien") echo "checked='checked'";?>/>
		 <br />
		  <label for="name">Eleveur :</label>
		  <input type="radio" id="radio" name="radioFonct" value="éleveur" <?php if ($client->fonction=="éleveur") echo "checked='checked'";?>/>
		 <br />
		 <label for="name">Vétérinaire :</label>
		  <input type="radio" id="radio" name="radioFonct" value="vétérinaire" <?php if ($client->fonction=="vétérinaire") echo "checked='checked'";?>/>
		 <br />
		 <label for="name">Autres (préciser) :</label>
		  <input type="text" name="textAutreFonct" class="public" value="<?php if ($client->fonction!="ingénieur" && $client->fonction!="technicien" && $client->fonction!="éleveur" && $client->fonction!="vétérinaire") echo $client->fonction;?> "/>
		  
		<br /> <br /><br />
		 <label for="name"></label>	
		  <strong>Demande une réservation de chambre(s) (stage sur plusieurs jours uniquement, sous réserve qu'un hébergement soit proposé pour ce stage, voir descriptif) :</strong>
		  <br /><br />
		   <label for="name">La veille du stage :</label>
		  <input type="checkbox" id="checkbox" name="checkVeille" value="chambre la veille du stage"/>
		  <br />
		   <label for="name">et un dîner (les dîners sont servis jusqu'à 20h30)</label>
		  <input type="checkbox" id="checkbox" name="checkDiner" value="dîner"/>
		  <br />
		   <label for="name">Pendant le stage :</label>
		  <input type="checkbox" id="checkbox" name="checkPendant" value="chambre pendant le stage" />
		<br /> <br /><br />
		 <label for="name"></label>	
		  <strong>Etablissement(s) à FACTURER :</strong>
		  <br /><br />
		   <label for="name">Pour la pédagogie :</label>
		  <input type="text" name="textPedag" class="public" />
		  <br />
		   <label for="name">N° TVA :</label>
		  <input type="text" name="textPedagTva" class="public"/>
		  <br />
		    <label for="name">Pour l'hébergement :</label>
		  <input type="text" name="textHeberg" class="public" />
		  <br />
		   <label for="name">N° TVA :</label>
		  <input type="text" name="textHebergTva" class="public" />
		  <br />
		 <input id="button" name="validerInscr" type="button" class="public" value="Valider" onClick="javascript:validerInfosForma()"/>  
	<?php
	} else  if ($action=="sinscrire") {//fin else if ($action=="seConnecter" || $action=="creerCompte")
	?>
		Nous vous remercions pour votre pré-inscription à la formation "<?=$laForma->titrePara?>" <?php if ($laForma->datefin) echo "du ".$laForma->datedeb." au ".$laForma->datefin; else if ($laForma->datedeb && !$laForma->datefin) echo $laForma->datedeb; else if ($laForma->surMesure=="o") echo "sur mesure"; ?>.<br /><br />
		Nous vous enverrons un mail à l'adresse <?=$leClient->email?> pour confirmer l'inscription définitive. 
	
	<?php
	}//fin du else if ($action=="sinscrire") 
	?>
 </fieldset>
	<input type="hidden" name="numpara" value="<?=$numpara?>"/>
<input type="hidden" name="action" />
<!-- Fin affichage contenu non dynamique (provenant du CMS)-->

				<p>&nbsp;</p>
				<p>&nbsp;</p>
  </div>
</div>
	
	
	<?php

	// Les contacts référents liés  la catégorie ou sous-catgorie
	$nb_cont=0;
	if ($numsscateg) {
	   $menuCont=new Menu();
	   $menuCont->type="sscateg";
	   $menuCont->nummenu=$numsscateg;	
	   $nb_cont=$menuCont->afficherContacts("o");
	} else if ($numcateg) {//fin if ($numsscateg) 
	    $menuCont=new Menu();
	    $menuCont->type="categorie";
	    $menuCont->nummenu=$numcateg;	
	    $nb_cont=$menuCont->afficherContacts("o");	  
		
	}
	if ($nb_cont) {
	?>
		<div id="colBoxFarRight" class="item">
		 	<div class="sap-content">
			 <div class="titre185">Contact<? if ($nb_cont>1) echo"s";?></div>
			 <?php
			  for ($i=0;$i<count($menuCont->listcontact);$i++) { 
			  	$leContact=	$menuCont->listcontact[$i];
				$pageSpecContact=new Page();
				$pageSpecContact->pageSpecifique("contact");
			?>  
			  <p><strong><?=$leContact->prenom." ".$leContact->nom?></strong><br /> 
			  <?=miseEnForme($leContact->fonction)?><br />
			  <? if($leContact->tel) echo "<span class=\"carreliens\">Tél.&nbsp;".$leContact->tel."</span><br />";?>
			  <a href="index.php?spec=contact&numpage=<?=$pageSpecContact->numpage?>&numrub=<?=$pageSpecContact->numrub?>&numcateg=<?=$pageSpecContact->numcateg?>&numsscateg=<?=$pageSpecContact->numsscateg?>&numcontact=<?=$leContact->numcontact?>&lg=<?=$lg?>" class="carreliens">Envoyer un courriel</a><br /><br /></p>
			  	
			<?php  
			  }// fin du for ($i=0;$i<count($menuCont->listcontact);$i++)
			 ?>
			 <div class="spacer"></div>
			 <?php
			 if (!$laPage->C3) {
			 ?>
			
			</div>
		</div> 
	<?php
			}//fin if (!$laPage->C3)
	}
	/*----------------------------------- COLONNE CONTRIBUTIFS C3 --------------------------------------------------------*/
	if ($laPage->C3) { 
		if (!$nb_cont) {
	?>
	<div id="colBoxFarRight" class="item">
	 	<div class="sap-content">
			 <?php
			 }//fin if (!$nb_cont)
				$listparas=new ListeParagraphes();	
				$listparas->numpage=$laPage->numpage;
				$listparas->colonne=3; 
				$listparas->afficherListeParas();

				foreach ($listparas as $paras) {
				?>
					<p class="titre185"><?=$paras->titrePara?></p>
					<?php
					if ($paras->contenuPara) {
					?>
					<p><?=$paras->contenuPara?></p>
					<? } ?>
					
					<?php
					// les fichiers
					$listfichiers=new ListeFichiers();
					$listfichiers->numpara= $paras->numpara; 
					$nb_fichiers=$listfichiers->afficherListeFichiers();
					if ($nb_fichiers) {
						foreach ($listfichiers as $fichiers) {
					?> 
						  <?php if ($fichiers->libFichier) { ?>
						  <p>
							<a href="ouverturepdf.php?file=<?=$fichiers->nomFichier?>" target="_blank"><?=$fichiers->libFichier?></a>
						  </p>
						  <? } // fin if ($fichiers->libFichier)
						  ?>
						 
					<?php
						}//fin du foreach ($listfichiers as $fichiers) 	 
					}//fin 	if ($nb_fichiers)  
					
					 //les liens (pour mettre un lien sur une photo - l'affichage est realise plus bas)
					$url_lien="";
					$libelle_lien="";
					$fenetre_lien="";
					
					$listliens=new ListeLiens();
					$listliens->numpara= $paras->numpara;
					$nb_liens=$listliens->afficherListeLiens();
					foreach ($listliens as $liens) {
						$url_lien=$liens->urlLien;
						$libelle_lien=$liens->libLien;
						$fenetre_lien=$liens->fenLien;
						break;
					}
					
					// les photos
					$listphotos=new ListePhotos();
					$listphotos->numpara= $paras->numpara; 
					$nb_photos=$listphotos->afficherListePhotos();
					if ($nb_photos) {
						foreach ($listphotos as $photos) {
					?> 
							<?php
							if ($photos->ext=="swf" ) {
							?>
								<script type="text/javascript">
								AC_FL_RunContent( 
								'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','180','height','240','src','photos/<?=$photos->nomPhoto?>','quality','high','pluginspage','http://www.macromedia.com/go/getflashplayer','movie','photos/<?=$photos->nomPhoto?>' 
								); //end AC code
								</script><noscript><object 
								classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" 
								codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" 
								width="180" height="240">
													 <param name="movie" value="photos/<?=$photos->nomPhoto?>" />
													 <param name="quality" value="high" />
													 <embed src="photos/<?=$photos->nomPhoto?>" quality="high" 
								pluginspage="http://www.macromedia.com/go/getflashplayer" 
								type="application/x-shockwave-flash" width="180" height="240"></embed>
												  </object></noscript>

							<?php
							} else {
							?>
								<? if ($url_lien) { 
									  echo "<a href='".$url_lien."'  title=\"".$libelle_lien."\"";
									  if ($fenetre_lien=="o") echo " target='_blank'";
									  echo">"; 
									} 
								 ?>
								<img src="photos/<?=$photos->nomPhoto?>" <?php if (!$url_lien) {?>alt="<? if ($photos->legende) echo $photos->legende;?>" <?php } ?> />
								<? if ($laPage->accueilPage!="o") echo"<br />";?>
								<? if ($url_lien) echo "</a>"; ?>
								
							<?php
							}//fin du else
							
							
							?>
					<?php
						}//fin du foreach ($listphotos as $photos)
					}//fin 	if ($nb_photos)

					//Les vidéos  
					$listvideos=new ListeVideos();
					$listvideos->numpara= $paras->numpara; 
					$nb_videos=$listvideos->afficherListeVideos();
					if ($nb_videos) {
						foreach ($listvideos as $videos) {
					?> 
						   <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="185" height="139" id="FLVPlayer1">
						  <param name="movie" value="FLVPlayer_Progressive.swf" />
						  <param name="salign" value="lt" />
						  <param name="quality" value="high" />
						  <param name="scale" value="noscale" />
						  <param name="FlashVars" value="&MM_ComponentVersion=1&skinName=Clear_Skin_1&streamName=videos/<?=$videos->nomVideo?>&autoPlay=false&autoRewind=true" />
						  <embed src="FLVPlayer_Progressive.swf" flashvars="&MM_ComponentVersion=1&skinName=Clear_Skin_1&streamName=videos/<?=$videos->nomVideo?>&autoPlay=false&autoRewind=true" quality="high" scale="noscale" width="185" height="139" name="FLVPlayer1" salign="LT" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />                 
	</object>
							<?=$videos->legendeVideo?><br />
					<?php
						}//fin du foreach ($listphotos as $photos)
					}//fin 	if ($nb_photos)
					
					//les liens
					$listliens=new ListeLiens();
					$listliens->numpara= $paras->numpara;
					$nb_liens=$listliens->afficherListeLiens();
					
					if ($nb_liens) {
						foreach ($listliens as $liens) {
					?>
						  <?php
						  if ($liens->libLien && $laPage->accueilPage!="o") {
						  ?>
						  <p>
						  	<?php if ($liens->texteLien) echo $liens->texteLien."<br />"; ?>
							<a href="<?=$liens->urlLien?>" <?php if ($liens->fenLien=="o") echo "target='_blank'";?> class="carreliens"><?=$liens->libLien?></a>
						  </p>
						  <? } ?>
					<?php
						}//fin du foreach ($listliens as $liens)  
					} //fin if ($nb_liens)
					?>
				 <div class="spacer"></div>
				<?php
				} //fin du foreach
				?>
		</div>
	</div> 
	<?php
	} // fin if ($laPage->C3) 
}//fin if ($laPage->nomPageGoogle)
	?>