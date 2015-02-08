<?php
//$rows=array(array("kinase"=>"SAMMPLEKINASE")); //kinase
$de_carrier=json_decode($_POST['json'], true);
//print_r($de_carrier);
$rows=$de_carrier["protein"]["input"]["5"];
?>
<head>
<link type="text/css" href="../Metro-UI-CSS-master/css/metro-bootstrap.css" rel="stylesheet" />
<link type="text/css" href="../Metro-UI-CSS-master/css/metro-bootstrap-responsive.css" rel="stylesheet" />

<script src="js/jquery-1.8.2.js"></script>
<script src="js/jquery-ui-1.9.1.custom.min.js"></script>
</head>
<body class='metro'>
<div class='container' style="margin-left:80;width:800px;">
<h2><font color="green" size="6" >Kinase-Substrate</font></h2>
	<table class='table'>
		<tr>
			<td>
			<div id="kinase_substrate">
				<?php
					foreach ($rows as $row)
					{
						echo '<span class="ui-icon ui-icon-bullet" style="float: left;"></span>';
						echo "<a href=''>".$row['kinase']."</a>";
					}
				?>
			</div>
			</td>
		</tr>
	</table>
</div>
</body>