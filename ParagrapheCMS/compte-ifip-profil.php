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
  if ($_SESSION['numclient'])  {
  	$client=new Client();
	$client->numclient=$_SESSION['numclient'];
	$client->infosClient();
	
  	if ($action=="modifierCompte") {
	?>
			<strong>Merci, votre profil a été mis à jour.</strong>
			<br /><br /><br /><br />
		
	<?php
	}
	?>
	  <fieldset>
	   
		<br />
		<br />
		
		<label for="name"></label>
		   <strong>Vos informations personnelles :</strong>
		<br />
		
		
		<label for="name">Civilité :</label>
		  <select name="selectCiv " class="public">
			<option>-</option>
			<option value="Mr" <?php if ($client->civilite=="Mr") echo "selected='selected'";?>>Mr</option>
			<option value="Mme" <?php if ($client->civilite=="Mme") echo "selected='selected'";?>>Mme</option>
			<option value="Mlle" <?php if ($client->civilite=="Mlle") echo "selected='selected'";?>>Mlle</option>
		</select>
		<br />
		
		<label for="textPrenom">Prénom<em class="important">*</em> :</label>
      <input type="text" id="textPrenom" name="textPrenom" class="public" value="<?=$client->prenom?>" />
    <br />
	
	
      <label for="textNom">Nom<em class="important">*</em> :</label>
      <input type="text" id="textNom" name="textNom" class="public"value="<?=$client->nom?>" />
    <br />
	
	
      <label for="textEmail">Email <em class="important">*</em> :</label>
      <input type="text" id="textEmail" name="textEmail" class="public" value="<?=$client->email?>" />
	<br />
	
	
	  <label for="textSociete">Société / organisation<em class="important">*</em> :</label>
      <input type="text" id="textSociete" name="textSociete" class="public" value="<?=$client->raison?>" />
	<br />
	
	
	  <label for="textSociete">Fonction :</label>
      <input type="text" id="textFonction" name="textFonction" class="public" value="<?=$client->fonction?>" />
	<br />
	
	 
	 <label for="textAdr1">Adresse<em class="important">*</em> : </label>
	  &nbsp;<input type="text" name="textAdr1" id="textAdr1" class="public" value="<?=$client->adr1?>" />
	<br />
	
	
	  <label for="textAdr2">&nbsp;</label>
	  <input type="text" name="textAdr2" id="textAdr2" class="public" value="<?=$client->adr2?>"  />
	<br />
	
	
	  <label for="textCp">Code Postal<em class="important">*</em> : </label>
	  &nbsp;<input type="textCp" id="textCp" name="textCp" class="public" value="<?=$client->cp?>"  />
	 <br />
	 
	 
	   <label for="textVille">Ville<em class="important">*</em> : </label>
	   &nbsp;<input type="text" name="textVille" id="textVille" class="public" value="<?=$client->ville?>"  />
	 <br />
	 
	 
	   <label for="selectPays">Pays<em class="important">*</em> : </label>
	  &nbsp;<select name="selectPays" class="public">
	  <option>Choisir...</option>
		<?php
		$result = mysql_query("SELECT * FROM if_pays ORDER BY pays");
		while ($row=mysql_fetch_array($result)) {
		?>
			<option value="<?=$row['numpays']?>" <?php if ($client->numpays==$row['numpays'] || $row['numpays']=="247") echo "selected='selected'";?>>
			<?=utf8_encode($row['pays'])?></option>
		<?php
		}//fin du while
		?>
	</select>
	<br />
	
	
	<label for="textTel">Téléphone<em class="important">*</em> : </label>
	&nbsp;<input name="textTel" type="text" class="public" id="textTel" maxlength="25" value="<?=$client->tel?>" />
	<br />
	
	
	<label for="textFax">Fax : </label>
	&nbsp;<input name="textFax" type="text" class="public" id="textFax" maxlength="25" value="<?=$client->fax?>" />
	<br />
	
	
		<label for="name"></label>
		<input id="validerInscr" name="validerInscr" type="button"  class="bouton" value="Valider" onClick="javascript:validerInscrForma('modifierCompte')"/> 
	
		</fieldset>
	<?php
	} 
	?>
		
	<input type="hidden" name="numpara" value="<?=$numpara?>"/>
<input type="text" name="action" value="<?=$action?>" />

				<p>&nbsp;</p>
				<p>&nbsp;</p>
				
  </div>
</div>
<?php
}//fin if ($laPage->nomPageGoogle)
?>
