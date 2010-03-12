<?php /* Date de cration: 23/12/2008 */ 
$laPage = new Page();
$laPage->numpage=$numpage;
$laPage->infosPage();
$laPage->infosColonnes(); 

//setlocale(LC_ALL, "french");
//setlocale(LC_TIME, 'fr_FR.iso-8859-1', 'fr.iso-8859-1', 'fr_FR.iso-8859-1', 'fr.iso-8859-1');
// Recuperation des formations, contacts, docs (l'affichage est gere plus bas)
	// Les formations liées à la catégorie ou sous-catégorie
	$nb_forma=0;
	
	// Les documentations liées à la catégorie ou sous-catégorie
	// pas de docs dans cette page specifique : la requete perturbe celle du moteur
	$nb_doc=0;
	
	
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
	
	//Mise en page particuliere pour la colonne C3 si 1 seul contenu dedans (contact)
	//mais pas de contenu contributif propre à la page
	// pour eviter de prendre toute la largeur
	if (($laPage->C0 && !$laPage->C3 && !$nb_cont && !$nb_forma && !$nb_doc) ||
	($laPage->C0 && !$laPage->C3 && $nb_cont && !$nb_forma && !$nb_doc)) 
	$divflotte=1;
	else $divflotte=0;
		
if ($laPage->nomPageGoogle) { 
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
				<!-- Affichage contenu non dynamique-->
				<p>Nous répondons aux besoins de formation des techniciens et des ingénieurs de la filière porcine et des éleveurs spécialisés par une adaptation permanente de notre programme annuel de formation et par la mise en place de formations intra-entreprises après analyse des besoins spécifiques des équipes à former.<br />&nbsp;<br />&nbsp;</p>
				<table width="550" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="positionnement"><h4>Rechercher une formation</h4></td>
                    <td>&nbsp;</td>
                    <td><h4>Prochaines sessions </h4></td>
                  </tr>
                  <tr>
                    <td class="positionnement">
					<select name="selectDom" class="public" OnChange="location='index.php?numpage=<?=$numpage?>&spec=<?=$spec?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&lg=<?=$lg?>&dom='+this.value">
				   <option value="">S&eacute;lectionner un thème</option>  
				   <?php
				   $numr=SelectSimple("numrub","if_rubrique","1","1"," AND nom LIKE 'domaines d\'Expertise'");//numro de la rubrique correspondant  "Domaine d'expertise"
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
				<br />
				<?php
				if ($dom) {
				   //On liste les formations liées à la catégorie (en fait ce sont toutes les formations des sous-categ dont la categ a été sélectionnée)
				   
				   if ($ssdom) {//on a sélectionné un sous-domaine
				  	   $menus_forma=new Menu(); 
					   $menus_forma->type="sscateg";
					   $menus_forma->nummenu=$ssdom;
					   $menus_forma->lg=$lg;
					   $menus_forma->nomkey="numsscateg";
					   $menus_forma->infosMenu();
					   $nb_forma_menu=$menus_forma->afficherFormations(); 
				   } else { //on a sélectionné un domaine uniquement
					   $menus_forma=new Menu(); 
					   $menus_forma->type="categorie";
					   $menus_forma->nomkey="numcateg";
					   $menus_forma->nummenu=$dom;
					   $menus_forma->lg=$lg;
					   $menus_forma->infosMenu();
					   $nb_forma_menu=$menus_forma->afficherFormations(); 
				   }
				   
				   //On affiche les sous-catégories liées à la catégorie sélectionnée et qui ont des formations
				   $ssdomaines=new ListeMenus(); 
				   $ssdomaines->type="sscateg";
				   $ssdomaines->nomkey="numsscateg";
				   $ssdomaines->numfkey=$dom; 
				   $ssdomaines->lg=$lg;  
				   $nb_ssdom=$ssdomaines->afficherListeMenus();	  
				   if ($nb_ssdom) {	 
				   	?>
				 	<select name="selectSsDom" class="public" OnChange="location='index.php?numpage=<?=$numpage?>&spec=<?=$spec?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&lg=<?=$lg?>&dom=<?=$dom?>&ssdom='+this.value">	
					<option value="">Affinez par sous-thème</option> 
				 <?php
				   		foreach ($ssdomaines as $menus) {  
							$nb_forma=$menus->afficherFormations();
							if ($nb_forma) {
				?>
						 		<option value="<?=$menus->nummenu?>" <?php if ($menus->nummenu==$ssdom) echo "selected='selected'";?>><?=$menus->nomMenu?></option> 
				
				<?php 
							}//fin if($nb_forma)
						} //fin du foreach	
				?>
					</select>
				<?php
					}//fin if ($nb_ssdom)
				} else if (!$surmesure) {//fin if ($dom) : toutes les formations
					   $menus_forma=new Menu(); 
					   $menus_forma->type="categorie";
					   $menus_forma->nomkey="numcateg";
					   $menus_forma->lg=$lg;
					   //$menus_forma->infosMenu();
					   $nb_forma_toutes=$menus_forma->afficherFormations(); 
				}
				?>	
			 <br />
			   <strong>Toutes les formations</strong><br />
					<a href="index.php?numpage=<?=$numpage?>&amp;spec=<?=$spec?>&amp;numrub=<?=$numrub?>&amp;numcateg=<?=$numcateg?>&amp;numsscateg=<?=$numsscateg?>&amp;lg=<?=$lg?>&amp;surmesure=o" class="carreliens">les formations sur mesure</a><br />
					<a href="index.php?numpage=<?=$numpage?>&amp;spec=<?=$spec?>&amp;numrub=<?=$numrub?>&amp;numcateg=<?=$numcateg?>&amp;numsscateg=<?=$numsscateg?>&amp;lg=<?=$lg?>&amp;" class="carreliens">le catalogue de l'année</a></td>
                    <td>&nbsp;</td>
                    <td width="250">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<?php
					$prochainesForma=new ListeParagraphes();
					$prochainesForma->formation=1;
					$prochainesForma->tri_date=" WHERE date_deb>=".time()." AND enligne='o' ORDER BY date_deb LIMIT 0,2";
				    $nb_form=$prochainesForma->afficherListeParas();
				    if ($nb_form) {
						$pageSpec=new Page();
						$pageSpec->pageSpecifique("formation-inscription");
						
						foreach ($prochainesForma as $paras) {	
							$nom_fiche="";
							$listfichiers=new ListeFichiers();
							$listfichiers->numpara= $paras->numpara; 
							$nb_fichiers=$listfichiers->afficherListeFichiers();
							foreach ($listfichiers as $fichiers) {
								$nom_fiche=$fichiers->nomFichier;
								break;
							}
					?>
						 <tr>
                          <td width="10"><span class="carreliens">&nbsp;</span></td>
						 <td width="99%"><div class="petit">
						 <?=$paras->titrePara?>
						  <br />Dates : 
						  <?php 
						  if ($paras->datefin) {
						  	if ($paras->datedeb==$paras->datefin || !$paras->datefin) echo "$paras->datedeb"; 
							else echo "du ".$paras->datedeb." au ".$paras->datefin;
						  }
						  ?><br />
						  <a href="ouverturepdf.php?file=<?=$nom_fiche?>" target="_blank" class="pdfpetit">consulter la fiche</a> | <a href="index.php?numpage=<?=$pageSpec->numpage?>&amp;spec=<?=$pageSpec->nomFichier?>&amp;numrub=<?=$numrub?>&amp;numcateg=<?=$numcateg?>&amp;numsscateg=<?=$numsscateg?>&amp;numpara=<?=$paras->numpara?>&amp;lg=<?=$lg?>">s'inscrire</a>
						  <br />
						  </div>
						  </td>
					    </tr>
					<?php
						}//fin  de foreach ($prochainesForma as $paras)
					}//fin if ($nb_form)
					?>
					</table>
					
					</td>
                  </tr>
             </table>
				 <?php
				 if ($surmesure) {//on a cliqué sur "Voir aussi : nos formations sur mesure
				 	$listeforma=new ListeParagraphes();
					$listeforma->formation=1;
					$tri_date=" WHERE sur_mesure='o' AND enligne='o' ORDER BY titre";
					$listeforma->tri_date=$tri_date;
  					$nb_forma_surm=$listeforma->afficherListeParas();
				 
				 }
				 
				 if ($nb_forma_menu || $nb_forma_surm || $nb_forma_toutes ) {
				 //echo "ll=".$menus_forma->nomMenu;
				?>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<?php if ($dom) echo"<h2>".$menus_forma->nomMenu."</h2>";?>
					<div class="positionnement">
					
					<table width="100%" border="0" cellpadding="5" cellspacing="0">
						<tr class="entete">
							<td width="32%"><div align="left">Formation</div></td>
							<td width="23%"><div align="left">Dates</div></td>
							<td width="16%"><div align="left">Actions</div></td>
							<td width="9%"></td>
						    <td width="20%"></td>
						</tr>
						<?php
						if ($nb_forma_menu || $nb_forma_toutes) {
							$k="fond_clair2";
							$pageSpec=new Page();
							$pageSpec->pageSpecifique("formation-inscription");
							
							$pageSpecContact=new Page();
							$pageSpecContact->pageSpecifique("contact");
							
							for ($i=0;$i<count($menus_forma->listforma);$i++) { 
								if ($k=="fond_clair") $k="fond_clair2"; else $k="fond_clair";
								$nom_fiche="";
								$laForma=$menus_forma->listforma[$i];
								$fiche=new ListeFichiers();
								$fiche->numpara= $laForma->numpara; 
								$fiche->afficherListeFichiers();
								foreach ($fiche as $fichiers) {
									$nom_fiche=$fichiers->nomFichier;
									break;
								}
						?>
								<tr class="<?=$k;?>">
									<td><?=$laForma->titrePara?></td>
									<td class="petit"><?php if ($laForma->surMesure=="o") echo "formation sur mesure"; else if ($laForma->datefin==$laForma->datedeb || !$laForma->datedeb) echo $laForma->datedeb; else echo "du ".$laForma->datedeb." au ".$laForma->datefin;  ?></td>
									<td class="petit"><a href="ouverturepdf.php?file=<?=$nom_fiche?>" target="_blank" class="pdf">consulter la fiche</a></td>
									<td class="petit"><a href="index.php?numpage=<?=$pageSpec->numpage?>&spec=<?=$pageSpec->nomFichier?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numpara=<?=$laForma->numpara?>&lg=<?=$lg?>">s'inscrire</a></td>
								    <td class="petit"><a href="index.php?spec=contact&numpage=<?=$pageSpecContact->numpage?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numcontact=13&lg=<?=$lg?>&type=infosformation">demander des<br />renseignements</a></td>
								</tr>
						<?php
							}//fin du for
						 } else if ($nb_forma_surm) {//fin if ($nb_forma_menu)
						 	$k="fond_clair2";
							$pageSpec=new Page();
							$pageSpec->pageSpecifique("formation-inscription");
							foreach ($listeforma as $paras) {	
								if ($k=="fond_clair") $k="fond_clair2"; else $k="fond_clair";
								$nom_fiche="";
								$fiche=new ListeFichiers();
								$fiche->numpara= $paras->numpara; 
								$fiche->afficherListeFichiers();
								foreach ($fiche as $fichiers) {
									$nom_fiche=$fichiers->nomFichier;
									break;
								}
						?>
								<tr class="<?=$k;?>">
									<td><?=$paras->titrePara?></td>
									<td class="petit"><?php if ($paras->surMesure=="o") echo "formation sur mesure"; else if ($paras->datedeb==$paras->datefin || !$paras->datefin) echo $paras->datedeb; else echo "du ".$paras->datedeb." au ".$paras->datefin;   ?></td>
									<td class="petit"><a href="ouverturepdf.php?file=<?=$nom_fiche?>" target="_blank" class="pdf">consulter la fiche</a></td>
									<td><a href="index.php?numpage=<?=$pageSpec->numpage?>&spec=<?=$pageSpec->nomFichier?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numpara=<?=$laForma->numpara?>&lg=<?=$lg?>">s'inscrire</a></td>
								    <td><span class="petit"><a href="index.php?spec=contact&amp;numpage=<?=$pageSpecContact->numpage?>&amp;numrub=<?=$numrub?>&amp;numcateg=<?=$numcateg?>&amp;numsscateg=<?=$numsscateg?>&amp;numcontact=13&amp;lg=<?=$lg?>&amp;type=infosformation">demander des<br />
							        renseignements</a></span></td>
								</tr>
						<?php
							}//fin de foreach ($listform as $paras)
						}//fin else if ($nb_forma_surm) 
						?>
			 </table>
			 </div>	
				<?php
				} else if ($dom) {//fin if ($nb_forma_menu || $nb_forma_surm || $nb_forma_toutes)
				?>
					<?php if ($dom) echo"<h2>".$menus_forma->nomMenu."</h2>";?>
					<div class="positionnement">
					<p><strong>Aucune formation ne correspond à vos critères de recherche</strong></p>
					</div>
				<?php
				}//fin else if ($dom)
				?>
				<!-- Fin affichage contenu non dynamique -->
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
						}//fin du foreach ($listvideos as $videos)
					}//fin 	if ($nb_videos)
					
				} //fin du foreach
				?>
  </div>
</div>
	
	
<?php	
}//fin if ($laPage->nomPageGoogle)
	?>

	

