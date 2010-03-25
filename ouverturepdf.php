<?
if (!isset($file)) $file="";
if (!isset($check_url)) $check_url="";
if ($file) $check_url=preg_match("/^http:\/\//i", $file);

if ($file && !$check_url && file_exists("fichiers/".$file)) {

	$fichier="fichiers/".$file;
	$fp=fopen($fichier,"r");
	header("Content-Type : application/octet-stream");
	header('Content-Disposition: attachment; filename="'.$fichier.'"');
	readfile($fichier);
	// fclose($chem."pdf/".$fichier); ????
	/*
	$fichier="fichiers/".$file;
	$fp=fopen($fichier,"r");
	$buff=fread($fp,filesize($fichier)); 
	header('Content-type: application/pdf');
	echo $buff;
	fclose($fp);
	*/
}
?>