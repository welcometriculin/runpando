/**
 * 
 */
jQuery(document).ready(function(){
//channel card dynamic form start
	$myGroup = $('#partner-refresh');
	$myGroup.on('show.bs.collapse','.collapse', function() {
	    $myGroup.find('.collapse.in').collapse('hide');
	});
//step 3 all files
$("input:radio[name='FormBuilder[step_1_chrequire]']").on('change',function() {
    var value = $(this).val();
   // alert(value);
    if(value == 1) {
		$('#total_ch_fields').show();
		$('#total_ch_fields input').removeAttr('disabled');
		$('#total_ch_fields select').removeAttr('disabled','disabled');
		$("input[name='FormBuilder[step_1_field1_chrequire]'][value='1']").click();
		$("input[name='FormBuilder[step_1_field1_chrequire]'][value='1']").prop("checked",true);
		$("input[name='FormBuilder[step_1_field1_chmandatory]'][value='1']").prop("checked",true);
		$("input[name='FormBuilder[step_1_field2_chrequire]'][value='1']").click();
		$("input[name='FormBuilder[step_1_field2_chrequire]'][value='1']").prop("checked",true);
		$("input[name='FormBuilder[step_1_field2_chmandatory]'][value='1']").prop("checked",true);
		$("input[name='FormBuilder[step_1_field3_chrequire]'][value='1']").click();
		$("input[name='FormBuilder[step_1_field3_chrequire]'][value='1']").prop("checked",true);
		$("input[name='FormBuilder[step_1_field3_chmandatory]'][value='1']").prop("checked",true);
		$("input[name='FormBuilder[step_1_field4_chrequire]'][value='1']").click();
		$("input[name='FormBuilder[step_1_field4_chrequire]'][value='1']").prop("checked",true);
		$("input[name='FormBuilder[step_1_field4_chmandatory]'][value='1']").prop("checked",true);
		$("input[name='FormBuilder[step_1_field5_chrequire]'][value='1']").click();
		$("input[name='FormBuilder[step_1_field5_chrequire]'][value='1']").prop("checked",true);
		$("input[name='FormBuilder[step_1_field5_chmandatory]'][value='1']").prop("checked",true);
		$('#formbuilder-product_id').val('');
		$('#formbuilder-step_1_field1_chlabel').val('');
		$('#formbuilder-step_1_field1_chdata_type').val('');
		$('#formbuilder-step_1_field1_chvalidation_type').val('');
		$('#formbuilder-step_1_field1_chno_chars').val('');
		$('#step_1_field1_chvalidation_type').css('display', 'none');
		$('#formbuilder-step_1_field1_chfield_value').val('');
		$('#step_1_field1_chvlaue').css('display', 'none');
		$('.step_1_field1_chfield_boxes').remove();
		$('#formbuilder-step_1_field2_chlabel').val('');
		$('#formbuilder-step_1_field2_chdata_type').val('');
		$('#formbuilder-step_1_field2_chvalidation_type').val('');
		$('#step_1_field2_chvalidation_type').css('display', 'none');
		$('#formbuilder-step_1_field2_chfield_value').val('');
		$('#step_1_field2_chvlaue').css('display', 'none');
		$('.step_1_field2_chfield_boxes').remove();
		$('#formbuilder-step_1_field3_chlabel').val('');
		$('#formbuilder-step_1_field3_chdata_type').val('');
		$('#formbuilder-step_1_field3_chvalidation_type').val('');
		$('#step_1_field3_chvalidation_type').css('display', 'none');
		$('#formbuilder-step_1_field3_chfield_value').val('');
		$('#step_1_field3_chvlaue').css('display', 'none');
		$('.step_1_field3_chfield_boxes').remove();
		$('#formbuilder-step_1_field4_chlabel').val('');
		$('#formbuilder-step_1_field4_chdata_type').val('');
		$('#formbuilder-step_1_field4_chvalidation_type').val('');
		$('#formbuilder-step_1_field4_chno_chars').val('');
		$('#step_1_field4_chvalidation_type').css('display', 'none');
		$('#formbuilder-step_1_field4_chfield_value').val('');
		$('#step_1_field4_chvlaue').css('display', 'none');
		$('.step_1_field4_chfield_boxes').remove();
		$('#formbuilder-step_1_field5_chlabel').val('');
		$('#formbuilder-step_1_field5_chdata_type').val('');
		$('#formbuilder-step_1_field5_chvalidation_type').val('');
		$('#formbuilder-step_1_field5_chno_chars').val('');
		$('#step_1_field5_chvalidation_type').css('display', 'none');
		$('#formbuilder-step_1_field5_chfield_value').val('');
		$('#step_1_field5_chvlaue').css('display', 'none');
		$('.step_1_field5_chfield_boxes').remove();
		$("input:radio[name='FormBuilder[step_1_chrequire]']").parents(':eq(2)').removeClass('grey-bg');
		$("input:radio[name='FormBuilder[step_1_field1_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');

	} else if(value == 0) {
		$('#total_ch_fields').hide();
		$('#total_ch_fields input').attr('disabled','disabled');
		$('#total_ch_fields select').attr('disabled','disabled');
		$("input[name='FormBuilder[step_1_field1_chrequire]'][value='0']").prop("checked",true);
		$("input[name='FormBuilder[step_1_field2_chrequire]'][value='0']").prop("checked",true);
		$("input[name='FormBuilder[step_1_field3_chrequire]'][value='0']").prop("checked",true);
		$("input[name='FormBuilder[step_1_field4_chrequire]'][value='0']").prop("checked",true);
		$("input[name='FormBuilder[step_1_field5_chrequire]'][value='0']").prop("checked",true);
		$("input:radio[name='FormBuilder[step_1_chrequire]']").parents(':eq(2)').addClass('grey-bg');
		$("input:radio[name='FormBuilder[step_1_field1_chmandatory]']").parents(':eq(2)').addClass('grey-bg');
		$('.step_1_field1_chfield_boxes').remove();
		$('.step_1_field2_chfield_boxes').remove();
		$('.step_1_field3_chfield_boxes').remove();
		$('.step_1_field4_chfield_boxes').remove();
		$('.step_1_field5_chfield_boxes').remove();
		//$('#total_ch_fields input').hide();
    }
});
//step1
//field 1 
$("input:radio[name='FormBuilder[step_1_field1_chrequire]']").on('change',function() {
	var value = $(this).val();
	if(value == 1) {
		$('#step_1_chfield1').css('display','block');
		$("input[name='FormBuilder[step_1_field1_chmandatory]'][value='1']").prop("checked",true);
		$("input:radio[name='FormBuilder[step_1_field1_chrequire]']").parents(':eq(2)').removeClass('grey-bg');
		$("input[name='FormBuilder[step_1_field1_chmandatory]'][value='1']").click();
		$("input[name='FormBuilder[step_1_field1_chmandatory]'][value='1']").prop("checked",true);
		$("input:radio[name='FormBuilder[step_1_field1_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');
	//	$('#step_5_field1 input').removeAttr('disabled');
	//	$('#step_5_field1 select').removeAttr('disabled');
	} else if(value == 0) {
		$("input[name='FormBuilder[step_1_field1_chmandatory]'][value='0']").click();
		$("input[name='FormBuilder[step_1_field1_chmandatory]'][value='0']").prop("checked",true);
		$("input:radio[name='FormBuilder[step_1_field1_chmandatory]']").parents(':eq(2)').addClass('grey-bg');
		$('#formbuilder-step_1_field1_chlabel').val('');
		$('#formbuilder-step_1_field1_chdata_type').val('');
		$('#formbuilder-step_1_field1_chno_chars').val('');
		$('#formbuilder-step_1_field1_chvalidation_type').val('');
		$('#step_1_field1_chvalidation_type').css("display","none");
		$('#formbuilder-step_1_field1_chfield_value').val('');
		$('#step_1_field1_chvlaue').css("display","none");
		$('.step_1_field1_chfield_boxes').remove();
		$('#step_1_field1 input').val('');
		$('#step_1_field1 select').val('');
		$('#step_1_chfield1').hide();
		$('#step_1_field1_chvlaue input').attr("disabled","disabled");
		$("input:radio[name='FormBuilder[step_1_field1_chrequire]']").parents(':eq(2)').addClass('grey-bg');
} 
});	
//step 1 mandatory
$("input:radio[name='FormBuilder[step_1_field1_chmandatory]']").on('change',function() {
	value = $(this).val();
	if(value == 1) {
		$("input:radio[name='FormBuilder[step_1_field1_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');
	} else if(value == 0) {
		$("input:radio[name='FormBuilder[step_1_field1_chmandatory]']").parents(':eq(2)').addClass('grey-bg');
	} 
});



$('#formbuilder-step_1_field1_chdata_type').on('change',function(){
	var data_type_value = $(this).val();
	if(data_type_value == 'edittext') {
		$('#formbuilder-step_1_field1_chvalidation_type').val('');	
		$('#step_1_field1_chvalidation_type').css("display","block");
		$('#formbuilder-step_1_field1_chno_chars').val('');	
		$('#step_1_field1_chno_of_chars').css("display","block");
		$('#formbuilder-step_1_field1_chfield_value').val('');
		$('.step_1_field1_chfield_boxes').remove();
		$('#step_1_field1_chvlaue input').attr("disabled","disabled");
		$('#step_1_field1_chvlaue').css("display","none");
	} else if(data_type_value == 'radio' || data_type_value == 'selectbox' || data_type_value == 'checkbox') {
		$('#formbuilder-step_1_field1_chno_chars').val('');	
		$('#step_1_field1_chno_of_chars').css("display","none");
		$('#formbuilder-step_1_field1_chvalidation_type').val('');
		$('#step_1_field1_chvalidation_type').css("display","none");
		$('#formbuilder-step_1_field1_chfield_value').val('');
		$('.step_1_field1_chfield_boxes').remove();
		$('#step_1_field1_chvlaue input').removeAttr('disabled');
		$('#step_1_field1_chvlaue').css("display","block");
	}  else if(data_type_value == 'textarea') {
		$('#formbuilder-step_1_field1_chno_chars').val('');	
		$('#step_1_field1_chno_of_chars').css("display","block");
		$('#formbuilder-step_1_field1_chvalidation_type').val('');	
		$('#step_1_field1_chvalidation_type').css("display","none");
		$('#formbuilder-step_1_field1_chfield_value').val('');
		$('.step_1_field1_chfield_boxes').remove();
		$('#step_1_field1_chvalidation_type').css("display","none");
		$('#step_1_field1_chvlaue input').attr("disabled","disabled");
		$('#step_1_field1_chvlaue').css("display","none");
	}  else if(data_type_value == 'rating') {
		$('#formbuilder-step_1_field1_chno_chars').val('');	
		$('#step_1_field1_chno_of_chars').css("display","none");
		$('#formbuilder-step_1_field1_chvalidation_type').val('');	
		$('#step_1_field1_chvalidation_type').css("display","none");
		$('#formbuilder-step_1_field1_chfield_value').val('');
		$('.step_1_field1_chfield_boxes').remove();
		$('#step_1_field1_chvalidation_type').css("display","none");
		$('#step_1_field1_chvlaue input').attr("disabled","disabled");
		$('#step_1_field1_chvlaue').css("display","none");
	} else {
		$('#formbuilder-step_1_field1_chno_chars').val('');	
		$('#step_1_field1_chno_of_chars').css("display","none");
		$('#formbuilder-step_1_field1_chvalidation_type').val('');	
		$('#step_1_field1_chvalidation_type').css("display","none");
		$('#formbuilder-step_1_field1_chfield_value').val('');
		$('#step_1_field1_chvlaue').css("display","none");
		$('#step_1_field1_chvlaue input').attr("disabled","disabled");
		$('.step_1_field1_chfield_boxes').remove();
	}
})		
//add more
$("#step_1_field1_chvlaue .form-group .add-txt").click(function(){
     var no = $(".form-group").length + 1;
      var more_textbox = $('<div class="form-group step_1_field1_chfield_boxes">' +
      '</span></label>' +
      '<div class="row"><div class="col-sm-offset-6 col-sm-6 col-md-offset-3 col-md-9 col-lg-offset-4 col-lg-4"><div class="dd-check"><span class="pull-left"><input class="form-control" type="text" name="step_1_field1_chfield_boxes[]" id="txtbox' + no + '" />' +
      '</span><span class="cb"><a href="#" class="btn btn-danger btn-xs remove-txt"><i class="fa fa-minus"></i></a></span>' +
      '</div></div><div class="help-block"></div></div></div>');
      more_textbox.hide();
      $("#step_1_field1_chvlaue .form-group:last").after(more_textbox);
      more_textbox.fadeIn("slow");
      $(".field-formbuilder-step_1_field1_chfield_value").find('.help-error').html('');
      return false;
  });

//Remove
  $('#step_1_field1_chvlaue').on('click', '.remove-txt', function(){
      $(this).parents(':eq(4)').fadeOut("slow", function() {
          $(this).remove();
        /*   $('.label-numbers').each(function( index ){
              $(this).text( index + 1 );
          }); */
      });
      return false;
  }); 
  
//step1
//field 1 
$("input:radio[name='FormBuilder[step_1_field2_chrequire]']").on('change',function() {
	var value = $(this).val();
	if(value == 1) {
		$('#step_1_chfield2').css('display','block');
		$("input[name='FormBuilder[step_1_field2_chmandatory]'][value='1']").prop("checked",true);
		$("input:radio[name='FormBuilder[step_1_field2_chrequire]']").parents(':eq(2)').removeClass('grey-bg');
		$("input[name='FormBuilder[step_1_field2_chmandatory]'][value='1']").click();
		$("input[name='FormBuilder[step_1_field2_chmandatory]'][value='1']").prop("checked",true);
		$("input:radio[name='FormBuilder[step_1_field2_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');
	//	$('#step_5_field1 input').removeAttr('disabled');
	//	$('#step_5step_4_chfield1t').removeAttr('disabled');
	} else if(value == 0) {
		$("input[name='FormBuilder[step_1_field2_chmandatory]'][value='0']").click();
		$("input[name='FormBuilder[step_1_field2_chmandatory]'][value='0']").prop("checked",true);
		$("input:radio[name='FormBuilder[step_1_field2_chmandatory]']").parents(':eq(2)').addClass('grey-bg');
		$('#formbuilder-step_1_field2_chlabel').val('');
		$('#formbuilder-step_1_field2_chdata_type').val('');
		$('#formbuilder-step_1_field2_chno_chars').val('');
		$('#step_1_field2_chno_of_chars').css("display","none");
		$('#formbuilder-step_1_field2_chvalidation_type').val('');
		$('#step_1_field2_chvalidation_type').css("display","none");
		$('#formbuilder-step_1_field2_chfield_value').val('');
		$('#step_1_field2_chvlaue').css("display","none");
		$('.step_1_field2_chfield_boxes').remove();
		$('#step_1_field2 input').val('');
	    $('#step_1_field2 select').val('');
	    $('#step_1_chfield2').hide();
	    $('#step_1_field2_chvlaue input').attr("disabled","disabled");
	    $("input:radio[name='FormBuilder[step_1_field2_chrequire]']").parents(':eq(2)').addClass('grey-bg');
	} 
});		
$("input:radio[name='FormBuilder[step_1_field2_chmandatory]']").on('change',function() {
	value = $(this).val();
	if(value == 1) {
		$("input:radio[name='FormBuilder[step_1_field2_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');
	} else if(value == 0) {
		$("input:radio[name='FormBuilder[step_1_field2_chmandatory]']").parents(':eq(2)').addClass('grey-bg');
	} 
});
$('#formbuilder-step_1_field2_chdata_type').on('change',function(){
	var data_type_value = $(this).val();
	if(data_type_value == 'edittext') {
		$('#formbuilder-step_1_field2_chno_chars').val('');
		$('#step_1_field2_chno_of_chars').css("display","block");
		$('#formbuilder-step_1_field2_chvalidation_type').val('');
		$('#step_1_field2_chvalidation_type').css("display","block");
		$('#formbuilder-step_1_field2_chfield_value').val('');
		$('.step_1_field2_chfield_boxes').remove();
		$('#step_1_field2_chvlaue input').attr("disabled","disabled");
		$('#step_1_field2_chvlaue').css("display","none");
	} else if(data_type_value == 'radio' || data_type_value == 'selectbox' || data_type_value == 'checkbox') {
		$('#formbuilder-step_1_field2_chno_chars').val('');
		$('#step_1_field2_chno_of_chars').css("display","none");
		$('#formbuilder-step_1_field2_chvalidation_type').val('');
		$('#step_1_field2_chvalidation_type').css("display","none");
		$('#formbuilder-step_1_field2_chfield_value').val('');
		$('.step_1_field2_chfield_boxes').remove();
		$('#step_1_field2_chvlaue input').removeAttr('disabled');
		$('#step_1_field2_chvlaue').css("display","block");
	}  else if(data_type_value == 'textarea') {
		$('#formbuilder-step_1_field2_chno_chars').val('');
		$('#step_1_field2_chno_of_chars').css("display","block");
		$('#formbuilder-step_1_field2_chvalidation_type').val('');
		$('#step_1_field2_chvalidation_type').css("display","none");
		$('#formbuilder-step_1_field2_chfield_value').val('');
		$('.step_1_field2_chfield_boxes').remove();
		$('#step_1_field2_chvlaue input').attr("disabled","disabled");
		$('#step_1_field2_chvlaue').css("display","none");
	} else if(data_type_value == 'rating') {
		$('#formbuilder-step_1_field2_chvalidation_type').val('');
		$('#step_1_field2_chvalidation_type').css("display","none");
		$('#formbuilder-step_1_field2_chfield_value').val('');
		$('.step_1_field2_chfield_boxes').remove();
		$('#step_1_field2_chvlaue input').attr("disabled","disabled");
		$('#step_1_field2_chvlaue').css("display","none");
		$('#formbuilder-step_1_field2_chno_chars').val('');
		$('#step_1_field2_chno_of_chars').css("display","none");
	} else {
		$('#formbuilder-step_1_field2_chno_chars').val('');
		$('#step_1_field2_chno_of_chars').css("display","none");
		$('#formbuilder-step_1_field2_chvalidation_type').val('');
		$('#step_1_field2_chvalidation_type').css("display","none");
		$('#formbuilder-step_1_field2_chfield_value').val('');
		$('#step_1_field2_chvlaue').css("display","none");
		$('#step_1_field2_chvlaue input').attr("disabled","disabled");
		$('.step_1_field2_chfield_boxes').remove();
	}
})		
//add more
$("#step_1_field2_chvlaue .form-group .add-txt").click(function(){
       var no = $(".form-group").length + 1;
        var more_textbox = $('<div class="form-group step_1_field2_chfield_boxes">' +
        '</span></label>' +
        '<div class="row"><div class="col-sm-offset-6 col-sm-6 col-md-offset-3  col-md-9 col-lg-offset-4 col-lg-4"><div class="dd-check"><span class="pull-left"><input class="form-control" type="text" name="step_1_field2_chfield_boxes[]" id="txtbox' + no + '" />' +
        '</span><span class="cb"><a href="#" class="btn btn-danger btn-xs remove-txt"><i class="fa fa-minus"></i></a></span>' +
        '</div></div><div class="help-block"></div></div></div>');
        more_textbox.hide();
        $("#step_1_field2_chvlaue .form-group:last").after(more_textbox);
        more_textbox.fadeIn("slow");
        $(".field-formbuilder-step_1_field2_chfield_value").find('.help-error').html('');
        return false;
    });

//Remove
    $('#step_1_field2_chvlaue').on('click', '.remove-txt', function(){
        $(this).parents(':eq(4)').fadeOut("slow", function() {
            $(this).remove();
          /*   $('.label-numbers').each(function( index ){
                $(this).text( index + 1 );
            }); */
        });
        return false;
    }); 
    
    //step1
    //field 1 
    $("input:radio[name='FormBuilder[step_1_field3_chrequire]']").on('change',function() {
    var value = $(this).val();
    if(value == 1) {
    	$('#step_1_chfield3').css('display','block');
    	$("input[name='FormBuilder[step_1_field3_chmandatory]'][value='1']").prop("checked",true);
    	$("input:radio[name='FormBuilder[step_1_field3_chrequire]']").parents(':eq(2)').removeClass('grey-bg');
    	$("input[name='FormBuilder[step_1_field3_chmandatory]'][value='1']").click();
		$("input[name='FormBuilder[step_1_field3_chmandatory]'][value='1']").prop("checked",true);
		$("input:radio[name='FormBuilder[step_1_field3_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');
//    	$('#step_5_field1 input').removeAttr('disabled');
//    	$('#step_5_field1 select').removeAttr('disabled');
    } else if(value == 0) {
    	$("input[name='FormBuilder[step_1_field3_chmandatory]'][value='0']").click();
		$("input[name='FormBuilder[step_1_field3_chmandatory]'][value='0']").prop("checked",true);
		$("input:radio[name='FormBuilder[step_1_field3_chmandatory]']").parents(':eq(2)').addClass('grey-bg');
    	$('#formbuilder-step_1_field3_chlabel').val('');
		$('#formbuilder-step_1_field3_chdata_type').val('');
		$('#formbuilder-step_1_field3_chno_chars').val('');
		$('#step_1_field3_chno_of_chars').css("display","none");
		$('#formbuilder-step_1_field3_chvalidation_type').val('');
		$('#step_1_field3_chvalidation_type').css("display","none");
		$('#formbuilder-step_1_field3_chfield_value').val('');
		$('#step_1_field3_chvlaue').css("display","none");
		$('.step_1_field3_chfield_boxes').remove();
    	$('#step_1_chfield3 select').val('');
    	$('#step_1_chfield3').hide();
    	$('#step_1_field3_chvlaue input').attr("disabled","disabled");
    	$("input:radio[name='FormBuilder[step_1_field3_chrequire]']").parents(':eq(2)').addClass('grey-bg');
    } 
    });		
    $("input:radio[name='FormBuilder[step_1_field3_chmandatory]']").on('change',function() {
    	value = $(this).val();
    	if(value == 1) {
    		$("input:radio[name='FormBuilder[step_1_field3_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');
    	} else if(value == 0) {
    		$("input:radio[name='FormBuilder[step_1_field3_chmandatory]']").parents(':eq(2)').addClass('grey-bg');
    	} 
    });
    $('#formbuilder-step_1_field3_chdata_type').on('change',function(){
	    var data_type_value = $(this).val();
	    if(data_type_value == 'edittext') {
	    	$('#formbuilder-step_1_field3_chno_chars').val('');
			$('#step_1_field3_chno_of_chars').css("display","block");
	    	$('#formbuilder-step_1_field3_chvalidation_type').val('');
	    	$('#step_1_field3_chvalidation_type').css("display","block");
			$('#formbuilder-step_1_field3_chfield_value').val('');
			$('.step_1_field3_chfield_boxes').remove();
	    	$('#step_1_field3_chvlaue input').attr("disabled","disabled");
		    $('#step_1_field3_chvlaue').css("display","none");
	    } else if(data_type_value == 'radio' || data_type_value == 'selectbox' || data_type_value == 'checkbox') {
	    	$('#formbuilder-step_1_field3_chno_chars').val('');
			$('#step_1_field3_chno_of_chars').css("display","none");
	    	$('#formbuilder-step_1_field3_chvalidation_type').val('');
	    	$('#step_1_field3_chvalidation_type').css("display","none");
			$('#formbuilder-step_1_field3_chfield_value').val('');
			$('.step_1_field3_chfield_boxes').remove();
		    $('#step_1_field3_chvlaue input').removeAttr('disabled');
		    $('#step_1_field3_chvlaue').css("display","block");
	    }  else if(data_type_value == 'textarea') {
	    	$('#formbuilder-step_1_field3_chno_chars').val('');
			$('#step_1_field3_chno_of_chars').css("display","block");
	    	$('#formbuilder-step_1_field3_chvalidation_type').val('');
	    	$('#step_1_field3_chvalidation_type').css("display","none");
			$('#formbuilder-step_1_field3_chfield_value').val('');
			$('.step_1_field3_chfield_boxes').remove();
		    $('#step_1_field3_chvlaue input').attr("disabled","disabled");
		    $('#step_1_field3_chvlaue').css("display","none");
		}  else if(data_type_value == 'rating') {
	    	$('#formbuilder-step_1_field3_chno_chars').val('');
			$('#step_1_field3_chno_of_chars').css("display","none");
	    	$('#formbuilder-step_1_field3_chvalidation_type').val('');
	    	$('#step_1_field3_chvalidation_type').css("display","none");
			$('#formbuilder-step_1_field3_chfield_value').val('');
			$('.step_1_field3_chfield_boxes').remove();
		    $('#step_1_field3_chvlaue input').attr("disabled","disabled");
		    $('#step_1_field3_chvlaue').css("display","none");
		} else {
			$('#formbuilder-step_1_field3_chno_chars').val('');
			$('#step_1_field3_chno_of_chars').css("display","none");
			$('#formbuilder-step_1_field3_chvalidation_type').val('');
			$('#step_1_field3_chvalidation_type').css("display","none");
			$('#formbuilder-step_1_field3_chfield_value').val('');
			$('#step_1_field3_chvlaue').css("display","none");
			$('#step_1_field3_chvlaue input').attr("disabled","disabled");
			$('.step_1_field3_chfield_boxes').remove();
		}
    })		
    //add more
    $("#step_1_field3_chvlaue .form-group .add-txt").click(function(){
           var no = $(".form-group").length + 1;
            var more_textbox = $('<div class="form-group step_1_field3_chfield_boxes">' +
            '</span></label>' +
            '<div class="row"><div class="col-sm-offset-6 col-sm-6 col-md-offset-5  col-md-7 col-lg-offset-4 col-lg-4"><div class="dd-check"><span class="pull-left"><input class="form-control" type="text" name="step_1_field3_chfield_boxes[]" id="txtbox' + no + '" />' +
            '</span><span class="cb"><a href="#" class="btn btn-danger btn-xs remove-txt"><i class="fa fa-minus"></i></a></span>' +
            '</div></div><div class="help-block"></div></div></div>');
            more_textbox.hide();
            $("#step_1_field3_chvlaue .form-group:last").after(more_textbox);
            more_textbox.fadeIn("slow");
            $(".field-formbuilder-step_1_field3_chfield_value").find('.help-error').html('');
            return false;
        });

    //Remove
        $('#step_1_field3_chvlaue').on('click', '.remove-txt', function(){
            $(this).parents(':eq(4)').fadeOut("slow", function() {
                $(this).remove();
              /*   $('.label-numbers').each(function( index ){
                    $(this).text( index + 1 );
                }); */
            });
            return false;
        }); 
        
      //step1
      //field 4 
      $("input:radio[name='FormBuilder[step_1_field4_chrequire]']").on('change',function() {
      	var value = $(this).val();
      	if(value == 1) {
      		$('#step_1_chfield4').css('display','block');
      		$("input[name='FormBuilder[step_1_field4_chmandatory]'][value='1']").prop("checked",true);
      		$("input:radio[name='FormBuilder[step_1_field4_chrequire]']").parents(':eq(2)').removeClass('grey-bg');
      		$("input[name='FormBuilder[step_1_field4_chmandatory]'][value='1']").click();
    		$("input[name='FormBuilder[step_1_field4_chmandatory]'][value='1']").prop("checked",true);
    		$("input:radio[name='FormBuilder[step_1_field4_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');
      	//	$('#step_5_field1 input').removeAttr('disabled');
      	//	$('#step_5_field1 select').removeAttr('disabled');
      	} else if(value == 0) {
      		$("input[name='FormBuilder[step_1_field4_chmandatory]'][value='0']").click();
    		$("input[name='FormBuilder[step_1_field4_chmandatory]'][value='0']").prop("checked",true);
    		$("input:radio[name='FormBuilder[step_1_field4_chmandatory]']").parents(':eq(2)').addClass('grey-bg');
      		$('#formbuilder-step_1_field4_chlabel').val('');
      		$('#formbuilder-step_1_field4_chdata_type').val('');
      		$('#formbuilder-step_1_field4_chno_chars').val('');
      		$('#formbuilder-step_1_field4_chvalidation_type').val('');
      		$('#step_1_field4_chvalidation_type').css("display","none");
      		$('#formbuilder-step_1_field4_chfield_value').val('');
      		$('#step_1_field4_chvlaue').css("display","none");
      		$('.step_1_field4_chfield_boxes').remove();
      		$('#step_1_field4 input').val('');
      		$('#step_1_field4 select').val('');
      		$('#step_1_chfield4').hide();
      		$('#step_1_field4_chvlaue input').attr("disabled","disabled");
      		$("input:radio[name='FormBuilder[step_1_field4_chrequire]']").parents(':eq(2)').addClass('grey-bg');
      } 
      });	
      //step 1 mandatory
      $("input:radio[name='FormBuilder[step_1_field4_chmandatory]']").on('change',function() {
      	value = $(this).val();
      	if(value == 1) {
      		$("input:radio[name='FormBuilder[step_1_field4_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');
      	} else if(value == 0) {
      		$("input:radio[name='FormBuilder[step_1_field4_chmandatory]']").parents(':eq(2)').addClass('grey-bg');
      	} 
      });
      
      $('#formbuilder-step_1_field4_chdata_type').on('change',function(){
      	var data_type_value = $(this).val();
      	if(data_type_value == 'edittext') {
      		$('#formbuilder-step_1_field4_chvalidation_type').val('');	
      		$('#step_1_field4_chvalidation_type').css("display","block");
      		$('#formbuilder-step_1_field4_chno_chars').val('');	
      		$('#step_1_field4_chno_of_chars').css("display","block");
      		$('#formbuilder-step_1_field4_chfield_value').val('');
      		$('.step_1_field4_chfield_boxes').remove();
      		$('#step_1_field4_chvlaue input').attr("disabled","disabled");
      		$('#step_1_field4_chvlaue').css("display","none");
      	} else if(data_type_value == 'radio' || data_type_value == 'selectbox' || data_type_value == 'checkbox') {
      		$('#formbuilder-step_1_field4_chno_chars').val('');	
      		$('#step_1_field4_chno_of_chars').css("display","none");
      		$('#formbuilder-step_1_field4_chvalidation_type').val('');
      		$('#step_1_field4_chvalidation_type').css("display","none");
      		$('#formbuilder-step_1_field4_chfield_value').val('');
      		$('.step_1_field4_chfield_boxes').remove();
      		$('#step_1_field4_chvlaue input').removeAttr('disabled');
      		$('#step_1_field4_chvlaue').css("display","block");
      	}  else if(data_type_value == 'textarea') {
      		$('#formbuilder-step_1_field4_chno_chars').val('');	
      		$('#step_1_field4_chno_of_chars').css("display","block");
      		$('#formbuilder-step_1_field4_chvalidation_type').val('');	
      		$('#step_1_field4_chvalidation_type').css("display","none");
      		$('#formbuilder-step_1_field4_chfield_value').val('');
      		$('.step_1_field4_chfield_boxes').remove();
      		$('#step_1_field4_chvalidation_type').css("display","none");
      		$('#step_1_field4_chvlaue input').attr("disabled","disabled");
      		$('#step_1_field4_chvlaue').css("display","none");
      	}  else if(data_type_value == 'rating') {
      		$('#formbuilder-step_1_field4_chno_chars').val('');	
      		$('#step_1_field4_chno_of_chars').css("display","none");
      		$('#formbuilder-step_1_field4_chvalidation_type').val('');	
      		$('#step_1_field4_chvalidation_type').css("display","none");
      		$('#formbuilder-step_1_field4_chfield_value').val('');
      		$('.step_1_field4_chfield_boxes').remove();
      		$('#step_1_field4_chvalidation_type').css("display","none");
      		$('#step_1_field4_chvlaue input').attr("disabled","disabled");
      		$('#step_1_field4_chvlaue').css("display","none");
      	} else {
      		$('#formbuilder-step_1_field4_chno_chars').val('');	
      		$('#step_1_field4_chno_of_chars').css("display","none");
      		$('#formbuilder-step_1_field4_chvalidation_type').val('');	
      		$('#step_1_field4_chvalidation_type').css("display","none");
      		$('#formbuilder-step_1_field4_chfield_value').val('');
      		$('#step_1_field4_chvlaue').css("display","none");
      		$('#step_1_field4_chvlaue input').attr("disabled","disabled");
      		$('.step_1_field4_chfield_boxes').remove();
      	}
      })		
      //add more
      $("#step_1_field4_chvlaue .form-group .add-txt").click(function(){
           var no = $(".form-group").length + 1;
            var more_textbox = $('<div class="form-group step_1_field4_chfield_boxes">' +
            '</span></label>' +
            '<div class="row"><div class="col-sm-offset-6 col-sm-6 col-md-offset-3 col-md-9 col-lg-offset-4 col-lg-4"><div class="dd-check"><span class="pull-left"><input class="form-control" type="text" name="step_1_field4_chfield_boxes[]" id="txtbox' + no + '" />' +
            '</span><span class="cb"><a href="#" class="btn btn-danger btn-xs remove-txt"><i class="fa fa-minus"></i></a></span>' +
            '</div></div><div class="help-block"></div></div></div>');
            more_textbox.hide();
            $("#step_1_field4_chvlaue .form-group:last").after(more_textbox);
            more_textbox.fadeIn("slow");
            $(".field-formbuilder-step_1_field4_chfield_value").find('.help-error').html('');
            return false;
        });

      //Remove
        $('#step_1_field4_chvlaue').on('click', '.remove-txt', function(){
            $(this).parents(':eq(4)').fadeOut("slow", function() {
                $(this).remove();
              /*   $('.label-numbers').each(function( index ){
                    $(this).text( index + 1 );
                }); */
            });
            return false;
        });       
        
        //step1
        //field 5 
        $("input:radio[name='FormBuilder[step_1_field5_chrequire]']").on('change',function() {
        	var value = $(this).val();
        	if(value == 1) {
        		$('#step_1_chfield5').css('display','block');
        		$("input[name='FormBuilder[step_1_field5_chmandatory]'][value='1']").prop("checked",true);
        		$("input:radio[name='FormBuilder[step_1_field5_chrequire]']").parents(':eq(2)').removeClass('grey-bg');
        		$("input[name='FormBuilder[step_1_field5_chmandatory]'][value='1']").click();
        		$("input[name='FormBuilder[step_1_field5_chmandatory]'][value='1']").prop("checked",true);
        		$("input:radio[name='FormBuilder[step_1_field5_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');
        		//	$('#step_5_field1 input').removeAttr('disabled');
        	//	$('#step_5_field1 select').removeAttr('disabled');
        	} else if(value == 0) {
        		$("input[name='FormBuilder[step_1_field5_chmandatory]'][value='0']").click();
        		$("input[name='FormBuilder[step_1_field5_chmandatory]'][value='0']").prop("checked",true);
        		$("input:radio[name='FormBuilder[step_1_field5_chmandatory]']").parents(':eq(2)').addClass('grey-bg');
        		$('#formbuilder-step_1_field5_chlabel').val('');
        		$('#formbuilder-step_1_field5_chdata_type').val('');
        		$('#formbuilder-step_1_field5_chno_chars').val('');
        		$('#formbuilder-step_1_field5_chvalidation_type').val('');
        		$('#step_1_field5_chvalidation_type').css("display","none");
        		$('#formbuilder-step_1_field5_chfield_value').val('');
        		$('#step_1_field5_chvlaue').css("display","none");
        		$('.step_1_field5_chfield_boxes').remove();
        		$('#step_1_field5 input').val('');
        		$('#step_1_field5 select').val('');
        		$('#step_1_chfield5').hide();
        		$('#step_1_field5_chvlaue input').attr("disabled","disabled");
        		$("input:radio[name='FormBuilder[step_1_field5_chrequire]']").parents(':eq(2)').addClass('grey-bg');
        } 
        });	
        //step 1 mandatory
        $("input:radio[name='FormBuilder[step_1_field5_chmandatory]']").on('change',function() {
        	value = $(this).val();
        	if(value == 1) {
        		$("input:radio[name='FormBuilder[step_1_field5_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');
        	} else if(value == 0) {
        		$("input:radio[name='FormBuilder[step_1_field5_chmandatory]']").parents(':eq(2)').addClass('grey-bg');
        	} 
        });
        
        $('#formbuilder-step_1_field5_chdata_type').on('change',function(){
        	var data_type_value = $(this).val();
        	if(data_type_value == 'edittext') {
        		$('#formbuilder-step_1_field5_chvalidation_type').val('');	
        		$('#step_1_field5_chvalidation_type').css("display","block");
        		$('#formbuilder-step_1_field5_chno_chars').val('');	
        		$('#step_1_field5_chno_of_chars').css("display","block");
        		$('#formbuilder-step_1_field5_chfield_value').val('');
        		$('.step_1_field5_chfield_boxes').remove();
        		$('#step_1_field5_chvlaue input').attr("disabled","disabled");
        		$('#step_1_field5_chvlaue').css("display","none");
        	} else if(data_type_value == 'radio' || data_type_value == 'selectbox' || data_type_value == 'checkbox') {
        		$('#formbuilder-step_1_field5_chno_chars').val('');	
        		$('#step_1_field5_chno_of_chars').css("display","none");
        		$('#formbuilder-step_1_field5_chvalidation_type').val('');
        		$('#step_1_field5_chvalidation_type').css("display","none");
        		$('#formbuilder-step_1_field5_chfield_value').val('');
        		$('.step_1_field5_chfield_boxes').remove();
        		$('#step_1_field5_chvlaue input').removeAttr('disabled');
        		$('#step_1_field5_chvlaue').css("display","block");
        	}  else if(data_type_value == 'textarea') {
        		$('#formbuilder-step_1_field5_chno_chars').val('');	
        		$('#step_1_field5_chno_of_chars').css("display","block");
        		$('#formbuilder-step_1_field5_chvalidation_type').val('');	
        		$('#step_1_field5_chvalidation_type').css("display","none");
        		$('#formbuilder-step_1_field5_chfield_value').val('');
        		$('.step_1_field5_chfield_boxes').remove();
        		$('#step_1_field5_chvalidation_type').css("display","none");
        		$('#step_1_field5_chvlaue input').attr("disabled","disabled");
        		$('#step_1_field5_chvlaue').css("display","none");
        	}  else if(data_type_value == 'rating') {
        		$('#formbuilder-step_1_field5_chno_chars').val('');	
        		$('#step_1_field5_chno_of_chars').css("display","none");
        		$('#formbuilder-step_1_field5_chvalidation_type').val('');	
        		$('#step_1_field5_chvalidation_type').css("display","none");
        		$('#formbuilder-step_1_field5_chfield_value').val('');
        		$('.step_1_field5_chfield_boxes').remove();
        		$('#step_1_field5_chvalidation_type').css("display","none");
        		$('#step_1_field5_chvlaue input').attr("disabled","disabled");
        		$('#step_1_field5_chvlaue').css("display","none");
        	} else {
        		$('#formbuilder-step_1_field5_chno_chars').val('');	
        		$('#step_1_field5_chno_of_chars').css("display","none");
        		$('#formbuilder-step_1_field5_chvalidation_type').val('');	
        		$('#step_1_field5_chvalidation_type').css("display","none");
        		$('#formbuilder-step_1_field5_chfield_value').val('');
        		$('#step_1_field5_chvlaue').css("display","none");
        		$('#step_1_field5_chvlaue input').attr("disabled","disabled");
        		$('.step_1_field5_chfield_boxes').remove();
        	}
        })		
        //add more
        $("#step_1_field5_chvlaue .form-group .add-txt").click(function(){
             var no = $(".form-group").length + 1;
              var more_textbox = $('<div class="form-group step_1_field5_chfield_boxes">' +
              '</span></label>' +
              '<div class="row"><div class="col-sm-offset-6 col-sm-6 col-md-offset-3 col-md-9 col-lg-offset-4 col-lg-4"><div class="dd-check"><span class="pull-left"><input class="form-control" type="text" name="step_1_field5_chfield_boxes[]" id="txtbox' + no + '" />' +
              '</span><span class="cb"><a href="#" class="btn btn-danger btn-xs remove-txt"><i class="fa fa-minus"></i></a></span>' +
              '</div></div><div class="help-block"></div></div></div>');
              more_textbox.hide();
              $("#step_1_field5_chvlaue .form-group:last").after(more_textbox);
              more_textbox.fadeIn("slow");
              $(".field-formbuilder-step_1_field5_chfield_value").find('.help-error').html('');
              return false;
          });

        //Remove
          $('#step_1_field5_chvlaue').on('click', '.remove-txt', function(){
              $(this).parents(':eq(4)').fadeOut("slow", function() {
                  $(this).remove();
                /*   $('.label-numbers').each(function( index ){
                      $(this).text( index + 1 );
                  }); */
              });
              return false;
          });        
        
        //step 2 field 1
        $("input:radio[name='FormBuilder[step_2_field1_chrequire]']").on('change',function() {
      	  value = $(this).val();
      	  if(value == 1) {
	      	  $('#step_2_chfield1').css('display','block');
	      	  $("input[name='FormBuilder[step_2_field1_chmandatory]'][value='1']").prop("checked",true);
	      	  $('#step_2_chfield1 input').removeAttr('disabled');
	      	  $('#step_2_chfield1 select').removeAttr('disabled');
	      	  $("input:radio[name='FormBuilder[step_2_field1_chrequire]']").parents(':eq(2)').removeClass('grey-bg');
	      	  $("#refresh_form_2_3").trigger('reset');
      	  } else if(value == 0) {
	      	  $('#step_2_chfield1 input').attr('disabled','disabled');
	      	  $('#step_2_chfield1 select').attr('disabled','disabled');

	      	 // $('#step_2_chfield1_validation_type input').attr('disabled','disabled');
	      	//  $('#step_2_chfield1_validation_type select').attr('disabled','disabled');
	      	  $('#step_2_chfield1').css('display','none');
	      	  $("input[name='FormBuilder[step_2_field1_chmandatory]'][value='0']").prop("checked",true);
	      	  $('#formbuilder-step_2_field1_chlabel1').val('');
	      	  $('#formbuilder-step_2_field2_chlabel2').val('');
	      	  $('#formbuilder-step_2_field3_chlabel3').val('');
	      	  $('#step_2_chfield1 select').val('');
	      	$("input:radio[name='FormBuilder[step_2_field1_chrequire]']").parents(':eq(2)').addClass('grey-bg');
      	  } 
      	  }); 
        $("input:radio[name='FormBuilder[step_2_field1_chmandatory]']").on('change',function() {
        	value = $(this).val();
        	if(value == 1) {
        		$("input:radio[name='FormBuilder[step_2_field1_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');
        	} else if(value == 0) {
        		$("input:radio[name='FormBuilder[step_2_field1_chmandatory]']").parents(':eq(2)').addClass('grey-bg');
        	} 
        });
//step 3 field 1
        //step2
        //field 1 
        $("input:radio[name='FormBuilder[step_3_field1_chrequire]']").on('change',function() {
        var value = $(this).val();
        if(value == 1) {
        	$('#step_3_chfield1').css('display','block');
        	$("input[name='FormBuilder[step_3_field1_chmandatory]'][value='1']").prop("checked",true);
        	$('#step_3_chfield1 input').removeAttr('disabled');
        	$('#step_3_chfield1 select').removeAttr('disabled');
        	$("input:radio[name='FormBuilder[step_3_field1_chrequire]']").parents(':eq(2)').removeClass('grey-bg');
        	$("#refresh_form_2_3").trigger('reset');
        } else if(value == 0) {
        	$("input[name='FormBuilder[step_3_field1_chmandatory]'][value='0']").prop("checked",true);
        	$('#step_3_chfield1 input').attr('disabled','disabled');
        	$('#step_3_chfield1 select').attr('disabled','disabled');
        	$('#formbuilder-step_3_field1_chlabel').val('');
    		$('#formbuilder-step_3_field1_chdata_type').val('');
    		$('#formbuilder-step_3_field1_chno_chars').val('');
			$('#step_3_field1_chno_of_chars').css("display","none");
    		$('#formbuilder-step_3_field1_chvalidation_type').val('');
    		$('#step_3_field1_chvalidation_type').css("display","none");
    		$('#formbuilder-step_3_field1_chfield_value').val('');
    		$('#step_3_field1_chvlaue').css("display","none");
    		$('#step_3_field1_chvlaue input').attr("disabled","disabled");
    		$('.step_3_field1_chfield_boxes').remove();
        	$('#step_3_chfield1 select').val('');
        	$('#step_3_chfield1').hide();
        	$("input:radio[name='FormBuilder[step_3_field1_chrequire]']").parents(':eq(2)').addClass('grey-bg');
        } 
        });
        $("input:radio[name='FormBuilder[step_3_field1_chmandatory]']").on('change',function() {
        	value = $(this).val();
        	if(value == 1) {
        		$("input:radio[name='FormBuilder[step_3_field1_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');
        	} else if(value == 0) {
        		$("input:radio[name='FormBuilder[step_3_field1_chmandatory]']").parents(':eq(2)').addClass('grey-bg');
        	} 
        });
        $('#formbuilder-step_3_field1_chdata_type').on('change',function(){
	        var data_type_value = $(this).val();
	        if(data_type_value == 'edittext') {
	        	$('#formbuilder-step_3_field1_chno_chars').val('');
				$('#step_3_field1_chno_of_chars').css("display","block");
	        	$('#formbuilder-step_3_field1_chvalidation_type').val('');
	        	$('#step_3_field1_chvalidation_type').css("display","block");
				$('#formbuilder-step_3_field1_chfield_value').val('');
				$('.step_3_field1_chfield_boxes').remove();
		        $('#step_3_field1_chvlaue input').attr("disabled","disabled");
		        $('#step_3_field1_chvlaue').css("display","none");
	        } else if(data_type_value == 'radio' || data_type_value == 'selectbox' || data_type_value == 'checkbox') {
	        	$('#formbuilder-step_3_field1_chno_chars').val('');
				$('#step_3_field1_chno_of_chars').css("display","none");
	        	$('#formbuilder-step_3_field1_chvalidation_type').val('');
	        	$('#step_3_field1_chvalidation_type').css("display","none");
				$('#formbuilder-step_3_field1_chfield_value').val('');
				$('.step_3_field1_chfield_boxes').remove();
		        $('#step_3_field1_chvlaue input').removeAttr('disabled');
		        $('#step_3_field1_chvlaue').css("display","block");
	        }  else if(data_type_value == 'textarea') {
	        	$('#formbuilder-step_3_field1_chno_chars').val('');
				$('#step_3_field1_chno_of_chars').css("display","block");
	        	$('#formbuilder-step_3_field1_chvalidation_type').val('');
	        	$('#step_3_field1_chvalidation_type').css("display","none");
	        	$('#formbuilder-step_3_field1_chfield_value').val('');
				$('.step_3_field1_chfield_boxes').remove();
		        $('#step_3_field1_chvlaue input').attr("disabled","disabled");
		        $('#step_3_field1_chvlaue').css("display","none");
		    } else if(data_type_value == 'rating') {
	        	$('#formbuilder-step_3_field1_chno_chars').val('');
				$('#step_3_field1_chno_of_chars').css("display","none");
	        	$('#formbuilder-step_3_field1_chvalidation_type').val('');
	        	$('#step_3_field1_chvalidation_type').css("display","none");
	        	$('#formbuilder-step_3_field1_chfield_value').val('');
				$('.step_3_field1_chfield_boxes').remove();
		        $('#step_3_field1_chvlaue input').attr("disabled","disabled");
		        $('#step_3_field1_chvlaue').css("display","none");
		    }  else {
		    	$('#formbuilder-step_3_field1_chno_chars').val('');
				$('#step_3_field1_chno_of_chars').css("display","none");
		    	$('#formbuilder-step_3_field1_chvalidation_type').val('');
				$('#step_3_field1_chvalidation_type').css("display","none");
				$('#formbuilder-step_3_field1_chfield_value').val('');
				$('#step_3_field1_chvlaue').css("display","none");
				$('#step_3_field1_chvlaue input').attr("disabled","disabled");
				$('.step_3_field1_chfield_boxes').remove();
		    }
        })		
        //add more
        $("#step_3_field1_chvlaue .form-group .add-txt").click(function(){
               var no = $(".form-group").length + 1;
                var more_textbox = $('<div class="form-group step_3_field1_chfield_boxes">' +
                '</span></label>' +
                '<div class="row"><div class="col-sm-offset-6 col-sm-6 col-md-offset-5  col-md-7 col-lg-offset-4 col-lg-4"><div class="dd-check"><span class="pull-left"><input class="form-control" type="text" name="step_3_field1_chfield_boxes[]" id="txtbox' + no + '" />' +
                '</span><span class="cb"><a href="#" class="btn btn-danger btn-xs remove-txt"><i class="fa fa-minus"></i></a></span>' +
                '</div></div><div class="help-block"></div></div></div>');
                more_textbox.hide();
                $("#step_3_field1_chvlaue .form-group:last").after(more_textbox);
                more_textbox.fadeIn("slow");
                $(".field-formbuilder-step_3_field1_chfield_value").find('.help-error').html('');
                return false;
            });

        //Remove
            $('#step_3_field1_chvlaue').on('click', '.remove-txt', function(){
                $(this).parents(':eq(4)').fadeOut("slow", function() {
                    $(this).remove();
                  /*   $('.label-numbers').each(function( index ){
                        $(this).text( index + 1 );
                    }); */
                });
                return false;
            }); 
            
          //step 5 
        	//field 1 
        	$("input:radio[name='FormBuilder[step_4_field1_chrequire]']").on('change',function() {
            var value = $(this).val();
        	if(value == 1) {
        		$('#step_4_chfield1').css('display','block');
        		$('#step_4_chfield1 input').removeAttr('disabled');
        		$('#step_4_chfield1 select').removeAttr('disabled');
        		$("input:radio[name='FormBuilder[step_4_field1_chrequire]'][value='1']").prop("checked",true);
        		$("input[name='FormBuilder[step_4_field1_chrequire]'][value='0']").next('span').removeClass('input-checked');
    			$("input[name='FormBuilder[step_4_field1_chrequire]'][value='1']").next('span').addClass('input-checked');
    			$("input:radio[name='FormBuilder[step_4_field1_chmandatory]'][value='1']").prop("checked",true);
    			$("input[name='FormBuilder[step_4_field1_chmandatory]'][value='0']").next('span').removeClass('input-checked');
    			$("input[name='FormBuilder[step_4_field1_chmandatory]'][value='1']").next('span').addClass('input-checked');
    			$("input:radio[name='FormBuilder[step_4_field1_chrequire]']").parents(':eq(2)').removeClass('grey-bg');
    			$("input:radio[name='FormBuilder[step_4_field1_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');
        	} else if(value == 0) {
        		$('#step_4_chfield1 input').attr('disabled','disabled');
        		$('#step_4_chfield1 select').attr('disabled','disabled');
        		$("input:radio[name='FormBuilder[step_4_field1_chmandatory]'][value='0']").prop("checked",true);
        		$('#formbuilder-step_4_field1_chlabel').val('');
        		$("input:radio[name='FormBuilder[step_4_field1_chrequire]']").parents(':eq(2)').addClass('grey-bg');
        		$('#step_4_chfield1').css('display','none');
            } 	
        });	
        	$("input:radio[name='FormBuilder[step_4_field1_chmandatory]']").on('change',function() {
        		value = $(this).val();
        		if(value == 1) {
        			$("input:radio[name='FormBuilder[step_4_field1_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');
        		} else if(value == 0) {
        			$("input:radio[name='FormBuilder[step_4_field1_chmandatory]']").parents(':eq(2)').addClass('grey-bg');
        		} 
        	});
        $('#formbuilder-step_4_field1_chdata_type').on('change',function(){
        	var data_type_value = $('#formbuilder-step_4_field1_chdata_type').val();
        	//alert(data_type_value);
        	if(data_type_value == 'edittext') {
        	//$('#step_4_field1_chvalidation_type select').removeAttr('disabled');;
        	$('#step_4_field1_chvalidation_type').css("display","block");
        	$('#step_4_field1_chvlaue input').attr("disabled","disabled");
        	$('#step_4_field1_chvlaue').css("display","none");
          } else if(data_type_value == 'radio' || data_type_value == 'selectbox' || data_type_value == 'checkbox') {
        	//$('#step_4_field1_chvalidation_type select').attr("disabled","disabled");
        	$('#step_4_field1_chvalidation_type').css("display","none");
        	$('#step_4_field1_chvlaue input').removeAttr('disabled');;
        	$('#step_4_field1_chvlaue').css("display","block");
         }  else {
        	//$('#step_5_validation_type select').attr("disabled","disabled");
        	$('#step_4_field1_chvalidation_type').css("display","none");
        }
        })		
        //add more
        $("#step_4_field1_chvlaue .form-group .add-txt").click(function(){
                   var no = $(".form-group").length + 1;
                    var more_textbox = $('<div class="form-group">' +
                    '</span></label>' +
                    '<div class="row"><div class="col-sm-offset-6 col-sm-6 col-md-offset-5  col-md-7 col-lg-offset-4 col-lg-4"><div class="dd-check"><span class="pull-left"><input class="form-control" type="text" name="step_4_field1_chfield_boxes[]" id="txtbox' + no + '" />' +
                    '</span><span class="cb"><a href="#" class="btn btn-danger btn-xs remove-txt"><i class="fa fa-minus"></i></a></span>' +
                    '</div></div><div class="help-block"></div></div></div>');
                    more_textbox.hide();
                    $("#step_4_field1_chvlaue .form-group:last").after(more_textbox);
                    more_textbox.fadeIn("slow");
                    return false;
                });

        	//Remove
                $('#step_4_field1_chvlaue').on('click', '.remove-txt', function(){
                    $(this).parents(':eq(4)').fadeOut("slow", function() {
                        $(this).remove();
                      /*   $('.label-numbers').each(function( index ){
                            $(this).text( index + 1 );
                        }); */
                    });
                    return false;
                }); 
//channel card dynamic form end
            
//channel card update  start
 $('#formbuilder-product_id').on('change',function(){
	 var companyid = $('#formbuilder-companyid').val();
	 var activityval = $('#ch_activity_id').val();
	 var product_id = $('#formbuilder-product_id').val();
	 /*if (companyid != '' && product_id == '') {
			$.ajax({
				method: "GET",
				url: "dynamicdata",
				async: false,
				data: {company_id: companyid,activity_id: activityval,type:'channel'},
				success: function(data) {
					res = $.parseJSON(data);
					if (res != '') {
						if (res['step2']) {
							if(res['step2'][0]['require'] == 1) {
								$("input[name='FormBuilder[step_2_field1_chrequire]'][value='1']").prop("checked",true);
								$('#step_2_chfield1').css('display','block');//before any change if no option radio button selected
							} else {
								$("input[name='FormBuilder[step_2_field1_chrequire]'][value='0']").prop("checked",true);
							}
							if(res['step2'][0]['mandatory'] == 1) {
								$("input[name='FormBuilder[step_2_field1_chmandatory]'][value='1']").prop("checked",true);
							} else {
								$("input[name='FormBuilder[step_2_field1_chmandatory]'][value='0']").prop("checked",true);
							}
							if (res['step2'][0]['label'] != '') {
								$('#formbuilder-step_2_field1_chlabel1').val(res['step2'][0]['label']);
							} else {
								$('#formbuilder-step_2_field1_chlabel1').val('');
							}
							if (res['step2'][1]['label'] != '') {
								$('#formbuilder-step_2_field2_chlabel2').val(res['step2'][1]['label']);
							} else {
								$('#formbuilder-step_2_field2_chlabel2').val('');
							}
							if (res['step2'][2]['label'] != '') {
								$('#formbuilder-step_2_field3_chlabel3').val(res['step2'][2]['label']);
							} else {
								$('#formbuilder-step_2_field3_chlabel3').val('');
							}
						}
						if (!res['step2']) {
							$("input:radio[name='FormBuilder[step_2_field1_chrequire]'][value='0']").click();
							$("input:radio[name='FormBuilder[step_2_field1_chrequire]'][value='0']").prop("checked",true);
						}
						if (res['step3']) {
							if(res['step3'][0]['require'] == 1) {
								$("input[name='FormBuilder[step_3_field1_chrequire]'][value='1']").prop("checked",true);
								$('#step_3_chfield1').css('display','block');//before any change if no option radio button selected
							} else {
								$("input[name='FormBuilder[step_3_field1_chrequire]'][value='0']").prop("checked",true);
							}
							if(res['step3'][0]['mandatory'] == 1) {
								$("input[name='FormBuilder[step_3_field1_chmandatory]'][value='1']").prop("checked",true);
							} else {
								$("input[name='FormBuilder[step_3_field1_chmandatory]'][value='0']").prop("checked",true);
							}
							$('#formbuilder-step_3_field1_chlabel').val(res['step3'][0]['label']);
							if (res['step3'][0]['data_type'] != '') {
								$('#formbuilder-step_3_field1_chdata_type').val(res['step3'][0]['data_type']);
								if (res['step3'][0]['data_type'] == 'edittext') {
									$('#step_3_field1_chvalidation_type').css('display','block');
									$('#formbuilder-step_3_field1_chvalidation_type').val(res['step3'][0]['validation_type']);
									$('#step_3_field1_chvlaue input').attr("disabled","disabled");
									 //$('#step_2_field1_feild_vlaue').css("display","none");
								} else if (res['step3'][0]['data_type'] == 'textarea') {
									$('#formbuilder-step_3_field1_chvalidation_type').val('');
									$('#step_3_field1_chvalidation_type').css('display','none');
									$('#formbuilder-step_3_field1_chfield_value').val('');
									$('.step_3_field1_chfield_boxes').remove();
									$('#step_3_field1_chvlaue input').attr("disabled","disabled");
									$('#step_3_field1_chvlaue').css('display','none');
								} else if(res['step3'][0]['data_type'] == 'radio' || res['step3'][0]['data_type'] == 'checkbox' || res['step3'][0]['data_type'] == 'selectbox') {
									$('#formbuilder-step_3_field1_chvalidation_type').val('');
									$('#step_3_field1_chvalidation_type').css('display','none');
									$('#step_3_field1_chvlaue input').removeAttr('disabled');
									$('#step_3_field1_chvlaue').css("display","block");
									if (res['step3'][0]['values'] instanceof Array) {
										//console.log(res['step4'][0]['values']);
										$('#formbuilder-step_3_field1_chfield_value').val(res['step3'][0]['values'][0]);
										 var field_value = res['step3'][0]['values'];
										 var values_length = res['step3'][0]['values'].length;
										 var j = 0;
										 for(var i= 1; i <= values_length-1;i++) {
											 var no = $(".form-group").length + 1;
								             var more_textbox = $('<div class="form-group step_3_field1_chfield_boxes">' +
								                '</span></label>' +
								                '<div class="col-sm-10"><input class="form-control" type="text" name="step_3_field1_chfield_boxes[]" value = "'+ field_value[i] +'" id="txtbox' + no + '" />' +
								                '<a href="#" class="btn btn-danger btn-xs remove-txt">Remove</a>' +
								                '</div></div>');
								             $("#step_3_field1_chvlaue .form-group:last").after(more_textbox);
								             more_textbox.fadeIn("slow");
								             j++;
										 }
									}
								}
							}
						}
						if (!res['step3']) {
							$("input:radio[name='FormBuilder[step_3_field1_chrequire]'][value='0']").click();
							$("input:radio[name='FormBuilder[step_3_field1_chrequire]'][value='0']").prop("checked",true);
						}
					} else {
						$("input[name='FormBuilder[step_2_field1_chrequire]'][value='1']").prop("checked",true);
						$('#step_2_chfield1').css('display','block');//before any change if no option radio button selected
						$("input[name='FormBuilder[step_2_field1_chmandatory]'][value='1']").prop("checked",true);
						$('#formbuilder-step_2_field1_chlabel1').val('');
						$('#formbuilder-step_2_field2_chlabel2').val('');
						$('#formbuilder-step_2_field3_chlabel3').val('');
						$("input[name='FormBuilder[step_3_field1_chrequire]'][value='1']").prop("checked",true);
						$('#step_3_chfield1').css('display','block');//before any change if no option radio button selected
						$("input[name='FormBuilder[step_3_field1_chmandatory]'][value='1']").prop("checked",true);
						$('#formbuilder-step_3_field1_chlabel').val('');
						$('#formbuilder-step_3_field1_chdata_type').val('');
						$('#step_3_field1_chvalidation_type').css('display','none');
						$('#step_3_field1_chvlaue').css('display','none');
						$('#step_3_chfield1 input').removeAttr('disabled');
			        	$('#step_3_chfield1 select').removeAttr('disabled');
						$("#refresh_form_2_3").trigger('reset');
					}
				}
			});
	 } else*/ if (companyid != '' && product_id != '') {
			$.ajax({
				method: "GET",
				url: "dynamicdata",
				async: false,
				data: {company_id: companyid,activity_id: activityval,type:'channel', product_id : product_id},
				success: function(data) {
					res = $.parseJSON(data);
					if (res != '') {
						if (res['step1']) {
							/*if (res['step1'][0]['product_unit']['kg'] == 'kg') {
								$("input[name='FormBuilder[product_unit][]'][value='kg']").prop("checked",true);
							} else {
								$("input[name='FormBuilder[product_unit][]'][value='kg']").prop("checked",false);
							}
							if (res['step1'][0]['product_unit']['liters'] == 'liters') {
								$("input[name='FormBuilder[product_unit][]'][value='liters']").prop("checked",true);
							} else {
								$("input[name='FormBuilder[product_unit][]'][value='liters']").prop("checked",false);
							}
							if (res['step1'][0]['product_unit']['bags'] == 'bags') {
								$("input[name='FormBuilder[product_unit][]'][value='bags']").prop("checked",true);
							} else {
								$("input[name='FormBuilder[product_unit][]'][value='bags']").prop("checked",false);
							}
							if (res['step1'][0]['product_unit']['packs'] == 'packs') {
								$("input[name='FormBuilder[product_unit][]'][value='packs']").prop("checked",true);
							} else {
								$("input[name='FormBuilder[product_unit][]'][value='packs']").prop("checked",false);
							}
							if (res['step1'][0]['product_unit']['boxes'] == 'boxes') {
								$("input[name='FormBuilder[product_unit][]'][value='boxes']").prop("checked",true);
							} else {
								$("input[name='FormBuilder[product_unit][]'][value='boxes']").prop("checked",false);
							}*/
							if(res['step1'][0]['require'] == 1) {
								$("input[name='FormBuilder[step_1_field1_chrequire]'][value='1']").click();
								$("input[name='FormBuilder[step_1_field1_chrequire]'][value='1']").prop("checked",true);
								$('#step_1_chfield1').css('display','block');//before any change if no option radio button selected
							} else {
								$("input[name='FormBuilder[step_1_field1_chrequire]'][value='0']").click();
								$("input[name='FormBuilder[step_1_field1_chrequire]'][value='0']").prop("checked",true);
							}
							if(res['step1'][0]['mandatory'] == 1) {
								$("input[name='FormBuilder[step_1_field1_chmandatory]'][value='1']").click();
								$("input[name='FormBuilder[step_1_field1_chmandatory]'][value='1']").prop("checked",true);
								$("input:radio[name='FormBuilder[step_1_field1_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');
							} else {
								$("input[name='FormBuilder[step_1_field1_chmandatory]'][value='0']").click();
								$("input[name='FormBuilder[step_1_field1_chmandatory]'][value='0']").prop("checked",true);
								$("input:radio[name='FormBuilder[step_1_field1_chmandatory]']").parents(':eq(2)').addClass('grey-bg');
							}
							if (res['step1'][0]['label'] != '') {
								$('#formbuilder-step_1_field1_chlabel').val(res['step1'][0]['label']);
							} else {
								$('#formbuilder-step_1_field1_chlabel').val('');
							}
							if (res['step1'][0]['data_type'] != '') {
								$('#formbuilder-step_1_field1_chdata_type').val(res['step1'][0]['data_type']);
								if (res['step1'][0]['data_type'] == 'edittext') {
									$('#step_1_field1_chvalidation_type').css('display','block');
									$('#formbuilder-step_1_field1_chvalidation_type').val(res['step1'][0]['validation_type']);
									$('#step_1_field1_chvlaue input').attr("disabled","disabled");
									$('#step_1_field1_chvlaue').css("display","none");
									$('#formbuilder-step_1_field1_chno_chars').val(res['step1'][0]['no_of_chars']);
									$('#step_1_field1_chno_of_chars').css("display","block");
								} else if (res['step1'][0]['data_type'] == 'textarea') {
									$('#formbuilder-step_1_field1_chvalidation_type').val('');
									$('#step_1_field1_chvalidation_type').css('display','none');
									$('#formbuilder-step_1_field1_chfield_value').val('');
									$('.step_1_field1_chfield_boxes').remove();
									$('#step_1_field1_chvlaue input').attr("disabled","disabled");
									$('#step_1_field1_chvlaue').css('display','none');
									$('#formbuilder-step_1_field1_chno_chars').val(res['step1'][0]['no_of_chars']);
									$('#step_1_field1_chno_of_chars').css("display","block");
								} else if (res['step1'][0]['data_type'] == 'rating') {
									$('#formbuilder-step_1_field1_chvalidation_type').val('');
									$('#step_1_field1_chvalidation_type').css('display','none');
									$('#formbuilder-step_1_field1_chfield_value').val('');
									$('.step_1_field1_chfield_boxes').remove();
									$('#step_1_field1_chvlaue input').attr("disabled","disabled");
									$('#step_1_field1_chvlaue').css('display','none');
									$('#formbuilder-step_1_field1_chno_chars').val('');
									$('#step_1_field1_chno_of_chars').css("display","none");
								} else if(res['step1'][0]['data_type'] == 'radio' || res['step1'][0]['data_type'] == 'checkbox' || res['step1'][0]['data_type'] == 'selectbox') {
									$('#formbuilder-step_1_field1_chvalidation_type').val('');
									$('#step_1_field1_chvalidation_type').css('display','none');
									$('#step_1_field1_chvlaue input').removeAttr('disabled');
									$('#step_1_field1_chvlaue').css("display","block");
									$('#formbuilder-step_1_field1_chno_chars').val('');
									$('#step_1_field1_chno_of_chars').css("display","none");
									if (res['step1'][0]['values'] instanceof Array) {
										//console.log(res['step4'][0]['values']);
										$('#formbuilder-step_1_field1_chfield_value').val(res['step1'][0]['values'][0]);
										$('.step_1_field1_chfield_boxes').remove();
										 var field_value = res['step1'][0]['values'];
										 var values_length = res['step1'][0]['values'].length;
										 var j = 0;
										 for(var i= 1; i <= values_length-1;i++) {
											 var no = $(".form-group").length + 1;
								             var more_textbox = $('<div class="form-group step_1_field1_chfield_boxes">' +
								                '</span></label>' +
								                '<div class="row"><div class="col-sm-offset-6 col-sm-6 col-md-offset-5  col-md-7 col-lg-offset-4 col-lg-4"><div class="dd-check"><span class="pull-left"><input class="form-control" type="text" name="step_1_field1_chfield_boxes[]" value = "'+ field_value[i] +'" id="txtbox' + no + '" />' +
								                '</span><span class="cb"><a href="#" class="btn btn-danger btn-xs remove-txt"><i class="fa fa-minus"></i></a></span>' +
								                '</div></div><div class="help-block"></div></div></div>');
								             $("#step_1_field1_chvlaue .form-group:last").after(more_textbox);
								             more_textbox.fadeIn("slow");
								             j++;
										 }
									}
								}
							}
							if(res['step1'][1]['require'] == 1) {
								$("input[name='FormBuilder[step_1_field2_chrequire]'][value='1']").click();
								$("input[name='FormBuilder[step_1_field2_chrequire]'][value='1']").prop("checked",true);
								$('#step_1_chfield2').css('display','block');//before any change if no option radio button selected
							} else {
								$("input[name='FormBuilder[step_1_field2_chrequire]'][value='0']").click();
								//$("input[name='FormBuilder[step_1_field2_chrequire]'][value='0']").click();
								$("input[name='FormBuilder[step_1_field2_chrequire]'][value='0']").prop("checked",true);
							}
							if(res['step1'][1]['mandatory'] == 1) {
								$("input[name='FormBuilder[step_1_field2_chmandatory]'][value='1']").click();
								$("input[name='FormBuilder[step_1_field2_chmandatory]'][value='1']").prop("checked",true);
								$("input:radio[name='FormBuilder[step_1_field2_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');
							} else {
								$("input[name='FormBuilder[step_1_field2_chmandatory]'][value='0']").click();
								$("input[name='FormBuilder[step_1_field2_chmandatory]'][value='0']").prop("checked",true);
								$("input:radio[name='FormBuilder[step_1_field2_chmandatory]']").parents(':eq(2)').addClass('grey-bg');
							}
							if (res['step1'][1]['label'] != '') {
								$('#formbuilder-step_1_field2_chlabel').val(res['step1'][1]['label']);
							} else {
								$('#formbuilder-step_1_field2_chlabel').val('');
							}
							if (res['step1'][1]['data_type'] != '') {
								$('#formbuilder-step_1_field2_chdata_type').val(res['step1'][1]['data_type']);
								if (res['step1'][1]['data_type'] == 'edittext') {
									$('#step_1_field2_chvalidation_type').css('display','block');
									$('#formbuilder-step_1_field2_chvalidation_type').val(res['step1'][1]['validation_type']);
									$('#step_1_field2_chvlaue input').attr("disabled","disabled");
									$('#step_1_field2_chvlaue').css("display","none");
									$('#formbuilder-step_1_field2_chno_chars').val(res['step1'][1]['no_of_chars']);
									$('#step_1_field2_chno_of_chars').css("display","block");
								} else if (res['step1'][1]['data_type'] == 'textarea') {
									$('#formbuilder-step_1_field2_chvalidation_type').val('');
									$('#step_1_field2_chvalidation_type').css('display','none');
									$('#formbuilder-step_1_field2_chfield_value').val('');
									$('.step_1_field2_chfield_boxes').remove();
									$('#step_1_field2_chvlaue input').attr("disabled","disabled");
									$('#step_1_field2_chvlaue').css('display','none');
									$('#formbuilder-step_1_field2_chno_chars').val(res['step1'][1]['no_of_chars']);
									$('#step_1_field2_chno_of_chars').css("display","block");
								} else if (res['step1'][1]['data_type'] == 'rating') {
									$('#formbuilder-step_1_field2_chvalidation_type').val('');
									$('#step_1_field2_chvalidation_type').css('display','none');
									$('#formbuilder-step_1_field2_chfield_value').val('');
									$('.step_1_field2_chfield_boxes').remove();
									$('#step_1_field2_chvlaue input').attr("disabled","disabled");
									$('#step_1_field2_chvlaue').css('display','none');
									$('#formbuilder-step_1_field2_chno_chars').val('');
									$('#step_1_field2_chno_of_chars').css("display","none");
								} else if(res['step1'][1]['data_type'] == 'radio' || res['step1'][1]['data_type'] == 'checkbox' || res['step1'][1]['data_type'] == 'selectbox') {
									$('#formbuilder-step_1_field2_chvalidation_type').val('');
									$('#step_1_field2_chvalidation_type').css('display','none');
									$('#step_1_field2_chvlaue input').removeAttr('disabled');
									$('#step_1_field2_chvlaue').css("display","block");
									$('#formbuilder-step_1_field2_chno_chars').val('');
									$('#step_1_field2_chno_of_chars').css("display","none");
									if (res['step1'][1]['values'] instanceof Array) {
										//console.log(res['step4'][0]['values']);
										$('#formbuilder-step_1_field2_chfield_value').val(res['step1'][1]['values'][0]);
										$('.step_1_field2_chfield_boxes').remove();
										 var field_value = res['step1'][1]['values'];
										 var values_length = res['step1'][1]['values'].length;
										 var j = 0;
										 for(var i= 1; i <= values_length-1;i++) {
											 var no = $(".form-group").length + 1;
								             var more_textbox = $('<div class="form-group step_1_field2_chfield_boxes">' +
								                '</span></label>' +
								                '<div class="row"><div class="col-sm-offset-6 col-sm-6 col-md-offset-5  col-md-7 col-lg-offset-4 col-lg-4"><div class="dd-check"><span class="pull-left"><input class="form-control" type="text" name="step_1_field2_chfield_boxes[]" value = "'+ field_value[i] +'" id="txtbox' + no + '" />' +
								                '</span><span class="cb"><a href="#" class="btn btn-danger btn-xs remove-txt"><i class="fa fa-minus"></i></a></span>' +
								                '</div></div><div class="help-block"></div></div></div>');
								             $("#step_1_field2_chvlaue .form-group:last").after(more_textbox);
								             more_textbox.fadeIn("slow");
								             j++;
										 }
									}
								}
							}
							if(res['step1'][2]['require'] == 1) {
								$("input[name='FormBuilder[step_1_field3_chrequire]'][value='1']").click();
								$("input[name='FormBuilder[step_1_field3_chrequire]'][value='1']").prop("checked",true);
								$('#step_1_chfield3').css('display','block');//before any change if no option radio button selected
							} else {
								$("input[name='FormBuilder[step_1_field3_chrequire]'][value='0']").click();
								//$("input[name='FormBuilder[step_1_field3_chrequire]'][value='0']").click();
								$("input[name='FormBuilder[step_1_field3_chrequire]'][value='0']").prop("checked",true);
							}
							if(res['step1'][2]['mandatory'] == 1) {
								$("input[name='FormBuilder[step_1_field3_chmandatory]'][value='1']").click();
								$("input[name='FormBuilder[step_1_field3_chmandatory]'][value='1']").prop("checked",true);
								$("input:radio[name='FormBuilder[step_1_field3_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');
							} else {
								$("input[name='FormBuilder[step_1_field3_chmandatory]'][value='0']").click();
								$("input[name='FormBuilder[step_1_field3_chmandatory]'][value='0']").prop("checked",true);
								$("input:radio[name='FormBuilder[step_1_field3_chmandatory]']").parents(':eq(2)').addClass('grey-bg');
							}
							if (res['step1'][2]['label'] != '') {
								$('#formbuilder-step_1_field3_chlabel').val(res['step1'][2]['label']);
							} else {
								$('#formbuilder-step_1_field3_chlabel').val('');
							}
							if (res['step1'][2]['data_type'] != '') {
								$('#formbuilder-step_1_field3_chdata_type').val(res['step1'][2]['data_type']);
								if (res['step1'][2]['data_type'] == 'edittext') {
									$('#step_1_field3_chvalidation_type').css('display','block');
									$('#formbuilder-step_1_field3_chvalidation_type').val(res['step1'][2]['validation_type']);
									$('#step_1_field3_chvlaue input').attr("disabled","disabled");
									$('#step_1_field3_chvlaue').css("display","none");
									$('#formbuilder-step_1_field3_chno_chars').val(res['step1'][2]['no_of_chars']);
									$('#step_1_field3_chno_of_chars').css("display","block");
								} else if (res['step1'][2]['data_type'] == 'textarea') {
									$('#formbuilder-step_1_field3_chvalidation_type').val('');
									$('#step_1_field3_chvalidation_type').css('display','none');
									$('#formbuilder-step_1_field3_chfield_value').val('');
									$('.step_1_field3_chfield_boxes').remove();
									$('#step_1_field3_chvlaue input').attr("disabled","disabled");
									$('#step_1_field3_chvlaue').css('display','none');
									$('#formbuilder-step_1_field3_chno_chars').val(res['step1'][2]['no_of_chars']);
									$('#step_1_field3_chno_of_chars').css("display","block");
								} else if (res['step1'][2]['data_type'] == 'rating') {
									$('#formbuilder-step_1_field3_chvalidation_type').val('');
									$('#step_1_field3_chvalidation_type').css('display','none');
									$('#formbuilder-step_1_field3_chfield_value').val('');
									$('.step_1_field3_chfield_boxes').remove();
									$('#step_1_field3_chvlaue input').attr("disabled","disabled");
									$('#step_1_field3_chvlaue').css('display','none');
									$('#formbuilder-step_1_field3_chno_chars').val('');
									$('#step_1_field3_chno_of_chars').css("display","none");
								} else if(res['step1'][2]['data_type'] == 'radio' || res['step1'][2]['data_type'] == 'checkbox' || res['step1'][2]['data_type'] == 'selectbox') {
									$('#formbuilder-step_1_field3_chvalidation_type').val('');
									$('#step_1_field3_chvalidation_type').css('display','none');
									$('#step_1_field3_chvlaue input').removeAttr('disabled');
									$('#step_1_field3_chvlaue').css("display","block");
									$('#formbuilder-step_1_field3_chno_chars').val('');
									$('#step_1_field3_chno_of_chars').css("display","none");
									if (res['step1'][2]['values'] instanceof Array) {
										//console.log(res['step4'][0]['values']);
										$('#formbuilder-step_1_field3_chfield_value').val(res['step1'][2]['values'][0]);
										$('.step_1_field3_chfield_boxes').remove();
										 var field_value = res['step1'][2]['values'];
										 var values_length = res['step1'][2]['values'].length;
										 var j = 0;
										 for(var i= 1; i <= values_length-1;i++) {
											 var no = $(".form-group").length + 1;
								             var more_textbox = $('<div class="form-group step_1_field3_chfield_boxes">' +
								                '</span></label>' +
								                '<div class="row"><div class="col-sm-offset-6 col-sm-6 col-md-offset-5  col-md-7 col-lg-offset-4 col-lg-4"><div class="dd-check"><span class="pull-left"><input class="form-control" type="text" name="step_1_field3_chfield_boxes[]" value = "'+ field_value[i] +'" id="txtbox' + no + '" />' +
								                '</span><span class="cb"><a href="#" class="btn btn-danger btn-xs remove-txt"><i class="fa fa-minus"></i></a></span>' +
								                '</div></div><div class="help-block"></div></div></div>');
								             $("#step_1_field3_chvlaue .form-group:last").after(more_textbox);
								             more_textbox.fadeIn("slow");
								             j++;
										 }
									}
								}
							}
							if(res['step1'][3]['require'] == 1) {
								$("input[name='FormBuilder[step_1_field4_chrequire]'][value='1']").click();
								$("input[name='FormBuilder[step_1_field4_chrequire]'][value='1']").prop("checked",true);
								$('#step_1_chfield4').css('display','block');//before any change if no option radio button selected
							} else {
								$("input[name='FormBuilder[step_1_field4_chrequire]'][value='0']").click();
								//$("input[name='FormBuilder[step_1_field4_chrequire]'][value='0']").click();
								$("input[name='FormBuilder[step_1_field4_chrequire]'][value='0']").prop("checked",true);
							}
							if(res['step1'][3]['mandatory'] == 1) {
								$("input[name='FormBuilder[step_1_field4_chmandatory]'][value='1']").click();
								$("input[name='FormBuilder[step_1_field4_chmandatory]'][value='1']").prop("checked",true);
								$("input:radio[name='FormBuilder[step_1_field4_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');
							} else {
								$("input[name='FormBuilder[step_1_field4_chmandatory]'][value='0']").click();
								$("input[name='FormBuilder[step_1_field4_chmandatory]'][value='0']").prop("checked",true);
								$("input:radio[name='FormBuilder[step_1_field4_chmandatory]']").parents(':eq(2)').addClass('grey-bg');
							}
							if (res['step1'][3]['label'] != '') {
								$('#formbuilder-step_1_field4_chlabel').val(res['step1'][3]['label']);
							} else {
								$('#formbuilder-step_1_field4_chlabel').val('');
							}
							if (res['step1'][3]['data_type'] != '') {
								$('#formbuilder-step_1_field4_chdata_type').val(res['step1'][3]['data_type']);
								if (res['step1'][3]['data_type'] == 'edittext') {
									$('#step_1_field4_chvalidation_type').css('display','block');
									$('#formbuilder-step_1_field4_chvalidation_type').val(res['step1'][3]['validation_type']);
									$('#step_1_field4_chvlaue input').attr("disabled","disabled");
									$('#step_1_field4_chvlaue').css("display","none");
									$('#formbuilder-step_1_field4_chno_chars').val(res['step1'][3]['no_of_chars']);
									$('#step_1_field4_chno_of_chars').css("display","block");
								} else if (res['step1'][3]['data_type'] == 'textarea') {
									$('#formbuilder-step_1_field4_chvalidation_type').val('');
									$('#step_1_field4_chvalidation_type').css('display','none');
									$('#formbuilder-step_1_field4_chfield_value').val('');
									$('.step_1_field4_chfield_boxes').remove();
									$('#step_1_field4_chvlaue input').attr("disabled","disabled");
									$('#step_1_field4_chvlaue').css('display','none');
									$('#formbuilder-step_1_field4_chno_chars').val(res['step1'][3]['no_of_chars']);
									$('#step_1_field4_chno_of_chars').css("display","block");
								} else if (res['step1'][3]['data_type'] == 'rating') {
									$('#formbuilder-step_1_field4_chvalidation_type').val('');
									$('#step_1_field4_chvalidation_type').css('display','none');
									$('#formbuilder-step_1_field4_chfield_value').val('');
									$('.step_1_field4_chfield_boxes').remove();
									$('#step_1_field4_chvlaue input').attr("disabled","disabled");
									$('#step_1_field4_chvlaue').css('display','none');
									$('#formbuilder-step_1_field4_chno_chars').val('');
									$('#step_1_field4_chno_of_chars').css("display","none");
								} else if(res['step1'][3]['data_type'] == 'radio' || res['step1'][3]['data_type'] == 'checkbox' || res['step1'][3]['data_type'] == 'selectbox') {
									$('#formbuilder-step_1_field4_chvalidation_type').val('');
									$('#step_1_field4_chvalidation_type').css('display','none');
									$('#step_1_field4_chvlaue input').removeAttr('disabled');
									$('#step_1_field4_chvlaue').css("display","block");
									$('#formbuilder-step_1_field4_chno_chars').val('');
									$('#step_1_field4_chno_of_chars').css("display","none");
									if (res['step1'][3]['values'] instanceof Array) {
										//console.log(res['step4'][0]['values']);
										$('#formbuilder-step_1_field4_chfield_value').val(res['step1'][3]['values'][0]);
										$('.step_1_field4_chfield_boxes').remove();
										 var field_value = res['step1'][3]['values'];
										 var values_length = res['step1'][3]['values'].length;
										 var j = 0;
										 for(var i= 1; i <= values_length-1;i++) {
											 var no = $(".form-group").length + 1;
								             var more_textbox = $('<div class="form-group step_1_field4_chfield_boxes">' +
								                '</span></label>' +
								                '<div class="row"><div class="col-sm-offset-6 col-sm-6 col-md-offset-5  col-md-7 col-lg-offset-4 col-lg-4"><div class="dd-check"><span class="pull-left"><input class="form-control" type="text" name="step_1_field4_chfield_boxes[]" value = "'+ field_value[i] +'" id="txtbox' + no + '" />' +
								                '</span><span class="cb"><a href="#" class="btn btn-danger btn-xs remove-txt"><i class="fa fa-minus"></i></a></span>' +
								                '</div></div><div class="help-block"></div></div></div>');
								             $("#step_1_field4_chvlaue .form-group:last").after(more_textbox);
								             more_textbox.fadeIn("slow");
								             j++;
										 }
									}
								}
							}
							if(res['step1'][4]['require'] == 1) {
								$("input[name='FormBuilder[step_1_field5_chrequire]'][value='1']").click();
								$("input[name='FormBuilder[step_1_field5_chrequire]'][value='1']").prop("checked",true);
								$('#step_1_chfield5').css('display','block');//before any change if no option radio button selected
							} else {
								$("input[name='FormBuilder[step_1_field5_chrequire]'][value='0']").click();
								//$("input[name='FormBuilder[step_1_field5_chrequire]'][value='0']").click();
								$("input[name='FormBuilder[step_1_field5_chrequire]'][value='0']").prop("checked",true);
							}
							if(res['step1'][4]['mandatory'] == 1) {
								$("input[name='FormBuilder[step_1_field5_chmandatory]'][value='1']").click();
								$("input[name='FormBuilder[step_1_field5_chmandatory]'][value='1']").prop("checked",true);
								$("input:radio[name='FormBuilder[step_1_field5_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');
							} else {
								$("input[name='FormBuilder[step_1_field5_chmandatory]'][value='0']").click();
								$("input[name='FormBuilder[step_1_field5_chmandatory]'][value='0']").prop("checked",true);
								$("input:radio[name='FormBuilder[step_1_field5_chmandatory]']").parents(':eq(2)').addClass('grey-bg');
							}
							if (res['step1'][4]['label'] != '') {
								$('#formbuilder-step_1_field5_chlabel').val(res['step1'][4]['label']);
							} else {
								$('#formbuilder-step_1_field5_chlabel').val('');
							}
							if (res['step1'][4]['data_type'] != '') {
								$('#formbuilder-step_1_field5_chdata_type').val(res['step1'][4]['data_type']);
								if (res['step1'][4]['data_type'] == 'edittext') {
									$('#step_1_field5_chvalidation_type').css('display','block');
									$('#formbuilder-step_1_field5_chvalidation_type').val(res['step1'][4]['validation_type']);
									$('#step_1_field5_chvlaue input').attr("disabled","disabled");
									$('#step_1_field5_chvlaue').css("display","none");
									$('#formbuilder-step_1_field5_chno_chars').val(res['step1'][4]['no_of_chars']);
									$('#step_1_field5_chno_of_chars').css("display","block");
								} else if (res['step1'][4]['data_type'] == 'textarea') {
									$('#formbuilder-step_1_field5_chvalidation_type').val('');
									$('#step_1_field5_chvalidation_type').css('display','none');
									$('#formbuilder-step_1_field5_chfield_value').val('');
									$('.step_1_field5_chfield_boxes').remove();
									$('#step_1_field5_chvlaue input').attr("disabled","disabled");
									$('#step_1_field5_chvlaue').css('display','none');
									$('#formbuilder-step_1_field5_chno_chars').val(res['step1'][4]['no_of_chars']);
									$('#step_1_field5_chno_of_chars').css("display","block");
								} else if (res['step1'][4]['data_type'] == 'rating') {
									$('#formbuilder-step_1_field5_chvalidation_type').val('');
									$('#step_1_field5_chvalidation_type').css('display','none');
									$('#formbuilder-step_1_field5_chfield_value').val('');
									$('.step_1_field5_chfield_boxes').remove();
									$('#step_1_field5_chvlaue input').attr("disabled","disabled");
									$('#step_1_field5_chvlaue').css('display','none');
									$('#formbuilder-step_1_field5_chno_chars').val('');
									$('#step_1_field5_chno_of_chars').css("display","none");
								} else if(res['step1'][4]['data_type'] == 'radio' || res['step1'][4]['data_type'] == 'checkbox' || res['step1'][4]['data_type'] == 'selectbox') {
									$('#formbuilder-step_1_field5_chvalidation_type').val('');
									$('#step_1_field5_chvalidation_type').css('display','none');
									$('#step_1_field5_chvlaue input').removeAttr('disabled');
									$('#step_1_field5_chvlaue').css("display","block");
									$('#formbuilder-step_1_field5_chno_chars').val('');
									$('#step_1_field5_chno_of_chars').css("display","none");
									if (res['step1'][4]['values'] instanceof Array) {
										//console.log(res['step4'][0]['values']);
										$('#formbuilder-step_1_field5_chfield_value').val(res['step1'][4]['values'][0]);
										$('.step_1_field5_chfield_boxes').remove();
										 var field_value = res['step1'][4]['values'];
										 var values_length = res['step1'][4]['values'].length;
										 var j = 0;
										 for(var i= 1; i <= values_length-1;i++) {
											 var no = $(".form-group").length + 1;
								             var more_textbox = $('<div class="form-group step_1_field5_chfield_boxes">' +
								                '</span></label>' +
								                '<div class="row"><div class="col-sm-offset-6 col-sm-6 col-md-offset-5  col-md-7 col-lg-offset-4 col-lg-4"><div class="dd-check"><span class="pull-left"><input class="form-control" type="text" name="step_1_field5_chfield_boxes[]" value = "'+ field_value[i] +'" id="txtbox' + no + '" />' +
								                '</span><span class="cb"><a href="#" class="btn btn-danger btn-xs remove-txt"><i class="fa fa-minus"></i></a></span>' +
								                '</div></div><div class="help-block"></div></div></div>');
								             $("#step_1_field5_chvlaue .form-group:last").after(more_textbox);
								             more_textbox.fadeIn("slow");
								             j++;
										 }
									}
								}
							}
						}
					} else {
						$("input[name='FormBuilder[product_unit][]']").prop("checked",false);
						$("input[name='FormBuilder[step_1_field1_chrequire]'][value='1']").click();
						$("input[name='FormBuilder[step_1_field1_chrequire]'][value='1']").prop("checked",true);
						$('#step_1_chfield1').css('display','block');//before any change if no option radio button selected
						$("input[name='FormBuilder[step_1_field1_chmandatory]'][value='1']").click();
						$("input[name='FormBuilder[step_1_field1_chmandatory]'][value='1']").prop("checked",true);
						$('#formbuilder-step_1_field1_chlabel').val('Supplied');
						$('#formbuilder-step_1_field1_chdata_type').val('');
						$('#formbuilder-step_1_field1_chvalidation_type').val('');
						$('#step_1_field1_chvalidation_type').css('display','none');
						$('#formbuilder-step_1_field1_chfield_value').val('');
						$('#step_1_field1_chvlaue').css('display','none');
						$("input[name='FormBuilder[step_1_field2_chrequire]'][value='1']").click();
						$("input[name='FormBuilder[step_1_field2_chrequire]'][value='1']").prop("checked",true);
						$('#step_1_chfield2').css('display','block');//before any change if no option radio button selected
						$("input[name='FormBuilder[step_1_field2_chmandatory]'][value='1']").click();
						$("input[name='FormBuilder[step_1_field2_chmandatory]'][value='1']").prop("checked",true);
						$('#formbuilder-step_1_field2_chlabel').val('Liquidated');
						$('#formbuilder-step_1_field2_chdata_type').val('');
						$('#formbuilder-step_1_field2_chvalidation_type').val('');
						$('#step_1_field2_chvalidation_type').css('display','none');
						$('#formbuilder-step_1_field2_chfield_value').val('');
						$('#step_1_field2_chvlaue').css('display','none');
						$("input[name='FormBuilder[step_1_field3_chrequire]'][value='1']").click();
						$("input[name='FormBuilder[step_1_field3_chrequire]'][value='1']").prop("checked",true);
						$('#step_1_chfield3').css('display','block');//before any change if no option radio button selected
						$("input[name='FormBuilder[step_1_field3_chmandatory]'][value='1']").click();
						$("input[name='FormBuilder[step_1_field3_chmandatory]'][value='1']").prop("checked",true);
						$('#formbuilder-step_1_field3_chlabel').val('Season Progress');
						$('#formbuilder-step_1_field3_chdata_type').val('');
						$('#formbuilder-step_1_field3_chvalidation_type').val('');
						$('#step_1_field3_chvalidation_type').css('display','none');
						$('#formbuilder-step_1_field3_chfield_value').val('');
						$('#step_1_field3_chvlaue').css('display','none');
						$("input[name='FormBuilder[step_1_field4_chrequire]'][value='1']").click();
						$("input[name='FormBuilder[step_1_field4_chrequire]'][value='1']").prop("checked",true);
						$('#step_1_chfield4').css('display','block');//before any change if no option radio button selected
						$("input[name='FormBuilder[step_1_field4_chmandatory]'][value='1']").click();
						$("input[name='FormBuilder[step_1_field4_chmandatory]'][value='1']").prop("checked",true);
						$('#formbuilder-step_1_field4_chlabel').val('Supplied');
						$('#formbuilder-step_1_field4_chdata_type').val('');
						$('#formbuilder-step_1_field4_chvalidation_type').val('');
						$('#step_1_field4_chvalidation_type').css('display','none');
						$('#formbuilder-step_1_field4_chfield_value').val('');
						$('#step_1_field4_chvlaue').css('display','none');
						$("input[name='FormBuilder[step_1_field5_chrequire]'][value='1']").click();
						$("input[name='FormBuilder[step_1_field5_chrequire]'][value='1']").prop("checked",true);
						$('#step_1_chfield5').css('display','block');//before any change if no option radio button selected
						$("input[name='FormBuilder[step_1_field5_chmandatory]'][value='1']").click();
						$("input[name='FormBuilder[step_1_field5_chmandatory]'][value='1']").prop("checked",true);
						$('#formbuilder-step_1_field5_chlabel').val('Supplied');
						$('#formbuilder-step_1_field5_chdata_type').val('');
						$('#formbuilder-step_1_field5_chvalidation_type').val('');
						$('#step_1_field5_chvalidation_type').css('display','none');
						$('#formbuilder-step_1_field5_chfield_value').val('');
						$('#step_1_field5_chvlaue').css('display','none');
						$("#refresh_form_1").trigger('reset');
					}
				}
		});
	 } else if (companyid == '') {
		 	$("input[name='FormBuilder[product_unit][]']").prop("checked",false);
			$("input[name='FormBuilder[step_1_field1_chrequire]'][value='1']").prop("checked",true);
			$('#step_1_chfield1').css('display','block');//before any change if no option radio button selected
			$("input[name='FormBuilder[step_1_field1_chmandatory]'][value='1']").prop("checked",true);
			$('#formbuilder-step_1_field1_chlabel').val('Supplied');
			$('#formbuilder-step_1_field1_chdata_type').val('');
			$('#formbuilder-step_1_field1_chvalidation_type').val('');
			$('#step_1_field1_chvalidation_type').css('display','none');
			$('#formbuilder-step_1_field1_chno_chars').val('');
			$('#step_1_field1_chno_of_chars').hide();
			$('#formbuilder-step_1_field1_chfield_value').val('');
			$('#step_1_field1_chvlaue').css('display','none');
			$("input[name='FormBuilder[step_1_field2_chrequire]'][value='1']").prop("checked",true);
			$('#step_1_chfield2').css('display','block');//before any change if no option radio button selected
			$("input[name='FormBuilder[step_1_field2_chmandatory]'][value='1']").prop("checked",true);
			$('#formbuilder-step_1_field2_chlabel').val('Liquidated');
			$('#formbuilder-step_1_field2_chdata_type').val('');
			$('#formbuilder-step_1_field2_chvalidation_type').val('');
			$('#step_1_field2_chvalidation_type').css('display','none');
			$('#formbuilder-step_1_field2_chno_chars').val('');
			$('#step_1_field2_chno_of_chars').hide();
			$('#formbuilder-step_1_field2_chfield_value').val('');
			$('#step_1_field2_chvlaue').css('display','none');
			$("input[name='FormBuilder[step_1_field3_chrequire]'][value='1']").prop("checked",true);
			$('#step_1_chfield3').css('display','block');//before any change if no option radio button selected
			$("input[name='FormBuilder[step_1_field3_chmandatory]'][value='1']").prop("checked",true);
			$('#formbuilder-step_1_field3_chlabel').val('Season Progress');
			$('#formbuilder-step_1_field3_chdata_type').val('');
			$('#formbuilder-step_1_field3_chvalidation_type').val('');
			$('#step_1_field3_chvalidation_type').css('display','none');
			$('#formbuilder-step_1_field3_chno_chars').val('');
			$('#step_1_field3_chno_of_chars').hide();
			$('#formbuilder-step_1_field3_chfield_value').val('');
			$('#step_1_field3_chvlaue').css('display','none');
			$("input[name='FormBuilder[step_1_field4_chrequire]'][value='1']").prop("checked",true);
			$('#step_1_chfield4').css('display','block');//before any change if no option radio button selected
			$("input[name='FormBuilder[step_1_field4_chmandatory]'][value='1']").prop("checked",true);
			$('#formbuilder-step_1_field4_chlabel').val('Supplied');
			$('#formbuilder-step_1_field4_chdata_type').val('');
			$('#formbuilder-step_1_field4_chvalidation_type').val('');
			$('#step_1_field4_chvalidation_type').css('display','none');
			$('#formbuilder-step_1_field4_chno_chars').val('');
			$('#step_1_field4_chno_of_chars').hide();
			$('#formbuilder-step_1_field4_chfield_value').val('');
			$('#step_1_field4_chvlaue').css('display','none');
			$("input[name='FormBuilder[step_1_field5_chrequire]'][value='1']").prop("checked",true);
			$('#step_1_chfield5').css('display','block');//before any change if no option radio button selected
			$("input[name='FormBuilder[step_1_field5_chmandatory]'][value='1']").prop("checked",true);
			$('#formbuilder-step_1_field5_chlabel').val('Supplied');
			$('#formbuilder-step_1_field5_chdata_type').val('');
			$('#formbuilder-step_1_field5_chvalidation_type').val('');
			$('#step_1_field5_chvalidation_type').css('display','none');
			$('#formbuilder-step_1_field5_chno_chars').val('');
			$('#step_1_field5_chno_of_chars').hide();
			$('#formbuilder-step_1_field5_chfield_value').val('');
			$('#step_1_field5_chvlaue').css('display','none');
			$("#refresh_form_1").trigger('reset');
			
			$("input[name='FormBuilder[step_2_field1_chrequire]'][value='1']").prop("checked",true);
			$('#step_2_chfield1').css('display','block');//before any change if no option radio button selected
			$("input[name='FormBuilder[step_2_field1_chmandatory]'][value='1']").prop("checked",true);
			$('#formbuilder-step_2_field1_chlabel1').val('Collection');
			$('#formbuilder-step_2_field2_chlabel2').val('Target');
			$('#formbuilder-step_2_field3_chlabel3').val('Status');
			$("input[name='FormBuilder[step_3_field1_chrequire]'][value='1']").prop("checked",true);
			$('#step_3_chfield1').css('display','block');//before any change if no option radio button selected
			$("input[name='FormBuilder[step_3_field1_chmandatory]'][value='1']").prop("checked",true);
			$('#formbuilder-step_3_field1_chlabel').val('Remarks');
			$('#formbuilder-step_3_field1_chdata_type').val('');
			$('#step_3_field1_chvalidation_type').css('display','none');
			$('#formbuilder-step_3_field1_chno_chars').val('');
			$('#step_3_field1_chno_of_chars').css("display","none");
			$('#step_3_field1_chvlaue').css('display','none');
			$("input[name='FormBuilder[step_4_field1_chrequire]'][value='1']").prop("checked",true);
			$('#step_4_chfield1').css('display','block');//before any change if no option radio button selected
			$("input[name='FormBuilder[step_4_field1_chmandatory]'][value='1']").prop("checked",true);
			$('#formbuilder-step_4_field1_chlabel').val('Remarks');
			$('#formbuilder-step_4_field1_chdata_type').val('');
			$('#step_4_field1_chvalidation_type').css('display','none');
			$('#formbuilder-step_4_field1_chno_chars').val('');
			$('#step_4_field1_chno_of_chars').css("display","none");
			$('#step_4_field1_chvlaue').css('display','none');
			$('#formbuilder-step_4_field1_chno_of_images').val('1');
			$("#refresh_form_2_3").trigger('reset');
	 }
 });
 
 $('#formbuilder-companyid').on('change',function(){
	 var companyid = $('#formbuilder-companyid').val();
	 var activityval = $('#ch_activity_id').val();
	 var prod_id = $('#formbuilder-product_id').val();
	 if (prod_id != '') {
		 $("input:radio[name='FormBuilder[step_1_chrequire]'][value='1']").click();
		 $("input:radio[name='FormBuilder[step_1_chrequire]'][value='1']").prop("checked",true);
		 $("input[name='FormBuilder[step_1_field1_chrequire]'][value='1']").click();
		 $("input[name='FormBuilder[step_1_field1_chrequire]'][value='1']").prop("checked",true);
		 $("input[name='FormBuilder[step_1_field2_chrequire]'][value='1']").click();
		 $("input[name='FormBuilder[step_1_field2_chrequire]'][value='1']").prop("checked",true);
		 $("input[name='FormBuilder[step_1_field3_chrequire]'][value='1']").click();
		 $("input[name='FormBuilder[step_1_field3_chrequire]'][value='1']").prop("checked",true);
		 $("input[name='FormBuilder[step_1_field4_chrequire]'][value='1']").click();
		 $("input[name='FormBuilder[step_1_field4_chrequire]'][value='1']").prop("checked",true);
		 $("input[name='FormBuilder[step_1_field5_chrequire]'][value='1']").click();
		 $("input[name='FormBuilder[step_1_field5_chrequire]'][value='1']").prop("checked",true);
		 $("input[name='FormBuilder[step_1_field1_chmandatory]'][value='1']").click();
		 $("input[name='FormBuilder[step_1_field1_chmandatory]'][value='1']").prop("checked",true);
		 $("input[name='FormBuilder[step_1_field2_chmandatory]'][value='1']").click();
		 $("input[name='FormBuilder[step_1_field2_chmandatory]'][value='1']").prop("checked",true);
		 $("input[name='FormBuilder[step_1_field3_chmandatory]'][value='1']").click();
		 $("input[name='FormBuilder[step_1_field3_chmandatory]'][value='1']").prop("checked",true);
		 $("input[name='FormBuilder[step_1_field4_chmandatory]'][value='1']").click();
		 $("input[name='FormBuilder[step_1_field4_chmandatory]'][value='1']").prop("checked",true);
		 $("input[name='FormBuilder[step_1_field5_chmandatory]'][value='1']").click();
		 $("input[name='FormBuilder[step_1_field5_chmandatory]'][value='1']").prop("checked",true);
		 $("input:radio[name='FormBuilder[step_1_field1_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');
		 $("input:radio[name='FormBuilder[step_1_field2_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');
		 $("input:radio[name='FormBuilder[step_1_field3_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');
		 $("input:radio[name='FormBuilder[step_1_field4_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');
		 $("input:radio[name='FormBuilder[step_1_field5_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');
		 $("input[name='FormBuilder[step_1_chrequire]'][value='1']").click();
		 	$("input[name='FormBuilder[product_unit][]']").prop("checked",false);
			$("input[name='FormBuilder[step_1_field1_chrequire]'][value='1']").prop("checked",true);
			$('#step_1_chfield1').css('display','block');//before any change if no option radio button selected
			$("input[name='FormBuilder[step_1_field1_chmandatory]'][value='1']").prop("checked",true);
			$('#formbuilder-step_1_field1_chlabel').val('');
			$('#formbuilder-step_1_field1_chdata_type').val('');
			$('#formbuilder-step_1_field1_chvalidation_type').val('');
			$('#step_1_field1_chvalidation_type').css('display','none');
			$('#formbuilder-step_1_field1_chno_chars').val('');
			$('#step_1_field1_chno_of_chars').hide();
			$('#formbuilder-step_1_field1_chfield_value').val('');
			$('#step_1_field1_chvlaue').css('display','none');
			$("input[name='FormBuilder[step_1_field2_chrequire]'][value='1']").prop("checked",true);
			$('#step_1_chfield2').css('display','block');//before any change if no option radio button selected
			$("input[name='FormBuilder[step_1_field2_chmandatory]'][value='1']").prop("checked",true);
			$('#formbuilder-step_1_field2_chlabel').val('');
			$('#formbuilder-step_1_field2_chdata_type').val('');
			$('#formbuilder-step_1_field2_chvalidation_type').val('');
			$('#step_1_field2_chvalidation_type').css('display','none');
			$('#formbuilder-step_1_field2_chno_chars').val('');
			$('#step_1_field2_chno_of_chars').hide();
			$('#formbuilder-step_1_field2_chfield_value').val('');
			$('#step_1_field2_chvlaue').css('display','none');
			$("input[name='FormBuilder[step_1_field3_chrequire]'][value='1']").prop("checked",true);
			$('#step_1_chfield3').css('display','block');//before any change if no option radio button selected
			$("input[name='FormBuilder[step_1_field3_chmandatory]'][value='1']").prop("checked",true);
			$('#formbuilder-step_1_field3_chlabel').val('');
			$('#formbuilder-step_1_field3_chdata_type').val('');
			$('#formbuilder-step_1_field3_chvalidation_type').val('');
			$('#formbuilder-step_1_field3_chno_chars').val('');
			$('#step_1_field3_chno_of_chars').hide();
			$('#step_1_field3_chvalidation_type').css('display','none');
			$('#formbuilder-step_1_field3_chfield_value').val('');
			$('#step_1_field3_chvlaue').css('display','none');
			$("input[name='FormBuilder[step_1_field4_chrequire]'][value='1']").prop("checked",true);
			$('#step_1_chfield4').css('display','block');//before any change if no option radio button selected
			$("input[name='FormBuilder[step_1_field4_chmandatory]'][value='1']").prop("checked",true);
			$('#formbuilder-step_1_field4_chlabel').val('');
			$('#formbuilder-step_1_field4_chdata_type').val('');
			$('#formbuilder-step_1_field4_chvalidation_type').val('');
			$('#step_1_field4_chvalidation_type').css('display','none');
			$('#formbuilder-step_1_field4_chno_chars').val('');
			$('#step_1_field4_chno_of_chars').hide();
			$('#formbuilder-step_1_field4_chfield_value').val('');
			$('#step_1_field4_chvlaue').css('display','none');
			$("input[name='FormBuilder[step_1_field5_chrequire]'][value='1']").prop("checked",true);
			$('#step_1_chfield5').css('display','block');//before any change if no option radio button selected
			$("input[name='FormBuilder[step_1_field5_chmandatory]'][value='1']").prop("checked",true);
			$('#formbuilder-step_1_field5_chlabel').val('');
			$('#formbuilder-step_1_field5_chdata_type').val('');
			$('#formbuilder-step_1_field5_chvalidation_type').val('');
			$('#step_1_field5_chvalidation_type').css('display','none');
			$('#formbuilder-step_1_field5_chno_chars').val('');
			$('#step_1_field5_chno_of_chars').hide();
			$('#formbuilder-step_1_field5_chfield_value').val('');
			$('#step_1_field5_chvlaue').css('display','none');
			$("#refresh_form_1").trigger('reset');
	 }
	 if (companyid != '') {
			$.ajax({
				method: "GET",
				url: "dynamicdata",
				async: false,
				data: {company_id: companyid,activity_id: activityval,type:'channel'},
				success: function(data) {
					res = $.parseJSON(data);
					console.log(res);
					if (res != '') {
						if (res['step1']) {
							$("input:radio[name='FormBuilder[step_1_chrequire]'][value='1']").click();
							$("input:radio[name='FormBuilder[step_1_chrequire]'][value='1']").prop("checked",true);
							$("#refresh_form_1").trigger('reset');
						}
						if (!res['step1']) {
							$("input:radio[name='FormBuilder[step_1_chrequire]'][value='0']").click();
							$("input:radio[name='FormBuilder[step_1_chrequire]'][value='0']").prop("checked",true);
						}
						/*if (res['step2']) {
							if(res['step2'][0]['require'] == 1) {
								$("input:radio[name='FormBuilder[step_2_field1_chrequire]'][value='1']").click();
								$("input[name='FormBuilder[step_2_field1_chrequire]'][value='1']").prop("checked",true);
								$('#step_2_chfield1').css('display','block');//before any change if no option radio button selected
								$('#step_2_chfield1 input').removeAttr('disabled');
							} else {
								$("input:radio[name='FormBuilder[step_2_field1_chrequire]'][value='0']").click();
								$("input[name='FormBuilder[step_2_field1_chrequire]'][value='0']").prop("checked",true);
							}
							if(res['step2'][0]['mandatory'] == 1) {
								$("input:radio[name='FormBuilder[step_2_field1_chmandatory]'][value='1']").click();
								$("input[name='FormBuilder[step_2_field1_chmandatory]'][value='1']").prop("checked",true);
								$("input:radio[name='FormBuilder[step_2_field1_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');
							} else {
								$("input:radio[name='FormBuilder[step_2_field1_chmandatory]'][value='0']").click();
								$("input[name='FormBuilder[step_2_field1_chmandatory]'][value='0']").prop("checked",true);
								$("input:radio[name='FormBuilder[step_2_field1_chmandatory]']").parents(':eq(2)').addClass('grey-bg');
							}
							if (res['step2'][0]['label'] != '') {
								$('#formbuilder-step_2_field1_chlabel1').val(res['step2'][0]['label']);
							} else {
								$('#formbuilder-step_2_field1_chlabel1').val('');
							}
							if (res['step2'][1]['label'] != '') {
								$('#formbuilder-step_2_field2_chlabel2').val(res['step2'][1]['label']);
							} else {
								$('#formbuilder-step_2_field2_chlabel2').val('');
							}
							if (res['step2'][2]['label'] != '') {
								$('#formbuilder-step_2_field3_chlabel3').val(res['step2'][2]['label']);
							} else {
								$('#formbuilder-step_2_field3_chlabel3').val('');
							}
						}
						if (!res['step2']) {
							$("input:radio[name='FormBuilder[step_2_field1_chrequire]'][value='0']").click();
							$("input:radio[name='FormBuilder[step_2_field1_chrequire]'][value='0']").prop("checked",true);
						}*/
						if (res['step2']) {
							if(res['step2'][0]['require'] == 1) {
								$("input:radio[name='FormBuilder[step_3_field1_chrequire]'][value='1']").click();
								$("input:radio[name='FormBuilder[step_3_field1_chrequire]'][value='1']").prop("checked",true);
								$('#step_3_chfield1').css('display','block');//before any change if no option radio button selected
								$("input[name='FormBuilder[step_3_field1_chmandatory]']").removeAttr("disabled");
								$('#formbuilder-step_3_field1_chlabel').removeAttr("disabled");
								$('#formbuilder-step_3_field1_chdata_type').removeAttr("disabled");
								$("input:radio[name='FormBuilder[step_3_field1_chrequire]']").parents(':eq(2)').removeClass('grey-bg');
							} else {
								$("input:radio[name='FormBuilder[step_3_field1_chrequire]'][value='0']").click();
								$("input[name='FormBuilder[step_3_field1_chrequire]'][value='0']").prop("checked",true);
								$("input:radio[name='FormBuilder[step_3_field1_chrequire]']").parents(':eq(2)').addClass('grey-bg');
							}
							if(res['step2'][0]['mandatory'] == 1) {
								$("input:radio[name='FormBuilder[step_3_field1_chmandatory]'][value='1']").click();
								$("input[name='FormBuilder[step_3_field1_chmandatory]'][value='1']").prop("checked",true);
								$("input:radio[name='FormBuilder[step_3_field1_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');
							} else {
								$("input:radio[name='FormBuilder[step_3_field1_chmandatory]'][value='0']").click();
								$("input[name='FormBuilder[step_3_field1_chmandatory]'][value='0']").prop("checked",true);
								$("input:radio[name='FormBuilder[step_3_field1_chmandatory]']").parents(':eq(2)').addClass('grey-bg');
							}
							$('#formbuilder-step_3_field1_chlabel').val(res['step2'][0]['label']);
							if (res['step2'][0]['data_type'] != '') {
								$('#formbuilder-step_3_field1_chdata_type').val(res['step2'][0]['data_type']);
								if (res['step2'][0]['data_type'] == 'edittext') {
									$('#step_3_field1_chvalidation_type').css('display','block');
									$('#formbuilder-step_3_field1_chvalidation_type').val(res['step2'][0]['validation_type']);
									$('#step_3_field1_chvlaue input').attr("disabled","disabled");
									$('#step_3_field1_chvlaue').css("display","none");
									$('#formbuilder-step_3_field1_chno_chars').val(res['step2'][0]['no_of_chars']);
									$('#step_3_field1_chno_of_chars').css("display","block");
								} else if (res['step2'][0]['data_type'] == 'textarea') {
									$('#formbuilder-step_3_field1_chvalidation_type').val('');
									$('#step_3_field1_chvalidation_type').css('display','none');
									$('#formbuilder-step_3_field1_chfield_value').val('');
									$('.step_3_field1_chfield_boxes').remove();
									$('#step_3_field1_chvlaue input').attr("disabled","disabled");
									$('#step_3_field1_chvlaue').css('display','none');
									$('#formbuilder-step_3_field1_chno_chars').val(res['step2'][0]['no_of_chars']);
									$('#step_3_field1_chno_of_chars').css("display","block");
								} else if (res['step2'][0]['data_type'] == 'rating') {
									$('#formbuilder-step_3_field1_chvalidation_type').val('');
									$('#step_3_field1_chvalidation_type').css('display','none');
									$('#formbuilder-step_3_field1_chfield_value').val('');
									$('.step_3_field1_chfield_boxes').remove();
									$('#step_3_field1_chvlaue input').attr("disabled","disabled");
									$('#step_3_field1_chvlaue').css('display','none');
									$('#formbuilder-step_3_field1_chno_chars').val('');
									$('#step_3_field1_chno_of_chars').css("display","none");
								} else if(res['step2'][0]['data_type'] == 'radio' || res['step2'][0]['data_type'] == 'checkbox' || res['step2'][0]['data_type'] == 'selectbox') {
									$('#formbuilder-step_3_field1_chvalidation_type').val('');
									$('#step_3_field1_chvalidation_type').css('display','none');
									$('#step_3_field1_chvlaue input').removeAttr('disabled');
									$('#step_3_field1_chvlaue').css("display","block");
									if (res['step2'][0]['values'] instanceof Array) {
										//console.log(res['step4'][0]['values']);
										$('#formbuilder-step_3_field1_chfield_value').val(res['step2'][0]['values'][0]);
										$('.step_3_field1_chfield_boxes').remove();
										 var field_value = res['step2'][0]['values'];
										 var values_length = res['step2'][0]['values'].length;
										 var j = 0;
										 for(var i= 1; i <= values_length-1;i++) {
											 var no = $(".form-group").length + 1;
								             var more_textbox = $('<div class="form-group step_3_field1_chfield_boxes">' +
								                '</span></label>' +
								                '<div class="row"><div class="col-sm-offset-6 col-sm-6 col-md-offset-5  col-md-7 col-lg-offset-4 col-lg-4"><div class="dd-check"><span class="pull-left"><input class="form-control" type="text" name="step_3_field1_chfield_boxes[]" value = "'+ field_value[i] +'" id="txtbox' + no + '" />' +
								                '</span><span class="cb"><a href="#" class="btn btn-danger btn-xs remove-txt"><i class="fa fa-minus"></i></a></span>' +
								                '</div></div><div class="help-block"></div></div></div>');
								             $("#step_3_field1_chvlaue .form-group:last").after(more_textbox);
								             more_textbox.fadeIn("slow");
								             j++;
										 }
									}
								}
							}
						}
						if (!res['step2']) {
							$("input:radio[name='FormBuilder[step_3_field1_chrequire]'][value='0']").click();
							$("input:radio[name='FormBuilder[step_3_field1_chrequire]'][value='0']").prop("checked",true);
						}
						if(res['step3']) {
							$("input[name='FormBuilder[step_4_field1_chrequire]'][value='1']").click();						

							//alert(res['step1'][0]['require']);
							if(res['step3'][0]['require'] == 1) {
								$("input[name='FormBuilder[step_4_field1_chrequire]'][value='1']").prop("checked",true);
							} else {
								$("input[name='FormBuilder[step_4_field1_chrequire]'][value='0']").prop("checked",true);
								$("input[name='FormBuilder[step_4_field1_chmandatory]'][value='0']").prop("checked",true);
								$('#formbuilder-step_4_field1_chlabel').val('');
								$('#step_4_chfield1').css('display','none');
							}
							if(res['step3'][0]['mandatory'] == 1) {
								$("input[name='FormBuilder[step_4_field1_chmandatory]'][value='1']").prop("checked",true);
								$("input:radio[name='FormBuilder[step_4_field1_chmandatory]']").parents(':eq(2)').removeClass('grey-bg');
								$("input[name='FormBuilder[step_4_field1_chmandatory]'][value='1']").next('span').addClass('input-checked');
								$("input[name='FormBuilder[step_4_field1_chmandatory]'][value='0']").next('span').removeClass('input-checked');
							} else {
								$("input[name='FormBuilder[step_4_field1_chmandatory]'][value='0']").prop("checked",true);
								$("input[name='FormBuilder[step_4_field1_chmandatory]'][value='1']").next('span').removeClass('input-checked');
								$("input:radio[name='FormBuilder[step_4_field1_chmandatory]']").parents(':eq(2)').addClass('grey-bg');
								$("input[name='FormBuilder[step_4_field1_chmandatory]'][value='0']").next('span').addClass('input-checked');
								
							}
							if(res['step3'][0]['label'] != '') {
								$('#formbuilder-step_4_field1_chlabel').val(res['step3'][0]['label']);
							} else {
								
							}
							if(res['step3'][0]['no_of_images'] != '' && res['step3'][0]['no_of_images'] != 0) {
								$('#formbuilder-step_4_field1_chno_of_images').val(res['step3'][0]['no_of_images']);
							} else {
								$('#formbuilder-step_4_field1_chno_of_images').val('1');
							}
						} 
						if(!res['step3']) {
							$('#step_4_chfield1 input').attr('disabled','disabled');
							$("input[name='FormBuilder[step_4_field1_chrequire]'][value='0']").prop("checked",true);
							$("input:radio[name='FormBuilder[step_4_field1_chmandatory]'][value='0']").prop("checked",true);
							$("input[name='FormBuilder[step_4_field1_chrequire]'][value='0']").next('span').addClass('input-checked');
							$("input[name='FormBuilder[step_4_field1_chrequire]'][value='1']").next('span').removeClass('input-checked');
							$('#step_4_chfield1').css('display','none');
							$("input:radio[name='FormBuilder[step_4_field1_chrequire]']").parents(':eq(2)').addClass('grey-bg');
						}
					} else {
						$("input:radio[name='FormBuilder[step_1_chrequire]'][value='1']").click();
						$("input[name='FormBuilder[step_1_chrequire]'][value='1']").prop("checked",true);
						$("input:radio[name='FormBuilder[step_2_field1_chrequire]'][value='1']").click();
						$("input[name='FormBuilder[step_2_field1_chrequire]'][value='1']").prop("checked",true);
						$('#step_2_chfield1').css('display','block');//before any change if no option radio button selected
						$("input:radio[name='FormBuilder[step_2_field1_chmandatory]'][value='1']").click();
						$("input[name='FormBuilder[step_2_field1_chmandatory]'][value='1']").prop("checked",true);
						$('#formbuilder-step_2_field1_chlabel1').val('Collection');
						$('#formbuilder-step_2_field2_chlabel2').val('Target');
						$('#formbuilder-step_2_field3_chlabel3').val('Status');
						$("input:radio[name='FormBuilder[step_3_field1_chrequire]'][value='1']").click();
						$("input[name='FormBuilder[step_3_field1_chrequire]'][value='1']").prop("checked",true);
						$('#step_3_chfield1').css('display','block');//before any change if no option radio button selected
						$("input:radio[name='FormBuilder[step_3_field1_chmandatory]'][value='1']").click();
						$("input[name='FormBuilder[step_3_field1_chmandatory]'][value='1']").prop("checked",true);
						$('#formbuilder-step_3_field1_chlabel').val('Remarks');
						$('#formbuilder-step_3_field1_chdata_type').val('');
						$('#formbuilder-step_3_field1_chno_chars').val('');
						$('#step_3_field1_chno_of_chars').hide();
						$('#step_3_field1_chvalidation_type').css('display','none');
						$('#step_3_field1_chvlaue').css('display','none');
						$('#step_2_chfield1 input').removeAttr('disabled');
			        	$('#step_3_chfield1 input').removeAttr('disabled');
			        	$('#step_3_chfield1 select').removeAttr('disabled');
			        	$('#formbuilder-step_3_field1_chno_chars').val('');
						$('#step_3_field1_chno_of_chars').css("display","none");
						$("input:radio[name='FormBuilder[step_4_field1_chrequire]'][value='1']").click();
						$("input[name='FormBuilder[step_4_field1_chrequire]'][value='1']").prop("checked",true);
						$('#step_4_chfield1').css('display','block');//before any change if no option radio button selected
						$("input:radio[name='FormBuilder[step_4_field1_chmandatory]'][value='1']").click();
						$("input[name='FormBuilder[step_4_field1_chmandatory]'][value='1']").prop("checked",true);
						$('#formbuilder-step_4_field1_chlabel').val('Images');
						$('#formbuilder-step_4_field1_chdata_type').val('image');
						$('#formbuilder-step_4_field1_chno_chars').val('');
						$('#step_4_field1_chno_of_chars').hide();
						$('#step_4_field1_chvalidation_type').css('display','none');
						$('#step_4_field1_chvlaue').css('display','none');
						$('#step_4_chfield1 input').removeAttr('disabled');
			        	$('#step_4_chfield1 select').removeAttr('disabled');
			        	$('#formbuilder-step_4_field1_chno_chars').val('');
						$('#step_4_field1_chno_of_chars').css("display","none");
						$('#formbuilder-step_4_field1_chno_of_images').val('1');
						$("#refresh_form_2_3").trigger('reset');
					}
				}
			});
	 }  else if (companyid == '') {
		 	$("input[name='FormBuilder[step_1_chrequire]'][value='1']").click();
		 	$("input[name='FormBuilder[product_unit][]']").prop("checked",false);
			$("input[name='FormBuilder[step_1_field1_chrequire]'][value='1']").prop("checked",true);
			$('#step_1_chfield1').css('display','block');//before any change if no option radio button selected
			$("input[name='FormBuilder[step_1_field1_chmandatory]'][value='1']").prop("checked",true);
			$('#formbuilder-step_1_field1_chlabel').val('Supplied');
			$('#formbuilder-step_1_field1_chdata_type').val('');
			$('#formbuilder-step_1_field1_chvalidation_type').val('');
			$('#step_1_field1_chvalidation_type').css('display','none');
			$('#formbuilder-step_1_field1_chno_chars').val('');
			$('#step_1_field1_chno_of_chars').hide();
			$('#formbuilder-step_1_field1_chfield_value').val('');
			$('#step_1_field1_chvlaue').css('display','none');
			$("input[name='FormBuilder[step_1_field2_chrequire]'][value='1']").prop("checked",true);
			$('#step_1_chfield2').css('display','block');//before any change if no option radio button selected
			$("input[name='FormBuilder[step_1_field2_chmandatory]'][value='1']").prop("checked",true);
			$('#formbuilder-step_1_field2_chlabel').val('Liquidated');
			$('#formbuilder-step_1_field2_chdata_type').val('');
			$('#formbuilder-step_1_field2_chvalidation_type').val('');
			$('#step_1_field2_chvalidation_type').css('display','none');
			$('#formbuilder-step_1_field2_chno_chars').val('');
			$('#step_1_field2_chno_of_chars').hide();
			$('#formbuilder-step_1_field2_chfield_value').val('');
			$('#step_1_field2_chvlaue').css('display','none');
			$("input[name='FormBuilder[step_1_field3_chrequire]'][value='1']").prop("checked",true);
			$('#step_1_chfield3').css('display','block');//before any change if no option radio button selected
			$("input[name='FormBuilder[step_1_field3_chmandatory]'][value='1']").prop("checked",true);
			$('#formbuilder-step_1_field3_chlabel').val('Season Progress');
			$('#formbuilder-step_1_field3_chdata_type').val('');
			$('#formbuilder-step_1_field3_chvalidation_type').val('');
			$('#step_1_field3_chvalidation_type').css('display','none');
			$('#formbuilder-step_1_field3_chno_chars').val('');
			$('#step_1_field3_chno_of_chars').hide();
			$('#formbuilder-step_1_field3_chfield_value').val('');
			$('#step_1_field3_chvlaue').css('display','none');
			$("input[name='FormBuilder[step_1_field4_chrequire]'][value='1']").prop("checked",true);
			$('#step_1_chfield4').css('display','block');//before any change if no option radio button selected
			$("input[name='FormBuilder[step_1_field4_chmandatory]'][value='1']").prop("checked",true);
			$('#formbuilder-step_1_field4_chlabel').val('Supplied');
			$('#formbuilder-step_1_field4_chdata_type').val('');
			$('#formbuilder-step_1_field4_chvalidation_type').val('');
			$('#step_1_field4_chvalidation_type').css('display','none');
			$('#formbuilder-step_1_field4_chno_chars').val('');
			$('#step_1_field4_chno_of_chars').hide();
			$('#formbuilder-step_1_field4_chfield_value').val('');
			$('#step_1_field4_chvlaue').css('display','none');
			$("input[name='FormBuilder[step_1_field5_chrequire]'][value='1']").prop("checked",true);
			$('#step_1_chfield5').css('display','block');//before any change if no option radio button selected
			$("input[name='FormBuilder[step_1_field5_chmandatory]'][value='1']").prop("checked",true);
			$('#formbuilder-step_1_field5_chlabel').val('Supplied');
			$('#formbuilder-step_1_field5_chdata_type').val('');
			$('#formbuilder-step_1_field5_chvalidation_type').val('');
			$('#step_1_field5_chvalidation_type').css('display','none');
			$('#formbuilder-step_1_field5_chno_chars').val('');
			$('#step_1_field5_chno_of_chars').hide();
			$('#formbuilder-step_1_field5_chfield_value').val('');
			$('#step_1_field5_chvlaue').css('display','none');
			$("#refresh_form_1").trigger('reset');
			
			$("input[name='FormBuilder[step_2_field1_chrequire]'][value='1']").click();
			$("input[name='FormBuilder[step_2_field1_chrequire]'][value='1']").prop("checked",true);
			$('#step_2_chfield1').css('display','block');//before any change if no option radio button selected
			$("input[name='FormBuilder[step_2_field1_chmandatory]'][value='1']").prop("checked",true);
			$('#formbuilder-step_2_field1_chlabel1').val('Collection');
			$('#formbuilder-step_2_field2_chlabel2').val('Target');
			$('#formbuilder-step_2_field3_chlabel3').val('Status');
			$("input[name='FormBuilder[step_3_field1_chrequire]'][value='1']").click();
			$("input[name='FormBuilder[step_3_field1_chrequire]'][value='1']").prop("checked",true);
			$('#step_3_chfield1').css('display','block');//before any change if no option radio button selected
			$("input[name='FormBuilder[step_3_field1_chmandatory]'][value='1']").prop("checked",true);
			$('#formbuilder-step_3_field1_chlabel').val('Remarks');
			$('#formbuilder-step_3_field1_chdata_type').val('');
			$('#step_3_field1_chvalidation_type').css('display','none');
			$('#formbuilder-step_3_field1_chno_chars').val('');
			$('#step_3_field1_chno_of_chars').css("display","none");
			$('#step_3_field1_chvlaue').css('display','none');
			$("input[name='FormBuilder[step_4_field1_chrequire]'][value='1']").click();
			$("input[name='FormBuilder[step_4_field1_chrequire]'][value='1']").prop("checked",true);
			$('#step_4_chfield1').css('display','block');//before any change if no option radio button selected
			$("input[name='FormBuilder[step_4_field1_chmandatory]'][value='1']").prop("checked",true);
			$('#formbuilder-step_4_field1_chlabel').val('Images');
			$('#formbuilder-step_4_field1_chdata_type').val('');
			$('#step_4_field1_chvalidation_type').css('display','none');
			$('#formbuilder-step_4_field1_chno_chars').val('');
			$('#step_4_field1_chno_of_chars').css("display","none");
			$('#step_4_field1_chvlaue').css('display','none');
			$('#formbuilder-step_4_field1_chno_of_images').val('1');
			$("#refresh_form_2_3").trigger('reset');
	 }
 });

//channel card update  end 
 /* dynamic channel form save button click start*/
 //function beforeSubmit(fn) {
	//;
	// alert('okkdszdsa');
	// return  $('#dynamic-channel-form-save').yiiActiveForm('submitForm');
	 //$('#dynamic-channel-form-save').yiiActiveForm('submitForm');
	  // call the 'callback' function you gave as argument
	/*  var res = fn();
	  //return res;
	  alert(res+ '123645');
	  if (res === false) {alert(1000);
		  return false;
	  } else {
		  return true;
	  }*/
	//}

 $('#dynamic-channel-form-save').on('beforeSubmit',function(){
	//$('#dynamic-channel-form-save').yiiActiveForm('submitForm');
	 		minimumchSteps_count = 0;
			minimum_ch_steps = true;
		 	var chfields_count = 0;//count of fields when radio, checkbox or selectbox selected
		 	var step_1_field1_chfield_lenth = 0;
		 	var step_1_field1_chfield_boxes_values = [];
		 	var step_1_field2_chfield_lenth = 0;
		 	var step_1_field2_chfield_boxes_values = [];
		 	var step_1_field3_chfield_lenth = 0;
		 	var step_1_field3_chfield_boxes_values = [];
		 	var step_1_field4_chfield_lenth = 0;
		 	var step_1_field4_chfield_boxes_values = [];
		 	var step_1_field5_chfield_lenth = 0;
		 	var step_1_field5_chfield_boxes_values = [];
		 	var step_3_field1_chfield_lenth = 0;
		 	var step_3_field1_chfield_boxes_values = [];
		 	var step1_field1_chunique_values_arr = [];
			var step1_field1_chunique_values_arr_results = [];
			var step1_field2_chunique_values_arr = [];
			var step1_field2_chunique_values_arr_results = [];
			var step1_field3_chunique_values_arr = [];
			var step1_field3_chunique_values_arr_results = [];
			var step1_field4_chunique_values_arr = [];
			var step1_field4_chunique_values_arr_results = [];
			var step1_field5_chunique_values_arr = [];
			var step1_field5_chunique_values_arr_results = [];
		 	var step2_field1_chunique_values_arr = [];
			var step2_field1_chunique_values_arr_results = [];
			var step3_field1_chunique_values_arr = [];
			var step3_field1_chunique_values_arr_results = [];
			var step4_field1_chunique_values_arr = [];
			var step4_field1_chunique_values_arr_results = [];
			var unique_fields_chcount = 0;//count of unique fields values when radio, checkbox or selectbox selected
		 	var chmin = 0;
		 	if ($("input[name='FormBuilder[step_1_chrequire]']:checked").val() == 1) {
		 		if ($("input[name='FormBuilder[step_1_field1_chrequire]']:checked").val() == 1) {
		 			minimumchSteps_count = minimumchSteps_count + 1;
		 		 	step_1_field1_chfield_lenth = $("input[name='step_1_field1_chfield_boxes[]']").length - 1;//-1 is used to remove addmore button field count from list
		 		 	var step1_field1_value_chunique = $('#formbuilder-step_1_field1_chfield_value').val();
		 			step1_field1_chunique_values_arr.push(step1_field1_value_chunique);
		 		 	if (step_1_field1_chfield_lenth > 0) {
		 		 		var chskipNo = 0;
		 		 		$("input[name='step_1_field1_chfield_boxes[]']").each(function() {
		 		 			if (chskipNo == 0) {
		 		 				chskipNo = 1;
		 		 				return;
		 		 			}
		 		 		    var step_1_field1_chvalue = $(this).val();
		 		 		    if (step_1_field1_chvalue) {
		 		 		    	$(this).parents(':eq(2)').next().html('');
		 		 		    	step_1_field1_chfield_boxes_values.push(step_1_field1_chvalue);
		 		 		    	step1_field1_chunique_values_arr.push(step_1_field1_chvalue);
		 		 		    } else {
		 		 		    	$(this).parents(':eq(2)').next().html('Cannot be blank.');
		 		 		    }
		 		 		});
		 		 	} else {
		 				if ($('#formbuilder-step_1_field1_chdata_type').val() == 'radio' || $('#formbuilder-step_1_field1_chdata_type').val() == 'checkbox' || $('#formbuilder-step_1_field1_chdata_type').val() == 'selectbox') {
		 					if (step_1_field1_chfield_lenth == 0) {
		 						chfields_count = 1;
		 						chmin = 1;
		 						$("input[name='step_1_field1_chfield_boxes[]']").each(function() {
		 							$(".field-formbuilder-step_1_field1_chfield_value").find('.help-error').html('Please add one more field.');
		 							//setTimeout(function(){ $(".field-formbuilder-step_1_field1_chfield_value").find('.help-error').html(''); }, 3000);
		 						});
		 					}
		 				} else {
		 					$(".field-formbuilder-step_1_field1_chfield_value").find('.help-error').html('');
		 				}
		 			}
		 		 	/*Duplicate field values start*/
		 			var step1_field1_chsorted_arr = step1_field1_chunique_values_arr.slice().sort(); // You can define the comparing function here. 
		 			//console.log(sorted_arr);           // JS by default uses a crappy string compare.
		 			                                     // (we use slice to clone the array so the
		 			                                     // original array won't be modified)
		 			for (var i = 0; i < step1_field1_chunique_values_arr.length - 1; i++) {
		 			    if (step1_field1_chsorted_arr[i + 1] == step1_field1_chsorted_arr[i]) {
		 			    	step1_field1_chunique_values_arr_results.push(step1_field1_chsorted_arr[i]);
		 			    }
		 			}
		 			if (step1_field1_chunique_values_arr_results.length > 0) {
		 				unique_fields_chcount = 1;
		 				$(".field-formbuilder-step_1_field1_chfield_value").find('.help-error').html('Duplicate values are entered.');
		 			} else if (step1_field1_chunique_values_arr_results.length == 0 && chmin == 0) {
		 				$(".field-formbuilder-step_1_field1_chfield_value").find('.help-error').html('');
		 			}
		 			/*Duplicate field values stop*/
		 		}
		 		if ($("input[name='FormBuilder[step_1_field2_chrequire]']:checked").val() == 1) {
		 			minimumchSteps_count = minimumchSteps_count + 1;
		 		 	step_1_field2_chfield_lenth = $("input[name='step_1_field2_chfield_boxes[]']").length - 1;//-1 is used to remove addmore button field count from list
		 		 	var step1_field2_value_chunique = $('#formbuilder-step_1_field2_chfield_value').val();
		 			step1_field2_chunique_values_arr.push(step1_field2_value_chunique);
		 		 	if (step_1_field2_chfield_lenth > 0) {
		 		 		var chskipNo = 0;
		 		 		$("input[name='step_1_field2_chfield_boxes[]']").each(function() {
		 		 			if (chskipNo == 0) {
		 		 				chskipNo = 1;
		 		 				return;
		 		 			}
		 		 		    var step_1_field2_chvalue = $(this).val();
		 		 		    if (step_1_field2_chvalue) {
		 		 		    	$(this).parents(':eq(2)').next().html('');
		 		 		    	step_1_field2_chfield_boxes_values.push(step_1_field2_chvalue);
		 		 		    	step1_field2_chunique_values_arr.push(step_1_field2_chvalue);
		 		 		    } else {
		 		 		    	$(this).parents(':eq(2)').next().html('Cannot be blank.');
		 		 		    }
		 		 		});
		 		 	} else {
		 				if ($('#formbuilder-step_1_field2_chdata_type').val() == 'radio' || $('#formbuilder-step_1_field2_chdata_type').val() == 'checkbox' || $('#formbuilder-step_1_field2_chdata_type').val() == 'selectbox') {
		 					if (step_1_field2_chfield_lenth == 0) {
		 						chfields_count = 1;
		 						chmin = 1;
		 						$("input[name='step_1_field2_chfield_boxes[]']").each(function() {
		 							$(".field-formbuilder-step_1_field2_chfield_value").find('.help-error').html('Please add one more field.');
		 							//setTimeout(function(){ $(".field-formbuilder-step_1_field2_chfield_value").find('.help-error').html(''); }, 3000);
		 						});
		 					}
		 				} else {
		 					$(".field-formbuilder-step_1_field2_chfield_value").find('.help-error').html('');
		 				}
		 			}
		 		 	/*Duplicate field values start*/
		 			var step1_field2_chsorted_arr = step1_field2_chunique_values_arr.slice().sort(); // You can define the comparing function here. 
		 			//console.log(sorted_arr);           // JS by default uses a crappy string compare.
		 			                                     // (we use slice to clone the array so the
		 			                                     // original array won't be modified)
		 			for (var i = 0; i < step1_field2_chunique_values_arr.length - 1; i++) {
		 			    if (step1_field2_chsorted_arr[i + 1] == step1_field2_chsorted_arr[i]) {
		 			    	step1_field2_chunique_values_arr_results.push(step1_field2_chsorted_arr[i]);
		 			    }
		 			}
		 			if (step1_field2_chunique_values_arr_results.length > 0) {
		 				unique_fields_chcount = 1;
		 				$(".field-formbuilder-step_1_field2_chfield_value").find('.help-error').html('Duplicate values are entered.');
		 			} else if (step1_field2_chunique_values_arr_results.length == 0 && chmin == 0){
		 				$(".field-formbuilder-step_1_field2_chfield_value").find('.help-error').html('');
		 			}
		 			/*Duplicate field values stop*/
		 		}
		 		if ($("input[name='FormBuilder[step_1_field3_chrequire]']:checked").val() == 1) {
		 			minimumchSteps_count = minimumchSteps_count + 1;
		 		 	step_1_field3_chfield_lenth = $("input[name='step_1_field3_chfield_boxes[]']").length - 1;//-1 is used to remove addmore button field count from list
		 		 	var step1_field3_value_chunique = $('#formbuilder-step_1_field3_chfield_value').val();
		 			step1_field3_chunique_values_arr.push(step1_field3_value_chunique);
		 		 	if (step_1_field3_chfield_lenth > 0) {
		 		 		var chskipNo = 0;
		 		 		$("input[name='step_1_field3_chfield_boxes[]']").each(function() {
		 		 			if (chskipNo == 0) {
		 		 				chskipNo = 1;
		 		 				return;
		 		 			}
		 		 		    var step_1_field3_chvalue = $(this).val();
		 		 		    if (step_1_field3_chvalue) {
		 		 		    	$(this).parents(':eq(2)').next().html('');
		 		 		    	step_1_field3_chfield_boxes_values.push(step_1_field3_chvalue);
		 		 		    	step1_field3_chunique_values_arr.push(step_1_field3_chvalue);
		 		 		    } else {
		 		 		    	$(this).parents(':eq(2)').next().html('Cannot be blank.');
		 		 		    }
		 		 		});
		 		 	} else {
		 				if ($('#formbuilder-step_1_field3_chdata_type').val() == 'radio' || $('#formbuilder-step_1_field3_chdata_type').val() == 'checkbox' || $('#formbuilder-step_1_field3_chdata_type').val() == 'selectbox') {
		 					if (step_1_field3_chfield_lenth == 0) {
		 						chfields_count = 1;
		 						chmin = 1;
		 						$("input[name='step_1_field3_chfield_boxes[]']").each(function() {
		 							$(".field-formbuilder-step_1_field3_chfield_value").find('.help-error').html('Please add one more field.');
		 							//setTimeout(function(){ $(".field-formbuilder-step_1_field3_chfield_value").find('.help-error').html(''); }, 3000);
		 						});
		 					}
		 				} else {
		 					$(".field-formbuilder-step_1_field3_chfield_value").find('.help-error').html('');
		 				}
		 			}
		 		 	/*Duplicate field values start*/
		 			var step1_field3_chsorted_arr = step1_field3_chunique_values_arr.slice().sort(); // You can define the comparing function here. 
		 			//console.log(sorted_arr);           // JS by default uses a crappy string compare.
		 			                                     // (we use slice to clone the array so the
		 			                                     // original array won't be modified)
		 			for (var i = 0; i < step1_field3_chunique_values_arr.length - 1; i++) {
		 			    if (step1_field3_chsorted_arr[i + 1] == step1_field3_chsorted_arr[i]) {
		 			    	step1_field3_chunique_values_arr_results.push(step1_field3_chsorted_arr[i]);
		 			    }
		 			}
		 			if (step1_field3_chunique_values_arr_results.length > 0) {
		 				unique_fields_chcount = 1;
		 				$(".field-formbuilder-step_1_field3_chfield_value").find('.help-error').html('Duplicate values are entered.');
		 			} else if (step1_field3_chunique_values_arr_results.length == 0 && chmin == 0) {
		 				$(".field-formbuilder-step_1_field3_chfield_value").find('.help-error').html('');
		 			}
		 			/*Duplicate field values stop*/
		 		}
		 		if ($("input[name='FormBuilder[step_1_field4_chrequire]']:checked").val() == 1) {
		 			minimumchSteps_count = minimumchSteps_count + 1;
		 		 	step_1_field4_chfield_lenth = $("input[name='step_1_field4_chfield_boxes[]']").length - 1;//-1 is used to remove addmore button field count from list
		 		 	var step1_field4_value_chunique = $('#formbuilder-step_1_field4_chfield_value').val();
		 			step1_field4_chunique_values_arr.push(step1_field4_value_chunique);
		 		 	if (step_1_field4_chfield_lenth > 0) {
		 		 		var chskipNo = 0;
		 		 		$("input[name='step_1_field4_chfield_boxes[]']").each(function() {
		 		 			if (chskipNo == 0) {
		 		 				chskipNo = 1;
		 		 				return;
		 		 			}
		 		 		    var step_1_field4_chvalue = $(this).val();
		 		 		    if (step_1_field4_chvalue) {
		 		 		    	$(this).parents(':eq(2)').next().html('');
		 		 		    	step_1_field4_chfield_boxes_values.push(step_1_field4_chvalue);
		 		 		    	step1_field4_chunique_values_arr.push(step_1_field4_chvalue);
		 		 		    } else {
		 		 		    	$(this).parents(':eq(2)').next().html('Cannot be blank.');
		 		 		    }
		 		 		});
		 		 	} else {
		 				if ($('#formbuilder-step_1_field4_chdata_type').val() == 'radio' || $('#formbuilder-step_1_field4_chdata_type').val() == 'checkbox' || $('#formbuilder-step_1_field4_chdata_type').val() == 'selectbox') {
		 					if (step_1_field4_chfield_lenth == 0) {
		 						chfields_count = 1;
		 						chmin = 1;
		 						$("input[name='step_1_field4_chfield_boxes[]']").each(function() {
		 							$(".field-formbuilder-step_1_field4_chfield_value").find('.help-error').html('Please add one more field.');
		 							//setTimeout(function(){ $(".field-formbuilder-step_1_field4_chfield_value").find('.help-error').html(''); }, 3000);
		 						});
		 					}
		 				} else {
		 					$(".field-formbuilder-step_1_field4_chfield_value").find('.help-error').html('');
		 				}
		 			}
		 		 	/*Duplicate field values start*/
		 			var step1_field4_chsorted_arr = step1_field4_chunique_values_arr.slice().sort(); // You can define the comparing function here. 
		 			//console.log(sorted_arr);           // JS by default uses a crappy string compare.
		 			                                     // (we use slice to clone the array so the
		 			                                     // original array won't be modified)
		 			for (var i = 0; i < step1_field4_chunique_values_arr.length - 1; i++) {
		 			    if (step1_field4_chsorted_arr[i + 1] == step1_field4_chsorted_arr[i]) {
		 			    	step1_field4_chunique_values_arr_results.push(step1_field4_chsorted_arr[i]);
		 			    }
		 			}
		 			if (step1_field4_chunique_values_arr_results.length > 0) {
		 				unique_fields_chcount = 1;
		 				$(".field-formbuilder-step_1_field4_chfield_value").find('.help-error').html('Duplicate values are entered.');
		 			} else if (step1_field4_chunique_values_arr_results.length == 0 && chmin == 0){
		 				$(".field-formbuilder-step_1_field4_chfield_value").find('.help-error').html('');
		 			}
		 			/*Duplicate field values stop*/
		 		}
		 		if ($("input[name='FormBuilder[step_1_field5_chrequire]']:checked").val() == 1) {
		 			minimumchSteps_count = minimumchSteps_count + 1;
		 		 	step_1_field5_chfield_lenth = $("input[name='step_1_field5_chfield_boxes[]']").length - 1;//-1 is used to remove addmore button field count from list
		 		 	var step1_field5_value_chunique = $('#formbuilder-step_1_field5_chfield_value').val();
		 			step1_field5_chunique_values_arr.push(step1_field5_value_chunique);
		 		 	if (step_1_field5_chfield_lenth > 0) {
		 		 		var chskipNo = 0;
		 		 		$("input[name='step_1_field5_chfield_boxes[]']").each(function() {
		 		 			if (chskipNo == 0) {
		 		 				chskipNo = 1;
		 		 				return;
		 		 			}
		 		 		    var step_1_field5_chvalue = $(this).val();
		 		 		    if (step_1_field5_chvalue) {
		 		 		    	$(this).parents(':eq(2)').next().html('');
		 		 		    	step_1_field5_chfield_boxes_values.push(step_1_field5_chvalue);
		 		 		    	step1_field5_chunique_values_arr.push(step_1_field5_chvalue);
		 		 		    } else {
		 		 		    	$(this).parents(':eq(2)').next().html('Cannot be blank.');
		 		 		    }
		 		 		});
		 		 	} else {
		 				if ($('#formbuilder-step_1_field5_chdata_type').val() == 'radio' || $('#formbuilder-step_1_field5_chdata_type').val() == 'checkbox' || $('#formbuilder-step_1_field5_chdata_type').val() == 'selectbox') {
		 					if (step_1_field5_chfield_lenth == 0) {
		 						chfields_count = 1;
		 						chmin = 1;
		 						$("input[name='step_1_field5_chfield_boxes[]']").each(function() {
		 							$(".field-formbuilder-step_1_field5_chfield_value").find('.help-error').html('Please add one more field.');
		 							//setTimeout(function(){ $(".field-formbuilder-step_1_field5_chfield_value").find('.help-error').html(''); }, 3000);
		 						});
		 					}
		 				} else {
		 					$(".field-formbuilder-step_1_field5_chfield_value").find('.help-error').html('');
		 				}
		 			}
		 		 	/*Duplicate field values start*/
		 			var step1_field5_chsorted_arr = step1_field5_chunique_values_arr.slice().sort(); // You can define the comparing function here. 
		 			//console.log(sorted_arr);           // JS by default uses a crappy string compare.
		 			                                     // (we use slice to clone the array so the
		 			                                     // original array won't be modified)
		 			for (var i = 0; i < step1_field5_chunique_values_arr.length - 1; i++) {
		 			    if (step1_field5_chsorted_arr[i + 1] == step1_field5_chsorted_arr[i]) {
		 			    	step1_field5_chunique_values_arr_results.push(step1_field5_chsorted_arr[i]);
		 			    }
		 			}
		 			if (step1_field5_chunique_values_arr_results.length > 0) {
		 				unique_fields_chcount = 1;
		 				$(".field-formbuilder-step_1_field5_chfield_value").find('.help-error').html('Duplicate values are entered.');
		 			} else if (step1_field5_chunique_values_arr_results.length == 0 && chmin == 0){
		 				$(".field-formbuilder-step_1_field5_chfield_value").find('.help-error').html('');
		 			}
		 			/*Duplicate field values stop*/
		 		}
		 		/* minimum fields required for step 1 */
				minimum_ch_steps = minimumchSteps();
				//alert(minimum_ch_steps)
				/* minimum fields required for step 1 */
		 	}
		 	if ($("input[name='FormBuilder[step_3_field1_chrequire]']:checked").val() == 1) {
		 	 	step_3_field1_chfield_lenth = $("input[name='step_3_field1_chfield_boxes[]']").length - 1;//-1 is used to remove addmore button field count from list
		 	 	var step3_field1_value_chunique = $('#formbuilder-step_3_field1_chfield_value').val();
	 			step3_field1_chunique_values_arr.push(step3_field1_value_chunique);
		 	 	if (step_3_field1_chfield_lenth > 0) {
		 	 		var chskipNo = 0;
		 	 		$("input[name='step_3_field1_chfield_boxes[]']").each(function() {
		 	 			if (chskipNo == 0) {
		 	 				chskipNo = 1;
		 	 				return;
		 	 			}
		 	 		    var step_3_field1_chvalue = $(this).val();
		 	 		    if (step_3_field1_chvalue) {
		 	 		    	$(this).parents(':eq(2)').next().html('');
		 	 		    	$(".field-formbuilder-step_3_field1_chfield_value").find('.help-error').html('');
		 	 		    	step_3_field1_chfield_boxes_values.push(step_3_field1_chvalue);
		 	 		    	step3_field1_chunique_values_arr.push(step_3_field1_chvalue);
		 	 		    } else {
		 	 		    	$(this).parents(':eq(2)').next().html('Cannot be blank.');
		 	 		    }
		 	 		});
		 	 	} else {
		 			if ($('#formbuilder-step_3_field1_chdata_type').val() == 'radio' || $('#formbuilder-step_3_field1_chdata_type').val() == 'checkbox' || $('#formbuilder-step_3_field1_chdata_type').val() == 'selectbox') {
		 				if (step_3_field1_chfield_lenth == 0) {
		 					chfields_count = 1;
		 					chmin = 1;
		 					$("input[name='step_3_field1_chfield_boxes[]']").each(function() {
		 						$(".field-formbuilder-step_3_field1_chfield_value").find('.help-error').html('Please add one more field.');
		 						setTimeout(function(){ $(".field-formbuilder-step_3_field1_chfield_value").find('.help-error').html(''); }, 3000);
		 					});
		 				}
		 			} else {
						$(".field-formbuilder-step_3_field1_chfield_value").find('.help-error').html('');
					}
		 		}
		 	 	/*Duplicate field values start*/
	 			var step3_field1_chsorted_arr = step3_field1_chunique_values_arr.slice().sort(); // You can define the comparing function here. 
	 			//console.log(sorted_arr);           // JS by default uses a crappy string compare.
	 			                                     // (we use slice to clone the array so the
	 			                                     // original array won't be modified)
	 			for (var i = 0; i < step3_field1_chunique_values_arr.length - 1; i++) {
	 			    if (step3_field1_chsorted_arr[i + 1] == step3_field1_chsorted_arr[i]) {
	 			    	step3_field1_chunique_values_arr_results.push(step3_field1_chsorted_arr[i]);
	 			    }
	 			}
	 			if (step3_field1_chunique_values_arr_results.length > 0) {
	 				unique_fields_chcount = 1;
	 				$(".field-formbuilder-step_3_field1_chfield_value").find('.help-error').html('Duplicate values are entered.');
	 			} else if (step3_field1_chunique_values_arr_results.length == 0 && chmin == 0){
	 				$(".field-formbuilder-step_3_field1_chfield_value").find('.help-error').html('');
	 			}
	 			/*Duplicate field values stop*/
		 	}
		  	//if any errors are there collapse menu has to open start
		 	accordionproductOpen();
		 	//if any errors are there collapse menu has to open end
		 	if (step_1_field1_chfield_boxes_values.length != step_1_field1_chfield_lenth || step_1_field2_chfield_boxes_values.length != step_1_field2_chfield_lenth || step_1_field3_chfield_boxes_values.length != step_1_field3_chfield_lenth || step_1_field4_chfield_boxes_values.length != step_1_field4_chfield_lenth || step_1_field5_chfield_boxes_values.length != step_1_field5_chfield_lenth || step_3_field1_chfield_boxes_values.length != step_3_field1_chfield_lenth || chfields_count == 1 || minimum_ch_steps === false || unique_fields_chcount == 1) {
		        return false;
		    } 
		 	return true;
  });
$('#dynamic-channel-form-save').on('submit',function(){
		setTimeout(function(){ accordionproductOpen(); }, 500);

});
  /* dynamic channel form save button click end*/
 //if any errors are there collapse menu has to open start
 function accordionproductOpen() {
 	    $('.accordion-product').each(function(){
 			if ($(this).find('.help-block').text() != '' || $(this).find('.help-error').text() != '') {
 				if ($(this).hasClass('in')) {
 					return false;
 				} else {
 					$(this).prev().find('a').click();
 					return false;
 				}
 			} else {
 				return true;
 			}
 	    });
 }
 //if any errors are there collapse menu has to open end
//minimum fields required for step 1 start
/* $('#dynamic-channel-form-save').on('submit', function(){
 	setTimeout(function(){ accordionproductOpen(); }, 500);
 });*/
 function minimumchSteps() {
	 var chresult = true;
     if ($('#ch_activity_id').val() == 5) {
     	if (minimumchSteps_count <= 1 ) {
     		$('#formbuilder-step_1_chrequire').parent('div').next('div .help-block').html('Two fields are mandatory for step 1');
     		chresult = false;
     	}  else {
     		$('#formbuilder-step_1_chrequire').parent('div').next('div .help-block').html('');
     		chresult = true;
     	}
     }
     return chresult;
 }
 //minimum fields required for step 1 end
 /* dynamic channel form save button click start*/
 /*$('#dynamic-channel-form-save').on('submit', function(){
 	var step_1_field1_chfield_lenth = $("input[name='step_1_field1_chfield_boxes[]']").length - 1;//-1 is used to remove addmore button field count from list
 	var step_1_field1_chfield_boxes_values = [];
 	if (step_1_field1_chfield_lenth > 0) {
 		var chskipNo = 0;
 		$("input[name='step_1_field1_chfield_boxes[]']").each(function() {
 			if (chskipNo == 0) {
 				chskipNo = 1;
 				return;
 			}
 		    var step_1_field1_chvalue = $(this).val();
 		    if (step_1_field1_chvalue) {
 		    	$(this).parents(':eq(2)').next().html('');
 		    	step_1_field1_chfield_boxes_values.push(step_1_field1_chvalue);
 		    } else {
 		    	$(this).parents(':eq(2)').next().html('Cannot be blank.');
 		    }
 		});
 	}
 	var step_1_field2_chfield_lenth = $("input[name='step_1_field2_chfield_boxes[]']").length - 1;//-1 is used to remove addmore button field count from list
 	var step_1_field2_chfield_boxes_values = [];
 	if (step_1_field2_chfield_lenth > 0) {
 		var chskipNo = 0;
 		$("input[name='step_1_field2_chfield_boxes[]']").each(function() {
 			if (chskipNo == 0) {
 				chskipNo = 1;
 				return;
 			}
 		    var step_1_field2_chvalue = $(this).val();
 		    if (step_1_field2_chvalue) {
 		    	$(this).parents(':eq(2)').next().html('');
 		    	step_1_field2_chfield_boxes_values.push(step_1_field2_chvalue);
 		    } else {
 		    	$(this).parents(':eq(2)').next().html('Cannot be blank.');
 		    }
 		});
 	}
 	var step_1_field3_chfield_lenth = $("input[name='step_1_field3_chfield_boxes[]']").length - 1;//-1 is used to remove addmore button field count from list
 	var step_1_field3_chfield_boxes_values = [];
 	if (step_1_field3_chfield_lenth > 0) {
 		var chskipNo = 0;
 		$("input[name='step_1_field3_chfield_boxes[]']").each(function() {
 			if (chskipNo == 0) {
 				chskipNo = 1;
 				return;
 			}
 		    var step_1_field3_chvalue = $(this).val();
 		    if (step_1_field3_chvalue) {
 		    	$(this).parents(':eq(2)').next().html('');
 		    	step_1_field3_chfield_boxes_values.push(step_1_field3_chvalue);
 		    } else {
 		    	$(this).parents(':eq(2)').next().html('Cannot be blank.');
 		    }
 		});
 	}
 	var step_3_field1_chfield_lenth = $("input[name='step_3_field1_chfield_boxes[]']").length - 1;//-1 is used to remove addmore button field count from list
 	var step_3_field1_chfield_boxes_values = [];
 	if (step_3_field1_chfield_lenth > 0) {
 		var chskipNo = 0;
 		$("input[name='step_3_field1_chfield_boxes[]']").each(function() {
 			if (chskipNo == 0) {
 				chskipNo = 1;
 				return;
 			}
 		    var step_3_field1_chvalue = $(this).val();
 		    if (step_3_field1_chvalue) {
 		    	$(this).parents(':eq(2)').next().html('');
 		    	step_3_field1_chfield_boxes_values.push(step_3_field1_chvalue);
 		    } else {
 		    	$(this).parents(':eq(2)').next().html('Cannot be blank.');
 		    }
 		});
 	}
 	//if any errors are there collapse menu has to open start
	setTimeout(function(){ accordionproductOpen(); }, 500);
	//if any errors are there collapse menu has to open end
 	if (step_1_field1_chfield_boxes_values.length != step_1_field1_chfield_lenth || step_1_field2_chfield_boxes_values.length != step_1_field2_chfield_lenth || step_1_field3_chfield_boxes_values.length != step_1_field3_chfield_lenth || step_3_field1_chfield_boxes_values.length != step_3_field1_chfield_lenth) {
        return false;
    }
 	return true;
 });*/	
 /* dynamic channel form save button click end*/
//if any errors are there collapse menu has to open start
/*function accordionproductOpen() {
	    $('.accordion-product').each(function(){
			if ($(this).find('.help-block').text() != '') {
				if ($(this).hasClass('in')) {
					return false;
				} else {
					$(this).prev().find('a').click();
					return false;
				}
			} else {
				return true;
			}
	    });
}*/
//if any errors are there collapse menu has to open end
});
