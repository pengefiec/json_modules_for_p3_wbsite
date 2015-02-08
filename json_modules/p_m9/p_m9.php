<?php
$de_carrier=json_decode($_POST['json'], true);//no need for now
//print_r($de_carrier);
$rows=$de_carrier["protein"]["input"]["9"];
$link="link";
$type="type";
$accessions=array(0=>"<a href=\"$link\" title=\"Click to go to $type\" target=\"_blank\">SAMPLETYPE_SAMPLEACC</a>");

?>
<head>
<link type="text/css" href="../Metro-UI-CSS-master/css/metro-bootstrap.css" rel="stylesheet" />
<link type="text/css" href="../Metro-UI-CSS-master/css/metro-bootstrap-responsive.css" rel="stylesheet" />

<script src="js/jquery-1.8.2.js"></script>
<script src="js/jquery-ui-1.9.1.custom.min.js"></script>
</head>
<body class='metro'>
<div class='container' style="margin-left:80;width:800px;">
<h2><font color="green" size="6" >Accessions</font></h2>
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
</div>
</body>
