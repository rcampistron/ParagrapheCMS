<?php /* Date de cration: 04/02/09 */
$voirCom = new Commande();
$voirCom->numcom=$numcom;
$voirCom->infosCommande();

?> 
<div class="item" id="coltexteAdmin">
	<div class="sap-content">
		<div class="TabbedPanels">
		  <div class="TabbedPanelsContentGroup">
		    <div class="TabbedPanelsContent"> 
			<h2>Détail de la commande n° <?=$numcom?><!--<?=$voirCom->numerop?>--> du <?=$voirCom->dcrea?></h2>
		 		 <strong>Client :</strong>
				 <br />
				      <?php
					  $clientCom = new Client();
					  $clientCom->numclient=$voirCom->numclient;
					  $clientCom->infosClient();
					  echo $clientCom->raison."<br />".$clientCom->civilite." ".$clientCom->nom." ".$clientCom->prenom."<br />".$clientCom->adr1." ".$clientCom->adr2."<br />".$clientCom->cp." ".$clientCom->ville."<br />".$clientCom->nompays;
					  if ($clientCom->tel) echo "<br />Téléphone : ".$clientCom->tel;
					  if ($clientCom->fax) echo "<br />Fax : ".$clientCom->fax;
					  if ($clientCom->gsm) echo "<br />Portable : ".$clientCom->gsm;
					  ?>
				    <br />
					<br />
				      <strong>Adresse de livraison :</strong><br />
				      <?php
					  $voirCom->infosLivraison();
					  echo $voirCom->raison_l."<br />".$voirCom->nom_l." ".$voirCom->prenom_l."<br />".$voirCom->adr1_l." ".$voirCom->adr2_l."<br />".$voirCom->cp_l." ".$voirCom->ville_l."<br />".$voirCom->nompays_l;
					  if ($voirCom->tel_l) echo "<br />Téléphone : ".$voirCom->tel_l;
					  ?>
				    <br />
					<br />
				     <strong>Adresse de facturation :</strong><br />
				      <?php
					  echo $voirCom->raison_f."<br />".$voirCom->nom_f." ".$voirCom->prenom_f."<br />".$voirCom->adr1_f." ".$voirCom->adr2_f."<br />".$voirCom->cp_f." ".$voirCom->ville_f."<br />".$voirCom->nompays_f;
					  if ($voirCom->tel_f) echo "<br />Téléphone : ".$voirCom->tel_f;
					  if ($voirCom->fax_f) echo "<br />Fax : ".$voirCom->fax_f;
					  ?>
				    <br />
					<br />
					<fieldset>
					<ol>
					<li>
				      <label for="name">Montant de la commande :</label>
					  <?=$voirCom->montantTTC?> €
					 </li>
					 <li>
				      <label for="name">Frais de port :</label>
					  <?=$voirCom->fraisPort?> €
					 </li>
					 <li>
				      <label for="name">Réglement :</label>
					  <?php if ($voirCom->tpereg=="ch") echo "par chèque"; else if ($voirCom->tpereg=="vi") echo "par virement"; else if ($voirCom->tpereg=="cb") echo "par Carte Bancaire"; else if ($voirCom->tpereg=="dv") echo "demande de devis";?>
					 </li>
					 <br /><br />
					 <li>
				      <label for="name"><strong>Articles de la commande :</strong></label>
					 <?php
					 $detail=new Panier;
					 $detail->numcom=$voirCom->numcom;
					 if ($voirCom->formation) $list_articles=$detail->listerArticlesForm(); 
					 else if ($voirCom->article) $list_articles=$detail->listerArticlesCrees();
					 else $list_articles=$detail->listerArticles();
					 for ($i=0; $i<count($list_articles); $i++) {
					 	$article=$list_articles[$i];
						if ($voirCom->formation) {
							$laForma= new Formation();
							$laForma->numpara=$article["numpara"];
							$laForma->infosFormation();
						}
					 ?>
					  <li>
				      	<?php
						if ($voirCom->formation) echo "Inscription à la formation \"".$laForma->titrePara."\" - tarif : ".$article["montantTTC"]." €";
						else if ($voirCom->article) echo $article["designation"]." - tarif : ".$article["prix_vente"]." €";
						else echo $article["titre"]." - réf :".$article["reference"]." - quantité : ".$article["qte"]." - prix total : ".$article["prix_total"]." €";
						
						?>
					 </li>
					 <?php
					 }//fin du for
					 ?>
					  <br /><br />
					 <li>
				      <label for="name"><strong>Etat de la commande :</strong></label>
					  <select name="selectEtat">
					  	<option value="1" <?php if ($voirCom->etat=="1") echo "selected='selected'";?>>En attente de validation</option>
					    <option value="2" <?php if ($voirCom->etat=="2") echo "selected='selected'";?>>Validée</option>
						<option value="3" <?php if ($voirCom->etat=="3") echo "selected='selected'";?>>Expédiée</option>
						<option value="4" <?php if ($voirCom->etat=="4") echo "selected='selected'";?>>Archivée</option>
					  </select>
					 </li>
					 <li>
				      <label for="name">Suivi coliposte :</label>
				      <input type="text" id="suivi" name="textColiposte" value="<?=$voirCom->suivi_coliposte?>"/>
				    </li>
				</ol>
				 <br />	
				  <input type="hidden" name="numcom" value="<?=$numcom?>" />
				  <input type="hidden" name="action"  value="<?=$action?>" />
				 <input id="button" name="validerCommande" type="button" value="Modifier" onClick="javascript:valideCommande()"/>  
		 	     <input id="button" name="retour" type="button" value="Retour (sans mail)" onclick="javascript:document.forms[0].action.value='annuler';document.forms[0].submit()"/>
					</fieldset>
   </div>
  </div>
  </div>
</div>
</div>


