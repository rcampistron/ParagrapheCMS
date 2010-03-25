<?php /* Date de creation: 10/12/2008 */ ?>

<div class="item" id="coltexteAdmin">

	<div class="sap-content">

      <div id="pageadmin">   
        <h2>Tableau de bord des menus</h2>
        <p>
          <br />
          
          <a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=ajouter-menu&cont=rubrique">Ajouter une rubrique</a> | <a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=ajouter-menu&cont=categorie">Ajouter une cat&eacute;gorie</a> | <a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=ajouter-menu&cont=sscateg">Ajouter une sous-cat&eacute;gorie</a>
          
          <br />
          <br />
          
          <?php

  $listrub = new ListeMenus();

  $listrub->type="rubrique";

  $listrub->nomkey="numrub";

  $nb_rub=$listrub->afficherListeMenus();	

  if ($nb_rub) {

  ?>
          
        </p>
        <table>
          
          <tr class="entete"><td>Type</td><td>Zone</td><td>Libell&eacute;</td><td>Page</td><td>Ordre</td><td>Langue</td><td>Action</td><td>Affich&eacute;</td></tr>
          
          <?php

	  foreach ($listrub as $menus) {

	  	if (!$cl) $cl="class=\"fond_clair\""; else $cl="";

	  ?>
          
          <tr class="fond_clair">
            
            <td>Rubrique</td>
  
			<td><?=$menus->zone?></td>
  
			<td><?=$menus->nomMenu?></td>
  
			<td><?=$menus->url?></td>
  
			<td><?=$menus->ordre?></td>
			  
			<td><?=$menus->lg?></td>
			  
			<td><a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=ajouter-menu&cont=rubrique&nummenu=<?=$menus->nummenu?>">modifier</a>
			  <?php
			if ($uti->estAdmin()) {
			?>
			  <br /><a href="javascript:if (confirm('Souhaitez-vous supprimer le menu ?')) window.location='index.php?id=<?=$id?>&pg_admin=<?=$pg_admin?>&cnx=<?=$cnx?>&supMenu=<?=$menus->nummenu?>&type=rubrique'">supprimer</a>
			  <?php
			}//fin if ($uti->estAdmin()) 
			?>
		    </td>
  
			<td><?php if ($uti->estAdmin()) {?><a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numrub=<?=$menus->nummenu?>&affic=<?=$menus->affiche?>"><?php } if ($menus->affiche=="o") echo "oui"; else echo "non";?><?php if ($uti->estAdmin()) {?></a><?php } ?></td>
  
	   </tr> 
          
          <?php

			$listcateg = new ListeMenus();

		    $listcateg->type="categorie";

		    $listcateg->nomkey="numcateg";

			$listcateg->numfkey=$menus->nummenu;

		    $listcateg->afficherListeMenus();	

			foreach ($listcateg as $menus) {

			?>
          
          <tr class="fond_clair2">
            
            <td>Cat&eacute;gorie</td>
  
				<td><?=$menus->zone?></td>
  
				<td><?=$menus->nomMenu?></td>
  
				<td><?=$menus->url?></td>
  
				<td><?=$menus->ordre?></td>	
				  <td><?=$menus->lg?></td>
  
				<td><a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=ajouter-menu&cont=categorie&nummenu=<?=$menus->nummenu?>">modifier</a>
				  <?php
				if ($uti->estAdmin()) {
				?>
				  <br /><a href="javascript:if (confirm('Souhaitez-vous supprimer le menu ?')) window.location='index.php?id=<?=$id?>&pg_admin=<?=$pg_admin?>&cnx=<?=$cnx?>&supMenu=<?=$menus->nummenu?>&type=categorie'">supprimer</a>
				  <?php
				}//fin if ($uti->estAdmin()) 
				?>
		    </td>
  
				<td 
				<?php
				//gestion couleur de la cellule selon etat de la publication
				if ($menus->affiche!="o") echo" class=\"fond_fonce\"";
				?>
				><?php if ($uti->estAdmin()) {?><a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numcateg=<?=$menus->nummenu?>&affic=<?=$menus->affiche?>"><?php } if ($menus->affiche=="o") echo "oui"; else echo "non";?><?php if ($uti->estAdmin()) {?></a><?php } ?></td>
  
	      </tr>
          
          <?php

				$listsscateg = new ListeMenus();

			    $listsscateg->type="sscateg";

			    $listsscateg->nomkey="numsscateg";

				$listsscateg->numfkey=$menus->nummenu;

			    $listsscateg->afficherListeMenus();	

				foreach ($listsscateg as $menus) {

				?>
          
          <tr>
            
            <td>Sous-cat&eacute;gorie</td>
  
					<td><?=$menus->zone?></td>
  
					<td><?=$menus->nomMenu?></td>
  
					<td><?=$menus->url?></td>
  
					<td><?=$menus->ordre?></td>
					  <td><?=$menus->lg?></td>
  
					<td><a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=ajouter-menu&cont=sscateg&nummenu=<?=$menus->nummenu?>">modifier</a>
					  <?php
					if ($uti->estAdmin()) {
					?>
					  <br /><a href="javascript:if (confirm('Souhaitez-vous supprimer le menu ?')) window.location='index.php?id=<?=$id?>&pg_admin=<?=$pg_admin?>&cnx=<?=$cnx?>&supMenu=<?=$menus->nummenu?>&type=sscateg'">supprimer</a>
					  <?php
					}//fin if ($uti->estAdmin()) 
					?>
		    </td>
  
					<td
					<?php
					//gestion couleur de la cellule selon etat de la publication
					if ($menus->affiche!="o") echo" class=\"fond_fonce\"";
					?>
					><?php if ($uti->estAdmin()) {?><a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numsscateg=<?=$menus->nummenu?>&affic=<?=$menus->affiche?>"><?php } if ($menus->affiche=="o") echo "oui"; else echo "non";?><?php if ($uti->estAdmin()) {?></a><?php } ?></td>
  
	      </tr> 
          
          <?php 

				}//fin du foreach sscateg

			} //fin du foreach categ

	  }	//fin du foreach  rubrique

	  ?>
          
          
          
        </table>
  
  <br /><br />
        
        
        
        <?php

  }	else {

  ?>
        
        Il n'y a aucun menu créé.
        
        <?php

  }//fin de if ($nb_rub) 

  ?>
        
  <br />	
        
</div></div>



</div>

