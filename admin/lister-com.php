<?php /* Date de creation : 03/02/2009 */ ?>
<div class="item" id="coltexteAdmin">
	<div class="sap-content">
<div id="pageadmin">

  <h2>Liste des commandes</h2>
   <br /><br />
	Critères de recherche
	<br />
	<select name="selectEtat">
		<option value="">Etat de la commande</option>
		<option value="1">En attente de validation</option>
		<option value="2">Validée (réglée)</option>
		<option value="3">Expédiée</option>
		<option value="4">Archivée</option>
		<!--<option value="4">Reçue</option>-->
	</select>
	<br />
	<select name="selectReg">
		<option value="">Mode de réglement</option>
		<option value="ch">chèque</option>
		<option value="vi">virement</option>
		<option value="cb">carte bancaire</option>
		<option value="dv">demande de devis</option>
	</select>
	<br />
	du <input type="text" class="public" name="textDu"/> au <input type="text" class="public" name="textAu"/> format jj/mm/aaaa
	<br />
	<input type="hidden" name="action" />
	<input id="button" name="validerRech" type="button" value="Rechercher" onClick="javascript:valideRech()"/>  
	<br /><br />
  <h4>Commandes 
  <?php
  if ($selectEtat=="1") echo " en attente de validation"; 
  else if ($selectEtat=="2") echo " validées (réglées)"; 
  else if ($selectEtat=="3") echo " expédiées";
  else if ($selectEtat=="4") echo " archivées";  
  
  if ($selectReg=="ch") echo " réglées par chèque";
  if ($selectReg=="vi") echo " réglées par virement";
  else if ($selectReg=="cb") echo " réglées par carte bancaire";
  else if ($selectReg=="dv") echo " (demandes de devis)";
  
  if ($textDu && $textAu) echo " passées du ".$textDu." au ".$textAu;
  else if ($textDu) echo " passées à partir du ".$textDu;
  else if ($textAu) echo " passées jusqu'au ".$textAu; 
  
  if (!$selectEtat && !$selectReg && !$textDu && !$textAu) echo "en attente de validation";
  ?>
  </h4>
  <?php
  $listcom = new ListeCommandes();
  if (!$action) {
	$listcom->etat="=1";//par défaut : commande en attente de validation par l'admin
  } else {
  	if ($selectEtat || $selectReg || $textDu || $textAu) {
		if ($selectEtat) $listcom->etat="=".$selectEtat;
		if ($selectReg) $listcom->type_reg=$selectReg;
		if ($textDu) {
			$list_du=explode("/",$textDu);
			$date_du=mktime(0,0,0,$list_du[1],$list_du[0],$list_du[2]);
			$listcom->date_du=$date_du;
		}
		if ($textAu) {
			$list_au=explode("/",$textAu);
			$date_au=mktime(23,59,59,$list_au[1],$list_au[0],$list_au[2]);
			$listcom->date_au=$date_au;
		}
		if (!$listcom->etat) $listcom->etat=">=1";
	} else {
		if (!$listcom->etat) $listcom->etat="=1";//par défaut : commande en attente de validation par l'admin
	}
  }
  $nb_com=$listcom->afficherListeCommandes();	
  if ($nb_com) {
  ?>
  <table>
  	  <tr class="entete"><td>Numéro</td><td>Date</td><td>Client</td><td>Montant</td><td>Réglée</td><td>Etat</td><td></td></tr>
	  <?php
	  $total=0;
	  foreach ($listcom as $commandes) {   
	  	if (!$cl) $cl=" class=\"fond_clair\""; else $cl="";
		//calcul du total
		$total+=str_replace(",",".",$commandes->montantTTC);
	  ?>
	   <tr<?=$cl?>>
		   	<td><?=$commandes->numcom?>
			<!-- ?????verifier pourquoi Sev avait mis ce champ au lieu de numcom <?=$commandes->numerop?>--></td>
			<td><?=$commandes->dcrea?></td>
			<td>
			<?php
			$clientCom=new Client();
			$clientCom->numclient=$commandes->numclient;
			$clientCom->infosClient();
			echo $clientCom->raison."<br />".$clientCom->civilite." ".$clientCom->nom." ".$clientCom->prenom."<br />".$clientCom->adr1." ".$clientCom->adr2." ".$clientCom->cp." ".$clientCom->ville." ".$clientCom->nompays;
			?>
			</td>
			<td><?=$commandes->montantTTC." €"?></td>
			<td><?php 
			if ($commandes->tpereg=="cb" && $commandes->erreurpaiement=="non") echo "Oui, par Carte Bancaire";
			else if ($commandes->tpereg=="cb" && $commandes->erreurpaiement=="oui") echo "Non, erreur paiement Carte Bancaire";
			else if ($commandes->tpereg=="cb" && !$commandes->erreurpaiement) echo "Non, paiement Carte bancaire non finalisé";
			else if ($commandes->tpereg=="ch" && $commandes->etat=="1") echo "Non, par chèque"; 
			else if ($commandes->tpereg=="ch" && $commandes->etat>=2) echo "Oui, par chèque";
			else if ($commandes->tpereg=="vi" && $commandes->etat=="1") echo "Non, par virement"; 
			else if ($commandes->tpereg=="vi" && $commandes->etat>=2) echo "Oui, par virement"; 
			else if ($commandes->tpereg=="dv" && $commandes->etat>=1) echo "Demande de devis";?></td>
			<td><?php if ($commandes->erreurpaiement=="oui") echo"Paiement Refusé par la banque OU annulé par le client";
			else {
				if ($commandes->etat=="1") echo "en attente de validation"; 
				else if ($commandes->etat=="2") echo "validée"; 
				else if ($commandes->etat=="3") echo "expédiée"; 
				else if ($commandes->etat=="4") echo "archivée";
			}
			?></td>
			<td>
				<a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=modifier-com&numcom=<?=$commandes->numcom?>">voir le détail</a>
				<br />
				<a href="javascript:if (confirm('Souhaitez-vous supprimer la commande ?')) window.location='index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&supcom=<?=$commandes->numcom?>&selectEtat=<?=$selectEtat?>&action=<?=$action?>'">supprimer</a>
			</td>
	   </tr> 
	  <?php 
	  }	//fin du foreach  listcont
	  ?>
	  <tr>
	    <td class="trait"></td>
	    <td class="trait">&nbsp;</td>
	    <td class="trait">&nbsp;</td>
	   <td class="trait">&nbsp;</td>
	   <td class="trait">&nbsp;</td>
	    <td class="trait">&nbsp;</td>
	    <td class="trait">&nbsp;</td>
		</tr>
		<tr>
	    <td>TOTAL</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	   <td width="80"><?=number_format($total,2,","," ")?>&nbsp;€</td>
	   <td>&nbsp;</td>
	   <td>&nbsp;</td>
	    <td>&nbsp;</td>
		</tr>
  </table>
  <br />
      <br />
    
      <?php
  }	else {
  ?>
    <p>Il n'y a aucune commande correspondant à ces critères.</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p></p>
  <p>&nbsp;</p>
  <p>&nbsp;</p><p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
        <?php
  }//fin de if ($nb_rub) 
  ?>
    <br />	
        
</div>

</div>

</div>