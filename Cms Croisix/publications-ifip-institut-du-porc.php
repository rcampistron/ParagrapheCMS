<?php /* Date de cration: 19/01/2009 */ 
$laPage = new Page();
$laPage->numpage=$numpage;
$laPage->infosPage();
$laPage->infosColonnes();

//setlocale(LC_ALL, "french");

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
	
	//Mise en page particuliere pour la colonne C3 
	// pour eviter de prendre toute la largeur
	$divflotte=1;
		
if ($laPage->nomPageGoogle) { 
?>

<div class="item" id="coltexte785"> 
		   <div class="sap-content">
				<!-- item 1 | 785 pixels de large ou 585 pixels ou 385 -->
				<p class="titre585"><?=$laPage->titrePage?></p>
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
				<!-- Affichage moteur de recherche --->
				<?php
				// Include du moteur de recherche des publications
				include("moteur-recherche-publications-ifip.php");
				?>
				<!-- Fin affichage moteur de recherche -->
				
				
				<p>&nbsp;</p>
				<p>&nbsp;</p>
  </div>
</div>
<?php	
}//fin if ($laPage->nomPageGoogle)
	?>