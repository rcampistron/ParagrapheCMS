<?php /* Date de création: 30/02/2009 */
if ($numarticle) {//on est en modification
   $modifArti = new Article();
   $modifArti->numarticle=$numarticle;
   $modifArti->infosArti();
}
?>

<div class="item" id="coltexteAdmin">
	<div class="sap-content">
		<div class="TabbedPanels">
 			 <div class="TabbedPanelsContentGroup">
  				  <div class="TabbedPanelsContent"> 
			<fieldset>
			<legend><?php if ($numarticle) echo "Modifier l'article"; else echo "Ajouter un article";?></legend>
			<ol>
				    <li>
				      <label for="name">Libelle<em>*</em> :</label>
				      <input type="text" id="name" name="textLibelle" value="<?=$modifArti->libelle?>"/>
				    </li>
				    <li>
				  <input type="hidden" name="numarticle" value="<?=$numarticle?>" />
				  </li>
				  <li>
				 <input id="button" name="validerArti" type="button" value="Valider" onClick="javascript:valideArti()"/>
				 </li> 
			</ol> 
   		</fieldset>
		</div>
	</div>  
</div>
</div>  
</div>

