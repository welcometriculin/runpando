<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\SubActivity */

$this->title = 'Add New';
$this->params['breadcrumbs'][] = ['label' => 'Sub Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sub-activity-create">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-xs-12 col-md-6 col-lg-4">
    <?= $form->field($model, 'activity_id')->dropDownList(ArrayHelper::map($activities, 'activity_id', 'activity_name'), ['prompt' => 'Select']) ?>
    </div>
	<div class="col-xs-12 col-md-6 col-lg-4">
    <?= $form->field($model, 'sub_activity_name')->textInput(['maxlength' => true]) ?>
    </div>
    
    <?php //echo $form->field($model, 'company_id')->textInput() ?>

    <?php //echo $form->field($model, 'created_by')->textInput() ?>

    <?php //echo $form->field($model, 'created_date')->textInput() ?>

    <?php //echo $form->field($model, 'updated_by')->textInput() ?>

    <?php //echo $form->field($model, 'updated_date')->textInput() ?>

    <div class="col-xs-12 col-md-12 col-lg-4">
        <?= Html::submitButton($model->isNewRecord ? 'Add' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary pull-left' : 'btn btn-primary ']) ?>
         <a href="<?php echo Url::to(['index']);?>" type="button"
				class="btn btn-danger  ">Cancel</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
