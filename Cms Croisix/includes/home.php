<?php
/**
 * @file home.php
 * @brief Contient l'accueil du site
 * @details Est inclu dans @ref index.php. Lorsque pg_admin = home. 
 * 
 */
$laPage = new Page(); 
if ($numpage) {
	$laPage->numpage=$numpage;
	$laPage->infosPage();
	$laPage->infosColonnes(); 
}
?>
<link rel="stylesheet" href="/assets/SpryMenuBarHorizontal.css" type="text/css" />

<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>

<div id="indexPhoto" class="line">
      <div id="anim" class="item">
        <div class="sap-content">
		<script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','770','height','175','src','images/anim-accueil','quality','high','pluginspage','http://www.macromedia.com/go/getflashplayer','wmode','transparent','movie','images/anim-accueil' ); //end AC code
</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="770" height="175">
          <param name="movie" value="images/anim-accueil.swf" />
          <param name="quality" value="high" />
		  <param name="wmode" value="transparent" />
          <embed src="images/anim-accueil.swf" width="770" height="175" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent"></embed>
		  </object>
</noscript>
		<!--<img src="images/index.jpg" />--></div>
      </div>
      <div id="colBoxFarRightHome" class="item">
        <div class="sap-content">
          <p><strong>Extranet Génétique</strong><br />
            Réservé aux professionnels de la génétique porcine<br />
            <a href="../PagesStatics/genetique/gene/index.html" target="_blank">se connecter</a></p>
          <p><strong>Espace Pro</strong><br />
            Pour accéder aux documentations réservées aux professionnels de la filière <br />
			<a href="extranet-pro.html">se connecter</a><br />
			<?php
			
			//on recherche les infos de la page contact
			$pageSpecContactPro=new Page();
			$pageSpecContactPro->pageSpecifique("contact");
			
			//on recherche les infos (numrub, numcateg, numsscateg) de la page espace pro
			$pageSpecExtranetPro=new Page();
			$pageSpecExtranetPro->pageSpecifique("extranet-pro");
			
			//qui est le contact lie a l'espace pro ?
			$menuCont=new Menu();
			$menuCont->type="categorie";
			$menuCont->nummenu=$pageSpecExtranetPro->numcateg;
			$nb_cont=$menuCont->afficherContacts("o");
			$leContact=	$menuCont->listcontact[0]; //numcontact=16
			
			
			?>
            <a href="index.php?spec=<?=$pageSpecContactPro->nomFichier?>&numpage=<?=$pageSpecContactPro->numpage?>&numrub=<?=$pageSpecExtranetPro->numrub?>&numcateg=<?=$pageSpecExtranetPro->numcateg?>&numsscateg=<?=$pageSpecExtranetPro->numsscateg?>&numcontact=<?=$leContact->numcontact?>&lg=<?=$lg?>&type=accespro">demander un accès Pro</a></p>
        </div>
      </div>
</div>
    <!-- end of header -->
    <!-- spacer -->
    <div class="line">
      <div id="leftIndex" class="item">
        <div class="sap-content">&nbsp;<br/>
        </div>
      </div>
    </div>
    <!-- contenu  -->
    <div class="line">
      <div id="leftIndex" class="item">
        <div class="sap-content"><img src="images/carre_rouge.gif" width="15" height="15" class="redsquare" /><h1>Bienvenue sur le portail de l'Ifip</h1>
          <p class="indexplusgrand">L'IFIP - Institut du porc anticipe, fédère et accompagne les professionnels de la filière porcine. Organisme de Recherche & Développement, il met au service des acteurs économiques son expérience et ses compétences ainsi qu’un réseau de partenaires, ouvert vers l’international.</p>
		  <p class="indexplusgrand">&nbsp;<br />
	      <strong>Nos Prestations  :</strong></p>
		  <p class="indexplusgrand"><a href="diagnostic-audit-pour-entreprises-filiere-porc.html" class="carreliens">diagnostics et audits en élevage</a> : les experts Ifip à vos côtés</p>
		  <p class="indexplusgrand"><a href="formations-ifip-institut-du-porc.html" class="carreliens">formation</a> sur l'ensemble de nos <a href="ifip-institut-du-porc-domaines-expertises.html">domaines d'expertise</a></p>
		  <p class="indexplusgrand"><a href="realisation-etudes-experimentations-productions-porcines.html" class="carreliens">expertises</a> en hygiène des aliments</p>
		  <hr />
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="168"><h2>Publications</h2>
	<?php
	$pageSpec=new Page();
	$pageSpec->pageSpecifique("publications-ifip-institut-du-porc");
	?>
     <a href="index.php?spec=<?=$pageSpec->nomFichier?>&numpage=<?=$pageSpec->numpage?>&numrub=<?=$pageSpec->numrub?>&numcateg=<?=$pageSpec->numcateg?>&numsscateg=<?=$pageSpec->numsscateg?>&lg=<?=$pageSpec->lg?>"><img src="images/p-index-documentation.jpg" alt="" width="170" height="170" border="0" /></a></td>
    <td><img src="images/im-blanc.gif" alt="" width="1" height="160" /></td>
    <td><p class="indexplusgrand"><a href="publications-ifip-institut-du-porc.html" class="carreliens">Base documentaire </a></p>
	  <p class="indexplusgrand"><a href="newsletters-ifip-institut-du-porc.html" class="carreliens">Lettres électroniques</a></p>
	<p class="indexplusgrand"><a href="techniporc-barometre-porc.html" class="carreliens">Revues de l'IFIP</a></p>
	<p class="indexplusgrand"><a href="catalogue-des-editions-ifip-institut-du-porc.html" class="panier">Catalogue des éditions</a></p>
    <br />
    <h2>Dernières publications</h2>
	<div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<?php
					//Les 3 derniers OUVRAGES de reference (parmi les ouvrages a la une)
					$nb_doc=0;
					$dernieresParu=new ListeParagraphes();
					$dernieresParu->doc=1;
					$dernieresParu->req_doc=" WHERE  publiee='o' AND acces_res!='o' AND type_doc='5' AND une='o' 
					ORDER BY date DESC LIMIT 0,3";
				    $nb_doc=$dernieresParu->afficherListeParas();
				    if ($nb_doc) {
	?>
					
	
	<?php
						foreach ($dernieresParu as $paras) {	
							$pageSpec=new Page();
							$pageSpec->pageSpecifique("catalogue-ifip-institut-du-porc");
							
							//pour type_doc, il suffit d'utiliser l'attribut  type_doc de l'objet Documentation, soit dans la page home.php : $paras->type_doc
					?>
						 <tr>
       					 <td width="1%" class="sanspadding"><span class="carreliens">&nbsp;</span></td>
						 <td width="99%" class="sanspadding"><span class="petit"><a href="index.php?spec=<?=$pageSpec->nomFichier?>&numpage=<?=$pageSpec->numpage?>&numrub=<?=$pageSpec->numrub?>&numcateg=<?=$pageSpec->numcateg?>&numsscateg=<?=$pageSpec->numsscateg?>&lg=<?=$pageSpec->lg?>&numpara=<?=$paras->numpara?>"><strong><?=$paras->titrePara?></strong></a></span>						 </td>
						 </tr>
					<?php
						}//fin  de foreach ($dernieresParu as $paras)
					}//fin if ($nb_doc)
					
					//Les 2 dernieres PUBLICATIONS
					$nb_doc=0;
					$dernieresParu=new ListeParagraphes();
					$dernieresParu->doc=1;
					$dernieresParu->req_doc=" WHERE  publiee='o' AND acces_res!='o' AND type_doc!='5' 
					ORDER BY date DESC LIMIT 0,2";
				    $nb_doc=$dernieresParu->afficherListeParas();
				    if ($nb_doc) {
	?>
					
	
	<?php
						foreach ($dernieresParu as $paras) {	
							$pageSpecPublis=new Page();
							$pageSpecPublis->pageSpecifique("publications-ifip-institut-du-porc");
							
							//pour type_doc, il suffit d'utiliser l'attribut  type_doc de l'objet Documentation, soit dans la page home.php : $paras->type_doc
					?>
						 <tr>
       					 <td width="1%" class="sanspadding"><span class="carreliens">&nbsp;</span></td>
						 <td width="99%" class="sanspadding"><span class="petit"><a href="index.php?spec=<?=$pageSpecPublis->nomFichier?>&numpage=<?=$pageSpecPublis->numpage?>&numrub=<?=$pageSpecPublis->numrub?>&numcateg=<?=$pageSpecPublis->numcateg?>&numsscateg=<?=$pageSpecPublis->numsscateg?>&lg=<?=$pageSpecPublis->lg?>&numpara=<?=$paras->numpara?>"><strong><?=$paras->titrePara?></strong></a></span>						 </td>
						 </tr>
					<?php
						}//fin  de foreach ($dernieresParu as $paras)
					}//fin if ($nb_doc)
					?>
	
	
	</table>
	</div>
	 </td>
  </tr>
</table>
<div class="spacer"></div>
<!-- DEBUT du contenu provenant du CMS en colonne de gauche C1 -->
	<?php
	$listparas1=new ListeParagraphes();	
	$listparas1->numpage=$laPage->numpage; 
	$listparas1->colonne="1"; 
	$listparas1->afficherListeParas();

	foreach ($listparas1 as $paras) {
		$url_lien="";
		
		if ($paras->titrePara) {
			echo "<".$paras->typeTitre.">";
			echo $paras->titrePara;
			echo "</".$paras->typeTitre.">";
		}//fin if ($paras->titrePara)
		
		//les liens (pour mettre un lien sur une photo - l'affichage est realise plus bas)
		$listliens=new ListeLiens();
		$listliens->numpara= $paras->numpara;
		$nb_liens=$listliens->afficherListeLiens();
		foreach ($listliens as $liens) {
			$url_lien=$liens->urlLien;
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
				<p align="center">
				<? } ?>
				<?php
				if ($photos->ext=="swf" ) {// c'est un flash
				?>
					<script type="text/javascript">
					AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','180','height','240','src','photos/<?=$photos->nomPhoto?>','quality','high','pluginspage','http://www.macromedia.com/go/getflashplayer','movie','photos/<?=$photos->nomPhoto?>' ); //end AC code  
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
					<? //if ($url_lien) echo "<a href='".$url_lien."' target='_blank'>"; ?>
					<a href="indicateurs-et-previsions-marches-porc.html"><img src="photos/<?=$photos->nomPhoto?>" alt="<?=$photos->legende?>" border="0"/></a><br />
					<? //if ($url_lien) echo "</a>"; ?>
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
				<a href="fichiers/<?=$fichiers->nomFichier?>" target="_blank"><?=$fichiers->libFichier?></a>
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
		?>
		<div class="spacer"></div>
	<?php
	} //fin du foreach ($listparas1 as $paras) 
	?>
<!-- FIN  du contenu provenant du CMS en colonne de gauche C1 -->

        </div>
      </div>
      <div id="middleIndex" class="item">
        <div class="sap-content">
          <p class="titreindex">Veille internationale</p>
          <?php
			$listebreves=new ListeParagraphes();
			$listebreves->breve=1;
			$req_breve=" ORDER BY date DESC LIMIT 0,1";
			$listebreves->req_breve=$req_breve;
  			$nb_breves=$listebreves->afficherListeParas(); 
			//$cpt_breves=0;
			
			if ($nb_breves) { 
		  ?>
		  <?php
		  		foreach ($listebreves as $paras) {
				  
				  echo"<p>"; // padding-left de 13px - line height, plus petit que indexplusgrand
				  echo iconv('ISO-8859-1', 'UTF-8',(strftime("%d %B %Y",$paras->datebrut)));
				  //echo strftime("%d %B %Y",$paras->datebrut);
				  echo" | ";
				  echo "<span class=\"source\">".$paras->source."</span>";
				  echo"</p>";
				  if ($paras->titrePara) {
					echo "<p><strong>";
					echo $paras->titrePara;
					echo "</strong></p>";
				  }//fin if ($paras->titrePara)
				  $pageSpec=new Page();
				  $pageSpec->pageSpecifique("veille-economique-internationale-production-viande-porc");
				  //if (!$cpt_breves) {
		?>
			<div class="positionnement">
				<p class="indexplusgrand"><? echo substr($paras->contenuPara,0,300);?>... <span class="petit"><a href="index.php?spec=veille-economique-internationale-production-viande-porc&numpage=<?=$pageSpec->numpage?>&numrub=<?=$pageSpec->numrub?>&numcateg=<?=$pageSpec->numcateg?>&numsscateg=<?=$pageSpec->numsscateg?>&numpays=<?=$paras->numpays?>&lg=<?=$lg?>">Lire la suite</a>&nbsp;|&nbsp;<a href="veille-economique-internationale-production-viande-porc.html">Toute l'actualité éco à l'international</a></span></p>
			</div>
			<div style="margin-bottom:5px;"></div> 
			<table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="13" class="sansmarge"><img src="../images/carre-liens.gif" alt="" width="5" height="5" style="margin-top:5px" /></td>
                <td class="sansmarge petit">Pour vous accompagner dans votre développement, l’Ifip met à votre service une <a href="veille-economique-internationale-production-viande-porc.html">veille économique internationale</a></td>
              </tr>
          </table>
				<?php
					//}//fin if (!$cpt_breves)
					//$cpt_breves++;
				}//fin du foreach ($listebreves as $paras) 
				?>
		  <? } // fin if ($nb_breves)
		  ?>
	      <hr />
		  <h2>Conjoncture de la filière : les indicateurs</h2>
		  <table>
		  <tr>
		  <td>
		  <?php
		  /****** On va chercher les 4 premières images de la page "Indicateurs Conjoncture" ********************/
		  $pageInd=new Page();
		  $pageInd->aliasPage="indicateurs-et-previsions-marches-porc.html";//<------------- ATTENTION, ce nom de fichier ne doit pas être modifié.
		  $numpage_ind=$pageInd->rechercherNumPage();
		  $listparas_ind=new ListeParagraphes();	
		  $listparas_ind->numpage=$numpage_ind;
		  $listparas_ind->afficherListeParas();
		  foreach ($listparas_ind as $paras) {
		  	$listimg= new ListePhotos();
			$listimg->numpara=$paras->numpara;
			$listimg->afficherListePhotos();
			foreach ($listimg as $photos)  {
				$imgInd[]=$photos->nomPhoto;
			}
		  }
		  //print_r($imgInd);
		  //La liste des img est dans le tableau $imgInd - prendre les 4 premières  $imgInd[0], $imgInd[1], $imgInd[2], $imgInd[3]
		  ?>
		  
		  <div id="prixaliment"><a href="indicateurs-et-previsions-marches-porc.html"><img src="photos/<?=$imgInd[1]?>" /></a></div>
		  <div id="prixporc" style="visibility:hidden;height:0px;"><a href="indicateurs-et-previsions-marches-porc.html"><img src="photos/<?=$imgInd[2]?>" /></a></div>
		  <div id="prixpieces" style="visibility:hidden;height:0px;"><a href="indicateurs-et-previsions-marches-porc.html"><img src="photos/<?=$imgInd[3]?>" /></a></div>
		  <div id="prixdetail" style="visibility:hidden;height:0px;"><a href="indicateurs-et-previsions-marches-porc.html"><img src="photos/<?=$imgInd[4]?>" /></a></div>
		  </td>
		  <td>
		  <br />
		  <span class="petit">Choisir un indicateur ci-dessous :</span><br />
		  <p class="indexplusgrand">
		    <a href="javascript:CacherCalque('prixporc','prixpieces','prixdetail');MontrerCalque('prixaliment');" class="carreliens petit">Prix de l'aliment </a><br />
            <a href="javascript:CacherCalque('prixaliment','prixpieces','prixdetail');MontrerCalque('prixporc');" class="carreliens petit">Prix du porc</a><br />
		  <a href="javascript:CacherCalque('prixaliment','prixporc','prixdetail');MontrerCalque('prixpieces');" class="carreliens petit">Prix des pièces</a><br /><a href="javascript:CacherCalque('prixaliment','prixporc','prixpieces');MontrerCalque('prixdetail');" class="carreliens petit">Prix au détail</a>
		  </p>
		  </td>
		  </tr>
		  </table>
		  <p><a href="indicateurs-et-previsions-marches-porc.html" class="carreliens petit">Consultez aussi la rubrique Marchés</a></p>	
		  <div class="spacer"></div>		  
<!-- DEBUT du contenu provenant du CMS en colonne de droite C2 -->
<?php
				$listparas2=new ListeParagraphes();	
				$listparas2->numpage=$laPage->numpage;
				$listparas2->colonne=2;
				$listparas2->afficherListeParas();

				foreach ($listparas2 as $paras) {
					if ($paras->titrePara) {
						if ($laPage->accueilPage=="o") echo "<div class='titre185'>"; else  echo "<".$paras->typeTitre.">";
						echo $paras->titrePara;
						if ($laPage->accueilPage=="o") echo "</div>"; else echo "</".$paras->typeTitre.">";
					}//fin if ($paras->titrePara)
					
					if ($paras->contenuPara) {
						if ($paras->listePara=="li") echo miseEnFormeListe($paras->contenuPara); else echo "<p>".$paras->contenuPara."</p>";
					}
					
					//les liens
					$listliens=new ListeLiens();
					$listliens->numpara= $paras->numpara;
					$nb_liens=$listliens->afficherListeLiens();
					
					$url_lien="";
					
					if ($nb_liens) {
						$cpt_lien=0;
						foreach ($listliens as $liens) {
							if (!$cpt_lien) $url_lien=$liens->urlLien;
							if (!$cpt_lien) $libelle_lien=$liens->libLien;
							if (!$cpt_lien) $fenetre_lien=$liens->fenLien;
					?>
						  <?php
						  if ($liens->libLien && $laPage->accueilPage!="o") {
						  ?>
						  <p>
						  	<?php if ($liens->texteLien) echo $liens->texteLien."<br />"; ?>
							<a href="<?=$liens->urlLien?>" <?php if ($liens->fenLien=="o") echo "target='_blank'";?>><?=$liens->libLien?></a>
						  </p>
						  <? } // fin if ($liens->libLien)?>
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
						 <p>
							<a href="fichiers/<?=$fichiers->nomFichier?>" target="_blank"><?=$fichiers->libFichier?></a>
		  </p>
						 
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
								AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','180','height','240','src','photos/<?=$photos->nomPhoto?>','quality','high','pluginspage','http://www.macromedia.com/go/getflashplayer','movie','photos/<?=$photos->nomPhoto?>' ); //end AC code
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
									  echo "<a href='".$url_lien."' title='".$libelle_lien."'";
									  if ($fenetre_lien=="o") echo " target='_blank'";
									  echo">"; 
									} 
								 ?>
								<div class="positionnement"><img src="photos/<?=$photos->nomPhoto?>" alt="<? if ($photos->legende) echo $photos->legende; 
								else if ($libelle_lien) echo $libelle_lien?>" /> <br />
								<? if ($url_lien) echo "</a>"; ?>
								</div>
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
						   <p>
							<a href="videos/<?=$videos->nomVideo?>" target="_blank"><?=$videos->nomVideo?></a>
							<?=$videos->legende?><br />
						  </p>
					<?php
						}//fin du foreach ($listphotos as $photos)
					}//fin 	if ($nb_photos)
					?>
				<div class="spacer"></div>
				<?php
				} //fin du foreach ($listparas2 as $paras)
				
				// Les fiches actions liées à la catégorie ou sous-catégorie (domaines d'expertise)
				$nb_fiches=0;
				$tri_date=" AND publiee='o' AND type_doc='1'";
				if ($numsscateg) {
				   $menuDoc=new Menu();
				   $menuDoc->type="sscateg";
				   $menuDoc->nummenu=$numsscateg;	
				   $menuDoc->tri_date=$tri_date;
				   $nb_fiches=$menuDoc->afficherDocs();
				} else if ($numcateg) {//fin if ($numsscateg) 
					$menuDoc=new Menu();
					$menuDoc->type="categ";
					$menuDoc->nummenu=$numcateg;
					$menuDoc->tri_date=$tri_date;	
					$nb_fiches=$menuDoc->afficherDocs();	  
					
				}
				
				if ($nb_fiches) {
				?>
					<h2>Nos actions R&D </h2>
				    <?php
					for ($i=0;$i<count($menuDoc->listdoc);$i++) { 
							$laDoc=$menuDoc->listdoc[$i];
							$fiche=new ListeFichiers();
							$fiche->numpara= $laDoc->numpara; 
							$fiche->afficherListeFichiers();
							foreach ($fiche as $fichiers) {
								$nom_fiche=$fichiers->nomFichier;
								break;
							}
						  if ($nom_fiche) {
						  ?>
							<p><a href="fichiers/<?=$nom_fiche?>" target="_blank"><?=$laDoc->titrePara?></a></p>
						  <?php
						  }//fin if ($nom_fiche) 
						  ?>
						<?php 
					 }//fin for ($i=0;$i<count($menuDoc->listdoc);$i++)
				}//fin if ($nb_doc)
				?>		  
<!-- FIN  du contenu provenant du CMS en colonne de droite C2 -->	
	  
        </div>
	  </div>	
      
<!-- DEBUT  du contenu associé provenant du CMS en colonne C3 -->
		  
	  <div id="colBoxFarRight" class="item">
		 	<div class="sap-content">	
	<?php
	// Les formations liées à la catégorie ou sous-catégorie
	$nb_forma=0;
	$tri_date=" AND sur_mesure!='o' AND date_deb>=".time()." ORDER BY date_deb";
	if ($numsscateg) {
	   $menuForma=new Menu();
	   $menuForma->type="sscateg";
	   $menuForma->nummenu=$numsscateg;	
	   $menuForma->tri_date=$tri_date;
	   $nb_forma=$menuForma->afficherFormations();
	} else if ($numcateg) {//fin if ($numsscateg) 
	    $menuForma=new Menu();
	    $menuForma->type="categ";
	    $menuForma->nummenu=$numcateg;
		$menuForma->tri_date=$tri_date;	
	    $nb_forma=$menuForma->afficherFormations();	  
		
	}
	if ($nb_forma) {
	?>
			 <div class="titre185">Formations</div>
			 <?php
			  	$laForma=$menuForma->listforma[0];
				$pageSpec=new Page();
				$pageSpec->pageSpecifique("formations-ifip");
			 	
			?>  
			  <p><strong>Prochaine session</strong></p> 
			  <p><?=$laForma->titrePara?></p> 
			  <p>Dates : <?php if ($laForma->datefin) echo "du ".$laForma->datedeb." au ".$laForma->datefin; else echo $laForma->datedeb;?> </p>
			  <p>
			  <a href="index.php?spec=formation-inscription&numpage=<?=$pageSpec->numpage?>&numrub=<?=$pageSpec->numrub?>&numcateg=<?=$pageSpec->numcateg?>&numsscateg=<?=$pageSpec->numsscateg?>&numcontact=<?=$leContact->numcontact?>&lg=<?=$lg?>" class="carreliens">S'inscrire</a></p>	
			   <p><a href="index.php?spec=formations-ifip&numpage=<?=$pageSpec->numpage?>&numrub=<?=$pageSpec->numrub?>&numcateg=<?=$pageSpec->numcateg?>&numsscateg=<?=$pageSpec->numsscateg?>&lg=<?=$lg?>" class="carreliens">Toutes les formations</a></p>
			   <div class="spacer"></div>
			<?php  
	}//fin if ($nb_forma)
	
	// Les documentations liées à la catégorie ou sous-catégorie
	$nb_doc=0;
	$tri_date=" AND publiee='o' AND type_doc!='1'";
	if ($numsscateg) {
	   $menuDoc=new Menu();
	   $menuDoc->type="sscateg";
	   $menuDoc->nummenu=$numsscateg;	
	   $menuDoc->tri_date=$tri_date;
	   $nb_doc=$menuDoc->afficherDocs();
	} else if ($numcateg) {//fin if ($numsscateg) 
	    $menuDoc=new Menu();
	    $menuDoc->type="categ";
	    $menuDoc->nummenu=$numcateg;
		$menuDoc->tri_date=$tri_date;	
	    $nb_doc=$menuDoc->afficherDocs();	  
		
	}
	
	if ($nb_doc) {
	?>
		<div class="titre185">Documentation</div>
	<?php
		for ($i=0;$i<count($menuDoc->listdoc);$i++) { 
				$laDoc=$menuDoc->listdoc[$i];
				$fiche=new ListeFichiers();
				$fiche->numpara= $laDoc->numpara; 
				$fiche->afficherListeFichiers();
				foreach ($fiche as $fichiers) {
					$nom_fiche=$fichiers->nomFichier;
					break;
				}
			  if ($nom_fiche) {
			  ?>
			  	<p><a href="fichiers/<?=$nom_fiche?>" target="_blank" class="carreliens"><?=$laDoc->titrePara?></a></p>
			  <?php
			  }//fin if ($nom_fiche) 
			  ?>
			<?php 
		 }//fin for ($i=0;$i<count($menuDoc->listdoc);$i++)
		 ?>
		 <div class="spacer"></div>
		 <?php
	}//fin if ($nb_doc)
	
	// Les contacts liés à la catégorie ou sous-catgorie
	$nb_cont=0;
	if ($numsscateg) {
	   $menuCont=new Menu();
	   $menuCont->type="sscateg";
	   $menuCont->nummenu=$numsscateg;	
	   $nb_cont=$menuCont->afficherContacts();
	} else if ($numcateg) {//fin if ($numsscateg) 
	    $menuCont=new Menu();
	    $menuCont->type="categorie";
	    $menuCont->nummenu=$numcateg;	
	    $nb_cont=$menuCont->afficherContacts();	  
		
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
			  <p><strong><?=$leContact->prenom." ".$leContact->nom?></strong><br /> 
			  <?=miseEnForme($leContact->fonction)?><br />
			  <? if($leContact->tel) echo $leContact->tel."<br />";?>
			  <a href="index.php?spec=contact&numpage=<?=$pageSpec->numpage?>&numrub=<?=$pageSpec->numrub?>&numcateg=<?=$pageSpec->numcateg?>&numsscateg=<?=$pageSpec->numsscateg?>&numcontact=<?=$leContact->numcontact?>&lg=<?=$lg?>" class="carreliens">Envoyer un courriel</a><br /><br /></p>
			  	
			<?php  
			  }// fin du for ($i=0;$i<count($menuCont->listcontact);$i++)
			 ?>
			 <div class="spacer"></div>
			 <?php 
	}//fin if ($nb_cont)
  
  //Les brèves d'actualités
  $nb_actus=0;
  $listactus= new ListeParagraphes();
  $listactus->actu="o";
  $listactus->req_actu=" WHERE accueil='o' ORDER BY numpara DESC";
  $nb_actus=$listactus->afficherListeParas();
  if ($nb_actus) {
  ?>
	  <div class="titre185">Actualités</div>
	  <?php
	  $pageSpecActus=new Page();
	  $pageSpecActus->pageSpecifique("actualites-filiere-production-porc");
	  
	  foreach ($listactus as $paras) {
	  ?>
		  <p>
			<strong><?=$paras->titrePara?></strong>
		  </p>
		  <?php
			//les liens (pour mettre un lien sur une photo - l'affichage est realise plus bas)
			$listliens=new ListeLiens();
			$listliens->numpara= $paras->numpara;
			$nb_liens=$listliens->afficherListeLiens();
			
			$url_lien="";
			$libelle_lien="";
			$fenetre_lien="";
			
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
					if ($url_lien) {
						echo "<a href='".$url_lien."'  title=\"".$libelle_lien."\"";
						if ($fenetre_lien=="o") echo " target='_blank'";
						echo">";
					}
					?>
					<img src="photos/<?=$photos->nomPhoto?>" alt="<?=$photos->legende?>" /> <br />
					<?php
					if ($url_lien) echo "</a>";
					?>
			<?php
				}//fin du foreach ($listphotos as $photos)
			}//fin 	if ($nb_photos)
			 
			if ($paras->contenuPara) {
				echo "<p class=\"marge5\">".substr($paras->contenuPara,0,108);
				echo"... </strong></strong><a href=\"index.php?spec=".$pageSpecActus->nomFichier."&numpage=".$pageSpecActus->numpage."&numrub=".$pageSpecActus->numrub."&numcateg=".$pageSpecActus->numcateg."&numsscateg=".$pageSpecActus->numsscateg."&lg=".$pageSpecActus->lg."&numpara=".$paras->numpara."\">Lire la suite</a>";
				
			}
			 
			
			// affichage des liens
			if ($nb_liens) {
				reset($listliens);
				foreach ($listliens as $liens) {
			?>
				  <br />
					<?php if ($liens->texteLien) echo $liens->texteLien."<br />"; ?>
					<a href="<?=$liens->urlLien?>" <?php if ($liens->fenLien=="o") echo "target='_blank'";?>><?=$liens->libLien?></a>
			<?php
				}//fin du foreach ($listliens as $liens)  
			} //fin if ($nb_liens)
			echo "</p>";
	  }//fin du foreach ($listactus as $paras) 
	  ?>
	 <div class="spacer"></div>
<?php
}//fin if ($nb_actus>=1) {


		
	/*----------------------------------- COLONNE CONTRIBUTIFS C3 --------------------------------------------------------*/
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
					// les fichiers
					$listfichiers=new ListeFichiers();
					$listfichiers->numpara= $paras->numpara; 
					$nb_fichiers=$listfichiers->afficherListeFichiers();
					if ($nb_fichiers) {
						foreach ($listfichiers as $fichiers) {
					?> 
						  <?php if ($fichiers->libFichier) { ?>
						  <p>
							<a href="fichiers/<?=$fichiers->nomFichier?>" target="_blank"><?=$fichiers->libFichier?></a>
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
								AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','180','height','240','src','photos/<?=$photos->nomPhoto?>','quality','high','pluginspage','http://www.macromedia.com/go/getflashplayer','movie','photos/<?=$photos->nomPhoto?>' ); //end AC code
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
									  echo "<a href='".$url_lien."' title='".$libelle_lien."'";
									  if ($fenetre_lien=="o") echo " target='_blank'";
									  echo">"; 
									} 
								 ?>
								<img src="photos/<?=$photos->nomPhoto?>" alt="<? if ($photos->legende) echo $photos->legende; 
								else if ($libelle_lien) echo $libelle_lien?>" />
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
					
					$url_lien="";
					
					if ($nb_liens) {
						$cpt_lien=0;
					?>
					<ul class="listecarres">
					<?php
						foreach ($listliens as $liens) {
							if (!$cpt_lien) $url_lien=$liens->urlLien;
							if (!$cpt_lien) $libelle_lien=$liens->libLien;
							if (!$cpt_lien) $fenetre_lien=$liens->fenLien;
					?>
						  <?php
						  if ($liens->libLien && $laPage->accueilPage!="o") {
						  ?>
						  <li class="listecarres">
						  	<?php if ($liens->texteLien) echo $liens->texteLien."<br />"; ?>
							<a href="<?=$liens->urlLien?>" <?php if ($liens->fenLien=="o") echo "target='_blank'";?>><?=$liens->libLien?></a>
						  </li>
						  <? } ?>
					<?php
							$cpt_lien++;
						}//fin du foreach ($listliens as $liens) 
					?>
					</ul>
					<?php
					} //fin if ($nb_liens)
					?>
				 <p style="background-color:#FFFFFF">&nbsp;<br /></p>
				<?php
				} //fin du foreach

	} // fin if ($laPage->C3) 
?>
	</div>
</div>
    </div>
    <!---fin div class="line"--->
    <!-- end contenu home page -->