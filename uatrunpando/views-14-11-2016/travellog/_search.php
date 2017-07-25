<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Users;
/* @var $this yii\web\View */
/* @var $model app\models\TravelLogSearch */
/* @var $form yii\widgets\ActiveForm */
$listData=\app\models\PlanCards::Userslist();
?>

<div class="travel-log-search clearfix">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php // echo $form->field($model, 'id') ?>

    <?php // echo $form->field($model, 'guid') ?>
    <div class="">
<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-5">
		<div class="form-sec travel-log_frm">
		<div class="row">
    <?= $form->field($model, 'assign_to',['template' => "{label}\n<div class='col-xs-12 col-sm-6 col-md-6 col-lg-8  mb15'>{input}</div>\n{hint}\n{error}"])->dropDownList($listData,['prompt' => 'All'])->label('Your Team',['class'=>'col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pl15 pr15']) ?>
</div>
</div>
	</div>
	<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-4">
		<div class="form-sec search-section">
		<div class="row">
	<?= $form->field($model, 'free_text_search',['template' => "{label}\n<div class='col-xs-12 col-sm-6 col-md-6 col-lg-9 mb15'>{input}</div>\n{hint}\n{error}"])->textInput(['placeholder' => 'Enter Text'])->label('Keyword',['class'=>'col-xs-12 col-sm-5 col-md-3 col-lg-3 control-label pr15 pl15']) ?>
	</div>
	</div>
	</div>
    <?php // echo $form->field($model, 'card_type') ?>

    <?php // echo $form->field($model, 'planned_date') ?>

    <?php // echo $form->field($model, 'plan_type') ?>

    <?php // echo $form->field($model, 'crop_name') ?>

    <?php // echo $form->field($model, 'product_name') ?>

    <?php // echo $form->field($model, 'channel_partner') ?>

    <?php // echo $form->field($model, 'village_name') ?>

    <?php // echo $form->field($model, 'activity') ?>

    <?php // echo $form->field($model, 'distance_travelled') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'plan_approval_status') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_date') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'is_deleted') ?>

    <div class="form-group col-xs-12 col-md-12 col-lg-3 travellog-search-btn text-center">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'search_button']) ?>
        <?= Html::a('Reset', ['index'], ['class' => 'btn btn-danger']) ?>
    </div> 
    
    <?php ActiveForm::end(); ?>
</div>
</div>
<?php 
$script = <<< JS
jQuery(document).ready(function($){
// 	$('#travellogsearch-assign_to').change(function(){
// 		$('#search_button').click();
// 	});
});
JS;
$this->registerJs($script);
?>