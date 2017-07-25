<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\PlanCards */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plan-cards-form">

    <?php $form = ActiveForm::begin(); ?>
 	 <div class="col-sm-6">
    <?= $form->field($model, 'planned_date')->widget(yii\jui\DatePicker::className(),
                    [
                        'clientOptions' =>[
                      'dateFormat' => 'yyyy-MM-dd',
                        'minDate' => 0,
                        //'maxDate' => 5,
                        'todayHighlight' => true,
						//'yearRange'=>'2016:'.(date('Y')+1),
							],
                    	 'options'=>[
				'class'=>'form-control',
				'placeholder' => $model->getAttributeLabel('planned_date'),
                         ],]) ?>
    </div>
 	<?php 
 	
//use app\models\Country;
 	$listData=\app\models\PlanCards::Userslist();
?>
<div class="col-sm-6">
    <?= $form->field($model, 'assign_to')->dropDownList($listData, ['prompt' => 'Select Employee']) ?></div>
	 <div class="col-sm-6">
    <?= $form->field($model, 'crop_name')->textInput(['maxlength' => true]) ?></div>
	 <div class="col-sm-6">
    <?= $form->field($model, 'channel_partner')->textInput(['maxlength' => true]) ?></div>
	 <div class="col-sm-6">
    <?= $form->field($model, 'village_name')->textInput(['maxlength' => true]) ?></div>
 <div class="col-sm-6">
    <?= $form->field($model, 'activity')->dropDownList([ 'Farmer Meeting' => 'Farmer Meeting', 'Field Visit' => 'Field Visit', 'Farmer Group Meeting' => 'Farmer Group Meeting', 'Mass Campaign' => 'Mass Campaign', 'Demonstration' => 'Demonstration', 'Channel Card' => 'Channel Card', ], ['prompt' => 'Select Activity']) ?></div>
	<div class="col-xs-12">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create And Approve' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div></div>

    <?php ActiveForm::end(); ?>

</div>
