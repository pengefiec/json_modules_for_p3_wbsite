<?php
//$rows=array(array("annotation"=>"annotationSample","latin"=>"latinSample","commonName"=>"commonNameSample","sequence"=>"sequenceSample","id"=>1,"locationInProtein"=>1));
//$rows=json_decode($_POST['json'], true);
$de_carrier=json_decode($_POST['json'], true);
//print_r($de_carrier);
$rows=$de_carrier["protein"]["input"]["2"];
//$id = $_GET['id'];
$id =1;//***faked***
//$ref = $_GET['ref'];
$ref=2;//***faked***
//$description = $rows[0]['annotation'];
//$organism 	= '<i>'.$rows[0]['latin'].'</i> ('.$rows[0]['commonName'].')';
//p_m2 follow*********************

$sequence 	= $rows[0]['sequence'];
$sites_s	=$rows[0]['sites'];
$legend_color=array();
$legend_type=array();
foreach($sites_s as $site){
	foreach($site['info'] as $info){
		if(in_array($info['color'], $legend_color)==false){
			$legend_color[]=$info['color'];
			$legend_type[]=$info['type'];
		}
	}
}
//print_r($legend_type);
$sites = array();
foreach($rows as $row) {
	$sites[$row['locationInProtein']] = $row['id'];
}
ksort($sites);
$numSites 	= count($sites);
/*
echo'
<script>
function getValue()
  {
  alert("hehehhehe");
  }
</script>';
*/
$site='{"1":{}}';
$siteD=json_decode($site,true);
$rows_1=array(array("pid"=>1,"annotation"=>"SAMPLE_ANNOTATION","sequence"=>"SAMPLE_SEQUENCE","latin"=>"SAMPLE_LATIN","commonName"=>"SMAPLE_COMMONNAME","loc"=>1));
$rows_2=array(array("id"=>1,"reference"=>"SAMPLE_REFERENCE","link"=>"SAMPLE_LINK"));
$rows_3=array(array("phosphoSequence"=>"SAMPLE#PHOSPHOSEQUENCE","locationInPeptide"=>1,"location"=>1));
//$siteD["2"]=$rows_2;
$de_carrier["site"]["input"]["1"]=$rows_1;
$de_carrier["site"]["input"]["3"]=$rows_3;
$carrier=json_encode($de_carrier); 
$array = str_split($sequence);
?>
<head>
<link type="text/css" href="../Metro-UI-CSS-master/min/metro-bootstrap.min.css" rel="stylesheet" />
<link type="text/css" href="../Metro-UI-CSS-master/min/metro-bootstrap-responsive.min.css" rel="stylesheet" />
<link type="text/css" href="../Metro-UI-CSS-master/min/iconFont.min.css" rel="stylesheet" />

<!-- standalone page styling (can be removed) -->
<link rel="shortcut icon" href="/media/img/favicon.ico">
<!--<link type="text/css" href="tooltip.css" rel="stylesheet" />
<link type="text/css" href="tooltip_bar.css" rel="stylesheet" />-->
<link type="text/css" href="tooltip.css" rel="stylesheet" />


<script src="js/jquery-1.8.2.js"></script>
<script src="js/jquery-ui-1.9.1.custom.min.js"></script>
<script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
<!--<script type="text/javascript" src="../Metro-UI-CSS-master/js/metro-button-set.js"></script> -->
<!--Load the AJAX API-->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script src="p_m2.js"></script>
<script type="text/javascript"> 
<?php
$js_array = json_encode($legend_color);
echo "var color_array = ". $js_array . ";\n";
?>
var current=[];
//console.log(color_array);
$(document).ready(function(){
  $("#detail").click(function(){
parent.document.forms['site'].elements['json_site'].value =JSON.stringify(
 <?php 
echo $carrier;  													 													
?>);
   parent.document.getElementById("site").submit();  });
   
  
 
});

</script>
</head>
<body class="metro">
<div class="container" style="width:800px;">
<!--Phosphosites place holder-->

<h2><font color="green" size="6">Sequence</font></h2>
<div class="input-control radio default-style inline-block" data-role="input-control">
	<label class="inline-block">
		<input type="radio" name="r1" value="1" checked="">
		<span class="check"></span>
		Pie Chart
	</label>
	
	<label class="inline-block">
		<input type="radio" name="r1" value="2">
		<span class="check"></span>
		List
	</label>
	
	<label class="inline-block">
		<input type="radio" name="r1" value="3">
		<span class="check"></span>
		Bar
	</label>	
</div>
<?php
  //-----------generate legend---------------
			$legend='';
			$legend='<table class="table"><tr><td style="border-bottom:0px; padding: 0px;"><div class="input-control checkbox" data-role="input-control"><label class="inline-block"><input type="checkbox" id="s_all" onclick="showAll()"><span class="check"></span>Show All</label></div></td>	
					<td style="border-bottom:0px;padding: 0px;"><div class="input-control checkbox" data-role="input-control"><label class="inline-block"><input type="checkbox" id="h_all" onclick="hideAll()"><span class="check"></span>Hide All</label></div></td></tr>
					<tr><td style="border-bottom:0px;padding: 0px;"><div class="input-control checkbox" data-role="input-control"><label class="inline-block"><input id="multiple_leg" type="checkbox" onclick="showMultiple()"><span class="check" style="border:2px fuchsia solid" ></span><font color="fuchsia">Multiple</font></label></div></td>';
						
			$leg_i=0;
			foreach($legend_color as $color){
			
				if(($leg_i%3==0)&&($leg_i!=0)){
					$legend.='<tr><td style="border-bottom:0px;padding: 0px;"></td>';
				}
				
				$legend.='<td style="border-bottom:0px;padding: 0px;" ><div class="input-control checkbox" data-role="input-control"><label class="inline-block"><input type="checkbox" id="'.$color.'_leg" class="common_leg" onclick="show(\''.$color.'\')"><span class="check" style="border:2px '.$color.' solid" ></span><font color="'.$color.'">'.$legend_type[$leg_i].'</div></td>'; 
				
				if(($leg_i%5==0)&&($leg_i!=0)){
					$legend.='</tr>';
				}
				$leg_i++;		
			}
			$legend.='</tr></table>';
			print $legend;
?>
<table id="chart" class="table">
	<tr>
        
        <?php $blocksPerLine = 6; ?>
        <!--<td class="txt_bold txt_align_top">Sequence:</td>-->
        <td class="txt_align_right"><div class="sequence css_left grid"><?php 
          for($i = 0; $i <= ((strlen($sequence)-1) / 10) / $blocksPerLine; $i++) {
            print (1 + $i*10*$blocksPerLine).'&nbsp;<br />';
          }
        ?></div>
        </td>
        <td colspan="5" style="font-size:16px;"><div class="sequence protein" ><?php 
          // -----------------generate sequence-----------------------
          $seq2 = ''; $i = 1;$cmul=0;
         
          foreach($array as $pos=>$char) {
            if(!empty($sites_s[$i])){
              	//------generate class string--------
				$class_str='';
				$chart_color='';
				foreach ($sites_s[$i]["info"] as $row) {
					//print_r($row);
					$class_str.=$row["color"];
					$class_str.=' ';
					$chart_color.='"';
					$chart_color.=$row["color"];
					$chart_color.='"';
					$chart_color.=',';
				}
				$ccc=rtrim($chart_color, ",");
				//echo $ccc.'<br/>';
                //$seq2 .= '<div style="display:inline;"><a class="ui-corner-all phosphosite" href="phosphosite.php?id='.$sites[$i-1]["id"].'" style="color:white; background-color:'.$sites[$i-1]["info"][0]["color"].' " >'.$char.'</a></div>';
              
             
                $cmul=$cmul+1;
				if (count($sites_s[$i]["info"])==1) {
				$seq2 .= '<div style="display:inline;" class="char"><a class="'.$class_str.' download_now chosen_colors " id="'.$pos.'" style="color:white; background-color:'.$sites_s[$i]["info"][0]["color"].' " >'.$char.'</a>';
               }
			   else{
				$seq2.='<div style="display:inline;"class="char"><a class="'.$class_str.' download_now multiple chosen_colors" id="'.$pos.'" style="color:white;background-color:fuchsia" >'.$char.'</a>';
				}
			 ?><script type="text/javascript">
                  google.load('visualization', '1.0', {'packages':['corechart']});
      // Set a callback to run when the Google Visualization API is loaded.
                google.setOnLoadCallback(drawChart);
                function drawChart() {
                 var data = google.visualization.arrayToDataTable([  ['Task', 'link', 'Hours per Day'],
                 <?php
                       $j=0;
                       $d=count($sites_s[$i]["info"]);
                        foreach ($sites_s[$i]["info"] as $row) {
                         $j=$j+1;
                       if($j>=$d){
                        echo'["'.$row["type"].'",'.'"phosphosite.php?id='.$sites_s[$i]["id"].'",'.$row["value"].']';
                       }
                       else{
                          echo'["'.$row["type"].'",'.'"phosphosite.php?id='.$sites_s[$i]["id"].'",'.$row["value"].'],';
                        }
						
                      }
                        ?>
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 2]);

         var options = {'colors':[<?=$ccc?>],
						'title':'',
                       'width':260,
                       'height':180};
                       
        var chart = new google.visualization.PieChart( 
          document.getElementById('chart_div'+<?php echo $cmul ?>));
        chart.draw(view, options);

        var selectHandler = function(e) {
         window.location = data.getValue(chart.getSelection()[0]['row'], 1 );
        }

        // Add our selection handler.
        google.visualization.events.addListener(chart, 'select', selectHandler);
      }

      
    </script><?php
              $seq2.='<div class="arrow_box" style="display: none;">
              <div class="place-right padding5 fg-orange" style="
					cursor: pointer;
					z-index: 1;
					position: relative;

				"><i class="icon-cancel" ></i></div>
                        <div id="chart_div'.$cmul.'">';
            
              $seq2.='</div>
                    </div></div>';
               
            
            }
            else {
              $seq2 .= '<div style="display:inline;">'.$char.'</div>';
            }
            if($i%10 == 0) {
              
              $seq2 .= '<div style="display:inline;">'." ".'</div>';
            }
            if($i%60 == 0) {
              $seq2 .= '<br />';
            }
            $i++;
          }

          print $seq2;
         // print_r($sites);
        ?></div></td>
      </tr> 

</table>

<table class="table" id="list" style="display:none;">
<tr>
        <?php $blocksPerLine = 6; ?>
        <td class="txt_align_right"><div class="sequence css_left grid"><?php 
          for($i = 0; $i <= ((strlen($sequence)-1) / 10) / $blocksPerLine; $i++) {
            print (1 + $i*10*$blocksPerLine).'&nbsp;<br />';
          }
        ?></div>
        </td>
        <td colspan="4" style="font-size:16px;"><div class="sequence protein grid" ><?php 
          //--------------- generate sequence--------------
          $seq2 = ''; $i = 1;
          foreach($array as $char) {
            if(!empty($sites_s[$i])){
				//------generate class string--------
				$class_str='';
				foreach ($sites_s[$i]["info"] as $row) {
					//print_r($row);
					$class_str.=$row["color"];
					$class_str.=' ';
				}
              if (count($sites_s[$i]["info"])==1) {
                $seq2 .= '<div style="display:inline;" class="char"><a class="'.$class_str.' download_now  chosen_colors" href="phosphosite.php?id='.$sites_s[$i]["id"].'" style="color:white; background-color:'.$sites_s[$i]["info"][0]["color"].' " >'.$char.'</a>';    
                $seq2.='<div class="arrow_box" style="display: none;">
					  <div class="qtip">
						
					  <table class="test">';
                 $seq2.= '<tr>
                          <td>
                          <a href="phosphosite.php?id='.$sites_s[$i]["id"].'">
                            <div class="squares '.$class_str.'" ></div>
                          </a>
                          </td>
                          <td>
                            <a href="phosphosite.php?id='.$sites_s[$i]["id"].'">'.$sites_s[$i]["info"][0]["type"].':</a>
                          </td>
                          <td>
                            <a href="phosphosite.php?id='.$sites_s[$i]["id"].'">'.$sites_s[$i]["info"][0]["value"].'</a>
                          </td>
                        </tr>';                 
              
              $seq2.='</table>
                    </div>
                    </div></div>';
			  }
              else{
                //echo $class_str;
                $seq2.='<div style="display:inline;" class="char"><a class="'.$class_str.' download_now chosen_colors multiple" style="color:white;background-color:fuchsia">'.$char.'</a>';
                  
                $seq2.='<div class="arrow_box" style="display: none;">
					  
					<div class="qtip">
					  <table class="test">';
                foreach ($sites_s[$i]["info"] as $row) {
                 $seq2.= '<tr>
                          <td>
                          <a href="phosphosite.php?id='.$sites_s[$i]["id"].'">
                            <div class="squares '.$row["color"].'" ></div>
                          </a>
                          </td>
                          <td>
                            <a href="phosphosite.php?id='.$sites_s[$i]["id"].'">'.$row["type"].':</a>
                          </td>
                          <td>
                            <a href="phosphosite.php?id='.$sites_s[$i]["id"].'">'.$row["value"].'</a>
                          </td>
                        </tr>';                 
              }
              $seq2.='</table>
                    </div>
                    </div></div>';
                    
               
            }
            }
            else {
              $seq2 .= '<div style="display:inline;">'.$char.'</div>';
            }
            if($i%10 == 0) {
              
              $seq2 .= '<div style="display:inline;">'." ".'</div>';
            }
            if($i%60 == 0) {
              $seq2 .= '<br />';
            }
            $i++;
          }
          print $seq2;
         // print_r($sites);
        ?></div>
		</td>
      </tr> 

</table>
<table id="bar" class="table" style="display:none ">
<tr>
        <?php $blocksPerLine = 6; ?>
        <td class="txt_align_right"><div class="sequence css_left grid"><?php 
      
          for($i = 0; $i <= ((strlen($sequence)-1) / 10) / $blocksPerLine; $i++) {
            print (1 + $i*10*$blocksPerLine).'&nbsp;<br />';
          }
        ?></div>
        </td>
        <td colspan="4" style="font-size:16px;"><div class="sequence protein grid"><?php 
  
		
          //----------- generate sequence-----------------------
		  $seq2 = ''; $i = 1;
          foreach($array as $char) {
            if(!empty($sites_s[$i])){      
			//------generate class string--------
				$class_str='';
				foreach ($sites_s[$i]["info"] as $row) {
					//print_r($row);
					$class_str.=$row["color"];
					$class_str.=' ';
				}
				//echo $class_str;
              if (count($sites_s[$i]["info"])==1) {
                $seq2 .= '<div style="display:inline;" class="char"><a class="'.$sites_s[$i]["info"][0]["color"].' download_now chosen_colors " href="phosphosite.php?id='.$sites_s[$i]["id"].'" style="color:white; background-color:'.$sites_s[$i]["info"][0]["color"].' " >'.$char.'</a>';
				$seq2.='<div class="arrow_box" style="display: none;">
                          <div class="qtip_bar">
                          <table class="test">';
				 $seq2.= '<div style="display:inline;">
				  <a href="phosphosite.php?id='.$sites_s[$i]["id"].'">
					<div class="download_now squares '.$class_str.'" title="'.$sites_s[$i]["info"][0]["type"].' : '.$sites_s[$i]["info"][0]["value"].'">
					
				  </a>
				  </div>'; 	
				  $seq2.='</table>
                    </div>
                    </div></div>';
  }
              else{
                //echo $class_str;
                $seq2.='<div style="display:inline;" class="char"><a class="'.$class_str.' download_now chosen_colors multiple "  style="color:white;background-color:fuchsia">'.$char.'</a>';
                  
                $seq2.='<div class="arrow_box" style="display: none;">
                          <div class="qtip_bar">
                          <table class="test">';
				
                foreach ($sites_s[$i]["info"] as $row) {
                 $seq2.= '<div style="display:inline;">
                          <a href="phosphosite.php?id='.$sites_s[$i]["id"].'">
                            <div class="download_now squares '.$row["color"].'" title="'.$row["type"].' : '.$row["value"] .'">
                            
                          </a>
                          </div>'; 
                          
                                          
              }
              $seq2.='</table>
                    </div>
                    </div></div>';
                   
               
            }
            }
            else {
              $seq2 .= '<div style="display:inline;">'.$char.'</div>';
            }
            if($i%10 == 0) {
              
              $seq2 .= '<div style="display:inline;">'." ".'</div>';
            }
            if($i%60 == 0) {
              $seq2 .= '<br />';
            }
            $i++;
          }
          print $seq2;
         // print_r($sites);
        ?></div><br/>
	<?php
	
	?></td>
	</tr>
</table>

</div>
<script>
	$(document).ready(function() {
      $('.download_now').tooltip({ 
        position:'top center',
        effect: 'slide' ,
        delay:80,
        disabled: true

      });
	$(".padding5").click(function(){
    $(this).parent().css({display:"none"});
	
	});

  


});
</script>
</body>
