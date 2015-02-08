<?php
//set_include_path('system'.PATH_SEPARATOR.'templates');

//require_once('Template.php');
//require_once('RedirectBrowserException.php');
//require_once('DatabaseUtility.php');
//require_once('CustomFunctions.php');
//require_once("session.php");

//$tmpl = new Template();

$id = isset($_GET['id']) ? $_GET['id'] : '';
$pnrseq =  isset($_GET['pnrseq']) ? $_GET['pnrseq'] : '';
$pro = isset($_GET['pro']) ? $_GET['pro'] : '';
$loc = isset($_GET['loc']) ? $_GET['loc'] : '';
$ref = isset($_GET['ref']) ? $_GET['ref'] : '';

$getref = "";


//$queryDs = "SELECT reference,dataSource.id FROM peptide,mass,dataSource WHERE peptide.mass=mass.id AND mass.dataSource=dataSource.id AND ";
//$query = "SELECT peptide.id,peptide.location,peptide.sequence,mass.id as msid,mass.file,mass.scan,ISNULL(mass.mz) AS nullMass,dataSource.reference,dataSource.link,protein.id AS pid,protein.annotation,organism.latin,organism.commonName ".
	//"FROM peptide,mass,dataSource,protein,organism WHERE peptide.mass=mass.id AND peptide.protein=protein.id AND mass.dataSource=dataSource.id AND protein.organism=organism.label AND ";
/*
if(!empty($id)) {
	$q= 'peptide.id='.$id;
	$query .= $q;
	$queryDs .= $q;
} elseif (!empty($pnrseq)) {
	$q = "peptide.phosphoSequence='$pnrseq' AND peptide.protein=$pro AND peptide.location=$loc";
	$query .= $q;
	$queryDs .= $q;
} else {
	// TODO
	// Display error message Phosphosite information not available!
}
if (!empty($ref)) {
	$q = " AND mass.dataSource=$ref";
	$query .= $q;
	$getref = "&ref=$ref";
}*/
//openDatabase();

//$query .= " ORDER BY mass.id";

//$rows = runQuery($query);
//$rows=array(array("id"=>1,"location"=>1,"sequence"=>"SAMPLE_SEQUENCE","msid"=>1,"file"=>"SAMPLE_FILE","scan"=>"SAMPLESCAN","nullMass"=>true,"reference"=>"SAMPLE_REFERNECE","link"=>"SAMPLE_LINK","pid"=>1,"annotation"=>"SAMPLE_ANNOTATION","latin"=>"SAMPLE_LATIN","commonName"=>"COMMONNAME"));
$carrier=$_POST["json_peptide"];
echo $carrier;
$de_carrier=json_decode($carrier,true);
$rows=$de_carrier["peptide"]["input"];
//print_r($rows[0]);
if (!empty($rows[0])) {
	$seqpep = $rows[0]['sequence'];
	$seq = formatpep($seqpep,$rows[0]['id'],$getref, true);
	//$phosphosites = getptms($rows[0]['id']);
	$phosphosites=array(array("site"=>1,"ptm"=>"p","locationInPeptide"=>2,"locationInProtein"=>1));
	$org = $rows[0]['latin'].' ('.$rows[0]['commonName'].')';
	$loc = $rows[0]['location'];
}

$ms = array();
$params = array();
$headers = array();
foreach($rows as $row) {
	if (isset($row['scan'])) {
		$mshtml = "{$row['file']}.{$row['scan']}";
	} else {
		$mshtml = $row['msid'];
	}

	if ($row['nullMass']==0) {
		$mshtml = "<a href=\"spectrum/view_spectrum.php?msid={$row['msid']}&pep={$row['id']}\" target=\"_blank\">$mshtml</a>&nbsp;&nbsp;";
	}

	//array_push($ms,$row['msid']);
	$ms[$row['msid']] = $row['msid'];
	$msheader[$row['msid']] = $mshtml;

	$link = $row['link'];
	if (empty($link)) {
		$param['Reference'] = $row['reference'];
	} else {
		$param['Reference'] = "<a href=\"{$link}\" target=\"_blank\">{$row['reference']}</a>";
	}
	$headers['Reference'] = 1;

	//$query = "SELECT value,peptideParameterType.name FROM peptideParameter,peptideParameterType WHERE peptide='{$row['id']}' AND peptideParameter.parameter=peptideParameterType.id";
	//$res1 = runQuery($query);
	$res1=array(array("value"=>1,"name"=>"SAMPLE_NAME"));
	foreach($res1 as $row1) {
		$param[$row1['name']] = $row1['value'];
		$headers[$row1['name']] = 1;
	}

	$params[] = $param;
}

// query for datasources
//$result = runQuery($queryDs);
$result=array(array("reference"=>"SAMPLE_REFERENCE","id"=>1));
foreach($result as $row) {
	$dataSource[$row['id']] = $row['reference'];
}
if (count($dataSource)>1) {
	$dataSource[0] = "All";
	ksort($dataSource);
}

$i = 0;
$spectrumData = array();
foreach ($ms as $msid=>$mscount) {
	$spectrumData[] = array(
		'mp'		=> merge_params(array_slice($params, $i, $mscount)),
		'msid' 		=> $msid
	);
	$i += $mscount;
}

foreach($phosphosites as $row) {
	$sites[] = array(
		'locationInProtein' => $row['locationInProtein'], 
		'id' 				=> $row['site'], 
		'amino' 			=> substr(preg_replace('/[^a-zA-Z]/', '', $pnrseq), $row['locationInPeptide'], 1)
	);
}

// reference links
$refs = array();
//$query ="SELECT id,link,reference FROM dataSource ORDER BY pubmed DESC;";
//$result = runQuery($query);
$result=array(array("id"=>1,"link"=>"SAMPLE_LINK","reference"=>"SAMPLE_REFERENECE"));
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



//$tmpl->headers		= $headers;
//$tmpl->msheader		= $msheader;
//$tmpl->id			= $id;
//$tmpl->pnrseq		= $pnrseq;
//$tmpl->pro			= $pro;
//$tmpl->loc 			= $loc;
//$tmpl->spectrumData	= $spectrumData;
//$tmpl->sites		= $sites;
//$tmpl->ms			= $ms;
$numSpectra 	= count($ms);
$seq 			= $seq;
$ref			= $ref;
$refLink		= isset($refLink) ? $refLink : NULL;
$dataSource 	= $dataSource;
$protLink		= 'protein.php?id='.$pro.$getref;
//$accessions 	= getXrefLink($pro);
$link="link";
$type="type";
$accessions=array(0=>"<a href=\"$link\" title=\"Click to go to $type\" target=\"_blank\">SAMPLETYPE_SAMPLEACC</a>");
$description 	= $rows[0]['annotation'];
$organism 	= '<i>'.$rows[0]['latin'].'</i> ('.$rows[0]['commonName'].')';
$current 		= 'browse';
//$tmpl->pageContent 	= $tmpl->build('peptide.tmpl');

//closeDatabase();

//print $tmpl->build('page.tmpl');

function formatpep($seqpep,$id,$getref,$bSeq) {
	$phosphosites = array();
	$seq = "";
	//$sites = getptms($id);
$sites =array(array("site"=>1,"locationInPeptide"=>1,"ptm"=>"p","locationInProtein"=>100));
	$start = 0;
	foreach($sites as $site) {
		$loc = $site['locationInPeptide'];
		$href = 'href="phosphosite.php?id='.$site['site'].$getref.'"';
		$sbst = '<a class="ui-corner-all phosphosite" '.$href.'>'.substr($seqpep,$loc,1).'</a>';
		$seq = $seq.substr($seqpep,$start,$loc-$start).$sbst;
		$start = $loc + 1;
		
		$phosphosites[$href] = substr($seqpep,$loc,1);
	}
	$seq = $seq.substr($seqpep,$start);
	
	if($bSeq) {
		return $seq;
	} else {
		return $phosphosites;
	}
}
/*
function getptms($id) {
	$query_getsites = "SELECT site,ptm,locationInPeptide,locationInProtein FROM peptideSiteRelation,site WHERE peptide=$id AND peptideSiteRelation.site=site.id ORDER BY locationInPeptide";
	
	$result_getsites = runQuery($query_getsites);

	$sites = array();
	foreach($result_getsites as $row_getsites) {
		$sites[] = $row_getsites;
	}

	return $sites;
}
*/
function merge_params($params) {
	if (count($params)<=1)
		return $params;

	$keep[] = array();
	$n = count($params);
	for ($i=0; $i<$n; $i++) {
		$parami = $params[$i];
		$keep[$i] = true;
		for ($j=0; $j<$i; $j++) {
			if ($keep[$j]) {
				$paramj = $params[$j];
				// find the intersection of two arrays
				$intersect = array_intersect_assoc($parami,$paramj);
				// if the new param is equal or contained in an existing param
				if (count($intersect)==count($parami)) {
					$keep[$i] = false;
					break;
				} elseif (count($intersect)==count($paramj)) {
					// if the existing param is contained in the new param
					$keep[$j] = false;
					break;
				}
			}
		}
	}

	$ret = array();
	for ($i=0; $i<$n; $i++) {
		if ($keep[$i]) {
			$ret[] = $params[$i];
		}
	}

	return $ret;
}
?>
<head>
<link type="text/css" href="Metro-UI-CSS-master/css/metro-bootstrap.css" rel="stylesheet" />
<link type="text/css" href="Metro-UI-CSS-master/css/metro-bootstrap-responsive.css" rel="stylesheet" />
<script type="text/javascript"> 
function getHref($href){
document.forms['site'].elements['json_site'].value =JSON.stringify(
 <?php 
echo $carrier;  													 													
?>);
	document.myform.action=$href;
   document.getElementById("site").submit();

}
</script>
</head>
<body class="metro">
<div class="container grid">
<h1>Peptide</h1>

<form id="site"name="myform" method="POST" action="phosphosite.php">
<input type="hidden" name="json_site" value=''>
<input type="hidden" name="action">
</form>

<table class="table">
<tr>
	<td class="txt_bold txt_align_top">Protein:</td>
	<td><a class="button" href="<?php print $protLink; ?>">Details</a></td>
</tr>
<tr>
	<td class="txt_bold txt_align_top">Description:</td>
	<td><?php print $description; ?></td>
</tr>
<tr>
	<td class="txt_bold txt_align_top">Organism:</td>
	<td><?php print $organism; ?></td>
</tr>
<tr>
	<td class="txt_bold txt_align_top">Location:</td>
	<td><?php print (($loc)+1); ?></td>
</tr>
<tr>
	<td class="txt_bold txt_align_top">NR Sequence:</td>
	<td><span class="sequence"><?php print $seq; ?></span></td>
</tr>
<tr>
	<td class="txt_bold txt_align_top">No. of Spectra:</td>
	<td><?php print $numSpectra; ?></td>
</tr>
<tr>
	<td class="txt_bold txt_align_top">Reference:</td>
	<td colspan="2"><?php 
	print '<form method="get" action="peptide.php" id="refForm">';
	if(isset($_GET['id'])) {
		print '<input name="id" type="hidden" id="id" value="'.$id.'" />';
	} elseif (isset($_GET['pnrseq'])) {
		print '<input name="pnrseq" type="hidden" id="pnrseq" value="'.$pnrseq.'" />';
		print '<input name="pro" type="hidden" id="pro" value="'.$pro.'" />';
		print '<input name="loc" type="hidden" id="loc" value="'.$loc.'" />';
	}
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
		print '<br/>';
		print '&nbsp;<a href="'.$refLink.'" target="_blank" class="button" id="viewRef">View Reference</a>';
	}
	print '</div></form>';
	?></td>
</tr>
<tr>
	<td class="txt_bold txt_align_top">Phosphosites:</td>
	<td>
		<div class="table_shrink clear">
		<table class="display simple_table">
			<thead>
				<tr>
					<th>Position</th><th>Amino Acid</th><th>Phosphosite</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($sites as $site) {
				$href='"phosphosite.php?id='.$site['id'].'&amp;ref='.$ref.'"';
					print '<tr>';
					print '<td class="center"><span class="sequence">'.($site['locationInProtein']+1).'</span></td>';
					print '<td class="center"><span class="sequence">'.$site['amino'].'</span></td>';
					print '<td class="center"><a class="button" onclick=';echo" 'getHref(".$href.")'>Details</a></td>";
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
<tr>
	<td class="txt_bold txt_align_top">Spectra:</td>
	<td>&nbsp;</td>
</tr>
</table>

<div class="clear">
	<table id="spectrum_table" class="display table">
		<thead>
			<tr>
				<?php
				print '<th>Spectrum</th>';
				foreach ($headers as $h=>$tmp) {
					print '<th>'.$h.'</th>';
				}
				?>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($spectrumData as $sd) {
				$mp = $sd['mp'];
				$msid = $sd['msid'];
				$nmp = count($mp);
				for($j = 0; $j<$nmp; $j++) {
					print '<tr>';
					print '<td>'.$msheader[$msid].'</td>';
					$param = $mp[$j];
					foreach ($headers as $h=>$tmp) {
						print '<td>'.$param[$h].'</td>';
					}
					print '</tr>';
				}
			}
			?>
		</tbody>
	</table>
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

	
</body></html>