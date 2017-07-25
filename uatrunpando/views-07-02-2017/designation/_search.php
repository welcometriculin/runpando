<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DesignationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="designations-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'designation_id') ?>

    <?= $form->field($model, 'designation_name') ?>

    <?= $form->field($model, 'company_id') ?>

    <?= $form->field($model, 'created_by') ?>

    <?= $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <?php // echo $form->field($model, 'updated_date') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
