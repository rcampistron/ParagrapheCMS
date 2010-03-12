<?php
include ("connexion.php");

$fp = @fopen("baseifip-retravaillee-hc.csv","r");
//$fp = @fopen("basealfort-henriette.csv","r");
$cpt=0;
	while (!feof($fp)){
		$str=fgets($fp);
		$tab=explode("*",$str);
		/**
		Base Alfort
		$tab[0]=utf8_encode(str_replace("\"","",str_replace("'","''",stripslashes($tab[0]))));
		$tab[1]=utf8_encode(str_replace("\"","",str_replace("'","''",stripslashes($tab[1]))));
		$tab[2]=utf8_encode(str_replace("\"","",str_replace("'","''",stripslashes($tab[2]))));
		$tab[3]=utf8_encode(str_replace("\"","",str_replace("'","''",stripslashes($tab[3]))));
		$tab[4]=utf8_encode(str_replace("\"","",str_replace("'","''",stripslashes($tab[4]))));
		$tab[5]=utf8_encode(str_replace("\"","",str_replace("'","''",str_replace("/",";",stripslashes($tab[5])))));
		$tab[6]=utf8_encode(str_replace("\"","",str_replace("'","''",stripslashes($tab[6]))));
		//mysql_query("INSERT INTO if_paragraphe (titre,contenu) VALUES ('$tab[2]','$tab[6]')");	   
		//echo "<br>INSERT INTO if_paragraphe (titre,contenu) VALUES ('$tab[2]','$tab[6]')";
		$numpara=mysql_insert_id();
		if ($tab[4]) $dat=mktime(0,0,0,1,1,$tab[4]); else $dat=0;
		//mysql_query("INSERT INTO if_docs (numpara,titre_en,auteur,date,reference,keyw) VALUES ('$numpara','$tab[3]','$tab[1]','$dat','$tab[0]','$tab[5]')");
		echo "<br>INSERT INTO if_docs (numpara,titre_en,auteur,date,reference,keyw) VALUES ('$numpara','$tab[3]','$tab[1]','$dat','$tab[0]','$tab[5]')";
		//echo "<br>".$tab[4];
		**/
		
		/**
		-949
		-Apport supplÃ©mentaire daliment ou de lipides pendant les 10 derniers jours de gestation et consÃ©quences sur les performances de mise bas et de lactation
		-Quiniou N	Etienne M	Mourot J	Noblet J	
		-2008
		-Notes (Espace Pro)
		-aliment	apport supplÃ©mentaire	consÃ©quences	gestation	lactation	lipides	mise bas	performance	performances
		-JournÃ©es de la Recherche Porcine (Nom du journal => type de doc)
		-40 (Volume)
		- (Numéro)
		- Extra feed or lipid supplies 10 days prior to parturition and their consequences on farrowing and lactation performances (titre anglais)
		- résumé									
							
		-964
		-Bien-Ãªtre et Ã©levage des porcs
		-Meunier-SalaÃ¼n MC	Bizeray D	Colson V	Courboulay V	Lensink J	Prunier A	Remience V	Vandenheede M	
		-2007
		-
		-bien-Ãªtre	Ã©levage	
		-INRA Productions animales
		-20
		-1
		-The welfare of farmed pigs
		-																																									
**/
/**Array ( [1] => fiche actions [2] => article de revue "techniporc" [3] => article de revue "baromÃ¨tre porc" [4] => article de revue "patho-gÃ¨nes" [5] => ouvrage de rÃ©fÃ©rence [6] => fiche repÃ¨res techniques [7] => fiche observatoire Ã©conomique [8] => la lettre note de conjoncture aliment [9] => la lettre actualitÃ© sur l'Ã©levage porcin [10] => la lettre infos viandes fraÃ®ches et produits transformÃ©s )
baromÃ¨tre porc

**/
		
		//Base Ifip
		
		/**$tab[0]=str_replace("\"","",str_replace("'","''",stripslashes($tab[0])));// champ reference
		$tab[1]=str_replace("\"","",str_replace("'","''",stripslashes($tab[1])));//champ titre français
		$tab[2]=str_replace("\"","",str_replace("'","''",stripslashes($tab[2])));//auteur
		$tab[3]=str_replace("\"","",str_replace("'","''",stripslashes($tab[3])));//date_libre
		
		if (eregi("Espace pro",$tab[4])) $acces_res="o"; else $acces_res="n";//espace pro
		//echo "<br />".$acces_res." ".$tab[0]." ".$tab[4];
		$tab[5]=str_replace("\"","",str_replace("'","''",stripslashes($tab[5])));//mots-clés
		
		
		
		if (trim($tab[6])) {
			$result=mysql_query("SELECT type_doc FROM if_type_doc WHERE nom LIKE '%".trim(str_replace("\"","",str_replace("'","''",stripslashes($tab[6]))))."%'");
			//echo "<br />SELECT type_doc FROM if_type_doc WHERE nom LIKE '%".trim(str_replace("\"","",str_replace("'","''",stripslashes($tab[6]))))."%'";
			$row=mysql_fetch_row($result);
		}
		
		if ($row[0]) {
			//echo "<br>ref=".$tab[0]." ifip=".$tab[6]." type de doc= ".$row[0];
			$type_doc=$row[0];
		} else {
		   $result=mysql_query("SELECT MAX(type_doc) FROM if_type_doc");
		   $row=mysql_fetch_row($result);
		   $type_doc=$row[0]+1;
		   mysql_query("INSERT INTO if_type_doc (type_doc,nom) VALUES ('$type_doc','".trim(str_replace("\"","",str_replace("'","''",stripslashes($tab[6]))))."')");
		   //echo "<br>ref=".$tab[0]." INSERT INTO if_type_doc (type_doc,nom) VALUES ('$type_doc','".trim(str_replace("\"","",str_replace("'","''",stripslashes($tab[6]))))."')";
		   
		}
		
		$ref_biblio="Vol.".str_replace("\"","",str_replace("'","''",stripslashes($tab[7])))." ".str_replace("\"","",str_replace("'","''",stripslashes($tab[8])));// champ ref_biblio (Volume + numéro)
		$tab[9]=str_replace("\"","",str_replace("'","''",stripslashes($tab[9])));//titre_en
		$tab[10]=str_replace("\"","",str_replace("'","''",stripslashes($tab[10])));//contenu
		
		
		mysql_query("INSERT INTO if_paragraphe (titre,contenu) VALUES ('$tab[1]','$tab[10]')");	
		//echo "<br>INSERT INTO if_paragraphe (titre,contenu) VALUES ('$tab[1]','$tab[10]')";
		$numpara=mysql_insert_id();
		mysql_query("INSERT INTO if_docs (numpara,type_doc,titre_en,auteur,ref_biblio,date_libre,reference,keyw,acces_res) VALUES ('$numpara','$type_doc','$tab[9]','$tab[2]','$ref_biblio','$tab[3]','$tab[0]','$tab[5]','$acces_res')");
		echo "<br>INSERT INTO if_docs (numpara,type_doc,titre_en,auteur,ref_biblio,date_libre,reference,keyw,acces_res) VALUES ('$numpara','$type_doc','$tab[9]','$tab[2]','$ref_biblio','$tab[3]','$tab[0]','$tab[5]','$acces_res')";
		
		$cpt++;
		**/
	}
	
fclose($fp);	
mysql_close();
?>
