<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Users;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\web\View;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $model app\models\PlanCardSearch */
/* @var $form yii\widgets\ActiveForm */
$com_id = Yii::$app->user->identity->input_company_id;
$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
//$listData=\app\models\PlanCards::Userslist();
//echo '<pre>';print_r($data);exit;
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

	<div class="">
		<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-4">
				<div class="row">
					<?php 
					$format = <<< SCRIPT
function format(state) {
console.log(state);
    if (!state.id) return state.text; // optgroup
		var st = state.text
		var array = st.split(" - ");
		console.log(array);
  //  return '<img class="flag" src="' + src + '"/>' + state.text;
			if(array[0] == 'All') {
				 return '<span>'+array[0] +'</span>';
			} else {
				return '<span>'+array[0] +'</span> - <span class = "drop">'+array[1]+'</span>';
			}
}
SCRIPT;
					$escape = new JsExpression("function(m) { return m; }");
					$this->registerJs($format, View::POS_HEAD);
					echo $form->field($model, 'assign_to',['template' => "{label}\n<div class='col-xs-12'>{input}</div>\n{hint}\n{error}"])->widget(Select2::classname(), [
				    'data' => $data,
					'size' => Select2::MEDIUM,
				    'options' => ['prompt' => 'All','class' => 'form-control'],
					'pluginOptions' => [
					'allowClear' => false,
					'tags' => false,
					'templateResult' => new JsExpression('format'),
					'templateSelection' => new JsExpression('format'),
					'escapeMarkup' => $escape,
					//'maximumSelectionLength'=> 1
					],
				])->label('Your Team',['class'=>'control-label pl15']); ?>


				</div>
		</div>
		<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-4">
			<div class="search-section">
				<div class="row">
					<?= $form->field($model, 'free_text_search',['template' => "{label}\n<div class='col-xs-12 '>{input}</div>\n{hint}\n{error}"])->textInput(['placeholder' => 'Enter Text'])->label('Keyword',['class'=>'col-xs-12 col-sm-5 col-md-3 col-lg-3 control-label pr15 pl15']) ?>
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

		<div
			class="form-group col-xs-12 col-md-12 col-lg-3 plan-cards search-fileds  text-center">

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
