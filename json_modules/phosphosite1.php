<?php
//set_include_path('system'.PATH_SEPARATOR.'templates');

//require_once('Template.php');
//require_once('RedirectBrowserException.php');
//require_once('DatabaseUtility.php');
//require_once('session.php');
//require_once('CustomFunctions.php');

//$tmpl = new Template();

$phosphosite_id = $_GET['id'];
$ref = $_GET['ref'];

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

foreach($nrPeptideRows as $row) {
	$nrseq = $row['phosphoSequence'];
	$linkformat = str_replace('#', '%23', $nrseq);
	$formated = format_nr_pep_unlink_exclusiveself($nrseq,$row['locationInPeptide']);
	$href = 'href="peptide.php?pnrseq='.$linkformat.'&pro='.$id.'&loc='.$row['location'].$getref.'"';
	$peptides[$formated] = $href;
}

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
$numSites 	= count($sites);
$numSpectra 	= count($mass);
$sequence 	= $rows[0]['sequence'];
//$tmpl->commentPageId= $commentPageId;
//$tmpl->comment      = $tmpl->build('comment.tmpl');
//closeDatabase();

$current = 'browse';
//$tmpl->pageContent = $tmpl->build('phosphosite.tmpl');

function format_nr_pep_unlink_exclusiveself($nrpseq,$exsite) {
        $seq = "";
        $seqpep = str_replace('#', '', $nrpseq);

        $start = 0;

        $sites = getSiteFromNrPep($nrpseq);
        foreach($sites as $site) {
                if ($site == $exsite) {
                        $sbst = '<span class="ui-corner-all phosphosite highlight">'.substr($seqpep,$site,1).'</span>';
                } else {
                        $sbst = '<span class="ui-corner-all phosphosite">'.substr($seqpep,$site,1).'</span>';
                }
                $seq = $seq.substr($seqpep,$start,$site-$start).$sbst;
                $start = $site + 1;
        }
        $seq = $seq.substr($seqpep,$start);

        return $seq;
}

function getSiteFromNrPep($nrpseq) {
    $curr = strpos($nrpseq, '#');
    while ($curr) {
    	$sites[] = $curr - count($sites) - 1;
    	$curr = strpos($nrpseq, '#', $curr+1);
    }
    return $sites;
}
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
			

			
<h3>Phosphorylation Site</h3>
<table border="0">
<tr>
	<td class="txt_bold txt_align_top">Protein: </td>
	<td colspan="2"><a class="button" href="<?php print $protLink; ?>">Details</a></td>
</tr>
<tr>
	<td class="txt_bold txt_align_top">Description: </td>
	<td colspan="2"><?php print $description; ?></td>
</tr>
<tr>
	<td class="txt_bold txt_align_top">Organism: </td>
	<td colspan="2"><?php print $organism; ?></td>
</tr>
<tr>
	<td class="txt_bold txt_align_top">Position: </td>
	<td colspan="2"><?php print $loc; ?></td>
</tr>
<tr>
	<td class="txt_bold txt_align_top">Surrounding Sequence: </td>
	<td colspan="2"><span class="sequence"><?php print $surrSeq; ?></span></td>
</tr>
<tr>
	<td class="txt_bold txt_align_top">No. of Spectra: </td>
	<td colspan="2"><?php print $numSpectra; ?></td>
</tr>
<tr>
	<td class="txt_bold txt_align_top">Reference:</td>
	<td colspan="2"><?php 
	print '<form method="get" action="phosphosite.php" id="refForm">';
	print '<input name="id" type="hidden" id="id" value="'.$id.'" />';
	print '<div class="clear"><div class="css_left"><select name="ref" id="refSelect" size="1">';
	foreach($dataSource as $dsId => $dsRef) {
			print '<option value="'.$dsId.'"';
			if ($ref==$dsId) {
				print ' selected="selected"';
			}
			print '>'.$dsRef.'</option>';
	}
	print '</select></div>';
	if(!empty($refLink)) {
		print '&nbsp;<a href="'.$refLink.'" target="_blank" class="button" id="viewRef">View Reference</a>';
	}
	print '</div></form>';
	?></td>
</tr>
<tr>
	<td class="txt_bold txt_align_top">NR Peptides: </td>
	<td colspan="2">
	<div class="table_shrink clear">
		<table cellpadding="0" cellspacing="0" border="0" class="display simple_table">
			<thead>
				<tr>
					<th>NR Sequence</th><th>Peptide</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($peptides as $pepSeq => $href) {
					print '<tr>';
					print '<td><span class="sequence">'.$pepSeq.'</span></td>';
					print '<td class="center"><a class="button" '.$href.'>Details</a></td>';
					print '</tr>';
				}
				?>
			</tbody>
		</table>
	</div>
	</td>
</tr>
<tr>
	<td class="txt_bold txt_align_top">Accessions:</td>
	<td colspan="2">
	<table>
		<tr>
		<?php
			$count = 0;
			foreach($accessions as $accession) {
				print '<td><div class="clear"><span class="ui-icon ui-icon-bullet" style="float: left;"></span><div style="float: left; margin-right: .3em;">'.$accession.'&nbsp;</div></div></td>';
				$count++;
				if($count%2 == 0) print '</tr><tr>';
			}
			for($i=0; $i<$count%2; $i++){
				print '<td>&nbsp;</td>';
			}
		?>
		</tr>
	</table>
	</td>
</tr>
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