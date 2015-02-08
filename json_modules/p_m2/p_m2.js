$(document).ready(function(){
$('input[name=r1]').on('change', function(){
	var n = $(this).val();
	switch(n)
	{
			case '1':
				
				  $('#chart').css('display','block');
				  $('#list').css('display','none');
				  $('#bar').css('display','none');
				  break;
			case '2':
				  $('#chart').css('display','none');
				  $('#list').css('display','block');
				  $('#bar').css('display','none');
				  break;
			case '3':
				 $('#chart').css('display','none');
				 $('#list').css('display','none');
				 $('#bar').css('display','block');
		}
	});
	});
	 function show(color){
	$('#multiple_leg').prop('checked',false);
	$('#s_all').prop('checked',false);
	$('#h_all').prop('checked',false);
	 var color_class='.'+color;
	 var legend_id='#'+color+'_leg';
	 chars=$('.char>a');
	//console.log(chars);
	 if($(legend_id).is(':checked')){
		current.push(color);
		$('.chosen_colors').css( 'background-color','white');
		$('.chosen_colors').css( 'color','black');
		chars.each(function(index, e){
			class_list=e.className.split(/\s+/);
			
			var results = [];
			for (var i = 0; i < class_list.length; i++) {
				if (current.indexOf(class_list[i]) !== -1) {
					results.push(class_list[i]);
				}
			}
			//console.log(e);
			//console.log(class_list);
			if(results.length==0){
				$(e).css( 'background-color','white');
				$(e).css( 'color','black');
			}else if(results.length==1){
				//console.log(results.length);
				
				$(e).css( 'background-color',results[0]);
				$(e).css( 'color','white');
			}else{
				$(e).css( 'background-color','fuchsia');
				$(e).css( 'color','white');
			}
		});
		
	}else{
			//console.log(current);
			var index = current.indexOf(color);
			//console.log(index);
			if (index > -1) {
			current.splice(index, 1)
			}
			//console.log(current);
		$('.chosen_colors').css( 'background-color','white');
		chars.each(function(index, e){
			class_list=e.className.split(/\s+/);
			//find intersection between current color and the classes of a particular character
			var results = [];
			for (var i = 0; i < class_list.length; i++) {
				if (current.indexOf(class_list[i]) !== -1) {
					results.push(class_list[i]);
				}
			}
			//console.log(results);
			if(results.length==0){
				$(e).css( 'background-color','white');
				$(e).css( 'color','black');
			}else if(results.length==1){
				$(e).css( 'background-color',results[0]);
				$(e).css( 'color','white');
			}else{
				$(e).css( 'background-color','fuchsia');
				$(e).css( 'color','white');
			}
		});			
			
		}	
   }
 function showAll(){
	chars=$('.char>a');
	if($("#s_all").is(':checked')){
		$('.common_leg').prop('checked',false);
		$('#multiple_leg').prop('checked',false);
		$('#h_all').prop('checked',false);
		current=[];
		chars.each(function(index, e){
			class_list=e.className.split(/\s+/);
			var download_check=class_list.indexOf('download_now');
			var multiple_check=class_list.indexOf('multiple');
			//console.log(e);
			if(multiple_check!=-1){
				//console.log(multiple_check);
				$(e).css( 'background-color','fuchsia');
				$(e).css( 'color','white');
			}else if(download_check!=-1){
				$(e).css( 'background-color',class_list[0]);
				$(e).css( 'color','white');
			}else{
				$(e).css( 'background-color','white');
				$(e).css( 'color','black');
			}
			});
	}
   }
   function hideAll(){
	if($("#h_all").is(':checked')){
		$('.common_leg').prop('checked',false);
		$('#multiple_leg').prop('checked',false);
		$('#s_all').prop('checked',false);
		current=[];
		$('.chosen_colors').css( 'background-color','white');
		$('.chosen_colors').css( 'color','black');
	}
   }
   function showMultiple(){
    if($('#multiple_leg').is(':checked')){
		$('.common_leg').prop('checked',false);
		current=[];
		$('.chosen_colors').css( 'background-color','white');
		$('.chosen_colors').css( 'color','black');
		$('.multiple').css( 'background-color','fuchsia');
		$('.multiple').css( 'color','white');
	}else{
		
		$('.chosen_colors').css( 'background-color','white');
		$('.chosen_colors').css( 'color','black');
	}
   }