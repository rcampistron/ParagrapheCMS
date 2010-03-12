<?php /* Date de création: 09/02/2009 */ 
?>

<div class="item" id="coltexteAdmin">
	<div class="sap-content">
<div id="pageadmin">
  <h2>Liste des brèves internationales</h2>
   <p>La brève internationale la plus récente s'affiche automatiquement en page d'accueil.<br />
     Dans la page des brèves internationales, les brèves des 30 derniers jours sont affichées par défaut. Le visiteur peut également effectuer une recherche par pays et/ou période.
     <br />
     <br />
   <a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=ajouter-breve">Ajouter une brève internationale</a>
   <br /><br />
   </p>
  <?php
  $listbreves = new ListeParagraphes();	  
  $listbreves->breve=1;
  $listbreves->req_breve=" ORDER BY date DESC";
  $nb_breves=$listbreves->afficherListeParas();
  if ($nb_breves) {	
  ?>
  <table width="100%">
  	  <tr class="entete"><td>Titre</td><td>Pays</td><td>Date</td><td>Actions</td></tr>
	  <?php	
	  $cl="";
	  foreach ($listbreves as $paras) {	
	  	 if (!$cl) $cl="class=\"fond_clair\""; else $cl="";
	  ?>
	   <tr <?=$cl?>>
		   	<td><?=$paras->titrePara?></td>
			<td><?=utf8_encode($paras->nom_pays)?></td>
			<td><?=$paras->date_breve?></td>
			<td><a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=ajouter-breve&numpara=<?=$paras->numpara?>">modifier</a><br/>
			<a href="javascript:if (confirm('Souhaitez-vous supprimer la brève ?')) window.location='index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&supbreve=<?=$paras->numpara?>'">supprimer</a>
			</td>
	   </tr>
	   <?php
	   }//fin du foreach 
	   ?> 
 </table>
 <?php
 }  else {
 ?>
 	Il n'y a aucune brève
  <?php
 }
 ?>
  <br /><br />
<br />	
</div>
</div>
</div>

