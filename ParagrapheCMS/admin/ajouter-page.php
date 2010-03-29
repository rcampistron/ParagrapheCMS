<?php /* Date de cr�ation: 08/12/2008 */ ?>

<div class="item" id="coltexteAdmin">
	<div class="sap-content">
<div class="TabbedPanels">
  <div class="TabbedPanelsContentGroup">
    <div class="TabbedPanelsContent"> 
	<fieldset>
  <legend>Nouvelle Page</legend>
  <ol>
    <li>
      <label for="lang">Langue :</label>
       <select id="lang" name="selectLg">
	  	  <option value="fr">fran&ccedil;ais</option>
		  <option value="en">anglais</option>
	  </select>
    </li>
	<li>
      <label for="name">Nom de la page Google<em>*</em> :</label>
      <input id="name" name="textNomG"/>
    </li>
    <li>
      <label for="title">Titre de la page<em>*</em> :</label>
      <textarea id="title" name="textTitre"/></textarea>
    </li>
    <li>
      <label for="desc">Description :</label>
      <input id="desc" name="textDescr"/>
    </li>
    <li>
      <label for="keywords">Mots clefs :</label>
      <input id="keywords" name="textKeyw"/>
    </li>
    <li>
      <label for="alias">Nom du fichier<em>*</em> :</label>
      <input id="alias" name="textAlias"/> .html    </li> 
	<?php
	if ($uti->estAdmin()) {
	?>
		 <li>
	      <label for="name">Cette page est sp&eacute;cifique (réservé webmaster expert) :</label>
	      <input type="text" id="name" name="textFichier"/> .php	    </li>	
		
	<?php
	}
	?>
	<li>
      <label for="alias">Cette page est de type "accueil" de rubrique :</label>
      <input type="radio" id="radio" name="radioAccueil" value="o" /> <span class="radio">oui</span>	<input type="radio" id="radio" name="radioAccueil" value="n" checked="checked" /> <span class="radio">non</span>    </li> 
	<li>
      <label for="alias">Cette page est de type "accueil" de site :</label>
      <input type="radio" id="radio" name="radioAccueilSite" value="o" /> <span class="radio">oui</span> 	<input type="radio" id="radio" name="radioAccueilSite" value="n"  checked="checked" /> <span class="radio">non</span>    </li>
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
		  <select name="selectMenu[]" size="15" multiple>
		  	  <?php
			  if ($nb_rub) {
			  ?>
			  	<option>Les rubriques</option>
			  <?php 
			  	foreach ($listrub as $menus) {
			  ?>
				 <option value="<?=$menus->nummenu."-".$listrub->type?>"> &nbsp;&nbsp;&nbsp;<?=$menus->nomMenu?></option>
			  <?php	
			    }//fin du foreach
			  }//fin if ($nb_rub)

			  if ($nb_categ) {
			  ?>
			  	<option></option>
				<option>Les catégories</option>
			  <?php 
			  	foreach ($listcateg as $menus) {
			  ?>
				 <option value="<?=$menus->nummenu."-".$listcateg->type?>"> &nbsp;&nbsp;&nbsp;<?=$menus->nomMenu?></option>
			  <?php	
			    }//fin du foreach
			  }//fin if ($nb_rub)

			   if ($nb_sscateg) {
			  ?>
			  	<option></option>
				<option>Les sous-catgories</option>
			  <?php 
			  	foreach ($listsscateg as $menus) {
			  ?>
				 <option value="<?=$menus->nummenu."-".$listsscateg->type?>"> &nbsp;&nbsp;&nbsp;<?=$menus->nomMenu?></option>
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
	      <label for="alias">Cette page est publi&eacute;e :</label>
	      <input type="radio" id="radio" name="radioPubliee" value="o" checked="checked" /> <span class="radio">oui</span> 	<input type="radio" id="radio" name="radioPubliee" value="n" /> <span class="radio">non</span>	    </li>
	<?php
	}
	
    $listphotos=new ListePhotos(); 	   
	$b=$listphotos->afficherListePhotos();
	if ($b) { 
	?>
		<li>
		  <label for="fphot">Associer la photo existante:</label>
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
		  <?php
		  }//fin if ($b)
		  ?>
		  </li>	
		  <li>
			  <label for="fphoto"><?php if ($b) echo "ou ajouter une ";?>	photo :</label>
			     <input type="file" name="filePhoto"  />	
		  </li>    
	  </ol>
<br />	
<input id="button" name="validerPage" type="button" value="Valider" onClick="javascript:ajoutePage()"/>	
</fieldset>
</div>
</div>
</div>
</div>
</div>
