<?php
#################################################################################
###           RECUPERATION DES PARTIES SPID                                   ###
#################################################################################
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/include/prefs.php');
require_once(dirname(__FILE__).'/function.calculs.php');
$now = trim($db->DBTimeStamp(time()), "'");
$error = 0;

$licence = $params['licence'];
$designation = '';
$query = "SELECT CONCAT_WS(' ', nom, prenom) AS player FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";
$dbretour = $db->Execute($query, array($licence));
if ($dbretour && $dbretour->RecordCount() > 0)
  {
    while ($row= $dbretour->FetchRow())
      {
	$player = $row['player'];
	//return $player;
	}
	
}
else{
	$designation.="Joueur introuvable";
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('joueurs');
}

$service = new Service();
$result = $service->getJoueurPartiesSpid("$licence");
//var_dump($result);
//le service est-il ouvert ?
/**/
//on teste le resultat retourné     
$lignes = count($result);//on compte le nb d'éléments du tableau
//on compte le nb de résultats du spid présent ds la bdd pour le joueur
$spid = ping_admin_ops::compte_spid($licence);

//var_dump($spid);


if(!is_array($result) || count($result)>0 ){
	
	
		$this->SetMessage('Le service est coupé');
		$this->RedirectToAdminTab('recuperation');	
}
elseif($lignes <=$spid)
{
	$designation.="Parties spid à jour : ". $spid ." parties en base et ". $lignes ." en ligne";
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('recuperation');
}
else
{
	//on teste un truc de guedin
	//on supprime tous les enregistrements concernant le joueur ds la base de données pour les remplacer par les nouvelles
	$query1 = "DELETE FROM ".cms_db_prefix()."module_ping_parties_spid WHERE saison = ? AND licence = ?";
	$dbresult1 = $db->Execute($query1, array($saison_courante, $licence));
	
	$i = 0;
	$compteur = 0;
	foreach($result as $cle =>$tab)
	{
		$compteur++;
	
		$dateevent = $tab[date];
		$chgt = explode("/",$dateevent);
		$date_event = $chgt[2]."-".$chgt[1]."-".$chgt[0];
		$annee = '20'.$chgt[2];
		//on extrait le mois pour retrouver la situation mensuelle
			if (substr($chgt[1], 0,1)==0){
				$mois_event = substr($chgt[1], 1,1);
				//echo "la date est".$date_event;
			}
			else
			{
				$mois_event = $chgt[1];
			}
		
		$nom = $tab[nom];
		//on adapte son nom d'abord
		$nom_global = get_name($nom);//une fonction qui permet d'extraire le nom et le prénom
		$nom_reel = $nom_global[0];//le nom
		$prenom_reel = $nom_global[1];//le prénom
		//on va prendre 
		//echo $nom_reel. ' '.$prenom_reel.'<br />';
		$classement = $tab[classement];
		$cla = substr($classement, 0,1);

			
		//Avec le nom on va aller chercher la situation mensuelle de l'adversaire
		//on pourra la stocker pour qu'elle re-serve et l'utiliser pour affiner le calcul des points
		//d'abord on va chercher ds la bdd si l'adversaire y est déjà pour le mois et la saison en question
		$query4 = "SELECT points FROM ".cms_db_prefix()."module_ping_adversaires WHERE nom = ? AND prenom = ? AND mois = ? AND annee = ?";
		//echo $query4.'<br />';
		$dbresult4 = $db->Execute($query4, array($nom_reel,$prenom_reel,$mois_event,$annee));
		
			if($dbresult4 && $dbresult4->RecordCount()>0)//ok on a un enregistrement qui correspond
			{
				$row4 = $dbresult4->FetchRow();
				$newclass = $row4['points'];
			}
			//deuxième cas : 
			//on n'a pas d'enregistrement et on est dans le mois courant et l'année courante : on va chercher les points avec la classe pour ensuite l'insérer ds la bdd
			elseif($dbresult4->RecordCount()==0 && $mois_event == date('n') && $annee = date('y'))
			{
				//on va chercher la sit mens du pongiste
				
				
				$service = new Service();
				$resultat = $service->getJoueursByName("$nom_reel", $prenom ="$prenom_reel");
				//var_dump($resultat);
				if(is_array($resultat) && count($resultat)>0 )
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
						
							//on insère le tout dans la bdd
							$query5 = "INSERT INTO ".cms_db_prefix()."module_ping_adversaires (id,datecreated, datemaj, mois, annee, phase, licence, nom, prenom, points, clnat, rangreg,rangdep, progmois) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
							//echo $query5;
							$dbresultat5 = $db->Execute($query5,array($now,$now,$mois_courant, $annee_courante, $phase, $licence2, $nom, $prenom, $point, $clnat, $rangreg, $rangdep, $progmois));
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
		$query = "SELECT points FROM ".cms_db_prefix()."module_ping_sit_mens WHERE licence = ? AND mois = ?";//" AND saison = ?";
		$dbresult = $db->Execute($query, array($licence,$mois_event));
		
			if ($dbresult && $dbresult->RecordCount() == 0)
			{
				$designation.="Ecart non calculé";
				$ecart = 0;
			}
			
		$row = $dbresult->FetchRow();
		$points = $row[points];
		$ecart_reel = $points - $newclass;
		//on calcule l'écart selon la grille de points de la FFTT
		$type_ecart = CalculEcart($ecart_reel);
		$epreuve = $tab[epreuve];
		
		// de quelle compétition s'agit-il ? 
		//On a la date et le type d'épreuve
		//on peut donc en déduire le tour via le calendrier
		//et le coefficient pour calculer les points via la table type_competitons
		
		//1 - on récupére le tour s'il existe
		//on va fdonc chercher dans la table calendrier
		$query = "SELECT DISTINCT numjourn FROM ".cms_db_prefix()."module_ping_calendrier WHERE name = ? date_debut = ? OR date_fin = ?";
		$resultat = $db->Execute($query, array($epreuve,$date_event, $date_event));
		
			if ($resultat && $resultat->RecordCount()>0){
				$row = $resultat->FetchRow();
				$numjourn = $row['numjourn'];
			}
			else
			{
				$numjourn = 0;
			}
		
		//2 - on récupère le coefficient de la compétition
		//Attention au critérium fédéral !!
		
			if($epreuve == 'Critérium fédéral')
			{
				//on va cherche rle bon coeff !!
			
				$query2 = "SELECT type_compet, coefficient FROM ".cms_db_prefix()."module_ping_participe AS p, ".cms_db_prefix()."module_ping_type_competitions AS tc WHERE p.type_compet = tc.code_compet AND p.licence = ?";
				$dbresultat2 = $db->Execute($query2,array($licence));
				
				if ($dbresultat2 && $dbresultat2->RecordCount()>0)
				{
					$row2 = $dbresultat2->FetchRow();
					$coeff = $row2['coefficient'];
					//on a le type de compet, on peut chercher
				}
				
			}
			else
			{
				$coeff = coeff($epreuve);
			}
		
		
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
		 $points1 = CalculPointsIndivs($type_ecart, $victoire);
		//echo "le coeff est : ".$coeff."<br />";
		//echo "le type ecart est : ".$type_ecart."<br />";
		//echo "les points 1 sont : ".$points1."<br />";
		$pointres = $points1*$coeff; 
		$forfait = $tab[forfait];
	
//on autorise les doublons ?
	
		
			$query2 = "INSERT INTO ".cms_db_prefix()."module_ping_parties_spid (id, saison, datemaj, licence, date_event, epreuve, nom, numjourn,classement, victoire,ecart,type_ecart, coeff, pointres, forfait) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			
			//echo $query;
			$dbresultat = $db->Execute($query2,array($saison_courante,$now, $licence, $date_event, $epreuve, $nom, $numjourn, $newclass,$victoire,$ecart_reel,$type_ecart, $coeff,$pointres, $forfait));
			$i++;
			if(!$dbresultat)
				{
					$designation.="Erreur query2 ";
					$designation.=$db->ErrorMsg(); 
					$error++;
				}
			}
			
		
	
$comptage = $i;
$status = 'Parties SPID';
$designation .= "Récupération spid de ".$comptage." parties sur ".$compteur."  de ".$player;
$query = "INSERT INTO ".cms_db_prefix()."module_ping_recup (id, datecreated, status, designation, action) VALUES ('', ?, ?, ?, ?)";
$action = "retrieve_parties_spid";
$dbresult = $db->Execute($query, array($now, $status,$designation,$action));

	if(!$dbresult)
	{
		$designation.= $db->ErrorMsg(); 
	}
	
	if($compteur >0)
	{
	$query = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET spid = ? WHERE licence = ? AND saison = ?";
	$dbresult = $db->Execute($query, array($compteur,$licence,$saison_courante));
	
		if(!$dbresult)
		{
			$designation.= $db->ErrorMsg(); 
	
		}
	}	
//	$this->SetMessage("$designation");
//	$this->RedirectToAdminTab('recup');

	}



#
# EOF
#
?>