<?php
/**
 * @file home_en.php
 * @brief Contient l'accueil du site en anglais
 * @details Est inclu dans @ref index.php. Lorsque pg_admin = home et lg=en. 
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
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','770','height','175','src','images/anim-accueil','quality','high','pluginspage','http://www.macromedia.com/go/getflashplayer','movie','images/anim-accueil' ); //end AC code
</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="770" height="175">
          <param name="movie" value="images/anim-accueil.swf" />
          <param name="quality" value="high" />
          <embed src="images/anim-accueil.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="770" height="175"></embed>
		  </object></noscript>
		<!--<img src="images/index.jpg" />--></div>
      </div>
      <div id="colBoxFarRightHome" class="item">
        <div class="sap-content">
          <p><strong>Extranet Génétique</strong><br />
            Réservé aux professionnels de la génétique porcine<br />
            <a href="http://www.ifip.asso.fr/genetique/gene/index.html" target="_blank">se connecter</a></p>
          <p><strong>Espace Pro</strong><br />
            Réservé aux professionnels du secteur des viandes fraîches et produits transformés<br />
			<a href="extranet-pro.html">se connecter</a><br />
            <a href="index.php?spec=contact&numpage=79&numrub=8&numcateg=&numsscateg=&numcontact=16&lg=fr">demander un mot de passe</a></p>
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
        <div class="sap-content"><img src="images/carre_rouge.gif" width="15" height="15" class="redsquare" /><h1>Bienvenue sur le portail de l'Ifip IN ENGLISH</h1>
          <p class="indexplusgrand">L'IFIP - Institut du Porc anticipe, fédère et accompagne les professionnels de la filière porcine. Opérateur de Recherche & Développement, l'Institut apporte des réponses opérationnelles aux acteurs économiques de la filière : éleveurs, fabricants d’aliments, organisations de génétique, vétérinaires, abatteurs-découpeurs, industriels et artisans de la transformation.</p>
		  <p class="indexplusgrand"><strong>Prestations Ifip :</strong></p>
		  <p class="indexplusgrand"><a href="diagnostic-audit-pour-entreprises-filiere-porc.html" class="carreliens">diagnostics et audit</a> : les experts Ifip à vos côtés;</p>
		  <p class="indexplusgrand"><a href="formations-ifip-institut-du-porc.html" class="carreliens">formation</a> sur l'ensemble de nos domaines d'expertise;</p>
		  <hr />
		  <h2>Nos documentations</h2>
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="images/p-index-documentation.jpg" alt="" width="202" height="161" /></td>
    <td><img src="images/im-blanc.gif" alt="" width="1" height="160" /></td>
    <td><p class="indexplusgrand"><span class="carreliens">Documentation en ligne</span><br /><img src="images/picto-loupe.gif" alt="" width="15" height="17" /><a href="publications-ifip-institut-du-porc.htm">Effectuer une recherche</a></p>
	<p class="indexplusgrand"><a href="newsletters-ifip-institut-du-porc.html" class="carreliens">Lettres électroniques</a></p>
	<p class="indexplusgrand"><span class="carreliens">Les revues de l'IFIP</span><br /><a href="#">Techniporc</a></p>
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
					<? if ($url_lien) echo "<a href='".$url_lien."' target='_blank'>"; ?>
					<img src="photos/<?=$photos->nomPhoto?>" alt="<?=$photos->legende?>" /> <br />
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
				  echo strftime("%d %B %Y",$paras->datebrut);
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
				<p class="indexplusgrand"><? echo substr($paras->contenuPara,0,200);?>... <span class="petit"><a href="index.php?spec=veille-economique-internationale-production-viande-porc&numpage=<?=$pageSpec->numpage?>&numrub=<?=$pageSpec->numrub?>&numcateg=<?=$pageSpec->numcateg?>&numsscateg=<?=$pageSpec->numsscateg?>&numpays=<?=$paras->numpays?>&lg=<?=$lg?>">Lire la suite</a>&nbsp;|&nbsp;<a href="veille-economique-internationale-production-viande-porc.html">Toute l'actualité éco à l'international</a></span></p>
			</div>
			<p><a href="accompagnement-entreprises-a-international.html" class="plus">Comment l'Ifip accompagne votre développement à l'international</a>
				<?php
					//}//fin if (!$cpt_breves)
					//$cpt_breves++;
				}//fin du foreach ($listebreves as $paras) 
				?>
		  <? } // fin if ($nb_breves)
		  ?>
		    <hr />
		  <h2>Conjoncture filière : les indicateurs</h2>
		  <?php
		  /****** On va chercher les 4 premières images de la page "Indicateurs Conjoncture" ********************/
		  $pageInd=new Page();
		  $pageInd->aliasPage="";//<------------- Mettre ici le nom du fichier html lorsqu'il sera créé. ATTENTION, ce nom de fichier ne devra pas être modifié.
		  $numpage_ind=$pageInd->rechercherNumPage();
		  $listparas_ind=new ListeParagraphes();	
		  $listparas_ind->numpage=$numpage_ind;
		  foreach ($listparas_ind as $paras) {
		  	$listimg= new ListePhotos();
			$listimg->numpara=$paras->numpara;
			$listimg->afficherListePhotos();
			foreach ($listimg as $photos)  {
				$imgInd[]=$photos->nomPhoto;
			}
		  }
		  //La liste des img est dans le tableau $imgInd - prendre les 4 premières  $imgInd[0], $imgInd[1], $imgInd[2], $imgInd[3]
		  ?>
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
	  <div class="titre185">Brèves :</div>
	  <?php
	  foreach ($listactus as $paras) {
	  ?>
		  <p>
			<?=$paras->titrePara?>
		  </p>
		  <?php
			//les liens (pour mettre un lien sur une photo - l'affichage est realise plus bas)
			$listliens=new ListeLiens();
			$listliens->numpara= $paras->numpara;
			$nb_liens=$listliens->afficherListeLiens();
			
			$url_lien="";
			
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
					if ($url_lien) echo "<a href='".$url_lien."' target='_blank'>";
					?>
					<img src="photos/<?=$photos->nomPhoto?>" alt="<?=$photos->legende?>" /> <br />
					<?php
					if ($url_lien) echo "</a>";
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
				echo "<p>".$paras->contenuPara."</p>";
			}
			 
			
			// affichage des liens
			if ($nb_liens) {
				reset($listliens);
				foreach ($listliens as $liens) {
			?>
				  <p>
					<?php if ($liens->texteLien) echo $liens->texteLien."<br />"; ?>
					<a href="<?=$liens->urlLien?>" <?php if ($liens->fenLien=="o") echo "target='_blank'";?>><?=$liens->libLien?></a>
				  </p>
			<?php
				}//fin du foreach ($listliens as $liens)  
			} //fin if ($nb_liens)
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
							<a href="<?=$liens->urlLien?>" <?php if ($liens->fenLien=="o") echo "target='_blank'";?> class="carreliens"><?=$liens->libLien?></a>
						  </p>
						  <? } ?>
					<?php
							$cpt_lien++;
						}//fin du foreach ($listliens as $liens)  
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