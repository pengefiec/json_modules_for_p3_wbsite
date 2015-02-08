<?php
//$rows=array(array("pid"=>1,"annotation"=>"SAMPLE_ANNOTATION","sequence"=>"SAMPLE_SEQUENCE","latin"=>"SAMPLE_LATIN","commonName"=>"SMAPLE_COMMONNAME","loc"=>1));
$protLink="hhaha";
$de_carrier=json_decode($_POST['json'], true);
$rows=$de_carrier["site"]["input"]["1"];
//print_r($rows);
$description 	= $rows[0]['annotation'];
$organism 	= '<i>'.$rows[0]['latin'].'</i> ('.$rows[0]['commonName'].')';
//$numSites 	= count($sites);
$loc = $rows[0]['loc'];
$sequence = $rows[0]['sequence']; 
$start = 10*floor($loc/10)+1;
$end = 10*ceil($loc/10);
$surrSeq = substr($sequence,$start,$loc-$start).'<span class="ui-corner-all phosphosite">'.substr($sequence,$loc,1).'</span>'.substr($sequence,$loc+1,$end-$loc);
$loc 			= $loc + 1;
?>
<head>
<link type="text/css" href="../Metro-UI-CSS-master/css/metro-bootstrap.css" rel="stylesheet" />
<link type="text/css" href="../Metro-UI-CSS-master/css/metro-bootstrap-responsive.css" rel="stylesheet" />
</head>
<body class="metro">
<div class="container grid" style="margin:auto;width:900px;">
<table class="table">
<tbody>
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
</tbody>
</table>
</div>
</body>