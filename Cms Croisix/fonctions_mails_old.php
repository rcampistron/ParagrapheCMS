<?php
/*********************************************************************/
// Gestion de l'envoi des mails, separee de fonctions.php
// car on a besoin des classes (qui sont incluses apres fonctions.php)
/*********************************************************************/
function EnvoiMailCommande($numcommande,$email,$autorise) {

 if(!is_numeric($numcommande)) return false;
 else {
		
		$date=date("d/m/Y",time());
		//recup de la commande - on ne peut pas utiliser nos objets
		$result=mysql_query("SELECT * FROM if_bo_com WHERE numcom='".$numcommande."'");
		$laCommande=mysql_fetch_array($result);
		
		//recup de la commande - on ne peut pas utiliser nos objets
		$result=mysql_query("SELECT * FROM if_bo_client WHERE numclient='".$laCommande["numclient"]."'");
		$leClient=mysql_fetch_array($result);
		/*
		$laCommande=new Commande();
		$laCommande->numcom->$numcommande;
		$laCommande->infosCommande();
		
		$leClient=new Client();
		$leClient->numclient->$laCommande->numclient;
		$leClient->infosClient();
		*/
		
		$corps.="\nCOMMANDE IFIP - Institut du Porc\n\n";
		
		
		if ($autorise=="o") {
			$corps.="Bonjour ".$leClient["prenom"]." ".$leClient["nom"].",\n\nNous avons bien enregistré votre ";
			$corps.="commande n°".$numcommande." sur le site de l'Ifip Institut du Porc et vous en remercions.\n";
			$corps.="Vous trouverez ci-dessous le détail de votre commande.\n";	
			
			
			$corps.="----------------------------------------------------------------------------------\n";
			$corps.="DETAIL DE VOTRE COMMANDE\n";
			$corps.="----------------------------------------------------------------------------------\n";
			$result=mysql_query("SELECT * FROM if_bo_detail WHERE numcom='$numcommande'");
			while($detail=mysql_fetch_array($result)) {
				$numpara=$detail["numpara"];
				$numarticle=$detail["numarticle"];
				if($numpara) $titre=SelectSimple("titre","if_paragraphe","numpara",$numpara,"");
				if($numarticle) $titre=SelectSimple("libelle","if_articles","numarticle",$numarticle,"");
				$corps.=$titre." - ".$detail["prix_vente"]." euros - qte : ".$detail["qte"]."\n";
			}
			$corps.="----------------------------------------------------------------------------------\n";
		
			$corps.="Commande N° ".$numcommande."\n";
			$corps.="Livraison : ".$laCommande["fraisPort"]." euros\n";
			$corps.="Total : ".$laCommande["montantTTC"]." euros\n\n";
			$corps.="Mode de paiement : carte bancaire\n";
		
			$corps.="\Vos coordonnées : ".$email."\n";
		
			$corps.="Vous pouvez suivre en ligne l'évolution de votre commande en vous connectant à la rubrique Mon Compte.\n ";
			$corps.="accessible en haut et à droite de toutes les pages du site.\n ";	
		} else {
			$corps.="Bonjour ".$leClient->prenom." ".$leClient->nom.",\n";			
			$corps.="Une erreur s'est produite lors de votre commande n°".$numcommande." sur le site de l'Ifip,\n\n";
			$corps.="pendant le paiement en ligne (ex:mauvais numéro de carte,...).\n\n";
			$corps.="Nous vous conseillons de recommencer l'opération en vous connectant sur le site de l'Ifip.\n\n";
		}	
			$corps.="\nCordialement\n";
			$corps.="\nBrigitte Laval, IFIP\n";
			$corps.="\nTél. 01 40 04 53 72\n";
			$corps.="----------------------------------------------------------------------------------\n";
			
			
			$recipients=$email;
			$From="Ifip<ifip@ifip.asso.fr>";
			$Bcc="";
			$To=$recipients;
			$ReturnPath=$From;
			$ReplyTo=$From;
			$Subject="Votre commande IFIP (n°".$numcommande.")";
			
			EnvoiMail($recipients,$From,$Bcc,$To,$ReturnPath,$ReplyTo,$Subject,$corps);
			
			
			$recipients="brigitte.laval@ifip.asso.fr";
			$From="Ifip<ifip@ifip.asso.fr>";
			$Bcc="";
			$To=$recipients;
			$ReturnPath=$From;
			$ReplyTo=$From;
			$Subject="Copie Commande IFIP (n°".$numcommande.")";
			
			EnvoiMail($recipients,$From,$Bcc,$To,$ReturnPath,$ReplyTo,$Subject,$corps);		
			
			return true;
	}
}

function EnvoiMailCommandeCheque($numcommande,$email,$montant) {

 if(!is_numeric($numcommande)) return false;
 else {
		
		$date=date("d/m/Y",time());
		//recup de la commande - on ne peut pas utiliser nos objets
		$result=mysql_query("SELECT * FROM if_bo_com WHERE numcom='".$numcommande."'");
		$laCommande=mysql_fetch_array($result);
		
		//recup de la commande - on ne peut pas utiliser nos objets
		$result=mysql_query("SELECT * FROM if_bo_client WHERE numclient='".$laCommande["numclient"]."'");
		$leClient=mysql_fetch_array($result);
		/*
		$laCommande=new Commande();
		$laCommande->numcom->$numcommande;
		$laCommande->infosCommande();
		
		$leClient=new Client();
		$leClient->numclient->$laCommande->numclient;
		$leClient->infosClient();
		*/
		
		$corps.="\nCOMMANDE IFIP - Institut du Porc\n\n";
			
		$corps.="Bonjour ".$leClient["prenom"]." ".$leClient["nom"].",\n\nNous avons bien enregistré votre ";
		$corps.="commande n°".$numcommande." sur le site de l'Ifip Institut du Porc et vous en remercions.\n";
		$corps.="Vous trouverez ci-dessous le détail de votre commande ainsi que les informations pour procéder au règlement.\n";
		
		$corps.="----------------------------------------------------------------------------------\n";
		$corps.="DETAIL DE VOTRE COMMANDE\n";
		$corps.="----------------------------------------------------------------------------------\n";
		$result=mysql_query("SELECT * FROM if_bo_detail WHERE numcom='$numcommande'");
		while($detail=mysql_fetch_array($result)) {
			$numpara=$detail["numpara"];
			$numarticle=$detail["numarticle"];
			if($numpara) $titre=SelectSimple("titre","if_paragraphe","numpara",$numpara,"");
			if($numarticle) $titre=SelectSimple("libelle","if_articles","numarticle",$numarticle,"");
			$corps.=$titre." - ".$detail["prix_vente"]." euros - qte : ".$detail["qte"]."\n";
		}
		$corps.="----------------------------------------------------------------------------------\n";
		
		$corps.="Commande N° ".$numcommande."\n";
		$corps.="Livraison ".$laCommande["fraisPort"]." euros\n";
		$corps.="Total ".$laCommande["montantTTC"]." euros\n\n";
		$corps.="Mode de paiement : chèque bancaire\n";
		$corps.="Veuillez adresser un chèque d'un montant de\n"; 
		$corps.=miseEnFormeNombre($montant); 
		$corps.="€ à l'adresse suivante :\n";
		$corps.="<strong>Ifip	-	Institut	du	porc</strong>\n";
		$corps.="Service Editions\n";
		$corps.="A l'attention de Brigitte Laval\n";
		$corps.="149 rue de Bercy\n";
		$corps.="75595 Paris Cedex 12\n";
		
		$corps.="----------------------------------------------------------------------------------\n";
		$corps.="\Adresse e-mail : ".$email."\n";
		
		
		
		$corps.="Vous pouvez suivre en ligne l'évolution de votre commande en vous connectant à la rubrique Mon Compte.\n ";
		$corps.="accessible en haut et à droite de toutes les pages du site.\n ";
		$corps.="Un mail de validation vous sera automatiquement envoyé à réception de votre chèque.\n\n ";
			
			
		$corps.="\nCordialement\n";
		$corps.="\nBrigitte Laval, IFIP\n";
		$corps.="\nTél. 01 40 04 53 72\n";
		$corps.="----------------------------------------------------------------------------------\n";
			
			
		$recipients=$email;
		$From="Ifip<ifip@ifip.asso.fr>";
		$Bcc="";
		$To=$recipients;
		$ReturnPath=$From;
		$ReplyTo=$From;
		$Subject="Votre commande IFIP (n°".$numcommande.")";
			
		EnvoiMail($recipients,$From,$Bcc,$To,$ReturnPath,$ReplyTo,$Subject,$corps);
			
			
		$recipients="brigitte.laval@ifip.asso.fr";
		$From="Ifip<ifip@ifip.asso.fr>";
		$Bcc="";
		$To=$recipients;
		$ReturnPath=$From;
		$ReplyTo=$From;
		$Subject="Copie commande IFIP (n°".$numcommande.")";
			
		EnvoiMail($recipients,$From,$Bcc,$To,$ReturnPath,$ReplyTo,$Subject,$corps);		
			
		return true;
  }
}

function EnvoiMailCommandeChequeValidee($numcommande,$email,$montant) {

 if(!is_numeric($numcommande)) return false;
 else {
		
		//recup de la commande - on ne peut pas utiliser nos objets
		$result=mysql_query("SELECT * FROM if_bo_com WHERE numcom='".$numcommande."'");
		$laCommande=mysql_fetch_array($result);
		
		//recup de la commande - on ne peut pas utiliser nos objets
		$result=mysql_query("SELECT * FROM if_bo_client WHERE numclient='".$laCommande["numclient"]."'");
		$leClient=mysql_fetch_array($result);
		
		$corps.="\nCOMMANDE IFIP - Institut du Porc\n\n";
		
		$corps.="Bonjour ".$leClient["prenom"]." ".$leClient["nom"].",\n\n";
			
		$corps.="Nous avons bien reçu votre chèque en paiement de votre ";
		$corps.="commande n°".$numcommande." effectuée sur le site de l'Ifip et vous en remercions.\n\n";
		$corps.="Si votre commande concerne des ouvrages, ceux-ci sont en cours de préparation pour expédition.\n";
		$corps.="Si votre commande concerne une référence (article) à télécharger, nous vous invitons\n";
		$corps.="à vous rendre sur la page d'accueil ifip.asso.fr puis cliquer sur la rubrique Mon Compte.\n ";
		$corps.="accessible en haut et à droite de toutes les pages du site. Cliquez sur le détail de la commande\n ";
		$corps.="n°".$numcommande." pour accéder à la liste des documents à télécharger.\n ";
		

		$corps.="\nVous pouvez également suivre en ligne l'évolution de votre commande en vous 
		connectant cette même rubrique.\n";	
			
			
		$corps.="\nCordialement\n";
		$corps.="\nBrigitte Laval\n";
		$corps.="<strong>Ifip - Institut	du	porc</strong>\n";
		$corps.="Service Editions\n";
		$corps.="149 rue de Bercy\n";
		$corps.="75595 Paris Cedex 12\n";
		$corps.="----------------------------------------------------------------------------------\n";
			
			
		$recipients=$email;
		$From="Ifip<ifip@ifip.asso.fr>";
		$Bcc="";
		$To=$recipients;
		$ReturnPath=$From;
		$ReplyTo=$From;
		$Subject="IFIP/ n°".$numcommande." - paiement reçu";
			
		EnvoiMail($recipients,$From,$Bcc,$To,$ReturnPath,$ReplyTo,$Subject,$corps);
			
			
		$recipients="brigitte.laval@ifip.asso.fr";
		$From="Ifip<ifip@ifip.asso.fr>";
		$Bcc="";
		$To=$recipients;
		$ReturnPath=$From;
		$ReplyTo=$From;
		$Subject="Copie IFIP/ n°".$numcommande." - paiement reçu";
			
		EnvoiMail($recipients,$From,$Bcc,$To,$ReturnPath,$ReplyTo,$Subject,$corps);		
			
		return true;
  }
}

function EnvoiMailCommandeExpediee($numcommande,$email) {

 if(!is_numeric($numcommande)) return false;
 else {
		
		//recup de la commande - on ne peut pas utiliser nos objets
		$result=mysql_query("SELECT * FROM if_bo_com WHERE numcom='".$numcommande."'");
		$laCommande=mysql_fetch_array($result);
		
		//recup de la commande - on ne peut pas utiliser nos objets
		$result=mysql_query("SELECT * FROM if_bo_client WHERE numclient='".$laCommande["numclient"]."'");
		$leClient=mysql_fetch_array($result);
		
		$corps.="\nCOMMANDE IFIP - Institut du Porc\n\n";
		
		$corps.="Bonjour ".$leClient["prenom"]." ".$leClient["nom"].",\n\n";
			
		$corps.="Votre ";
		$corps.="commande n°".$numcommande." a été expédiée par nos services.\n ";	
			
		$corps.="\nCordialement\n";
		$corps.="\nBrigitte Laval\n";
		$corps.="<strong>Ifip - Institut	du	porc</strong>\n";
		$corps.="Service Editions\n";
		$corps.="149 rue de Bercy\n";
		$corps.="75595 Paris Cedex 12\n";
		$corps.="----------------------------------------------------------------------------------\n";
			
			
		$recipients=$email;
		$From="Ifip<ifip@ifip.asso.fr>";
		$Bcc="";
		$To=$recipients;
		$ReturnPath=$From;
		$ReplyTo=$From;
		$Subject="IFIP/ n°".$numcommande." - paiement reçu";
			
		EnvoiMail($recipients,$From,$Bcc,$To,$ReturnPath,$ReplyTo,$Subject,$corps);
			
			
		$recipients="brigitte.laval@ifip.asso.fr";
		$From="Ifip<ifip@ifip.asso.fr>";
		$Bcc="";
		$To=$recipients;
		$ReturnPath=$From;
		$ReplyTo=$From;
		$Subject="Copie IFIP/ n°".$numcommande." - paiement reçu";
			
		EnvoiMail($recipients,$From,$Bcc,$To,$ReturnPath,$ReplyTo,$Subject,$corps);		
			
		return true;
  }
}
?>
