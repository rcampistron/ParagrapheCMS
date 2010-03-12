<?php /* Date de cr�ation: 18/12/2008 */ ?>

<div class="item" id="coltexteAdmin">



	<div class="sap-content">



<div id="pageadmin">



  <h2>Liste des utilisateurs</strong></h2>

   <br /><br />

   <a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=ajouter-uti">Ajouter un utilisateur</a>

   <br /><br />

  <?php

  $listuti = new ListeUtilisateurs();

  $listuti->afficherListeUtis();	

  ?>

  <table>

  	  <tr class="entete"><td>Nom</td><td>Prenom</td><td>Identifiant</td><td>Mot de passe</td><td>Administrateur</td><td>Action</td><td>Actif</td></tr>

	  <?php

	  foreach ($listuti as $utis) {
		if (!$cl) $cl="class=\"fond_clair\""; else $cl="";
	  ?>

	   <tr <?=$cl?>>

		   	<td><?=$utis->nom?></td>

			<td><?=$utis->prenom?></td>

			<td><?=$utis->login?></td>

			<td><?=$utis->pwd?></td>

			<td><?php if ($utis->admin=="o") echo "oui"; else echo "non";?></td>

			<td><a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=ajouter-uti&numuti=<?=$utis->numuti?>">modifier</a></td>

			<td><a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numuti=<?=$utis->numuti?>&act=<?=$utis->actif?>"><?php if ($utis->actif=="o") echo "oui"; else echo "non";?></a></td>

	   </tr>

	   <?php

	   }//fin du foreach

	   ?> 

 </table>

  <br /><br />



<br />	

</div>
</div>
</div>
