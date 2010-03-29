<?php /* Date de cr�ation: 18/12/2008 */
if ($numuti) {//on est en modification
   $modifUti = New Utilisateur();
   $modifUti->numuti=$numuti;
   $modifUti->infosUti();
}
?>
<div class="item" id="coltexteAdmin">
	<div class="sap-content">
		<div class="TabbedPanels">
		  <div class="TabbedPanelsContentGroup">
		    <div class="TabbedPanelsContent"> 
			<fieldset>	
			<legend><?php if ($numuti) echo "Modifier l'utilisateur"; else echo "Ajouter un utilisateur";?></legend>
		 		 <ol>
				    <li>
				      <label for="name">Nom :</label>
				      <input type="text" id="name" name="textNom" value="<?=$modifUti->nom?>"/>
				    </li>
				    <li>
				      <label for="prenom">P&eacute;nom :</label>
				      <input type="text" id="prenom" name="textPrenom" value="<?=$modifUti->prenom?>"/>
				    </li>
					<li>
				      <label for="identifiant">Identifiant (adresse e-mail)<em>*</em> :</label>
				      <input type="text" id="identifiant" name="textLogin" value="<?=$modifUti->login?>"/>
				    </li>	
					<li>
				      <label for="motDePasse">Mot de passe<em>*</em> :</label>
				      <input type="text" id="motDePasse" name="textPwd" value="<?=$modifUti->pwd?>"/>
				    </li> 
					<li>
				      <label for="estAdmin">Administrateur :</label>
				      <input type="radio"  id="estAdmin" name="radioAdmin" value="o" <?php if ($modifUti->admin=="o" || !$modifUti->admin) echo "checked='checked'";?> /> <span class="radio">oui</span> 	<input type="radio" id="radio" name="radioAdmin" value="n" <?php if ($modifUti->admin=="n") echo "checked='checked'";?> /> <span class="radio">non</span>
				    </li>	
					<li>
				      <label for="estActif">Actif :</label>
				      <input type="radio" id="estActif" name="radioActif" value="o" <?php if ($modifUti->actif=="o" || !$modifUti->actif) echo "checked='checked'";?> /> <span class="radio">oui</span> 	<input type="radio" id="radio" name="radioActif" value="n" <?php if ($modifUti->actif=="n") echo "checked='checked'";?> /> <span class="radio">non</span>
				    </li>	
				</ol>
				 <br />	
				  <input type="hidden" name="numuti" value="<?=$numuti?>" />
				 <input id="button" name="validerUti" type="button" value="Valider" onClick="javascript:valideUti()"/>  
		 	</fieldset>
   </div>
  </div>
  </div>
</div>
</div>
