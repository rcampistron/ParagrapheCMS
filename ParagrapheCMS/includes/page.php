<?php /* Date de création: 10/12/2008 */ 
/**
 * @file page.php
 * @date 10/12/2008
 * @brief Cette page contient le contenu du site.
 * @details Elle est visible depuis le site public ou bien dans l'admin ( à partir du fichier @ref content.php)
 * en modification de page (onglet "voir")
 * Pour le contenu en colonne 1 et 2, les liens sont affichés avant les photos alors que pour le contenu contibutif C3, les liens viennent après 
 */





$laPage = new Page(); 
if ($numpage) {
	$laPage->numpage=$numpage;
	$laPage->infosPage();
	$laPage->infosColonnes(); 
	
	// Recuperation des formations, contacts, docs (l'affichage est gere plus bas)
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
	
	// Les documentations liées à la catégorie ou sous-catégorie
	//QUE les docs qui ont des pdf (d'où l'utilisation des types sscat et categ pour Menu->afficherDocs)
	// NON, modifié HC : on cherche aussi sur les ouvrages de référence (qui n'ont pas de pdf donc on passe à type sscateg)
	$nb_doc=0;
	$tri_date=" AND type_doc!='1' "; // type_doc='1' : fiches actions - publiee='o' est compris dans l'objet Menu
	if ($numsscateg) {//on est dans une page de type sous domaine
	   $menuDoc=new Menu();
	   $menuDoc->type="sscateg"; //toutes les docs (pas que celles qui ont un pdf)
	   $menuDoc->nummenu=$numsscateg;
	   $menuDoc->tri_date=$tri_date;
	   $nb_doc=$menuDoc->afficherDocs();
	} else if ($numcateg) {//fin if ($numsscateg) on est dans une page de type dom
		$menuDoc=new Menu();
	    $menuDoc->type="categorie"; //toutes les docs
	    $menuDoc->nummenu=$numcateg;
		$menuDoc->tri_date=$tri_date;	
	    $nb_doc=$menuDoc->afficherDocs();
		//if ($nb_doc==0) $nb_doc=$menuDoc->afficherDocsSousCateg();	
	}
	
	// Les contacts liés à la catégorie ou sous-categorie
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
	
	//Mise en page particuliere pour la colonne C3 si 1 seul contenu dedans (contact)
	//mais pas de contenu contributif propre à la page
	// pour eviter de perdre 1 colonne en hauteur
	if (($laPage->C0 && !$laPage->C3 && !$nb_cont && !$nb_forma && !$nb_doc) ||
	($laPage->C0 && !$laPage->C3 && $nb_cont && !$nb_forma && !$nb_doc)) 
	$divflotte=1;
	else $divflotte=0;

}
if ($numpage) {
/*----------------------------------- COLONNE C0 ou C1 --------------------------------------------------------------*/
?>
<div class="item" id="<?php
			if ($laPage->C0) {
				if (!$divflotte) echo "coltexte585";
				else echo "coltexte785";
			} else if ($laPage->C1) echo "coltexte385"; else echo"coltexte785";
		?>"> 
		   <div class="sap-content">
				<!-- item 1 | 785 pixels de large ou 585 pixels ou 385 -->
				<p class="<?php
			if ($laPage->C0) {
				if (!$divflotte)  echo "titre585"; 
				else echo "titre785"; 
			} else if ($laPage->C1) echo "titre385";else echo "titre785";?>"><?=$laPage->titrePage?></p>
				<?php
				// div flotte à droite si pas de contenu contributif mais des contacts
				if ($divflotte) {
				?>
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
						  <? if($leContact->tel) echo"<span class=\"carreliens\">Tél.&nbsp;".$leContact->tel."</span><br />";?>
						  <a href="index.php?spec=contact&numpage=<?=$pageSpecContact->numpage?>&numrub=<?=$pageSpecContact->numrub?>&numcateg=<?=$pageSpecContact->numcateg?>&numsscateg=<?=$pageSpecContact->numsscateg?>&numcontact=<?=$leContact->numcontact?>&lg=<?=$lg?>" class="carreliens">Envoyer un courriel</a><br /><br /></p>
							
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
				<?php
				} // fin if ($divflotte)
				?>
				<?php
				$listparas1=new ListeParagraphes();	
				$listparas1->numpage=$laPage->numpage; 
				if ($laPage->C0) $listparas1->colonne="0";	 else if ($laPage->C1) $listparas1->colonne="1"; 
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

					if ($nb_photos) { // on fait un tableau plutot qu'un flottement qui met trop le bazar
						echo"<table><tr><td class='sansmarge'>";
					?>
					
					<?php
						foreach ($listphotos as $photos) {
					?> 
							<!--
							<?php //if ($paras->contenuPara) { ?>
							<div class="floatG">
							<? //} else { ?>
							-->
							<p>
							<? //} ?>
							
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
							<!--
							<?php //if ($paras->contenuPara) { ?>
							</div>
							<? //} else { ?>
							-->
							</p>
							<? //} ?>
					<?php
						}//fin du foreach ($listphotos as $photos)
						echo"</td>";
						echo"<td class='sansmarge'>";
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
							<a href="ouverturepdf.php?file=<?=$fichiers->nomFichier?>" target="_blank" class="pdf"><?=$fichiers->libFichier?></a>
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
						}//fin du foreach ($listvideos as $videos)
					}//fin 	if ($nb_videos)
					if ($nb_photos) echo"</td></tr></table>";
				} //fin du foreach
				?>
			</div>
	</div>

	<?php
	/*----------------------------------- COLONNE C2 -------------------------------------------------------------------*/
	if ($laPage->C2) {//colonne de droite
	?>
		<div class="item" id="colBoxRight">
		    <div class="sap-content">
				<!-- item 2 185 pixels wide -->
				
				<?php
				$listparas2=new ListeParagraphes();	
				$listparas2->numpage=$laPage->numpage;
				$listparas2->colonne=2;
				$listparas2->afficherListeParas();

				foreach ($listparas2 as $paras) {
					if ($paras->titrePara) {
						if ($laPage->accueilPage=="o") echo "<div class='titre185'>"; else  echo "<div class='titre185'>";
						//else echo "<".$paras->typeTitre.">"; Mise en commentaire Henriette - on maintient un titre 185
						echo $paras->titrePara;
						if ($laPage->accueilPage=="o") echo "</div>"; else echo "</div>";
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
					
					//le contenu
					if ($paras->contenuPara) {
						if ($paras->listePara=="li") echo miseEnFormeListe($paras->contenuPara); else echo "<p>".$paras->contenuPara."</p>";
					}
					
						
					
						
					//les liens : affichage
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
					?>
					<ul class="ficheactions">
					<?php
						foreach ($listfichiers as $fichiers) {
					?> 
						  <?php if ($fichiers->nomFichier) { ?>
						  <li class="ficheactions petit">
							<a href="ouverturepdf.php?file=<?=$fichiers->nomFichier?>" target="_blank"><?=$fichiers->libFichier?></a>
						  </li>
						  <? } // fin if ($fichiers->libFichier)
						  ?>
						 
					<?php
						}//fin du foreach ($listfichiers as $fichiers) 	
					?>
					</ul>
					<?php 
					}//fin 	if ($nb_fichiers) 
					
					
					
				} //fin du foreach
				
				// Les fiches actions liées à la catégorie ou sous-catégorie (domaines d'expertise)
				$nb_fiches=0;
				$tri_date=" AND publiee='o' AND type_doc='1'";
				if ($numsscateg) {
				   $menuDocAction=new Menu();
				   $menuDocAction->type="sscateg";
				   $menuDocAction->nummenu=$numsscateg;	
				   $menuDocAction->tri_date=$tri_date;
				   $nb_fiches=$menuDocAction->afficherDocs();
				} /* Mise en commentaire Henriette - pas d'affichage dans les pages categ, ça fait trop.
					else if ($numcateg) {//fin if ($numsscateg) 
					$menuDoc=new Menu();
					$menuDoc->type="categ";
					$menuDoc->nummenu=$numcateg;
					$menuDoc->tri_date=$tri_date;	
					$nb_fiches=$menuDoc->afficherDocs();	  
					
				}*/
				
				if ($nb_fiches) {
				?>
					<div class="titre185rouge">Nos actions R&D </div>
					<div id="divficheaction1" style="visibility:visible;">
					<ul class="ficheactions">
				    <?php
					//Les 5 premieres fiches action
					for ($i=0;$i<5;$i++) { 
							$laDoc=$menuDocAction->listdoc[$i];
							$fiche=new ListeFichiers();
							$fiche->numpara= $laDoc->numpara; 
							$fiche->afficherListeFichiers();
							foreach ($fiche as $fichiers) {
								$nom_fiche=$fichiers->nomFichier;
								$poids_fiche=$fichiers->poidsFichier;
								break;
							}
						  if ($nom_fiche) {
						  ?>
							<li class="ficheactions petit"><a href="ouverturepdf.php?file=<?=$nom_fiche?>" target="_blank" title="<?=$poids_fiche?>"><?=$laDoc->titrePara?></a></li><!-- class="pdf petit" -->
						  <?php
						  }//fin if ($nom_fiche) 
						  ?>
						<?php 
					 }//fin for ($i=0;$i<5;$i++)
					 ?>
					 </ul>
					 <?php
					 if (count($menuDocAction->listdoc)>5) {
					 ?>
					 <p align="right"><a href="javascript:montrerFichesAction('divficheaction','divficheaction1')" class="petit carreliens">voir toutes les actions</a></p>
					 <?php
					 }
					 ?>
					 </div>
					 <?php
					//toutes les fiches actions
					if (count($menuDocAction->listdoc)>5) {
					?>
						<div id="divficheaction" style="visibility:hidden; height:0">
						<ul class="ficheactions">
						 <?php
						for ($i=0;$i<count($menuDocAction->listdoc);$i++) { 
								$laDoc=$menuDocAction->listdoc[$i];
								$fiche=new ListeFichiers();
								$fiche->numpara= $laDoc->numpara; 
								$fiche->afficherListeFichiers();
								foreach ($fiche as $fichiers) {
									$nom_fiche=$fichiers->nomFichier;
									break;
								}
							  if ($nom_fiche) {
							  ?>
								<li class="ficheactions petit"><a href="ouverturepdf.php?file=<?=$nom_fiche?>" target="_blank" ><?=$laDoc->titrePara?></a></li><!-- class="pdf petit" -->
							  <?php
							  }//fin if ($nom_fiche) 
							  ?>
							<?php 
						 }//fin for ($i=0;$i<count($menuDocAction->listdoc);$i++)
						 ?>
						 </ul>
						 <p align="right"><a href="javascript:montrerFichesAction('divficheaction','divficheaction1')" class="petit carreliens">masquer</a>
			</p>
						</div>
					<?php
					} //fin if (count($menuDocAction->listdoc)>5)
					?>
					</ul>
					<?php
				} // fin if ($nb_fiches)
					?>

			</div>
		</div>	
	<?php
	} //fin  if ($laPage->C2)
	?>
	<?php
	/*----------------------------------- COLONNE CONTRIBUTIFS C3 --------------------------------------------------------*/
	if (!$divflotte)  {
	?>

		
	<div id="colBoxFarRight" class="item">
		 	<div class="sap-content">
	<?php
	
	// affichage des formations
	if ($nb_forma) {
	?>
			 <div class="titre185">Formations</div>
			 <?php
			  	$laForma=$menuForma->listforma[0];
				$pageSpecForma=new Page();
				$pageSpecForma->pageSpecifique("formations-ifip");
				
				$nom_fiche="";
				$listfichiers=new ListeFichiers();
				$listfichiers->numpara= $laForma->numpara; 
				$nb_fichiers=$listfichiers->afficherListeFichiers();
				foreach ($listfichiers as $fichiers) {
					$nom_fiche=$fichiers->nomFichier;
					break;
				}
			 	
			?>  
			  <p><strong>Prochaine session</strong></p> 
			  <p><?=$laForma->titrePara?></p> 
			  <p>Dates : <?php if ($laForma->datefin) echo "du ".$laForma->datedeb." au ".$laForma->datefin; else echo $laForma->datedeb;?> </p>
			  <p>
			  <a href="ouverturepdf.php?file=<?=$nom_fiche?>" target="_blank" class="carreliens">consulter la fiche</a> | <a href="index.php?spec=formation-inscription&numpage=<?=$pageSpecForma->numpage?>&numrub=<?=$pageSpecForma->numrub?>&numcateg=<?=$pageSpecForma->numcateg?>&numsscateg=<?=$pageSpecForma->numsscateg?>&numpara=<?=$laForma->numpara?>&lg=<?=$lg?>">S'inscrire</a></p>	
			   <p><a href="index.php?spec=formations-ifip&numpage=<?=$pageSpecForma->numpage?>&numrub=<?=$pageSpec->numrub?>&numcateg=<?=$pageSpecForma->numcateg?>&numsscateg=<?=$pageSpecForma->numsscateg?>&lg=<?=$lg?>" class="carreliens">Toutes les formations</a><br />&nbsp;</p>
			   <div class="spacer"></div>
			<?php  
	}//fin if ($nb_forma)
	
	
	// affichage des docs
	
	if ($nb_doc) {
	?>
		<div class="titre185">Documentation</div>
		<table width="185">
	<?php
		$j=0;//compteur des fiches effectivement affichées
		for ($i=0;$i<count($menuDoc->listdoc);$i++) {
			$nom_fiche="";
			if ($menuDoc->listdoc[$i]) {
					$laDoc=$menuDoc->listdoc[$i];
					$fiche=new ListeFichiers();
					$fiche->numpara= $laDoc->numpara; 
					$fiche->afficherListeFichiers();
					
					foreach ($fiche as $fichiers) {
						$nom_fiche=$fichiers->nomFichier;
						$poids_fiche=$fichiers->poidsFichier;
						break; // on ne va chercher q'un seul fichier pdf
					}
				  if ($laDoc->type_doc=='5' || ($laDoc->type_doc!='5' && $nom_fiche)) {
				  	$j++;
					if ($j>3) break; // on ne liste que 3 docs
			  ?>
			  		<tr>
					 <td><p> 
					 <img src="../images/<? if($laDoc->type_doc=='5') echo"picto-panier.gif";
					 else if ($laDoc->acces_res=="o") echo"picto-pdf-acces-reserve.gif";
					 else  echo"picto-pdf.gif"; ?>" alt="" /></p>
					 </td>
					 <td><!--<a href="ouverturepdf.php?file=<?=$nom_fiche?>" target="_blank" class="carreliens"><?=$laDoc->titrePara?></a>-->
					<?php 
									
									/* -------------------- LA DOC EST RESERVEE AUX PROFESSIONNELS -------------------- */
									if ($laDoc->acces_res=="o") {
										
										$pagePro = new Page();
										$pagePro->pageSpecifique("extranet-pro");
										
									
										if (!$_SESSION['numprof']) {//Le professionnel n'est pas connecté
									?>
										<a href="index.php?numpage=<?=$pagePro->numpage?>&spec=<?=$pagePro->nomFichier?>&numrub=<?=$pagePro->numrub?>&numcateg=<?=$pagePro->numcateg?>&numsscateg=<?=$pagePro->numsscateg?>&numdoc=<?=$laDoc->numpara?>&lg=<?=$lg?>" class="gris"><?=$laDoc->titrePara?><br />
<strong>Rapport réservé Espace Pro | identifiez-vous</strong></a>
									<?php
										} else if ($laDoc->tarif) {//Le professionnel est connecté et la doc est payante
									?>
											<a href="index.php?numpage=<?=$pagePro->numpage?>&spec=<?=$pagePro->nomFichier?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numpara=<?=$laDoc->numpara?>&textQte=1&lg=<?=$lg?>" class="gris"><?=$laDoc->titrePara?><br />
											<strong><?=$laDoc->tarif?> &euro;&nbsp;|&nbsp;rapport réservé Espace Pro &nbsp;|&nbsp;consulter le résumé</strong></a>
									<?php
										} else {//Le professionnel est connecté et la doc n'est pas payante
											if ($nom_fiche) {//le pdf existe (a priori oui, vu que l'on ne prend que les docs avec pdf)
									?>
											<a href="ouverturepdf.php?file=<?=$nom_fiche?>" target="_blank"><?=$laDoc->titrePara?><br />
											<strong>Rapport gratuit réservé Espace Pro | télécharger ce rapport (<?=$poids_fiche?>)</strong></a>
									<?php
											}
										}//fin du else if ($laDoc->tarif) 
									
									/* -------------------- LA DOC N'EST PAS RESERVEE mais elle est payante -------------------- */
									} else if ($laDoc->tarif) {
										
										if ($laDoc->type_doc=='5') {//ouvrage de référence
										  $pageBdd = new Page();
										  $pageBdd->pageSpecifique("catalogue-ifip-institut-du-porc");
										  
									?>
										<!--<a href="index.php?numpage=<?=$pagePanier->numpage?>&spec=<?=$pagePanier->nomFichier?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numdoc=<?=$laDoc->numpara?>&textQte=1&lg=<?=$lg?>" class="panier"><?=$laDoc->titrePara?></a>-->
										  <a href="index.php?numpage=<?=$pageBdd->numpage?>&spec=<?=$pageBdd->nomFichier?>&numrub=<?=$pageBdd->numrub?>&numcateg=<?=$pageBdd->numcateg?>&numsscateg=<?=$pageBdd->numsscateg?>&numpara=<?=$laDoc->numpara?>&textQte=1&lg=<?=$lg?>" class="gris"><?=$laDoc->titrePara?><br />
										<strong><?=$laDoc->tarif?> &euro;&nbsp;|&nbsp;consulter le descriptif</strong></a>
									<?php
										} else { // publication
										  $pageBdd = new Page();
										  $pageBdd->pageSpecifique("publications-ifip-institut-du-porc");
									?>
									 	  <a href="index.php?numpage=<?=$pageBdd->numpage?>&spec=<?=$pageBdd->nomFichier?>&numrub=<?=$pageBdd->numrub?>&numcateg=<?=$pageBdd->numcateg?>&numsscateg=<?=$pageBdd->numsscateg?>&numpara=<?=$laDoc->numpara?>&textQte=1&lg=<?=$lg?>" class="gris"><?=$laDoc->titrePara?><br />
										<strong><?=$laDoc->tarif?> &euro;&nbsp;|&nbsp;consulter le résumé</strong></a>
									<?php
										}
									
									/* -------------------- LA DOC N'EST PAS RESERVEE et elle est gratuite -------------------- */
									} else if ($nom_fiche && $laDoc->acces_res=="n" && !$laDoc->tarif) {
									?> 
										<a href="ouverturepdf.php?file=<?=$nom_fiche?>" target="_blank" class="gris"><?=$laDoc->titrePara?><br />
										<strong>Gratuit | télécharger cet article (<?=$poids_fiche?>)</strong></a>
									<?php
									}
									?>
					</td>
					</tr>
			  <?php
			  	   }//fin if ($laDoc->type_doc=='5' || ($laDoc->type_doc!='5' && $nom_fiche))
			  ?>
			<?php 
		 	}
		 }//fin for ($i=0;$i<count($menuDoc->listdoc);$i++)
		 ?>
		 </table>
		 <?php
		 //Lien vers toutes les docs de ce domaine et/ou sous domaine
		 $pageSpecDoc=new Page();
		 $pageSpecDoc->pageSpecifique("publications-ifip-institut-du-porc");
		?>
		 <p><a class="carreliens" href="index.php?spec=<?=$pageSpecDoc->nomFichier?>&numpage=<?=$pageSpecDoc->numpage?>&numrub=<?=$pageSpecDoc->numrub?>&numcateg=<?=$pageSpecDoc->numcateg?>&numsscateg=<?=$pageSpecDoc->numsscateg?>&lg=<?=$pageSpecDoc->lg?>&dom=<?=$numcateg?>&ssdom=<?=$numsscateg?>">Toute la doc sur ce thème</a><br />&nbsp;</p>
		 <div class="spacer"></div>
		 <?php
	}//fin if ($nb_doc)
	
	
	?>
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
			  <a href="index.php?spec=contact&numpage=<?=$pageSpecContact->numpage?>&numrub=<?=$pageSpecContact->numrub?>&numcateg=<?=$pageSpecContact->numcateg?>&numsscateg=<?=$pageSpecContact->numsscateg?>&numcontact=<?=$leContact->numcontact?>&lg=<?=$lg?>" class="carreliens">Envoyer un courriel</a><br /><br /></p>
			  	
			<?php  
			  }// fin du for ($i=0;$i<count($menuCont->listcontact);$i++)
			 ?>
			 <div class="spacer"></div>
			 <?php 
	}//fin if ($nb_cont)
	
	?>
		<?php
				// Les paragraphes
				$listparas=new ListeParagraphes();	
				$listparas->numpage=$laPage->numpage;
				$listparas->colonne=3; 
				$listparas->afficherListeParas();

				foreach ($listparas as $paras) {
					if ($paras->titrePara) {
				?>
					<div class="titre185"><?=$paras->titrePara?></div>
				<?php	
					}
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
								<? if ($laPage->accueilPage!="o" && $paras->titrePara) echo"<br />";?>
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
					
					//le contenu du paragraphe
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
					?>
					<ul class="listepdf">
					<?php
						foreach ($listfichiers as $fichiers) {
					?> 
						  <?php if ($fichiers->nomFichier && $fichiers->libFichier) { ?>
						  <li class="listepdf">
							<a href="ouverturepdf.php?file=<?=$fichiers->nomFichier?>" target="_blank"><?=$fichiers->libFichier?></a>
						  </li>
						  <? } // fin if ($fichiers->libFichier)
						  ?>
						 
					<?php
						}//fin du foreach ($listfichiers as $fichiers) 	
					?>
					</ul>
					<?php 
					}//fin 	if ($nb_fichiers)
					
					//les liens
					$listliens=new ListeLiens();
					$listliens->numpara= $paras->numpara;
					$nb_liens=$listliens->afficherListeLiens();
					
					if ($nb_liens) {?>
					<ul class="listecarres">
					<?php
						foreach ($listliens as $liens) {
					?>
						  <?php
						  if ($liens->libLien && $laPage->accueilPage!="o") {
						  ?>
						  <li class="listecarres">
						  	<?php if ($liens->texteLien) echo $liens->texteLien."<br />"; ?>
							<a href="<?=$liens->urlLien?>" <?php if ($liens->fenLien=="o") echo "target='_blank'";?>><?=$liens->libLien?></a>
						  </li>
						  <? } //fin if ($liens->libLien && $laPage->accueilPage!="o")
						}//fin du foreach ($listliens as $liens) 
					?>
					</ul>
					<?php
					} //fin if ($nb_liens)
					?>
				 <p style="background-color:#FFFFFF">&nbsp;<br /></p>
				<?php
				} //fin du foreach
?>

	</div>
</div>
<?php
	} // fin if (!$divflotte)
?>
<?php
	
} else if (!$id) {//fin if ($numpage)	  -----> on est en page d'accueil sur le site public : utiliser l'objet $accueilPage
?>

<h1>Bienvenue sur la page d'accueil de l'IFIP.</h1> <h2>Ce site Loest en construction.</h2>

<?php
}  // fin if ($numpage) => else if (!$id)
?>
	

