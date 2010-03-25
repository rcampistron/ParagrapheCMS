<div class="sap-content">

	  
 	    <?php
 	    /**
 	     * @file menu.php 
 	     * @brief G&eacute;n&egrave;re les menus
 	     * @details Inclu dans /ref index.php.
 	     * @todo compléter la description
 	     */	
		if ($numrub) {
			$listcateg=new ListeMenus(); 	  
			$listcateg->type="categorie";
			$listcateg->nomkey="numcateg";
			$listcateg->zone="3";
			$listcateg->numfkey=$numrub; 
			$listcateg->lg=$lg;  
			$listcateg->afficherListeMenus();	  
			foreach ($listcateg as $menus) {
				$numcat=$menus->nummenu;
		?>
			  <div class="<?php if ($numcat==$numcateg) echo "MenuLon"; else echo "MenuL";?>">
			  <a href="<?php if ($id) echo "index.php?id=$id&cnx=$cnx&pg_admin=content&numpage=$menus->numpage&numrub=$numrub&numcateg=$numcat&onglet=voir";
			   else 
			   echo $menus->url;?>">
			  <?=$menus->nomMenu?></a></div>
				<!-- Les sous-categories liees aux categories -->
				<?php
				if ($numcateg==$numcat) {
					$listsscateg=new ListeMenus(); 	  
					$listsscateg->type="sscateg";
					$listsscateg->nomkey="numsscateg";
					$listsscateg->numfkey=$numcateg;	 
					$listsscateg->affiche="o";
					$listsscateg->lg=$lg;  
					$listsscateg->afficherListeMenus();	
					foreach ($listsscateg as $menus) { 
				?>	 
				<div class="<?php if ($numsscateg==$menus->nummenu) echo "ssMenuLon"; else echo "ssMenuL";?>"><a href="<?php if ($id) echo "index.php?id=$id&cnx=$cnx&pg_admin=content&numpage=$menus->numpage&numrub=$numrub&numcateg=$numcateg&numsscateg=$menus->nummenu&onglet=voir"; else echo $menus->url;?>"><?=$menus->nomMenu?></a></div>
			
				<?php 
					} //fin du foreach ($listsscateg as $menus)
				}//fin de  if ($numcateg) 
			} //fin du foreach ($listcateg as $menus)
			
		}//fin if ($numrub)
		?>


 <? if ($id)  { ?>

 <br />



 <hr />

 <ul id="MenuBarAdmin" class="MenuBarVertical">

 <li>&nbsp;&nbsp;<strong>Administrer le site</strong></li>

  <li><a href="index.php?pg_admin=lister-uti&id=<?=$id?>&cnx=<?=$cnx?>">Gérer les utilisateurs</a></li>

  <li><a href="index.php?pg_admin=lister-page&id=<?=$id?>&cnx=<?=$cnx?>&publi=1">Gérer la publication</a></li>

  <li><a href="index.php?pg_admin=admin-site&id=<?=$id?>&cnx=<?=$cnx?>">Décrire le  site (url...) </a></li>

  <li>&nbsp;</li>
  <li>&nbsp;&nbsp;<strong>G&eacute;rer les contenus</strong></li>
  <li><a href="index.php?pg_admin=lister-menu&amp;id=<?=$id?>&amp;cnx=<?=$cnx?>">Les menus</a></li>
  <li><a href="index.php?pg_admin=lister-page&id=<?=$id?>&cnx=<?=$cnx?>">Les pages</a></li>  
  <li><a href="index.php?pg_admin=lister-contact&id=<?=$id?>&cnx=<?=$cnx?>">Les contacts</a></li>
  <li><a href="index.php?pg_admin=lister-formation&id=<?=$id?>&cnx=<?=$cnx?>">Les formations</a></li>
  <li><a href="index.php?pg_admin=lister-doc&id=<?=$id?>&cnx=<?=$cnx?>">Les documentations</a></li>
  <li><a href="index.php?pg_admin=lister-actu&id=<?=$id?>&cnx=<?=$cnx?>">Les actualités</a></li>
  <li><a href="index.php?pg_admin=lister-breve&id=<?=$id?>&cnx=<?=$cnx?>">Les brèves internationales</a></li>
  
  <li>&nbsp;</li>
  <li>&nbsp;&nbsp;<strong>G&eacute;rer les accès réservés</strong></li>
  <li><a href="index.php?pg_admin=lister-prof&id=<?=$id?>&cnx=<?=$cnx?>">Les professionnels</a></li>
  
  <li>&nbsp;</li>
  <li>&nbsp;&nbsp;<strong>G&eacute;rer la boutique</strong></li>
  <li><a href="index.php?pg_admin=lister-client&amp;id=<?=$id?>&amp;cnx=<?=$cnx?>">Les clients</a></li>
  <li><a href="index.php?pg_admin=lister-com&id=<?=$id?>&cnx=<?=$cnx?>">Les commandes</a></li>  
  <li><a href="index.php?pg_admin=lister-inscri&id=<?=$id?>&cnx=<?=$cnx?>">Les inscriptions</a></li>
  <li><a href="index.php?pg_admin=lister-arti&id=<?=$id?>&cnx=<?=$cnx?>">Les articles</a></li>
  
  <li>&nbsp;</li>
  <li>&nbsp;&nbsp;<strong>Deconnexion</strong></li>
  <li><a href="/index.php?id=<?=$id?>&cnx=<?=$cnx?>&decon=1">Quitter mode admin</a></li>
 </ul>

 

 <? } ?>

</div>

