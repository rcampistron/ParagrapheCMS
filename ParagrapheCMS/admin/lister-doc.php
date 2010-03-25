<?php /* Date de création: 19/12/2008 */ 
// gestion de l'affichage page à page (suite et retour)
if (!isset($suite)) $suite=0;
if (!isset($pageactive)) $pageactive=1;
if (!isset($nbdocsparpage)) $nbdocsparpage=50;
$su=$suite-$nbdocsparpage; // -5 -> 0
$suite+=$nbdocsparpage; // 5 -> 10
$s=$suite-$nbdocsparpage; // 0 -> 5

?>

<div class="item" id="coltexteAdmin">
	<div class="sap-content">
<div id="pageadmin">
  <h2>Liste des documentations</h2>  
   <p><br /><br />
   <a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=ajouter-doc">Ajouter une documentation</a>
   <br />
   <br />
   </p>
   <h4>Rechercher des documentations</h4><br />
   <fieldset>
   <ol><li>
     <label>Sans critère :&nbsp; </label>
     &nbsp;<a href="index.php?id=<?=$id?>&amp;cnx=<?=$cnx?>&amp;pg_admin=<?=$pg_admin?>&amp;touteladoc=o">Afficher toutes les documentations</a>   </li>
   <li>
   <label>Par thème :</label>
   <select name="selectDom" class="public" OnChange="location='index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&dom='+this.value">
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
	  </li>
	  <?php
	  if ($dom) {
	  ?>
	  <li><label>Affiner par sous-thème :</label>
	  <?php
	  
	  	//On affiche les sous-catégories liées à la catégorie sélectionnée et qui ont des documentations
		$ssdomaines=new ListeMenus(); 
		$ssdomaines->type="sscateg";
		$ssdomaines->nomkey="numsscateg";
		$ssdomaines->numfkey=$dom; 
		$ssdomaines->lg=$lg;  
		$nb_ssdom=$ssdomaines->afficherListeMenus();	  
		if ($nb_ssdom) {	 
		?>
			<select name="selectSsDom" class="public" OnChange="location='index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&dom=<?=$dom?>&ssdom='+this.value">	
			<option value="">S&eacute;lectionner un sous-domaine</option> 
			<?php
			foreach ($ssdomaines as $menus) {  
				if ($spec=="extranet-pro") $menus->tri_date=" AND acces_res='o'";
				$nb_doc=$menus->afficherDocs();
				if ($nb_doc) {
				?>
					<option value="<?=$menus->nummenu?>" <?php if ($menus->nummenu==$ssdom) echo "selected='selected'";?>><?=$menus->nomMenu?></option> 
				
			<?php 
				}//fin if($nb_doc)
			} //fin du foreach	
			?>
			</select>
		<?php
		}//fin if ($nb_ssdom)

		?>	
		</li>
	  <?php
	  } // fin if ($dom)
	  ?>
	  <li><label>Par type de document :</label>
	  <?php
	  
	  
	  
	  
	  ?>
	  <select name="selectTypeDoc" OnChange="location='index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&dom=<?=$dom?>&ssdom=<?=$ssdom?>&type_doc='+this.value" class="large">
				    
					<option value="">S&eacute;lectionner un type de document</option>  
					<?php
					$TypeAIgnorer=array(
						13,14,17,18,19,
						20,21,22,23,24,25,26,27,28,29,
						30,31,32,33,34,35,36,37,38,39,
						40,41,42,43,44,45,46,47,48,49,
						50,51,52,53,54,55,56,57,58,59,
						60,61,62,63,64,66,67,68,69,
						70,71,72,73,74,75,76,77,78,79,
						80,82,83,83,84,85,86,87,88,89,
						90,91,92,93,94,95,96,97,98,99,
						100,101,102,103,104,105,106,107,108,109,
						110,111,112,113,114,115,117,118,119,
						120,121,122,123,124,125,126,127,128,129,
						131,134,136,137,138,
						142,143,144,145,147,150,151,152,153);

						
					$query.="SELECT * FROM if_type_doc WHERE (type_doc!='16'";
					reset($TypeAIgnorer);
					while (list(,$val)=each($TypeAIgnorer)) {
						$query.=" AND type_doc!='".$val."'";
					}
					$query.=") ORDER BY nom";
					$result=mysql_query($query);
					//$result=mysql_query("SELECT * FROM if_type_doc ORDER BY nom");
					while ($row=mysql_fetch_array($result)) {
					?>
							<option value="<?=$row["type_doc"]?>" <?php if ($type_doc==$row["type_doc"]) echo "selected='selected'";?>>(type <?=$row["type_doc"]?>) <?=$row["nom"]?> </option>
					<?php
					}//fin du wile
					?>
      </select>
	  </li>
	  <li><label>Par critère spécifique :</label>
	  <select name="selectCritere" OnChange="location='index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&dom=<?=$dom?>&ssdom=<?=$ssdom?>&type_doc=<?=$type_doc?>&critere='+this.value" class="public">
				    
					<option value="">Sélectionner un critère</option>  
					<option value="acces_res" <?php if ($critere=="acces_res") echo "selected='selected'";?>>Notices en accès réservé</option>
					<option value="nonpubliee" <?php if ($critere=="nonpubliee") echo "selected='selected'";?>>Notices non publiées</option>
					<option value="anciennedate" <?php if ($critere=="anciennedate") echo "selected='selected'";?>>Notices avec date ancien format</option>
      </select>
	  </li>
	  <li>
	  <label>Par mots clés :</label>
	  <input class="public" type="text" name="textRech" id="textRech" onfocus="MontrerCalque('attente')" onkeyup="ajax('fonctions_ajax2.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>', 'suggestion', 'attente','POST', 'null', 'textRech','null');" value="<? if ($rech) echo stripslashes($rech)?>" />
	</li>
	<li>
	  <label>Par auteur :</label>
	  <input class="public" type="text" name="textRechAut" id="textRechAut" onfocus="MontrerCalque('attente')" onkeyup="ajax('fonctions_ajax2.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>', 'suggestion', 'attente','POST', 'null', 'textRechAut','null');" value="<? if ($rechauteur) echo $rechauteur?>"  />
	</li>
	<li>
	<label>&nbsp;</label> 
			 <div id="attente">
                         <p><strong>Pour rechercher une documentation<br />
                           veuillez saisir les <span class="rouge">2 premi&egrave;res lettres</span> <br />
                          de votre recherche et patienter pendant la g&eacute;n&eacute;ration de la liste </strong></p>
      		</div>
			<div id="suggestion"></div>
		</li>

			<li>
			<label>&nbsp;</label>
			<input id="button" name="annuler" type="button" value="Annuler les critères" onclick="javascript:location='index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>'"  />
			</li>
	  </ol>
			<h4>&nbsp;</h4>
</fieldset>
			
				<?php /*----------------------- Recherche de documents -----------------------------------*/
				
		 
				if ($dom) {
				   //On liste les documentations liées à la catégorie (en fait ce sont toutes les documentations des sous-categ dont la categ a été sélectionnée)
				    if ($annee) {//on a sélectionné un critère de date - plus utilisé
						$date_deb=mktime(0,0,0,1,1,$annee);
						$date_fin=mktime(23,59,59,12,31,$annee);
						$tri_date=" AND (date BETWEEN $date_deb AND $date_fin)";
					}
					
					if ($type_doc) {//on a sélectionné un type de document
						$tri_date.=" AND type_doc='$type_doc'";
					}
					
					if ($critere && $critere=="acces_res") {//on a sélectionné un type de document
						$tri_date.=" AND acces_res='o'";
					} else if ($critere && $critere=="anciennedate") {//on a sélectionné un type de document
						$tri_date.=" AND date='0'";
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
				   } else { //on a sélectionné un domaine uniquement : les docs de la categ + des souscategs
					   $menus_doc=new Menu(); 
					   $menus_doc->type="categorie";
					   $menus_doc->nomkey="numcateg";
					   $menus_doc->nummenu=$dom;
					   $menus_doc->lg=$lg;
					   $menus_doc->infosMenu();
					   $menus_doc->tri_date=$tri_date;
					   $nb_doc_menu=$menus_doc->afficherDocs();
					   $menus_doc->afficherDocsSousCateg();
					   $total=count($menus_doc->listdoc); //car $nb_doc_menu renvoi ici juste true et listdoc est incrémenté dans afficherDocsSousCateg()
				   }
				   
				   
				
				} else if ($type_doc) {//fin if ($dom) : on a sélectionné un type de document mais pas une catég ni sous-categ
					$listdoc=new ListeParagraphes();
					$listdoc->doc=1;
					$listdoc->docvcourte=1;
					$req_doc=" WHERE type_doc='$type_doc' AND publiee='o'";
					if ($spec=="extranet-pro") $req_doc.=" AND acces_res='o'";
					$req_doc.=" ORDER BY date DESC"; //remise en service (plus tri sur le tableau des objets)
					$listdoc->req_doc=$req_doc;
					$listdoc->borneinf=$s;
					$listdoc->bornesup=$nbdocsparpage;
  					$nb_doc_type=$listdoc->afficherListeParas();
					$total=$nb_doc_type;
				} else if ($rech) {//fin else if ($annee) : recherche par mots-clés (suggestion de contenu)
				    $listdoc=new ListeParagraphes();
					$listdoc->doc=1;
					$listdoc->docvcourte=1;
					$keyw_majuscule=Majuscules($rech);
					$keyw_lettre=Majuscules(substr($rech,0,1)).substr($rech,1);
					$keyw_lettre2=ajoutAccents(substr($rech,0,1)).substr($rech,1);//première lettre accentuée (économie)
					$req_doc=" WHERE (keyw LIKE '%$rech%' OR keyw LIKE '%$keyw_majuscule%' 
					OR keyw LIKE '%$keyw_lettre%' OR keyw LIKE '%$keyw_lettre2%')";
					if ($spec=="extranet-pro") $req_doc.=" AND acces_res='o'";
					$req_doc.="ORDER BY date DESC"; //remise en service (plus tri sur le tableau des objets)
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
					OR auteur LIKE '%$aut_lettre%') ";
					if ($spec=="extranet-pro") $req_doc.=" AND acces_res='o'";
					$req_doc.="ORDER BY date DESC"; //remise en service (plus tri sur le tableau des objets)
					$listdoc->req_doc=$req_doc;
					$listdoc->borneinf=$s;
					$listdoc->bornesup=$nbdocsparpage;
  					$nb_doc_rech=$listdoc->afficherListeParas();
					$total=$nb_doc_rech;
				} else if ($touteladoc){//fin else if ($rech) 
				    $listdoc = new ListeParagraphes();
				    $listdoc->doc=1;
					$listdoc->docvcourte=1; // pour ne stocker que les numpara et les annees (fabriquees par InfosDocVCourte)
				    $req_doc.="ORDER BY date DESC"; //remise en service (plus tri sur le tableau des objets)
					$listdoc->req_doc=$req_doc;
				    $listdoc->borneinf=$s;
					$listdoc->bornesup=$nbdocsparpage;
					$nb_doc_def=$listdoc->afficherListeParas();
					$total=$nb_doc_def;
				} else if ($numpara) {//fin else if ($touteladoc) : 1 doc de sélectionnée
					$listdoc=new ListeParagraphes();
					$listdoc->doc=1;
					$listdoc->docvcourte=1;
					$req_doc=" WHERE numpara=".$numpara;
					$listdoc->req_doc=$req_doc;
					$listdoc->borneinf=$s;
					$listdoc->bornesup=$nbdocsparpage;
  					$nb_doc_numpara=$listdoc->afficherListeParas();
					$total=$nb_doc_numpara;
				} else if ($critere) {//fin else if ($numpara) : 1 critère de sélectionné
					$listdoc=new ListeParagraphes();
					$listdoc->doc=1;
					$listdoc->docvcourte=1;
					$listdoc->borneinf=$s;
					$listdoc->bornesup=$nbdocsparpage;
					if ($critere=="acces_res") $req_doc=" WHERE acces_res='o'";
					else if ($critere=="nonpubliee") $req_doc=" WHERE publiee!='o'";
					else if ($critere=="anciennedate") $req_doc=" WHERE date='0'";
					$req_doc.="ORDER BY date DESC"; //remise en service (plus tri sur le tableau des objets)
					$listdoc->req_doc=$req_doc;
  					$nb_doc_critere=$listdoc->afficherListeParas();
					$total=$nb_doc_critere;

				} // fin else if ($numpara)
				?>
					
			<br />	 	
			
   
   
  <?php
  
  if ($nb_doc_def || $nb_doc_menu || $nb_doc_type || $nb_doc_rech || $nb_doc_numpara || $nb_doc_critere) {	
  ?>
  <table>
  <?php
  		
		if ($total) {
			$nb_pages=ceil($total/$nbdocsparpage);
  ?>
			<tr>
			  <td colspan="8" align='center'>
			 <?php
				$de=$s+1;
				if ($suite>$total) echo"<strong>notices ".$de." à ".$total; else echo"&nbsp;<strong>notices ".$de." à ".$suite; echo"&nbsp;/&nbsp;".$total."</strong>&nbsp;"; 
			  ?>
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
		}//fin if ($total)
  ?>
  	  <tr class="entete">
	    <td></td>
		<td>Titre</td>
  	    <td>Année<br />
  	      et date </td>
  	    <td>Type de doc</td><td>Menus associ&eacute;s</td>
  	    <td>Fichiers ou tarif </td><td>En ligne</td><td>Actions</td></tr>
	  <?php	
	  $cl="";
	  if ($nb_doc_menu) { //documentations liées à la categ ou sous-categ (et éventuellement au type de doc et à la date)
		 $n=1; // numero de ligne
		 for ($i=$s;$i<$suite;$i++) { 
		 //for ($i=0;$i<count($menus_doc->listdoc);$i++) { 
	     	if (!$cl) $cl="class=\"fond_clair\""; else $cl="";
			if ($menus_doc->listdoc[$i]) {
			  $laDoc=$menus_doc->listdoc[$i];
		?>
		  <tr <?=$cl?>>
		    <td><?=$n?><? if ($laDoc->numpara) echo " - ".$laDoc->numpara?></td>
		   	<td><?=$laDoc->titrePara?></td>
			<td><?=$laDoc->anneeDoc?><? if ($laDoc->date) echo "<br />".$laDoc->date?></td>
			<td><?=$laDoc->nom_type_doc?></td>
			<td>
			  <?php
			  $nb_categ=$laDoc->afficherCateg();
			  if ($nb_categ>0) {
			   for ($j=0;$j<count($laDoc->listcateg);$j++) {
			   	   $laCateg=$laDoc->listcateg[$j];
				   echo $laCateg->nomMenu."<br />";
			   } 
			  }//fin if ($nb_categ>0)	 
			
			  $nb_sscateg=$laDoc->afficherSscateg();
			  if ($nb_sscateg>0) {
			   for ($j=0;$j<count($laDoc->listsscateg);$j++) {
			   	   $laSscateg=$laDoc->listsscateg[$j];
				   echo $laSscateg->nomMenu."<br />";
			   } 
			  }//fin if ($nb_sscateg>0)	 
			
			?>			</td>
			<td>
			  <?php
			  $listfichiers=new ListeFichiers();
			  $listfichiers->numpara= $laDoc->numpara; 
			  $nb_fichiers=$listfichiers->afficherListeFichiers();
			  foreach ($listfichiers as $fichiers) {
			    if ($fichiers->nomFichier) {
			  ?>
			    <a href="ouverturepdf.php?file=<?=$fichiers->nomFichier?>" target="_blank"><?=$fichiers->nomFichier?></a>
			  <?php
			    }
			  }
			  ?>
			  <?php
			  if ($laDoc->tarif) echo "<br />".$laDoc->tarif." &euro; TTC";
			  ?>
			  <?php
			  if ($laDoc->acces_res=="o") echo "<br />Doc. en accès réservé";
			  ?>
			</td>
			<td><?php if ($laDoc->publiee=="o") echo "oui"; else echo "non";?></td>
			<td><a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=ajouter-doc&numpara=<?=$laDoc->numpara?>&dom=<?=$dom?>&ssdom=<?=$ssdom?>&type_doc=<?=$type_doc?>&critere=<?=$critere?>&touteladoc=<?=$touteladoc?>&rech=<?=$rech?>&rechauteur=<?=$rechauteur?>&pageactive=<?=$pageactive?>&suite=<?=$s?>">modifier</a><br/>
			<a href="javascript:if (confirm('Souhaitez-vous supprimer la documentation ?')) window.location='index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&supdoc=<?=$laDoc->numpara?>&numparafichier=<?=$fichiers->numparafichier?>'">supprimer</a>			</td>
	   </tr>
	   <?php
		 	  } // fin if ($menus_doc->listdoc[$i])
			$n++;
		 }//fin de for ($i=0;$i<count($menus_doc->listdoc);$i++) 
	   } else if ($nb_doc_def || $nb_doc_critere || $nb_doc_type || $nb_doc_rech || $nb_doc_numpara) {//fin if ($nb_doc_menu) : documentations par défaut ou liées au type de doc
	   	 
		  //echo count($listdoc->paras);
		  //print_r($listdoc->paras);
		  //reset($listdoc->paras);

		  $n=1;
		  foreach ($listdoc as $paras) { //NB : le tableau est tronqué dans l'objet selon le nbre souhaite par page

			 if (!$cl) $cl="class=\"fond_clair\""; else $cl="";
			 //On récupère les infos complètes de la doc (on n'a stocké que l'année dans le tableau $paras[])
			 $laDoc=new Documentation();
			 $laDoc->numpara=$paras->numpara;
			 $laDoc->infosDoc();
	  ?>
	   <tr <?=$cl?>>
		   	<td><?=$n?><? if ($laDoc->numpara) echo " - ".$laDoc->numpara?></td>
			<td><?=$laDoc->titrePara?></td>
			<td><?=$laDoc->anneeDoc?><? if ($laDoc->date) echo "<br />".$laDoc->date?></td>
			<td><?=$laDoc->nom_type_doc?></td>
			<td>
			<?php
			$nb_categ=$laDoc->afficherCateg();
			if ($nb_categ>0) {
			   for ($i=0;$i<count($laDoc->listcateg);$i++) {
			   	   $laCateg=$laDoc->listcateg[$i];
				   echo $laCateg->nomMenu."<br />";
			   } 
			}//fin if ($nb_categ>0)	 
			
			$nb_sscateg=$laDoc->afficherSscateg();
			if ($nb_sscateg>0) {
			   for ($i=0;$i<count($laDoc->listsscateg);$i++) {
			   	   $laSscateg=$laDoc->listsscateg[$i];
				   echo $laSscateg->nomMenu."<br />";
			   } 
			}//fin if ($nb_sscateg>0)	 
			
			?>			</td>
			<td>
			<?php
			$listfichiers=new ListeFichiers();
			$listfichiers->numpara= $laDoc->numpara; 
			$nb_fichiers=$listfichiers->afficherListeFichiers();
			foreach ($listfichiers as $fichiers) {
			?>
			  <a href="ouverturepdf.php?file=<?=$fichiers->nomFichier?>" target="_blank"><?=$fichiers->nomFichier?></a>
			<?php
			}
			?>
			<?php if ($laDoc->tarif) echo "<br />".$laDoc->tarif." &euro; TTC";?>
			<?php if ($laDoc->acces_res=="o") echo "<br />Doc. en accès réservé"; ?>
			</td>
			<td><?php if ($laDoc->publiee=="o") echo "oui"; else echo "non";?></td>
			<td><a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=ajouter-doc&numpara=<?=$laDoc->numpara?>&dom=<?=$dom?>&ssdom=<?=$ssdom?>&type_doc=<?=$type_doc?>&critere=<?=$critere?>&touteladoc=<?=$touteladoc?>&rech=<?=$rech?>&rechauteur=<?=$rechauteur?>&pageactive=<?=$pageactive?>&suite=<?=$s?>">modifier</a><br/>
			<a href="javascript:if (confirm('Souhaitez-vous supprimer la documentation ?')) window.location='index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&supdoc=<?=$paras->numpara?>&numparafichier=<?=$fichiers->numparafichier?>'">supprimer</a>			</td>
	   </tr>
	   <?php
			$n++;
		}//fin du foreach 
	   } /* HC 21 mai 2009 - requete trop longue (toute la doc était stockée dans ListeParagraphes)
	   else if ($nb_doc_numpara) {//fin if ($nb_doc_def) : documentations par défaut ou liées au type de doc
	   echo count($listdoc->paras);
	   
		  foreach ($listdoc as $paras) {	
			 if (!$cl) $cl="class=\"fond_clair\""; else $cl="";
	  ?>
	   <tr <?=$cl?>>
		   	<td><?=$paras->titrePara?></td>
			<td><?=$paras->anneeDoc?></td>
			<td><?=$paras->nom_type_doc?></td>
			<td>
			<?php
			$nb_categ=$paras->afficherCateg();
			if ($nb_categ>0) {
			   for ($i=0;$i<count($paras->listcateg);$i++) {
			   	   $laCateg=$paras->listcateg[$i];
				   echo $laCateg->nomMenu."<br />";
			   } 
			}//fin if ($nb_categ>0)	 
			
			$nb_sscateg=$paras->afficherSscateg();
			if ($nb_sscateg>0) {
			   for ($i=0;$i<count($paras->listsscateg);$i++) {
			   	   $laSscateg=$paras->listsscateg[$i];
				   echo $laSscateg->nomMenu."<br />";
			   } 
			}//fin if ($nb_sscateg>0)	 
			
			?>			</td>
			<td>
			<?php
			$listfichiers=new ListeFichiers();
			$listfichiers->numpara= $paras->numpara; 
			$nb_fichiers=$listfichiers->afficherListeFichiers();
			foreach ($listfichiers as $fichiers) {
			?>
			  <a href="ouverturepdf.php?file=<?=$fichiers->nomFichier?>" target="_blank"><?=$fichiers->nomFichier?></a>
			<?php
			}
			?>
			<?php if ($paras->tarif) echo $paras->tarif." &euro; TTC";?>
			</td>
			<td><?php if ($paras->publiee=="o") echo "oui"; else echo "non";?></td>
			<td><a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=ajouter-doc&numpara=<?=$paras->numpara?>&dom=<?=$dom?>&ssdom=<?=$ssdom?>&type_doc=<?=$type_doc?>">modifier</a><br/>
			<a href="javascript:if (confirm('Souhaitez-vous supprimer la documentation ?')) window.location='index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&supdoc=<?=$paras->numpara?>&numparafichier=<?=$fichiers->numparafichier?>'">supprimer</a>			</td>
	   </tr>
	   <?php
	   	}//fin du foreach 
	   }//fin else if ($nb_doc_date || $nb_doc_type || $nb_doc_rech)
	   */
	   ?> 
 </table>
 <?php
 }  else {
 	if ($type_doc || $critere || $rech || $ssdom || $dom) {
 ?>
 	<br /><br /><strong>Aucune documentation ne correspond à votre recherche</strong>
  <?php
  	} // fin if
 } // fin else
 ?>
 <input type="hidden" name="suite" value="<?=$suite?>" />
 <input type="hidden" name="pageactive" value="<?=$pageactive?>" />
 <input type="hidden" name="touteladoc" value="<?=$touteladoc?>" />
 <input type="hidden" name="critere" value="<?=$critere?>" />
 <input type="hidden" name="type_doc" value="<?=$type_doc?>" />
 <input type="hidden" name="rech" value="<?=$rech?>" />
 <input type="hidden" name="rechauteur" value="<?=$rechauteur?>" />
 <input type="hidden" name="dom" value="<?=$dom?>" />
 <input type="hidden" name="ssdom" value="<?=$ssdom?>" />
 <input type="hidden" name="anciennedate" value="<?=$anciennedate?>" />
 <br />
 <br />
<br />	
</div>
</div>
</div>
