<?php /* Date de création:20/03/2009 */ 
$laPage = new Page();
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
	
	// Les contacts liés à la catégorie ou sous-catgorie
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
	
	//Mise en page particuliere pour la colonne C3 si 1 seul contenu dedans (cont, forma ou doc)
	//mais pas de contenu contributif propre à la page
	// pour eviter de prendre toute la largeur
	if (($laPage->C0 && !$laPage->C3 && !$nb_cont && !$nb_forma && !$nb_doc) ||
	($laPage->C0 && !$laPage->C3 && $nb_cont && !$nb_forma && !$nb_doc) || 
	($laPage->C0 && !$laPage->C3 && !$nb_cont && $nb_forma && !$nb_doc) || 
	($laPage->C0 && !$laPage->C3 && !$nb_cont && !$nb_forma && $nb_doc)) 
	$divflotte=1;
	else $divflotte=0;

//setlocale(LC_ALL, "french");
	
if ($laPage->nomPageGoogle) {
?>
<div class="item" id="<?php
			if ($laPage->C0) { 
				if (!$divflotte) echo "coltexte585";
				else echo "coltexte785"; 
			} else if ($laPage->C1) echo "coltexte385";
			else echo"coltexte785";
		?>"> 
		   <div class="sap-content">
				<!-- item 1 | 785 pixels de large ou 585 pixels ou 385 -->
				<p class="<?php
			if ($laPage->C0) {
				if (!$divflotte)  echo "titre585"; 
				else echo "titre785"; 
			} else if ($laPage->C1) echo "titre385";?>"><?=$laPage->titrePage?></p>
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
							$pageSpec=new Page();
							$pageSpec->pageSpecifique("contact");
						?>  
						  <p><strong><?=$leContact->prenom." ".$leContact->nom?></strong><br /> 
						  <?=miseEnForme($leContact->fonction)?><br />
						  <? if($leContact->tel) echo "<span class=\"carreliens\">Tél.&nbsp;".$leContact->tel."</span><br />";?>
						  <a href="index.php?spec=contact&numpage=<?=$pageSpec->numpage?>&numrub=<?=$pageSpec->numrub?>&numcateg=<?=$pageSpec->numcateg?>&numsscateg=<?=$pageSpec->numsscateg?>&numcontact=<?=$leContact->numcontact?>&lg=<?=$lg?>" class="carreliens">Envoyer un courriel</a><br /><br /></p>
							
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
				<!-- Affichage contenu non dynamique (provenant du CMS)-->
				<?php
				$listactus=new ListeParagraphes();	
				$listactus->actu=1;
				if ($numpara) $listactus->req_actu=" WHERE numpara='".$numpara."'";
				$listactus->req_actu.=" ORDER BY date DESC";
			    $nb_actus=$listactus->afficherListeParas();
				foreach ($listactus as $paras) {	
				?>
					<h3><?=$paras->titrePara?> - <?=$paras->date_actu?></h3>
					<?php
					//Toutes les actualites
					if (!$numpara) {
					?>
					<div id="actu1_<?=$paras->numpara?>">
					
					<p><?php if (strlen($paras->contenuPara)>=100) echo substr($paras->contenuPara,0,100)."...</strong>"; else echo $paras->contenuPara?>
					<?php
					if (strlen($paras->contenuPara)>=100) {
					?>
						<a href="javascript: montrerActu('actu1_<?=$paras->numpara?>','actu2_<?=$paras->numpara?>')">Lire la suite</a>
					<?php
					}
					?>
					</p>
					</div>
					<?php
					} // fin if (!$numpara)
					?>
					<div id="actu2_<?=$paras->numpara?>" 
					<?php if (strlen($paras->contenuPara)>=100 && !$numpara) echo"style=\"visibility:hidden; height:0px\"";?>>
						<?php if (strlen($paras->contenuPara)>=100 || $numpara) echo"<p>".$paras->contenuPara."</p>";?>
						<?php
						//le lien (pour mettre un lien sur la vignette - l'affichage est realise plus bas)
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
						
						// la vignette
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
						
						// affichage du lien
						if ($nb_liens) {
							//$cpt_lien=0;
							reset($listliens);
						?>
						<ul class="listecarres">
						<?php
							foreach ($listliens as $liens) {
								//if (!$cpt_lien) $url_lien=$liens->urlLien;
						?>
							  <li class="listecarres">
								<?php if ($liens->texteLien) echo $liens->texteLien."<br />"; ?>
								<a href="<?=$liens->urlLien?>" <?php if ($liens->fenLien=="o") echo "target='_blank'";?>><?=$liens->libLien?></a>
							  </li>
						<?php
								//$cpt_lien++;
							}//fin du foreach ($listliens as $liens)
						?>
						</ul>
						<?php
						} //fin if ($nb_liens)
						?>	
						
					</div>
				<?php
				}//fin du foreach ($listactus as $paras)
				?>
				<?php
				if ($numpara) {
					$pageSpecActus=new Page();
					$pageSpecActus->pageSpecifique("actualites-filiere-production-porc");
				?>
				<p><br />
				<a href="index.php?spec=<?=$pageSpecActus->nomFichier?>&numpage=<?=$pageSpecActus->numpage?>&numrub=<?=$pageSpecActus->numrub?>&numcateg=<?=$pageSpecActus->numcateg?>&numsscateg=<?=$pageSpecActus->numsscateg?>&lg=<?=$pageSpecActus->lg?>">Toutes les actualités</a>
				</p>
				<?php
				}//fin if ($numpara)
				?>
				<!-- Fin affichage contenu non dynamique (provenant du CMS) -->
				
				
				<p>&nbsp;</p>
				<p>&nbsp;</p>
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
					?>
					<ul class="listepdf">
					<?php
						foreach ($listfichiers as $fichiers) {
					?> 
						  <li class="listepdf">
							<a href="ouverturepdf.php?file=<?=$fichiers->nomFichier?>" target="_blank"><?=$fichiers->libFichier?></a>
						  </li>
						 
					<?php
						}//fin du foreach ($listfichiers as $fichiers) 
					?>
					</ul>
					<?php 
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
				} //fin du foreach
				?>
				
  </div>
</div>
	
	<?php
	/*----------------------------------- COLONNE DE DROITE C2 --------------------------------------------------------*/
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
						if ($laPage->accueilPage=="o") echo "<p class='titre185'>"; else  echo "<".$paras->typeTitre.">";
						echo $paras->titrePara;
						if ($laPage->accueilPage=="o") echo "</p>"; else echo "</".$paras->typeTitre.">";
					}//fin if ($paras->titrePara)
					
					if ($paras->contenuPara) {
						if ($paras->listePara=="li") echo miseEnFormeListe($paras->contenuPara); else echo "<p>".$paras->contenuPara."</p>";
					}
					
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
							<a href="ouverturepdf.php?file=<?=$fichiers->nomFichier?>" target="_blank"><?=$fichiers->libFichier?></a>
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
				} //fin du foreach
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
				$pageSpec=new Page();
				$pageSpec->pageSpecifique("formations-ifip");
			 	
			?>  
			  <p><strong>Prochaine session</strong></p> 
			  <p><?=$laForma->titrePara?></p> 
			  <p>Dates : <?php if ($laForma->datefin) echo "du ".$laForma->datedeb." au ".$laForma->datefin; else echo $laForma->datedeb;?> </p>
			  <p>
			  <a href="index.php?spec=formation-inscription&numpage=<?=$pageSpec->numpage?>&numrub=<?=$pageSpec->numrub?>&numcateg=<?=$pageSpec->numcateg?>&numsscateg=<?=$pageSpec->numsscateg?>&numpara=<?=$laForma->numpara?>&lg=<?=$lg?>" class="carreliens">S'inscrire</a></p>	
			   <p><a href="index.php?spec=formations-ifip&numpage=<?=$pageSpec->numpage?>&numrub=<?=$pageSpec->numrub?>&numcateg=<?=$pageSpec->numcateg?>&numsscateg=<?=$pageSpec->numsscateg?>&lg=<?=$lg?>" class="carreliens">Toutes les formations</a></p>
			   <div class="spacer"></div>
			<?php  
	}//fin if ($nb_forma)
	
	
	// affichage des docs
	if ($nb_doc) {
	?>
		<div class="titre185">Documentation</div>
	<?php
		for ($i=0;$i<count($menuDoc->listdoc);$i++) { 
					$laDoc=$menuDoc->listdoc[$i];
					$fiche=new ListeFichiers();
					$fiche->numpara= $laDoc->numpara; 
					$fiche->afficherListeFichiers();
					$nom_fiche="";
					foreach ($fiche as $fichiers) {
						$nom_fiche=$fichiers->nomFichier;
						break;
					}
				  if ($nom_fiche) {
			  ?>
			  		<p>
					<?php
									if ($laDoc->acces_res=="o") {//La doc est réservée aux Professionnels
										
										$pagePro = new Page();
										$pagePro->pageSpecifique("extranet-pro");
									
										if (!$_SESSION['numprof']) {//Le professionnel n'est pas connecté
									?>
										<a href="index.php?numpage=<?=$pagePro->numpage?>&spec=<?=$pagePro->nomFichier?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numdoc=<?=$laDoc->numpara?>&lg=<?=$lg?>" class="reserve">Ce document est en accès réservé<br /><?=$laDoc->titrePara?></a>
									<?php
										} else if ($laDoc->tarif) {//Le professionnel est connecté et la doc est payante
									?>
											<?=$laDoc->tarif?> &euro; <a href="index.php?numpage=<?=$pageSpec->numpage?>&spec=<?=$pageSpec->nomFichier?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numdoc=<?=$laDoc->numpara?>&textQte=1&lg=<?=$lg?>" class="panier"><?=$laDoc->titrePara?></a>
									<?php
										} else {//Le professionnel est connecté et la doc n'est pas payante 
									?>
											<a href="ouverturepdf.php?file=<?=$nom_fiche?>" target="_blank"><?=$laDoc->titrePara?></a>
									<?php
										}//fin du else if ($paras->tarif) 
									
									} else if ($laDoc->tarif) { //La doc n'est pas réservée aux professionnels mais elle est payante
									?>
										<a href="index.php?numpage=<?=$pageSpec->numpage?>&spec=<?=$pageSpec->nomFichier?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numdoc=<?=$laDoc->numpara?>&textQte=1&lg=<?=$lg?>" class="panier"><?=$laDoc->titrePara?></a>
									<?php
									} else if ($nom_fiche && $laDoc->acces_res=="n" && !$laDoc->tarif) {// La doc n'est pas réservée aux professionnels et elle n'est pas payante
									?> 
										<a href="ouverturepdf.php?file=<?=$nom_fiche?>" target="_blank"><?=$laDoc->titrePara?></a>
									<?php
									}
									?>
					</p>
			  <?php
			  	   }//fin if ($nom_fiche) 
			  ?>
			<?php 
		 }//fin for ($i=0;$i<count($menuDoc->listdoc);$i++)
		 ?>
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
				$pageSpec=new Page();
				$pageSpec->pageSpecifique("contact");
			?>  
			  <p><strong><?=$leContact->prenom." ".$leContact->nom?></strong><br /> 
			  <?=miseEnForme($leContact->fonction)?><br />
			  <? if($leContact->tel) echo "<span class=\"carreliens\">Tél.&nbsp;".$leContact->tel."</span><br />";?>
			  <a href="index.php?spec=contact&numpage=<?=$pageSpec->numpage?>&numrub=<?=$pageSpec->numrub?>&numcateg=<?=$pageSpec->numcateg?>&numsscateg=<?=$pageSpec->numsscateg?>&numcontact=<?=$leContact->numcontact?>&lg=<?=$lg?>" class="carreliens">Envoyer un courriel</a><br /><br /></p>
			  	
			<?php  
			  }// fin du for ($i=0;$i<count($menuCont->listcontact);$i++)
			 ?>
			 <div class="spacer"></div>
			 <?php 
	}//fin if ($nb_cont)
	
	?>
		<?php
				// Les paragphres
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
							<a href="ouverturepdf.php?file=<?=$fichiers->nomFichier?>" target="_blank" class="pdf"><?=$fichiers->libFichier?></a>
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
} //fin if ($laPage->nomPageGoogle)
?>
