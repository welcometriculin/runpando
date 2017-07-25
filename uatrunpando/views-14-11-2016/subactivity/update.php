<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\SubActivity */

$this->title = 'Edit Sub Activity';
$this->params['breadcrumbs'][] = ['label' => 'Sub Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Edit Sub Activity';
?>
<div class="sub-activity-update">

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

    <div class="col-xs-12 col-md-12 col-lg-4 crp_edit">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success ' : 'btn btn-primary edit_sub_btn pull-left']) ?>
         <a href="<?php echo Url::to(['index']);?>" type="button"
				class="btn btn-danger  ">Cancel</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
