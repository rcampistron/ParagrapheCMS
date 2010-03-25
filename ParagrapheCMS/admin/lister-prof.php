<?php /* Date de cration: 28/01/2009 */ ?>
<div class="item" id="coltexteAdmin">
	<div class="sap-content">
<div id="pageadmin">

  <h2>Liste des professionnels</h2>
  <p>
  Un professionnel est simplement un client qui a un accès autorisé à l'espace pro. Il peut donc se connecter aux deux espaces avec ses identifiants IFIP : même adresse email et même mot de passe. <br />
  La liste des domaines (thèmes) qui lui est proposée dans l'espace pro dépend de son profil (amont et/ou aval). La définition du critère amont et/ou aval pour chaque domaine est effectuée directement dans la base de données : champs if_categorie.amont et if_categorie.aval. Contactez un informaticien pour modifier cette liste. <br />
  La demande d'accès à l'espace pro est envoyée par email au contact associé à la page Espace Pro (Claire BENES).<br />
   <br />
   <a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=ajouter-prof">Ajouter un  professionnel</a><br />
   <br />
   </p>
  <?php
  $listprof = new ListeClients();
  $listprof->profes="o";
  $nb_prof=$listprof->afficherListeClients();	
  if ($nb_prof) {
  ?>
  <table width="760">
  	  <tr class="entete"><td>Structure</td><td>Nom</td><td>Prénom</td><td>Email</td>
  	  <td>Mot de passe Pro </td>
  	    <td>Amont/Aval</td>
  	    <td>Actif</td><td></td></tr>
	  <?php
	  foreach ($listprof as $clients) {   
	  	if (!$cl) $cl="class=\"fond_clair\""; else $cl="";
	  ?>
	   <tr <?=$cl?>>
		   	<td><?=$clients->raison?></td>
			<td><?=$clients->nom?></td>
			<td><?=$clients->prenom?></td>
			<td><?=$clients->email?></td>
			<td><?=$clients->pwd?></td>
			<td><? if($clients->amont=="o") echo"amont"; if($clients->amont=="o" && $clients->aval=="o") echo"&nbsp;/&nbsp;"; if($clients->aval=="o") echo "aval";?></td>
			<td>
				<?php if ($uti->estAdmin()) {?><a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numclient=<?=$clients->numclient?>&actif=<?=$clients->actif?>"> <?php } ?>
				<?php if ($clients->actif=="o") echo "oui"; else echo "non";?>
				<?php if ($uti->estAdmin()) {?></a> <?php } ?>			</td>
			<td>
			<a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=ajouter-prof&numclient=<?=$clients->numclient?>">modifier</a>
			<?php
			if ($uti->estAdmin()) {
			?>
				<br />
				<a href="javascript:if (confirm('Souhaitez-vous supprimer le professionnel ?')) window.location='index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&supprof=<?=$clients->numclient?>'">supprimer</a>
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
  	Il n'y a aucun professionnel cr&eacute;&eacute;.
  <?php
  }//fin de if ($nb_rub) 
  ?>
<br />	
</div>

</div>

</div>

