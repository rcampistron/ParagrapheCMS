<?php /* Date de création: 11/02/2009 */ 
// gestion de l'affichage page à page (suite et retour)
if (!isset($suite)) $suite=0;
if (!isset($pageactive)) $pageactive=1;
if (!isset($nbdocsparpage)) $nbdocsparpage=50;
$su=$suite-$nbdocsparpage; // -5 -> 0
$suite+=$nbdocsparpage; // 5 -> 10
$s=$suite-$nbdocsparpage; // 0 -> 5

?>
<?php
if (!$dom && !$rech && !$rechauteur && !$type_doc && !$annee && !$numpara) {
?>
<table width="<? if ($spec=="extranet-pro") echo"785"; else echo"550";?>" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="280" class="positionnement"><h4>Rechercher dans la base documentaire </h4></td>
                    <td width="30"><img src="images/im-blanc.gif" alt="" width="30" height="5" /></td>
                    <td width="627"><h4>Vient de paraître  </h4></td>
                  </tr>
                  <tr>
                    <td class="positionnement">
					<strong>Recherche par thème :</strong><br />
					<select name="selectDom" class="public" OnChange="location='index.php?numpage=<?=$numpage?>&spec=<?=$spec?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&lg=<?=$lg?>&dom='+this.value">
				   <option value=""></option>  
				   <?php
				   $numr=SelectSimple("numrub","if_rubrique","1","1"," AND nom LIKE 'domaines d\'Expertise'");//numro de la rubrique correspondant  "Domaine d'expertise"
				   $domaines=new ListeMenus(); 
				   $domaines->type="categorie";
				   $domaines->nomkey="numcateg";
				   $domaines->numfkey=$numr;
				   if ($_SESSION['numprof']) {
				   	$clients=new Client();
					$clients->numclient=$_SESSION['numprof'];
					$clients->infosClient();
				   	if ($spec=="extranet-pro") $domaines->amont=$clients->amont; 
					if ($spec=="extranet-pro") $domaines->aval=$clients->aval;
				   }
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
				
					
			<!-- Désactivé le 20/03/2009	 	
			<select name="selectTypeDoc" class="public"  OnChange="location='index.php?numpage=<?=$numpage?>&spec=<?=$spec?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&lg=<?=$lg?>&dom=<?=$dom?>&ssdom=<?=$ssdom?>&type_doc='+this.value">
				    
					<option value="">S&eacute;lectionner un type de document</option>  
					<?php
					$result=mysql_query("SELECT * FROM if_type_doc ORDER BY nom");
					while ($row=mysql_fetch_array($result)) {
					?>
							<option value="<?=$row["type_doc"]?>" <?php if ($type_doc==$row["type_doc"]) echo "selected='selected'";?>><?=$row["nom"]?></option>
					<?php
					}//fin du wile
					?>
		     </select>
			 -->
			<!-- Mis en commentaire le 09/02/2009
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="selectAn" class="public"  OnChange="location='index.php?numpage=<?=$numpage?>&spec=<?=$spec?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&lg=<?=$lg?>&dom=<?=$dom?>&ssdom=<?=$ssdom?>&type_doc='+this.form.elements['selectTypeDoc'].options[this.form.elements['selectTypeDoc'].selectedIndex].value+'&annee='+this.value">
				    <option value="">S&eacute;lectionner une ann&eacute;e</option>  
				    <?php
					for ($i=(date("Y")-5);$i<=(date("Y")+5);$i++) {
					?>
						<option value="<?=$i?>" <?php if ($annee==$i) echo "selected='selected'";?>><?=$i?></option>
					
					<?php
					}//fin du for
					?>					
		     </select>
			 -->
			 <strong>Recherche par mots-clés </strong><br /> 
			 <input type="text" name="textRech" id="textRech" class="public" onfocus="MontrerCalque('attente')" onkeyup="ajax('fonctions_ajax2.php?numpage=<?=$numpage?>&amp;spec=<?=$spec?>&amp;numrub=<?=$numrub?>&amp;numcateg=<?=$numcateg?>&amp;numsscateg=<?=$numsscateg?>&amp;lg=<?=$lg?>&amp;id=<?=$id?>', 'suggestion', 'attente','POST', 'null', 'textRech','null');"  />
			 <strong>Recherche par auteur </strong><br /> 
			 <input type="text" name="textRechAut" id="textRechAut" class="public" onfocus="MontrerCalque('attente')" onkeyup="ajax('fonctions_ajax2.php?numpage=<?=$numpage?>&amp;spec=<?=$spec?>&amp;numrub=<?=$numrub?>&amp;numcateg=<?=$numcateg?>&amp;numsscateg=<?=$numsscateg?>&amp;lg=<?=$lg?>&amp;id=<?=$id?>', 'suggestion', 'attente','POST', 'null', 'textRechAut','null');"  />
			 <div id="attente">
             <strong>Pour rechercher une documentation<br />
                           veuillez saisir au moins les 3 premières lettres 
                          du mot-clé ou du nom de l'auteur et patienter pendant la 
						  génération de la liste de suggestion</strong>
                     </div>
			<div id="suggestion"></div> 
			 <p>&nbsp;<br />
			   </td>
                    <td>&nbsp;</td>
                    <td width="<? if ($spec=="extranet-pro") echo"465"; else echo"280";?>">
					  <table width="100%" border="0" cellspacing="0" cellpadding="0">
					<?php
					$nb_doc=0;
					$dernieresParu=new ListeParagraphes();
					$dernieresParu->doc=1;
					$req_doc=" WHERE  publiee='o' AND acces_res!='o' AND type_doc!='5' ORDER BY date DESC LIMIT 0,4";
				    if ($spec=="extranet-pro") $req_doc=" WHERE  publiee='o' AND acces_res='o' AND type_doc!='5' 
					ORDER BY date DESC LIMIT 0,4";
					$dernieresParu->req_doc=$req_doc;
					$nb_doc=$dernieresParu->afficherListeParas();
					$pageSpecCommande=new Page();
					$pageSpecCommande->pageSpecifique("panier-ifip-institut-du-porc");
					$pageSpecLien=new Page();
					if ($spec=="extranet-pro") $pageSpecLien->pageSpecifique("extranet-pro");
					else $pageSpecLien->pageSpecifique("publications-ifip-institut-du-porc");
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
						 <td width="99%"><div class="petit"><a href="index.php?spec=<?=$pageSpecLien->nomFichier?>&numpage=<?=$pageSpecLien->numpage?>&numrub=<?=$pageSpecLien->numrub?>&numcateg=<?=$pageSpecLien->numcateg?>&numsscateg=<?=$pageSpecLien->numsscateg?>&lg=<?=$pageSpecLien->lg?>&numpara=<?=$paras->numpara?>" class="gris"><strong><?=$paras->titrePara?></strong></a></strong> <!--(<?php if ($paras->dateLibre) echo $paras->dateLibre; else echo $paras->date;?> )-->
						  <?php
						  if ($paras->tarif) {
						  ?>
						  	<br />
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
} // fin if (!$dom && !$rech)
?>
<?php /*----------------------- Recherche de documents -----------------------------------*/
if ($dom) {
	//On liste les documentations liées à la catégorie (en fait ce sont toutes les documentations des sous-categ dont la categ a été sélectionnée)
	if ($annee) {//on a sélectionné un critère de date
		$date_deb=mktime(0,0,0,1,1,$annee);
		$date_fin=mktime(23,59,59,12,31,$annee);
		$tri_date=" AND (date BETWEEN $date_deb AND $date_fin)";
	}
					
	if ($type_doc) {//on a sélectionné un type de document
		$tri_date.=" AND type_doc='$type_doc'";
	}
					
	if ($spec=="extranet-pro") $tri_date.=" AND acces_res='o'";
					   
	if ($ssdom) {//on a sélectionné un sous-domaine
		$menus_doc=new Menu(); 
		$menus_doc->type="sscateg";
		$menus_doc->nummenu=$ssdom;
		$menus_doc->lg=$lg;
		$menus_doc->nomkey="numsscateg";
		$menus_doc->infosMenu();
		$menus_doc->tri_date=$tri_date;
		$nb_doc_menu=$menus_doc->afficherDocs(); 
		$total=$nb_doc_menu;
	} else { //on a sélectionné un domaine uniquement - mais on va chercher TOUTES les docs de la categ et de ses sscateg
		$menus_doc=new Menu(); 
		$menus_doc->type="categorie";
		$menus_doc->nomkey="numcateg";
		$menus_doc->nummenu=$dom;
		$menus_doc->lg=$lg;
		$menus_doc->infosMenu();
		$menus_doc->tri_date=$tri_date;
		$nb_doc_menu=$menus_doc->afficherDocs();// true ou false, pas une valeur
		$menus_doc->afficherDocsSousCateg(); //on ajoute les docs liées à la souscateg aussi
		$total=count($menus_doc->listdoc); //car $nb_doc_menu de afficherDocsSousCateg() renvoi juste true ou false et listdoc est incrémenté dans afficherDocsSousCateg()
	}
				
} else if ($type_doc) {//fin if ($dom) : on a sélectionné un type de document mais pas une catég ni sous-categ => n'est plus utilisé
					$listdoc=new ListeParagraphes();
					$listdoc->doc=1;
					$listdoc->docvcourte=1;
					$req_doc=" WHERE type_doc='$type_doc' AND publiee='o'";
					if ($spec=="extranet-pro") $req_doc.=" AND acces_res='o'";
					$req_doc.=" ORDER BY date DESC"; //remise en service (plus de tri sur le tableau des objets)
					$listdoc->req_doc=$req_doc;
					$listdoc->borneinf=$s;
					$listdoc->bornesup=$nbdocsparpage;
  					$nb_doc_type=$listdoc->afficherListeParas();
					$total=$nb_doc_type;
} else if ($annee) {//fin else if ($type_doc) : on a sélectionné l'année mais pas une catég ni sous-categ => n'est plus utilisé
					$listdoc=new ListeParagraphes();
					$listdoc->doc=1;
					$date_deb=mktime(0,0,0,1,1,$annee);
					$date_fin=mktime(23,59,59,12,31,$annee);
					$req_doc=" WHERE (date BETWEEN $date_deb AND $date_fin) AND publiee='o'";
					if ($type_doc) $req_doc.=" AND type_doc='$type_doc'";// on a sélectionné un type de document
					if ($spec=="extranet-pro") $req_doc.=" AND acces_res='o'";
					$req_doc.=" ORDER BY date DESC";
					$listdoc->req_doc=$req_doc;
  					$nb_doc_date=$listdoc->afficherListeParas();
} else if ($rech) {//fin else if ($annee) : recherche par mots-clés (suggestion de contenu)
				    $listdoc=new ListeParagraphes();
					$listdoc->doc=1;
					$listdoc->docvcourte=1;
					$keyw_majuscule=Majuscules($rech);
					$keyw_lettre=Majuscules(substr($rech,0,1)).substr($rech,1);
					$keyw_lettre2=ajoutAccents(substr($rech,0,1)).substr($rech,1);//première lettre accentuée (économie)
					$req_doc=" WHERE (keyw LIKE '%$rech%' OR keyw LIKE '%$keyw_majuscule%' 
					OR keyw LIKE '%$keyw_lettre%' OR keyw LIKE '%$keyw_lettre2%') AND publiee='o'";
					if ($spec=="extranet-pro") $req_doc.=" AND acces_res='o'";
					$req_doc.="ORDER BY date DESC"; //remis en service (plus de tri sur le tableau des objets)
					$listdoc->req_doc=$req_doc;
					$listdoc->borneinf=$s;
					$listdoc->bornesup=$nbdocsparpage;
  					$nb_doc_rech=$listdoc->afficherListeParas();
					$total=$nb_doc_rech;
} else if ($rechauteur) {//fin else if ($rech) : recherche par auteur (suggestion de contenu)
					$listdoc=new ListeParagraphes();
					$listdoc->doc=1;
					$listdoc->docvcourte=1;
					$aut_majuscule=Majuscules($rechauteur);
					$aut_lettre=Majuscules(substr($rechauteur,0,1)).substr($rechauteur,1);
					$req_doc=" WHERE (auteur LIKE '%$rechauteur%' OR auteur LIKE '%$aut_majuscule%' 
					OR auteur LIKE '%$aut_lettre%') AND publiee='o'";
					if ($spec=="extranet-pro") $req_doc.=" AND acces_res='o'";
					$req_doc.="ORDER BY date DESC"; //remis en service (plus de tri sur le tableau des objets)
					$listdoc->req_doc=$req_doc;
					$listdoc->borneinf=$s;
					$listdoc->bornesup=$nbdocsparpage;
  					$nb_doc_rech=$listdoc->afficherListeParas();
					$total=$nb_doc_rech;
} else if ($numpara) {//fin else if ($rech) : 1 doc de sélectionnée (par ex via la page d'accueil)
					$listdoc=new ListeParagraphes();
					$listdoc->doc=1;
					$listdoc->docvcourte=1;
					$req_doc=" WHERE numpara=".$numpara;
					$listdoc->req_doc=$req_doc;
					$listdoc->borneinf=$s;
					$listdoc->bornesup=$nbdocsparpage;
  					$nb_doc_numpara=$listdoc->afficherListeParas();
					$total=$nb_doc_numpara;
				
				
} // fin else if ($numpara)
?>
<?php /*----------------- Affichage des resultats ---------------------------------------------------------*/
							 
if ($nb_doc_menu || $nb_doc_date || $nb_doc_type || $nb_doc_rech || $nb_doc_numpara) {// Il y a des résultats aux critères sélectionnés
				?>
					<div class="positionnement">
					<h4><?php echo"Résultat de la recherche"; ?></h4>
					<table width="550" border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td width="100">
						<?php 
						if ($dom) echo"Thème : "; 
						else if ($rech) echo"Mots clés : ";
						else if ($rechauteur) echo"Auteur : ";
						else if ($type_doc) echo"Revue ou Lettre : ";
						?></td>
						<td width="380"><strong><?php if ($dom) echo SelectSimple('nom','if_categorie','numcateg',$dom); else if ($rech) echo stripslashes($rech); else if ($rechauteur) echo Majuscules($rechauteur); else if ($type_doc) echo SelectSimple("nom","if_type_doc","type_doc",$type_doc);?></strong></td>
					  </tr>
					  <tr>
						<td><?php if ($dom) echo"Affiner par sous thème : "?></td>
						<td>
						<?php if ($dom) {
							//On affiche les sous-catégories liées à la catégorie sélectionnée et qui ont des documentations
							$ssdomaines=new ListeMenus(); 
							$ssdomaines->type="sscateg";
							$ssdomaines->nomkey="numsscateg";
							$ssdomaines->numfkey=$dom; 
							$ssdomaines->lg=$lg;  
							$nb_ssdom=$ssdomaines->afficherListeMenus();	  
							if ($nb_ssdom) {	 
							?>
								<select name="selectSsDom" class="public" OnChange="location='index.php?numpage=<?=$numpage?>&spec=<?=$spec?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&lg=<?=$lg?>&dom=<?=$dom?>&ssdom='+this.value">	
								<option value=""></option> 
								<?php
								foreach ($ssdomaines as $menus) {  
									if ($spec=="extranet-pro") $menus->tri_date=" AND acces_res='o'";
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
						
						
						}
						?></td>
					  </tr>
					  <tr>
					    <td colspan="2"> 
						<?php
						$pageSpecNewRecherche=new Page();
						if ($spec=="extranet-pro") $pageSpecNewRecherche->pageSpecifique("extranet-pro"); 
						else $pageSpecNewRecherche->pageSpecifique("publications-ifip-institut-du-porc");
					?>
						 <a href="index.php?spec=<?=$pageSpecNewRecherche->nomFichier?>&numpage=<?=$pageSpecNewRecherche->numpage?>&numrub=<?=$pageSpecNewRecherche->numrub?>&numcateg=<?=$pageSpecNewRecherche->numcateg?>&numsscateg=<?=$pageSpecNewRecherche->numsscateg?>&lg=<?=$pageSpecNewRecherche->lg?>">Cliquez ici pour effectuer une nouvelle recherche</a>
						</td>
				      </tr>
					</table>
					<table width="785" border="0" cellpadding="5" cellspacing="0">
						<?php
  		
						if ($total) 
						if ($total) {
							$nb_pages=ceil($total/$nbdocsparpage);
				  		?>
							<tr>
							  <td colspan="5" align='center'>
							  <strong>
							 <?php
								echo $total." document(s)";
								echo"<br />";
								$de=$s+1;
								if ($suite>$total) echo"documents ".$de." à ".$total; else echo"&nbsp;documents ".$de." à ".$suite;
							  ?>
							 </strong>
							  <br />
							  <br />
							  Pages :  
							 <?php
							 //accès direct à une page
							 for ($page=1;$page<=$nb_pages;$page++) {
								$destination=$nbdocsparpage*($page-1);
								?>
									<? if ($page!=$pageactive) {?><a href="javascript:document.forms[0].suite.value=<? echo $destination?>;document.forms[0].pageactive.value=<?=$page?>;document.forms[0].submit();"><? } ?><strong><?=$page?></strong><? if ($page!=$pageactive) {?></a><? } ?>
							<?php
							 }
							?>
							</td></tr>
				  <?php			
						}//fin if ($nb_doc_def || $nb_doc_critere)
				  ?>
						
						<tr class="entete">
						  <td>&nbsp;</td>
						  <td width="595"><div align="left">Publication</div></td>
							<td width="143" align="left">Année</td>
							<td width="143" align="left">Type</td>
							<td width="200" align="left">Obtenir</td>
						</tr>
						<?php
						if ($nb_doc_menu) { //documentations liées à la categ ou sous-categ (et éventuellement au type de doc et à la date)
							$k="fond_clair2";
							$n=1; // numero de ligne
							for ($i=$s;$i<$suite;$i++) {
							//for ($i=0;$i<count($menus_doc->listdoc);$i++) { 
								if ($k=="fond_clair") $k="fond_clair2"; else $k="fond_clair";
								$nom_fiche="";
							  if ($menus_doc->listdoc[$i]) {
								$laDoc=$menus_doc->listdoc[$i];
								$fiche=new ListeFichiers();
								$fiche->numpara=$laDoc->numpara; 
								$fiche->afficherListeFichiers();
								foreach ($fiche as $fichiers) {
									$nom_fiche=$fichiers->nomFichier;
									$poids_fiche=$fichiers->poidsFichier;
									break; 
								}
						?>
								<tr class="<? echo $k; if ($laDoc->contenuPara) echo" highlight";?> ">
								  <td ><?=$n?></td>
									<td ><?=$laDoc->titrePara?>
									<?php
									if ($laDoc->contenuPara) {
										if ($laDoc->acces_res!="o" || ($laDoc->acces_res=="o" && $_SESSION['numprof'])) {
									?>
									<br /><a href="javascript: montrerDoc('doc<?=$laDoc->numpara?>')" class="petit gris plus">Consulter le résumé</a>
										<br />
										<div id="doc<?=$laDoc->numpara?>" style="visibility:hidden; height:0px;margin:10px;">
											<div class="positionnement"><?=$laDoc->contenuPara?></div>
										</div>	
									<?php
										}
									}//fin if ($laDoc->contenuPara)
									?>									</td>
									<td><?php if ($laDoc->anneeDoc) echo $laDoc->anneeDoc; //else echo $laDoc->date_libre;?></td>
									<td class="petit"><?=$laDoc->nom_type_doc?></td>
									<td>
									<div class="petit">
									<?php
									/*---------------- La doc est réservée aux Professionnels -------------------------------*/
									if ($laDoc->acces_res=="o") {//La doc est réservée aux Professionnels
										
										$pagePro = new Page();
										$pagePro->pageSpecifique("extranet-pro");
									
										if (!$_SESSION['numprof']) {//Le professionnel n'est pas connecté
									?>
									  <a href="index.php?numpage=<?=$pagePro->numpage?>&spec=<?=$pagePro->nomFichier?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numdoc=<?=$laDoc->numpara?>&lg=<?=$lg?>" class="reserve">Rapport réservé Espace Pro<br />
									  Veuillez vous identifier</a>
									<?php
										} else if ($laDoc->tarif) {//Le professionnel est connecté et la doc est payante
											$pagePanier = new Page();
											$pagePanier->pageSpecifique("panier-ifip-institut-du-porc");
									?>
											<a href="index.php?numpage=<?=$pagePanier->numpage?>&spec=<?=$pagePanier->nomFichier?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numdoc=<?=$laDoc->numpara?>&textQte=1&lg=<?=$lg?>" class="panier"><?=$laDoc->tarif;?> &euro; commander </a>
									<?php
										} else {//Le professionnel est connecté et la doc n'est pas payante 
											if ($nom_fiche) {//le pdf existe
									?>
											<a href="ouverturepdf.php?file=<?=$nom_fiche?>" target="_blank" class="pdf">Télécharger ce rapport (<?=$poids_fiche?>)</a>
									<?php
											} else {//pas de pdf à télécharger
											
											$pageContactPasdeDoc = new Page();
											$pageContactPasdeDoc->pageSpecifique("contact");
									?>
											Ce rapport est sous copyright ou indisponible. 
											Merci de contacter <?=$leContact->prenom." ".$leContact->nom?> 
						  					par tél <? if($leContact->tel) echo $leContact->tel;?> 
						  ou <a href="index.php?spec=contact&numpage=<?=$pageContactPasdeDoc->numpage?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numcontact=<?=$leContact->numcontact?>&lg=<?=$lg?>">Email</a>
									<?php
											} //fin else (pas de de pdf)
										}//fin du else if ($paras->tarif) 
									
									/*---------------- Doc non réservée MAIS payante -------------------------------*/
									} else if ($laDoc->tarif) { //La doc n'est pas réservée aux professionnels mais elle est payante
										$pagePanier = new Page();
										$pagePanier->pageSpecifique("panier-ifip-institut-du-porc");
										if ($nom_fiche || $laDoc->type_doc=="5") {//le pdf est bien en ligne !!!
									?>
											<a href="index.php?numpage=<?=$pagePanier->numpage?>&spec=<?=$pagePanier->nomFichier?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numdoc=<?=$laDoc->numpara?>&textQte=1&lg=<?=$lg?>" class="panier"><?=$laDoc->tarif?> &euro; commander cette référence</a>
										<?php
										} else {
											$pageContactPasdeDoc = new Page();
											$pageContactPasdeDoc->pageSpecifique("contact");
										?>
											Cet article est sous copyright ou indisponible. 
											Merci de contacter <?=$leContact->prenom." ".$leContact->nom?> 
						  					par tél <? if($leContact->tel) echo $leContact->tel;?> 
						  ou <a href="index.php?spec=contact&numpage=<?=$pageContactPasdeDoc->numpage?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numcontact=<?=$leContact->numcontact?>&lg=<?=$lg?>">Email</a>
										
										<?php
										}
										?>
									<?php
									/*---------------- Doc non réservée + n'est pas payante -------------------------------*/
									
									} else if ($laDoc->acces_res=="n" && !$laDoc->tarif) {
										if ($nom_fiche) {//le pdf existe
									?>
											<a href="ouverturepdf.php?file=<?=$nom_fiche?>" target="_blank" class="pdf">Télécharger cet article (<?=$poids_fiche?>)</a>
									<?php
										} else {//pas de pdf à télécharger
											$pageContactPasdeDoc = new Page();
											$pageContactPasdeDoc->pageSpecifique("contact");
									?>
											Cet article est sous copyright ou indisponible. 
											Merci de contacter <?=$leContact->prenom." ".$leContact->nom?> 
						  					par tél <? if($leContact->tel) echo $leContact->tel;?> 
						  ou <a href="index.php?spec=contact&numpage=<?=$pageContactPasdeDoc->numpage?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numcontact=<?=$leContact->numcontact?>&lg=<?=$lg?>">Email</a>
									<?php
										} //fin else (pas de de pdf)
									}
									?>
									</div>									</td>
								</tr>
						<?php
							  } // fin if ($menus_doc->listdoc[$i])
							  $n++;
							}//fin du for ($i=$s;$i<$suite;$i++)
/* -------------------- DOCUMENTATIONS LIEES A UN TYPE DE DOC OU A UN NUMPARA OU A UNE RECHERCHE MOT CLE OU AUTEUR --------- */							
						 } else if ($nb_doc_date || $nb_doc_type || $nb_doc_rech || $nb_doc_numpara) {//fin if ($nb_doc_menu) : documentations liées à la date et/ou au type de doc
						 	$n=1;
							$k="fond_clair2";
							foreach ($listdoc as $paras) {	
								if ($k=="fond_clair") $k="fond_clair2"; else $k="fond_clair";
								//On récupère les infos complètes de la doc (on n'a stocké que l'année dans le tableau $paras[])
							    $laDoc=new Documentation();
							    $laDoc->numpara=$paras->numpara;
							    $laDoc->infosDoc();
								$nom_fiche="";
								$fiche=new ListeFichiers();
								$fiche->numpara= $paras->numpara; 
								$fiche->afficherListeFichiers();
								foreach ($fiche as $fichiers) {
									$nom_fiche=$fichiers->nomFichier;
									$poids_fiche=$fichiers->poidsFichier;
									break;
								}
						?>
								<tr class="<? echo $k; if ($laDoc->contenuPara) echo" highlight";?>">
								  <td><?=$n?></td>
									<td><?=$laDoc->titrePara?>
									<?php
									if ($laDoc->contenuPara) {
										if ($laDoc->acces_res!="o" || ($laDoc->acces_res=="o" && $_SESSION['numprof'])) {
									?>
									<br /><a href="javascript: montrerDoc('doc<?=$laDoc->numpara?>')" class="petit gris plus">Consulter le résumé</a>
										<br />
										<div id="doc<?=$laDoc->numpara?>" style="visibility:hidden; height:0px;margin:10px;">
											<div class="positionnement"><?=$laDoc->contenuPara?></div>
										</div>	
									<?php
										}// fin if (la doc n'est pas réservée ou le professionnel est connecté
									}//fin if ($paras->contenuPara)
									?>									
									</td>
									<td><?php if ($laDoc->anneeDoc) echo $laDoc->anneeDoc;?></td>
									<td class="petit"><?=$laDoc->nom_type_doc?></td>
									<td>
									<div class="petit">
									<?php
									if ($laDoc->acces_res=="o") {//La doc est réservée aux Professionnels
										
										$pagePro = new Page();
										$pagePro->pageSpecifique("extranet-pro");
									
										if (!$_SESSION['numprof']) {//Le professionnel n'est pas connecté
									?>
									  <a href="index.php?numpage=<?=$pagePro->numpage?>&spec=<?=$pagePro->nomFichier?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numdoc=<?=$laDoc->numpara?>&lg=<?=$lg?>" class="reserve">Rapport réservé Espace Pro<br />
									  Veuillez vous identifier</a>
									<?php
										} else if ($laDoc->tarif) {//Le professionnel est connecté et la doc est payante
											$pagePanier = new Page();
											$pagePanier->pageSpecifique("panier-ifip-institut-du-porc");
									?>
											<a href="index.php?numpage=<?=$pagePanier->numpage?>&spec=<?=$pagePanier->nomFichier?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numdoc=<?=$laDoc->numpara?>&textQte=1&lg=<?=$lg?>" class="panier"><?=$laDoc->tarif?> &euro; commander </a>
									<?php
										} else {//Le professionnel est connecté et la doc n'est pas payante
											if ($nom_fiche) {//le pdf existe
									?>
											<a href="ouverturepdf.php?file=<?=$nom_fiche?>" target="_blank" class="pdf">Télécharger ce rapport (<?=$poids_fiche?>)</a>
									<?php
											} else {//pas de pdf à télécharger
											
											$pageContactPasdeDoc = new Page();
											$pageContactPasdeDoc->pageSpecifique("contact");
									?>
											Ce rapport est indisponible ou sous copyright. 
											Merci de contacter <?=$leContact->prenom." ".$leContact->nom?> 
						  					par tél <? if($leContact->tel) echo $leContact->tel;?> 
						  ou <a href="index.php?spec=contact&numpage=<?=$pageContactPasdeDoc->numpage?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numcontact=<?=$leContact->numcontact?>&lg=<?=$lg?>">Email</a>
									<?php
											} //fin else (pas de de pdf)
										}//fin du else (!$paras->tarif) 
									
									} else if ($laDoc->tarif) { //La doc n'est pas réservée aux professionnels mais elle est payante
										$pagePanier = new Page();
										$pagePanier->pageSpecifique("panier-ifip-institut-du-porc");
									if ($nom_fiche || $laDoc->type_doc=="5") {//le pdf est bien en ligne !!!
									?>
											<a href="index.php?numpage=<?=$pagePanier->numpage?>&spec=<?=$pagePanier->nomFichier?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numdoc=<?=$laDoc->numpara?>&textQte=1&lg=<?=$lg?>" class="panier"><?=$laDoc->tarif?> &euro; commander cette référence</a>
										<?php
										} else {
											$pageContactPasdeDoc = new Page();
											$pageContactPasdeDoc->pageSpecifique("contact");
										?>
											Cet article est sous copyright ou indisponible. 
											Merci de contacter <?=$leContact->prenom." ".$leContact->nom?> 
						  					par tél <? if($leContact->tel) echo $leContact->tel;?> 
						  ou <a href="index.php?spec=contact&numpage=<?=$pageContactPasdeDoc->numpage?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numcontact=<?=$leContact->numcontact?>&lg=<?=$lg?>">Email</a>
										
										<?php
										}
										?>
									<?php
									} else if ($laDoc->acces_res=="n" && !$laDoc->tarif) {// La doc n'est pas réservée aux professionnels et elle n'est pas payante
									if ($nom_fiche) {//le pdf existe
									?>
											<a href="ouverturepdf.php?file=<?=$nom_fiche?>" target="_blank" class="pdf">Télécharger cet article (<?=$poids_fiche?>)</a>
									<?php
											} else {//pas de pdf à télécharger
											$pageContactPasdeDoc = new Page();
											$pageContactPasdeDoc->pageSpecifique("contact");
									?>
											Cet article est indisponible ou sous copyright. 
											Merci de contacter <?=$leContact->prenom." ".$leContact->nom?> 
						  					par tél <? if($leContact->tel) echo $leContact->tel;?> 
						  ou <a href="index.php?spec=contact&numpage=<?=$pageContactPasdeDoc->numpage?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numcontact=<?=$leContact->numcontact?>&lg=<?=$lg?>">Email</a>
									<?php
											} //fin else (pas de de pdf)
									}
									?>									</td>
								</tr>
						<?php
								$n++;
							}//fin de foreach ($listdoc as $paras)
						}//fin else if ($nb_doc_date || $nb_doc_type) 
						?>
						<tr>
						  <td>&nbsp;</td>
						  <td><img src="images/im-blanc.gif" alt="" width="400" height="5" /></td>
						  <td></td>
						  <td></td>
						  <td><img src="images/im-blanc.gif" alt="" width="200" height="5" /></td>
						</tr>
			 </table>
			  </div>	
<?php
} else if ($dom || $annee || $type_doc || $rech || $rechauteur) {//fin if ($nb_doc_menu || $nb_doc_date || $nb_doc_type)
?>
	<div class="positionnement">
					<h4><?php echo"Résultat de la recherche"; ?></h4>
					<table width="550" border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td width="100">
						<?php 
						if ($dom) echo"Thème : "; 
						else if ($rech) echo"Mots clés : ";
						 else if ($rechauteur) echo"Auteur : ";
						?></td>
						<td width="380"><strong><?php if ($dom) echo $menus_doc->nomMenu; else if ($rech) echo $rech; else if ($rechauteur) echo Majuscules($rechauteur);?></strong></td>
					  </tr>
					  <tr>
					    <td colspan="2">
						<br />
						<strong>Aucune documentation ne correspond à vos critères de recherche</strong>
						<?php
						$pageSpecNewRecherche=new Page();
						if ($spec=="extranet-pro") $pageSpecNewRecherche->pageSpecifique("extranet-pro"); 
						else $pageSpecNewRecherche->pageSpecifique("publications-ifip-institut-du-porc");
					?>
						 <br /><a href="index.php?spec=<?=$pageSpecNewRecherche->nomFichier?>&numpage=<?=$pageSpecNewRecherche->numpage?>&numrub=<?=$pageSpecNewRecherche->numrub?>&numcateg=<?=$pageSpecNewRecherche->numcateg?>&numsscateg=<?=$pageSpecNewRecherche->numsscateg?>&lg=<?=$pageSpecNewRecherche->lg?>">Cliquez ici pour effectuer une nouvelle recherche</a>
						<br />
						<br />
						</td>
				      </tr>
					</table>
					</div>
					
<?php
}//fin else if ($dom || $annee)
?>
<input type="hidden" name="suite" value="<?=$suite?>" />
<input type="hidden" name="pageactive" value="<?=$pageactive?>" />
<input type="hidden" name="critere" value="<?=$critere?>" />
<input type="hidden" name="type_doc" value="<?=$type_doc?>" />
<input type="hidden" name="rech" value="<?=$rech?>" />
<input type="hidden" name="rechauteur" value="<?=$rechauteur?>" />
<input type="hidden" name="dom" value="<?=$dom?>" />
<input type="hidden" name="ssdom" value="<?=$ssdom?>" />