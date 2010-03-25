<?php
$pageAccueil = new Page();
$pageAccueil->lg=$lg;
$pageAccueil->infosPage();
 //if ($numpage && $accueil) echo $accueilPage->nomPhoto; else if ($numpage) echo $titrePage->nomPhoto; else echo "logo.gif";
?>
<div id="fond">

<div id="grey"></div>

<div id="logo"><a href="<?php if ($id) echo "index.php?id=$id&cnx=$cnx&pg_admin=content&numpage=$pageAccueil->numpage&numrub=$menus->nummenu&onglet=voir&page_accueil=o&lg=$pageAccueil->lg"; else if ($pageAccueil->aliasPage) echo $pageAccueil->aliasPage; else echo $if_site["url"];?>"><img src="../images/logo.gif" width="119" height="58" hspace="15" align="left"></a>

	</div><div id="menu"> 

 	 	<!-- menu principal deplace dans une div absolue -->		

		</div>
		<div id="menu2">
			<table>
			<tr>
			<td class="sansmarge">
			<input type="text" name="rech_site"  id="rech_site" onfocus="this.value=''" value="rechercher"/>
			</td>
			<td><a href="javascript:document.forms[0].moteur_rech.value=1;document.forms[0].submit()" class="white"><img src="../images/fleche-rechercher.gif" alt="" width="18" height="17" border="0"/></a>
			</td>
			</tr>
			</table> 
		<ul id="MenuBarTopRight" class="MenuBarHorizontal2">
		
		<?php
			$listrub=new ListeMenus(); 	  
			$listrub->type="rubrique";
			$listrub->nomkey="numrub";
			$listrub->zone="1";
			$listrub->lg=$lg;
			$listrub->afficherListeMenus();	
			$cpt=0;  
			foreach ($listrub as $menus) {
		?>
		
		
			<li class="barre"><a href="<?php if ($id) echo "index.php?id=$id&cnx=$cnx&pg_admin=content&numpage=$menus->numpage&numrub=$menus->nummenu&onglet=voir&page_accueil=$menus->accueilPage&lg=$menus->lgPage"; else echo $menus->url;?>" class="white"><?=$menus->nomMenu?><?php echo "&nbsp;|&nbsp;";?></a></li> 
		
		<?php
			} //fin du foreach
		?>
		<!--<li class="barre"><a href="#" class="white">Plan du site&nbsp;|&nbsp;</a></li> 
		
		<li class="barre"><a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&lg=fr" class="white">FR&nbsp;|&nbsp;</a></li> 

		<li><a href="index.php?id=<?=$id?>&cnx=<?=$cnx?>&lg=en" class="white">EN</a></li> -->

		</ul></div>

 <img src="<?php if ($numpage && $titrePage->nomPhoto) echo "../photos/".$titrePage->nomPhoto; else echo "../photos/bandeau-filiere.jpg";?>" width="970" height="180" />

</div>

