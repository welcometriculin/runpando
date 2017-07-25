<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Products */

$this->title = 'Add New';
$this->params['breadcrumbs'][] = ['label' => (count($label_names_display) > 0 ? ucfirst($label_names_display['product_label']) :'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-create">

    <?php $form = ActiveForm::begin(); ?>

    <?php //echo $form->field($model, 'guid')->textInput(['maxlength' => true]) ?>
    <div class="row">
	<div class="col-xs-12 col-sm-12 col-md-7 col-lg-5">
    <?= $form->field($model, 'product_name',['template' => "<div class='col-xs-12 col-sm-5 pr0 pl0 col-md-4'>{label}</div>\n<div class='col-xs-12 col-sm-7 col-md-8 pr0 pl0'>{input}\n{hint}\n{error}</div>"])->textInput(['maxlength' => true, 'class' => 'dd form-control']) ?>
	</div>
    <?php //echo $form->field($model, 'comp_id')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'created_by')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'created_date')->textInput() ?>

    <?php //echo $form->field($model, 'updated_by')->textInput() ?>

    <?php //echo $form->field($model, 'updated_date')->textInput() ?>

    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-7 crp_edit">
        <?= Html::submitButton($model->isNewRecord ? 'Add' : 'Edit', ['class' => $model->isNewRecord ? 'btn btn-primary mt0' : 'btn btn-primary m0']) ?>
        <a href="<?php echo Url::to(['index']);?>" type="button"
				class="btn btn-danger mt0">Cancel</a>
    </div>
</div>
    <?php ActiveForm::end(); ?>

</div>
