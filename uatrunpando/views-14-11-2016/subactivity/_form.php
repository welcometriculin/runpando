<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SubActivity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sub-activity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'activity_id')->textInput() ?>

    <?= $form->field($model, 'sub_activity_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_id')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'created_date')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'updated_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
