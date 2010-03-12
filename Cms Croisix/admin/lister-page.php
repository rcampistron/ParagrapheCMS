<?php /* Date de cration: 10/12/2008 */ ?>
<div class="item" id="coltexteAdmin">
	<div class="sap-content">
<div id="pageadmin">	
  <h2>Tableau de bord des pages</h2>
  <p><strong>Les pages peuvent être librement associées à un ou plusieurs menus</strong>. Une page peut ainsi figurer dans plusieurs rubriques du site si cela facilite la navigation pour vos visiteurs. Par exemple, la page de recherche d'un contact est associée aux menus Contacts&gt;Rechercher un contact et  L'institut&gt;Equipes Ifip <br />
    <strong>Le nom du fichier correspondant à une page (xxx.html) doit être défini avec soin</strong> car les mots clés qu'il contient compterons pour le référencement du site dans les moteurs de recherche. Favorisez aussi l'utilisation du tiret - plutôt que le &quot;underscore : _&quot; pour les mêmes raisons (même si ce n'est plus tout à fait aussi vrai qu'au début des moteurs de recherche). <br />
    <br />
    <?php if (!$publi) {?>
    <a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=ajouter-page">Ajouter une page</a>
    <?php } ?>
    <br />
    <br />
    <?php
  $listpages = new ListePages();
  $nb_pages=$listpages->afficherListePages();	
  if ($nb_pages) {

  ?>
  </p>
  <table>
  	  <tr class="entete">
  	    <td>Titre</td>
  	    <td>Date de cr&eacute;ation</td><td>Date de modification</td><td>Auteur</td>
  	  <td>Menus associés </td>
  	  <td>Fichier</td><td><?php if (!$publi) echo "En ligne"; else echo "Publi&eacute;e";?></td><?php if (!$publi) {?><td></td><?php } ?><!--<td>Supprimer</td>--></tr>
	  <?php
	  foreach ($listpages as $pages) {
	  	if (!$cl) $cl="class=\"fond_clair\""; else $cl="";
	  ?>
	   <tr <?=$cl?>>
		   	<td><?=$pages->titrePage?></td>
			<td><?=date("d/m/Y",$pages->hcreaPage)?></td>
			<td><?php if ($pages->hmodifPage) echo date("d/m/Y",$pages->hmodifPage);?></td>
			<td><?=$pages->auteur?></td>
			<td>
			 <?php
			  if (is_array($pages->list_numsscateg)) {
			  	  $leMenu = new Menu();
				  for ($i=0;$i<count($pages->list_numsscateg);$i++) {
						 $leMenu->type="sscateg";
						 $leMenu->nomkey="numsscateg";
						 $leMenu->nummenu=$pages->list_numsscateg[$i];
						 $leMenu->infosMenu();
						 echo $leMenu->nomMenu."<br />";
				  } 
			  }
			  
			  if (is_array($pages->list_numcateg)) {
			  	  $leMenu = new Menu();
				  for ($i=0;$i<count($pages->list_numcateg);$i++) {
				    	 $leMenu->type="categorie";
						 $leMenu->nomkey="numcateg";
						 $leMenu->nummenu=$pages->list_numcateg[$i];
						 $leMenu->infosMenu();
						 echo $leMenu->nomMenu."<br />";
				  } 
			  } 
			  
			  if (is_array($pages->list_numrub)) {
			  	  $leMenu = new Menu();
				  for ($i=0;$i<count($pages->list_numrub);$i++) {
						 $leMenu->type="rubrique";
						 $leMenu->nomkey="numrub";
						 $leMenu->nummenu=$pages->list_numrub[$i];	
						 $leMenu->infosMenu();
						 echo $leMenu->nomMenu."<br />";
				  } 
			  }
			 ?>
			</td>
			<td><?php echo $pages->aliasPage;?></td>
			<td 
			<?php
			//gestion couleur de la cellule selon etat de la publication
			if ($pages->publiePage!="o") echo" class=\"fond_fonce\"";
			?>
			><?php if ($publi) {?><a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numpageP=<?=$pages->numpage?>&publiee=<?=$pages->publiePage?>"> <?php } ?><?php if ($pages->publiePage=="o") echo "oui"; else echo "non";?><?php if ($publi) {?></a> <?php } ?></td>
			<?php if (!$publi) {?><td><a href="index.php?id=<?=$id?>&pg_admin=content&cnx=<?=$cnx?>&numpage=<?=$pages->numpage?>&numrub=<?=$pages->numrub?>&numcateg=<?=$pages->numcateg?>&numsscateg=<?=$pages->numsscateg?>&onglet=voir">modifier</a>
			<br />
			<?php
			if ($uti->estAdmin()) {
			?>
				<a href="javascript:if (confirm('Souhaitez-vous supprimer la page ?')) window.location='index.php?id=<?=$id?>&pg_admin=<?=$pg_admin?>&cnx=<?=$cnx?>&supPage=<?=$pages->numpage?>&numrub=<?=$pages->numrub?>&numcateg=<?=$pages->numcateg?>&numsscateg=<?=$pages->numsscateg?>'">supprimer</a>
			<?php
			}//fin if ($uti->estAdmin()) 
			?>
			</td>	<?php } ?>
			<!--<td><input type="checkbox" name="supPage[]" value="<?=$pages->numpage?>"></td>-->
	   </tr>
	  <?php
	  }	//fin du foreach
	  ?>
	  
  </table>
  <br /><br />
  <!--<input id="button" name="suppPage" type="button" value="Supprimer" onClick="javascript:supPage()"/>-->
  
  <?php
  }	else {
  ?>
  	Il n'y a aucune page cr&eacute;&eacute;.
  <?php
  }//fin de if ($nb_pages) 
  ?>
<br />	
</div>

</div>

</div>
