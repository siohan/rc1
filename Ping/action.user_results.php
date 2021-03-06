<?php
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
$db =& $this->GetDb();
//global $themeObject;
require_once(dirname(__FILE__).'/include/prefs.php');
$licence = '';
$date_event = '';
$affiche = 1;

	if(!isset($params['licence']) && $params['licence'] =='' )
	{
		echo "la licence est absente !";
		
	}
	else
	{
		$licence = $params['licence'];
		
		//si une date est précisée alors on affiche que les résultats de cette date
		if(isset($params['date_debut']) && $params['date_debut'] !='')
		{
			//on va alors cacher certains éléments de la page
			$affiche = 0;
			$date_debut = $params['date_debut'];
			$date_fin = $params['date_fin'];
		}
		if($affiche ==1)
		{
			$smarty->assign('phase2',
					$this->CreateLink($id,'user_results',$returnid, 'Phase 2', array("phase"=>"2","licence"=>$licence) ));
			$smarty->assign('phase1',
					$this->CreateLink($id,'user_results',$returnid, 'Phase 1', array("phase"=>"1","licence"=>$licence) ));
		}
		if(isset($params['month']) && $params['month'] !='')
		{
			$affiche = 0;
			$ok = 1;
			$month = $params['month'];
		}
		
		$rowarray1 = array();
		$query = "SELECT SUM(victoire) AS vic, count(victoire) AS total, SUM(pointres) AS pts FROM ".cms_db_prefix()."module_ping_parties_spid WHERE saison = ? AND licence = ?";
		//qqs paramètres
		$parms['saison'] = $saison_courante;
		$parms['licence'] = $licence;
		//on presente phase par phase ?
		if($affiche ==1)
		{
			if($this->GetPreference('phase_en_cours') =='1' )
			{
				if($params['phase'] ==2)
				{
					$query.= " AND MONTH(date_event) >= 1 AND MONTH(date_event) <=7"; 
				}
				else
				{
					$query.= " AND MONTH(date_event) > 7 AND MONTH(date_event) <=12";  ////BETWEEN NOW() AND (NOW() + INTERVAL 7 DAY)";
				}
			}
			elseif( $this->GetPreference('phase_en_cours') == '2')
			{
				if($params['phase'] ==1)
				{
					$query.= " AND MONTH(date_event) > 7 AND MONTH(date_event) <=12";  ////BETWEEN NOW() AND (NOW() + INTERVAL 7 DAY)";
				}
				else
				{
					$query.= " AND MONTH(date_event) >= 1 AND MONTH(date_event) <=7";  ////BETWEEN NOW() AND (NOW() + INTERVAL 7 DAY)";	
				}
			}
		}
		elseif($ok =='1')
		{
			$query.=" AND MONTH(date_event) = ?";
			$parms['month'] = $month;
		}
		

		$dbresult = $db->Execute($query, $parms);

			if($dbresult && $dbresult->RecordCount()>0)
			{
				while($row1 = $dbresult->FetchRow())
				{
					$onerow1= new StdClass();
					$onerow1->rowclass= $rowclass;
					$onerow1->vic= $row1['vic'];
					$onerow1->total= $row1['total'];
					$onerow1->pts= $row1['pts'];
					($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
					$rowarray1[]= $onerow1;
				}
			}
		$smarty->assign('items1', $rowarray1);


		$query1 = "SELECT CONCAT_WS(' ', nom, prenom) AS joueur FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";


		$dbresultat = $db->Execute($query1, array($licence));
		$row1 = $dbresultat->FetchRow();
		$joueur = $row1['joueur'];
		$smarty->assign('joueur', $joueur);
		$result= array ();
		$query3= "SELECT * FROM ".cms_db_prefix()."module_ping_parties_spid WHERE licence = ? AND saison = ?";//" ORDER BY date_event ASC";
		if($affiche =='1')
		{
			if($this->GetPreference('phase_en_cours') =='1' )
			{
				if($params['phase'] ==2)
				{
					$query3.= " AND MONTH(date_event) >= 1 AND MONTH(date_event) <=7"; 
				}
				else
				{
					$query3.= " AND MONTH(date_event) > 7 AND MONTH(date_event) <=12";  ////BETWEEN NOW() AND (NOW() + INTERVAL 7 DAY)";
				}
			}
			elseif( $this->GetPreference('phase_en_cours') == '2')
			{
				if($params['phase'] ==1)
				{
					$query3.= " AND MONTH(date_event) > 7 AND MONTH(date_event) <=12";  ////BETWEEN NOW() AND (NOW() + INTERVAL 7 DAY)";
				}
				else
				{
					$query3.= " AND MONTH(date_event) >= 1 AND MONTH(date_event) <=7";  ////BETWEEN NOW() AND (NOW() + INTERVAL 7 DAY)";	
				}
			}
		}
		elseif($affiche =='0')
		{
			if($ok=='1')
			{
				$query3.=" AND MONTH(date_event) = ?";
				$query3.=" ORDER BY date_event DESC";
				$dbresult3 = $db->Execute($query3, array($licence, $saison_courante,$month));
			}
			else
			{
				$query3.=" AND date_event BETWEEN ? AND ?";
				$query3.=" ORDER BY date_event DESC";
				$dbresult3 = $db->Execute($query3, array($licence, $saison_courante,$date_debut,$date_fin));
			}
		}
		
		else
		{
			$query3.=" ORDER BY date_event DESC";
			$dbresult3 = $db->Execute($query3, array($saison_courante, $licence));
		}
		
		//$dbresult = $db->Execute($query, array($saison_courante, $licence));
		/*
			if($dbresult3 && $dbresult3->RecordCount()>0)
			{
				while($row1 = $dbresult3->FetchRow())
				{
					$onerow1= new StdClass();
					$onerow1->rowclass= $rowclass;
					$onerow1->vic= $row1['vic'];
					$onerow1->total= $row1['total'];
					$onerow1->pts= $row1['pts'];
			
					($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
					$rowarray1[]= $onerow1;
				}
			}//echo $query;
		*/
		/*
		if($affiche ==1)
		{
			//On met un ordre particulier ou pas ?
			$query3.=" ORDER BY date_event DESC";
			$dbresult3= $db->Execute($query3, array($licence, $saison_courante));
		}
		else
		{
			$dbresult3= $db->Execute($query3, array($licence, $saison_courante,$date_debut, $date_fin));
		}
		*/
		$rowarray= array ();

		if ($dbresult3 && $dbresult3->RecordCount() > 0)
		  {
		    while ($row= $dbresult3->FetchRow())
		      {
	
			$onerow= new StdClass();
			$onerow->rowclass= $rowclass;
			$onerow->date_event= $row['date_event'];
			$onerow->epreuve= $row['epreuve'];
			$onerow->nom= $row['nom'];
			$onerow->classement= $row['classement'];
			$onerow->victoire= $row['victoire'];
			$onerow->coeff= $row['coeff'];
			$onerow->pointres= $row['pointres'];
			$rowarray[]= $onerow;
		      }
		  }
		$smarty->assign('resultats',
				$this->CreateLink($id,'user_results',$returnid,$contents = 'Tous ses résultats', array('licence'=>$licence)));
	}//fin du else (if $licence isset)

$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('ok',$ok)
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('retour',
 		$this->CreateReturnLink($id, $returnid,'Retour'));
$smarty->assign('items', $rowarray);
$smarty->assign('affiche',$affiche);
/*
$smarty->assign('resultats',
		$this->CreateLink($id,'user_results',$returnid, array('licence'=>$licence)));
*/
echo $this->ProcessTemplate('user_results.tpl');


#
# EOF
#
?>