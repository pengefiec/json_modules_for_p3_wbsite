<?php
//ontoloty
//$rows=array(array("ontologyID"=>"SAMPLE_ID","name"=>"SAMPLE_NAME","def"=>"SAMPLE_DEF","synonym"=>"SAMPLE_SYNONYM","xref"=>"SAMPLE_XREF" ));
$de_carrier=json_decode($_POST['json'], true);
//print_r($de_carrier);
$rows=$de_carrier["protein"]["input"]["7"];
?>
<head>
<link type="text/css" href="../Metro-UI-CSS-master/css/metro-bootstrap.css" rel="stylesheet" />
<link type="text/css" href="../Metro-UI-CSS-master/css/metro-bootstrap-responsive.css" rel="stylesheet" />

<script src="js/jquery-1.8.2.js"></script>
<script src="js/jquery-ui-1.9.1.custom.min.js"></script>
</head>
<body class='metro'>
<div class='container' style="margin-left:80;width:800px;">
	<div id="go_map">
		<h2><font color="green" size="6" >Ontology</font></h2>
		<table cellpadding="0" cellspacing="0" border="0" class="display table">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Synonym</th>
				</tr>
			</thead>
			<tbody>
		<?php
			foreach ($rows as $row){
				$id = $row['ontologyID'];
				$name = $row['name'];
				$def=$row['def'];
				$synonym = $row['synonym'];
				$xref = $row['xref'];
				echo "<tr><td>".$id."</td><td>".$name."</td><td>".$synonym."</td></tr>";
			}
		?>
			</tbody>
		</table><br />
		</div>
	</div>
</body>