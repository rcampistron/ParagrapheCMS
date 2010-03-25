<?php /* Date de creation: 19/12/2008 */ 
//setlocale(LC_ALL, "french");
?>

<div class="item" id="coltexteAdmin">
	<div class="sap-content">
<div id="pageadmin">
  <h2>Liste des formations</h2>
   <p>La prochaine formation s'affiche automatiquement dans la colonne de droite (contenus contributifs) des pages associées. <br />
     <br />
   <a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=ajouter-forma">Ajouter une formation</a>
   <br /><br />
   </p>
  <?php
  $listform = new ListeParagraphes();	  
  $listform->formation=1;
  $listform->tri_date=" ORDER BY titre";
  $nb_form=$listform->afficherListeParas();
  if ($nb_form) {	
  ?>
  <table width="100%">
  	  <tr class="entete"><td>Titre</td><td>Date de d&eacute;but</td><td>Date de fin</td><td>Menus associ&eacute;s</td><td>Fiche</td><td>Actions</td></tr>
	  <?php	
	  $cl="";
	  foreach ($listform as $paras) {	
	  	 if (!$cl) $cl="class=\"fond_clair\""; else $cl="";
	  ?>
	   <tr <?=$cl?>>
		   	<td><?=$paras->titrePara?></td>
			<td><?php if ($paras->datedeb!="01/01/1970") echo $paras->datedeb;?></td>
			<td><?php if ($paras->datefin!="01/01/1970") echo $paras->datefin;?></td>
			<td>
			<?php
			$nb_categ=$paras->afficherCateg();
			if ($nb_categ>0) {
			   for ($i=0;$i<count($paras->listcateg);$i++) {
			   	   $laCateg=$paras->listcateg[$i];
				   echo $laCateg->nomMenu."<br />";
			   } 
			}//fin if ($nb_categ>0)	 
			
			$nb_sscateg=$paras->afficherSscateg();
			if ($nb_sscateg>0) {
			   for ($i=0;$i<count($paras->listsscateg);$i++) {
			   	   $laSscateg=$paras->listsscateg[$i];
				   echo $laSscateg->nomMenu."<br />";
			   } 
			}//fin if ($nb_sscateg>0)	 
			
			?> 
			</td>
			<td>
			<?php
			$listfichiers=new ListeFichiers();
			$listfichiers->numpara= $paras->numpara; 
			$nb_fichiers=$listfichiers->afficherListeFichiers();
			foreach ($listfichiers as $fichiers) {
			?>
			  <a href="ouverturepdf.php?file=<?=$fichiers->nomFichier?>" target="_blank"><?=$fichiers->nomFichier?></a>
			<?php
			}
			?>
			</td>
			<td><a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=ajouter-forma&numpara=<?=$paras->numpara?>">modifier</a><br/>
			<a href="javascript:if (confirm('Souhaitez-vous supprimer la formation ?')) window.location='index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&supform=<?=$paras->numpara?>&numparafichier=<?=$fichiers->numparafichier?>'">supprimer</a>
			</td>
	   </tr>
	   <?php
	   }//fin du foreach 
	   ?> 
 </table>
 <?php
 }  else {
 ?>
 	Il n'y a aucune formation
  <?php
 }
 ?>
  <br /><br />
<br />	
</div>
</div>
</div>
