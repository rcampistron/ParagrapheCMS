<?php /* Date de cration: 23/01/2009 */ 
// Page Boutique
$laPage = new Page();
$laPage->numpage=$numpage;
$laPage->infosPage();
$laPage->infosColonnes(); 

//setlocale(LC_ALL, "french");

// Recuperation des contacts (l'affichage est g&eagrav;r&eacute; plus bas)
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
		
if ($laPage->nomPageGoogle) { 
	if ($numdoc) {
		$laDoc=new Documentation();
		$laDoc->numpara=$numdoc;
		$laDoc->infosDoc();
	}
	
	
	if ($_SESSION['numcom']) {
		$lePanier=new Panier();
		$lePanier->numcom=$_SESSION['numcom'];
		$lePanier->infosPanier();
	}
?>
<div class="item" id="coltexte785">
		   <div class="sap-content">
				<!-- item 1 585 pixels wide or 385 pixels wide -->
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
		<!-- Affichage contenu dynamique -->
		<table width="550" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="250" class="positionnement"><h4>Rechercher un ouvrage <br />
                    </h4></td>
                    <td>&nbsp;</td>
                    <td><h4>Vient de paraître  </h4></td>
                  </tr>
                  <tr>
                    <td class="positionnement">
					Rechercher par thème :<br />
						<select name="selectDom" class="public" OnChange="location='index.php?numpage=<?=$numpage?>&spec=<?=$spec?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&lg=<?=$lg?>&dom='+this.value">
					   <option value="">Les thèmes</option>  
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
						<? if ($dom) { ?>
						<br />&nbsp;<br />&nbsp;<br />
						Affiner par sous thème :<br />
						<?php
						   //On affiche les sous-catégories liées à la catégorie sélectionnée et qui ont des ouvrages
						   $ssdomaines=new ListeMenus(); 
						   $ssdomaines->type="sscateg";
						   $ssdomaines->nomkey="numsscateg";
						   $ssdomaines->numfkey=$dom; 
						   $ssdomaines->lg=$lg;  
						   $nb_ssdom=$ssdomaines->afficherListeMenus();	  
						   if ($nb_ssdom) {	 
							?>
							<select name="selectSsDom" class="public" OnChange="location='index.php?numpage=<?=$numpage?>&spec=<?=$spec?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&lg=<?=$lg?>&dom=<?=$dom?>&ssdom='+this.value">	
							<option value="">S&eacute;lectionner un sous-domaine</option> 
						 <?php
								foreach ($ssdomaines as $menus) {  
									$menus->tri_date=" AND type_doc='5'";
									$nb_doc=$menus->afficherDocs();
									if ($nb_doc) {
						?>
										<option value="<?=$menus->nummenu?>" <?php if ($menus->nummenu==$ssdom) echo "selected='selected'";?>><?=$menus->nomMenu?></option> 
						
						<?php 
									}//fin if($nb_forma)
								} //fin du foreach	
						?>
							</select>
						<?php
							}//fin if ($nb_ssdom)
						} // fin if ($dom)
						?>
						<br />
						
						
						
						<br />
						<?php
				if ($dom) {
				   //On liste les ouvrages de référence liés à la catégorie (en fait ce sont tous les ouvrages des sous-categ dont la categ a été sélectionnée)
				   $tri_date=" AND type_doc='5'";
				     
				   if ($ssdom) {//on a sélectionné un sous-domaine
				  	   $menus_doc=new Menu(); 
					   $menus_doc->type="sscateg";
					   $menus_doc->nummenu=$ssdom;
					   $menus_doc->lg=$lg;
					   $menus_doc->nomkey="numsscateg";
					   $menus_doc->infosMenu();
					   $menus_doc->tri_date=$tri_date;
					   $nb_doc_menu=$menus_doc->afficherDocs(); 
				   } else { //on a sélectionné un domaine uniquement
					   $menus_doc=new Menu(); 
					   $menus_doc->type="categorie";
					   $menus_doc->nomkey="numcateg";
					   $menus_doc->nummenu=$dom;
					   $menus_doc->lg=$lg;
					   $menus_doc->infosMenu();
					   $menus_doc->tri_date=$tri_date;
					   $nb_doc_menu=$menus_doc->afficherDocs();
					   $menus_doc->afficherDocsSousCateg();
				   }
				} else if ($numpara) {//fin if ($dom) - un ouvrage spécifique - après clic sur Vient de paraître
					$listedoc=new ListeParagraphes();
					$listedoc->doc=1;
					$req_doc=" WHERE numpara=".$numpara;
					$listedoc->req_doc=$req_doc;
					$nb_doc_numpara=$listedoc->afficherListeParas();
				
				} else {//fin if ($numpara) - les ouvrages a la une = affichage par défaut (ne pas confondre avec Vient de paraître)
					// les ouvrages a la une
					$listedoc=new ListeParagraphes();
					$listedoc->doc=1;
					$req_doc=" WHERE type_doc='5' AND une='o' ORDER BY date DESC";
					$listedoc->req_doc=$req_doc;
					$nb_doc_une=$listedoc->afficherListeParas();
				
				} //fin if else
				?>
			 <p>&nbsp;<br />
			   </td>
                    <td>&nbsp;</td>
                    <td width="250">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					
					<?php
					$nb_doc=0;
					$dernieresParu=new ListeParagraphes();
					$dernieresParu->doc=1;
					$dernieresParu->req_doc=" WHERE type_doc='5' ORDER BY date DESC LIMIT 0,3";
				    $nb_doc=$dernieresParu->afficherListeParas();
					$pageSpecCommande=new Page();
					$pageSpecCommande->pageSpecifique("panier-ifip-institut-du-porc");
				    if ($nb_doc) {
						foreach ($dernieresParu as $paras) {	
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
						 <a href="index.php?numpage=<?=$numpage?>&spec=<?=$spec?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&lg=<?=$lg?>&numpara=<?=$paras->numpara?>" class="gris"><strong><?=$paras->titrePara?></strong></a>
						  <!--<p>Date : <?php if ($paras->dateLibre) echo $paras->dateLibre; else echo $paras->date;?> </p>-->
						  <?php
						  if ($paras->tarif) {
						  ?>
						  	<br  />
						  	<?=$paras->tarif?> &euro; <a href="index.php?numpage=<?=$pageSpecCommande->numpage?>&spec=<?=$pageSpecCommande->nomFichier?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numdoc=<?=$paras->numpara?>&textQte=1&lg=<?=$lg?>" class="panier">ajouter au panier</a>
						  <?php
						  }
						  ?>
							<br />
							</div>
							</td>
							</tr>
					<?php
						}//fin  de foreach ($dernieresParu as $paras)
					}//fin if ($nb_doc)
					?>
					</table>
					</td>
                  </tr>
             </table>
				 <?php
							 
				 if ($nb_doc_menu) {// Il y a des résultats aux critères sélectionnés de domaine / sous-domaine
				?>
					<?php if ($dom) echo"<h2>Catalogue ".$menus_doc->nomMenu."</h2>";?>
					<div class="positionnement">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabboutique">
				<?php	
						$pageSpec=new Page();
						$pageSpec->pageSpecifique("panier-ifip-institut-du-porc");
						
						for ($i=0;$i<count($menus_doc->listdoc);$i++) { 
							$nom_fiche="";
							$ouvRef=$menus_doc->listdoc[$i];
							$fiche=new ListeFichiers();
							$fiche->numpara= $ouvRef->numpara; 
							$fiche->afficherListeFichiers();
							foreach ($fiche as $fichiers) {
								$nom_fiche=$fichiers->nomFichier;
								break;
							}
							// les photos
							$listphotos=new ListePhotos();
							$listphotos->numpara= $ouvRef->numpara; 
							$nb_photos=$listphotos->afficherListePhotos();
				
				?>
						 
						<tr>
						 <td class="sansmarge">
						 <div class="boutique">
							<div class="titre185">Commander</div>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="85" rowspan="5" class="sansmarge">
					<?php	if ($nb_photos) {
								foreach ($listphotos as $photos) {
					?>				 
								 
								 <?php if ($photos->nomPhoto && file_exists("photos/".$photos->nomPhoto)) { ?>
								 <a href="javascript:if (document.forms[0].textQte<?=$ouvRef->numpara?>.value=='') document.forms[0].textQte<?=$ouvRef->numpara?>.value=1; document.location='index.php?numpage=<?=$pageSpec->numpage?>&amp;spec=<?=$pageSpec->nomFichier?>&amp;numrub=<?=$numrub?>&amp;numcateg=<?=$numcateg?>&amp;numsscateg=<?=$numsscateg?>&amp;numdoc=<?=$ouvRef->numpara?>&amp;textQte='+document.forms[0].textQte<?=$ouvRef->numpara?>.value+'&amp;lg=<?=$lg?>'"><img src="photos/<?=$photos->nomPhoto?>" alt="<?=$ouvRef->titrePara?>" border="0" /></a>
								 <? } 						 
								}?>	
					<?php	}
					?>	
								</td>
                                <td></td>
								<td></td>
							  </tr>
							  <tr height="12">
								<td class="petit">Prix : </td>
								<td class="petit"><?=str_replace(".",",",$ouvRef->tarif)?> &euro;</td>
                              </tr>
							  <tr>
							    <td height="12" class="petit">Qté : </td>
								<td height="12" class="petit"><span class="public">
						 <input id="qte" name="textQte<?=$ouvRef->numpara?>" class="etroit" /></span></td>
						 	  </tr>
							  <tr>
							    <td height="12" class="petit"><span class="panier">&nbsp;</span></td>
								<td class="petit"><a href="javascript:if (document.forms[0].textQte<?=$ouvRef->numpara?>.value=='') alert('Veuillez saisir une quantité !'); else document.location='index.php?numpage=<?=$pageSpec->numpage?>&amp;spec=<?=$pageSpec->nomFichier?>&amp;numrub=<?=$numrub?>&amp;numcateg=<?=$numcateg?>&amp;numsscateg=<?=$numsscateg?>&amp;numdoc=<?=$ouvRef->numpara?>&amp;textQte='+document.forms[0].textQte<?=$ouvRef->numpara?>.value+'&amp;lg=<?=$lg?>'";>ajouter au panier</a></td>
							  </tr>
							  <tr>
							    <td colspan="2"></td>
							  </tr>
                          </table>
						 </div>	 
						 </td>
						 <td width="90%">
						 <h1><?=$ouvRef->titrePara?></h1>
				<?php	 if ($ouvRef->contenuPara) {
				?>
				<p><?=$ouvRef->contenuPara?></p>
				<?php
						}//fin if ($laDoc->contenuPara)
				?></td>
						</tr>
						 <tr>
						   <td>&nbsp;</td>
						   <td>&nbsp;</td>
					      </tr>
						
						<?php	} // fin for ($i=0;$i<count($menus_doc->listdoc);$i++) {
						?>
					  </table>
			  </div>	
				<?php
				 } else if ($nb_doc_une || $nb_doc_numpara) {// 1 doc ou ouvrages de référence à la une
				 ?>
				 	
					
					<br />
					<h2><? if($nb_doc_numpara) {?>Ouvrage récent <? } else {?>Les ouvrages à la une<? } ?></h2>
					<div class="positionnement">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabboutique">
				<?php	
						$pageSpec=new Page();
						$pageSpec->pageSpecifique("panier-ifip-institut-du-porc");
						
						foreach ($listedoc as $paras) {	
							$nom_fiche="";
							$fiche=new ListeFichiers();
							$fiche->numpara= $paras->numpara; 
							$fiche->afficherListeFichiers();
							foreach ($fiche as $fichiers) {
								$nom_fiche=$fichiers->nomFichier;
								break;
							}
							// les photos
							$listphotos=new ListePhotos();
							$listphotos->numpara= $paras->numpara; 
							$nb_photos=$listphotos->afficherListePhotos();
				
				?>
						 
						<tr>
						<td rowspan="2" class="sansmarge">
						<div class="boutique">
							<div class="titre185">Commander</div>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="85" rowspan="5" class="sansmarge">
								<?php	if ($nb_photos) {
											foreach ($listphotos as $photos) {
								?>				 
						 
						 						<a href="javascript:if (document.forms[0].textQte<?=$paras->numpara?>.value=='') document.forms[0].textQte<?=$paras->numpara?>.value=1; document.location='index.php?numpage=<?=$pageSpec->numpage?>&amp;spec=<?=$pageSpec->nomFichier?>&amp;numrub=<?=$numrub?>&amp;numcateg=<?=$numcateg?>&amp;numsscateg=<?=$numsscateg?>&amp;numdoc=<?=$paras->numpara?>&amp;textQte='+document.forms[0].textQte<?=$paras->numpara?>.value+'&amp;lg=<?=$lg?>'">
												<img src="photos/<?=$photos->nomPhoto?>" alt="<?=$paras->titrePara?>" border="0" />												</a>
						 
								<?php		}
									?>		
									<?php
										}
									?>								</td>
                                <td></td>
								<td></td>
							  </tr>
							  <tr height="12">
								<td class="petit">Prix : </td>
								<td class="petit"><?=str_replace(".",",",$paras->tarif)?> &euro;</td>
                              </tr>
							  <tr>
							    <td height="12" class="petit">Qté : </td>
								<td height="12" class="petit"><span class="public">
						 <input id="qte" name="textQte<?=$paras->numpara?>" class="etroit" /></span></td>
						 	  </tr>
							  <tr>
							    <td height="12" class="petit"><span class="panier">&nbsp;</span></td>
								<td class="petit"><a href="javascript:if (document.forms[0].textQte<?=$paras->numpara?>.value=='') alert('Veuillez saisir une quantité !'); else document.location='index.php?numpage=<?=$pageSpec->numpage?>&spec=<?=$pageSpec->nomFichier?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numdoc=<?=$paras->numpara?>&textQte='+document.forms[0].textQte<?=$paras->numpara?>.value+'&lg=<?=$lg?>'";>ajouter au panier</a>								</td>
							  </tr>
							  <tr>
							    <td colspan="2"></td>
							  </tr>
                          </table>
						 </div>
						 </td>
						 <td width="90%">
						 <h1><?=$paras->titrePara?></h1>						 </td>
						 </tr>
						 <tr>
						 <td>
				<?php	 if ($paras->contenuPara) {
				?>
							<p><?=$paras->contenuPara?></p>
				<?php
						}//fin if ($laDoc->contenuPara)
				?>						</td>
						</tr>
						 <tr>
						   <td>&nbsp;</td>
						   <td>&nbsp;</td>
						   <td class="sansmarge">&nbsp;</td>
				      </tr>
						
						<?php	} // fin foreach ($listedoc as $paras)
						?>
					  </table>
					  </div>

				 
				<?php
				} else if ($dom ) {//fin if ($nb_doc_une)
				?>
					<?php if ($dom) echo"<h2>".$menus_doc->nomMenu."</h2>";?>
					<p><strong>Aucun ouvrage ne correspond à vos critères de recherche</strong></p>
				<?php
				}//fin else if ($dom)
				?>
				<!--<hr />-->
				<!-- Fin affichage contenu non dynamique (provenant du CMS)-->		
				
  </div>
</div>
	
<?php


}//fin if ($laPage->nomPageGoogle)
	?>