<?php
//$rows=array(array("id"=>1,"reference"=>"referenceSample","Level"=>0));
//$rows=json_decode($_POST['json'], true);
$de_carrier=json_decode($_POST['json'], true);
$rows=$de_carrier["protein"]["input"]["4"];
$levelFlag=true;
//$id = $_GET['id'];
$id =1;//***faked***
//$ref = $_GET['ref'];
$ref=1;//****faked****
foreach($rows as $row) {
	$dataSource[$row['id']] = $row['reference'];
}
if (count($dataSource)>1) {
	$dataSource[0] = "All";
	ksort($dataSource);
}	
// reference links
$refLink = '';
$refs = array();
//$query ="SELECT id,link,reference FROM dataSource ORDER BY pubmed DESC;";
//$result = runQuery($query);
$result=array(array("id"=>1,"reference"=>"referenceSample", "link"=>"google.com"));
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
?>
<head>
<link type="text/css" href="../Metro-UI-CSS-master/css/metro-bootstrap.css" rel="stylesheet" />
<link type="text/css" href="../Metro-UI-CSS-master/css/metro-bootstrap-responsive.css" rel="stylesheet" />

<script src="js/jquery-1.8.2.js"></script>
<script src="js/jquery-ui-1.9.1.custom.min.js"></script>


</head>
<body class="metro">
<div class="container grid" style="margin-left:80;width:800px;">
	<table class="table">
		<tbody>
			<h2><font color="green" size="6">Reference</font></h2><br/>
			<tr class="module_2">
				<td colspan="2"><?php 
				print '<form method="get" action="protein.php" id="refForm">';
				print '<input name="id" type="hidden" id="id" value="'.$id.'" />';
				print '<div class="clear"><div class="css_left input-control select"><select name="ref" id="refSelect" size="1">';
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
		</tbody>
		</table>
		<div class="container">
		</body>