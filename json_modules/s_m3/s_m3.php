<?php
$carrier=$_POST['json'];
$de_carrier=json_decode($carrier, true);
$rows=$de_carrier["site"]["input"]["3"];
$mass=array(1=>1);
$id=1;$getref=1;//***faked***
$sites=array('a','b','c');//***faked***
$numSpectra = count($mass);
$peptides = array();
$rows_1=array(array("id"=>1,"location"=>1,"sequence"=>"SAMPLE_SEQUENCE","msid"=>1,"file"=>"SAMPLE_FILE","scan"=>"SAMPLESCAN","nullMass"=>true,"reference"=>"SAMPLE_REFERNECE","link"=>"SAMPLE_LINK","pid"=>1,"annotation"=>"SAMPLE_ANNOTATION","latin"=>"SAMPLE_LATIN","commonName"=>"COMMONNAME"));
$de_carrier["peptide"]["input"]=$rows_1;
$carrier=json_encode($de_carrier);
foreach($rows as $row) {
	$nrseq = $row['phosphoSequence'];
	$linkformat = str_replace('#', '%23', $nrseq);
	$formated = format_nr_pep_unlink_exclusiveself($nrseq,$row['locationInPeptide']);
	$href = '"peptide.php?pnrseq='.$linkformat.'&pro='.$id.'&loc='.$row['location'].$getref.'"';
	$peptides[$formated] = $href;
}
function format_nr_pep_unlink_exclusiveself($nrpseq,$exsite) {
        $seq = "";
        $seqpep = str_replace('#', '', $nrpseq);

        $start = 0;

        $sites = getSiteFromNrPep($nrpseq);
        foreach($sites as $s) {
                if ($s == $exsite) {
                        $sbst = '<span class="ui-corner-all phosphosite highlight">'.substr($seqpep,$s,1).'</span>';
                } else {
                        $sbst = '<span class="ui-corner-all phosphosite">'.substr($seqpep,$s,1).'</span>';
                }
                $seq = $seq.substr($seqpep,$start,$s-$start).$sbst;
                $start = $s + 1;
        }
        $seq = $seq.substr($seqpep,$start);

        return $seq;
}

function getSiteFromNrPep($nrpseq) {
    $curr = strpos($nrpseq, '#');
	$sites=array();
    while ($curr) {
    	$sites[] = $curr - count($sites) - 1;
    	$curr = strpos($nrpseq, '#', $curr+1);
    }
    return $sites;
}


?>
<head>
<link type="text/css" href="../Metro-UI-CSS-master/css/metro-bootstrap.css" rel="stylesheet" />
<link type="text/css" href="../Metro-UI-CSS-master/css/metro-bootstrap-responsive.css" rel="stylesheet" />
<script type="text/javascript"> 

function getHref($href){
parent.document.forms['peptide'].elements['json_peptide'].value =JSON.stringify(
 <?php 
echo $carrier;  													 													
?>);
	parent.document.myform.action=$href;
   parent.document.getElementById("peptide").submit();

}
</script>
</head>
<body class="metro">
<div class="container grid">
<table class="table">
<tr>
	<td class="txt_bold txt_align_top">No. of Spectra: </td>
	<td colspan="2"><?php print $numSpectra; ?></td>
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
					print '<td class="center"><a class="button" onclick=';echo" 'getHref(".$href.")'>Details</a></td>";
					print '</tr>';
				}
				?>
			</tbody>
		</table>
	</div>
	</td>
</tr>
</table>
</div>
</body>