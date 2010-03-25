<?php /* Date de cration: 23/12/2008 */ 
$laPage = new Page();
$laPage->numpage=$numpage;
$laPage->infosPage();
$laPage->infosColonnes();
$spec="equipes-ifip";

//setlocale(LC_ALL, "french");
//setlocale(LC_TIME, 'fr_FR.iso-8859-1', 'fr.iso-8859-1', 'fr_FR.iso-8859-1', 'fr.iso-8859-1');
		
if ($laPage->nomPageGoogle) { 
?>
<div class="item" id="<?php if ($laPage->C0) echo "coltexte585"; else if ($laPage->C1) echo "coltexte385";?>">

		   <div class="sap-content">
				<!-- item 1 585 pixels wide -->
				<p class="<?php if ($laPage->C0) echo "titre585"; else if ($laPage->C1) echo "titre385";?>"><?=$laPage->titrePage?></p>
				<!-- Affichage contenu dynamique -->
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
						foreach ($listliens as $liens) {
					?>
						  <p>
						  	<?php if ($liens->texteLien) echo $liens->texteLien."<br />"; ?>
							<a href="<?=$liens->urlLien?>" <?php if ($liens->fenLien=="o") echo "target='_blank'";?>><?=$liens->libLien?></a>
						  </p>
					<?php
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
						}//fin du foreach ($listvideos as $videos)
					}//fin 	if ($nb_videos)
				} //fin du foreach
				?>
				<!-- Affichage contenu non dynamique -->
				<br />&nbsp;<br />
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><p class="marge10"><strong>RECHERCHER un contact </strong></p></td>
                  </tr>
                  <tr>
                    <td>
					<div class="positionnement">
					<select name="selectDom" class="public" OnChange="location='index.php?numpage=<?=$numpage?>&spec=<?=$spec?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&lg=<?=$lg?>&dom='+this.value">
				   <option value="">S&eacute;lectionner un domaine d'activité</option>  
				   <?php
				   $numr=SelectSimple("numrub","if_rubrique","1","1"," AND nom LIKE 'domaines d\'Expertise'");//numéro de la rubrique correspondant  "Domaine d'expertise"
				   $domaines=new ListeMenus(); 
				   $domaines->type="categorie";
				   $domaines->nomkey="numcateg";
				   $domaines->numfkey=$numr; 
				   $domaines->lg=$lg;  
				   $domaines->afficherListeMenus();	  
				   foreach ($domaines as $menus) {
				   ?>
				   	 <option value="<?=$menus->nummenu?>" <?php if ($menus->nummenu==$dom) echo "selected='selected'";?>><?=$menus->nomMenu?></option>  
				   <?php
				   }//fin du foreach
				   ?>
				</select>
				</div>
				<br />
				<?php
				if ($dom) {
				   //On liste les personnes liées à la catégorie (en fait ce sont toutes les personnes des sous-categ dont la categ a été sélectionnée)
				   
				   		//on a sélectionné un domaine uniquement
					   $menus_cont=new Menu(); 
					   $menus_cont->type="categorie";
					   $menus_cont->nomkey="numcateg";
					   $menus_cont->nummenu=$dom;
					   $menus_cont->infosMenu();
					   $nb_cont_menu=$menus_cont->afficherContacts();//lié à la catégorie
					   $menus_cont->afficherContactsSousCateg();//lié à la sous-catégorie + tri sur le tableau listcontact[]
					   //print_r($menus_cont->listcontact);

				   //On affiche les sous-catégories liées à la catégorie sélectionnée et qui ont des formations
				   /*$ssdomaines=new ListeMenus(); 
				   $ssdomaines->type="sscateg";
				   $ssdomaines->nomkey="numsscateg";
				   $ssdomaines->numfkey=$dom; 
				   $ssdomaines->lg=$lg;  
				   $nb_ssdom=$ssdomaines->afficherListeMenus();	  
				   if ($nb_ssdom) {	 
				   	?>
				 	<!-- Mise en commentaire Henriette - pas d'affinage par sous domaine
					<select name="selectSsDom" class="public" OnChange="location='index.php?numpage=<?=$numpage?>&spec=<?=$spec?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&lg=<?=$lg?>&dom=<?=$dom?>&ssdom='+this.value">	
					<option value="">S&eacute;lectionner une spécialité</option> 
				 <?php
				   		foreach ($ssdomaines as $menus) {  
							$nb_cont=$menus->afficherContacts();
							if ($nb_cont) {
				?>
						 		<option value="<?=$menus->nummenu?>" <?php if ($menus->nummenu==$ssdom) echo "selected='selected'";?>><?=$menus->nomMenu?></option> 
				
				<?php 
							}//fin if($nb_forma)
						} //fin du foreach	
				?>
					</select>
					-->
				<?php
					}//fin if ($nb_ssdom)*/
				}
				?>
			   		</td>
                  </tr>
             </table>
				 <?php 
				 
				 if ($nb_cont_menu) {
				 //echo "ll=".$menus_cont->nomMenu;
				?>
					<?php if ($dom) echo"<h1>L'équipe du pôle ".$menus_cont->nomMenu."</h1>";?>
					<?php
					for ($i=0;$i<count($menus_cont->listcontact);$i++) { 
			  			$leContact=	$menus_cont->listcontact[$i];
						$pageSpec=new Page();
						$pageSpec->pageSpecifique("contact");
					
					?>
					<h2><?=$leContact->genre." ".$leContact->prenom." ".$leContact->nom?></h2>
					<p><?=miseEnForme($leContact->fonction)?><br />
					<? if ($leContact->tel) echo $leContact->tel."<br />";?>
					<? if($leContact->fax) echo $leContact->fax."<br />";?>
					<a href="index.php?spec=contact&numpage=<?=$pageSpec->numpage?>&numrub=<?=$pageSpec->numrub?>&numcateg=<?=$pageSpec->numcateg?>&numsscateg=<?=$pageSpec->numsscateg?>&numcontact=<?=$leContact->numcontact?>&lg=<?=$lg?>" class="carreliens">Envoyer un email</a><br /><br /></p>
					<?php  
					}// fin du for 
					  
					
					 ?>	
				<?php
				} else if ($dom) {//fin if ($nb_cont_menu)
				?>
					<?php if ($dom) echo"<h2>".$menus_cont->nomMenu."</h2>";?>
					<p><strong>Aucun contact ne correspond à vos critères de recherche</strong></p>
				<?php
				}//fin else if ($dom)
				?>
				<!-- Fin affichage contenu non dynamique -->
				<p>&nbsp;</p>
				<p>&nbsp;</p>
				
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
						  if ($liens->libLien) {
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
			  <p><strong><?=$leContact->prenom." ".$leContact->nom?></strong><br /> 
			  <?=miseEnForme($leContact->fonction)?><br />
			  <? if($leContact->tel) echo "<span class=\"carreliens\">Tél.&nbsp;".$leContact->tel."</span><br />";?>
			  <a href="index.php?spec=contact&numpage=<?=$pageSpec->numpage?>&numrub=<?=$pageSpec->numrub?>&numcateg=<?=$pageSpec->numcateg?>&numsscateg=<?=$pageSpec->numsscateg?>&numcontact=<?=$leContact->numcontact?>&lg=<?=$lg?>" class="carreliens">Lui envoyer un courriel</a><br />
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
						  <?php if ($fichiers->libFichier) { ?>
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
	<?php
	} // fin if ($laPage->C3) 
	?>
		</div>
	</div> 	
<?php	
}//fin if ($laPage->nomPageGoogle)
	?>

	

