<?php
//set_include_path('system'.PATH_SEPARATOR.'templates');

//require_once('Template.php');
//require_once('RedirectBrowserException.php');
//require_once('DatabaseUtility.php');
//require_once('session.php');
//require_once('CustomFunctions.php');

//$tmpl = new Template();

//$phosphosite_id = $_GET['id'];
$phosphosite_id=1;//***faked***
//$ref = $_GET['ref'];
$ref=1;//***faked***
$carrier=$_POST['json_site'];
//print $carrier;
$de_carrier=json_decode($carrier,true);
//print_r($de_carrier);
$site=$de_carrier["site"]["input"];

$getref = "";
if (!empty($ref)) {
	$getref = '&ref='.$ref;
}

//openDatabase();
//$query  = "SELECT site.protein AS pid, protein.annotation, protein.sequence, organism.latin, organism.commonName, site.locationInProtein AS loc ".
          //"FROM site,protein,organism ".
          //"WHERE site.protein=protein.id AND protein.organism=organism.label AND site.ptm='p' AND site.id=".$phosphosite_id.";";
//$rows = runQuery($query);
$rows=array(array("pid"=>1,"annotation"=>"SAMPLE_ANNOTATION","sequence"=>"SAMPLE_SEQUENCE","latin"=>"SAMPLE_LATIN","commonName"=>"SMAPLE_COMMONNAME","loc"=>1));
$id = $rows[0]['pid'];

// query dataSource
//$query = "SELECT dataSource.id,dataSource.reference FROM dataSource,siteDataSourceRelation WHERE siteDataSourceRelation.site='".$phosphosite_id."' AND siteDataSourceRelation.dataSource=dataSource.id ORDER BY pubmed DESC";
//$datasourceRows = runQuery($query);

$datasourceRows=array(array("id"=>1,"reference"=>"SAMPLE_REFERENCE"));
foreach($datasourceRows as $row) {
	$dataSource[$row['id']] = $row['reference'];
}
if (count($dataSource)>1) {
	$dataSource[0] = "All";
	ksort($dataSource);
}

$loc = $rows[0]['loc'];
$sequence = $rows[0]['sequence'];
$start = 10*floor($loc/10)+1;
$end = 10*ceil($loc/10);
$surrSeq = substr($sequence,$start,$loc-$start).'<span class="ui-corner-all phosphosite">'.substr($sequence,$loc,1).'</span>'.substr($sequence,$loc+1,$end-$loc);

//$mass = spectralOfProtein($id, $ref);
$mass=array(1=>1);
/*
if (empty($ref)) {
	$query = "SELECT DISTINCT peptide.phosphoSequence, peptideSiteRelation.locationInPeptide, peptide.location ".
			 "FROM peptideSiteRelation,peptide ".
			 "WHERE peptideSiteRelation.site=$phosphosite_id AND peptideSiteRelation.peptide=peptide.id;";
} else {
	$query = "SELECT DISTINCT peptide.phosphoSequence, peptideSiteRelation.locationInPeptide, peptide.location ".
			 "FROM peptideSiteRelation,peptide,mass ".
			 "WHERE peptideSiteRelation.site=$phosphosite_id AND peptideSiteRelation.peptide=peptide.id AND peptide.mass=mass.id AND mass.dataSource=$ref;";
}
*/
$peptides = array();
//$nrPeptideRows = runQuery($query);
$nrPeptideRows=array(array("phosphoSequence"=>"SAMPLE_PHOSPHOSEQUENCE","locationInPeptide"=>1,"location"=>1));


// reference links
$refs = array();
$query ="SELECT id,link,reference FROM dataSource ORDER BY pubmed DESC;";
//$result = runQuery($query);
$result=array(array("id"=>1,"link"=>"SAMPLE_LINK"));
foreach($result as $row) {
	$refID = $row['id'];
	$link = $row['link'];
	if (empty($link)) {
			$refs[$refID] = $row['reference'];
	} else {
			$refs[$refID] = $link;
	}
}
if(!empty($ref)) $refLink = $refs[$ref];
else if (count($dataSource) == 1) {
	$refID = array_keys($dataSource);
	$refLink = $refs[$refID[0]];
}

//comments and replies
/*$commentPageId = encrypt(json_encode(array("targetID"=>$phosphosite_id,"targetDescript"=>"phosphosite.php")));
/$commentID = isset($_GET['commentID']) ? check(decrypt($_GET['commentID'])) : '0';
$query = "SELECT COUNT(*) AS count FROM ptm_usr_Comment 
		WHERE  CommentID < '".$commentID."' AND TargetID = '".$phosphosite_id."' AND TargetDescript='protein.php';";
$result = runQuery($query);
$commentDisplayStart = $result[0]['count'];
*/
//$tmpl->peptides		= $peptides;
$id 			= $phosphosite_id;
$ref			= $ref;
//$tmpl->refLink		= $refLink;
//$tmpl->surrSeq		= $surrSeq;
$loc 			= $loc + 1;
//$tmpl->dataSource 	= $dataSource;
$protLink		= 'protein.php?id='.$id.$getref;
//$accessions 	= getXrefLink($id);
$link="link";
$type="type";
$accessions=array(0=>"<a href=\"$link\" title=\"Click to go to $type\" target=\"_blank\">SAMPLETYPE_SAMPLEACC</a>");
$description 	= $rows[0]['annotation'];
$organism 	= '<i>'.$rows[0]['latin'].'</i> ('.$rows[0]['commonName'].')';
//$numSites 	= count($sites);
$numSpectra 	= count($mass);
$sequence 	= $rows[0]['sequence'];
//$tmpl->commentPageId= $commentPageId;
//$tmpl->comment      = $tmpl->build('comment.tmpl');
//closeDatabase();

$current = 'browse';
//$tmpl->pageContent = $tmpl->build('phosphosite.tmpl');


?>

<!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="P3DB: Plant Protein Phosphorylation DataBase">
	<meta name="keywords" content="P3DB, Plant, Protein, Phosphorylation, DataBase">
	<link type="text/css" href="Metro-UI-CSS-master/css/metro-bootstrap.css" rel="stylesheet" />
	<link type="text/css" href="Metro-UI-CSS-master/css/metro-bootstrap-responsive.css" rel="stylesheet" />
	<script language="javascript" type="text/javascript">
	  function resizeIframe(obj) {
	    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
	    obj.style.width = obj.contentWindow.document.body.scrollWidth + 'px';
	  }
	</script>
	<title>P3DB - Plant Protein Phosphorylation DataBase</title>
</head><body class="metro">
<form id="peptide" name="myform" method="POST" action="">
<input type="hidden" name="json_peptide" value=''>
<input type="hidden" name="action">
</form>
<div id="container">
	<div id="form_container" style="display:none">
	</div>
	<div id="load_container" style="display:none" >
		<div class="loading_dialog">
			<img src='img/loader-earth.gif' alt='Processing'/>
			<span> Processing</span>
		</div>
	</div>
	
		<div id="content_wrapper">
			

<div class="page-header-content">			
<h1>Phosphorylation Site</h1>
</div>
<table border="0">
<?php
	$c=1;
			while(current($site)){
			//$rows=current($protein);//sent the module's owe data.
			

			$module="s_m".key($site)."/"."s_m".key($site).".php";
			echo'<form id="iform'.$c.'" target="iframe'.$c.'" method="POST" action="'.$module.'">';
			//echo'<input type="hidden" name="json" value='.json_encode($rows).'>';
			echo'<input type="hidden" name="json" value='.$carrier.'>';
			echo'</form>';
			echo '<tr><td><iframe name="iframe'.$c.'" frameborder="0" scrolling="no" onload="javascript:resizeIframe(this);" ></iframe><td></tr>';
			echo'<script type="text/javascript">';
  		    echo'document.getElementById("iform'.$c.'").submit();';
			echo'</script>';
			++$c;
			//$rows=current($protein);
			//require_once($module);
			next($site);

			}
?>

</table>
			<div id="footer_wrapper">
				<div class="txt_center">
				
					<span class="separator txt_small">&copy; 2008-2013 <a href="http://www.missouri.edu">University of Missouri</a>.</span>
				</div>
				<div style="display:none">
					<a href="http://apycom.com/">Apycom jQuery Menus</a>
				</div>
			</div>
		</div>
	
	
</div>
</body></html>		