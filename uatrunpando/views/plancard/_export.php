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
$listData=\app\models\PlanCards::Userslist();

?>

<div class="plan-cards-search clearfix">
	<?php 
		$form = ActiveForm::begin([
					'action' => ['download'],
					'method' => 'POST',
				'id' => 'export_form'
			]);
    		?>
	<?php  ?>
	<div class="">
		<div class=" col-xs-12 col-sm-12 col-md-3 col-lg-3 your_team">
			<div class="full-width">
				<?php 
										$format = <<< SCRIPT
function format(state) {
    if (!state.id) return state.text; // optgroup
		var st = state.text
		var array = st.split("-");
  //  return '<img class="flag" src="' + src + '"/>' + state.text;
			if(array[0] == 'All') {
				 return '<span>'+array[0] +'</span>';
			} else {
				if(array[1] == 0) {
					var des = array[2];
				} else {
				var des = array[1];
				}
			return '<span>'+array[0] +'</span> - <span class = "drop">'+des+'</span>';
			}
}
SCRIPT;
					$escape = new JsExpression("function(m) { return m; }");
					$this->registerJs($format, View::POS_HEAD);
					echo $form->field($model, 'assign_to')->widget(Select2::classname(), [
				    'data' => $data,
					'size' => Select2::SMALL,
				    'options' => ['class' => ''],
					'pluginOptions' => [
					'allowClear' => false,
					'tags' => false,
					'templateResult' => new JsExpression('format'),
					'templateSelection' => new JsExpression('format'),
					'escapeMarkup' => $escape,
					//'maximumSelectionLength'=> 1
					],
				])->label('Your Team'); ?>

			</div>
		</div>
		 <!--<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
			<div class="form-sec search-section"> -->
				<?php // echo $form->field($model, 'location')->dropDownList($villageList, ['prompt' => 'Select Location']); ?>
			<!-- </div>
		</div>  -->
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
			<div class="form-sec search-section">
			<?php $model->from_date = date("Y-m-d", strtotime("-2 week")); ?>
			<?php $model->to_date = date("Y-m-d"); ?>
				<?= $form->field($model, 'from_date')->widget(yii\jui\DatePicker::className(),
					[
					'clientOptions' =>[
                      'dateFormat' => 'yyyy-m-d',
                        'maxDate' => 0,
                        'todayHighlight' => true
						],
					'options'=>[
				'class'=>'form-control',
				'placeholder' =>"DD/MM/YYYY",'autocomplete' => 'off', 'onpaste' => 'return false;', 'onkeypress' => 'return false;'
                         ],]) ?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
			<div class="form-sec search-section">
				<?= $form->field($model, 'to_date')->widget(yii\jui\DatePicker::className(),
					[
					'clientOptions' =>[
                      'dateFormat' => 'yyyy-m-d',
                         'maxDate' => 0,
                        'todayHighlight' => true,
						'onSelect' => new \yii\web\JsExpression('function(dateText2) {
							 var dateText1Val = $("#plancards-from_date").val();
							 unixtime1 = Date.parse(dateText1Val)/1000;
							 unixtime2 = Date.parse(dateText2)/1000;
						}'),
							],
					'options'=>[
				'class'=>'form-control',
				'placeholder' =>"DD/MM/YYYY",'autocomplete' => 'off', 'onpaste' => 'return false;', 'onkeypress' => 'return false;'
                         ],]) ?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 search-fileds">
			<?=  Html::Button('Submit', ['class' => 'btn btn-primary','id' => 'summary_button']) ?>
		</div>
	</div>
	<div class="form-group col-xs-12 plan-cards text-center">
		<center>
			
		</center>
	</div>

	<?php ActiveForm::end(); ?>
</div>
<div id = 'data_loader' style ="display:none"><center><img src = "<?= Yii::getAlias('@weburl'); ?>/img/loading-image.gif""></center></div>
<div role="tabpanel" class="tabs"  style = "display:none" id ="summary_tabs">
	<ul class="nav nav-tabs" role="tablist">
			<li role="presentation"!important class="active"><a href="#LeaveSummary"
			aria-controls="home" role="tab" data-toggle="tab">Plan Summary</a></li>
		<li role="presentation" ><a href="#LeaveRequestSummary"
			aria-controls="home" role="tab" data-toggle="tab">Activity Summary</a></li>
<div class="export_id"><a href="<?php echo Url::to(['plancard/export']); ?>" class="export pull-right"  ><i class="fa fa-download"></i> Export</a></div>
	</ul>
	<div class="responsive-export clearfix"><a href="<?php echo Url::to(['plancard/export']); ?>" class="export pull-right"  ><i class="fa fa-download"></i> Export</a></div>
	<div class="tab-content clearfix">
		<div role="tabpanel" class="tab-pane " id="LeaveRequestSummary">
			<div class="panel-group" id="accordion" role="tablist"
				aria-multiselectable="true">
				<div class="panel-body panel-bg">
					<div class="col-sm-12 mt20 listview">
						<div id = "summary1">
						
					 	</div>
					</div>
				</div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane active" id="LeaveSummary">
			<div class="panel-group" id="accordion" role="tablist"
				aria-multiselectable="true">
				<div class="panel-body panel-bg">
					<div class="col-sm-12 mt20 listview">
					<div id = "summary2">
						
					 	</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	<?php

	/* $url = Url::home();
	$summary_url = 'http://localhost/dairy/src/main/php/web/index.php/plancard/download';
		$this->registerJs(
		    " var summary_url = ".$summary_url.";",
		    View::POS_HEAD,
		    'yiiOptions'
		); */
		?>
<?php 
$summary_url = Yii::$app->request->baseUrl;
 $script = <<< Js
	homes_url = "$summary_url";
Js;
 $this->registerJs($script);

?>
	<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/js/summary.js',['depends' => [\yii\web\JqueryAsset::className()]]); ?>

