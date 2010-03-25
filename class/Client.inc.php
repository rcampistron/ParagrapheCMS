<?php 
/**
 * @class Client Client.inc.php
 * @date 22/01/2009 
 * @brief G&egrave;re les diff&eacute;rents clients
 * @details Création, modification, connection, déconnection d'un client
**/

class Client {
/**
 * num(id) du client 
 * 
 */
	public $numclient;
	/**
	 * Raison sociale du client.
	 * 
	 */
	public $raison;
	/**
	 * Nom du client.
	 * 
	 */
	public $nom;
	/**
	 * pr&eacute;nom du client.
	 * 
	 */
	public $prenom;
	/**
	 * Civilit&eacute; du client.
	 */
	public $civilite;
	/**
	 * Fonction du client.
	 * 
	 */
	public $fonction;
	/** 
	 * Adresse principale du client. 
	 * 
	 */
	public $adr1;
	/**
	 * Adresse secondaire du client.
	 * 
	 */
	public $adr2;
	/**
	 * Code postal du client.
	 * 
	 */
	public $cp;
	/**
	 * Ville du client.
	*/
	public $ville;
	/**
	 * num(id) du pays.
	 */
	public $pays;
	/**
	 * Nom du pays. 
	 * 
	 */
	public $nompays;
	/**
	 * Num&eacutemeacute;ro de t&eacute;l&eacute;phone du client
	 * 
	 */
	public $tel;
	/**
	 * Num&eacutem&eacute;ro gsm du client
	 * 
	 */
	public $gsm;
	/**
	 * Num&eacutem&eacute;ro de fax du client
	 * 
	 */
	public $fax;
	/**
	 * Adresse &eacute;lectronique du client
	 * 
	 */
	public $email;
	/**
	 * Mot de passe du client 
	 * 
	 */
	public $pwd;
	/**
	 * Code de connexion du client lorsu'il se logge 
	 * 
	 */
	public $cnx;
	/**
	 * Indique si le client est actif, valeurs possibles "o" et "n"
	 * 
	 */
	public $actif;
	/**
	 * Indique si c'est un professionnel, valeurs possibles "o" et "n"
	 * 
	 */
	public $professionnel;
	/** 
	 * Le professionel est amont, (producteur, etc) l'affichage des menus et l'acc&eacute;s &agrave; certaines donn&eacute;es 
	 * est donc en cons&eacute;quence
	 * 
	 */
	public $amont; 
	/**
	 * Le professionnel est aval (boucher, etc) 
	 * 
	 */
	public $aval; 
	
	/**
	 * Permet de cr&eacute;er le client.
	 * @return $mes Renvoie un message de feedback
	 * si le compte existe déjà ou si l'adresse mail est déjà utilisée.
	 */
	
	function creerClient() {
		$mes="";
		$query="INSERT INTO if_bo_client (raison,nom,prenom,civilite,fonction,adr1,adr2,cp,ville,numpays,tel,gsm,fax,email,pwd,actif,profes,amont,aval) VALUES ('$this->raison','$this->nom','$this->prenom','$this->civilite','$this->fonction','$this->adr1','$this->adr2','$this->cp','$this->ville','$this->pays','$this->tel','$this->gsm','$this->fax','$this->email','".easy($this->pwd,"e")."','$this->actif','$this->professionnel','$this->amont','$this->aval')";
		$emailexiste=SelectSimple("email","if_bo_client","email",$this->email,"");
		if ($this->professionnel) { // creation d'un pro dans l'admin
		  	if ($emailexiste) { // et il est deja client de la boutique - maj du client
				$numclientexiste=SelectSimple("numclient","if_bo_client","email",$this->email,"");
				mysql_query("UPDATE if_bo_client SET profes='o',amont='$this->amont',aval='$this->aval' 
				WHERE numclient='".$numclientexiste."'");
				$mes="Un compte client existait déjà pour cette adresse email. Le profil (amont,aval) a été mis à jour. Le client conserve le même mot de passe et peut ainsi accéder à l\'ensemble du site";
				
			} else {
				mysql_query($query);
				$this->numclient=mysql_insert_id();
			}
		} else { // c'est un client qui se cree un compte en ligne
			if ($emailexiste) {
				$mes="Cette adresse e-mail existe déjà, vous avez déjà un compte.";
			} else {
				mysql_query($query);
				$this->numclient=mysql_insert_id();
				$_SESSION['numclient']=$this->numclient; // activation de la session pour les clients
			}
		}
		return $mes;
	}
/**
 * Permet de modifier le client 
 * @return $mes Renvoie un message de feedback
 */
	function modifierClient() {
		$mes="";
		mysql_query("UPDATE if_bo_client SET raison='$this->raison', nom='$this->nom', prenom='$this->prenom', civilite='$this->civilite', fonction='$this->fonction', adr1='$this->adr1', adr2='$this->adr2', cp='$this->cp', ville='$this->ville', numpays='$this->pays', tel='$this->tel', gsm='$this->gsm', fax='$this->fax', actif='$this->actif', amont='$this->amont', aval='$this->aval' WHERE numclient='$this->numclient'");
		
		if ($this->email) {
			$email=SelectSimple("email","if_bo_client","email",$this->email,"");
			if ($email) {
				$mes="Cette adresse e-mail existe déjà. Veuillez en chosir une autre !";
			} else {
				mysql_query("UPDATE if_bo_client SET email='$this->email' WHERE numclient='$this->numclient'");
			}
		}
		
		if ($this->pwd) mysql_query("UPDATE if_bo_client SET pwd='".easy($this->pwd,"e")."' WHERE numclient='$this->numclient'");
		
		return $mes;
	}
	/**
	 * Supprime un client de la bdd
	 */
	function supprimerClient() {
		mysql_query("DELETE FROM if_bo_client WHERE numclient='$this->numclient'");
	}
	/**
	 * Active le client en changeant la valeur du champ "actif" dans la table client de la BDD
	 */
	function activerClient() {
	   mysql_query("UPDATE if_bo_client SET actif='$this->actif' WHERE numclient='$this->numclient'");   
	}
	/**
	 * R&eacute;cup&egrave;re le num(id) du client
	 * 
	 */
	function getNumclient() {
		$numcli=SelectSimple("numclient","if_bo_client","email",$this->email," AND pwd='".easy($this->pwd,"e")."' AND actif='o'");
		return $numcli;
	}
	/**
	 * Permet de connecter le client en v&eacute;rifiant son pass et son login 
	 * @return $mes Renvoie un message de feedback si les codes de connexion ne sont pas valides
	 */
	function connecte() {
  	$mes="";
	if ($this->professionnel) $fin_req=" AND profes='o'";
	//else $fin_req=" AND profes!='o'";
	$row=SelectMultiple("if_bo_client","email",$this->email," AND pwd='".easy($this->pwd,"e")."' AND actif='o' $fin_req");
  	if ($row["numclient"]) {
		$this->numclient=$row["numclient"];
		if (!$this->professionnel && $row["profes"]=="o")  $this->professionnel="o"; 
		$icnx=time()+36000;
		$cnx=(string)$icnx;
		$cnx=$cnx."-".$this->id;
		
		$ip=getenv("REMOTE_ADDR");
		mysql_query("INSERT INTO if_bo_acces (numclient,cnx,tps,ip) VALUES ('$this->numclient','$cnx',now(),'$ip')");
		$this->cnx=$cnx;	
		if ($this->professionnel) {
			$_SESSION['numprof']=$row["numclient"];
			$_SESSION['numclient']=$row["numclient"];
		} else {
			$_SESSION['numclient']=$row["numclient"];
			unset($_SESSION['numprof']);
		}
		/*mysql_close();
		HEADER ("Location: ../index.php?id=$this->id&cnx=$this->cnx&pg_admin=accueil&numrub=$larub->nummenu");**/
	}  else {
	   $mes="Vos codes de connexion ne sont pas valides !";
	}
	return $mes;
  }
/**
 * D&eacute;connecte un client
 */
  function deconnecte() {
  	  mysql_query("UPDATE if_bo_acces SET inactif='o' WHERE numclient='$this->numclient' AND cnx='$this->cnx'");
  }
  /**
   * Envoie par mail le mot de passe perdu
   * @return $mes Renvoie un message de feedback
   */
  function envoyerPwd() {
  	
		//$row=SelectMultiple("if_bo_client","email",$this->email); Modifie car un meme email peut être utilise pour public & pro
		if ($this->professionnel) $fin_req=" AND profes='o'";
		//else $fin_req=" AND profes!='o'";
		$row=SelectMultiple("if_bo_client","email",$this->email," AND actif='o' $fin_req");
      	if ($row["numclient"]) {
			$corps= "Bonjour ".$row["prenom"]." ".$row["nom"].",\n\nSuite à votre demande, voici votre mot de passe : \n\n";
			$corps.="            --> ".easy($row["pwd"],"d");
			$corps.="\n\nVous souhaitant bonne réception,\n\n";
			$corps.="--------------------\n";
			$corps.="www.ifip.asso.fr\n\n";
			//$corps.=$bv_rvd["email"]."\n\n";
			//$corps.=$bv_rvd["tel"]."\n";
			$corps.="--------------------\n";
	
	        $entete="Content-type: text/plain\nStatus: U\nReply-To: ifip@ifip.asso.fr\nFrom: www.ifip.asso.fr <ifip@ifip.asso.fr>";
			mail($this->email,"Mot de passe !",$corps,$entete,"-f 'ifip@ifip.asso.fr'");		
			$m="Nous venons de vous adresser votre mot de passe à $this->email";
		} else {
			$m="Votre adresse e-mail n\'est pas valide.";
		}  
		return $m;
  }
  /**
   * Liste les informations du client
   */
  function infosClient() {
		$row=SelectMultiple("if_bo_client","numclient",$this->numclient);
		$this->raison=$row["raison"];	
		$this->nom=$row["nom"];	
		$this->prenom=$row["prenom"];
		$this->pwd=easy($row["pwd"],"d");
		$this->email=$row["email"];
		$this->civilite=$row["civilite"];
		$this->fonction=$row["fonction"];
		$this->adr1=$row["adr1"];
		$this->adr2=$row["adr2"];
		$this->cp=$row["cp"];
		$this->ville=$row["ville"];
		$this->pays=$row["numpays"];
		$this->nompays=utf8_encode(SelectSimple("pays","if_pays","numpays",$this->pays));
		$this->tel=$row["tel"];
		$this->gsm=$row["gsm"];
		$this->fax=$row["fax"];
		$this->actif=$row["actif"];
		$this->amont=$row["amont"];
		$this->aval=$row["aval"];
  }
  

}
?>