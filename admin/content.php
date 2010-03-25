<?php /* Date de creation: 08/12/2008 */
/***************************************************************************************************
Modifier une page : onglets Voir, Modifier la page, Modifier les paragraphes, Ajouter un paragraphe
****************************************************************************************************/	   
?>

<!-- the main content column -->
<div class="item" id="coltexteAdmin">
	<div class="sap-content">
		<div class="TabbedPanels" id="tp1">
			  <ul class="TabbedPanelsTabGroup">
			    <li class="TabbedPanelsTab" tabindex="0" onclick="javascript:Recharger('index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numrub=<?=$numrub?>&numpage=<?=$numpage?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&onglet=voir&page_accueil=<?=$page_accueil?>');">Voir</li>
			    <?php
				if ($numpage) {
				?> 
					<li class="TabbedPanelsTab" tabindex="1" onclick="javascript:Recharger('index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numrub=<?=$numrub?>&numpage=<?=$numpage?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&onglet=mod_page&page_accueil=<?=$page_accueil?>');">Modifier les param&egrave;tres g&eacute;n&eacute;raux</li>
					<li class="TabbedPanelsTab" tabindex="2" onclick="javascript:Recharger('index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numrub=<?=$numrub?>&numpage=<?=$numpage?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&onglet=mod_para&page_accueil=<?=$page_accueil?>');">Modifier les paragraphes</li>
					<li class="TabbedPanelsTab" tabindex="3" onclick="javascript:Recharger('index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numrub=<?=$numrub?>&numpage=<?=$numpage?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&onglet=aj_para&page_accueil=<?=$page_accueil?>');">Ajouter un paragraphe</li>
			   <?php
			   }
			   ?>
			  </ul>

 			  <div class="TabbedPanelsContentGroup">
    				<!-- onglet voir -->
					<div class="TabbedPanelsContent" id="voir"> 
					<?php
					  if ($onglet=="voir" && $page_accueil && $lg=="fr") include("includes/home.php"); else if ($onglet=="voir" && $page_accueil && $lg=="en") include("includes/home_en.php"); else if ($onglet=="voir") include("includes/page.php"); //la page que l'on voit
					 ?>
	 				</div>	
					<!-- onglet modifier page -->
					<div class="TabbedPanelsContent" id="modpage">
					<?php
					if ($onglet=="mod_page") include("admin/modifier-page.php");
					?> 
					</div>
					<!-- onglet modifier les paragraphes -->
					<div class="TabbedPanelsContent" id="modifier-parag">
					<?php
					if ($onglet=="mod_para") include("admin/modifier-parag.php");
					?> 
					</div>	 
					<div class="TabbedPanelsContent" id="ajouter-parag">
					<?php
					if ($onglet=="aj_para") include("admin/ajouter-parag.php");
					?> 
					</div>
 			 </div>
  		</div>
   </div>
</div>



