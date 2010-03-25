<?php
/**
 * @date 22/01/2009
 * @class Commande Commande.inc.php
 * @brief G&egrave;re les commandes faites sur la boutique
 * @details  création, modification d'une commande
 */

class Commande {
	/**
	 * Num&eacute;ro de la commande
	 */
	public $numcom;
	/**
	 * TVA initialis&eacute; &agrave; 0 car les prix de l'IFIP sont exprim&eacute;s TTC
	 * 
	 */
	public $ttva=0;
	/**
	 * montantHT
	 * 
	 */
	public $montantHT;
	/**
	 * Montant toutes taxes comprises
	 * 
	 */
	public $montantTTC;
	/**
	 * num(id) du client
	 * 
	 */
	public $numclient;
	/**
	 * num(id) de la cl&eacute; &eacute;trang&egrave;re de facturation
	 * 
	 */
	public $numlivfact;
	/**
	 * Nom du pays de livraison
	 * 
	 */
	public $pays;
	/**
	 * Taux de tva
	 * 
	 */
	public $tva;
	/**
	 * Montant des frais de port
	 * 
	 */
	public $fraisPort;
	/**
	 * Poids de la commande
	 * 
	 */
	public $totalPoids;
	/**
	 * Num&eacute;ro de transaction
	 * 
	 */
	public $numerop;
	/**
	 * Type de r&eacute;gl&egrave;ment (ch&egrave;que : ch, carte: cb, devis)
	 * 
	 */
	public $tpereg;
	/**
	 * num(id) du pays
	 * 
	 */
	public $numpays;
	/**
	 * 
	 */
	public $nom_pays;
	/**
	 *  état de la commande - valeurs possibles: 0 = créée,
	 *  1 = en attente de validation par l'admin, 2 = validée,
	 *  3 = expédiée, 4 = reçue
	 */

	public $etat;
	/**
	 * Num&eacute;ro de suivi sp&eacute;cifique &agrave; coliposte
	 * 
	 */

	public $suivi_coliposte;
	/**
	 * @brief Date de création sous format jj/mm/AA
	 * 
	 */

	public $dcrea;
	/**
	 * La commande est une formation
	 * 
	 */

	public $formation;
	/**
	 * La commande est un article créé à la volée
	 * 
	 */

	public $article;
	/**
	 * paiement refuse par la banque
	 * 
	 */

	public $erreurpaiement;

	/**
	 * Nom figurant sur la facturation
	 * 
	 */
	public $nom_f;
	/**
	 * Pr&eacute;nom figurant sur la facturation
	 * 
	 */
	public $prenom_f;
	/**
	 * Num&eacute;ro de t&eacute;l&eacute;phone figurant sur la facturation
	 * 
	 */
	public $tel_f;
	/**
	 * Num&eacute;ro de fax figurant sur la facturation
	 * 
	 */
	public $fax_f;
	/**
	 * Raison sociale figurant sur la facturation
	 * 
	 */
	public $raison_f;
	/**
	 * Adresse principale de facturation
	 * 
	 */
	public $adr1_f;
	/**
	 * Adresse secondaire de facturation
	 * 
	 */
	public $adr2_f;
	/**
	 * Code postal de l'adresse de facturation
	 * 
	 */
	public $cp_f;
	/**
	 * Ville de l'adresse de facturation
	 * 
	 */
	public $ville_f;
	/**
	 * Pays de l'adresse de facturation
	 * 
	 */
	public $pays_f;
	/**
	 * Nom_pays de l'adresse de facturation
	 * 
	 */
	public $nompays_f;
	/**
	 * Nom figurant sur l'adresse de livraison
	 * 
	 */
	public $nom_l;
	/**
	 * Pr&eacute;nom figurant sur l'adrese de livraison
	 * 
	 */
	public $prenom_l;
	/**
	 * Num&eacute;ro de t&eacute;l&eacute;phone figurant sur l'adresse de livraison
	 * 
	 */
	public $tel_l;
	/**
	 * Num&eacute;ro de fax figurant sur l'adresse de livraison
	 * 
	 */
	public $fax_l;
	/**
	 * Raison sociale figurant sur l'adresse de livraison
	 * 
	 */
	public $raison_l;
	/**
	 * Adresse principale de livraison
	 * 
	 */
	public $adr1_l;
	/**
	 * Adresse secondaire de livraison
	 * 
	 */
	public $adr2_l;
	/**
	 * Code postal de l'adresse de livraison
	 * 
	 */
	public $cp_l;
	/**
	 * Ville de l'adresse de livraison
	 * 
	 */
	public $ville_l;
	/**
	 * Pays de l'adresse de livraison
	 * 
	 */
	public $pays_l;
	public $nompays_l;

	/**
	 * Ins&egrave;re une nouvelle commande dans la base
	 * @return renvoie l'id de la commande ins&eacute;r&eacute;e
	 */

	function creerCommande() {
		$numerop=SelectMax("numerop","if_bo_com");
		$numerop++;
		mysql_query("INSERT INTO if_bo_com (numerop,numclient,etat,ttva) VALUES ('$numerop','$this->numclient','0','$this->ttva')");
		return mysql_insert_id(); //numcom
	}


	/**
	 * Modifie une commande
	 */
	function modifierCommande() {
		mysql_query("UPDATE if_bo_com SET numclient='$this->numclient' WHERE numcom='$this->numcom'");
	}

	/**
	 * @brief Fonction qui modifie la commande depuis le CMS
	 * @details (état de la commande + suivi colissimo)
	 */
	function modifierCommandeAdmin() {
		mysql_query("UPDATE if_bo_com SET etat='$this->etat', suivi_coliposte='$this->suivi_coliposte' WHERE numcom='$this->numcom'");
	}

	/**
	 *Fonction qui modifie le montant de commande depuis le CMS pour une formation (validation de la formation sur mesure)
	 */
	function modifierCommandeForma() {
		mysql_query("UPDATE if_bo_com SET montantHT='$this->montantHT', montantTTC='$this->montantTTC' WHERE numcom='$this->numcom'");
	}
	/**
	 * Supprime la commande
	 */
	function supprimerCommande() {
		$numlivfact=SelectSimple("numlivfact","if_bo_com","numcom",$this->numcom);
		mysql_query("DELETE FROM if_bo_livfact WHERE numlivfact='$numlivfact'");
		//mysql_query("DELETE FROM if_bo_detail WHERE numcom='$this->numcom'");
		mysql_query("DELETE FROM if_bo_com WHERE numcom='$this->numcom'");

	}
	/**
	 * Modifie le pays pour une commande
	 */
	function modifierPays() {
		mysql_query("UPDATE if_bo_com SET numpays='$this->pays' WHERE numcom='$this->numcom'");
	}
	/**
	 * @brief Valide une commande par ch&egrave;que
	 * @details change le champ "&eacute;tat" &agrave; 1
	 */
	function validerCommandeCheque() {
		mysql_query("UPDATE if_bo_com SET tpereg='ch', etat='1', numclient='$this->numclient', dcrea=now(), hcrea='".time()."',montantHT='$this->montantHT', montantTTC='$this->montantTTC',port='$this->fraisPort',erreur_paiement='non' WHERE numcom='$this->numcom'");
	}
	/**
	 * @brief Valide une commande par virement
	 * @details change le champ " &eacute;tat " &agrave; 1
	 */
	function validerCommandeVirement() {
		mysql_query("UPDATE if_bo_com SET tpereg='vi', etat='1', numclient='$this->numclient', dcrea=now(), hcrea='".time()."',montantHT='$this->montantHT', montantTTC='$this->montantTTC',port='$this->fraisPort',erreur_paiement='non' WHERE numcom='$this->numcom'");
	}
	/**
	 * Enregistre une demande de devis
	 */
	function enregistrerDemandeDevis() {
		mysql_query("UPDATE if_bo_com SET tpereg='dv', etat='1', numclient='$this->numclient', dcrea=now(), hcrea='".time()."',montantHT='$this->montantHT', montantTTC='$this->montantTTC',port='$this->fraisPort',erreur_paiement='non' WHERE numcom='$this->numcom'");
	}
	/**
	 * Valide une commande par carte bancaire
	 */
	function validerCommandeCB() {
		mysql_query("UPDATE if_bo_com SET tpereg='cb', etat='$this->etat', numclient='$this->numclient', dcrea=now(), hcrea='".time()."',montantHT='$this->montantHT', montantTTC='$this->montantTTC',port='$this->fraisPort' WHERE numcom='$this->numcom'");
	}
	/**
	 * Valide la commande et change les infos dans la table if_bo_bq
	 */
	function validerCommandeCBBanque() {
		mysql_query("UPDATE if_bo_com SET etat='$this->etat',erreur_paiement='non' WHERE numcom='$this->numcom'");
		mysql_query("INSERT INTO if_bo_bq (numcom,numerop,numautorisation,montant,dateop) VALUES ('$this->numcom','$this->numerop', '$this->auto', '$this->montant', now())");
	}
	/**
	 * Indique une erreur de commande dans la bdd
	 */
	function validerCommandeCBErreur() {
		mysql_query("UPDATE if_bo_com SET erreur_paiement='oui' WHERE numcom='$this->numcom'");
	}
	/**
	 * R&eacute;cup&egrave;re le montant HT  d'une commande
	 */
	function getMontantHT() {
		return SelectSimple("montantHT","if_bo_com","numcom",$this->numcom);
	}
	/**
	 * R&eacute;cup&egrave;re le montant TTC d'une commande
	 */
	function getMontantTTC() {
		return SelectSimple("montantTTC","if_bo_com","numcom",$this->numcom);
	}
	/**
	 * R&eacute;cup&egrave;re le num(id) de la commande
	 */
	function getNumCom() {
		return SelectSimple("numcom","if_bo_com","numcom",$this->numcom);
	}
	/**
	 * Obtenir le pays de livraison
	 */
	function getNumPays() {
		return SelectSimple("numpays","if_bo_com","numcom",$this->numcom);
	}
	/**
	 * Enregistre la livraison
	 */
	function enregistrerLivraison() {
		mysql_query("INSERT INTO if_bo_livfact (numclient,nom_f,prenom_f,tel_f,fax_f,raison_f,adr1_f,adr2_f,cp_f,ville_f,numpays_f,nom_l,prenom_l,tel_l,fax_l,raison_l,adr1_l,adr2_l,cp_l,ville_l,numpays_l) VALUES ('$this->numclient','$this->nom_f','$this->prenom_f','$this->tel_f','$this->fax_f','$this->raison_f','$this->adr1_f','$this->adr2_f','$this->cp_f','$this->ville_f','$this->pays_f','$this->nom_l','$this->prenom_l','$this->tel_l','$this->fax_l','$this->raison_l','$this->adr1_l','$this->adr2_l','$this->cp_l','$this->ville_l','$this->pays_l')");
		$numlivfact=mysql_insert_id();
		mysql_query("UPDATE if_bo_com SET numlivfact='$numlivfact' WHERE numcom='$this->numcom'");

	}
	/**
	 * R&eacute;cup&egrave;re les infos de la commande
	 */
	function infosCommande() {
		$form=SelectSimple("numdetail","if_bo_detail","numcom",$this->numcom," AND designation='Inscription formation'");
		if ($form) $this->formation="o";

		$artic=SelectSimple("numarticle","if_bo_detail","numcom",$this->numcom);
		if ($artic) $this->article="o";

		$row=SelectMultiple("if_bo_com","numcom",$this->numcom);
		$this->numerop=$row["numerop"];
		$this->tpereg=$row["tpereg"];
		$this->numclient=$row["numclient"];
		$this->numlivfact=$row["numlivfact"];
		$this->numpays=$row["numpays"];
		$this->nom_pays=utf8_encode(SelectSimple("pays","if_pays","numpays",$this->numpays));
		$this->fraisPort=$row["port"];
		$this->etat=$row["etat"];
		$this->suivi_coliposte=$row["suivi_coliposte"];
		$this->dcrea=date("d/m/Y",$row["hcrea"]);
		$this->montantTTC=$row["montantTTC"];
		$this->montantHT=$row["montantHT"];
		$this->erreurpaiement=$row["erreur_paiement"];

		$this->designation=SelectSimple("designation","if_bo_detail","numcom",$this->numcom,"");
		$this->qte=SelectSimple("qte","if_bo_detail","numcom",$this->numcom,"");

	}
	/**
	 * R&eacute;cup&egrave;re les infos de livraison
	 */
	function infosLivraison() {
		$row=SelectMultiple("if_bo_livfact","numlivfact",$this->numlivfact);
		$this->nom_f=$row["nom_f"];
		$this->prenom_f=$row["prenom_f"];
		$this->tel_f=$row["tel_f"];
		$this->fax_f=$row["fax_f"];
		$this->raison_f=$row["raison_f"];
		$this->adr1_f=$row["adr1_f"];
		$this->adr2_f=$row["adr2_f"];
		$this->cp_f=$row["cp_f"];
		$this->ville_f=$row["ville_f"];
		$this->pays_f=$row["numpays_f"];
		$this->nompays_f=utf8_encode(SelectSimple("pays","if_pays","numpays",$this->pays_f));
		$this->nom_l=$row["nom_l"];
		$this->prenom_l=$row["prenom_l"];
		$this->tel_l=$row["tel_l"];
		$this->fax_l=$row["fax_l"];
		$this->raison_l=$row["raison_l"];
		$this->adr1_l=$row["adr1_l"];
		$this->adr2_l=$row["adr2_l"];
		$this->cp_l=$row["cp_l"];
		$this->ville_l=$row["ville_l"];
		$this->pays_l=$row["numpays_l"];
		$this->nompays_l=utf8_encode(SelectSimple("pays","if_pays","numpays",$this->pays_l));
	}

}
?>
