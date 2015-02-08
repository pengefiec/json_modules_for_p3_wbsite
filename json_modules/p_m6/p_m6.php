<?php
//domains
//$rows=array(array("domainID"=>1,"applicationName"=>"SAMPLE_APPLICATIONNAME","domainDescription"=>"SAMPLE_DOMAINDESCRIPTION","matchStart"=>"SAMPLE_MATCHSTART","matchEnd"=>"SAMPLE_MATCHEND"));
$de_carrier=json_decode($_POST['json'], true);
//print_r($de_carrier);
$rows=$de_carrier["protein"]["input"]["6"];
?>
<head>
<link type="text/css" href="../Metro-UI-CSS-master/css/metro-bootstrap.css" rel="stylesheet" />
<link type="text/css" href="../Metro-UI-CSS-master/css/metro-bootstrap-responsive.css" rel="stylesheet" />

<script src="js/jquery-1.8.2.js"></script>
<script src="js/jquery-ui-1.9.1.custom.min.js"></script>
</head>
<body class='metro'>
<div class='container' style="margin-left:80;width:800px;">
			<div id="domain">
			<h2><font color="green" size="6" >Domain Information</font></h2>
				<table cellpadding="0" cellspacing="0" border="0" class="display table">
					<thead>
						<tr>
							<th>Domain ID</th>
							<th>Name</th>
							<th>Description</th>
							<th>Start</th>
							<th>End</th>
						</tr>
					</thead>
					<tbody>
				<?php

					foreach ($rows as $row){
						$id = $row['domainID'];
						$name = $row['applicationName'];
						$description=$row['domainDescription'];
						$start = $row['matchStart'];
						$end = $row['matchEnd'];
						echo "<tr><td>".$id."</td><td>".$name."</td><td>".$description."</td><td>".$start."</td><td>".$end."</td></tr>";
					}
				?>
					</tbody>
				</table><br />
			</div>
</div>
</body>