<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Crops */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="crops-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'crop_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comp_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_date')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
