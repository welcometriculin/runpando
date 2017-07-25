<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\InputCompaniesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="input-companies-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'guid') ?>

    <?= $form->field($model, 'organization_name') ?>

    <?= $form->field($model, 'person_name') ?>

    <?= $form->field($model, 'contact_email') ?>

    <?php // echo $form->field($model, 'phone_number') ?>

    <?php // echo $form->field($model, 'paid_amount') ?>

    <?php // echo $form->field($model, 'number_of_licenses') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_date') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
