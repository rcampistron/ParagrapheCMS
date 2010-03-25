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

// Les contacts liés à l'espace pro (la categorie)
$nb_cont=0;
$pageSpecExtranetPro=new Page();
$pageSpecExtranetPro->pageSpecifique("extranet-pro");
	
$menuCont=new Menu();
$menuCont->type="categorie";
$menuCont->nummenu=$pageSpecExtranetPro->numcateg;
$nb_cont=$menuCont->afficherContacts("o");	

/*
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
*/
	
	//Mise en page particuliere pour la colonne C3 si 1 seul contenu dedans (contact)
	//mais pas de contenu contributif propre à la page
	// pour eviter de perdre 1 colonne en hauteur
	$divflotte=1;
 
//setlocale(LC_ALL, "french");
		
if ($laPage->nomPageGoogle) { 
?>
<div class="item" id="coltexte785"> 
		   <div class="sap-content">
				<!-- item 1 585 pixels wide -->
				<p class="titre785"><?=$laPage->titrePage?></p>
				<!-- Affichage contact dans une div flottante à droite -->
				<div id="colBoxFarRightFlotte">
				 <div id="colBoxFarRightFlotteint">
				<?php
				// affichage des contacts
				if ($nb_cont) {
				?>
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
						  <a href="index.php?spec=contact&numpage=<?=$pageSpecContact->numpage?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numcontact=<?=$leContact->numcontact?>&lg=<?=$lg?>&type=accespro" class="carreliens">Demander un accès Pro </a><br />
						  <br /></p>
							
						<?php  
						  }// fin du for ($i=0;$i<count($menuCont->listcontact);$i++)
						 ?>
						 <div class="spacer"></div>
						 <?php 
				}//fin if ($nb_cont)
				
				?>
				 <!-- end of colBoxFarRightFlotteint -->
				 </div>
				 <!-- end of colBoxFarRightFlotte -->
				</div>
	
	<!-- Affichage contenu dynamique (provenant du CMS) -->
  <?php
  if (!$_SESSION['numprof'])  {
  ?>
	<?php
				$listparas1=new ListeParagraphes();	
				$listparas1->numpage=$laPage->numpage; 
				if ($laPage->C0) $listparas1->colonne=0;	 else if ($laPage->C1) $listparas1->colonne=1; 
				$listparas1->afficherListeParas();

				foreach ($listparas1 as $paras) {
				
					if ($paras->titrePara) {
						echo "<".$paras->typeTitre.">";
						echo $paras->titrePara;
						echo "</".$paras->typeTitre.">";
					}//fin if ($paras->titrePara)
					
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
							<?php if ($paras->contenuPara) { ?>
							<div class="floatG">
							<? } else { ?>
							<p>
							<? } ?>
							<?php
							if ($photos->ext=="swf" ) {// c'est un flash
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
								if ($url_lien) echo "</a>";
							} else {//c'est une photo / image gif ou jpg
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
							<?php if ($paras->contenuPara) { ?>
							</div>
							<? } else { ?>
							</p>
							<? } ?>
					<?php
						}//fin du foreach ($listphotos as $photos)
					}//fin 	if ($nb_photos)
					 
					if ($paras->contenuPara) {
						if ($paras->listePara=="li") echo miseEnFormeListe($paras->contenuPara); else echo "<p>".$paras->contenuPara."</p>";
					}
					 
					
					// affichage des liens
					if ($nb_liens) {
						//$cpt_lien=0;
						reset($listliens);
						foreach ($listliens as $liens) {
							//if (!$cpt_lien) $url_lien=$liens->urlLien;
					?>
						  <p>
						  	<?php if ($liens->texteLien) echo $liens->texteLien."<br />"; ?>
							<a href="<?=$liens->urlLien?>" <?php if ($liens->fenLien=="o") echo "target='_blank'";?>><?=$liens->libLien?></a>
						  </p>
					<?php
							//$cpt_lien++;
						}//fin du foreach ($listliens as $liens)  
					} //fin if ($nb_liens)

					// les fichiers
					$listfichiers=new ListeFichiers();
					$listfichiers->numpara= $paras->numpara; 
					$nb_fichiers=$listfichiers->afficherListeFichiers();

					if ($nb_fichiers) {
						foreach ($listfichiers as $fichiers) {
					?> 
						  <p>
							<a href="ouverturepdf.php?file=<?=$fichiers->nomFichier?>" target="_blank"><?=$fichiers->libFichier?></a>
						  </p>
						 
					<?php
						}//fin du foreach ($listfichiers as $fichiers) 	 
					}//fin 	if ($nb_fichiers)  

					

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
						}//fin du foreach ($listphotos as $photos)
					}//fin 	if ($nb_photos)
					
				} //fin du foreach
				?>
	
	<br /><br />
  <?php
  } else { // utilisateur connecté - affichage bienvenue
  	$clients=new Client();
	$clients->numclient=$_SESSION['numprof'];
	$clients->infosClient();
  ?>
  <h1>Vous êtes connecté à l'Espace PRO <? if($clients->amont) echo "Amont";?> <? if($clients->aval) echo "Aval";?></h1>
   <p>Si vous changez de section du site, retrouvez le bouton <a href="index.php?spec=<?=$spec?>&numpage=<?=$numpage?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&lg=<?=$lg?>&deconclient=o" class="deconnexion">Se déconnecter</a> situé à droite pour vous déconnecter de l'espace pro.<br /></p>
  <?php
  } // fin else = message d'accueil si utilisateur connecté
  ?>
  <?php
  if (!$_SESSION['numprof'])  {
  ?>
		<?php
		//qui est le contact lie a l'espace pro ?
		$leContact=	$menuCont->listcontact[0];
		
		$pageSpecContactPro=new Page();
		$pageSpecContactPro->pageSpecifique("contact");
		?>
		<table width="579" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="202">&nbsp;</td>
            <td width="377"><strong>Vous disposez d'un accès autorisé à l'Espace Pro, identifiez-vous avec votre compte IFIP<br />
                &nbsp;
</strong></td>
          </tr>
          <tr>
            <td>
              <div align="right">Votre email de connexion  :</div>
            </td>
            <td><input type="text" id="textEmailCpte" name="textEmailCpte" class="public"/></td>
          </tr>
          <tr>
            <td><div align="right">Votre mot de passe   : </div></td>
            <td><input type="password" id="textPwdCpte" name="textPwdCpte" class="public"/></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td> <a href="index.php?spec=oublie&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&lg=<?=$lg?>&type=accespro">mot de passe oublié ?</a>
		  | <a href="index.php?spec=contact&numpage=<?=$pageSpecContactPro->numpage?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&lg=<?=$lg?>&numcontact=<?=$leContact->numcontact?>&type=accespro">demander un accès Pro </a><br /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>
			<input id="validerEsp" name="validerEsp" type="button" class="public bouton" value="Valider" onClick="javascript:validerEspPro()"/>
			</td>
          </tr>
        </table>

		  <!-- 
		  <label for="textPwdCpte">Votre mot de passe  :</label>
		  <input type="password" id="textPwdClient" name="textPwdClient" class="public"/>
		<br />
		-->

		<br /> 
		<br />	
		<br />	
		 <?php
		 $listedoc=new ListeParagraphes();
		 $listedoc->doc=1;
		 $req_doc=" WHERE publiee='o' AND acces_res='o' ORDER BY date DESC LIMIT 0,20";
		 $listedoc->req_doc=$req_doc;
		 $nb_doc=$listedoc->afficherListeParas();
		 if ($nb_doc) {
		 ?> 
		 	<h2>Dernières mises en ligne : </h2>
			<ul>
		 	<?php
			foreach ($listedoc as $paras) {	
				echo"<li>".$paras->titrePara."</li>";
			}
			?>
			</ul>
			<?php
		 }//fin if ($nb_doc)
		 ?>
		<br />
	<input type="hidden" name="numpara" value="<?=$numpara?>"/>
	<input type="hidden" name="numdoc" value="<?=$numdoc?>"/><!-- L'utilisateur vient de la Base Documentaire Ifip, le document est en accès réservé aux professionnels et il est payant => après connexion, il sera redirigé vers le panier -->
<input type="hidden" name="action" />
<!-- Fin affichage contenu non dynamique (provenant du CMS) -->

	
	<?php
	} else if ($_SESSION['numprof'] && $_SESSION['numclient']) {//Le professionnel est connecté
			// Include du moteur de recherche
			include("moteur-recherche-publications-ifip-pro.php");
	}
	?>
  </div>
</div>
<?php
}//fin if ($laPage->nomPageGoogle)
	?>