<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-search">

    <?php $form = ActiveForm::begin([
        'action' => ['profile'],
        'method' => 'get',
    ]); ?>
    <div class="row">
	<div class="col-md-6 user-search-form">
	<div class="clearfix">
    <?= $form->field($model, 'free_text_search',['template' => "{label}\n<div class='col-xs-12 col-sm-8 col-md-8 col-lg-9 pr0 pl0 mb15'>{input}</div>\n{hint}\n{error}"])->textInput(['placeholder' => 'Enter Text'])->label('Keyword',['class'=>'col-xs-12 col-sm-3 col-md-4 col-lg-3 control-label']) ?>
    </div>
    </div>
    <?php // echo $form->field($model, 'id') ?>

    <?php // echo $form->field($model, 'guid') ?>

    <?php // echo $form->field($model, 'employee_number') ?>

    <?php // echo $form->field($model, 'first_name') ?>

    <?php // echo $form->field($model, 'last_name') ?>

    <?php // echo $form->field($model, 'designation') ?>

    <?php // echo $form->field($model, 'phone_number') ?>

    <?php // echo $form->field($model, 'email_address') ?>

    <?php // echo $form->field($model, 'password') ?>

    <?php // echo $form->field($model, 'roleid') ?>

    <?php // echo $form->field($model, 'input_company_id') ?>

    <?php // echo $form->field($model, 'reporting_user_id') ?>

    <?php // echo $form->field($model, 'photo') ?>

    <?php // echo $form->field($model, 'photo_path') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'district') ?>

    <?php // echo $form->field($model, 'head_quarters') ?>

    <?php // echo $form->field($model, 'area_of_operatoin') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'access_token') ?>

    <?php // echo $form->field($model, 'auth_key') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_date') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="col-md-6">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Reset', ['profile'], ['class' => 'btn btn-danger']) ?>
    </div>
</div>
    <?php ActiveForm::end(); ?>

</div>
