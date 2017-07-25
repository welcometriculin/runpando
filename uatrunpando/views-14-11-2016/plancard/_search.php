<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Users;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\PlanCardSearch */
/* @var $form yii\widgets\ActiveForm */
$com_id = Yii::$app->user->identity->input_company_id;
$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
$listData=\app\models\PlanCards::Userslist();
?>

<div class="plan-cards-search clearfix">
	<?php if (($action == 'history') && $controller == 'plancard') {
		$form = ActiveForm::begin([
					'action' => ['history'],
					'method' => 'get',
			]);
	} else {
    		$form = ActiveForm::begin([
    				'action' => ['index'],
    				'method' => 'get',
    		]);
    	}?>
	<?php  ?>
	<div class="">
	<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-5">
		<div class="form-sec">
		<div class="row">
			<?= $form->field($model, 'assign_to',['template' => "{label}\n<div class='col-xs-12 col-sm-6 col-md-6 col-lg-8  mb15'>{input}</div>\n{hint}\n{error}"])->dropDownList($listData, ['prompt' => 'All'])->label('Your Team',['class'=>'col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pl15 pr15']) ?>
		</div>
		</div>
	</div>
	<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-4">
		<div class="form-sec search-sectio">
		<div class="row">
			<?= $form->field($model, 'free_text_search',['template' => "{label}\n<div class='col-xs-12 col-sm-6 col-md-8 col-lg-9  mb15'>{input}</div>\n{hint}\n{error}"])->textInput(['placeholder' => 'Enter Text'])->label('Keyword',['class'=>'col-xs-12 col-sm-5 col-md-3 col-lg-3 control-label pr15 pl15']) ?>
		</div>
		</div>
	</div>
	<?php //echo $form->field($model, 'guid') ?>

	<?php //echo $form->field($model, 'assign_to') ?>

	<?php //echo $form->field($model, 'card_type') ?>

	<?php //echo$form->field($model, 'planned_date') ?>

	<?php // echo $form->field($model, 'plan_type') ?>

	<?php // echo $form->field($model, 'crop_name') ?>

	<?php // echo $form->field($model, 'channel_partner') ?>

	<?php // echo $form->field($model, 'village_name') ?>

	<?php // echo $form->field($model, 'activity') ?>

	<?php // echo $form->field($model, 'distance_travelled') ?>

	<?php // echo $form->field($model, 'status') ?>

	<?php // echo $form->field($model, 'created_date') ?>

	<?php // echo $form->field($model, 'created_by') ?>

	<?php // echo $form->field($model, 'updated_date') ?>

	<?php // echo $form->field($model, 'updated_by') ?>

	<div class="form-group col-xs-12 col-md-12 col-lg-3 plan-cards text-center">

		<?=  Html::submitButton('Search', ['class' => 'btn btn-primary','id' => 'search_button']) ?>
		<?php if (($controller == 'plancard' && $action == 'history')) {?>
		<?= Html::a('Reset', ['history'], ['class' => 'btn btn-danger']) ?>
		<?php } else { ?>
		<?= Html::a('Reset', ['index'], ['class' => 'btn btn-danger']) ?>
		<?php } ?>
	</div>

	<?php ActiveForm::end(); ?>
</div>
</div>

<?php
$view_more_url = Url::to();
$view_more_url = explode('/',$view_more_url);
$view_more_user_id = end($view_more_url);

$script = <<< JS
jQuery(document).ready(function($){
//for view more option
	if(!isNaN("$view_more_user_id")) {
		if ($('#plancardsearch-assign_to').find('option[value="$view_more_user_id"]').length == 0) {
			$('#plancardsearch-assign_to option[value=""]').attr('selected','selected');
			$('#search_button').click();
		} else {
			$('#plancardsearch-assign_to option[value="$view_more_user_id"]').attr('selected','selected');
			$('#search_button').click();
		}
	}
//for view more option end
// 	$('#plancardsearch-assign_to').change(function(){
// 		$('#search_button').click();
// 	});
});
JS;
$this->registerJs($script);
?>
