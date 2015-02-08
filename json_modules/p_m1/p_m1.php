<?php
$de_carrier=json_decode($_POST['json'], true);
//print_r($de_carrier);
$rows=$de_carrier["protein"]["input"]["1"];
$id =1;//***faked***
//$ref = $_GET['ref'];
$ref=2;//***faked***
$description = $rows[0]['annotation'];
$organism 	= '<i>'.$rows[0]['latin'].'</i> ('.$rows[0]['commonName'].')';
?>
<head>
<link type="text/css" href="../Metro-UI-CSS-master/min/metro-bootstrap.min.css" rel="stylesheet" />
<link type="text/css" href="../Metro-UI-CSS-master/min/metro-bootstrap-responsive.min.css" rel="stylesheet" />
<link type="text/css" href="../Metro-UI-CSS-master/min/iconFont.min.css" rel="stylesheet" />
<!-- standalone page styling (can be removed) -->
<link rel="shortcut icon" href="/media/img/favicon.ico">
<!--<link type="text/css" href="tooltip.css" rel="stylesheet" />
<link type="text/css" href="tooltip_bar.css" rel="stylesheet" />-->



<script src="js/jquery-1.8.2.js"></script>
<script src="js/jquery-ui-1.9.1.custom.min.js"></script>
<script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
<script type="text/javascript" src="../Metro-UI-CSS-master/js/metro-button-set.js"></script> 
<!--Load the AJAX API-->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>

</head>

<body class="metro">
<div class="container" style="margin-left:80;width:800px;">
<h2><font color="green" size="6" >Description and origin</font></h2>
<table class="table">
	<tbody>
	<tr class="module_1 row">
	<div class="span10">
		<td class="txt_bold txt_align_top">Description:</td>
		<td colspan="2"><?php print $description; ?></td>
	</div>	
	</tr>
	<tr class="module_1 row">
		<td class="txt_bold txt_align_top">Organism:</td>
		<td colspan="2"><?php print $organism; ?></td>
	</tr>
</table>
</div>
</body>