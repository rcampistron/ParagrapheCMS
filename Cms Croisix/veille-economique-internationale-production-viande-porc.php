<?php /* Date de création: 09/02/2009 */ 
$laPage = new Page();
$laPage->numpage=$numpage;
$laPage->infosPage();
$laPage->infosColonnes(); 


//setlocale(LC_ALL, "french");

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
	
	// Les documentations liées de type "fiche observatoire économique"
	// Attention : requete specifique à cette page
	// On utilise l'objet ListeParagraphes et pas Menu (contrairement à page.php)
	// car on ne veut que les docs de type 7
	$nb_doc=0;
	$req_doc=" WHERE type_doc='7' ORDER BY titre";
	$listedoc=new ListeParagraphes();
	$listedoc->doc=1;
	$listedoc->req_doc=$req_doc;
	$nb_doc=$listedoc->afficherListeParas();
	
	//Documentations suite : on va aussi chercher les docs liées au sous domaine Veille économique
	/*
	$numsscateg=6;
	$menuDoc=new Menu();
	$menuDoc->type="sscat"; //que les docs qui ont des fichiers (pas les ouvrages de référence donc)
	   $menuDoc->nummenu=$numsscateg;
	   $menuDoc->tri_date=$tri_date;
	   $nb_doc_sscateg_veille=$menuDoc->afficherDocs();
	*/
	
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
			} else if ($laPage->C1) echo "coltexte385"; else if ($laPage->C3) echo"coltexte585"; else echo"coltexte785";
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
				<!-- Affichage contenu non dynamique (provenant du CMS)-->
				<h1>Les brèves </h1>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="positionnement"><strong>Rechercher une brève </strong><br /><br /></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="positionnement">
					<select name="selectPays" class="public" OnChange="location='index.php?numpage=<?=$numpage?>&spec=<?=$spec?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&lg=<?=$lg?>&numpays='+this.value">
				   <option value="">S&eacute;lectionner un pays</option> 
				   <option value="">----------------------------------------------------</option>
					<option value="">Tous les pays</option>
					<option value="">----------------------------------------------------</option> 
				   <?php
					$result = mysql_query("SELECT if_pays.* FROM if_pays,if_breves WHERE if_pays.numpays=if_breves.numpays GROUP BY numpays ORDER BY pays");
					while ($row=mysql_fetch_array($result)) {
					?>
						<option value="<?=$row['numpays']?>" <?php if ($row['numpays']==$numpays) echo "selected='selected'";?>><?=utf8_encode($row['pays'])?></option>
					<?php
					}//fin du while
					?>
					</select>
				<br />
	 
			 <select name="selectDate" class="public"  OnChange="location='index.php?numpage=<?=$numpage?>&spec=<?=$spec?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&lg=<?=$lg?>&numpays='+this.form.elements['selectPays'].options[this.form.elements['selectPays'].selectedIndex].value+'&date_br='+this.value">
				    <option value="">S&eacute;lectionner une période</option>
					<option value="">----------------------------------------------------</option>
					<option value="">Toutes les périodes</option>
					<option value="">----------------------------------------------------</option>
				    <?php
					$lesBreves= new Breve();
					$list_date=$lesBreves->listerDates(); 
					for ($i=0;$i<count($list_date);$i++) {
					?>
						<option value="<?=$list_date[$i]?>" <?php if ($date_br==$list_date[$i]) echo "selected='selected'";?>><?=iconv('ISO-8859-1', 'UTF-8',(strftime("%B %Y",$list_date[$i])));?></option>
					
					<?php
					}//fin du for
					?>					
		     </select>
			
			   </td>
                    <td>&nbsp;</td>
                    
                  </tr>
             </table>
				 <?php
				 //Listage des breves
				if ($numpays && $date_br) {
					//On liste les brèves liées au pays sélectionné 
					$date_deb=mktime(0,0,0,date("m",$date_br),1,date("Y",$date_br));
					$date_fin=mktime(23,59,59,date("m",$date_br),date("t",$date_br),date("Y",$date_br));
					$req_breve=" WHERE numpays='$numpays' AND (date BETWEEN $date_deb AND $date_fin)";
				} else if ($numpays) {
					$req_breve=" WHERE numpays='$numpays'";
				} else if ($date_br) {
					$date_deb=mktime(0,0,0,date("m",$date_br),1,date("Y",$date_br));
					$date_fin=mktime(23,59,59,date("m",$date_br),date("t",$date_br),date("Y",$date_br));
					$req_breve=" WHERE (date BETWEEN $date_deb AND $date_fin)";
				} else { // 1 mois glissant
					$mois_prec=date("n")-1;
					$date_deb=mktime(0,0,0,$mois_prec,1,date("Y"));
					$date_fin=mktime(23,59,59,date("n"),date("t"),date("Y"));
					$req_breve=" WHERE (date BETWEEN $date_deb AND $date_fin)";
				
				}
				
				$listebreves=new ListeParagraphes();
				$listebreves->breve=1;
				/*
				if (!$req_breve) {//pas de critères sélectionnés = affichage par défaut des brèves du mois en cours
					$date_deb=mktime(0,0,0,date("n"),1,date("Y"));
					$date_fin=mktime(23,59,59,date("n"),date("t"),date("Y"));
					$req_breve=" WHERE (date BETWEEN $date_deb AND $date_fin)";
					
					//ou du mois precedent si aucune brève dans le mois en cours
					$listebreves->req_breve=$req_breve;
					$nb_breves=$listebreves->afficherListeParas();
					if (!$nb_breves) {
						$date_deb=mktime(0,0,0,date("n")-1,1,date("Y"));
						$date_fin=mktime(23,59,59,date("n"),date("t"),date("Y"));
						$req_breve=" WHERE (date BETWEEN $date_deb AND $date_fin)";
					
					}
				}
				*/
				$req_breve.=" ORDER BY date DESC";
				$listebreves->req_breve=$req_breve;
				$nb_breves=$listebreves->afficherListeParas(); 
							 
				 if ($nb_breves) {// Il y a des résultats aux critères sélectionnés
				?>
					<p>&nbsp;</p>
						<?php
						foreach ($listebreves as $paras) {
							if ($paras->titrePara) {
								echo "<h3 class=\"highlight\">";
								echo "<a href=\"javascript: montrerBreve('breve".$paras->numpara."')\" class=\"gris\">";
								echo $paras->titrePara;
								echo " (".iconv('ISO-8859-1', 'UTF-8',(strftime("%d %B %Y",$paras->datebrut))).")";
								echo "</a>";
								echo "</h3>";
							}//fin if ($paras->titrePara)
							?>
							
							<div id="breve<?=$paras->numpara?>" style="visibility:hidden; height:0px">
								<p><?=$paras->contenuPara?></p>
								<br />
								<p>Source : <em><?=$paras->source?></em></p>
							</div>	
				<?php
						}//fin du foreach ($listebreves as $paras) 
				?>
				<?php
					} else if ($numpays || $date_br ) {//fin if (nb_breves)
				?>
					<?php if ($dom) echo"<h2>".$menus_doc->nomMenu."</h2>";?>
					<p><br /><br /><strong>Aucune brève ne correspond à vos critères de recherche</strong></p>
				<?php
				}//fin else if ($numpays || $date_br)
				?>
				<!-- Fin affichage contenu non dynamique -->
				
				<!-- Affichage CMS -->
				<p>&nbsp;</p>
				<p>&nbsp;</p>
				<?php
				$listparas1=new ListeParagraphes();	
				$listparas1->numpage=$laPage->numpage; 
				if ($laPage->C0) $listparas1->colonne="0"; else if ($laPage->C1) $listparas1->colonne="1"; 
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
		<table width="185">
	<?php
		foreach ($listedoc as $paras) {
				$fiche=new ListeFichiers();
				$fiche->numpara= $paras->numpara; 
				$fiche->afficherListeFichiers();
				foreach ($fiche as $fichiers) {
					$nom_fiche=$fichiers->nomFichier;
					$poids_fiche=$fichiers->poidsFichier;
					break;//un seul pdf a chaque fois
				}
			  if ($nom_fiche) {
			  ?>
			  	<tr>
				  <td><p><img src="../images/picto-pdf.gif" alt="" /></p></td>
				  <td><a href="ouverturepdf.php?file=<?=$nom_fiche?>" target="_blank" title="<?=$poids_fiche?>"><?=$paras->titrePara?></a></td>
				</tr>
			  <?php
			  }//fin if ($nom_fiche) 
			  ?>
			<?php 
		 }//fin for ($i=0;$i<count($menuDoc->listdoc);$i++)
		 ?>
		 </table>
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
						break;
					}
				  //if ($nom_fiche) {
				  	$j++;
					if ($j>3) break;
			  ?>
			  		<tr>
					 <td><p><img src="../images/picto-pdf.gif" alt="" /></p></td>
					 <td><!--<a href="ouverturepdf.php?file=<?=$nom_fiche?>" target="_blank" class="carreliens"><?=$laDoc->titrePara?></a>-->
					<?php
									//a noter ci-dessous : on ne va plus chercher les docs réservées aux professionnels
									if ($laDoc->acces_res=="o") {//La doc est réservée aux Professionnels
										
										$pagePro = new Page();
										$pagePro->pageSpecifique("extranet-pro");
										
									
										if (!$_SESSION['numprof']) {//Le professionnel n'est pas connecté
									?>
										<a href="index.php?numpage=<?=$pagePro->numpage?>&spec=<?=$pagePro->nomFichier?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numdoc=<?=$laDoc->numpara?>&lg=<?=$lg?>" class="gris"><?=$laDoc->titrePara?><br />
Article réservé aux professionnels - identifiez-vous</a>
									<?php
										} else if ($laDoc->tarif) {//Le professionnel est connecté et la doc est payante
									?>
											<a href="index.php?numpage=<?=$pagePro->numpage?>&spec=<?=$pagePro->nomFichier?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numpara=<?=$laDoc->numpara?>&textQte=1&lg=<?=$lg?>" class="gris"><?=$laDoc->titrePara?><br />
											<?=$laDoc->tarif?> &euro;&nbsp;|&nbsp;article réservé aux professionnels&nbsp;|&nbsp;consulter le résumé</a>
									<?php
										} else {//Le professionnel est connecté et la doc n'est pas payante
											if ($nom_fiche) {//le pdf existe (a priori oui, vu que l'on ne prend que les docs avec pdf
									?>
											<a href="ouverturepdf.php?file=<?=$nom_fiche?>" target="_blank"><?=$laDoc->titrePara?></a> (<?=$poids_fiche?>)
									<?php
											}
										}//fin du else if ($laDoc->tarif) 
									
									} else if ($laDoc->tarif) { //La doc n'est pas réservée aux professionnels mais elle est payante
										$pageBdd = new Page();
										$pageBdd->pageSpecifique("publications-ifip-institut-du-porc");
									?>
										<!--<a href="index.php?numpage=<?=$pagePanier->numpage?>&spec=<?=$pagePanier->nomFichier?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numdoc=<?=$laDoc->numpara?>&textQte=1&lg=<?=$lg?>" class="panier"><?=$laDoc->titrePara?></a>-->
					   <a href="index.php?numpage=<?=$pageBdd->numpage?>&spec=<?=$pageBdd->nomFichier?>&numrub=<?=$pageBdd->numrub?>&numcateg=<?=$pageBdd->numcateg?>&numsscateg=<?=$pageBdd->numsscateg?>&numpara=<?=$laDoc->numpara?>&textQte=1&lg=<?=$lg?>" class="gris"><?=$laDoc->titrePara?><br />
					   <?=$laDoc->tarif?> &euro;&nbsp;|&nbsp;consulter le résumé</a>
									<?php
									} else if ($nom_fiche && $laDoc->acces_res=="n" && !$laDoc->tarif) {// La doc n'est pas réservée aux professionnels et elle n'est pas payante
									?> 
										<a href="ouverturepdf.php?file=<?=$nom_fiche?>" target="_blank" class="gris"><?=$laDoc->titrePara?></a> (<?=$poids_fiche?>)
									<?php
									}
									?>
					</td>
					</tr>
			  <?php
			  	   //}//fin if ($nom_fiche) 
			  ?>
			<?php 
		 	}
		 }//fin for ($i=0;$i<count($menuDoc->listdoc);$i++)
		 ?>
		 </table>
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