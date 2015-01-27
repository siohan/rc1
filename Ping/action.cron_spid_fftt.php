<?php
#############################################################
###          Vérification entre Spid et FFTT              ###
#############################################################
if(!isset($gCms)) exit;
$db =& $this->GetDb();
global $themeObject;

require_once(dirname(__FILE__).'/include/prefs.php');
$designation = '';
//$query = "SEL";
$query = "SELECT sp.id,p.date_event,sp.licence as licence_spid, p.licence as licence_fftt,sp.nom as nom_spid, p.advnompre AS nom_fftt, sp.numjourn AS numjourn_spid, p.numjourn AS numjourn_fftt, sp.victoire AS victoire_spid, p.vd AS victoire_fftt, sp.coeff AS coeff_spid, p.coefchamp AS coeff_fftt, sp.pointres AS points_spid, p.pointres AS points_fftt FROM ".cms_db_prefix()."module_ping_parties_spid AS sp, ".cms_db_prefix()."module_ping_parties AS p WHERE sp.licence = p.licence AND sp.nom = p.advnompre AND sp.date_event = p.date_event AND sp.saison = ? AND (sp.pointres !=p.pointres) ORDER BY sp.id DESC";
//echo $query;
$dbresult = $db->Execute($query, array($saison_courante));
//$row = $dbresult->FetchRow();
$lic = array();
//$lic = $row[0]['licence'];
//echo "La valeur est : ".$lic;
$lignes = $dbresult->RecordCount();
for($i=0;$i<=$lignes;$i++)
{
	//array_push($lic,$row[$i]['id'], $row[$i]['numjourn_fftt']);
	//array_push($lic[$i],array($row['id'], $row['numjourn_fftt']));
	//$licen = substr(implode(", ", $lic), 0, -3);
}

//var_dump($dbresult);

/**/

$rowarray = array();
$i = 0;
	if($dbresult && $dbresult->RecordCount()>0)
	{
		while($row = $dbresult->FetchRow())
		{
			
			$record_id = $row['id'];
			$numjourn = $row['numjourn_fftt'];
			$coefchamp = $row['coeff_fftt'];
			$pointres = $row['points_fftt'];
			$vd = $row['victoire_fftt'];
			
			$query2 = "UPDATE ".cms_db_prefix()."module_ping_parties_spid SET numjourn = ?, coeff = ?, pointres = ?, victoire = ? WHERE id = ?";
			//echo $query2;
			$dbresultat = $db->Execute($query2, array($numjourn, $coefchamp,$pointres,$vd, $record_id));
			$i++;
				if(!$dbresultat)
				{
					$designation.= $db->ErrorMsg();

				}
		}
		
		$designation.="Rectification de ".$i." partie(s)";
		$this->SetMessage("$designation");
		$this->RedirectToAdminTab('spid');
		
	}
	else
	{
		$designation.="Pas de résultats à modifier";
	}
$this->SetMessage("$designation");
$this->RedirectToAdminTab('spid');
/**/	

#EOF
#
?>