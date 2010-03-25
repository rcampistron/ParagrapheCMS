<?
// querystring = chaine entière retournée par Paybox lors du retour au site (méthode GET)
//               Comme le précise la documentation Paybox, la valeur de la variable PBX_RETOUR
//               doit être obligatoirement en dernière position pour que cela fonctionne
// pubkeyfile = chemin d'accès complet au fichier de la clé public Paybox

function pbxtestsign($querystring,$pubkeyfile)
{
   $debut = strrpos($querystring,"&")+1;
   $longueur = strpos($querystring,"=",$debut)-$debut;
   $signpbxvarname = substr($querystring,$debut,$longueur);

   $signature = $_GET[$signpbxvarname];
   $b64decode = base64_decode(urldecode($signature));
   
   $position = strpos($querystring,$signpbxvarname);
   $verifdata = substr($querystring,0,$position-1);

   $fp = fopen($pubkeyfile,"r");
   $certificat = fread($fp,filesize($pubkeyfile));
   $clepublic = openssl_pkey_get_public($certificat);

   return openssl_verify($verifdata,$b64decode,$clepublic);
}

// RETOUR :: "1" si signature validée, "0" si signature erronée et "-1" en cas d'erreur.
?>
