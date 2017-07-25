<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Products */

$this->title = 'Edit '.(count($label_names_display) > 0 ? ucfirst($label_names_display['product_label']) :'Product');
$this->params['breadcrumbs'][] = ['label' => (count($label_names_display) > 0 ? ucfirst($label_names_display['product_label']) :'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Edit '.(count($label_names_display) > 0 ? ucfirst($label_names_display['product_label']) :'Product');
?>
<div class="products-update">

    <?php $form = ActiveForm::begin(); ?>
<div class="row">
    <?php //echo $form->field($model, 'guid')->textInput(['maxlength' => true]) ?>
    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-5">
    
    <?= $form->field($model, 'product_name',['template' => "<div class='col-xs-12 col-sm-5 col-md-4 pl0 pt5'>{label}</div>\n<div class='col-xs-12 col-sm-7 col-md-8 pr0 pl0 mb15'>{input}</div>\n{hint}\n{error}"])->textInput(['maxlength' => true, 'class' => 'dd dd form-control']); ?>
	</div>
	
	<!-- <div class="col-sm-4">
    <?= $form->field($model, 'product_name')->textInput(['maxlength' => true, 'class' => 'dd']) ?>
	</div> -->
    <?php //echo $form->field($model, 'comp_id')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'created_by')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'created_date')->textInput() ?>

    <?php //echo $form->field($model, 'updated_by')->textInput() ?>

    <?php //echo $form->field($model, 'updated_date')->textInput() ?>

    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-7 crp_edit">
        <?= Html::submitButton($model->isNewRecord ? 'Add' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary m0' : 'btn btn-primary mt0']) ?>
        <a href="<?php echo Url::to(['index']);?>" type="button"
				class="btn btn-danger mt0">Cancel</a>
    </div>
</div>
    <?php ActiveForm::end(); ?>

</div>
