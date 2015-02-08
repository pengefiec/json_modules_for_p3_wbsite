<?php
//$rows=array(array("id"=>1,"reference"=>"SAMPLE_REFERENCE","link"=>"SAMPLE_LINK"));

foreach($rows as $row) {
	$dataSource[$row['id']] = $row['reference'];
}
if (count($dataSource)>1) {
	$dataSource[0] = "All";
	ksort($dataSource);
}
//$result=array(array("id"=>1,"link"=>"SAMPLE_LINK"));
foreach($rows as $row) {
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
<tr>
	<td class="txt_bold txt_align_top">Reference:</td>
	<td colspan="2"><?php 
	print '<form method="get" action="phosphosite.php" id="refForm">';
	print '<input name="id" type="hidden" id="id" value="'.$id.'" />';
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
		print '&nbsp;<a href="'.$refLink.'" target="_blank" class="button" id="viewRef">View Reference</a>';
	}
	print '</div></form>';
	?></td>
</tr>