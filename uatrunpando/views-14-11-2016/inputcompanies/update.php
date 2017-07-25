<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\InputCompanies */

//$this->title = 'Update Input Companies: ' . ' ' . $model->id;
//$this->params['breadcrumbs'][] = ['label' => 'Input Companies', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->title = 'Edit Organization';
$this->params['breadcrumbs'][] = $this->title;
$loginsession = Yii::$app->session->get('loginid');
?>
<div class="input-companies-update">
		<?php $designation = \app\models\InputCompanies::getDesignation($model->id);?>
   <!--  <h1><?/*= Html::encode($this->title) */?></h1> -->

     <?php $form = ActiveForm::begin(); ?> 

			<div class="form row col-sm-12 mt20">
					 
				<div class="form-group col-sm-4">
    <?= $form->field($model, 'person_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Name']) ?>
				
				</div>
				<div class="form-group col-sm-4">
    <?= $form->field($model, 'designation')->textInput(['maxlength' => true, 'value' => $designation['designation'], 'placeholder' => 'Enter Designation']) ?>
				
				</div>
				<div class="form-group col-sm-4">
    <?= $form->field($model, 'organization_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Organization']) ?>
				
				</div>
				<div class="form-group col-sm-4">
    <?= $form->field($model, 'employee_number')->textInput(['maxlength' => true, 'value' => $designation['employee_number'],'placeholder' => 'Enter Employee ID']) ?>
				
				</div>
				</div>
				
					 <div class="hr"></div>
					 
					 <div class="form row col-sm-12 mt20">
					 
					 <div class="form-group col-sm-4">
    <?= $form->field($model, 'contact_email')->textInput(['maxlength' => true, 'readonly' => !$model->isNewRecord]) ?>
					 
				  
				</div>
					<div class="form-group col-sm-4">
	<?= $form->field($model, 'contact_person_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Contact Person Name']) ?>
				</div>
				<div class="form-group col-sm-4">
    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true, 'readonly' => !$model->isNewRecord]) ?>
				
				</div>
				
				
				
					 </div>
					 
					 <div class="hr"></div>
					 
					 <div class="form row col-sm-12 mt20">
					 <div class="form-group col-sm-4">
	<?= $form->field($model, 'license_information')->textInput(['maxlength' => true, 'placeholder' => 'Enter License Information']) ?>
				</div>
					 <div class="form-group col-sm-4">
    <?= $form->field($model, 'paid_amount')->textInput(['maxlength' => true, 'placeholder' => 'Enter Amount']) ?>
					 
				</div>
					<div class="form-group col-sm-4">
    <?= $form->field($model, 'number_of_licences')->dropDownList([ '50' => '1-50', '100' => '51-100', '200' => '101-200' ], ['prompt' => 'Select'])  ?>
					
				</div>
				
				 <div class="hr"></div>
					 
					 <div class="form row col-sm-12 mt20">
				<div class="form-group col-sm-10">
					<div class="checkbox">
    <?= $form->field($model, 'checkbox')->checkboxList(['termsandconditions'=>'Customer accepts Terms and Conditions'])->label('') ?>
					
  </div>
			</div>
			
			
			
				 </div>
				 
				 <div class="hr"></div>
				 
				 <div class="col-sm-12 text-center mbl_padd">
					<?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'save', 'value' => 'saved']) ?>
					<?= Html::submitButton(($model->status == 'inactive')? 'Save & Activate':'De-Activate', ['class' => 'btn btn-info', 'name' => 'save', 'value' => ($model->status == 'inactive')? 'saveactivate':'saveinactivate']) ?>
					<?= Html::a('Cancel', ['index'], ['class' => 'btn btn-danger']) ?>
					</div>
											 
					    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php 

$script = <<< JS

$(document).ready(function(){
	$('.kv-scorebar-border').hide();
	$('.kv-verdict').hide();
	$('#inputcompanies-password').keyup(function(){
			if($('#inputcompanies-password').val().length > 0){
				$('.kv-scorebar-border').hide();
				$('.kv-verdict').show();
			}
			else{
				$('.kv-verdict').hide();
			}
	});
	$('#navhead').hide();
	$('.footer').hide();
	$('.field-inputcompanies-checkbox').removeClass('required');
	$('#inputcompanies-checkbox').addClass('required');
	$('#inputcompanies-checkbox').find('label').addClass('control-label');	


});
JS;
$this->registerJs($script);
?>
						