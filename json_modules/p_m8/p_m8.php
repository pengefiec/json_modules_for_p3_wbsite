<?php
//ppi
//$rows=array(array("interactor_a"=>"SAMPLE001","interactor_b"=>"SAMPLE002","experimental_system"=>"SAMPLE_EXP","source"=>"SAMPLE_SOURCE","pubmed_ID"=>00000001));
$de_carrier=json_decode($_POST['json'], true);
//print_r($de_carrier);
$rows=$de_carrier["protein"]["input"]["8"];
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
<div id="PPI">
	<h2><font color="green" size="6" >Protein Protein Interaction</font></h2>
	<table cellpadding="0" cellspacing="0" border="0" class="display table">
			<thead>
				<tr>
					<th>INTERACTOR_A</th>
					<th>INTERACTOR_B</th>
					<th>EXPERIMENTAL_SYSTEM</th>
					<th>SOURCE</th><th>PUBMED_ID</th>
				</tr>
			</thead>
			<tbody>
			<?php
				
				foreach ($rows as $row){
					$name_A = $row['interactor_a'];
					$name_B = $row['interactor_b'];
					$exp=$row['experimental_system'];
					$source = $row['source'];
					$pid = $row['pubmed_ID'];
					echo "<tr><td>".$name_A."</td><td>".$name_B."</td><td>".$exp."</td><td>".$source."</td><td>".$pid."</td></tr>";
				}
			?>
			</tbody>
		</table><br />
	</div>

</div>
</body>