<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FormBuilderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-builder-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'form_builder_id') ?>

    <?= $form->field($model, 'form_builder_activity_id') ?>

    <?= $form->field($model, 'step') ?>

    <?= $form->field($model, 'required') ?>

    <?= $form->field($model, 'mandatory') ?>

    <?php // echo $form->field($model, 'label') ?>

    <?php // echo $form->field($model, 'data_type') ?>

    <?php // echo $form->field($model, 'validation_type') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <?php // echo $form->field($model, 'updated_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
