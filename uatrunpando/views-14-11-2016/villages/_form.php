<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Villages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="villages-form">

<?php $form = ActiveForm::begin(); ?>
  <div class="form-group clearfix">
	<?= $form->field($model, 'managefield',['template' => "{label}\n<div class='col-xs-12 col-sm-6 col-md-6 col-lg-4 pr0 pl0 '>{input}</div>\n{hint}\n{error}"])->dropDownList($mmlist,['prompt' => 'Select Manager'])->label('Manager Name',['class'=>'col-xs-12 col-sm-5 col-md-2 col-lg-2 control-label'])  ?></div>

      <div class="form-group clearfix">
	<?= $form->field($model, 'user_id',['template' => "{label}\n<div class='col-xs-12 col-sm-6 col-md-6 col-lg-4 pr0 pl0 '>{input}</div>\n{hint}\n{error}"])->dropDownList(['prompt' => 'Select Field Force Name'])->label('Field Force Name',['class'=>'col-xs-12 col-sm-5 col-md-2 col-lg-2 control-label'])  ?></div>
          <div class="form-group clearfix">
    <?= $form->field($model, 'village_name',['template' => "{label}\n<div class='col-xs-12 col-sm-6 col-md-6 col-lg-4 pr0 pl0 '>{input}</div>\n{hint}\n{error}"])->textInput(['maxlength' => true])->label((count($label_names_display) > 0 ? ucfirst($label_names_display['village_label']) :'Village').' Name',['class'=>'col-xs-12 col-sm-5 col-md-2 col-lg-2 control-label'])  ?>
      </div>
    <div class="col-xs-12 col-md-offset-2 col-md-6">
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
$list_url = $url.'/villages/fflist';
$script = <<< JS

	$("#villages-managefield").change(function(){
			var mm_id = $(this).val();
			fflist(mm_id);
		});
		mm_id = $("#villages-managefield").val();
		fflist(mm_id);
		function fflist(mm_id) {
		$.ajax({
			 	type: 'post',
			 	url:'$list_url',
				data:{mm_id:mm_id},
				success: function(response){
					 res = eval(response);
					//console.log(res['0']);
					if (res != 0) {
						$("#villages-user_id").html(res[0]);
						//$("#plancards-product_name").html(res[1]);
						//$("#plancards-crop_name").html(res[2]);	
					}
				}
			});
}
JS;
$this->registerJs($script);
?>