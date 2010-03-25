<?php /* Date de création: 12/02/2009 */ 
?>

<div class="item" id="coltexteAdmin">
	<div class="sap-content">
<div id="pageadmin">
  <h2>Liste des brèves d'actualités</h2>
   <p>Les brèves s'affichent dans la rubrique L'institut&gt; Les actualités <br />
     et en page d'accueil (zone de droite Les brèves) lorsque le critère correspondant est coché.<br />
     La mise en page est automatique : titre gras, lien etc. <br />
     <br />
   <a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=ajouter-actu">Ajouter une brève d'actualité</a>
   <br /><br />
   </p>
  <?php
  $listactus = new ListeParagraphes();	  
  $listactus->actu=1;
  $listactus->req_actu=" ORDER BY titre";
  $nb_actus=$listactus->afficherListeParas();
  if ($nb_actus) {	
  ?>
  <table width="500">
  	  <tr class="entete"><td>Titre</td>
  	    <td>Affichage accueil </td>
  	    <td>Actions</td></tr>
	  <?php	
	  $cl="";
	  foreach ($listactus as $paras) {	
	  	 if (!$cl) $cl="class=\"fond_clair\""; else $cl="";
	  ?>
	   <tr <?=$cl?>>
		   	<td><strong><?=$paras->titrePara?></strong></td>
			<td><? if($paras->accueil=="o") echo"oui"; else echo"non";?></td>
			<td><a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=ajouter-actu&numpara=<?=$paras->numpara?>">modifier</a><br/>
			<a href="javascript:if (confirm('Souhaitez-vous supprimer la brève d\'actualité ?')) window.location='index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&supactu=<?=$paras->numpara?>'">supprimer</a>			</td>
	   </tr>
	   <?php
	   }//fin du foreach 
	   ?> 
 </table>
 <?php
 }  else {
 ?>
 	Il n'y a aucune brève d'actualité
  <?php
 }
 ?>
  <br /><br />
<br />	
</div>
</div>
</div>

