<?php
//require_once("../../../../system/DatabaseUtility.php");
$id=$_GET['id'];

$protein='{"protein":{"input":{}},"source":{},"step":"protein"}';
$proteinD=json_decode($protein,true);
//print_r($proteinD);
//$annotation="a";
//for($i=0;$i<10000;$i++){
//$annotation=$annotation."a";
//}
//print $annotation;
//--------sequence configure-------
/*
openDatabase(); 
$query='SELECT proteinID, proteinName, Sequence, Pos, Type, Value, Color From proteininfo NATURAL JOIN proteinsites NATURAL JOIN modtype WHERE proteinID="'.$id.'"';
$result=runQuery($query);
$sequence=$result[0]['Sequence'];
$sites=array();
$pos_info=array();
foreach($result as $row){
	$pos_single_info=array("color"=>$row['Color'],"type"=>$row['Type'],"value"=>$row['Value']);
	$pos_info[$row['Pos']][]=$pos_single_info;
}
foreach($pos_info as $id=>$info){
	$sites[$id]=array("id"=>$id,"info"=>$info);
}
*/
$info1=array(array("color"=>"green","type"=>"type1","value"=>10),array("color"=>"yellow","type"=>"type2","value"=>20),array("color"=>"blue","type"=>"type3","value"=>30),array("color"=>"black","type"=>"type4","value"=>70),array("color"=>"orange","type"=>"type5","value"=>50),array("color"=>"red","type"=>"type6","value"=>30));
$info2=array(array("color"=>"green","type"=>"type1","value"=>10),array("color"=>"yellow","type"=>"type2","value"=>30),array("color"=>"blue","type"=>"type3","value"=>60),array("color"=>"black","type"=>"type4","value"=>90),array("color"=>"orange","type"=>"type5","value"=>120));
$info3=array(array("color"=>"orange","type"=>"type1","value"=>60));
$sequence='COLUMBIAMISSOURIISTHEMOSTBEAUTIFULCITYINTHEWORLDBUTTHISISNOTTRUEALSOTHEWEATHERTODAYISPRETTYWELL';

$sites=array(1=>array("id"=>1,"info"=>$info1),3=>array("id"=>3,"info"=>$info2),7=>array("id"=>7,"info"=>$info3));

//---------------------------------		
$rows_1=array(array("annotation"=>"annotationSample","latin"=>"latinSample","commonName"=>"commonNameSample"));
$rows_2=array(array("sequence"=>$sequence,"sites"=>$sites,"id"=>1,"locationInProtein"=>1));
//$rows_2=array(array("sequence"=>$sequence,"sites"=>$sites));
$rows_4=array(array("id"=>1,"reference"=>"referenceSample","Level"=>0));
//$rows_3=array(1=>1);
$rows_5=array(array("kinase"=>"SAMMPLEKINASE"));
$rows_6=array(array("domainID"=>1,"applicationName"=>"SAMPLE_APPLICATIONNAME","domainDescription"=>"SAMPLE_DOMAINDESCRIPTION","matchStart"=>"SAMPLE_MATCHSTART","matchEnd"=>"SAMPLE_MATCHEND"));
$rows_7=array(array("ontologyID"=>"SAMPLE_ID","name"=>"SAMPLE_NAME","def"=>"SAMPLE_DEF","synonym"=>"SAMPLE_SYNONYM","xref"=>"SAMPLE_XREF" ));
$rows_8=array(array("interactor_a"=>"SAMPLE001","interactor_b"=>"SAMPLE002","experimental_system"=>"SAMPLE_EXP","source"=>"SAMPLE_SOURCE","pubmed_ID"=>00000001));
$rows_9=array(array());
$proteinD["protein"]["input"]["1"]=$rows_1;
$proteinD["protein"]["input"]["2"]=$rows_2;
$proteinD["protein"]["input"]["4"]=$rows_4;
$proteinD["protein"]["input"]["5"]=$rows_5;
$proteinD["protein"]["input"]["6"]=$rows_6;
$proteinD["protein"]["input"]["7"]=$rows_7;
$proteinD["protein"]["input"]["8"]=$rows_8;
$proteinD["protein"]["input"]["9"]=$rows_9;
print_r($proteinD);
/*
$proteinD["3"]=$rows_3;
$proteinD["4"]=$rows_4;
$proteinD["5"]=$rows_5;
$proteinD["6"]=$rows_6;
$proteinD["7"]=$rows_7;*/
$json_protein=json_encode($proteinD);
//print json_encode($proteinD);
$proteinId=1;
?>






<form action="protein.php" method="POST">
<input type="hidden" name="json_protein" value=<?php echo $json_protein?> />

<input type="submit" value="send " />
</form>