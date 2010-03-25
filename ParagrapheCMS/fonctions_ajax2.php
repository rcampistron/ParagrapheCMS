<?
session_start();
include ("connexion.php");
include ("fonctions.php");
include ("includes/classes.php");
setlocale(LC_CTYPE, 'C');
mb_internal_encoding("UTF-8");
header('Content-Type: text/html; charset=utf-8');
/* ------------------ SUGGESTION - liste de mots cles -------------------------------------------------- */
if ($textRech) { 
 //echo utf8_encode($textRech);
?>
	
		Sélectionnez un mot-clé dans la liste ci-dessous<br /><br />	
<?php		
 //if (strlen($textRech)>1) {//si au moins une lettre de saisie
	$textRechSansAccent=$textRech;
	$textRech=utf8_encode($textRech);
	$longeur_mot=strlen($textRech);
	//echo "textRech = ".$textRech."<br />";
	//echo "longueur mot = ".$longeur_mot."<br />";
	//echo "---------------------------------<br />";
	/*if($_SESSION["numprof"]) {
		$clients=new Client();
		$clients->numclient=$_SESSION['numprof'];
		$clients->infosClient();
		$domaines->amont=$clients->amont; 
		$domaines->aval=$clients->aval;
		$categ="SELECT numcateg FROM if_categorie WHERE aval='o' AND amont=''";
		$querycateg=mysql_query($categ);
		while($numcateg=mysql_fetch_row($querycateg)) {	
			//$numcategok[]=$numcateg[0];	
			$para="SELECT numpara FROM if_para_categ WHERE numcateg=$numcateg[0]";
			$querypara=mysql_query($para);
			while($numpara=mysql_fetch_row($querypara)) {
				$numparaok[]=$numpara[0];
			}
		}
	}*/
	//print_r($numcategok);
	
	$query="SELECT keyw FROM if_v_doc WHERE 1";
	if (!$id) $query.=" AND publiee='o'";
	if ($spec=="extranet-pro") $query.=" AND acces_res='o'";
	
	$query=mysql_query($query);
			
	if($query) {
	  //fabrication du tableau des mots-cles
	  $tab_keyw=array();
	  while($result=mysql_fetch_object($query)) {
	  	
	  	if ($result->keyw) { // il y a des mots clés
		
			$list=explode(";",$result->keyw);
			//echo $list[1];				
			//echo $result->keyw."<br />";
			for ($i=0;$i<count($list);$i++) {
				$list[$i]=trim(strtolower($list[$i]));// on passe en minuscules	
				//echo $list[1];			
				//echo $list[$i]."<br />";
				//echo "substring = ".substr($list[$i],0,$longeur_mot)."<br />-------------<br />";
				
				$extrait_present=strpos(substr($list[$i],0,$longeur_mot),strtolower($textRech));
				if ($extrait_present!==false) {
					if (!in_array($list[$i],$tab_keyw)) {
						$tab_keyw[]=$list[$i];						
					}//fin if (!in_array($list[$i],$tab_keyw))
				} //fin de : si il y a le mot tapé dans la liste des mots clés
			} // fin for = lecture du tableau des keyw
		}//fin if ($result->keyw)
	  }// fin while
	  
	  //affichage du tableau fabriqué des mots-clés
	  //reset($tab_keyw);
	  //print_r($tab_keyw);
	  reset($tab_keyw);
	  sort($tab_keyw);
	  reset($tab_keyw);
	  for ($i=0;$i<count($tab_keyw);$i++) {
	  	//echo'<p>';
		if ($id) {
?>
			<a href="javascript:window.location='index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&amp;lg=<?=$lg?>&rech=<?=addslashes($tab_keyw[$i])?>'"><?=$tab_keyw[$i]?></a><br />
	<?php 
		} else {
	?>
			<a href="javascript:window.location='index.php?numpage=<?=$numpage?>&amp;spec=<?=$spec?>&amp;numrub=<?=$numrub?>&amp;numcateg=<?=$numcateg?>&amp;numsscateg=<?=$numsscateg?>&amp;lg=<?=$lg?>&rech=<?=addslashes($tab_keyw[$i])?>'"><?=$tab_keyw[$i]?></a><br />

<?php
							
		}//fin else if ($id)
	  } //fin for ($i=0;$i<count($tab_keyw);$i++)
	} else { // fin if($query)
		echo 'ERREUR : un problème est survenu lors de la soumission de la requete';
	}
  
 //}//fin if(strlen($textRech)>0)
	

/* ------------------ SUGGESTION - par auteur -------------------------------------------------- */
} else if ($textRechAut) { 
?>
		Sélectionnez un auteur dans la liste ci-dessous<br /><br />	
<?php		
 if(strlen($textRechAut)>0) {
	$textRechAut=utf8_encode($textRechAut);
	$longeur_mot=strlen($textRechAut);
	//echo "textRechAut = ".$textRechAut."<br />";
	//echo "longueur mot = ".$longeur_mot."<br />";
	//echo "---------------------------------<br />";
	$query="SELECT auteur FROM if_v_doc WHERE 1";
	if (!$id) $query.=" AND publiee='o'";
	if ($spec=="extranet-pro") $query.=" AND acces_res='o'";
	$query=mysql_query($query);
			
	if($query) {
	  //fabrication du tableau des mots-cles
	  $tab_auteurs=array();
	  while($result=mysql_fetch_object($query)) {
	  	if ($result->auteur) { // il y a des auteurs
			if (preg_match("/\//",$result->auteur)) $list=explode("/",$result->auteur);
			else $list=explode(";",$result->auteur);
			//echo $result->auteur."<br />";
			for ($i=0;$i<count($list);$i++) {
				$list[$i]=trim(strtolower($list[$i]));// on passe en minuscules
				//echo $list[$i]."<br />";
				//echo "substring = ".substr($list[$i],0,$longeur_mot)."<br />-------------<br />";
				$extrait_present=strpos(substr($list[$i],0,$longeur_mot),strtolower($textRechAut));
				if ($extrait_present!==false) {
					if (!in_array($list[$i],$tab_auteurs)) {
						$tab_auteurs[]=$list[$i];
					}//fin if (!in_array($list[$i],$tab_keyw))
				} //fin de : si il y a le mot tapé dans la liste des mots clés
			} // fin for = lecture du tableau des auteurs
		}//fin if ($result->auteur)
	  }// fin while
	  
	  //affichage du tableau fabriqué des auteurs
	  //reset($tab_auteurs);
	  //print_r($tab_auteurs);
	  reset($tab_auteurs);
	  sort($tab_auteurs);
	  reset($tab_auteurs);
	  for ($i=0;$i<count($tab_auteurs);$i++) {
	  	//echo'<p>';
		if ($id) {
?>
			<a href="javascript:window.location='index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&amp;lg=<?=$lg?>&rechauteur=<?=addslashes($tab_auteurs[$i])?>'"><?=$tab_auteurs[$i]?></a><br />
	<?php 
		} else {
	?>
			<a href="javascript:window.location='index.php?numpage=<?=$numpage?>&amp;spec=<?=$spec?>&amp;numrub=<?=$numrub?>&amp;numcateg=<?=$numcateg?>&amp;numsscateg=<?=$numsscateg?>&amp;lg=<?=$lg?>&rechauteur=<?=addslashes($tab_auteurs[$i])?>'"><?=$tab_auteurs[$i]?></a><br />

<?php
							
		}//fin else if ($id)
	  } //fin for ($i=0;$i<count($tab_keyw);$i++)
	} else { // fin if($query)
		echo 'ERREUR : un problème est survenu lors de la soumission de la requete';
	}
 }//fin if(strlen($textRech)>0)


/* ------------------ Panier - mise a jour des frais de port -------------------------------------------------- */
} else if ($selectPays) {//mise a jour du panier selon pays selectionne (frais de port)
	$lePanier=new Panier();
	$lePanier->numcom=$_SESSION['numcom'];
	if (!$selectPays) $selectPays="247";//France metropolitaine
	if ($selectPays) $lePanier->pays=$selectPays;
	$lePanier->infosPanier();
?>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="30%">Poids :</td>
		<td colspan="3">
		<?=$lePanier->totalPoids?>&nbsp;Kg
		</td>
	</tr>
	<tr>
		<td>Frais de port :</td>
		<td colspan="3">
	<?php
	if ($lePanier->pays=="247") {
	?>
		<strong><?=$lePanier->fraisPort;?> &euro;</strong>
		<?php
		if ($lePanier->fraisPort=="0,00") {
		?>
		<br />
		Livraison gratuite pour toute commande supérieure à 35 € ou pour les documents à télécharger en ligne après paiement
	<?php
		}
	} else {
		if ($lePanier->totalPoids!="0,00") {
			$pageContactLaval = new Page();
			$pageContactLaval->PageSpecifique("contact");
	?>
			<strong>Pour les Dom et autres pays</strong>, votre panier sera transformé en demande de prix et envoyé par mail à <a href="index.php?spec=contact&numpage=<?=$pageContactLaval->numpage?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numcontact=70&lg=fr"> Brigitte Laval</a> qui vous précisera par retour de mail le coût de la livraison.
	<?php
		} else {
	?>
		Livraison gratuite pour les documents à télécharger en ligne après paiement
	<?php
		}
	}//fin else
	?>

	</td>
	</tr>
	<tr><td colspan="4"></td></tr>
	<tr><td colspan="4">&nbsp;</td></tr>
	<tr class="entete"><td colspan="4"></td></tr>
	<tr><td colspan="4">&nbsp;</td></tr>
	<tr>
	<td><strong>TOTAL</strong><? if ($lePanier->pays!="247" && $lePanier->totalpoids!=0) echo" (hors livraison)";?> :</td>
	<td colspan="3"><strong><?=$lePanier->totalHT;?> &euro;</strong>
	</td>
	</tr>
	</table>
	
<?php
} 

mysql_close();
?>