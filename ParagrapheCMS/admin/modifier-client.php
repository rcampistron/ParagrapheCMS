<?php /* Date de cration: 03/02/09 */
$modifClient = new Client();
$modifClient->numclient=$numclient;
$modifClient->infosClient();

?> 
<div class="item" id="coltexteAdmin">
	<div class="sap-content">
		<div class="TabbedPanels">
		  <div class="TabbedPanelsContentGroup">
		    <div class="TabbedPanelsContent"> 
			<fieldset>	
			<legend>Modifier le client</legend>
		 		 <ol>
				    <li>
				      <label for="raisonSociale">Raison sociale :</label>
				      <input type="text" id="raisonSociale" name="textRaison" value="<?=$modifClient->raison?>"/>
				    </li>
					<li>
				      <label for="civilite">Civilité :</label>
				      <select id="civilite" name="selectCiv">
						<option>-</option>
						<option value="Mr" <?php if ($modifClient->civilite=="Mr") echo "selected='selected'";?>>Mr</option>
						<option value="Mme" <?php if ($modifClient->civilite=="Mme") echo "selected='selected'";?>>Mme</option>
						<option value="Mlle" <?php if ($modifClient->civilite=="Mlle") echo "selected='selected'";?>>Mlle</option>
					</select>
				    </li>
				    <li>
				      <label for="name">Nom<em>*</em> :</label>
				      <input type="text" id="name" name="textNom" value="<?=$modifClient->nom?>"/>
				    </li>
				    <li>
				      <label for="prenom">P&eacute;nom :</label>
				      <input type="text" id="prenom" name="textPrenom" value="<?=$modifClient->prenom?>"/>
				    </li>
					
					<li>
				      <label for="fonction">Fonction :</label>
				      <input type="text" id="fonction" name="textFonction" value="<?=$modifClient->fonction?>"/>
				    </li>
					 <li>
				      <label for="adresse1">Adresse :</label>
				      <input type="text" id="adresse1" name="textAdr1" value="<?=$modifClient->adr1?>"/>
				    </li>
					<li>
				      <label for="adresse2"></label>
				      <input type="text" id="adresse2" name="textAdr2" value="<?=$modifClient->adr2?>"/>
				    </li>
					 <li>
				      <label for="CP">Code postal :</label>
				      <input type="text" id="CP" name="textCp" value="<?=$modifClient->cp?>"/>
				    </li>
					 <li>
				      <label for="ville">Ville :</label>
				      <input type="text" id="ville" name="textVille" value="<?=$modifClient->ville?>"/>
				    </li>
					 <li>
				      <label for="pays">Pays :</label>
				      <select name="selectPays" id="pays" class="public" >	
						<?php
						$result = mysql_query("SELECT * FROM if_pays ORDER BY pays");
						while ($row=mysql_fetch_array($result)) {
						?>
							<option value="<?=$row['numpays']?>" <?php if ($modifClient->pays==$row['numpays']) echo "selected='selected'";?>><?=utf8_encode($row['pays'])?></option>
						<?php
						}//fin du while
						?>
						</select>
				    </li>
					 <li>
				      <label for="telephone">Téléphone :</label>
				      <input type="text" id="telephone" name="textTel" value="<?=$modifClient->tel?>"/>
				    </li>
					 <li>
				      <label for="fax">Fax :</label>
				      <input type="text" id="fax" name="textFax" value="<?=$modifClient->fax?>"/>
				    </li>
					 <li>
				      <label for="portable">Portable :</label>
				      <input type="text" id="portable" name="textGsm" value="<?=$modifClient->gsm?>"/>
				    </li>
					<li>
				      <label for="email">Email <em>*</em> :</label>
				      <input type="text" id="email" name="textEmail" value="<?=$modifClient->email?>"/>
				    </li>	
					<li>
				      <label for="pwd">Mot de passe<em>*</em> :</label>
				      <input type="text" id="pwd" name="textPwd" value="<?=$modifClient->pwd?>"/>
				    </li> 
					<li>
					  <label for="estActif">Actif :</label>
					  <input type="radio" id="estActif" name="radioActif" value="o" <?php if ($modifClient->actif=="o" || !$modifClient->actif) echo "checked='checked'";?>/> <span class="radio">oui</span>	<input type="radio" id="radio" name="radioActif" value="n" <?php if ($modifClient->actif=="n") echo "checked='checked'";?>/> <span class="radio">non</span>
					</li> 
				</ol>
				 <input type="hidden" name="numclient" value="<?=$numclient?>" />
				 <input id="button" name="validerClient" type="button" value="Valider" onClick="javascript:valideClient()"/>  
		 	</fieldset>
   </div>
  </div>
  </div>
</div>
</div>

