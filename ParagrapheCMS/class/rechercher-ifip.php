<?php /* Date de creation: 19/02/2009 */
/**
 * @date 19/02/2009
 * @file rechercher-ifip.php
 * Gestion de la mise en page sp&eacute;cifique a l'accueil
 * @note Se trouve dans le r&eacute;pertoire class alors que ce n'est pas une classe
 * 
 */ 
if ($numpage && $accueil) {
?>
<!-- ajout de breadcrumbs -->
<div class="line">	  	
 <div class="item" id="breadcrumbs">
   <div class="sap-content"><p class="breadcrumbs"><a href="<?=$pageAccueil->url?>">Accueil Ifip</a> > Rechercher</p>
   </div>
 </div>
</div>
<!-- ajout de cette div pour la gestion de l'affichage si on effectue une recherche via l'accueil -->
<!-- car dans ce cas, rechercher-ifip.php est include dans index.php sans que l'on ait cette div -->
<div class="line">
<?php
}
?>
<?php
if (is_array($resultats)) { 
	//print_r($resultats);
	$pagePro = new Page();
	$pagePro->pageSpecifique("extranet-pro");
	
	$pageBddDoc = new Page();
	$pageBddDoc->pageSpecifique("publications-ifip-institut-du-porc");
?>
	<div class="item" id="coltexte785"> 
		<div class="sap-content">
			<p class="titre785">Résultats de la recherche pour le mot "<?=$rech_site?>" </p>
			<table width="760">
					<tr>
						<td colspan="3">
				<?php
				 if (!isset($suite)) $suite=0;
				 if (!isset($rech_site_suite)) $suite=0;
				 $su=$suite-50;
				 $suite+=50;
				 $s=$suite-50;
				 ?>
					 <div align="center">
				 <?php
		    			echo"Résultats <strong>".$s."</strong> &agrave; <strong>";
						if ($suite>count($resultats)) echo count($resultats); 
						else echo $suite; echo"&nbsp;de&nbsp;<strong>".count($resultats)."</strong> résultats"; 
			  			echo "<br /><br />";
			  ?>	
			  			</div>
			  			</td>
					</tr>
					<tr>
					  <td colspan="3">
					  <div align="right">
					  <p>
					  <?php
					  if ($su>=0) {
					  ?>
					  <a href="javascript:document.forms[0].suite.value=<?=$su?>;document.forms[0].submit();" class="gris">Page précédente</a>
					  <?php
					  }
					  
					  if ($su>=0 && $suite<count($resultats)) echo"&nbsp;|&nbsp;";
					  if ($suite<count($resultats)) {
					  ?>
					  <a href="javascript:document.forms[0].suite.value=<?=$suite?>;document.forms[0].submit();"class="gris" >Page suivante</a>
					  <?php
					  }
					  ?>
					  <br />
					  </p>
					  </div>
					  </td>
			  </tr>
			  
			  <?php
			    
				for ($i=0; $i<$suite; $i++) {
					next($resultats);    
				}
				$output = array_slice($resultats,$s, 20); 
				foreach ($output as $key => $value) {
					if ($value["type"]=="page") {
					?>
					<tr>
						<td>
						<img src="images/picto-page.gif" alt="" width="15" height="16" />
						</td>
						<td>&nbsp;</td>
						<td>
						<p><a href="<?=$value["lien"];?>"> <?=$value["titre"]?></a></p> 
					  	<p class="marge10"><?=$value["texte"]?></p>					
						</td>
					</tr>
					<?php
					} else if ($value["type"]=="doc"&& $value["acces_res"]=="o") {//la doc est en acces reserve
					?>
					<tr>
						<td>
						<img src="images/picto-pdf-acces-reserve.gif" alt="Rapport en acc&egrave;s réservé" width="15" height="14" />
						</td>
						<td>&nbsp;</td>
						<td>
						<p><a href="javascript:if (confirm('Ce document est en acc&egrave;s réservé. Souhaitez-vous &ecirc;tre redirigé vers l\'espace Pro ?')) window.location='index.php?numpage=<?=$pagePro->numpage?>&spec=<?=$pagePro->nomFichier?>&numrub=<?=$pagePro->numrub?>&numcateg=<?=$pagePro->numcateg?>&numsscateg=<?=$pagePro->numsscateg?>&lg=<?=$lg?>'"> <?=$value["titre"]?></a></p>
						</td>
					</tr>
					<?php
					} else if ($value["type"]=="doc" && $value["tarif"]) {//la doc n'est pas réservée mais elle est payante
						
						
					?>
					<tr>
						<td><img src="images/picto-panier.gif" alt="" width="16" height="14" /></td>
						<td>&nbsp;</td>
						<td>
						<p><a href="index.php?numpage=<?=$pageBddDoc->numpage?>&spec=<?=$pageBddDoc->nomFichier?>&numrub=<?=$pageBddDoc->numrub?>&numcateg=<?=$pageBddDoc->numcateg?>&numsscateg=<?=$pageBddDoc->numsscateg?>&lg=<?=$lg?>&numpara=<?=$value["numpara"]?>"> <?=$value["titre"]?></a></p>
					   <p class="marge10"><?=$value["texte"]?></p>	
						</td>
					</tr>
					<?php
					} else if ($value["type"]=="doc" && !$value["tarif"]) {//la doc n'est pas reservée et elle n'est pas payante
						if ($value["lien"]) {//le pdf existe
					?>
					<tr>
						<td><img src="images/picto-pdf.gif" alt="" width="15" height="16" /></td>
						<td>&nbsp;</td>
						<td>
						<p><a href="<?=$value["lien"]?>" target="_blank"> <?=$value["titre"]?></a></p>
					   <p class="marge10"><?=$value["texte"]?></p>	
						</td>
					</tr>
						
					<?php
						} else {//le pdf n'existe pas ???
					?>
					<tr>
						<td><img src="images/picto-pdf.gif" alt="" width="15" height="16" /></td>
						<td>&nbsp;</td>
						<td>
						<p><a href="index.php?numpage=<?=$pageBddDoc->numpage?>&spec=<?=$pageBddDoc->nomFichier?>&numrub=<?=$pageBddDoc->numrub?>&numcateg=<?=$pageBddDoc->numcateg?>&numsscateg=<?=$pageBddDoc->numsscateg?>&lg=<?=$lg?>&numpara=<?=$value["numpara"]?>"> <?=$value["titre"]?></a></p>
					   <p class="marge10"><?=$value["texte"]?></p>	
						</td>
					</tr>
					<?php
						
						}
					}
					?>
				<?php
				}//fin du for
				?>
		  <tr>
		  <td colspan="3">
		  <input type="hidden" name="suite" />
   <input type="hidden" name="rech_site_suite" value="<?=$rech_site?>" />
   			

   </td>
   </tr>
		  </table>
		</div>
	</div>
<?php
} else {//fin if (is_array($resultats))
?>
	<div class="item" id="coltexte585"> 
		<div class="sap-content">
			<p class="titre785">Il n'y a aucun résultat pour le mot "<?=$rech_site?>" </p>
			
		</div>
	</div>
<?php
}
?>
<?php
if ($numpage && $accueil) {
?>
</div>
<!-- fin de div class="line" -->
<?php
}
?>