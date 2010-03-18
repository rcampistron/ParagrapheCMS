<?php
/**
 * @file fonctions.php
 * @Date 05/06/2008 
 **/
$getar = $_GET;	
$getkeys = array_keys($getar);

for($i=0; $i<count($getkeys); $i++){
	$k = $getkeys[$i];
	$v = $getar[$k];
	${$k}=$v;  
	if (!is_array(${$k})) ${$k}=fx_filter($k);
}

$getar = $_POST;  
$getkeys = array_keys($getar);

for($i=0; $i<count($getkeys); $i++){
	$k = $getkeys[$i];
	$v = $getar[$k];
	${$k}=$v;  
	if (!is_array(${$k})) ${$k}=fx_filter($k);
}

if (!$lg) $lg="fr";

if ($lg=="fr") setlocale(LC_TIME, 'french');
else setlocale(LC_TIME, 'en_US.utf-8', 'en.utf-8', 'en_US.utf-8', 'en.utf-8');
//setlocale(LC_TIME, 'french.utf8');
//setlocale(LC_TIME, 'fr_FR.utf-8', 'fr.utf-8', 'fr_FR.utf-8', 'fr.utf-8');


// 28.08.08 : fonction qui ne sert plus car idem aux fonctions de recuperation des variables GET et POST
function InitialisationVar(){
 $tab=func_get_args();
 for ($i=0;$i<count($tab);$i++) {
 	$nom=$tab[$i]; 
	$tab_return[$nom]=fx_filter($nom);
 }
 return $tab_return;
}

// filtrage des donnees, a utiliser systï¿½matiquement pour toute variable externe
function fx_filter($name, $type='STRING', $def='')
{  	 
// si la variable n'a pas ete recue, gerer proprement l'erreur
// on se fiche de savoir comment a ete transmise la donnee.
if(!isset($_REQUEST[$name])) return $def;
$unsafe=trim($_REQUEST[$name]);
// selon le type de variable attendue, traiter.
switch($type)
{
// on gere ici les entier et les flottants de la meme maniere, ceci est un exemple simplifie
// ceci protege des injections sql sur les entiers et evite toute incohï¿½rence.
case 'INT':
case 'FLOAT':
if(!is_numeric($unsafe)) return $def;
return $unsafe;
break; //inutile, pour respecter la syntaxe habituelle
default :  
//$unsafe=stripslashes($unsafe);
// on se protege des injections SQL sur des strings
// remplacer ces tests pour Sybase, qui echappe les ' par une autre ' et on un \
if(get_magic_quotes_gpc()==0)
{
$unsafe=addslashes($unsafe);
}
break;
}

// il reste les XSS.
// on pourrait aussi utiliser html_entities() a la place de htmlspecial chars
// mais attention aux tailles des champs sgbd a augmenter
// on pourrait aussi utiliser strip_tags()
$safe=htmlspecialchars($unsafe, ENT_QUOTES);
$safe=str_replace("&lt;","<",$unsafe);
$safe=str_replace("&gt;",">",$unsafe);
return trim($safe);
}  

/** Fonction de cryptage/décryptage du mot de passe 
 * @todo Nom de fonction à renommer, "easy" est très peu explicite 
 * @param $code la chaîne a dencoder 
 * @param $tp "d" pour décoder, "e" pour encoder
 **/
function easy($code,$tp) {
	$pass="";
	$id="1078652900";		 
		$alphabet = "AB2CDEFGHIJKL0M9NOP7QRST6UVWXYZabcdefghijklmnop5qrstuvwxyz41%^,;!*()_+-=][}{/>3<8|@.";
		$nb_id=strlen($id);
		
		for ($i=0;$i<$nb_id;$i++) {
			$liste=explode(substr($id,$i,1),$alphabet);
			$tab_alpha[]=substr($id,$i,1).$liste[1].$liste[0];
		}
			
			$nb_code=strlen($code);
	
			$k=0;
			$lig="";
			for ($i=0;$i<$nb_code;$i++) {
				$car_code=substr($code,$i,1);
				if ($tp=="e") $pass.=substr($tab_alpha[$k],strpos($alphabet,$car_code),1); else $pass.=substr($alphabet,strpos($tab_alpha[$k],$car_code),1);
				$k++;
				if ($k==$nb_id) $k=0;
				
			}
			return $pass;
}

function supprAccents($objet) {
 $liste=array("Ã "=>"a",
 			  "Ã¢"=>"a",
			  "Ã§"=>"c",
			  "Ã¨"=>"e",
			  "Ã©"=>"e",
			  "Ãª"=>"e",
			  "Ã¯"=>"i",
			  "Ã®"=>"i",
			  "Ã´"=>"o",
			  "Ã¹"=>"u",
			  "Ã»"=>"u",
			  "Ã¼"=>"u"
 			  );
	
 foreach($liste as $accent=>$sansaccent) {
 	$objet=str_replace($accent,$sansaccent,$objet);
 }
 return $objet;
}

function ajoutAccents($objet) {
 $liste=array("a"=>"Ã ",
			  "c"=>"Ã§",
			  "e"=>"Ã©",
			  "o"=>"Ã´",
			  "u"=>"Ã»"
 			  );
	
 foreach($liste as $accent=>$sansaccent) {
 	$objet=str_replace($accent,$sansaccent,$objet);
 }
 return $objet;
}

function Majuscules($objet) {
 $liste=array("Ã "=>"A",
 			  "Ã¢"=>"A",
			  "Ã§"=>"C",
			  "Ã¨"=>"E",
			  "Ã©"=>"E",
			  "Ãª"=>"E",
			  "Ã¯"=>"I",
			  "Ã®"=>"I",
			  "Ã´"=>"O",
			  "Ã¹"=>"U",
			  "Ã»"=>"U",
			  "Ã¼"=>"U"
 			  );
	
 foreach($liste as $accent=>$majuscule) {
 	$objet=str_replace($accent,$majuscule,$objet);
 }		
 $objet=strtoupper($objet);
 //$objet=str_replace('"','',$objet);
 $objet=str_replace('\"','',$objet);
 return $objet;
}

function testerLettre($contenu,$exception="") {
 $alphabet=array(a,Ã ,Ã¢,Ã¦,b,c,Ã§,d,e,Ã©,Ã¨,Ãª,Ã«,f,g,h,i,Ã®,Ã¯,j,k,l,m,n,o,Ã´,Å“,p,q,r,s,t,u,Ã¹,Ã»,Ã¼,v,w,x,y,Ã¿,z);
 $tab=array();
 foreach ($alphabet as $lettre) {
	//if (ereg($lettre,$contenu)) {//fonction depreciee et a reserver a de l'expression reguliere
	$pos=stripos($contenu,$lettre);
	if ($pos!==false) {
		$tab[]=$lettre;
	} 
 }
 return $tab;
}

function miseEnForme($contenu) {
  $contenu=str_replace("\n","<br />",trim($contenu));
  return $contenu;
}

function miseEnFormeTextarea($contenu) {
  $contenu=str_replace("<br />","\n",$contenu);
  return $contenu;
}

function supprimeRC($contenu) {	//supprime les retours charriot
  $contenu=str_replace("<br />","",$contenu);
  return $contenu;
}

function miseEnFormeListe($contenu) {	// met en forme le contenu de type "Liste" <ul><li></li></ul>
  $newcont="<ul><li>";
  $newcont.=str_replace("<br />","</li><li>",$contenu);
  $newcont.="</li></ul>";
  return $newcont;
}

function miseEnFormeNombre($contenu) {
  $contenu=number_format(str_replace(",",".",$contenu),2,",","");
  return $contenu;
}
 // transforme le numero au format 01 99 34 89 78
function afficherTel($num) {
	if ($num) {
	   $num=str_replace(" ","",$num);
	   $num=Substr($num,0,2)." ".Substr($num,2,2)." ".Substr($num,4,2)." ".Substr($num,6,2)." ".Substr($num,8,2);
	}
	return $num;
}

// retourne le numero de telephone au format 0199348978
function nettoyerTel($num) {
 	 $num=str_replace(" ","",str_replace("/","",str_replace(".","",str_replace(";","",str_replace(",","",str_replace("'","''",str_replace("\"","",stripslashes($num))))))));
	 $num=str_replace(":","",$num);	   
	 $num=str_replace("-","",$num);
	 $reg1="^33";	
	 $num=ereg_replace($reg1,"0",$num);
	 $reg2="^0033";
	 $num=ereg_replace($reg2,"0",$num);
	 $reg3="^[+]33";
	 $num=ereg_replace($reg3,"0",$num);
	 return $num;
}


// formate la date de type jj/mm/aaaa en timestamp
function formaterDate($date) {  
  $list=explode("/",$date);
  $laDate=mktime(0,0,0,$list[1],$list[0],$list[2]);
  return $laDate;
}

//Nettoie tous les accents
function normaliza ($string){ 
    $a = 'Ã€Ã�Ã‚ÃƒÃ„Ã…Ã†Ã‡ÃˆÃ‰ÃŠÃ‹ÃŒÃ�ÃŽÃ�Ã�Ã‘Ã’Ã“Ã”Ã•Ã–Ã˜Ã™ÃšÃ›ÃœÃ�Ãž 
ÃŸÃ Ã¡Ã¢Ã£Ã¤Ã¥Ã¦Ã§Ã¨Ã©ÃªÃ«Ã¬Ã­Ã®Ã¯Ã°Ã±Ã²Ã³Ã´ÃµÃ¶Ã¸Ã¹ÃºÃ»Ã½Ã½Ã¾Ã¿Å”Å•'; 
    $b = 'aaaaaaaceeeeiiiidnoooooouuuuy 
bsaaaaaaaceeeeiiiidnoooooouuuyybyRr'; 
    $string = utf8_decode($string);     
    $string = strtr($string, utf8_decode($a), $b); 
    $string = strtolower($string); 
    return utf8_encode($string); 
} 

//Trie le tableau d'objets contacts dans equipes-ifip.php (contacts sur categ et souscateg)
function trierContacts($av1, $av2) {
	return strcmp($av1->nom, $av2->nom);
}

//Trie le tableau d'objets docs dans le moteur de recherche publications-ifip-institut-du-porc.php (docs sur categ et souscateg)
function trierDocs(&$a,&$b) {
    //$ret=strcasecmp($a->anneeDoc, $b->anneeDoc); Mise en commentaire Henriette - on trie maintenant sur le champ date
	$ret=bccomp($a->date_brute, $b->date_brute);
    return ( $ret == 0 ? 0 : ($ret < 0 ? 1 : -1));
}

function contact_nom_cmp($av1, $av2) {
     		return strcmp($av1->nom, $av2->nom);
}		
/************************************** FONCTIONS BIEN UTILES************************************************************/

function SelectSimple($champ,$table,$cle,$valeur,$fin_req='') {
 $result=mysql_query("SELECT (".$champ.") FROM ".$table." WHERE ".$cle."='".$valeur."' ".$fin_req);  
 $row=mysql_fetch_row($result);
 return $row[0];
} 

function SelectMax($champ,$table) {
 $result=mysql_query("SELECT MAX(".$champ.") FROM ".$table."");
 $row=mysql_fetch_row($result);
 return $row[0];
}

function SelectMax2($champ,$table,$cle,$valeur) {
 $result=mysql_query("SELECT MAX(".$champ.") FROM ".$table." WHERE ".$cle."='".$valeur."'");
 $row=mysql_fetch_row($result);
 return $row[0];
}

function SelectCount($champ,$table,$cle,$valeur) {
 $result=mysql_query("SELECT COUNT(".$champ.") FROM ".$table." WHERE ".$cle."='".$valeur."'");
 $row=mysql_fetch_row($result);
 return $row[0];
}

function SelectCount2($champ,$table,$cle,$valeur,$groupage) {
 $result=mysql_query("SELECT ".$champ." FROM ".$table." WHERE ".$cle."='".$valeur."' GROUP BY ".$groupage." ");
 $count=mysql_num_rows($result);
 return $count;
} 	

function SelectMultiple($table,$cle,$valeur,$fin_req='') {
 $result=mysql_query("SELECT * FROM ".$table." WHERE ".$cle."='".$valeur."' ".$fin_req);  
 $row=mysql_fetch_array($result);
 return $row;
} 

function redimage($img_src,$dst_w,$dst_h) {
   // Lit les dimensions de l'image
   $size = GetImageSize($img_src);  
   $src_w = $size[0]; $src_h = $size[1];
   // Teste les dimensions tenant dans la zone
   $test_h = round(($dst_w / $src_w) * $src_h);
   $test_w = round(($dst_h / $src_h) * $src_w);
   // Si Height final non prcis (0)
   if(!$dst_h) $dst_h = $test_h;
   // Sinon si Width final non prcis (0)
   elseif(!$dst_w) $dst_w = $test_w;
   // Sinon teste quel redimensionnement tient dans la zone
   elseif($test_h>$dst_h) $dst_w = $test_w;
   else $dst_h = $test_h;

   // Affiche les dimensions optimales
   echo "WIDTH=".$dst_w." HEIGHT=".$dst_h;
}

function EnvoiMail($recipients,$From,$Bcc,$To,$ReturnPath,$ReplyTo,$Subject,$corps) {
		
	//$entete  = "MIME-Version: 1.0\n";
    $entete.= "Content-type: text/html; charset=UTF-8\n";
	$entete.="From:".$From."\n";
	$entete.="Reply-To:".$ReplyTo."\n";
	$entete.="Return-Path:".$ReturnPath."\n";
	$entete.="Bcc:".$Bcc."\n";
	$entete.="To:".$To;
	
	$corps=nl2br(stripslashes($corps));
	$Subject=stripslashes($Subject);
	
	mail($recipients,$Subject,$corps,$entete);
}


/**************FONCTION PROPRE AU PAIMENT EN LIGNE*****************************************************************/
/**************VERIFICATION DE LA SIGNATURE E TRANSACTION*********************************************************/

function LoadKey( $keyfile, $pub=true, $pass='' ) {         // chargement de la clÃ© (publique par dÃ©faut)

    $fp = $filedata = $key = FALSE;                         // initialisation variables
    $fsize =  filesize( $keyfile );                         // taille du fichier
    if( !$fsize ) return FALSE;                             // si erreur on quitte de suite
    $fp = fopen( $keyfile, 'r' );                           // ouverture fichier
    if( !$fp ) return FALSE;                                // si erreur ouverture on quitte
    $filedata = fread( $fp, $fsize );                       // lecture contenu fichier
    fclose( $fp );                                          // fermeture fichier
    if( !$filedata ) return FALSE;                          // si erreur lecture, on quitte
    if( $pub )
        $key = openssl_pkey_get_public( $filedata );        // recuperation de la cle publique
    else                                                    // ou recuperation de la cle privee
        $key = openssl_pkey_get_private( array( $filedata, $pass ));
    return $key;                                            // renvoi cle ( ou erreur )
}

// comme precise la documentation Paybox, la signature doit Ãªtre
// obligatoirement en derniÃ¨re position pour que cela fonctionne

function GetSignedData( $qrystr, &$data, &$sig ) {          // renvoi les donnes signees et la signature

    $pos = strrpos( $qrystr, '&' );                         // cherche dernier separateur
    $data = substr( $qrystr, 0, $pos );                     // et voila les donnees signees
    $pos= strpos( $qrystr, '=', $pos ) + 1;                 // cherche debut valeur signature
    $sig = substr( $qrystr, $pos );                         // et voila la signature
    $sig = base64_decode( urldecode( $sig ));               // decodage signature
}

// $querystring = chaine entiÃ¨re retournÃ©e par Paybox lors du retour au site (mÃ©thode GET)
// $keyfile = chemin d'accÃ¨s complet au fichier de la clÃ© publique Paybox

function PbxVerSign( $qrystr, $keyfile ) {                  // verification signature Paybox

    $key = LoadKey( $keyfile );                             // chargement de la cle
    if( !$key ) return -1;                                  // si erreur chargement cle
//  penser Ã  openssl_error_string() pour diagnostic openssl si erreur
    GetSignedData( $qrystr, $data, $sig );                  // separation et recuperation signature et donnees
    return openssl_verify( $data, $sig, $key );             // verification : 1 si valide, 0 si invalide, -1 si erreur
}
?>
