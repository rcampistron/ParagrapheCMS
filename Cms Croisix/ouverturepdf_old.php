<?
$fichier="fichiers/".$file;
$fp=fopen($fichier,"r");
$buff=fread($fp,filesize($fichier)); 
header('Content-type: application/pdf');
echo $buff;
fclose($fp);
?>