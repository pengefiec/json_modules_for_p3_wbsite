<?php
//set_include_path('system'.PATH_SEPARATOR.'templates');

//require_once('Template.php');
//require_once('RedirectBrowserException.php');
//require_once('DatabaseUtility.php');
//require_once('CustomFunctions.php');
//require_once('session.php');
//$tmpl = new Template();



//json stuff
$carrier=$_POST['json_protein'];
$de_carrier=json_decode($carrier,true);
$protein=$de_carrier["protein"]["input"];
//print_r($origin);
//$id = $_GET['id'];
$id =1;//***faked***
//$ref = $_GET['ref'];

$ref=2;//***faked***
//openDatabase();
//$query='SELECT annotation,symbol,sequence,latin,commonName FROM protein,organism WHERE protein.id = \''.$id.'\' AND protein.organism=organism.label;';
//$rows = runQuery($query);
//$rows=$modulesRows["module_1"];
/*$rows=array(array(
"annotation"=>"annotationSample",
"latin"=>"latinSample",
"commonName"=>"commonNameSample",
"sequence"=>"sequenceSample"
));*/
// query database for phosphorylation sites in this protein
//$query  = "SELECT id, locationInProtein FROM site WHERE protein = $id AND ptm='p'";
//if (!empty($ref)) {
	//$query .= " AND EXISTS (SELECT * FROM mass,peptide,peptideSiteRelation WHERE mass.dataSource=$ref AND mass.id=peptide.mass AND peptideSiteRelation.peptide=peptide.id AND peptideSiteRelation.site=site.id)";
//}
//$rows2 = runQuery($query);
//$rows2 = $modulesRows["module_3"];
/*$rows2 = array(
array("locationInProtein"=>1, "id"=>1)
);*/
/*$sites = array();
foreach($rows2 as $row) {
	$sites[$row['locationInProtein']] = $row['id'];
}
ksort($sites);

// query dataSource
//$query = "SELECT id,reference,Level FROM dataSource,proteinDataSourceRelation WHERE protein='$id' AND dataSource=id ORDER BY pubmed DESC";
//$rows3 = runQuery($query);
$rows3=array(array("id"=>1,"reference"=>"referenceSample","Level"=>0));
$levelFlag=true;
foreach($rows3 as $row) {
	$dataSource[$row['id']] = $row['reference'];
}
if (count($dataSource)>1) {
	$dataSource[0] = "All";
	ksort($dataSource);
}
*/
// reference links
//$refLink = '';
//$refs = array();
//$query ="SELECT id,link,reference FROM dataSource ORDER BY pubmed DESC;";
//$result = runQuery($query);
/*$result=array(array("id"=>1,"reference"=>"referenceSample", "link"=>"google.com"));
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
*/
//$mass = spectralOfProtein($id, $ref);
//$mass=array(1=>1);
//comments and replies
/*$commentPageId = encrypt(json_encode(array("targetID"=>$id,"targetDescript"=>"protein.php")));
$commentID = isset($_GET['commentID']) ? check(decrypt($_GET['commentID'])) : '0';
$query = "SELECT COUNT(*) AS count FROM ptm_usr_Comment 
		//WHERE  CommentID < '".$commentID."' AND TargetID = '".$id."' AND TargetDescript='protein.php';";
$result = runQuery($query);
$result=array(array("count"=>1));
$commentDisplayStart = $result[0]['count'];
$comments = getComment($id, "protein.php");
$replies = array();
foreach ($comments as $row)
{
	$replyTo = $row['CommentID'];
	$replies[$replyTo]= getReply($replyTo, $id, "protein.php");
}
if (isset($_POST['submit']))
{
	$commentMessage=$_POST['commentMessage'];
	if (!isset($_POST['replyTo']))
		$replyTo=null;
	else
		$replyTo=$_POST['replyTo'];
	addComment($_SESSION['name'],$commentMessage, $id, "protein.php", $replyTo);
	unset($_POST['submit']);
}*/

//$ppi = getPPI($id);
//$ppi=array(array("interactor_a"=>"SAMPLE001","interactor_b"=>"SAMPLE002","experimental_system"=>"SAMPLE_EXP","source"=>"SAMPLE_SOURCE","pubmed_ID"=>00000001));

//$kinases = getKinaseByProtein($id);
//$kinases=array(array("kinase"=>"SAMMPLEKINASE"));
//$ontology = getOntologyByProtein($id);
//$ontology=array(array("ontologyID"=>"SAMPLE_ID","name"=>"SAMPLE_NAME","def"=>"SAMPLE_DEF","synonym"=>"SAMPLE_SYNONYM","xref"=>"SAMPLE_XREF" ));
//$domains = getDomainByProtein($id);
//$domains=array(array("domainID"=>1,"applicationName"=>"SAMPLE_APPLICATIONNAME","domainDescription"=>"SAMPLE_DOMAINDESCRIPTION","matchStart"=>"SAMPLE_MATCHSTART","matchEnd"=>"SAMPLE_MATCHEND"));
//$tmpl->id 			= $id;
//$tmpl->ref			= $ref;
//$tmpl->refLink		= $refLink;
//$tmpl->sites 		= $sites;
//$tmpl->dataSource 	= $dataSource;
//$accessions 	= getXrefLink($id);
//$link="link";
//$type="type";
//$accessions=array(0=>"<a href=\"$link\" title=\"Click to go to $type\" target=\"_blank\">SAMPLETYPE_SAMPLEACC</a>");
//$description 	= $rows[0]['annotation'];
//$organism 	= '<i>'.$rows[0]['latin'].'</i> ('.$rows[0]['commonName'].')';
//$numSites 	= count($sites);
//$numSpectra 	= count($mass);
//$sequence 	= $rows[0]['sequence'];
//$tmpl->comments		= $comments;
//$tmpl->replies		= $replies;
//$tmpl->ppi			= $ppi;
//$tmpl->kinases		= $kinases;
//$tmpl->ontology		= $ontology;
//$tmpl->domains		= $domains;
//$tmpl->commentPageId= $commentPageId;
//$comment      = $tmpl->build('comment.tmpl');
//$commentDisplayStart = $commentDisplayStart;
//closeDatabase();

$current = 'browse';
//$username=$_SESSION['name'];
//$level=$_SESSION['level'];

//if ($levelFlag)
	//$tmpl->pageContent = $tmpl->build('protein.tmpl');
//else
	//$tmpl->pageContent = $tmpl->build('accessDenied.tmpl');
//print $tmpl->build('page.tmpl');
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
	    //obj.style.width = obj.contentWindow.document.body.scrollWidth + 'px';
		obj.style.width ='1100px';
	  }
	</script>



</head><body class="metro">
<form id="site" method="POST" action="phosphosite.php">
<input type="hidden" name="json_site" value=''>
<input type="hidden" name="action">
</form>
<div id="main_wrapper container" class="page secondary grid" style="margin:auto;width:900px;">
	<div id="form_container" style="display:none">
		<div class='loading_dialog'>
			
			<span> Loading</span>
		</div>
	</div>
	<div id="load_container" style="display:none" >
		<div class="loading_dialog">
			
			<span> Processing</span>
		</div>
	</div>
	
	<div class="page-header-content">
                <h1>Protein</h1>
                
     </div>
		<div id="content_wrapper">
			
			
			
			
				
			<?php
			$c=1;
			while(current($protein)){
			//$rows=current($protein);//sent the module's owe data.
			

			$module="p_m".key($protein)."/"."p_m".key($protein).".php";
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
			next($protein);

			}
			//$rows=current($protein);
			//require_once("p_m1/p_m1.php");
			//require_once("p_m1.php");
			
			?>
			
			

			<br />


<div id="JmolPane" class="JmolPanels">
	<div id="Jmol0" class="JmolDiv"></div>
</div>


			
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