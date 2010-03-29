<?php /* Date de cr�ation: 11/12/2008 */ 
$laPage = new Page(); 
if ($numpage) {
	$laPage->numpage=$numpage;
	$laPage->infosPage();
}

?>
<fieldset>
  <legend>Page</legend>
  <ol>
     <li>
      <label for="selectLg">langue :</label>
       <select id="selectLg" name="selectLg">
	  	  <option value="fr" <?php if ($laPage->lg=="fr") echo "selected='selected'";?>>fran&ccedil;ais</option>
		  <option value="en" <?php if ($laPage->lg=="en") echo "selected='selected'";?>>anglais</option>
	  </select>
    </li>
    <li>
      <label for="namePage">Nom de la page Google<em>*</em> :</label>
      <input id="namePage" name="textNomG" value="<?=$laPage->nomPageGoogle?>"/>
    </li>
    <li>
      <label for="titlePage">Titre de la page<em>*</em> :</label>
	  <textarea id="titlePage" name="textTitre"/><?=miseEnFormeTextarea($laPage->titrePage)?></textarea>
    </li>
    <li>
      <label for="desc">Description :</label>
      <input id="desc" name="textDescr" value="<?=$laPage->descrPage?>"/>
    </li>
    <li>
      <label for="keywords">Mots clefs :</label>
      <input id="keywords" name="textKeyw" value="<?=$laPage->keywPage?>"/>
    </li>
   <li>
      <label for="alias">Nom du fichier <em>*</em> :</label>
      <input id="alias" name="textAlias" value="<?=$laPage->aliasPage?>"/>
    </li>   
	<?php
	if ($uti->estAdmin()) {
	?>
		 <li>
	      <label for="estSpec">Cette page est sp&eacute;cifique (réservé webmaster expert) :</label>
	      <input type="text" id="estSpec" name="textFichier" value="<?=$laPage->nomFichier?>"/> .php
	    </li>	
		
	<?php
	}
	?>
	 <li> 
      <label for="radioAccueil">Cette page est de type "accueil" de rubrique :</label> 
      <input type="radio" id="radio" name="radioAccueil" value="o" <?php if ($laPage->accueilPage=="o") echo "checked='checked'";?> /> <span class="radio">oui</span> 	<input type="radio" id="radio" name="radioAccueil" value="n" <?php if ($laPage->accueilPage=="n") echo "checked='checked'";?> /> <span class="radio">non</span>
    </li> 
	<li>
      <label for="radioAccueil">Cette page est de type "accueil" de site :</label> 
      <input type="radio" name="radioAccueilSite" id="radio" value="o" <?php if ($laPage->accueilSite=="o") echo "checked='checked'";?> /> <span class="radio">oui</span> 	<input type="radio" id="radio" name="radioAccueilSite" value="n" <?php if ($laPage->accueilSite=="n") echo "checked='checked'";?> /> <span class="radio">non</span>
    </li> 
	<?php
	 $listrub=new ListeMenus();
	 $listrub->type="rubrique";
	 $listrub->nomkey="numrub";
	 $listrub->ordre_req="nom";//requête trié par ordre alaphabétique du menu
	 $nb_rub=$listrub->afficherListeMenus();

	 $listcateg=new ListeMenus();
	 $listcateg->type="categorie";
	 $listcateg->nomkey="numcateg";
	 $listcateg->ordre_req="nom";//requête trié par ordre alaphabétique du menu
	 $nb_categ=$listcateg->afficherListeMenus();

	 $listsscateg=new ListeMenus();
	 $listsscateg->type="sscateg";   
	 $listsscateg->nomkey="numsscateg";
	 $listsscateg->ordre_req="nom";//requête trié par ordre alaphabétique du menu
	 $nb_sscateg=$listsscateg->afficherListeMenus();

	 if ($nb_rub || $nb_categ || $nb_sscateg) {
	?>
		<li>
	      <label for="alias">Associer cette page &agrave; un ou plusieurs menus :</label>
		  <select name="selectMenu[]" multiple size="15">
		  	  <?php
			  if ($nb_rub) {
			  ?>
			  	<option>Les rubriques</option>
			  <?php 
			  	foreach ($listrub as $menus) {
			  ?>
				 <option value="<?=$menus->nummenu."-".$listrub->type?>"
				 <?php
				  if (is_array($laPage->list_numrub)) {
				  	for ($i=0;$i<count($laPage->list_numrub);$i++) {
				    	 if ($laPage->list_numrub[$i]==$menus->nummenu) echo "selected='selected'";
					} 
				 }
				 ?>
				 > &nbsp;&nbsp;&nbsp;<?=$menus->nomMenu?></option>
			  <?php	
			    }//fin du foreach
			  }//fin if ($nb_rub)

			  if ($nb_categ) {
			  ?>
			  	<option></option>
				<option>Les cat&eacute;gories</option>
			  <?php 
			  	foreach ($listcateg as $menus) {
			  ?>
				 <option value="<?=$menus->nummenu."-".$listcateg->type?>"
				 <?php
				  if (is_array($laPage->list_numcateg)) {
				  	for ($i=0;$i<count($laPage->list_numcateg);$i++) {
				    	 if ($laPage->list_numcateg[$i]==$menus->nummenu) echo "selected='selected'";
					} 
				 }
				 ?>
				 > &nbsp;&nbsp;&nbsp;<?=$menus->nomMenu?></option>
			  <?php	
			    }//fin du foreach
			  }//fin if ($nb_rub)
			  
			   if ($nb_sscateg) {
			  ?>
			  	<option></option>
				<option>Les sous-cat&eacute;gories</option>
			  <?php 
			  	foreach ($listsscateg as $menus) {
			  ?>
				 <option value="<?=$menus->nummenu."-".$listsscateg->type?>"
				  <?php
				  if (is_array($laPage->list_numsscateg)) {
				  	for ($i=0;$i<count($laPage->list_numsscateg);$i++) {
				    	 if ($laPage->list_numsscateg[$i]==$menus->nummenu) echo "selected='selected'";
					} 
				 }
				 ?> 
				 > &nbsp;&nbsp;&nbsp;<?=$menus->nomMenu?></option>
			  <?php	
			    }//fin du foreach
			  }//fin if ($nb_rub)
			  ?>
		  </select>
	    </li> 
	<?php
	}//fin if ($nb_rub || $nb_categ || $nb_sscateg)

	if ($uti->estAdmin()){
	?> 
		<li>
	      <label for="alias">Cette page est publi&eacute;e : </label>
	      <input type="radio" id="radio" name="radioPubliee" value="o" <?php if ($laPage->publiePage=="o") echo "checked='checked'";?> /> <span class="radio">oui</span> 	<input type="radio" id="radio" name="radioPubliee" value="n" <?php if ($laPage->publiePage=="n") echo "checked='checked'";?>/> <span class="radio">non</span>
	    </li>
	<?php
	}

	if ($laPage->nomPhoto) {
	?>	
	  <li id="li_photo_page">
      <label for="title">La photo :</label> 
	  <?=$laPage->nomPhoto?>&nbsp;<a href="javascript:conf_supAssoc('pop_sup.php?index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numpage=<?=$laPage->numpage?>&div=li_photo_page','la photo')">supprimer la photo</a><br />
  	  </li>	
	<?php		  
	}//fin if ($laPage->nomPhoto)  

    $listphotos=new ListePhotos(); 	   
	$b=$listphotos->afficherListePhotos();
	if ($b) { 
	  ?> 
	  <li>
		  <label for="fphot">Associer la photo existante :</label>
		  <select name="selectPhoto">	
			  <option></option>
			  <?php
				foreach ($listphotos as $photos) {
			  ?>
			  	   <option value="<?=$photos->numphoto?>"><?=$photos->nomPhoto?></option>
			  <?php
			  }
		  ?> 
		  </select>	
	</li>
	  <?php
	  }//fin if ($b)
	  ?>
	  <li>
		  <label for="fphotomodif"><?php if ($b) echo " ou "; echo "Ajouter une photo : ";?></label>
		     &nbsp;<input type="file" name="fileModifPhoto"  />	
	  </li>  
	  <li>
		  <label for="fnotice">&nbsp;</label>
		  <p class="liens">970 x 180 pixels - merci de nommer votre photo <br />bandeau-....jpg pour faciliter l'utilisation du cms.</p>
	  </li>  
  </ol>
 <br /><br />

<input type="hidden" name="action" value="modifier_page" />
<input id="button" name="ModifierPage" type="button" value="Valider" onClick="javascript:document.forms[0].submit()"/>
</fieldset>

