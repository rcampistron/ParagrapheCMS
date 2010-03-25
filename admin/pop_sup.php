<?php /* Date de cration: 26/06/2008 */ 
include ("../connexion.php");

include ("../fonctions.php");


/*** Include des classes ****/	
require_once ("classes.php");


if ($id) {
  $uti=new Utilisateur();
  $uti->id=$id;
}


if ($div=="li_liens".$numlien) {
  /**$fichier_fds=SelectSimple("fichier_fds","su_produits","numprod",$numprod); 
  if ($fichier_fds && file_exists($chem."fichiers/".$fichier_fds)) unlink($chem."fichiers/".$fichier_fds); 
  mysql_query("UPDATE su_produits SET fds='', fichier_fds='', date_fds='', lg_fds='' WHERE numprod='$numprod'");  **/  
  $supLien = new Lien();
  $supLien->numlien=$numlien;
  $supLien->supprimerLien();
} else if ($div=="li_fichiers".$numfichier) {
  $supPara = new Paragraphe(); 
  $supPara->numparafichier=$numparafichier;
  $supPara->enleverFichier();
} else if ($div=="li_photos".$numphoto) {
  $supPara = new Paragraphe(); 
  $supPara->numphoto=$numphoto;
  $supPara->numparaphoto=$numparaphoto;
  $supPara->enleverPhoto();
}  else if ($div=="li_videos".$numvideo) {
  $supPara = new Paragraphe(); 
  $supPara->numparavideo=$numparavideo;
  $supPara->enleverVideo();
} else if ($div=="li_photo_page") {
  $modPage = new Page(); 
  $modPage->numpage=$numpage;
  $modPage->enleverPhoto();
}

?>
<html>	
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../css/ifip.css" type="text/css" media="screen" />	 
<script type="text/javascript" src="../java.js"> 	</script>
<title></title>
<?php 
include ("javascript.php");   
include ("styles.php");
?>	 
</head>
<body class="popup">
<div id="container">
 <div id="pageadmin">
	    <table width="200" border="0">
          <tr>
            <td> <br />
		<br /> <?php if ($div=="li_liens".$numlien) echo "Le lien est supprim&eacute;."; else if ($div=="li_fichiers".$numfichier) echo "Le fichier est supprim&eacute;."; else if ($div=="li_photos".$numphoto) echo "La photo est supprim&eacute;e"; else if ($div=="li_videos".$numvideo) echo "La vid&eacute; est supprim&eacute;e";?>  <br /><br />	 
		<a href="javascript:fermer_fen('<?=$div?>')" >Fermer la fen&ecirc;tre</a></td>
          </tr>
        </table>
 </div>
</div> 
</body>
</html>
<?php
mysql_close();
?>