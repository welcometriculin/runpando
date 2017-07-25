<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Arrayhelper;


/* @var $this yii\web\View */
/* @var $model app\models\PlanCards */

$this->title = 'Update Plan Card';
$this->params['breadcrumbs'][] = ['label' => 'Plan Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php 
 	

 	$listData=\app\models\PlanCards::Userslist();
 	$village_name =\app\models\Villages::villageList($model->assign_to, 'update');
 	$village_list = ArrayHelper::map($village_name, 'village_id', 'village_name');
 	/* $village_list['add-new-elements'] = 'Add New'; */
 	//$crop_name =\app\models\Crops::cropList($model->assign_to, 'update');
 	//$crop_list = ArrayHelper::map($crop_name, 'crop_name', 'crop_name');
 	//$crop_list['add-new-elements'] = 'Add New';
 	//$product_name =\app\models\Products::productList($model->assign_to, 'update');
 	//$product_list = ArrayHelper::map($product_name, 'product_name', 'product_name');
 	//$product_list['add-new-elements'] = 'Add New';
 	$partners = \app\models\ChannelPartners::partnersList($model->assign_to, 'update');
 	$partners_list = ArrayHelper::map($partners, 'channel_partner_name', 'channel_partner_name');
 /* 	$partners_list['add-new-elements'] = 'Add New'; */

 	?>

<div class="plan-cards-form">
	<div class="form row col-md-12 mt20">
		<?php $form = ActiveForm::begin(); ?>
		<div class="form-group col-md-3">
			<?= $form->field($model, 'assign_to')->dropDownList($listData, ['prompt' => 'Select Employee','disabled'=>'disabled']) ?>
		</div>
		<div class="form-group col-md-3">
			<?= $form->field($model, 'planned_date')->widget(yii\jui\DatePicker::className(),
					[
					'clientOptions' =>[
                      'dateFormat' => 'yyyy-MM-dd',
                        'minDate' => 0,
                       // 'readonly' =>($model->status=='completed'),
                        		'autoclose' => true,
                        //'maxDate' => 5,
                        'todayHighlight' => true,
						//'yearRange'=>'2016:'.(date('Y')+1),
							],
                    		/*'clientEvents' => [
                    		 'changeDate' => ( $model->status == 'not_submitted' || $model->plan_approval_status == 'Approved' ?true:false),

			],*/
					'options'=>[
				'class'=>'form-control',
				'placeholder' => $model->getAttributeLabel('planned_date'),
                    	 		'readonly'=>($model->plan_approval_status == 'Approved' ?true:false), 'autocomplete' => 'off', 'onpaste' => 'return false;', 'onkeypress' => 'return false;'
                         ],]) ?>
		</div>
		<div class="form-group col-md-3">
			<?= $form->field($model, 'activity')->dropDownList([ 'Farm and Home Visit' => 'Farm and Home Visit','Farmer Group Meeting' => 'Farmer Group Meeting', 'Mass Campaign' => 'Mass Campaign', 'Demonstration' => 'Demonstration', 'Channel Card' => 'Partner Visit', ], ['prompt' => 'Select Activity','disabled'=>($model->plan_approval_status == 'Rejected'?false:true)]) ?>
		</div>

		<div class="form-group col-md-3">
			<?= $form->field($model, 'village_id')->dropDownList($village_list, ['prompt' => 'Select '.(count($label_names_display) > 0 ? ucfirst($label_names_display['village_label']) :'Village'),'disabled'=>$model->plan_approval_status == 'Approved' ?true:false]); ?>
		</div>
		<div class="form-group col-md-3" id='channel' style="display: none">
			<?= $form->field($model, 'channel_partner')->dropDownList($partners_list,['prompt' => 'Select  '.(count($label_names_display) > 0 ? ucfirst($label_names_display['partner_label']) :'Partner'),'disabled'=>$model->plan_approval_status == 'Approved' ?true:false]) ?>
		</div>
		<div class="form-group col-md-3 camp">
			<?= $form->field($model, 'crop_id')->dropDownList($crops_list, ['prompt' => 'Select '.(count($label_names_display) > 0 ? ucfirst($label_names_display['crop_label']) :'Crop'),'disabled'=>$model->plan_approval_status == 'Approved' ?true:false]); ?>
		</div>

		<div class="form-group col-md-3 camp">
			<?= $form->field($model, 'product_id')->dropDownList($products_list, ['prompt' => 'Select '.(count($label_names_display) > 0 ? ucfirst($label_names_display['product_label']) :'Product'),'disabled'=>$model->plan_approval_status == 'Approved' ?true:false]); ?>
		</div>
		<div class="hr"></div>
		<div class="form row col-md-12 mt20">
			<div class="form-group col-md-3">
				<?= $form->field($model, 'plan_approval_status')->dropDownList([ 'Approval Pending' => 'Approval Pending', 'Approved' => 'Approved','Rejected' => 'Rejected'],['disabled'=>'disabled']) ?>
			</div>
			<div class="form-group col-md-3">
				<?= $form->field($model, 'plan_type')->dropDownList(['planned' => 'Planned','adhoc' => 'Adhoc'],['disabled' => 'disabled']) ?>
			</div>
			<!--<div class="form-group col-sm-3" -->
			<?php //echo  $form->field($model, 'channel_partner')->textInput(['maxlength' => true,'readonly'=>$model->status=='completed']) ?>
			<!--</div -->
		</div>
		<div class="hr"></div>

		<div class="form row col-md-12 mt20">
			<div class="form-group col-md-3">
				<?= $form->field($model, 'status')->dropDownList([ 'not_submitted' => 'Not Submitted', 'submitted' => 'Submitted','rejected' => 'Rejected'],['disabled'=>'disabled']) ?>
			</div>
			<div class="form-group col-md-3">
				<?= $form->field($model, 'created_by')->textInput(['maxlength' => true,'readonly'=>true,'value'=>$updated['createdby']]) ?>
			</div>
			<div class="form-group col-md-3">
				<?= $form->field($model, 'updated_by')->textInput(['maxlength' => true,'readonly'=>true,'value'=>$updated['updatedby']]) ?>
			</div>
		</div>
		<div class="hr"></div>
		<div class="col-md-12 text-center">
			<?php   if ($model->status != 'submitted') {
				if($model->plan_approval_status == 'Approval Pending' || $model->plan_approval_status == 'Rejected' )
				{
					echo Html::submitButton('Update', ['class'=> 'btn btn-primary','name'=>'edit','value'=>'updated']) ;
				}

				if($model->plan_approval_status != 'Approved' || $model->plan_approval_status == 'Rejected' )
				{
					echo Html::submitButton('Approve', ['class'=> 'btn btn-info','name'=>'edit','value'=>'approve']);
				} if($model->plan_approval_status == 'Approval Pending' || $model->plan_approval_status == 'Approved') {
			echo Html::submitButton('Reject', ['class'=> 'btn btn-danger bg-red','name'=>'edit','value'=>'reject']) ;
    	} /*if ($model->plan_approval_status == 'Approval Pending' || $model->plan_approval_status == 'Rejected') {
    	echo Html::submitButton('Approve', ['class'=> 'btn btn-info','name'=>'edit','value'=>'approve']) ;
    	} else{
    			echo Html::submitButton('Reject', ['class'=> 'btn btn-danger','name'=>'edit','value'=>'reject']) ;
    	}*/
    	//Html::submitButton($model->plan_approval_status == 'Approval Pending' || $model->plan_approval_status == 'Rejected'? 'approve' : 'reject' , ['class'=> $model->plan_approval_status == 'Approval Pending' || $model->plan_approval_status == 'Rejected'?'btn btn-info':'btn btn-danger','name'=>$model->plan_approval_status == 'Approval Pending' || $model->plan_approval_status == 'Rejected'? 'approve' : 'reject','value'=>'updated']) ;
    	//echo $model->plan_approval_status == 'Approval Pending' || $model->plan_approval_status == 'Rejected'  ?Html::a('approve',Url::to(['activitaion', 'id' => $model->id,'status'=>'pending']),['class'=>'btn btn-info']) : Html::a('reject',Url::to(['activitaion', 'id' =>$model->id,'status'=>'rejected']),['class'=>'btn btn-danger']);

 	} ?>
			<a href="<?php echo Url::to(['plancard/index']);?>" type="button"
				class="btn btn-danger">Cancel</a>
		</div>
	</div>


	<?php ActiveForm::end(); ?>

</div>
<!-- Modal Popup add new-->
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

						<div class="form row col-md-12 mt20">
							<div class="form-group col-md-6">
								<label class="control-label required">Add New:</label>
								<div class="form-group field-plancards-add_new_elements required">
									<input id="plancards-add_new_elements" class="form-control" type="text" name="PlanCards[add_new_elements]">
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
<!-- Modal Popup add new-->
</div>
<?php


$script = <<< JS
jQuery(document).ready(function($){
		if($('#plancards-activity').val() == 'Channel Card'){
			$('#channel').show();
			$('.camp').hide();
			$('#plancards-crop_id').find('option:eq(0)').prop('selected', true);
			$('#plancards-crop_id').find('option:eq(0)').val(0);
			$('#plancards-product_id').find('option:eq(0)').prop('selected', true);
			$('#plancards-product_id').find('option:eq(0)').val(0);
		
		} else {
			$('.camp').show();
			$('#channel').hide();
			$('#plancards-channel_partner').find('option:eq(0)').val('0');

		}
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
});
JS;
$this->registerJs($script);
?>