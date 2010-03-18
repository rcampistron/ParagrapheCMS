<?php  
/**
 * @date 18/11/2008
 * @class Utilisateur
 * G&egrave;re les fonctionnalit&eacute;s li&eacute;es &agrave; l'utilisateur
 * 
**/
class Utilisateur {
  public $login;
  public $pwd;
  public $id;
  public $cnx;
  public $nom;
  public $prenom;
  public $admin;
  public $actif;
  /**
   * g&egrave;re la connection d'un utilisateur, d&eacute;termine si le mot de passe est bon 
   * @return message confirmant ou infirmant la connexion si le mot de passe est invalide
   */
  function connecte() {
  	$mes="";
	$row=SelectMultiple("if_utilisateur","login",$this->login," AND pwd='".easy($this->pwd,"e")."' AND actif='o'");
  	if ($row["iduti"]) {
		$this->id=$row["iduti"];   
		$icnx=time()+36000;
		$cnx=(string)$icnx;
		$cnx=$cnx."-".$this->id;
		
		$ip=getenv("REMOTE_ADDR");
		mysql_query("INSERT INTO if_acces (iduti,cnx,tps,ip,inactif) VALUES ('$this->id','$cnx',now(),'$ip','n')");
		$this->cnx=$cnx;	
		
		//Quel menu afficher lorsqu'on se logue ?
		$larub=new Menu();
		$larub->afficheRub();
		mysql_close();
		HEADER ("Location: ../index.php?id=$this->id&cnx=$this->cnx&pg_admin=accueil&numrub=$larub->nummenu");
	}  else {
	   $mes="Votre identifiant et/ou votre mot de passe n\'est pas valide !";
	}
	return $mes;
  }
/**
 * D&eacute;connecte l'utilisateur en changeant sont statut dans la bdd
 */
  function deconnecte() {
  	  mysql_query("UPDATE if_acces SET inactif='o' WHERE iduti='$this->id' AND cnx='$this->cnx'");
  }
  /**
   * D&eacute;termine si un utilisateur est admin 
   * @return renvoie true si l'utilisateur est admin 
   */
  function estAdmin() {
  	 $row=SelectSimple("admin","if_utilisateur","iduti",$this->id);	
	 if ($row[0]) return true;
  
  }
  /**
   * Cr&eacute;&eacute; un nouvel utilisateur dans la bdd
   * @see Utilisateur#activerUti()
   */
  function creerUti() {
  	mysql_query("INSERT INTO if_utilisateur (iduti,nom,prenom,login,pwd,admin) VALUES ('".time()."','$this->nom','$this->prenom','$this->login','".easy($this->pwd,"e")."','$this->admin')");	
	$this->numuti=mysql_insert_id(); 
	$this->activerUti();
  }
  /**
   * Modifie les infos concernant un utilisateur dans la bdd
   */
  function modifierUti() {
  	mysql_query("UPDATE if_utilisateur SET nom='$this->nom',prenom='$this->prenom',login='$this->login',pwd='".easy($this->pwd,"e")."',admin='$this->admin' WHERE numuti='$this->numuti'");	
	$this->activerUti();
  }
  /**
   * Active un utilisateur en passant la propri&eacute;t&eacute; actif &agrave; "o" ou "n"
   */
  function activerUti() {
  	mysql_query("UPDATE if_utilisateur SET actif='$this->actif' WHERE numuti='$this->numuti'");	
  }
  /**
   * Fonction qui v&eacute;rifie la session et d&eacute;termine si l'utilsateur est tjrs conent&eacute; et actif
   * @return 0 pour non connect&eacute; ou 0 pour connect&eacute;
   * @param $numclient num(id) du client 
   * @param $cnx identifiant de connexion
   */
  function Verif_Session($numclient,$cnx) {
	$verif_cnx=time();
	$res = mysql_query("SELECT MAX(numacces) FROM if_acces WHERE iduti='".$numclient."' AND cnx='".$cnx."'");	
	$row=mysql_fetch_row($res);
	$numaccesbo=$row[0];
	$liste_cnx=explode("-",$cnx);
	$conn=$liste_cnx[0];   
	$cleuti=$liste_cnx[1];
	
	$result=mysql_query("SELECT inactif FROM if_acces WHERE cnx='".$cnx."'"); 
	$row2=mysql_fetch_row($result); 
	$inactif=$row2[0];	

	if (!$numaccesbo || $inactif=="o" || $verif_cnx>($conn+14400) ){//Vérification de la session
		if($verif_cnx>($conn+14400)) mysql_query("UPDATE if_acces SET inactif='o' WHERE iduti='$numclient' AND cnx='$cnx'");
   		return(0);
	} else {
		return(1);
	}
  } //fin function verif_session
  /**
   * Fonction qui se charge de l'envoi de mot de passe par mail
   * @return renvoie le message de r&eacute;cup&eacute;ration de mot de passe
   */
  function envoyerPwd() {
		$row=SelectMultiple("if_utilisateur","login",$this->login);
      	if ($row["numuti"]) {
			$corps= "Bonjour,\n\nSuite à votre demande, voici votre mot de passe : \n\n";
			$corps.="            --> ".easy($row["pwd"],"d");
			$corps.="\n\nVous souhaitant bonne réception,\n\n";
			$corps.="--------------------\n";
			$corps.="www.ifip.asso.fr\n\n";
			//$corps.=$bv_rvd["email"]."\n\n";
			//$corps.=$bv_rvd["tel"]."\n";
			$corps.="--------------------\n";
	
	        $entete="Content-type: text/plain\nStatus: U\nReply-To: ifip@ifip.asso.fr\nFrom: www.ifip.asso.fr <ifip@ifip.asso.fr>";
			mail($this->login,"Mot de passe !",$corps,$entete,"-f 'ifip@ifip.asso.fr'");		
			$m="Nous venons de vous adresser votre mot de passe à l'\adresse $this->login";
		} else {
			$m="Votre adresse e-mail n\'est pas valide.";
		}  
		return $m;
  }
  /** 
   * R&eacute;cup&egrave;re chaque information li&eacute;es &agrave; un utilisateur, afin de les afficher 
   */
  function infosUti() {
		$row=SelectMultiple("if_utilisateur","numuti",$this->numuti);
		$this->iduti=$row["iduti"];	
		$this->nom=$row["nom"];	
		$this->prenom=$row["prenom"];	
		$this->login=$row["login"];
		$this->pwd=easy($row["pwd"],"d");
		$this->admin=$row["admin"];
		$this->actif=$row["actif"];
  }
}
?>
