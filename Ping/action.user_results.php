<?php
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
$db =& $this->GetDb();
//global $themeObject;
require_once(dirname(__FILE__).'/include/prefs.php');
$licence = '';

	if(!isset($params['licence']) && $params['licence'] =='' )
	{
		echo "Un problème est apparu !";
		
	}
	else
	{
		$licence = $params['licence'];
	

$smarty->assign('phase2',
		$this->CreateLink($id,'user_results',$returnid, 'Phase 2', array("phase"=>"2","licence"=>$licence) ));
$smarty->assign('phase1',
		$this->CreateLink($id,'user_results',$returnid, 'Phase 1', array("phase"=>"1","licence"=>$licence) ));
		
$rowarray1 = array();
$query = "SELECT SUM(victoire) AS vic, count(victoire) AS total, SUM(pointres) AS pts FROM ".cms_db_prefix()."module_ping_parties_spid WHERE saison = ? AND licence = ?";
//on presente phase par phase ?

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

$dbresult = $db->Execute($query, array($saison_courante, $licence));

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
$query= "SELECT * FROM ".cms_db_prefix()."module_ping_parties_spid WHERE licence = ? AND saison = ?";//" ORDER BY date_event ASC";
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

$dbresult = $db->Execute($query, array($saison_courante, $licence));

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
	}//echo $query;
//On met un ordre particulier ou pas ?
$query.=" ORDER BY date_event DESC";
$dbresult= $db->Execute($query, array($licence, $saison_courante));

$rowarray= array ();

if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
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

}//fin du else (if $licence isset)
/*
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
*/
$smarty->assign('items', $rowarray);

echo $this->ProcessTemplate('user_results.tpl');


#
# EOF
#
?>