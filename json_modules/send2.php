<?php
$site='{"1":{},"2":{},"3":{},"4":{}}';
$siteD=json_decode($site,true);
$rows_1=array(array("pid"=>1,"annotation"=>"SAMPLE_ANNOTATION","sequence"=>"SAMPLE_SEQUENCE","latin"=>"SAMPLE_LATIN","commonName"=>"SMAPLE_COMMONNAME","loc"=>1));
$rows_2=array(array("id"=>1,"reference"=>"SAMPLE_REFERENCE","link"=>"SAMPLE_LINK"));
$siteD["1"]=$rows_1;
$siteD["2"]=$rows_2;
$json_site=json_encode($siteD);
?>
<form action="phosphosite.php?id=1" method="POST">
<input type="hidden" name="json_site" value=<?php echo $json_site?> />

<input type="submit" value="send " />
</form>