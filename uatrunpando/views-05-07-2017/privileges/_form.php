<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Privileges */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="privileges-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'controller')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'action')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
