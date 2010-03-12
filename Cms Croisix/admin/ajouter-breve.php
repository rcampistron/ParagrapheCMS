<?php /* Date de cration: 18/12/2008 */
if ($numpara) {//on est en modification
   $modifBreve = new Breve();
   $modifBreve->numpara=$numpara;
   $modifBreve->infosBreve();
}
?>

<div class="item" id="coltexteAdmin">
	<div class="sap-content">
		<div class="TabbedPanels">
 			 <div class="TabbedPanelsContentGroup">
  				  <div class="TabbedPanelsContent"> 
			<fieldset>
			<legend><?php if ($numpara) echo "Modifier la brève internationale"; else echo "Ajouter une brève internationale";?></legend>
				    <li>
				      <label for="name">Titre<em>*</em> :</label>
				      <input type="text" id="name" name="textTitre" value="<?=$modifBreve->titrePara?>"/>
				    </li>
				    <li>
				      <label for="name">Contenu :</label>
				      <textarea name="textCont"><?=miseEnFormeTextarea($modifBreve->contenuPara)?></textarea>
				    </li>
					<li>
				      <label for="name">Source :</label>
				      <input type="text" id="name" name="textSource" value="<?=$modifBreve->source?>"/>
				    </li>
					<li>
				      <label for="name">Date de la brève (format jj/mm/aaaa) :</label>
				      <input type="text" id="name" name="textDate" value="<?=$modifBreve->date_breve?>"/>
				    </li>	
					<li>
				      <label for="name">Pays :</label>
				      <select name="selectPays" class="public" >
					  	<option>Sélectionner un pays</option>	
						<?php
						$result = mysql_query("SELECT * FROM if_pays ORDER BY pays");
						while ($row=mysql_fetch_array($result)) {
						?>
							<option value="<?=$row['numpays']?>" <?php if ($modifBreve->numpays==$row['numpays']) echo "selected='selected'";?>><?=utf8_encode($row['pays'])?></option>
						<?php
						}//fin du while
						?>
						</select>
				    </li>	
					
					
				 <br />	
				  <input type="hidden" name="numpara" value="<?=$numpara?>" />
				 <input id="button" name="validerBreve" type="button" value="Valider" onClick="javascript:valideBreve()"/>  
   		</fieldset>
		</div>
	</div>  
</div>
</div>  
</div>

