<?php /* Date de cr�ation: 17/03/2009 */ 
?>
<div class="item" id="coltexteAdmin">
	<div class="sap-content">
<div id="pageadmin">

  <legend><strong>Liste des inscriptions aux formations</strong></legend>
   <br /><br />
	<!--<select name="selectForm">
		<option value="">Rechercher une formation</option>
		<?php
		$listform = new ListeParagraphes();	  
		$listform->formation=1;
		$listform->tri_date=" WHERE sur_mesure='o' AND validee!='o' ORDER BY titre";
		$listform->afficherListeParas();
		foreach ($listform as $paras) {	
		?>
			<option value="<?=$paras->numpara?>"><?=$paras->titrePara?></option>
		<?php
		}
		?>
	</select>
	<br />
	-->
  <?php
  if (!$numpara) {
	  $listform = new ListeParagraphes();	
	  $listform->formation=1; 
	  $listform->tri_date=" WHERE sur_mesure='o' AND validee!='o' ORDER BY titre";
	  $nb_form=$listform->afficherListeParas();	
	  if ($nb_form) {
  ?>
	  <table>
		  <tr class="entete"><td>Formation</td><td>Nombre d'inscrits<td></td></tr>
		  <?php
		  foreach ($listform as $paras) {	
			if (!$cl) $cl="class=\"fond_clair\""; else $cl="";
		  ?>
		   <tr <?=$cl?>>
				<td><?=$paras->titrePara?></td>
				<td><?=$paras->nbInscrits();?></td>
				<td>
					<a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numpara=<?=$paras->numpara?>">voir le détail</a>
					<!--<br />
					<a href="javascript:if (confirm('Souhaitez-vous valider la formation ?')) window.location='index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&valide=<?=$paras->numpara?>'">valider</a>-->
				</td>
		   </tr> 
		  <?php 
		  }	//fin du foreach  listform
		  ?>
	  
	  </table>
	  <br /><br />
	 
	  <?php
	  }	else {
	  ?>
		Il n'y a aucune formation sur mesure non validée.
  <?php
	  }//fin de if ($nb_form) 
	  
   } else {//$numpara => détail de la formation
   	  $laFormation = new Formation();
	  $laFormation->numpara=$numpara;
	  $list_inscrits=$laFormation->listerInscrits();
   ?>
   
  Valider cette formation<br /><br />
  Date de début de la formation (format jj/mm/aaaa) <em>*</em>: <input type="text" id="name" name="textDateDeb"/><br />
  Date de fin de la formation (format jj/mm/aaaa) :  <input type="text" id="name" name="textDateFin" /><br /><br />
  <input type="hidden" name="valide" value="<?=$numpara?>" />
  
  <br />
   <table>
		 <tr class="entete"><td>Client</td><td>Désignation</td><td>Tarif €</td></tr>
   <?php	  
	  for ($i=0; $i<count($list_inscrits);$i++) {
	  		if (!$cl) $cl="class=\"fond_clair\""; else $cl="";
			
			$list_detail=$list_inscrits[$i];
	
			$leClient=$list_detail[0];
			$sesArticles=$list_detail[1];
  ?>
  		<tr <?=$cl?>>
			<td><?=$leClient->nom." ".$leClient->prenom?><br /><?=$leClient->adr1." ".$leClient->adr2;?><br /><?=$leClient->cp." ".$leClient->ville;?></td>
			<td valign="top">
			<?php
			for ($j=0; $j<count($sesArticles);$j++) {
				$sonDetail=$sesArticles[$j];
				echo $sonDetail["designation"]."<br />";
			}
			?>
			</td>
			<td><input type="text" name="textTarif<?=$sonDetail["numcom"]?>" class="public"/></td>
		</tr>
  <?php
  	  }//fin du for
  ?>
  		<tr><td></td><td></td><td><input id="button" name="validerForma" type="button" value="Valider" onClick="javascript:document.forms[0].submit()"/>  </td></tr>
  </table>

  
  <?php
  }//fin du else ($numpara)
  ?>
<br />	
</div>
</div>
</div>