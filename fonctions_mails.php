<?php
/*********************************************************************/
// Gestion de l'envoi des mails, separee de fonctions.php
// La transformation en mail html (encodage UTF_8 est effectuée
// dans la fonction EnvoiMail() de fonctions.php
/*********************************************************************/
function EnvoiMailCommande($numcommande,$email,$autorise) {

 if(!is_numeric($numcommande)) return false;
 else {
		
		$date=date("d/m/Y",time());
		//recup de la commande - on ne peut pas utiliser nos objets
		$result=mysql_query("SELECT * FROM if_bo_com WHERE numcom='".$numcommande."'");
		$laCommande=mysql_fetch_array($result);
		
		//recup du client
		$result=mysql_query("SELECT * FROM if_bo_client WHERE numclient='".$laCommande["numclient"]."'");
		$leClient=mysql_fetch_array($result);
		
		//recup des infos de livraison
		$result=mysql_query("SELECT * FROM if_bo_livfact WHERE numlivfact='".$laCommande["numlivfact"]."'");
		$laLivraison=mysql_fetch_array($result);
		
		$corps.="\nCOMMANDE IFIP - Institut du Porc - ".$date."\n\n";
		
		
		if ($autorise=="o") {
			$corps.="Bonjour ".$leClient["prenom"]." ".$leClient["nom"].",\n\nNous avons bien enregistré votre ";
			$corps.="commande n°".$numcommande." sur le site de l'Ifip Institut du Porc et vous en remercions.\n";
			$corps.="Vous en trouverez ci-dessous le détail.\n\n";	
			
			$corps.="----------------------------------------------------------------------------------\n";
			$corps.="DETAIL DE VOTRE COMMANDE n° ".$numcommande." en date du ".$date."\n";
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
			$corps.="Livraison : ".$laCommande["port"]." euros\n";
			$corps.="Total : ".$laCommande["montantTTC"]." euros\n\n";
			$corps.="Mode de paiement : carte bancaire\n";
		
			$corps.="\nVOS COORDONNEES : \n".$email."\n\n";
			
			$corps.="\nLIVRAISON : \n";
			$corps.=$laLivraison["prenom_l"]." ".$laLivraison["nom_l"]."\n";
			if ($laLivraison["raison_l"]) $corps.=$laLivraison["raison_l"]."\n";
			$corps.=$laLivraison["adr1_l"]."\n";
			if ($laLivraison["adr2_l"]) $corps.=$laLivraison["adr2_l"]."\n";
			$corps.=$laLivraison["cp_l"]." ".$laLivraison["ville_l"]."\n";
			$corps.=utf8_encode(SelectSimple("pays","if_pays","numpays",$laLivraison["numpays_l"],""))."\n";
			$corps.="Tél. ".$laLivraison["tel_l"]."\n";
			$corps.="Fax. ".$laLivraison["fax_l"]."\n";
			
			$corps.="\nFACTURATION : \n";
			$corps.=$laLivraison["prenom_f"]." ".$laLivraison["nom_f"]."\n";
			if ($laLivraison["raison_f"]) $corps.=$laLivraison["raison_f"]."\n";
			$corps.=$laLivraison["adr1_f"]."\n";
			if ($laLivraison["adr2_f"]) $corps.=$laLivraison["adr2_f"]."\n";
			$corps.=$laLivraison["cp_f"]." ".$laLivraison["ville_f"]."\n";
			$corps.=utf8_encode(SelectSimple("pays","if_pays","numpays",$laLivraison["numpays_f"],""))."\n";
			$corps.="Tél. ".$laLivraison["tel_f"]."\n";
			$corps.="Fax. ".$laLivraison["fax_f"]."\n";
			$corps.="\n";
		
			$corps.="Vous pouvez suivre en ligne l'évolution de votre commande et,\nle cas échéant, télécharger les documents ";
			$corps.="en vous connectant à la rubrique Mon Compte.\n ";
			$corps.="accessible en haut et à droite de toutes les pages du site.\n ";	
		} else {
			$corps.="Bonjour ".$leClient->prenom." ".$leClient->nom.",\n";			
			$corps.="Une erreur s'est produite lors de votre commande n°".$numcommande." sur le site de l'Ifip,\n\n";
			$corps.="pendant le paiement en ligne (ex : mauvais numéro de carte,...).\n\n";
			$corps.="Nous vous conseillons de recommencer l'opération en vous connectant sur le site de l'Ifip.\n\n";
		}	
			$corps.="\nCordialement\n";
			$corps.="\nBrigitte Laval, IFIP\n";
			$corps.="Tél. 01 40 04 53 72\n";
			$corps.="----------------------------------------------------------------------------------\n";
			
			
			$recipients=$email;
			$From="Ifip Institut du Porc<ifip@ifip.asso.fr>";
			$Bcc="";
			$To=$recipients;
			$ReturnPath=$From;
			$ReplyTo=$From;
			$Subject="Votre commande IFIP (n°".$numcommande.")";
			
			EnvoiMail($recipients,$From,$Bcc,$To,$ReturnPath,$ReplyTo,$Subject,$corps);
			

			$recipients="brigitte.laval@ifip.asso.fr";
			//$recipients="henriette.cuny@wanadoo.fr";
			$From="Ifip Institut du Porc<ifip@ifip.asso.fr>";
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
		
		//recup du client
		$resul=mysql_query("SELECT * FROM if_bo_client WHERE numclient='".$laCommande["numclient"]."'");
		$leClient=mysql_fetch_array($resul);
		
		//recup des infos de livraison
		$resu=mysql_query("SELECT * FROM if_bo_livfact WHERE numlivfact='".$laCommande["numlivfact"]."'");
		$laLivraison=mysql_fetch_array($resu);
		
		$corps.="\nCOMMANDE IFIP - Institut du Porc - ".$date."\n\n";
			
		$corps.="Bonjour ".$leClient["prenom"]." ".$leClient["nom"].",\n\nNous avons bien enregistré votre ";
		$corps.="commande n°".$numcommande." sur le site de l'Ifip Institut du Porc et vous en remercions.\n";
		$corps.="Vous trouverez ci-dessous le détail de votre commande ainsi que les informations pour procéder au règlement.\n";
		
		$corps.="----------------------------------------------------------------------------------\n";
		$corps.="DETAIL DE VOTRE COMMANDE n° ".$numcommande." en date du ".$date."\n";
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
		$corps.="Livraison ".$laCommande["port"]." euros\n";
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
		$corps.="\nAdresse e-mail : ".$email."\n";
		
		$corps.="LIVRAISON (sauf documents à télécharger) : \n";
		$corps.=$laLivraison["prenom_l"]." ".$laLivraison["nom_l"]."\n";
		if ($laLivraison["raison_l"]) $corps.=$laLivraison["raison_l"]."\n";
		$corps.=$laLivraison["adr1_l"]."\n";
		if ($laLivraison["adr2_l"]) $corps.=$laLivraison["adr2_l"]."\n";
		$corps.=$laLivraison["cp_l"]." ".$laLivraison["ville_l"]."\n";
		$corps.=utf8_encode(SelectSimple("pays","if_pays","numpays",$laLivraison["numpays_l"],""))."\n";
		$corps.="Tél. ".$laLivraison["tel_l"]."\n";
		$corps.="Fax. ".$laLivraison["fax_l"]."\n";
			
		$corps.="\nFACTURATION : \n";
		$corps.=$laLivraison["prenom_f"]." ".$laLivraison["nom_f"]."\n";
		if ($laLivraison["raison_f"]) $corps.=$laLivraison["raison_f"]."\n";
		$corps.=$laLivraison["adr1_f"]."\n";
		if($laLivraison["adr2_f"]) $corps.=$laLivraison["adr2_f"]."\n";
		$corps.=$laLivraison["cp_f"]." ".$laLivraison["ville_f"]."\n";
		$corps.=utf8_encode(SelectSimple("pays","if_pays","numpays",$laLivraison["numpays_f"],""))."\n";
		$corps.="Tél. ".$laLivraison["tel_f"]."\n";
		$corps.="Fax. ".$laLivraison["fax_f"]."\n";
		$corps.="\n";
		
		$corps.="Après réception de votre chèque de paiement, un mail de validation de votre commande sera envoyé 
		à l'adresse ".$email.".\nSi vous avez acheté des documents téléchargeables en ligne, nous vous invitons à vous rendre alors dans la rubrique Mon Compte (accessible en haut et à droite de toutes les pages du site) et à cliquer sur le détail de votre commande.\n ";
			
			
		$corps.="\nCordialement\n";
		$corps.="\nBrigitte Laval, IFIP\n";
		$corps.="Tél. 01 40 04 53 72\n";
		$corps.="----------------------------------------------------------------------------------\n";
			
			
		$recipients=$email;
		$From="Ifip Institut du Porc<ifip@ifip.asso.fr>";
		$Bcc="";
		$To=$recipients;
		$ReturnPath=$From;
		$ReplyTo=$From;
		$Subject="Votre commande IFIP (n°".$numcommande.")";
			
		EnvoiMail($recipients,$From,$Bcc,$To,$ReturnPath,$ReplyTo,$Subject,$corps);

		$recipients="brigitte.laval@ifip.asso.fr";
		//$recipients="henriette.cuny@wanadoo.fr";
		$From="Ifip Institut du Porc<ifip@ifip.asso.fr>";
		$Bcc="";
		$To=$recipients;
		$ReturnPath=$From;
		$ReplyTo=$From;
		$Subject="Copie commande IFIP (n°".$numcommande." - Chèque)";
			
		EnvoiMail($recipients,$From,$Bcc,$To,$ReturnPath,$ReplyTo,$Subject,$corps);		
			
		return true;
  }
}

function EnvoiMailCommandeVirement($numcommande,$email,$montant) {

 if(!is_numeric($numcommande)) return false;
 else {
		
		$date=date("d/m/Y",time());
		//recup de la commande - on ne peut pas utiliser nos objets
		$result=mysql_query("SELECT * FROM if_bo_com WHERE numcom='".$numcommande."'");
		$laCommande=mysql_fetch_array($result);
		
		//recup du client
		$resul=mysql_query("SELECT * FROM if_bo_client WHERE numclient='".$laCommande["numclient"]."'");
		$leClient=mysql_fetch_array($resul);
		
		//recup des infos de livraison
		$resu=mysql_query("SELECT * FROM if_bo_livfact WHERE numlivfact='".$laCommande["numlivfact"]."'");
		$laLivraison=mysql_fetch_array($resu);
		
		$corps.="\nCOMMANDE IFIP - Institut du Porc - ".$date."\n\n";
			
		$corps.="Bonjour ".$leClient["prenom"]." ".$leClient["nom"].",\n\nNous avons bien enregistré votre ";
		$corps.="commande n°".$numcommande." sur le site de l'Ifip Institut du Porc et vous en remercions.\n";
		$corps.="Vous trouverez ci-dessous le détail de votre commande ainsi que les informations pour procéder au règlement.\n";
		
		$corps.="----------------------------------------------------------------------------------\n";
		$corps.="DETAIL DE VOTRE COMMANDE n° ".$numcommande." en date du ".$date."\n";
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
		$corps.="Livraison ".$laCommande["port"]." euros\n";
		$corps.="Total ".$laCommande["montantTTC"]." euros\n\n";
		$corps.="Mode de paiement : virement\n";
		$corps.="Veuillez adresser un virement bancaire d'un montant de\n"; 
		$corps.=miseEnFormeNombre($montant); 
		$corps.="€ à l'adresse suivante :\n\n";
		
		$corps.="<strong>Banque : </strong>Crédit Agricole\n26, quai de la Rapée\n75596 Paris Cedex 12 \n\n";
		$corps.="<strong>Domiciliation : </strong>CRCA PARIS IAA. DISTRIB. \n";
		$corps.="<strong>Code banque : </strong>18206\n";
		$corps.="<strong>Code guichet : </strong>00280\n";
		$corps.="<strong>N° de compte : </strong>00220411001\n";
		$corps.="<strong>Clé rib : </strong>14\n\n";
		
		$corps.="<strong>International Bank Account Number : </strong>FR76 1820 6002 8000 2204 1100 114\n";
		$corps.="<strong>Bank Identifier Code : </strong>AGRIFRPP882\n";
		$corps.="----------------------------------------------------------------------------------\n";
		$corps.="\nAdresse e-mail : ".$email."\n";
		
		$corps.="LIVRAISON (sauf documents à télécharger) : \n";
		$corps.=$laLivraison["prenom_l"]." ".$laLivraison["nom_l"]."\n";
		if ($laLivraison["raison_l"]) $corps.=$laLivraison["raison_l"]."\n";
		$corps.=$laLivraison["adr1_l"]."\n";
		if ($laLivraison["adr2_l"]) $corps.=$laLivraison["adr2_l"]."\n";
		$corps.=$laLivraison["cp_l"]." ".$laLivraison["ville_l"]."\n";
		$corps.=utf8_encode(SelectSimple("pays","if_pays","numpays",$laLivraison["numpays_l"],""))."\n";
		$corps.="Tél. ".$laLivraison["tel_l"]."\n";
		$corps.="Fax. ".$laLivraison["fax_l"]."\n";
			
		$corps.="\nFACTURATION : \n";
		$corps.=$laLivraison["prenom_f"]." ".$laLivraison["nom_f"]."\n";
		if ($laLivraison["raison_f"]) $corps.=$laLivraison["raison_f"]."\n";
		$corps.=$laLivraison["adr1_f"]."\n";
		if($laLivraison["adr2_f"]) $corps.=$laLivraison["adr2_f"]."\n";
		$corps.=$laLivraison["cp_f"]." ".$laLivraison["ville_f"]."\n";
		$corps.=utf8_encode(SelectSimple("pays","if_pays","numpays",$laLivraison["numpays_f"],""))."\n";
		$corps.="Tél. ".$laLivraison["tel_f"]."\n";
		$corps.="Fax. ".$laLivraison["fax_f"]."\n";
		$corps.="\n";
		
		$corps.="Après réception de votre virement bancaire, un mail de validation de votre commande sera envoyé 
		à l'adresse ".$email.".\nSi vous avez acheté des documents téléchargeables en ligne, nous vous invitons à vous rendre alors dans la rubrique Mon Compte (accessible en haut et à droite de toutes les pages du site) et à cliquer sur le détail de votre commande.\n ";
			
			
		$corps.="\nCordialement\n";
		$corps.="\nBrigitte Laval, IFIP\n";
		$corps.="Service Editions\n";
		$corps.="149 rue de Bercy\n";
		$corps.="75595 Paris Cedex 12\n";
		$corps.="Tél. 01 40 04 53 72\n";
		$corps.="----------------------------------------------------------------------------------\n";
			
			
		$recipients=$email;
		$From="Ifip Institut du Porc<ifip@ifip.asso.fr>";
		$Bcc="";
		$To=$recipients;
		$ReturnPath=$From;
		$ReplyTo=$From;
		$Subject="Votre commande IFIP (n°".$numcommande.")";
			
		EnvoiMail($recipients,$From,$Bcc,$To,$ReturnPath,$ReplyTo,$Subject,$corps);

		$recipients="brigitte.laval@ifip.asso.fr";
		//$recipients="henriette.cuny@wanadoo.fr";
		$From="Ifip Institut du Porc<ifip@ifip.asso.fr>";
		$Bcc="";
		$To=$recipients;
		$ReturnPath=$From;
		$ReplyTo=$From;
		$Subject="Copie commande IFIP (n°".$numcommande." - Virement)";
			
		EnvoiMail($recipients,$From,$Bcc,$To,$ReturnPath,$ReplyTo,$Subject,$corps);		
			
		return true;
  }
}

function EnvoiMailCommandeChequeValidee($numcommande,$email,$montant) {//ajout HC du virement bancaire ici janvier 2009

 if(!is_numeric($numcommande)) return false;
 else {
		
		
		
		//recup de la commande - on ne peut pas utiliser nos objets
		$result=mysql_query("SELECT * FROM if_bo_com WHERE numcom='".$numcommande."'");
		$laCommande=mysql_fetch_array($result);
		
		if ($laCommande["tpereg"]=="ch") $type="chèque";
		else if ($laCommande["tpereg"]=="vi") $type="virement";
		
		//recup du client - on ne peut pas utiliser nos objets
		$result=mysql_query("SELECT * FROM if_bo_client WHERE numclient='".$laCommande["numclient"]."'");
		$leClient=mysql_fetch_array($result);
		
		$corps.="\nCOMMANDE IFIP - Institut du Porc\n\n";
		
		$corps.="Bonjour ".$leClient["prenom"]." ".$leClient["nom"].",\n\n";
			
		$corps.="Nous avons bien reçu votre ".$type." en paiement de votre ";
		$corps.="commande n°".$numcommande." effectuée sur le site de l'Ifip et vous en remercions.\n\n";
		$corps.="Si votre commande concerne des ouvrages, ceux-ci sont en cours de préparation pour expédition.\n";
		$corps.="Si votre commande concerne une référence (article) à télécharger, nous vous invitons\n";
		$corps.="à vous rendre sur la page d'accueil ifip.asso.fr puis à cliquer sur la rubrique Mon Compte.\n ";
		$corps.="accessible en haut et à droite de toutes les pages du site. Cliquez sur le détail de la commande\n ";
		$corps.="n°".$numcommande." pour accéder à la liste des documents à télécharger.\n ";
		

		$corps.="\nVous pouvez également suivre en ligne l'évolution de votre commande en vous 
		connectant à cette même rubrique.\n";	
			
			
		$corps.="\nCordialement\n";
		$corps.="\nBrigitte Laval\n";
		$corps.="<strong>Ifip - Institut	du	porc</strong>\n";
		$corps.="Service Editions\n";
		$corps.="149 rue de Bercy\n";
		$corps.="75595 Paris Cedex 12\n";
		$corps.="----------------------------------------------------------------------------------\n";
			
			
		$recipients=$email;
		$From="Ifip Institut du Porc<ifip@ifip.asso.fr>";
		$Bcc="";
		$To=$recipients;
		$ReturnPath=$From;
		$ReplyTo=$From;
		$Subject="IFIP/ commande n°".$numcommande." - paiement reçu";
			
		EnvoiMail($recipients,$From,$Bcc,$To,$ReturnPath,$ReplyTo,$Subject,$corps);
			
			
		$recipients="brigitte.laval@ifip.asso.fr,henriette.cuny@croisix.net";
		//$recipients="henriette.cuny@wanadoo.fr";
		$From="Ifip Institut du Porc<ifip@ifip.asso.fr>";
		$Bcc="";
		$To=$recipients;
		$ReturnPath=$From;
		$ReplyTo=$From;
		$Subject="Copie IFIP/ commande n°".$numcommande." - paiement reçu";
			
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
		
		//recup du client
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
		$From="Ifip Institut du Porc<ifip@ifip.asso.fr>";
		$Bcc="";
		$To=$recipients;
		$ReturnPath=$From;
		$ReplyTo=$From;
		$Subject="IFIP/ votre commande n°".$numcommande." est expédiée";
			
		EnvoiMail($recipients,$From,$Bcc,$To,$ReturnPath,$ReplyTo,$Subject,$corps);
			
			
		$recipients="brigitte.laval@ifip.asso.fr,henriette.cuny@croisix.net";
		//$recipients="henriette.cuny@wanadoo.fr";

		$From="Ifip Institut du Porc<ifip@ifip.asso.fr>";
		$Bcc="";
		$To=$recipients;
		$ReturnPath=$From;
		$ReplyTo=$From;
		$Subject="Copie IFIP/ votre commande n°".$numcommande." est expédiée";
			
		EnvoiMail($recipients,$From,$Bcc,$To,$ReturnPath,$ReplyTo,$Subject,$corps);		
			
		return true;
  }
}

function EnvoiMailDevis($numcommande,$email,$montant) {

 if(!is_numeric($numcommande)) return false;
 else {
		
		$date=date("d/m/Y",time());
		//recup de la commande - on ne peut pas utiliser nos objets
		$result=mysql_query("SELECT * FROM if_bo_com WHERE numcom='".$numcommande."'");
		$laCommande=mysql_fetch_array($result);
		
		//recup du client
		$result=mysql_query("SELECT * FROM if_bo_client WHERE numclient='".$laCommande["numclient"]."'");
		$leClient=mysql_fetch_array($result);
		
		//recup des infos de livraison
		$result=mysql_query("SELECT * FROM if_bo_livfact WHERE numlivfact='".$laCommande["numlivfact"]."'");
		$laLivraison=mysql_fetch_array($result);
		
		$corps.="\nCOMMANDE IFIP - Institut du Porc - ".$date."\n\n";
			
		$corps.="Bonjour ".$leClient["prenom"]." ".$leClient["nom"].",\n\nNous avons bien enregistré votre ";
		$corps.="demande de devis n°".$numcommande." sur le site de l'Ifip Institut du Porc et vous en remercions.\n";
		$corps.="Brigitte Laval vous contactera directement par retour de mail afin de vous préciser les frais de livraison ";
		$corps.="sur le pays : ".utf8_encode(SelectSimple("pays","if_pays","numpays",$laCommande["numpays"],""))."\n";
		
		$corps.="----------------------------------------------------------------------------------\n";
		$corps.="DETAIL DE VOTRE DEMANDE n° ".$numcommande." en date du ".$date."\n";
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
		$corps.="Demande N° ".$numcommande."\n";
		$corps.="Livraison en cours de chiffrage\n";
		$corps.="Total ".$laCommande["montantTTC"]." euros\n\n";
		
		$corps.="----------------------------------------------------------------------------------\n";
		$corps.="\Adresse e-mail : ".$email."\n";
		
		$corps.="\nLIVRAISON : \n";
		$corps.=$laLivraison["prenom_l"]." ".$laLivraison["nom_l"]."\n";
		if ($laLivraison["raison_l"]) $corps.=$laLivraison["raison_l"]."\n";
		$corps.=$laLivraison["adr1_l"]."\n";
		if ($laLivraison["adr2_l"]) $corps.=$laLivraison["adr2_l"]."\n";
		$corps.=$laLivraison["cp_l"]." ".$laLivraison["ville_l"]."\n";
		$corps.=utf8_encode(SelectSimple("pays","if_pays","numpays",$laLivraison["numpays_l"],""))."\n";
		$corps.="Tél. ".$laLivraison["tel_l"]."\n";
		$corps.="Fax. ".$laLivraison["fax_l"]."\n";
			
		$corps.="\nFACTURATION : \n";
		$corps.=$laLivraison["prenom_f"]." ".$laLivraison["nom_f"]."\n";
		if ($laLivraison["raison_f"]) $corps.=$laLivraison["raison_f"]."\n";
		$corps.=$laLivraison["adr1_f"]."\n";
		if ($laLivraison["adr2_f"]) $corps.=$laLivraison["adr2_f"]."\n";
		$corps.=$laLivraison["cp_f"]." ".$laLivraison["ville_f"]."\n";
		$corps.=utf8_encode(SelectSimple("pays","if_pays","numpays",$laLivraison["numpays_f"],""))."\n";
		$corps.="Tél. ".$laLivraison["tel_f"]."\n";
		$corps.="Fax. ".$laLivraison["fax_f"]."\n";
		$corps.="\n";
			
			
		$corps.="\nCordialement\n";
		$corps.="\nBrigitte Laval, IFIP\n";
		$corps.="Tél. 01 40 04 53 72\n";
		$corps.="----------------------------------------------------------------------------------\n";
			
			
		$recipients=$email;
		$From="Ifip Institut du Porc<ifip@ifip.asso.fr>";
		$Bcc="";
		$To=$recipients;
		$ReturnPath=$From;
		$ReplyTo=$From;
		$Subject="Votre demande de devis IFIP (n°".$numcommande.")";
			
		EnvoiMail($recipients,$From,$Bcc,$To,$ReturnPath,$ReplyTo,$Subject,$corps);
			
		$recipients="brigitte.laval@ifip.asso.fr,henriette.cuny@croisix.net";
		//$recipients="henriette.cuny@wanadoo.fr";
		$From="Ifip Institut du Porc<ifip@ifip.asso.fr>";
		$Bcc="";
		$To=$recipients;
		$ReturnPath=$From;
		$ReplyTo=$From;
		$Subject="Copie demande de devis (n°".$numcommande.")";
			
		EnvoiMail($recipients,$From,$Bcc,$To,$ReturnPath,$ReplyTo,$Subject,$corps);		
			
		return true;
  }
}
?>
