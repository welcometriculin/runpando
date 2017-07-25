<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Crops */

$this->title = 'Add New';
$this->params['breadcrumbs'][] = ['label' => (count($label_names_display) > 0 ? ucfirst($label_names_display['crop_label']) :'Crops'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crops-create">

<?php $form = ActiveForm::begin(); ?>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-5">
    <?= $form->field($model, 'crop_name',['template' => "<div class='col-xs-12 col-sm-3 col-md-4 pl0 pt5'>{label}</div>\n<div class='col-xs-12 col-sm-7 col-md-8 pr0 pl0 mb15'>{input}</div>\n{hint}\n{error}"])->textInput(['maxlength' => true, 'class' => 'dd dd form-control'])->label((count($label_names_display) > 0 ? ucfirst($label_names_display['crop_label']) :'Crops').' Name'); ?>
	</div>
    <?php //echo $form->field($model, 'comp_id')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'created_by')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'created_date')->textInput() ?>

    <?php //echo $form->field($model, 'updated_by')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'updated_date')->textInput() ?>

    <div class=" col-xs-12 col-sm-12 col-md-4 col-lg-7 crp_edit">
        <?= Html::submitButton($model->isNewRecord ? 'Add' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary mt0 ' : 'btn btn-primary ']) ?>
  <a href="<?php echo Url::to(['index']);?>" type="button"
				class="btn btn-danger mt0">Cancel</a>
    </div>
</div>
    <?php ActiveForm::end(); ?>

</div>
