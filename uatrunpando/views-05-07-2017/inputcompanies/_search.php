<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\InputCompaniesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="input-companies-search users-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="row">
	<div class="col-md-6 user-search-form">
	<div class="clearfix">
    <?= $form->field($model, 'free_text_search',['template' => "{label}\n<div class='col-xs-12 col-sm-8 col-md-8 col-lg-9 pr0 pl0 mb15'>{input}</div>\n{hint}\n{error}"])->textInput(['placeholder' => 'Enter Text'])->label('Keyword',['class'=>'col-xs-12 col-sm-3 col-md-4 col-lg-3 control-label']) ?>
    </div>
    </div>
    <?php //$form->field($model, 'id') ?>

    <?php // $form->field($model, 'guid') ?>

    <?php // $form->field($model, 'organization_name') ?>

    <?php // $form->field($model, 'person_name') ?>

    <?php //$form->field($model, 'contact_email') ?>

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
        <?= Html::a('Reset', ['index'], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
