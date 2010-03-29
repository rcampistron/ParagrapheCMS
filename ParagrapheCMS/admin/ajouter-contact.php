<?php /* Date de cration: 18/12/2008 */
if ($numcont) {//on est en modification
   $modifCont = new Contact();
   $modifCont->numcontact=$numcont;
   $modifCont->infosContact();
}
?> 
<div class="item" id="coltexteAdmin">
	<div class="sap-content">
		<div class="TabbedPanels">
		  <div class="TabbedPanelsContentGroup">
		    <div class="TabbedPanelsContent"> 
			<fieldset>	
			<legend><?php if ($numcont) echo "Modifier le contact"; else echo "Ajouter un contact";?></legend>
		 		 <ol>
				    <li>
				      <label for="nomContact">Nom<em>*</em> :</label>
				      <input type="text" id="nomContact" name="textNom" value="<?=$modifCont->nom?>"/>
				    </li>
				    <li>
				      <label for="prenom">P&eacute;nom :</label>
				      <input type="text" id="prenom" name="textPrenom" value="<?=$modifCont->prenom?>"/>
				    </li>
					<li>
				      <label for="genre">Genre :</label>
				      <select name="selectGenre" id="genre">
					  	  <option value="Mme" <?php if ($modifCont->genre=="Mme") echo "selected='selected'";?>>Madame</option>
						  <option value="Mlle" <?php if ($modifCont->genre=="Mlle") echo "selected='selected'";?>>Mademoiselle</option>
						  <option value="Mr" <?php if ($modifCont->genre=="Mr") echo "selected='selected'";?>>Monsieur</option>
					  </select>
				    </li>
					<li>
				      <label for="fonction">Fonction :</label>
					  <textarea id="fonction" name="textFonction"><?=miseEnFormeTextarea($modifCont->fonction)?></textarea>
				    </li>
					<li>
				      <label for="email">Email :</label>
				      <input type="text" id="email" name="textEmail" value="<?=$modifCont->email?>"/>
				    </li>	
					<li>
				      <label for="telephone">T&eacute;l&eacute;phone :</label>
				      <input type="text" id="telephone" name="textTel" value="<?=$modifCont->tel?>"/>
				    </li> 
					<li>
				      <label for="portable">Portable :</label>
				      <input type="text" id="portable" name="textGsm" value="<?=$modifCont->gsm?>"/>
				    </li>	
					<li>
				      <label for="fax">Fax :</label>
				      <input type="text" id="fax" name="textFax" value="<?=$modifCont->fax?>"/>
				    </li>	
					<li>
				      <label>Contact référent :</label>
      <input type="radio" id="radio" name="radioRefe" value="o" <?php if ($modifCont->referent=="o") echo  "checked='checked'";?>/> <span class="radio">oui</span>	<input type="radio" id="radio" name="radioRefe" value="n"  <?php if ($modifCont->referent=="n" || !$modifCont) echo  "checked='checked'";?>/> <span class="radio">non</span>
				    </li>	
					<?php
					 $list_categ=new ListeMenus();
					 $list_categ->type="categorie";
					 $list_categ->nomkey="numcateg";
					 $list_categ->ordre_req="nom";//requête trié par ordre alaphabétique du menu
					 $nb_categ=$list_categ->afficherListeMenus();
					 
					 $list_sscateg=new ListeMenus();
					 $list_sscateg->type="sscateg";   
					 $list_sscateg->nomkey="numsscateg";
					 $list_sscateg->ordre_req="nom";//requête trié par ordre alaphabétique du menu
					 $nb_sscateg=$list_sscateg->afficherListeMenus();
					 
					 if ($nb_categ) { 
					 	 if ($numcont) $modifCont->afficherCateg();
					?>
					 <li>
					      <label for="alias">Associer ce contact &agrave; une ou plusieurs cat&eacute;gories :</label>
						  <select name="selectCateg[]" size="15" multiple>					   
						  <?php
						  foreach ($list_categ as $menus) {
						  ?>
						  	 <option value="<?=$menus->nummenu?>"
							 <?php
							 for ($i=0;$i<count($modifCont->listcateg);$i++) {	
							   	   $laCateg=$modifCont->listcateg[$i];	  
								   if ($laCateg->nummenu==$menus->nummenu) echo " selected='selected'";
							   } 
							 ?>
							 ><?=$menus->nomMenu?></option>
						  <?php
						  }	//fin du foreach
						  ?>
				  	   </select>
					</li>
					<?php 
					} 
					
					if ($nb_sscateg) {
						if ($numcont) $modifCont->afficherSscateg();
					?>
					   <li>
					      <label for="alias">Associer ce contact &agrave; une ou plusieurs sous-cat&eacute;gories :</label>
						  <select name="selectSscateg[]" size="15" multiple>
						  <?php
						  foreach ($list_sscateg as $menus) {
						  ?>
						  	 <option value="<?=$menus->nummenu?>"
							  <?php
							 for ($i=0;$i<count($modifCont->listsscateg);$i++) {	
							   	   $laSscateg=$modifCont->listsscateg[$i];	
								   //echo $laSscateg->nummenu."<br>";  
								   if ($laSscateg->nummenu==$menus->nummenu) echo " selected='selected'";
							   } 
							 ?>
							 ><?=$menus->nomMenu?></option>
						  <?php
						  }	//fin du foreach
						  ?>
				  	     </select>
					</li>
					<?php
					}
					?>
				</ol>
				 <br />	
				  <input type="hidden" name="numcontact" value="<?=$numcont?>" />
				 <input id="button" name="validerCont" type="button" value="Valider" onClick="javascript:valideCont()"/>  
		 	</fieldset>
   </div>
  </div>
  </div>
</div>
</div>
