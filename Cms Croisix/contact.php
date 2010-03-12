<?php /* Date de cration: 13/01/2009*/ 
if ($numcontact) {
	$leContact=new Contact();
	$leContact->numcontact=$numcontact;
	$leContact->infosContact();

}

$laPage = new Page();
$laPage->numpage=$numpage;
$laPage->infosPage();
$laPage->infosColonnes(); 

setlocale(LC_ALL, "french");
		
if ($laPage->nomPageGoogle) { 
?>
<div class="item" id="<?php if ($laPage->C0) echo "coltexte585"; else if ($laPage->C1) echo "coltexte385";?>"> 
		   <div class="sap-content">
				<!-- item 1 585 pixels wide -->
				<p class="<?php if ($laPage->C0) echo "titre585"; else if ($laPage->C1) echo "titre385";?>"><?=$laPage->titrePage?></p>
	<fieldset>

  <legend>Envoyer un message à <? if ($leContact->nom) echo $leContact->prenom." ".$leContact->nom; else {?>L'IFIP - Institut du Porc<? } ?><? if (isset($type) && $type=="accespro") {?> 
  <br />
  pour demander un accès à l'espace pro
  <?php
  } // fin if (isset($type) && $type=="accespro")
  ?>
  </legend>
  <br />
  <?php
  	if (!$_SESSION["numclient"]) {
  ?>
  <p>Si vous disposez d'un compte IFIP, <a href="javascript:MontrerCalque('calqueconnexion');">connectez-vous</a> pour remplir automatiquement le formulaire de contact. </p>
  <div id="calqueconnexion" style="visibility:hidden;height:0">
  <table width="580" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="202">&nbsp;</td>
      <td width="377"><strong>Identifiez-vous avec votre compte IFIP<br />
&nbsp;      </strong></td>
    </tr>
    <tr>
      <td><div align="right">Votre email de connexion  :</div></td>
      <td><input type="text" id="textEmailCpte" name="textEmailCpte" class="public"/></td>
    </tr>
    <tr>
      <td><div align="right">Votre mot de passe   : </div></td>
      <td><input type="password" id="textPwdCpte" name="textPwdCpte" class="public"/></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><a href="index.php?spec=oublie&amp;numrub=<?=$numrub?>&amp;numcateg=<?=$numcateg?>&amp;numsscateg=<?=$numsscateg?>&amp;lg=<?=$lg?>">mot de passe oublié ?</a><br /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input id="validerEsp" name="validerEsp" type="button" class="public bouton" value="Valider" onclick="javascript:validerEspPro()"/>
        <input type="hidden" name="action" value="<?=$action?>" />      </td>
    </tr>
  </table>
  </div>
  <?php 
  	}
  ?>
  &nbsp;<br />
      <?php
	  /* ********************* Pre-remplissage formulaire si client  (ou pro) connecte *********************** */
	  if ($_SESSION["numclient"]) {
	  	$client=new Client();
		$client->numclient=$_SESSION['numclient'];
		$client->infosClient();
	  } else $client=array();
	  ?>
	  
	  <label for="textPrenom">Votre prénom<em class="important">*</em> :</label>
      <input type="text" id="textPrenom" name="textPrenom" class="public" value="<?=$client->prenom?>" />
    <br />
      <label for="textNom">Votre nom<em class="important">*</em> :</label>
      <input type="text" id="textNom" name="textNom" class="public"value="<?=$client->nom?>" />
    <br />
      <label for="textEmail">Votre e-mail <em class="important">*</em> :</label>
      <input type="text" id="textEmail" name="textEmail" class="public" value="<?=$client->email?>" />
	<br />
	  <label for="textSociete">Votre société / organisation<em class="important">*</em> :</label>
      <input type="text" id="textSociete" name="textSociete" class="public" value="<?=$client->raison?>" />
	<br />
	  <label for="textAdr1">Adresse<em class="important">*</em> : </label>
	  &nbsp;<input type="text" name="textAdr1" id="textAdr1" class="public" value="<?=$client->adr1?>" />
	<br />
	  <label for="textAdr2">&nbsp;</label>
	  <input type="text" name="textAdr2" id="textAdr2" class="public" value="<?=$client->adr2?>"  />
	<br />
	  <label for="textCp">Code Postal<em class="important">*</em> : </label>
	  &nbsp;<input type="textCp" id="textCp" name="textCp" class="public" value="<?=$client->cp?>"  />
	 <br />
	   <label for="textVille">Ville<em class="important">*</em> : </label>
	   &nbsp;<input type="text" name="textVille" id="textVille" class="public" value="<?=$client->ville?>"  />
	 <br />
	   <label for="selectPays">Pays<em class="important">*</em> : </label>
	  &nbsp;<select name="selectPays" class="public">
	  <option>Choisir...</option>
		<?php
		$result = mysql_query("SELECT * FROM if_pays ORDER BY pays");
		while ($row=mysql_fetch_array($result)) {
		?>
			<option value="<?=$row['numpays']?>" <?php if ($client->numpays==$row['numpays'] || $row['numpays']=="247") echo "selected='selected'";?>>
			<?=utf8_encode($row['pays'])?></option>
		<?php
		}//fin du while
		?>
	</select>
	<br />
	<label for="textTel">Téléphone<em class="important">*</em> : </label>
	&nbsp;<input name="textTel" type="text" class="public" id="textTel" maxlength="25" value="<?=$client->tel?>" />
	<br />
	<label for="textFax">Fax : </label>
	&nbsp;<input name="textFax" type="text" class="public" id="textFax" maxlength="25" value="<?=$client->fax?>" />
	<br />
      <label for="name">Votre objet<em class="important">*</em> :</label>
      <input type="text" id="name" name="textObjet" class="public" value="<? if ($type=="accespro") echo"Ifip EspacePro/ Demande d'autorisation d'accès"; else if ($type=="infosformation") echo"Ifip Formations/ Demande d'informations";?>" /> 
      <label for="name">Votre message<em class="important">*</em> :</label>
      <textarea id="name" name="textMess" class="public"/></textarea>
    <br /> 
	<br />
	<label for="name">&nbsp;</label>	
	<input id="button" name="validerMess" type="button" class="public" value="Envoyer le message" onClick="javascript:envoyerMess('<?=$type?>')"/>  
<br />		
<input type="hidden" value="<? if($numcontact) echo $numcontact;?>" name="numcontact" />
<!-- gestion differenciee du formulaire selon la valeur de type (accespro) -->
<input type="hidden" name="type" id="type" value="<?=$type?>" />
 </fieldset>
</div>
</div>
<? /*----------------------------------- COLONNE CONTRIBUTIFS C3 --------------------------------------------------------*/?>
	<div id="colBoxFarRight" class="item">
		 <div class="sap-content">
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
			 <div class="titre185">Contact<? if ($nb_cont>1) echo"s";?></div>
			 <?php
			  for ($i=0;$i<count($menuCont->listcontact);$i++) { 
			  	$leContact=	$menuCont->listcontact[$i];
				$pageSpec=new Page();
				$pageSpec->pageSpecifique("contact");
			?>  
			  <p><strong><?=$leContact->genre." ".$leContact->prenom." ".$leContact->nom?></strong><br /> 
			  <?=miseEnForme($leContact->fonction)?><br />
			  <? if($leContact->tel) echo "<span class=\"carreliens\">Tél.&nbsp;".$leContact->tel."</span><br />";?>
			  <a href="index.php?spec=contact&numpage=<?=$pageSpec->numpage?>&numrub=<?=$pageSpec->numrub?>&numcateg=<?=$pageSpec->numcateg?>&numsscateg=<?=$pageSpec->numsscateg?>&numcontact=<?=$leContact->numcontact?>&lg=<?=$lg?>" class="carreliens">Envoyer un courriel  </a><br />
			  <br /></p>
			<?php  
			  }// fin du for 
			  
			 
			 ?>
			

	<?php
			
	}
	
	if ($laPage->C3) { 
	?>
			 <?php
				$listparas=new ListeParagraphes();	
				$listparas->numpage=$laPage->numpage;
				$listparas->colonne=3; 
				$listparas->afficherListeParas();

				foreach ($listparas as $paras) {
				?>
					<div class="titre185"><?=$paras->titrePara?></div>
					<?php
					if ($paras->contenuPara) {
					?>
					<p><?=$paras->contenuPara?></p>
					<? } ?>
					
					<?php
					//les liens
					$listliens=new ListeLiens();
					$listliens->numpara= $paras->numpara;
					$nb_liens=$listliens->afficherListeLiens();
					
					$url_lien="";
					$libelle_lien="";
					$fenetre_lien="";
					
					if ($nb_liens) {
						$cpt_lien=0;
						foreach ($listliens as $liens) {
							if (!$cpt_lien) $url_lien=$liens->urlLien;
							if (!$cpt_lien) $libelle_lien=$liens->libLien;
							if (!$cpt_lien) $fenetre_lien=$liens->fenLien;
					?>
						  <?php
						  if ($liens->libLien) {
						  ?>
						  <p>
						  	<?php if ($liens->texteLien) echo $liens->texteLien."<br />"; ?>
							<a href="<?=$liens->urlLien?>" <?php if ($liens->fenLien=="o") echo "target='_blank'";?>><?=$liens->libLien?></a>
						  </p>
						  <? } ?>
					<?php
							$cpt_lien++;
						}//fin du foreach ($listliens as $liens)  
					} //fin if ($nb_liens)
					
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
									  echo "<a href='".$url_lien."' title=\"".$libelle_lien."\"";
									  if ($fenetre_lien=="o") echo " target='_blank'";
									  echo">"; 
									} 
								 ?>
								<img src="photos/<?=$photos->nomPhoto?>" <?php if (!$url_lien) {?>alt="<? if ($photos->legende) echo $photos->legende; ?>" <?php } ?>/> <br />
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
							<div class="positionnement">
							<p>&nbsp;</p>
							<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="320" height="240" id="FLVPlayer1">
						  <param name="movie" value="FLVPlayer_Progressive.swf" />
						  <param name="salign" value="lt" />
						  <param name="quality" value="high" />
						  <param name="scale" value="noscale" />
						  <param name="FlashVars" value="&MM_ComponentVersion=1&skinName=Clear_Skin_1&streamName=videos/<?=$videos->nomVideo?>&autoPlay=false&autoRewind=true" />
						  <embed src="FLVPlayer_Progressive.swf" flashvars="&MM_ComponentVersion=1&skinName=Clear_Skin_1&streamName=videos/<?=$videos->nomVideo?>&autoPlay=false&autoRewind=true" quality="high" scale="noscale" width="320" height="240" name="FLVPlayer1" salign="LT" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />                 
	</object>
							<?=$videos->legende?><br />
							</div>
					<?php
						}//fin du foreach ($listvideos as $videos)
					}//fin 	if ($nb_videos)
					?>
				 <div class="spacer"></div>
				<?php
				} //fin du foreach
				?>
	<?php
	} // fin if ($laPage->C3) 
	?>
		</div>
	</div> 	
<?php	
}//fin if ($laPage->nomPageGoogle)
?>
