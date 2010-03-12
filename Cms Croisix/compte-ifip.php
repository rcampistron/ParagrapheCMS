<?php /* Date de création: 13/03/2009*/ 
$laPage = new Page();
$laPage->numpage=$numpage;
$laPage->infosPage();
$laPage->infosColonnes();
 
	//echo "sess=".$_SESSION['numclient'];	
if ($laPage->nomPageGoogle) { 
?>
<div class="item" id="coltexte785"> 
		   <div class="sap-content">
				<!-- item 1 585 pixels wide -->
				<p class="titre785"><?=$laPage->titrePage?></p>
	
  <?php
  if (!$action && !$_SESSION['numclient'])  {
  ?>
	  <fieldset>
	  <legend><strong>Pour accéder à votre compte, veuillez saisir votre email de connexion et votre <br />mot de passe ci-dessous : </strong></legend><br />
		  	   
		<br /><br />
		  
		  <label for="name">Votre email de connexion :</label>
		  <input type="text" id="name" name="textEmailCpte" class="public"/>
		<br />
		  <label for="name">Votre mot de passe :</label>
		  <input type="password" id="name" name="textPwdCpte" class="public"/>
		 <br />
		  <label for="name"></label>
		 <a href="index.php?spec=oublie&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&lg=<?=$lg?>">mot de passe oublié ?</a>
		  <br /> 
		<br />
		<label for="name"></label>
		<input id="validerCpte" class="bouton" name="validerCpte" type="button" value="Valider" onClick="javascript:validerCpteForma()"/>  
		<br />
		<br /> 
		<br />
		<br />
		<label for="name"></label>
		   <strong>Vous n'êtes pas enregistré ? Inscrivez-vous :</strong>
		<br /><br />
		<label for="name">Civilité :</label>
		  <select name="selectCiv " class="public">
			<option>-</option>
			<option value="Mr">Mr</option>
			<option value="Mme">Mme</option>
			<option value="Mlle">Mlle</option>
		</select>
		<br />
		  <label for="name">Nom<em class="important">*</em> :</label>
		  <input type="text" name="textNom" class="public" />
		 <br />
		 <label for="name">Prénom<em class="important">*</em> :</label>
		  <input type="text" name="textPrenom" class="public"/>
		 <br />
		 <label for="textSociete">Société<em class="important">*</em> :</label>
		 <input type="text" name="textSociete" class="public" />
		 <br />
		 
		<label for="name">Email<em class="important">*</em> :</label>
		  <input type="text" name="textEmail" class="public"/>
		 <br />
		 <label for="name">Mot de passe<em class="important">*</em> :</label>
		  <input type="text" name="textPwd" class="public"/>
		<br /> 
		<label for="textAdr1">Adresse<em class="important">*</em> :</label>
		<input type="text" name="textAdr1" class="public" />
		<br />
		<label for="textAdr2"></label>
		<input type="text" name="textAdr2" class="public" />
		<br />
		<label for="textCp">Code Postal<em class="important">*</em> :</label>
		<input type="text" name="textCp" class="public" />
		<br />
		<label for="textVille">Ville<em class="important">*</em> :</label>
		<input type="text" name="textVille" class="public" />
		<br />
		<label for="selectPays">Pays<em class="important">*</em> :</label>
		<select name="selectPays" class="public">
		<option>Sélectionnez un pays</option>
		<option>------------------------------------------------------</option>
		<option value="247">France metropolitaine</option>
		<option>------------------------------------------------------</option>
		<?php
		$result = mysql_query("SELECT * FROM if_pays ORDER BY pays");
		while ($row=mysql_fetch_array($result)) {
		?>
			<option value="<?=$row['numpays']?>"><?=utf8_encode($row['pays'])?></option>
		<?php
		}//fin du while
		?>
		</select>
		<br />
		<label for="textTel">Tel<em class="important">*</em> :</label>
		<input type="text" name="textTel" class="public" />
		<br />
		<label for="textFax">Fax :</label>
		<input type="text" name="textFax" class="public" />
		<br />
		<label for="name"></label>
		<input id="validerInscr" name="validerInscr" type="button"  class="bouton" value="Valider" onClick="javascript:validerInscrForma('creerCompte')"/> 
		</fieldset>
	<?php
	} else if ($_SESSION['numclient'] && !$numcom) {//fin if (!$action && !$_SESSION['numclient'])
		if ($action=="creerCompte") {
	?>
			<strong>Merci, vous êtes maintenant enregistré sur notre site.</strong>
			<br /><br />
		
	<?php
		}
		$listcom = new ListeCommandes();
		$listcom->numclient=$_SESSION['numclient'];
		$listcom->etat=">=1";
		$listcom->erreur_paiement="non";
		$nb_com=$listcom->afficherListeCommandes();
		
		if ($nb_com) {
    ?>
		<h1 class="sansmarge">Liste de vos commandes</h1>
		<table>
		  <tr class="entete"><td>Numéro</td><td>Type</td><td>Date</td><td>Montant</td><td>Réglée</td><td>Etat</td><td></td></tr>
		  <?php
		  foreach ($listcom as $commandes) {   
			if (!$cl) $cl="class=\"fond_clair\""; else $cl="";
		  ?>
		   <tr <?=$cl?>>
				<td><?=$commandes->numcom?></td>
				<td><?php if ($commandes->formation) echo "Inscription formation"; else echo "Achat documentation";?></td>
				<td><?=$commandes->dcrea?></td>
				<td><?=$commandes->montantTTC." €"?></td>
				<td><?php 
				if ($commandes->tpereg=="cb" && $commandes->erreurpaiement=="non") echo "Oui, par Carte Bancaire";
				else if ($commandes->tpereg=="ch" && $commandes->etat=="1") echo "Non, par chèque"; 
				else if ($commandes->tpereg=="ch" && $commandes->etat>=2) echo "Oui, par chèque"; 
				else if ($commandes->tpereg=="dv" && $commandes->etat>=1) echo "Demande de devis";?></td>
				<td><?php if ($commandes->etat=="1") echo "en attente de validation"; else if ($commandes->etat=="2") echo "validée"; else if ($commandes->etat=="3") echo "expédiée"; else echo "traitée";?></td>
				<td>
					<a href="index.php?numpage=<?=$laPage->numpage?>&spec=<?=$spec?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&lg=<?=$lg?>&numcom=<?=$commandes->numcom?>">voir le détail</a>
				</td>
		   </tr> 
		  <?php 
		  }	//fin du foreach  listcom
		  ?>
	  
  		</table>
	
	<?php		
		} else {
	?>	
		Vous n'avez aucune commande en cours.
	<?php
		}//fin du else if ($nb_com)
	} else if ($numcom) {//fin else if ($_SESSION['numclient'] && !$numcom)
		$voirCom = new Commande();
		$voirCom->numcom=$numcom;
		$voirCom->infosCommande();
	?>
			<h2 class="supprmarge">Détail de la commande n° <?=$numcom?><!--<?=$voirCom->numerop?>--> du <?=$voirCom->dcrea?></h2> 
			<strong>Etat : </strong><?php if ($voirCom->etat=="1") echo "en attente de validation"; else if ($voirCom->etat=="2") echo "validée"; else if ($voirCom->etat=="3") echo "expédiée"; else echo "traitée";?>
		 <br />
		<?php
		if (!$voirCom->formation && !$voirCom->article) {//documentation
		?>	  
			  <br /><strong>Votre adresse de livraison :</strong><br />
			  <?php
			  $voirCom->infosLivraison();
			  echo $voirCom->raison_l."<br />".$voirCom->nom_l." ".$voirCom->prenom_l."<br />".$voirCom->adr1_l." ".$voirCom->adr2_l."<br />".$voirCom->cp_l." ".$voirCom->ville_l."<br />".$voirCom->nompays_l;
			  if ($voirCom->tel_l) echo "<br />Téléphone : ".$voirCom->tel_l;
			  ?>
			<br /><br />
			  <strong>Votre adresse de facturation :</strong><br />
			  <?php
			  echo $voirCom->raison_f."<br />".$voirCom->nom_f." ".$voirCom->prenom_f."<br />".$voirCom->adr1_f." ".$voirCom->adr2_f."<br />".$voirCom->cp_f." ".$voirCom->ville_f."<br />".$voirCom->nompays_f;
			  if ($voirCom->tel_f) echo "<br />Téléphone : ".$voirCom->tel_f;
			  if ($voirCom->fax_f) echo "<br />Fax : ".$voirCom->fax_f;
			  ?>
			<br /><br />
		<?php
		}//fin if (!$voirCom->formation)
		?>
		
			  Montant de la commande : <strong><?=$voirCom->montantTTC?> €</strong>
	   <?php
		if (!$voirCom->formation && !$voirCom->article) { // documentation
		?>		
			 <br /><br />
			  Frais de port : <strong><?=$voirCom->fraisPort?> €</strong>
		<?php
		}//fin if (!$voirCom->formation)
		?>
		
			<br /><br />
			  Réglement :&nbsp;
			  <?php if ($voirCom->tpereg=="ch") echo "par chèque"; else if ($voirCom->tpereg=="vi") echo "par virement bancaire"; else if ($voirCom->tpereg=="cb") echo "par Carte Bancaire"; else if ($voirCom->tpereg=="dv") echo "demande de devis"; ?>
			 <br />
			 <table width="100%" cellpadding="0" cellspacing="0" border="0">
			 <tr class="entete">
			 <td width="7%">Référence</td>
			 <td width="19%"><div align="left">Formation ou documentation</div></td>
			 <td width="6%">Quantité</td>
			 <td width="6%">Prix</td>
			 <td width="62%"><div align="left">Obtenir</div></td>
			 </tr>
			 <?php
			 $detail=new Panier();
			 $detail->numcom=$voirCom->numcom;
			 
			 if ($voirCom->formation) $list_articles=$detail->listerArticlesForm(); else if ($voirCom->article) $list_articles=$detail->listerArticlesCrees(); else $list_articles=$detail->listerArticles();
			 for ($i=0; $i<count($list_articles); $i++) {
				$article=$list_articles[$i];
				if (!$voirCom->formation && !$voirCom->article) { // une doc
			 ?>
				  <tr>
					<td><?=$article["reference"]?> - <?=$article["numpara"]?></td>
					<td><?=$article["titre"]?></td>
					<td align="center"><?=$article["qte"]?></td>
					<td><?=$article["prix_total"]?>&nbsp;€</td>
					<td>
					<?php
					if ($voirCom->etat=="2" || $voirCom->etat=="3" || $voirCom->etat=="4") {
						if ($article["numpara"]) {
							$fiche=new ListeFichiers();
							$fiche->numpara=$article["numpara"]; 
							$nb_fichiers=$fiche->afficherListeFichiers();
							//print_r($fiche);
							
							if ($nb_fichiers) {
								foreach ($fiche as $fichiers) {
									$nom_fiche=$fichiers->nomFichier;
									$poids_fiche=$fichiers->poidsFichier;
									if ($nom_fiche) {//le pdf existe
									?>
										<a href="ouverturepdf.php?file=<?=$nom_fiche?>" target="_blank" class="pdf">
										Télécharger (<?=$poids_fiche?>)</a>
										<br />
									<?php
									}// fin if ($nom_fiche)
								} // fin foreach 
							} else {
								if ($voirCom->etat=="2") {
								?>
								La documentation est en cours d'expédition
					
								<?php
								} else if ($voirCom->etat=="3") {
								?>
								La documentation a été expédiée
					
								<?php
								} else if ($voirCom->etat=="4") {
								?>
								Commande archivée
								<?php
								
								}
							} //fin else

						}//fin if ($article["numpara"])
					}//fin if ($voirCom->etat=="2" || $voirCom->etat=="3")
					?>
					
					
					</td>
				  </tr>
				<?php
				} else if ($voirCom->formation) {
					$laForma=new Formation();
					$laForma->numpara=$article["numpara"];
					$laForma->infosFormation();
				?>
					<tr>
					  <td colspan="5">
					  <?php echo $article["designation"]; if ($article["designation"]=="Inscription formation") echo " \"".$laForma->titrePara."\"";?>
					  </td>
					</tr>
				<?php
				} else {//fin du else if ($voirCom->formation)
				?>
					<tr>
					  <td colspan="5"><?=$article["designation"]?></td>
					</tr>
				<?php
				}//fin du else if ($voirCom->article)
				?>
				<br /><br />
			 <?php
			 }//fin du for ($i=0; $i<count($list_articles); $i++)
			 ?>
			 </table>
			  <br /><br />
			  <?php
			  if ($voirCom->suivi_coliposte) {
			  ?>
			  	<strong>Suivi Coliposte :</strong>&nbsp;
				
			  <?php
			  	echo $voirCom->suivi_coliposte;
			  }//fin if ($voirCom->suivi_coliposte)
			  ?>
	<?php
	}//fin else if ($numcom) 
	?>	
	<input type="hidden" name="numpara" value="<?=$numpara?>"/>
<input type="hidden" name="action" />

				<p>&nbsp;</p>
				<p>&nbsp;</p>
				
  </div>
</div>
<?php
}//fin if ($laPage->nomPageGoogle)
?>
