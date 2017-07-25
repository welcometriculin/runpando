<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Villages */

$this->title = 'Edit '.(count($label_names_display) > 0 ? ucfirst($label_names_display['village_label']) :'Village');
$this->params['breadcrumbs'][] = ['label' => (count($label_names_display) > 0 ? ucfirst($label_names_display['village_label']) :'Villages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Edit '.(count($label_names_display) > 0 ? ucfirst($label_names_display['village_label']) :'Village');
?>
<div class="villages-update">
    <?php $form = ActiveForm::begin(); ?>
  <div class="clearfix">
	<?= $form->field($model, 'managefield',['template' => "{label}\n<div class='col-xs-12 col-sm-6 col-md-6 col-lg-4 '>{input}\n{hint}\n{error}</div>"])->dropDownList($mmlist,['prompt' => 'Select Manager','disabled'=>'disabled'])->label('Manager Name',['class'=>'col-xs-12 col-sm-5 col-md-3 col-lg-3 text-right control-label'])  ?></div>

      <div class="clearfix">
	<?= $form->field($model, 'user_id',['template' => "{label}\n<div class='col-xs-12 col-sm-6 col-md-6 col-lg-4'>{input}\n{hint}\n{error}</div>"])->dropDownList($fflist,['prompt' => 'Select Field Force Name','disabled'=>'disabled'])->label('Field Force Name',['class'=>'col-xs-12 col-sm-5 col-md-3 col-lg-3 text-right control-label'])  ?></div>
          <div class="clearfix">
    <?= $form->field($model, 'village_name',['template' => "{label}\n<div class='col-xs-12 col-sm-6 col-md-6 col-lg-4'>{input}\n{hint}\n{error}</div>"])->textInput(['maxlength' => true])->label((count($label_names_display) > 0 ? ucfirst($label_names_display['village_label']) :'Village'),['class'=>'text-right col-xs-12 col-sm-5 col-md-3 col-lg-3 control-label'])  ?>
      </div>
    <div class="col-xs-12 col-md-offset-3 col-md-6">
    <div class="form-group alg_center">
        <?= Html::submitButton($model->isNewRecord ? 'Add' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
        <a href="<?php echo Url::to(['villages/index']);?>" type="button"
				class="btn btn-danger">Cancel</a>
   
    </div>
	</div>
    <?php ActiveForm::end(); ?>
</div>
	<?php
$url = Url::home();
$list_url = $url.'/villages/repotmanager';
$script = <<< JS

			var ff_id = $('#villages-user_id').val();
			$.ajax({
			 	type: 'post',
			 	url:'$list_url',
				data:{ff_id:ff_id},
				success: function(response){
					 res = eval(response);
						console.log(res);
						$("#villages-managefield").html(res);	

				}
			});
JS;
$this->registerJs($script);
?>