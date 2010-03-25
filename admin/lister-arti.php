<?php /* Date de création: 30/03/2009 */ 
?>

<div class="item" id="coltexteAdmin">
	<div class="sap-content">
<div id="pageadmin">
  <h2>Liste des articles</h2>
   
   <p>
   Veuillez copier/coller dans l'email destiné au client le lien indiqué pour l'article créé et ajouter le prix souhaité après la dernière variable<br />
   <strong>exemple pour un article de 12 Euros</strong> :<br />
http://www.ifipinfo.fr/index.php?numarticle=4&amp;prix=12<br /><br />
<a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=ajouter-arti">Créer un article</a>
<br />
<br />
</p>
  <?php
  $listartis = new ListeArticles();	  
  $nb_artis=$listartis->afficherListeArticles();
  if ($nb_artis) {	
  ?>
  <table width="760">
  	  <tr class="entete"><td>Libellé</td><td>Lien à fournir<br />  	    <br /></td>
  	    <td>Actions</td></tr>
	  <?php	
	  $cl="";
	  foreach ($listartis as $articles) {	
	  	 if (!$cl) $cl="class=\"fond_clair\""; else $cl="";
	  ?>
	   <tr <?=$cl?>>
		   	<td><?=$articles->libelle?></td>
			<td><?=$if_site["url"]."/index.php?numarticle=".$articles->numarticle."&prix="?></td>
			<td><a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=ajouter-arti&numarticle=<?=$articles->numarticle?>">modifier</a><br/>
			<a href="javascript:if (confirm('Souhaitez-vous supprimer l\'article ?')) window.location='index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&suparti=<?=$articles->numarticle?>'">supprimer</a>
			</td>
			
	   </tr>
	   <?php
	   }//fin du foreach 
	   ?> 
 </table>
 <?php
 }  else {
 ?>
 	Il n'y a aucun article
  <?php
 }
 ?>
  <br /><br />
<br />	
</div>
</div>
</div>


