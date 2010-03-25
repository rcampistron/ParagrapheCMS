<?php /* Date de cration: 29/01/09 */
if ($numclient) {//on est en modification
   $modifProf = new Client();
   $modifProf->numclient=$numclient;
   $modifProf->infosClient();
}
?> 
<div class="item" id="coltexteAdmin">
	<div class="sap-content">
		<div class="TabbedPanels">
		  <div class="TabbedPanelsContentGroup">
		    <div class="TabbedPanelsContent"> 
			<fieldset>	
			<legend><?php if ($numclient) echo "Modifier le professionnel"; else echo "Ajouter un professionnel";?></legend>
		 		 <ol>
				    <li>
				      <label for="name">Structure :</label>
				      <input type="text" id="name" name="textRaison" value="<?=$modifProf->raison?>"/>
				    </li>
				    <li>
				      <label for="name">Nom<em>*</em> :</label>
				      <input type="text" id="name" name="textNom" value="<?=$modifProf->nom?>"/>
				    </li>
				    <li>
				      <label for="name">Pr&eacute;nom :</label>
				      <input type="text" id="prenom" name="textPrenom" value="<?=$modifProf->prenom?>"/>
				    </li>
					<li>
				      <label for="name">Email<em>*</em> :</label>
				      <input type="text" id="email" name="textEmail" value="<?=$modifProf->email?>"/>
				    </li>	
					<li>
				      <label for="name">Mot de passe<em>*</em> :</label>
				      <input type="text" id="pwd" name="textPwd" value="<?=$modifProf->pwd?>"/>
				    </li> 
					<li>
					  <label for="alias">Actif :</label>
					  <input type="radio" id="radio" name="radioActif" value="o" <?php if ($modifProf->actif=="o" || !$modifProf->actif) echo "checked='checked'";?>/> <span class="radio">oui</span>	<input type="radio" id="radio" name="radioActif" value="n" <?php if ($modifProf->actif=="n") echo "checked='checked'";?>/> <span class="radio">non</span>
					</li> 
                    <li>
					  <label for="checkAmont">Amont :</label>
					  <input type="checkbox" id="checkAmont" name="checkAmont" value="o" <?php if ($modifProf->amont=="o") echo "checked='checked'";?>/>
					</li> 
                    <li>
					  <label for="checkAval">Aval :</label>
					  <input type="checkbox" id="checkAval" name="checkAval" value="o" <?php if ($modifProf->aval=="o") echo "checked='checked'";?>/>
					</li>
					<li>
				      <label for="textAdr1">Adresse<em> </em>:</label>
				      <input type="text" id="textAdr1" name="textAdr1" value="<?=$modifProf->adr1?>"/>
				    </li>
					<li>
				      <label for="textAdr2"></label>
				      &nbsp;<input type="text" id="textAdr2" name="textAdr2" value="<?=$modifProf->adr2?>"/>
				    </li>
					<li>
				      <label for="textCp">Code postal :</label>
				      <input type="text" id="textCp" name="textCp" value="<?=$modifProf->cp?>"/>
				    </li>
					<li>
				      <label for="textVille">Ville :</label>
				      <input type="text" id="textVille" name="textVille" value="<?=$modifProf->ville?>"/>
				    </li>
					<li>
				      <label for="selectPays">Pays :</label>
				      <select name="selectPays">
					  <option>Choisir un pays...</option>	
						<?php
						$result = mysql_query("SELECT * FROM if_pays ORDER BY pays");
						while ($row=mysql_fetch_array($result)) {
						?>
							<option value="<?=$row['numpays']?>" 
							<?php if ($modifProf->pays==$row['numpays']) echo "selected='selected'";?>><?=utf8_encode($row['pays'])?></option>
						<?php
						}//fin du while
						?>
						</select>
				    </li>
					<li>
				      <label for="textTel">Tel :</label>
				      <input type="text" id="textTel" name="textTel" value="<?=$modifProf->tel?>"/>
				    </li>
					<li>
				      <label for="textFax">Fax :</label>
				      <input type="text" id="textFax" name="textFax" value="<?=$modifProf->fax?>"/>
				    </li>
				</ol>
				 <br />	
				  <input type="hidden" name="numclient" value="<?=$numclient?>" />
				 <input id="button" name="validerProf" type="button" value="Valider" onClick="javascript:valideProf()"/>  
		 	</fieldset>
   </div>
  </div>
  </div>
</div>
</div>
