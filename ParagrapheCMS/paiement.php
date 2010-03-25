<?
/* ***********************************************************
On aboutit sur cette page a partir de l'action de form (index.php)
=> si etape=4, l'action va vers paiement.php (action=paiement.php?...)
=> en clair : infos de livraison / facturation => etape=4
=> on affiche du coup, la zone choix du type de paiement dans la page panier-ifip...
=> et lors de la soumission, on passe par paiement.php qui renvoie a index avec
=> action=validerReg
************************************************************* */
include ("connexion.php");
session_start();
?>
<html>
<body onLoad="javascript:document.forms[0].submit();">
<!-- onLoad="javascript:document.forms[0].submit();" -->
<?
include ("fonctions.php");
if (isset($radioReg) && $radioReg && $radioReg!="ch" && $radioReg!="vi" && $radioReg!="cb") $radioReg="";
include ("includes/classes.php");
?>

<? if ($radioReg=="ch") { ?>
<form action= 'index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&spec=<?=$spec?>&numpage=<?=$numpage?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&cont=<?=$cont?>&lg=<?=$lg?>' method="post">
<input type ="hidden" name="action" value="<?=$action?>">
<input type ="hidden" name="radioReg" value="ch">

<? } else if($radioReg=="vi") { ?>
<form action= 'index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&spec=<?=$spec?>&numpage=<?=$numpage?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&cont=<?=$cont?>&lg=<?=$lg?>' method="post">
<input type ="hidden" name="action" value="<?=$action?>">
<input type ="hidden" name="radioReg" value="vi">

<? } else if($radioReg=="cb") { ?>

	<?
	if ($_SESSION['numcom']) {
   
   $laCom= new Commande();
   $laCom->numclient=$_SESSION['numclient'];
   $laCom->numcom=$_SESSION['numcom'];			
			
   if ($forma) {//Le client règle une formation suite au mail reçu par l'admin
		$laCom->infosCommande();
		$montantCh=$laCom->montantTTC;
   } else {//Le client règle des docs (ouvrage,article, etc...)
		$numpays=$laCom->getNumPays();
		$lePanier=new Panier();
		$lePanier->numcom=$_SESSION['numcom'];
		$lePanier->pays=$numpays;
		$lePanier->infosPanier();
		$laCom->montantHT=$lePanier->totalHT;
		$laCom->montantTTC=$lePanier->totalTTC;
		$laCom->fraisPort=$lePanier->fraisPort;
		$montantCh=$lePanier->totalTTC;
   }
   $laCom->etat="1";
   $laCom->validerCommandeCB();		
   			
   $client=new Client();
   $client->numclient=$_SESSION['numclient'];
   $client->infosClient(); 
   
   /*$lePanier=new Panier();
   $lePanier->numcom=$_SESSION['numcom'];
   $lePanier->pays="247";
   $lePanier->infosPanier();*/
   $totalTTCok=str_replace(",",".",str_replace(" ","",$totalTTC));
   $prixbancaire=$totalTTCok*100;
   
?>
<FORM ACTION = '/ifip/cgi-bin/modulev3_windows.exe' METHOD = post>
<input type ="hidden" name="PBX_MODE" value="1">
<input type ="hidden" name="PBX_SITE" value="0786652">
<input type ="hidden" name="PBX_RANG" value="01">
<input type ="hidden" name="PBX_IDENTIFIANT" value="508309378">
<input type ="hidden" name="PBX_TOTAL" value="<?=$prixbancaire?>">
<input type ="hidden" name="PBX_DEVISE" value="978">
<input type ="hidden" name="PBX_CMD" value="<?=$laCom->getNumCom()?>">
<input type ="hidden" name="PBX_PORTEUR" value="<?=$client->email?>">
<input type ="hidden" name="PBX_RETOUR" value="montant:M;ref:R;auto:A;trans:T;sign:K">
<input type ="hidden" name="PBX_EFFECTUE" value="http://www.ifip.asso.fr/index.php?numpage=75&numrub=14&spec=panier-ifip-institut-du-porc&paiement=ok&etape=4&radioReg=cb">
<input type ="hidden" name="PBX_REFUSE" value="http://www.ifip.asso.fr/index.php?numpage=75&numrub=14&spec=panier-ifip-institut-du-porc&paiement=refuse&etape=4&radioReg=cb">
<input type ="hidden" name="PBX_ANNULE" value="http://www.ifip.asso.fr/index.php?numpage=75&numrub=14&spec=panier-ifip-institut-du-porc&paiement=annule&etape=4&radioReg=cb">
<input type ="hidden" name="PBX_TYPEPAIEMENT" value="CARTE">
 

	<? } ?>
   
<? } else { ?>
<form action='http://www.ifip.asso.fr/'>
<?php
}//fin else = pas de RadioReg
?>
</form>
</body>
</html>

