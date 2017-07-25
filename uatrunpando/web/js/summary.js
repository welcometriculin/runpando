var abcObj = '';
jQuery(document).ready(function () {
	assign_to =  $('#plancards-assign_to').val();
	//var location =   $('#plancards-location').val();
	from_date =  $('#plancards-from_date').val();
	to_date =    $('#plancards-to_date').val();
	if(assign_to != '' && from_date != '' && to_date != '') {
		summaryData(assign_to,location,from_date,to_date);
	}
	$('#summary_button').click(function(){
		
		assign_to =  $('#plancards-assign_to').val();
		//var location =   $('#plancards-location').val();
		from_date =  $('#plancards-from_date').val();
		to_date =    $('#plancards-to_date').val();
		unixtimestamp1= window.unixtime1;
		unixtimestamp2 = window.unixtime2;
		var timestamp = true;
		if(unixtimestamp1 > unixtimestamp2) {
			timestamp = false;
			$(".field-plancards-to_date").removeClass("has-success");
			$(".field-plancards-to_date").addClass("has-error");
			$("div.field-plancards-to_date").find("div").html("To Date should be greater than From Date.");
			//$('.export').css('display','none');
		}
		
		/*if(location == '') {
			$('.field-plancards-location').removeClass('has-success');
			$('.field-plancards-location').addClass('has-error');
			$('div.field-plancards-location').find('div').html('Location cannot be blank.');
		}*/
		
		if(from_date == '') {
			$('.field-plancards-from_date').removeClass('has-success');
			$('.field-plancards-from_date').addClass('has-error');
			$('div.field-plancards-from_date').find('div').html('From Date cannot be blank.');
		}
		if(to_date == '') {
			$('.field-plancards-to_date').removeClass('has-success');
			$('.field-plancards-to_date').addClass('has-error');
			$('div.field-plancards-to_date').find('div').html('To Date cannot be blank.');
		}
		if(assign_to == '') {
			$('.field-plancards-assign_to').removeClass('has-success');
			$('.field-plancards-assign_to').addClass('has-error');
			$('div.field-plancards-assign_to').find('div').html('Your Team cannot be blank.');
		}
		if(assign_to != '' && from_date != '' && to_date != '' && timestamp) {
			summaryData(assign_to,location,from_date,to_date);
		}
		});	
	
	function summaryData(assign_to,location,from_date,to_date) {
		$.ajax({
		 	type: 'post',
		 	url:'download',
		 	async:false,
			//data:{assign_to:assign_to,location:location,from_date:from_date,to_date:to_date,indication:'req'},
		 	data:{assign_to:assign_to,from_date:from_date,to_date:to_date,indication:'req'},
		 	beforeSend: function()
    		{
        		$('#data_loader').show();
        		//console.log('aa');
    		},
			success: function(response){
				result = eval(response);
				if(result[2] == 0) {
				$('.export').css('display','none');	
				} else {
				$('.export').css('display','block');	
				}
			$('#summary_tabs').css('display','block');	
			//$('#summary1').html(response)
			abcObj = result[0];
			$('#summary1').html(result[0]);
			$('#summary2').html(result[1]);
			$('#data_loader').hide();
			}
		});
}
	/* pjax.connect({
		    'container': 'pageContent',
		    'beforeSend': function(){ $('#sai').show(); },
		    'complete': function(){ $('#sai').hide();}
		  });*/
});