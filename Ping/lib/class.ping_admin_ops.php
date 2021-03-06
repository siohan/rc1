<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (wishy@users.sf.net)
#This project's homepage is: http://www.cmsmadesimple.org
#
#This program is free software; you can redistribute it and/or modify
#it under the terms of the GNU General Public License as published by
#the Free Software Foundation; either version 2 of the License, or
#(at your option) any later version.
#
#This program is distributed in the hope that it will be useful,
#but WITHOUT ANY WARRANTY; without even the implied warranty of
#MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#GNU General Public License for more details.
#You should have received a copy of the GNU General Public License
#along with this program; if not, write to the Free Software
#Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
#$Id: News.module.php 2114 2005-11-04 21:51:13Z wishy $

class ping_admin_ops
{
  protected function __construct() {}

  public static function ecrirejournal($now,$status, $designation,$action)
  {
    $db = cmsms()->GetDb();
	
    //Now remove the article
    $query = "INSERT INTO ".cms_db_prefix()."module_ping_recup (id, datecreated, status,designation, action) VALUES ('', ?, ?, ?, ?)";
    $db->Execute($query, array($now, $status, $designation,$action));
    
    
  }

public function CalculPointsIndivs($ecart,$victoire) {


		if($ecart ==1)
	{
		if( $victoire == 1)
		{

			$result = 6;		
			return $result;

		}
		else
		{

			$result = -5;


			return $result;
		}
	}
	elseif($ecart ==2)
	{
		if( $victoire ==1)
		{

			$result = 5.5;


			return $result;

		}
		else
		{

			$result = -6;


			return $result;
		}
	}
	elseif($ecart ==3)
	{
		if($victoire ==1)
		{

			$result = 5;			
			return $result;
		}
		else
		{

			$result = -7;			
			return $result;
		}
	}
	elseif($ecart ==4)
	{
		if( $victoire ==1)
		{

			$result = 4;


			return $result;
		}
		else
		{

			$result = -8;


			return $result;
		}
	}
	elseif($ecart ==5)
	{
		if( $victoire ==1)
		{

			$result = 3;


			return $result;
		}
		else
		{

			$result = -10;


			return $result;
		}
	}
	elseif($ecart ==6)
	{
		if( $victoire ==1)
		{

			$result = 2;


			return $result;
		}
		else
		{

			$result = -12.5;


			return $result;
		}
	}
	elseif($ecart ==7)
	{
		if( $victoire ==1)
		{

			$result = 1;			
			return $result;
		}
		else
		{

			$result = -16;			
			return $result;
		}
	}
	elseif($ecart ==8)
	{
		if( $victoire ==1)
		{

			$result = 0.5;			
			return $result;
		}
		else
		{

			$result = -20;			
			return $result;
		}
	}
	elseif($ecart ==9)
	{
		if( $victoire ==1)
		{

			$result = 0;			
			return $result;
		}
		else
		{

			$result = -29;		
			return $result;
		}
	}
	elseif($ecart ==-1)
	{
		if( $victoire ==1)
		{

			$result = 6;			
			return $result;
		}
		else
		{

			$result = -5;			
			return $result;
		}
	}
	elseif($ecart==-2)
	{
		if( $victoire ==1)
		{

			$result = 7;			
			return $result;

		}
		else
		{

			$result = -4.5;		
			return $result;
		}
	}
	elseif($ecart ==-3)
	{
		if( $victoire ==1)
		{

			$result = 8;			
			return $result;
		}
		else
		{

			$result = -4;


			return $result;
		}
	}
	elseif($ecart ==-4)
	{
		if( $victoire ==1)
		{

			$result = 10;			
			return $result;
		}
		else
		{

			$result = -3;			
			return $result;
		}
	}
	elseif($ecart ==-5)
	{
		if( $victoire ==1)
		{

			$result = 13;			
			return $result;
		}
		else
		{

			$result = -2;			
			return $result;
		}
	}
	elseif($ecart ==-6)
	{
		if( $victoire ==1)
		{

			$result = 17;			
			return $result;
		}
		else
		{

			$result = -1;			
			return $result;
		}
	}
	elseif($ecart ==-7)
	{
		if( $victoire ==1)
		{

			$result = 22;			
			return $result;
		}
		else
		{

			$result = -0.5;			
			return $result;
		}
	}
	elseif($ecart ==-8)
	{
		if( $victoire ==1)
		{

			$result = 28;			
			return $result;
		}
		else
		{

			$result = 0;			
			return $result;
		}
	}
	elseif($ecart ==-9)
	{
		if( $victoire ==1)
		{

			$result = 40;			
			return $result;
		}
		else
		{

			$result = 0;

		}
	}

}

public static function unable_player($licence)
  {
    $db = cmsms()->GetDb();

    //Now remove the entry
    $query = "UPDATE ".cms_db_prefix()."module_ping_joueurs SET actif ='0'  WHERE licence = ?";
    $db->Execute($query, array($licence));


  }

public static function supp_spid($record_id)
  {
    $db = cmsms()->GetDb();
	$ping = cms_utils::get_module('Ping');
	$saison = $ping->GetPreference('saison_en_cours');
    	//on fait la maj dans la table recup_parties, donc on récupère le N° de licence
	$query2 = "SELECT licence FROM ".cms_db_prefix()."module_ping_parties_spid WHERE id = ?";
	$dbresult2 = $db->Execute($query2,array($record_id));
	$row2 = $dbresult2->FetchRow();
	$licence2 = $row2['licence'];
    	//Now remove the entry
    	$query = "DELETE FROM ".cms_db_prefix()."module_ping_parties_spid WHERE id = ?";
    	$result = $db->Execute($query, array($record_id));
		//si la requete fonctionne on met la table recup_parties à jour
		if($result)
		{
			$query3 = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET spid = spid-1 WHERE licence = ? AND saison = ?";
			$db->Execute($query3, array($licence2, $saison));
		}
    



  }

public static function masculin($licence)
  {
    $db = cmsms()->GetDb();

    //Now remove the entry
    $query = "UPDATE ".cms_db_prefix()."module_ping_joueurs SET sexe ='M'  WHERE licence = ?";
    $db->Execute($query, array($licence));


  }

public static function feminin($licence)
  {
    	$db = cmsms()->GetDb();
   	
    //Now remove the entry
    $query = "UPDATE ".cms_db_prefix()."module_ping_joueurs SET sexe ='F'  WHERE licence = ?";
    $db->Execute($query, array($licence));


  }
public static function compte_spid($licence)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$ping = cms_utils::get_module('Ping');
	$saison = $ping->GetPreference('saison_en_cours');
	$query = "SELECT count(*) AS spid FROM ".cms_db_prefix()."module_ping_parties_spid WHERE licence = ? AND saison = ?";
	$dbresult = $db->Execute($query, array($licence,$saison));
	$row = $dbresult->FetchRow();
	$spid = $row['spid'];
	return $spid;

}
##
public static function compte_fftt($licence)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$ping = cms_utils::get_module('Ping');
	$saison = $ping->GetPreference('saison_en_cours');
	$query = "SELECT count(*) AS fftt FROM ".cms_db_prefix()."module_ping_parties WHERE licence = ? AND saison = ?";
	$dbresult = $db->Execute($query, array($licence,$saison));
	$row = $dbresult->FetchRow();
	$fftt = $row['fftt'];
	return $fftt;

}
##
	public static function maj_recup_parties($licence,$table)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		$ping = cms_utils::get_module('Ping');
		$saison = $ping->GetPreference('saison_en_cours');
		$query = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET maj_spid = ? WHERE licence= ? AND saison = ?";
		$dbresult = $db->Execute($query, array($licence,$saison));
		$row = $dbresult->FetchRow();
		$fftt = $row['fftt'];
		return $fftt;

	}
##
public static function search_player_licence($name)
{
	
//end of function
}

public static function get_name($nom)
{
	
	$explosion = explode(' ',$nom);
	$compteur = count($explosion);
	$name = array();
	$prenom = array();
	//on fait qqs traitements pour les caractères accentués
	
	
	$i =0;
	foreach ($explosion as $testcase) {
	$i++;
	//on nettoie les caractères qui posent problème
	$testcase = strtr($testcase, array(
	        'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
	        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
	        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
	        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
	        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
	        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
	        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
	        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r',
	    ));	
	  if (ctype_upper(str_replace("'","",$testcase)) || $testcase =="-" || $testcase =="'") {
	    $name[$i] = $testcase;
		//echo "La chaîne".$i." $testcase ne contient que des majuscules.\n";
	  } else {
	   // echo "La chaîne".$i." $testcase ne contient pas que des majuscules.\n";
		$prenom[$i] = $testcase;
	  }
	}
	
	$nom_final = implode(' ',$name);
	/*
	$nom_final = strtr($nom_final, array(
	        'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
	        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
	        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
	        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
	        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
	        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
	        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
	        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r',
	    ));
	*/
	$prenom_final = implode(' ',$prenom);
	/*
	$prenom_final = strtr($prenom_final, array(
	        'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
	        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
	        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
	        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
	        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
	        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
	        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
	        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r',
	    ));
	*/
	$result[0] = $nom_final;
	$result[1] = $prenom_final;
	return $result;	
//end of function
}
// cette fonction recherche la situation mensuelle d'un joueur du club ds la bdd
public static function get_sit_mens($licence, $mois_event, $annee)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$ping = cms_utils::get_module('Ping');
	$query = "SELECT points FROM ".cms_db_prefix()."module_ping_sit_mens WHERE licence = ? AND mois = ? AND annee = ?";
	$dbresult = $db->Execute($query, array($licence,$mois_event,$annee));
	//si la situation mensuelle du joueur du club n'existe pas ?
	//alors on n'enregistre pas le résultat et on le signale
		if ($dbresult && $dbresult->RecordCount() == 0)
		{
			//$designation.="Ecart non calculé";
			$retour_sit_mens = 0;
		}
		else
		{
			$row = $dbresult->FetchRow();
			$retour_sit_mens = $row['points'];
		}
	return $retour_sit_mens;
//end of function
}

public static function array_code_compet($type_compet)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$ping = cms_utils::get_module('Ping');
	$query4 = "SELECT licence FROM ".cms_db_prefix()."module_ping_participe WHERE type_compet = ?";
	$dbresultat4 = $db->Execute($query4,array($type_compet));
	$row4 = $dbresultat4->GetRows();
	$lignes = $dbresultat4->RecordCount();
	//echo $lignes."<br />";
	//echo $row4[1][licence];
	$lic = array();
	$i=0;

	for($i=0;$i<=$lignes;$i++)
	{
		$tab[$i] = $row4[$i]['licence'];
		
		array_push($lic,$tab[$i]);
		//$licen = array();
		//$licen = substr(implode(", ", $lic), 0, -3);
		//$licen = implode(", ", $lic);
	}
	return $lic;
//end of function
}

public static function delete_teamresult($record_id)
  {
    $db = cmsms()->GetDb();

    //Now remove the entry
    	$query = "DELETE FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE id = ?";
	$db->Execute($query, array($record_id));


  }

public static function display_on_frontend($id)
  {
    $db = cmsms()->GetDb();

    //Now remove the entry
    	$query = "UPDATE ".cms_db_prefix()."module_ping_poules_rencontres SET affiche = '1' WHERE id = ?";
	$db->Execute($query, array($id));


  }

public static function do_not_display($record_id)
  {
    $db = cmsms()->GetDb();

    //Now remove the entry
    	$query = "UPDATE ".cms_db_prefix()."module_ping_poules_rencontres SET affiche = '0' WHERE id = ?";
	$db->Execute($query, array($record_id));


  }

public static function CalculEcart($ecart)
{
	if($ecart >=0 && $ecart < 25) { $ecart = 1; return $ecart; }
	elseif($ecart >=25 && $ecart < 50){ $ecart = 2; return $ecart; }
	elseif($ecart >=50 && $ecart < 100){ $ecart = 3; return $ecart; }
	elseif($ecart >=100 && $ecart < 150){ $ecart = 4; return $ecart; }
	elseif($ecart >=150 && $ecart < 200){ $ecart = 5; return $ecart; }
	elseif($ecart >=200 && $ecart < 300){ $ecart = 6; return $ecart; }
	elseif($ecart >=300 && $ecart < 400){ $ecart = 7; return $ecart; }
	elseif($ecart >=400 && $ecart < 500){ $ecart = 8; return $ecart; }
	elseif($ecart >=500){ $ecart = 9; return $ecart; }

	elseif($ecart > -25 && $ecart < 0){$ecart = -1; return $ecart; }
	elseif($ecart <= -25 && $ecart > -50){$ecart = -2; return $ecart; }
	elseif($ecart <= -50 && $ecart > -100){$ecart = -3; return $ecart; }
	elseif($ecart <= -100 && $ecart > -150){$ecart = -4; return $ecart; }
	elseif($ecart <= -150 && $ecart > -200){$ecart = -5; return $ecart; }
	elseif($ecart <= -200 && $ecart > -300){$ecart = -6; return $ecart; }
	elseif($ecart <= -300 && $ecart > -400){$ecart = -7; return $ecart; }
	elseif($ecart <= -400 && $ecart > -500){$ecart = -8; return $ecart; }
	elseif($ecart <= -500){$ecart = -9; return $ecart; }
}

public static function coeff ($typeCompetition,$licence)
{
	$db  = cmsms()->GetDb();
	//attention au critérium fédéral !!
	//même nom d'épreuve mais coeff différent
	//il faut aussi récupérer la licence 
	if($typeCompetition =='Critérium fédéral')
	{
		$query4 = "SELECT tp.coefficient FROM ".cms_db_prefix()."module_ping_participe AS p, ".cms_db_prefix()."module_ping_type_competitions AS tp WHERE tp.code_compet = p.type_compet AND p.licence = ?";
		$dbresultat4 = $db->Execute($query4,array($licence));
		$row4 = $dbresultat4->FetchRow();
		$coeff = $row4['coefficient'];
		return $coeff;
	}
	else
	{
		
		$query ="SELECT coefficient FROM ".cms_db_prefix()."module_ping_type_competitions WHERE name = ?";
		$dbretour = $db->Execute($query, array($typeCompetition));

			if ($dbretour && $dbretour->RecordCount() > 0)
		  	{
		    		while ($row= $dbretour->FetchRow())
		      		{
					$coeff = $row['coefficient'];
					return $coeff;
				}
	
			}
			else
			{
				$coeff = 0;
				return $coeff;
				//echo "coefficient introuvable !";
			}
	}
}

public function coeff_ops($record_id, $coeff)
  {
	//debug_display($params, 'Parameters');
	
	global $gCms;
    	$db = cmsms()->GetDb();
    	//$ping = cms_utils::get_module('Ping');
	//require_once(dirname(__FILE__).'/function.calculs.php');
	//echo $record_id;
	//echo $coeff;
    	//On récupère les infos de l'enregistrement
    	$query = "SELECT * FROM ".cms_db_prefix()."module_ping_parties_spid WHERE id = ?";
	echo $query;
    	$dbresult = $db->Execute($query, array($record_id));

		
	
		while ($dbresult && $row = $dbresult->FetchRow())
		{
			
			$victoire = $row['victoire'];
			$ecart = $row['type_ecart'];
			echo $victoire;
			echo $ecart;
			$points1 = ping_admin_ops::CalculPointsIndivs($ecart,$victoire);
			//$coeff = '1.00';
			$pointres = $points1*$coeff;
			echo $coeff;
			echo $pointres;
                
                
                
    			$query3 = "UPDATE ".cms_db_prefix()."module_ping_parties_spid SET coeff = ?, pointres = ? WHERE id = ?";
    			$dbresult2 = $db->Execute($query3, array($coeff, $pointres, $record_id));
	        
				if(!$dbresult2)
				{
					$designation = $db->ErrorMsg();
					$status = 'Echec';
					$action = 'mass_delete update recup';
					$query4 = "INSERT INTO ".cms_db_prefix()."module_ping_recup (id, status, designation, action) VALUES ('', ?, ?, ?)";
					$dbresult3 = $db->Execute($query4, array($status, $designation, $action));
				}
                
		}//fin du while
  	


  }//fin de la fonction

public static function duplicate($record_id)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "SELECT * FROM ".cms_db_prefix()."module_ping_parties_spid WHERE id = ?";
	$dbresult = $db->Execute($query, array($record_id));
	
}

public static function retrieve_sit_mens($licence)
  {
	//on vérifie si la situation mensuelle a déjà été prise en compte
	global $gCms;
	$db = cmsms()->GetDb();
	$now = trim($db->DBTimeStamp(time()), "'");
	$mois_courant = date('n');//Mois au format 1, 2, 3 etc....
	$annee_courante = date('Y');
	$mois_francais = array('Janvier', 'Février','Mars', 'Avril', 'Mai', 'Juin', 'Juillet','Août', 'Septembre', 'Octobre','Novembre','Décembre');
	$now = trim($db->DBTimeStamp(time()), "'");
	$mois_reel = $mois_courant - 1;
	$mois_sm = $mois_francais["$mois_reel"];
	$mois_sit_mens = $mois_sm." ".$annee_courante;
	
	$query = "SELECT licence, nom, prenom FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";
	$dbresult = $db->Execute($query, array($licence));
	
		//il faut instancier le service
		$service = new Service();
		$result = $service->getJoueur("$licence");
		//var_dump($result);
		
			if(!is_array($result))
			{
				//le service est coupé ou la licence est inactive
				$row= $dbresult->FetchRow();
				$nom = $row['nom'];
				$prenom = $row['prenom'];
				$message.="Licence introuvable ou service coupé pour ".$nom." ".$prenom;
				$status = 'Echec';
				$designation = $message;
				$action = "mass_action";
				ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
			}
			else{
				//tout va bien on peut continuer
				$licence2 = $result[licence];
				//	echo "la licence est $licence <br />";
				$nom = $result[nom];
				$prenom = $result[prenom];
				//echo "le deuxième appel est : ".$nom." ".$prenom. "<br />";
				$natio = $result[natio];
				$clglob = $result[clglob];
				$points = $result[point];
				$aclglob = $result[aclglob];
				$apoint = $result[apoint];
				$clnat = $result[clnat];
				$categ = $result[categ];
				$rangreg = $result[rangreg];
				$rangdep = $result[rangdep];
				$valcla = $result[valcla];
				$clpro = $result[clpro];
				$valinit = $result[valinit];
				$progmois = $result[progmois];
				$progann = $result[progann];
				
				$query = "INSERT INTO ".cms_db_prefix()."module_ping_sit_mens (id,datecreated, datemaj, mois, annee, phase, licence, nom, prenom, points, clnat, rangreg,rangdep, progmois) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				//echo $query;
				$dbresultat = $db->Execute($query,array($now,$now,$mois_courant, $annee_courante, $phase, $licence2, $nom, $prenom, $points, $clnat, $rangreg, $rangdep, $progmois));

					if(!$dbresultat)
					{
						$message = $db->ErrorMsg(); 
						$status = 'Echec';
						$designation = $message;
						$action = "mass_action";
						ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
						
					}
					else {
						$status = 'Ok';
						$designation = "Situation ok pour ".$nom." ".$prenom;
						$action = 'mass_action';
						ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
						//on met la table recup à jour pour le joueur
						$query = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET datemaj = ? , sit_mens = ? WHERE licence = ?";
						$dbresult = $db->Execute($query, array($now, $mois_sit_mens, $licence2));
					}
				
				
				//$message.="<li>La licence est ok</li>";
			}//fin du else	!is_array
	
	//pas de bol la situation mensuelle est déjà présente
	
//	return $designation;
	
	
  }

public function retrieve_parties_spid( $licence )
  {
	global $gCms;
	$db = cmsms()->GetDb();
	//echo "cool !";
	$ping = cms_utils::get_module('Ping');
	//require_once(dirname(__FILE__).'/function.calculs.php');
	//echo "glop2";
	$saison_courante = $ping->GetPreference('saison_en_cours');
	$now = trim($db->DBTimeStamp(time()), "'");
	$aujourdhui = date('Y-m-d');
	$query = "SELECT CONCAT_WS(' ', nom, prenom) AS player FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";
	$dbretour = $db->Execute($query, array($licence));
	if ($dbretour && $dbretour->RecordCount() > 0)
	{
	    while ($row= $dbretour->FetchRow())
		{
		$player = $row['player'];
		$service = new Service();
		$result = $service->getJoueurPartiesSpid("$licence");
		//echo "glop3";
		//var_dump($result);
		//le service est-il ouvert ?
		/**/
		//on teste le resultat retourné     
		//on controle le nb d'entrées du tableau retourné
		//on le compare avec le chiffre ds la base de données
		$lignes = count($result);//on compte le nb d'éléments du tableau
		//on compte le nb de résultats du spid présent ds la bdd pour le joueur
		$spid = ping_admin_ops::compte_spid($licence);
		
			if(!is_array($result))
			{

				$message = "Service coupé"; 
				$status = 'Echec';
				$designation = $message;
				$action = "mass_action";
				ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
				
			}
			elseif($lignes <= $number)
			{
				$message = "Résultats SPID à jour pour ".$player." : ".$spid." en base de données ".$lignes." en ligne."; 
				$status = 'Echec';
				$designation = $message;
				$action = "mass_action";
				ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
				
				if($lignes == $number)
				{
					$query4 = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET maj_spid = ? WHERE licence = ? AND saison = ?";
					$dbresult4 = $db->Execute($query4,array($aujourdhui,$licence,$saison_courante));
				}
				
				
			}
			else
			{
				$i = 0;
				$compteur = 0;
				$a = 0;//ce compteur sert au parties non récupérées par sit mens vide
				$query1 = "DELETE FROM ".cms_db_prefix()."module_ping_parties_spid WHERE saison = ? AND licence = ?";
				$dbresult1 = $db->Execute($query1, array($saison_courante, $licence));
				foreach($result as $cle =>$tab)
				{

					$compteur++;

					$dateevent = $tab[date];
					$chgt = explode("/",$dateevent);
					$date_event = $chgt[2]."-".$chgt[1]."-".$chgt[0];
					$annee = '20'.$chgt[2];
					
						if (substr($chgt[1], 0,1)==0)
						{
							$mois_event = substr($chgt[1], 1,1);
							//echo "la date est".$date_event;
						}
						else
						{
							$mois_event = $chgt[1];
						}
					//on va vérifier si on a la situation mensuelle du joueur du club à jour pour le mois en question
					$retour_sit_mens = ping_admin_ops::get_sit_mens($licence,$mois_event,$annee);
					if($retour_sit_mens==0)
					{
						$designation.="Situation du mois ".$mois_event." manquante pour ".$player;
						$a++;
					}
					else
					{
						
					$nom = $tab[nom];
					//on adapte son nom d'abord
					$nom_global = ping_admin_ops::get_name($nom);//une fonction qui permet d'extraire le nom et le prénom
					$nom_reel1 = $nom_global[0];
					$nom_reel = addslashes($nom_global[0]);//le nom					
					$prenom_reel = $nom_global[1];//le prénom
					$annee_courante = date('Y');
					
					$classement = $tab[classement];//classement fourni par le spid
					$cla = substr($classement, 0,1);
						//Avec le nom on va aller chercher la situation mensuelle de l'adversaire
						//on pourra la stocker pour qu'elle re-serve et l'utiliser pour affiner le calcul des points
						//d'abord on va chercher ds la bdd si l'adversaire y est déjà pour le mois et la saison en question
						$query4 = "SELECT points FROM ".cms_db_prefix()."module_ping_adversaires WHERE nom = ? AND prenom = ? AND mois = ? AND annee = ?";
						//echo $query4.'<br />';
						$dbresult4 = $db->Execute($query4, array($nom_reel1, $prenom_reel,$mois_event,$annee_courante));

							if($dbresult4 && $dbresult4->RecordCount()>0 && $dbresult4->RecordCount() <2)//ok on a un enregistrement qui correspond
							{
								$row4 = $dbresult4->FetchRow();
								$newclass = $row4['points'];
							}
							//deuxième cas : 
							//on n'a pas d'enregistrement et on est dans le mois courant et l'année courante : on va chercher les points avec la classe pour ensuite l'insérer ds la bdd
							elseif($dbresult4->RecordCount()==0 && $mois_event == date('n') && $annee == date('Y'))
							{
								//on va chercher la sit mens du pongiste
								

								$service = new Service();
								$resultat = $service->getJoueursByName("$nom_reel", $prenom ="$prenom_reel");
								//var_dump($resultat);
								if(is_array($resultat) && count($resultat)>0 && count($resultat)<2)
								{//on a bien un tableau avec au moins un élément : c'est ok !

										//on a un résultat ?
										//echo "Glop";
										//$compteur++;
										$licen = $resultat[0][licence];//on a bien un numéro de licence, on peut donc récupérer la situation mensuelle en cours
										//echo $licen.'<br />';
										$service = new Service();
										$resultat2 = $service->getJoueur("$licen");

										if(is_array($resultat2) && count($resultat2)>0)
										{
											$licence2 = $resultat2[licence];
											$nom = $resultat2[nom];
											//echo 'autre nom : '.$nom .' '.$prenom;
											$prenom = $resultat2[prenom];
											$natio = $resultat2[natio];
											$clglob = $resultat2[clglob];
											$point = $resultat2[point];
											$aclglob = $resultat2[aclglob];
											$apoint = $resultat2[apoint];
											$clnat = $resultat2[clnat];
											$categ = $resultat2[categ];
											$rangreg = $resultat2[rangreg];
											$rangdep = $resultat2[rangdep];
											$valcla = $resultat2[valcla];
											$clpro = $resultat2[clpro];
											$valinit = $resultat2[valinit];
											$progmois = $resultat2[progmois];
											$progann = $resultat2[progann];
											$annee_courante = date('Y');
											//on insère le tout dans la bdd
											$query5 = "INSERT INTO ".cms_db_prefix()."module_ping_adversaires (id,datecreated, datemaj, mois, annee, phase, licence, nom, prenom, points, clnat, rangreg,rangdep, progmois) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
											//echo $query5;
											$dbresultat5 = $db->Execute($query5,array($now,$now,$mois_event, $annee_courante, $phase, $licence2, $nom, $prenom, $point, $clnat, $rangreg, $rangdep, $progmois));
												//On vérifie que l'insertion se passe bien
											$newclass = $point;
										}
										else
										{
											if($cla == 'N'){
												$newclassement = explode('-', $classement);
												$newclass = $newclassement[1];
											}
											else 
											{
												$newclass = $classement;
											}
										}


								}
								else
								{
									if(count($resultat)>1)//homonymie, etc...
									{
										$designation.="Homonymie pour ".$player;
									}
									//echo "Pas Glop";
									if($cla == 'N'){
										$newclassement = explode('-', $classement);
										$newclass = $newclassement[1];
									}
									else 
									{
										$newclass = $classement;
									}
								}//fin du if is_array($resultat)
							}
							else
							{
								//troisième cas : 
								//on n'a pas les points et on n'est pas dans le mois courant, on n'insère pas et on utilise le classement fourni
								if($cla == 'N'){
									$newclassement = explode('-', $classement);
									$newclass = $newclassement[1];
								}
								else 
								{
									$newclass = $classement;
								}
							}
					//on va calculer la différence entre le classement de l'adversaire et le classement du joueur du club
					$query = "SELECT points FROM ".cms_db_prefix()."module_ping_sit_mens WHERE licence = ? AND mois = ? AND annee = ?";
					$dbresult = $db->Execute($query, array($licence,$mois_event,$annee));
					//si la situation mensuelle du joueur du club n'existe pas ?
					//alors on n'enregistre pas le résultat et on le signale
						if ($dbresult && $dbresult->RecordCount() == 0)
						{
							//$designation.="Ecart non calculé";
							$ecart = 0;
						}
						

					$row = $dbresult->FetchRow();
					$points = $row[points];
					$ecart_reel = $points - $newclass;
					
					//on calcule l'écart selon la grille de points de la FFTT
					$type_ecart = ping_admin_ops::CalculEcart($ecart_reel);
					$epreuve = $tab[epreuve];
					//echo $ecart_reel;
					// de quelle compétition s'agit-il ? 
					//On a la date et le type d'épreuve
					//on peut donc en déduire le tour via le calendrier
					//et le coefficient pour calculer les points via la table type_competitons
					
					//1 - on récupére le tour s'il existe
					//on va fdonc chercher dans la table calendrier
					$query = "SELECT numjourn FROM ".cms_db_prefix()."module_ping_calendrier WHERE date_debut = ? OR date_fin = ?";
					$resultat = $db->Execute($query, array($date_event, $date_event));

						if ($resultat && $resultat->RecordCount()>0){
							$row = $resultat->FetchRow();
							$numjourn = $row[numjourn];
						}
						else
						{
							$numjourn = 0;
						}
					
				//	$numjourn = 0;
					//2 - on récupère le coefficient de la compétition
					$coeff = ping_admin_ops::coeff($epreuve,$licence);
					
					
					//$pointres = $points*$coeff;
					//fin du point 2

					$victoire = $tab[victoire];

						if ($victoire =='V'){
							$victoire = 1;
						}
						else 
						{
							$victoire = 0;
						}

					//on peut désormais calculer les points 
					//echo "la victoire est : ".$victoire."<br />";
					$points1 = ping_admin_ops::CalculPointsIndivs($type_ecart, $victoire);
					//echo "le coeff est : ".$coeff."<br />";
					//echo "le type ecart est : ".$type_ecart."<br />";
					//echo "les points 1 sont : ".$points1."<br />";
					$pointres = $points1*$coeff;
					$forfait = $tab[forfait];

					//on détruit tts les données de ce joueur
					//on teste un truc de guedin
					//on supprime tous les enregistrements concernant le joueur ds la base de données pour les remplacer par les nouvelles
					
					
					$query3 = "INSERT INTO ".cms_db_prefix()."module_ping_parties_spid (id, saison, datemaj, licence, date_event, epreuve, nom, numjourn,classement, victoire,ecart,type_ecart, coeff, pointres, forfait) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
					$i++;
					//echo $query;
					$dbresultat3 = $db->Execute($query3,array($saison_courante,$now, $licence, $date_event, $epreuve, $nom, $numjourn, $newclass, $victoire,$ecart_reel,$type_ecart, $coeff,$pointres, $forfait));

					if(!$dbresultat3)
						{
							$message = $db->ErrorMsg(); 
							$status = 'Echec';
							$designation = $message;
							$action = "mass_action";
							ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
						}

					//on met à jour la date de maj des résultats SPID
					
					
					}//fin du if si la sit mens du joueur du club est dûment renseignée

				}//fin du foreach
				
				$comptage = $i;
				$query4 = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET maj_spid = ?, spid = ?,spid_total = ? WHERE licence = ? AND saison = ?";
				$dbresult4 = $db->Execute($query4,array($aujourdhui,$comptage,$compteur,$licence,$saison_courante));
				
				$status = 'Parties SPID';
				$designation .= $comptage." parties Spid sur ".$compteur."  de ".$player;
				if($a >0)
				{
					$designation.= " ".$a." parties Spid non récupérées (situation mensuelle manquante)";
				}
				$action = "mass_action";
				ping_admin_ops::ecrirejournal($now,$status, $designation,$action);

			}//fin du if !is_array
		}//fin du while
	}//fin du if dbretour >0









  }//fin de la fonction
##
##
##
##
#   Retrieve parties FFTT

public static function retrieve_parties_fftt( $licence )
  {
	global $gCms;
	$db = cmsms()->GetDb();
	$ping = cms_utils::get_module('Ping');
	//require_once(dirname(__FILE__).'/function.calculs.php');
	$saison_courante = $ping->GetPreference('saison_en_cours');
	$now = trim($db->DBTimeStamp(time()), "'");
	$aujourdhui = date('Y-m-d');
	$query = "SELECT CONCAT_WS(' ', nom, prenom) AS player FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";
	$dbretour = $db->Execute($query, array($licence));
	if ($dbretour && $dbretour->RecordCount() > 0)
	{
	    while ($row= $dbretour->FetchRow())
		{
		$player = $row['player'];
		$service = new Service();
		$result = $service->getJoueurParties("$licence");
		$lignes = count($result);
		$fftt = ping_admin_ops::compte_fftt($licence);
		//var_dump($result);
		//le service est-il ouvert ?
		/**/
		//on teste le resultat retourné     

			if(!is_array($result))
			{
				$message = "Service coupé"; 
				$status = 'Echec';
				$designation = $message;
				$action = "mass_action";
				ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
			}
			elseif($lignes <= $fftt)
			{
				$message = "Parties FFTT à jour pour ".$player." : ".$fftt." en base de données ".$lignes." en ligne."; 
				$status = 'Echec';
				$designation = $message;
				$action = "mass_action";
				ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
				$aujourdhui = date('Y-m-d');
				$query = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET maj_fftt = ? WHERE licence = ? AND saison = ?";
				$dbresult4 = $db->Execute($query, array($aujourdhui,$licence,$saison_courante));
				
				
			}
			else
			{	
				$i = 0;
				$compteur = 0;
				foreach($result as $cle =>$tab)
				{

					$compteur++;

					
					$licence = $tab[licence];
					$advlic = $tab[advlic];
					$vd = $tab[vd];

						if ($vd =='V'){
							$vd = 1;
						}
						else 
						{
							$vd = 0;
						}
					$numjourn = $tab[numjourn];
					
						if(is_array($numjourn))
						{
							$numjourn = '0';
						}
						
					$codechamp = $tab[codechamp];
					$dateevent = $tab[date];
					$chgt = explode("/",$dateevent);
					$date_event = $chgt[2]."-".$chgt[1]."-".$chgt[0];
					/*
						if (substr($chgt[1], 0,1)==0)
						{
							$mois_event = substr($chgt[1], 1,1);
								//echo "la date est".$date_event;
						}
						else
						{
							$mois_event = $chgt[1];
						}
					*/	
					$advsexe = $tab[advsexe];
					$advnompre = $tab[advnompre];
					$pointres = $tab[pointres];
					$coefchamp = $tab[coefchamp];					
					$advclaof = $tab[advclaof];					
					
					$query = "SELECT licence,advlic, numjourn, codechamp, date_event, coefchamp FROM ".cms_db_prefix()."module_ping_parties WHERE licence = ? AND advlic = ? AND numjourn = ? AND codechamp = ? AND date_event = ? AND coefchamp = ?";
					//echo $query;
					$dbresult = $db->Execute($query, array($licence, $advlic, $numjourn, $codechamp, $date_event, $coefchamp));

					if($dbresult  && $dbresult->RecordCount() == 0) {
						$query = "INSERT INTO ".cms_db_prefix()."module_ping_parties (id, saison, licence, advlic, vd, numjourn, codechamp, date_event, advsexe, advnompre, pointres, coefchamp, advclaof) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
						$i++;
						//echo $query;
						$dbresultat = $db->Execute($query,array($saison_courante,$licence, $advlic, $vd, $numjourn, $codechamp, $date_event, $advsexe, $advnompre, $pointres, $coefchamp, $advclaof));

						if(!$dbresultat)
							{
								$message = $db->ErrorMsg(); 
								$status = 'Echec';
								$designation = $message;
								$action = "mass_action";
								ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
							}


					}//fin du if recordCount() ligne 244

				}//fin du foreach
				
				$comptage = $i;
				$query4 = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET maj_fftt = ?,fftt = ? WHERE licence = ? AND saison = ?";
				$dbresult4 = $db->Execute($query4, array($aujourdhui,$comptage,$licence,$saison_courante));
				
				$status = 'Parties FFTT';
				$designation .= "Récupération FFTT de ".$comptage." parties sur ".$compteur."  de ".$player;
				$action = "mass_action";
				ping_admin_ops::ecrirejournal($now,$status, $designation,$action);

			}//fin du if !is_array
		}//fin du while

	}//fin du if dbretour >0









  }//fin de la fonction

public static function erase_spid ( $id, $coeff_fftt, $numjourn_fftt, $points_fftt)
{
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_ping_parties_spid SET numjourn = ?, coeff = ?, pointres = ? WHERE id = ?";
	$db->Execute($query, array($numjourn_fftt, $coeff_fftt,$pointres_fftt));
}

public static function delete_journal($journalid)
  {
    $db = cmsms()->GetDb();

    //Now remove the entry
    $query = "DELETE FROM ".cms_db_prefix()."module_ping_recup WHERE id = ?";
    $db->Execute($query, array($journalid));

    
  }


} // end of class

#
# EOF
#
?>
