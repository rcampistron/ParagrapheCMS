<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Document sans nom</title>
</head>

<body>
</body>
</html>
<?
include ("connexion.php");
include ("fonctions.php");
//echo get_magic_quotes_gpc();
//echo "Symâ€™";
$sql = "SELECT numpara,contenu FROM if_paragraphe WHERE contenu LIKE \'%â€™%\' LIMIT 0, 30 ";
$result=mysql_query("SELECT numpara,contenu FROM if_paragraphe WHERE contenu LIKE \'%â€™%\'");
while ($row=mysql_fetch_row($result)) {
	echo $row[0]." - ".$row[1];
	echo "<br />";
	$keyw_corrige=str_replace("â€™","'",$row["contenu"]);
	echo $keyw_corrige;
	echo "<br /><br />";


}
?>