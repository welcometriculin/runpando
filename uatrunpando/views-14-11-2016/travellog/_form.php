<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TravelLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="travel-log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'guid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'assign_to')->textInput() ?>

    <?= $form->field($model, 'card_type')->dropDownList([ 'campaign card' => 'Campaign card', 'channel card' => 'Channel card', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'planned_date')->textInput() ?>

    <?= $form->field($model, 'plan_type')->dropDownList([ 'planned' => 'Planned', 'adhoc' => 'Adhoc', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'crop_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'channel_partner')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'village_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'activity')->dropDownList([ 'Farm and Home Visit' => 'Farm and Home Visit', 'Farmer Group Meeting' => 'Farmer Group Meeting', 'Mass Campaign' => 'Mass Campaign', 'Demonstration' => 'Demonstration', 'Channel Card' => 'Channel Card', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'distance_travelled')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'not_submitted' => 'Not submitted', 'submitted' => 'Submitted', 'rejected' => 'Rejected', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'plan_approval_status')->dropDownList([ 'Approval Pending' => 'Approval Pending', 'Approved' => 'Approved', 'Rejected' => 'Rejected', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'created_date')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_date')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'is_deleted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
