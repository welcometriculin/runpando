<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Arrayhelper;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\PlanCards */

$this->title = 'Build Plan';
$this->params['breadcrumbs'][] = ['label' => 'Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>
<?php 
 	
//use app\models\Country;
 	$listData = \app\models\PlanCards::Userslist();
 	$created_by = \app\models\PlanCards::createUser();
 	/* $village_name =\app\models\Villages::villageList();
 	$village_list = ArrayHelper::map($village_name, 'village_name', 'village_name');
 	$village_list['add-new-elements'] = 'Add New'; */
/*  	$crop_name = \app\models\Crops::cropList();
 	$crop_list = ArrayHelper::map($crop_name, 'crop_name', 'crop_name');
 	$crop_list['add-new-elements'] = 'Add New';
 	$product_name = \app\models\Products::productList();
 	$product_list = ArrayHelper::map($product_name, 'product_name', 'product_name');
 	$product_list['add-new-elements'] = 'Add New'; */
 	//$partners = \app\models\ChannelPartners::partnersList();
 	//$partners_list = ArrayHelper::map($partners, 'channel_partner_name', 'channel_partner_name');
 	//$partners_list['add-new-elements'] = 'Add New';
 	?>


<div
	class="plan-cards-form">
	<div class="form row col-sm-12 mt20">
		<?php $form = ActiveForm::begin(); ?>
		<div class="form-group col-md-3">
			<?= $form->field($model, 'assign_to')->dropDownList($listData, ['prompt' => 'Select Employee']) ?>
		</div>
		<div class="form-group col-md-3">
			<?= $form->field($model, 'planned_date')->widget(yii\jui\DatePicker::className(),
					[
					'clientOptions' =>[
                      'dateFormat' => 'yyyy-m-d',
                        'minDate' => 0,
                        //'maxDate' => 5,
                        'todayHighlight' => true,
						//'yearRange'=>'2016:'.(date('Y')+1),
                        'onSelect' => new \yii\web\JsExpression('function(dateText) {
                        		$.get("plantype/",{planned_date:dateText},function(data){
                        		$("#plancards-plan_type").html(data);
});
}'),
					],
					'options'=>[
				'class'=>'form-control',
				'placeholder' =>"DD/MM/YYYY",'autocomplete' => 'off', 'onpaste' => 'return false;', 'onkeypress' => 'return false;'
                         ],]) ?>
		</div>
		<div class="form-group col-md-3">
			<?= $form->field($model, 'activity')->dropDownList(['Farm and Home Visit' => 'Farm and Home Visit', 'Farmer Group Meeting' => 'Farmer Group Meeting', 'Mass Campaign' => 'Mass Campaign','Demonstration' => 'Demonstration','Channel Card' =>'Partner Visit'], ['prompt' => 'Select Activity']) ?>
		</div>

		<div class="form-group col-md-3">
			<?= $form->field($model, 'village_id')->dropDownList(['' => 'Select '.(count($label_names_display) > 0 ? ucfirst($label_names_display['village_label']) :'Village')]); ?>
		</div>
		<div class="form-group col-md-3" id='channel' style="display: none">
			<?= $form->field($model, 'channel_partner')->dropDownList(['prompt' => 'Select  '.(count($label_names_display) > 0 ? ucfirst($label_names_display['partner_label']) :'Partner')]) ?>
		</div>
		<div class="form-group col-md-3 camp">
			<?= $form->field($model, 'crop_id')->dropDownList($crops_list, ['prompt' => 'Select '.(count($label_names_display) > 0 ? ucfirst($label_names_display['crop_label']) :'Crop')]); ?>
		</div>
		<div class="form-group col-md-3 camp">
			<?= $form->field($model, 'product_id')->dropDownList($products_list,['prompt' => 'Select '.(count($label_names_display) > 0 ? ucfirst($label_names_display['product_label']) :'Product')]); ?>
		</div>

		<div class="form-group col-md-3">
			<?= $form->field($model, 'plan_type')->dropDownList([ 'planned' => 'planned', 'adhoc' => 'adhoc'],['prompt' => 'Select Plan Type','disabled'=>'disabled']) ?>
		</div>
		<div class="hr"></div>
		<div class="form row col-md-12 mt20">

			<div class="form-group col-md-3">
				<?= $form->field($model, 'plan_approval_status')->dropDownList([ 'Approval Pending' => 'Approval Pending', 'Approved' => 'Approved','Rejected' => 'Rejected'],['disabled'=>'disabled']) ?>
			</div>
		</div>
		<div class="hr"></div>

		<div class="form row col-md-12 mt20">
			<div class="form-group col-md-3">
				<?= $form->field($model, 'status')->dropDownList([ 'not_submitted' => 'Not Submitted', 'submitted' => 'Submitted','rejected' => 'Rejected'],['disabled'=>'disabled']) ?>
			</div>
			<div class="form-group col-md-3">
				<?= $form->field($model, 'created_by')->textInput(['maxlength' => true,'readonly'=>true,'value'=>$created_by]) ?>
			</div>
		</div>
		<div class="hr"></div>
		<div class="col-md-12 text-center">
			<?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'save', 'value' => 'saved']) ?>
			<?= Html::submitButton('Save & Approve', ['class' => 'btn btn-info', 'name' => 'save', 'value' => 'saveactivate']) ?>
			<a href="<?php echo Url::to(['plancard/index']);?>" type="button"
				class="btn btn-danger">Cancel</a>
		</div>
		<div class="col-md-12">


			<?php ActiveForm::end(); ?>

		</div>


	</div>
	<!-- Modal Popup village -->


	<div class="modal fade" id="myModal" tabindex="-1" role="dialog"
		aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
						aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="panel-body panel-bg">

						<div class="form row col-sm-12 mt20">
							<div class="form-group col-md-6">
								<label class="control-label required">Add New:</label>
								<div
									class="form-group field-plancards-add_new_elements required">
									<input id="plancards-add_new_elements" class="form-control"
										type="text" name="PlanCards[add_new_elements]">
									<div class="help-block"></div>
								</div>
							</div>
						</div>
						<div class="col-md-12 text-center">
							<?= Html::button('Add', ['class' => 'btn btn-primary', 'name' => 'save', 'id' => 'add-new']) ?>
							<?= Html::button('Cancel', ['class' => 'btn btn-danger', 'name' => 'cancel', 'id' => 'add-new-cancel']) ?>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Popup End -->

	<?php
$url = Url::home();
$url2 = $url.'plancard/plantype';
$list_url = $url.'/plancard/dropdownlist';
$script = <<< JS
jQuery(document).ready(function($){
	$('#plancards-activity').change(function(){
		if($(this).val() == 'Channel Card'){
			$('#channel').show();
			$('.camp').hide();
			$('#plancards-channel_partner').find('option:eq(0)').val('');
			$('#plancards-crop_id').find('option:eq(0)').val(0);
			$('#plancards-product_id').find('option:eq(0)').val(0);
		
		} else {
			$('.camp').show();
			$('#channel').hide();
			$('#plancards-channel_partner').find('option:eq(0)').val(0);
			$('#plancards-crop_id').find('option:eq(0)').val('');
			$('#plancards-product_id').find('option:eq(0)').val('');
		}
	});
	//add new element
	$('select').change(function(){
		element_ids = $(this).attr('id');
		if ($(this).val() == 'add-new-elements') {
			$('#'+element_ids).attr('data-target','#myModal');
			$('#'+element_ids).attr('data-toggle','modal');
		} else {
			$('#'+element_ids).removeAttr('data-toggle','modal');
			$('#'+element_ids).removeAttr('data-target','#myModal');
		}
	});
	//saving add new data in dropdown
	$('#add-new').click(function(){
		var add_new_element = $.trim($('#plancards-add_new_elements').val());
		if (add_new_element != '') {
			if (add_new_element != 'add-new-elements') {
				$('#'+element_ids).append("<option selected value='"+add_new_element+"'>"+add_new_element+"</option>");
				$('#'+element_ids).removeAttr('data-toggle','modal');
				$('#'+element_ids).removeAttr('data-target','#myModal');
				$('.close').click();
				$('#plancards-add_new_elements').val('');
				$('.field-plancards-add_new_elements').removeClass('has-error');
				$('div.field-plancards-add_new_elements').find('div').html('');
			} else {
				$('.field-plancards-add_new_elements').addClass('has-error');
				$('div.field-plancards-add_new_elements').find('div').html("Please try another one");
			}
		} else {
			$('.field-plancards-add_new_elements').addClass('has-error');
			$('div.field-plancards-add_new_elements').find('div').html("Add new field can't be blank");
		}
	});
	//close or cancel popup
	$('#add-new-cancel').click(function(){
		$('#myModal').modal('hide');
		$('#'+element_ids).removeAttr('data-toggle','modal');
		$('#'+element_ids).removeAttr('data-target','#myModal');
	});
	//auto focus popup
	$('#myModal').on('shown.bs.modal', function () {
    	$('#plancards-add_new_elements').focus();
    	$('#plancards-add_new_elements').val('');
	});
	//popup hide select default option
	$('#myModal').on('hidden.bs.modal', function(){
    	if ($('#'+element_ids).val() == 'add-new-elements') {
			$('#'+element_ids).find('option[value=""]').attr('selected','selected');
			$('#'+element_ids).removeAttr('data-toggle','modal');
			$('#'+element_ids).removeAttr('data-target','#myModal');
			$('#plancards-add_new_elements').val('');
		}
 	});
		//$('#plancards-crop_name option:last').css({'color':'white','background-color':'#5e4091'});
		//$('#plancards-village_name option:last').css({'color':'white','background-color':'#5e4091'});
		//$('#plancards-product_name option:last').css({'color':'white','background-color':'#5e4091'});
		//$('#plancards-channel_partner option:last').css({'color':'white','background-color':'#5e4091'});
		
		$("#plancards-assign_to").change(function(){
			var assign_to = $(this).val();
			$.ajax({
			 	type: 'post',
			 	url:'$list_url',
				data:{assign_to:assign_to},
				success: function(response){
					 res = eval(response);
					//console.log(res['0']);
					if (res != 0) {
						$("#plancards-village_id").html(res[0]);
						$("#plancards-channel_partner").html(res[1]);
						//$("#plancards-crop_name").html(res[2]);	
					} else {
						$("#plancards-village_id").html('<option value="">Select Village</option>');
						$("#plancards-channel_partner").html('<option value="">Select Partnert</option>');
						//$("#plancards-crop_name").html('<option value="">Select Crop</option>');
					}
				}
			});
		});
});
JS;
$this->registerJs($script);
?>