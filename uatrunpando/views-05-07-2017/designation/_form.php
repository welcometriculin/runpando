<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Designations */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-5">
    <?= $form->field($model, 'designation_name',['template' => "<div class='col-xs-12 col-sm-3 col-md-4 pl0 pt5'>{label}</div>\n<div class='col-xs-12 col-sm-7 col-md-8 pr0 pl0 mb15'>{input}\n{hint}\n{error}</div>"])->textInput(['maxlength' => true, 'class' => 'dd dd form-control']); ?>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-5 hide">
	<?= $form->field($model, 'company_id')->hiddenInput(['value'=> Yii::$app->user->identity->input_company_id])->label(false); ?>
   </div>
    <div class=" col-xs-12 col-sm-12 col-md-4 col-lg-7 crp_edit">
        <?= Html::submitButton($model->isNewRecord ?Yii::t('app', 'Create') :Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-primary mt0 ' : 'btn btn-primary mt0']) ?>
  <a href="<?php echo Url::to(['index']);?>" type="button"
				class="btn btn-danger mt0">Cancel</a>
    </div>
</div>
    <?php ActiveForm::end(); ?>
