<?php // Date de creation: 05/12/2008 

include("classes.php");
include("../connexion.php");



$result=mysql_query("SELECT * FROM if_site");

$res_site=mysql_numrows($result);

$if_site=mysql_fetch_array($result);

$chem=$if_site["path"];	  //$chem="/home/web/croisix/ifip.croisix.com/www/";



include("../fonctions.php");

 



if ($textLogin && $textPwd) {

   $uti=new Utilisateur();

   $uti->login=$textLogin;

   $uti->pwd=$textPwd;

   $mes=$uti->connecte();

}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>


<?php include ("javascript.php");  include ("styles.php"); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<link rel="stylesheet" href="../css/ifip.css" type="text/css" media="screen" />



<title>IFIP Login</title>

</head>

<body>

<div id="container">

<!-- start of header -->

<div id="header" class="line"><?php include ("header.php"); ?>

</div>

<!-- end of header -->



<!-- breadcrumbs -->	

<div class="line">	  	

	  <div class="item" id="breadcrumbs">

	    <div class="sap-content"><p class="breadcrumbs"><a href="/index.php">Ifip</a> > Administration login</p></div>

	  </div>

</div>

<!-- end breadcrumbs -->



<div class="line">

<!-- the left menu column -->

	<div class="item" id="menu_gauche">

 	&nbsp;	

	</div> 

	<!-- the content -->

<div class="item" id="coltexteAdmin">

<div class="sap-content">

<div id="pageadmin">

 	<form action="index.php" method="post" name="FormName" class="adminform">

		<fieldset>	

			<legend>Bienvenue bla sur l'outil d'administration du site ifip.asso.fr</legend>
			<br /><br />
			<legend>Merci de vous identifier pour administrer le site</legend>
			<br />

				<ol>

				    <li><label for="textLogin">Adresse e-mail :</label> <input type="text" name="textLogin"/></li>

 					<li><label for="textPwd">Mot de passe :</label>  <input type="password" name="textPwd"/></li>

					
					
					<li><a href="oublie.php">Mot de passe oubli&eacute; ?</a></li>
					<li><input id="button" type="submit" value="valider" /></li>

					
				</ol>

		</fieldset>

	</form>

</div><!--fin pageadmin -->

</div><!--fin sap-content -->

</div><!--fin item -->

</div><!---fin line--->

<!-- the footer -->

<div class="line">

	<div id="footer" class="item">

		<div class="sap-content">

 		 <?php include ("../includes/footer.php"); ?>

		</div>

	</div>

</div>

<!--fin footer -->

<!-- fin container -->

</div> 

</body></html>

<?php

if ($mes) {

echo"<script language=\"javascript1.2\"><!--\n";

echo"alert('$mes');\n";

echo"// --></script>";

}

?>
