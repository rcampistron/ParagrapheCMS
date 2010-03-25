<?php /* Date de creation: 19/02/2009 */
// Gestion de la mise en page specifique a l'accueil
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
?>
	<div class="item" id="coltexte785"> 
		<div class="sap-content">
			<p class="titre785">Résultats de la recherche pour le mot "<?=$rech_site?>" </p>
			<table>
					<tr>
						<td colspan="2">
				<?php
				 if (!isset($suite)) $suite=0;
				 $su=$suite-50;
				 $suite+=50;
				 $s=$suite-50;
				 ?>
					 <div align="center">
				 <?php
		    			echo"Résultats <strong>".$s."</strong> à <strong>";
						if ($suite>count($resultats)) echo count($resultats); 
						else echo $suite; echo"&nbsp;de&nbsp;<strong>".count($resultats)."</strong> résultats"; 
			  			echo "<br /><br />";
			  ?>	
			  			</div>
			  			</td>
					</tr>
					<tr>
					  <td colspan="2">
					  <div align="right">
					  <p>
					  <?php
					  if ($su>=0) {
					  ?>
					  <a href="javascript:document.forms[0].suite.value=<?=$su?>;document.forms[0].submit();" >Page précédente</a>
					  <?php
					  }
					  
					  if ($su>=0 && $suite<count($resultats)) echo"&nbsp;|&nbsp;";
					  if ($suite<count($resultats)) {
					  ?>
					  <a href="javascript:document.forms[0].suite.value=<?=$suite?>;document.forms[0].submit();" >Page suivante</a>
					  <?php
					  }
					  ?>
					  <br />
					  </p>
					  </div>
					  </td>
			  </tr>
			  
			  <?php
			    
				$pagePro = new Page();
			    $pagePro->pageSpecifique("extranet-pro");
				
				for ($i=0; $i<$suite; $i++) {
					next($resultats);    
				}
				$output = array_slice($resultats,$s, 20); 
				foreach ($output as $key => $value) {
				?>
					<tr>
						<td>
						<?php
						if ($value["type"]=="page") {
						?>
						<img src="images/picto-page.gif" alt="" width="15" height="16" />
						<?php
						} else if ($value["type"]=="doc" && $value["acces_res"]=="o") {
						?>
						<img src="images/picto-pdf-acces-reserve.gif" alt="Rapport en accès réservé" width="15" height="14" />						<?php
						} else if ($value["type"]=="doc" && $value["lien"]) {
						?>
						<?php
						} else {//ouvrage de reference sans fichier a telecharger
						?>
						
						<?php
						}
						?>
						</td>
						<td>
						[<?=$value["type"]?>]&nbsp;<a href="<?php if ($value["type"]=="doc" && $value["acces_res"]=="o") echo "javascript:if (confirm('Ce document est en accès réservé. Souhaitez-vous vous identifier ?')) window.location='index.php?numpage=$pagePro->numpage&spec=$pagePro->nomFichier&numrub=$numrub&numcateg=$numcateg&numsscateg=$numsscateg&lg=$lg'"; 
						else if (!$value["tarif"]) echo $value["lien"];?>" <?php if ($value["type"]=="doc" && $value["acces_res"]!="o") echo "target='_blank'";?>> 
					   <?=$value["titre"]?>
					  </a> <br /> 
					  <?=$value["texte"]?>
					  <br /> <br />						</td>
					</tr>
				<?php
				}//fin du for
				?>
			</table>
		</div>
	</div>
   <input type="hidden" name="suite" />
   <input type="hidden" name="rech_site_suite" value="<?=$rech_site?>" />
<?php
} else {//fin if (is_array($resultats))
?>
	<div class="item" id="coltexte585"> 
		<div class="sap-content">
			<p class="titre585">Il n'y a aucun résultat pour le mot "<?=$rech_site?>" </p>
			
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