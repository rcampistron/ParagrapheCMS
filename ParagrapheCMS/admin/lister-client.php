<?php /* Date de cration : 03/02/2009 */ ?>
<div class="item" id="coltexteAdmin">
	<div class="sap-content">
<div id="pageadmin">

  <h2>Liste des clients</h2>
  <p>Vous trouverez ci-dessous la liste des clients <strong>qui n'ont pas accès à l'espace pro</strong>. </p>
  <br />

  <?php
  $listclients = new ListeClients();
  $nb_clients=$listclients->afficherListeClients();	
  if ($nb_clients) {
  ?>
  <table style="width:700px">
  	  <tr class="entete"><td>Raison</td><td>Nom</td>
  	  <td>Fonction</td>
  	  <td>Coordonnées</td>
  	  <td>Codes d'accèes </td>
  	  <td>Actif</td><td></td></tr>
	  <?php
	  foreach ($listclients as $clients) {   
	  	if (!$cl) $cl="class=\"fond_clair\""; else $cl="";
	  ?>
	   <tr <?=$cl?>>
		   	<td><?=$clients->raison?></td>
			<td><?=$clients->civilite." ".$clients->nom." ".$clients->prenom?></td>
			<td><?=$clients->fonction?></td>
		  <td><?=$clients->adr1." ".$clients->adr2." ".$clients->cp." ".$clients->ville." ".$clients->nompays?><br />
			Tél. <?=$clients->tel?><br />
			Fax <?=$clients->fax?><br />
			Mob. <?=$clients->gsm?></td>
			<td><?=$clients->email?><br /><?=$clients->pwd?></td>
			<td>
				<?php if ($uti->estAdmin()) {?><a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numclient=<?=$clients->numclient?>&actif=<?=$clients->actif?>"> <?php } ?>
				<?php if ($clients->actif=="o") echo "oui"; else echo "non";?>
				<?php if ($uti->estAdmin()) {?></a> <?php } ?>			</td>
			<td>
			<a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=modifier-client&numclient=<?=$clients->numclient?>">modifier</a>
			<?php
			if ($uti->estAdmin()) {
			?>
				<br />
				<a href="javascript:if (confirm('Souhaitez-vous supprimer le client ?')) window.location='index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&supclient=<?=$clients->numclient?>'">supprimer</a>
			<?php
			}//fin if ($uti->estAdmin())
			?>			</td>
	   </tr> 
	  <?php 
	  }	//fin du foreach  listcont
	  ?>
  </table>
  <br /><br />
 
  <?php
  }	else {
  ?>
  	Il n'y a aucun client.
  <?php
  }//fin de if ($nb_rub) 
  ?>
<br />	
</div>

</div>

</div>

