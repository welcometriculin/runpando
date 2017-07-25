<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use kartik\password\PasswordInput;

/* @var $this yii\web\View */
/* @var $model app\models\InputCompanies */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="input-companies-form">
	<?php 
	if(Yii::$app->session->hasFlash('company-created')){?>
	        <div class="alert alert-success">
            Company details has been created successfully
        	</div>
	<?php 
	}
	else if(Yii::$app->session->hasFlash('company-updated')){
	?>
		    <div class="alert alert-success">
            Company details updated successfully
        	</div>
	<?php }?>
     <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-19\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?> 

    <?/*= $form->field($model, 'guid')->textInput(['maxlength' => true]) */?>
    
    <?= $form->field($model, 'person_name')->textInput(['maxlength' => true, 'placeholder' => 'Type your name','readonly' => !$model->isNewRecord]) ?>
    
    <?= $form->field($model, 'designation')->textInput(['maxlength' => true, 'readonly' => !$model->isNewRecord]) ?>

    <?= $form->field($model, 'organization_name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'contact_email')->textInput(['maxlength' => true]) ?>
    
    <?/*= $form->field($model, 'password')->widget(PasswordInput::classname(), ['pluginOptions' => [
        'showMeter' => true,
        'toggleMask' => false
    ]]) */?> 

    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true, 'readonly' => !$model->isNewRecord]) ?>

    <?/*= $form->field($model, 'paid_amount')->textInput(['maxlength' => true]) */?>

    <?= $form->field($model, 'number_of_licences')->dropDownList([ '50' => '1-50', '200' => '51-200', ], ['prompt' => 'Select', 'disabled' => !$model->isNewRecord])  ?>

    <?= $form->field($model, 'checkbox')->checkboxList(['terms'=>'Terms'])->label('') ?>
    
    <?/*= $form->field($model, 'status')->dropDownList([ 'active' => 'Active', 'inactive' => 'Inactive', ], ['prompt' => '']) */?>

    <?/*= $form->field($model, 'created_date')->textInput()*/ ?>

    <?/*= $form->field($model, 'created_by')->textInput(['maxlength' => true]) */?>

    <?/*= $form->field($model, 'updated_date')->textInput() */?>

    <?/*= $form->field($model, 'updated_by')->textInput(['maxlength' => true])*/ ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'name' =>'save', 'value'=> 'update']) ?>
        <?= Html::submitButton($model->status =='inactive' ? 'Save & Activate' : 'De-Activate', ['class' => $model->status =='inactive' ? 'btn btn-primary' : 'btn btn-danger', 'name' =>'save', 'value'=> $model->status =='inactive' ? 'updateactivate':'updateinactivate']) ?>
    
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



});
JS;
$this->registerJs($script);
?>