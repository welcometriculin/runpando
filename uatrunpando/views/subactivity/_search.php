<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VillagesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="row">
	<div class="col-md-6 user-search-form">
	
	
    <?= $form->field($model, 'free_text_search', ['template' => "{label}\n<div class='col-lg-12 pr0 pl0'>{input}</div>\n{hint}\n{error}"])->textInput(['placeholder' => 'Enter Keyword'])->label(false); ?>
    
    </div>
    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="col-sm-6">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Reset', ['index'], ['class' => 'btn btn-danger']) ?>
    </div>
</div>
    <?php ActiveForm::end(); ?>

</div>