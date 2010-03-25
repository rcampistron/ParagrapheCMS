<?php /* Date de cration: 19/12/2008 */ ?>
<div class="item" id="coltexteAdmin">
	<div class="sap-content">
<div id="pageadmin">

  <h2>Liste des contacts</h2>
   <p>Les contacts référents s'affichent automatiquement dans la colonne de droite (contenus contributifs) des pages associées. Les contacts non référents s'affichent dans la page &quot;Equipes Ifip&quot; lorsque le visiteur effectue une recherche sur un domaine d'activité de l'institut. <br />
     Dans la page &quot;Equipes Ifip&quot;, nous affichons tous les contacts du Domaine (référents et non référents) + les contacts de tous les sous domaines liés. Il est donc inutile d'associer un contact à la fois à un domaine et à un sous domaine. <br />
     <br />
   <a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=ajouter-contact">Ajouter un contact</a> 
   <br />
<br />
</p>
  <?php
  $listcont = new ListeContacts();
  $nb_cont=$listcont->afficherListeContacts();	
  if ($nb_cont) {
  ?>
  <table width="100%">
  	  <tr class="entete"><td>Nom</td><td>Prenom</td><td>Email</td><td>T&eacute;l&eacute;phone</td><!--<td>Portable</td><td>Fax</td>--><td>Référent</td><td>Menus associ&eacute;s</td><td>Actions</td></tr>
	  <?php
	  foreach ($listcont as $contacts) {   
	  	if (!$cl) $cl="class=\"fond_clair\""; else $cl="";
	  ?>
	   <tr <?=$cl?>>
		   	<td><?=$contacts->nom?></td>
			<td><?=$contacts->prenom?></td>
			<td><?=$contacts->email?></td>
			<td><?=$contacts->tel?></td>
			<!--<td><?=$contacts->gsm?></td>
			<td><?=$contacts->fax?></td>-->
			<td><?php if ($contacts->referent=="o") echo "oui"; else echo "non";?></td>
			<td>
			<?php
			$nb_categ=$contacts->afficherCateg();
			if ($nb_categ>0) {
			   for ($i=0;$i<count($contacts->listcateg);$i++) {
			   	   $laCateg=$contacts->listcateg[$i];
				   echo $laCateg->nomMenu."<br />";
			   } 
			}//fin if ($nb_categ>0)	 
			
			$nb_sscateg=$contacts->afficherSscateg();
			if ($nb_sscateg>0) {
			   for ($i=0;$i<count($contacts->listsscateg);$i++) {
			   	   $laSscateg=$contacts->listsscateg[$i];
				   echo $laSscateg->nomMenu."<br />";
			   } 
			}//fin if ($nb_sscateg>0)	 
			
			?>
			</td>
			<td>
			<a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=ajouter-contact&numcont=<?=$contacts->numcontact?>">modifier</a><br />
			<a href="javascript:if (confirm('Souhaitez-vous supprimer le contact ?')) window.location='index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&supcont=<?=$contacts->numcontact?>'">supprimer</a>
			</td>
	   </tr> 
	  <?php 
	  }	//fin du foreach  listcont
	  ?>
	  
  </table>
  <br /><br />
 
  <?php
  }	else {
  ?>
  	Il n'y a aucun contact cr&eacute;&eacute;.
  <?php
  }//fin de if ($nb_rub) 
  ?>
<br />	
</div>

</div>

</div>
