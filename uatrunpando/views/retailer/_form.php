<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\ChannelPartners */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="">

     <?php $form = ActiveForm::begin(['options' => [
                'class' => 'form-horizontal'
             ]]); ?>
      <div class="clearfix">
	<?= $form->field($model, 'managefield',['template' => "{label}\n<div class='col-xs-12 col-sm-5 col-md-4'>{input}\n{hint}\n{error}</div>"])->dropDownList($mmlist,['prompt' => 'Select Manager Name'])->label('Manager Name',['class'=>'col-xs-12 col-sm-5 col-md-3 col-lg-3 control-label'])  ?></div>

      <div class="clearfix">
	<?= $form->field($model, 'user_id',['template' => "{label}\n<div class='col-xs-12 col-sm-5 col-md-4'>{input}\n{hint}\n{error}</div>"])->dropDownList(['prompt' => 'Select Field Force Name'])->label('Field Force Name',['class'=>'col-xs-12 col-sm-5 col-md-3 col-lg-3 control-label'])  ?></div>
          <div class="clearfix">
    <?= $form->field($model, 'channel_partner_name',['template' => "{label}\n<div class='col-xs-12 col-sm-5 col-md-4'>{input}\n{hint}\n{error}</div>"])->textInput(['maxlength' => true])->label((count($label_names_display) > 0 ? ucfirst($label_names_display['partner_label']) :'Partner Name'),['class'=>'col-xs-12 col-sm-5 col-md-3 col-lg-3 control-label'])  ?>
      </div>
    <div class="col-xs-12 col-md-offset-3 col-md-6">
    <div class="form-group alg_center">
        <?= Html::submitButton($model->isNewRecord ? 'Add' : 'Edit', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
        <a href="<?php echo Url::to(['retailer/index']);?>" type="button"
				class="btn btn-danger">Cancel</a>
  
    </div>
	</div>
    <?php ActiveForm::end(); ?>

</div>
	<?php
$url = Url::home();
$list_url = $url.'/villages/fflist';
$script = <<< JS

	$("#channelpartners-managefield").change(function(){
			var mm_id = $(this).val();
			$.ajax({
			 	type: 'post',
			 	url:'$list_url',
				data:{mm_id:mm_id},
				success: function(response){
					 res = eval(response);
					//console.log(res['0']);
					if (res != 0) {
						$("#channelpartners-user_id").html(res[0]);
						//$("#plancards-product_name").html(res[1]);
						//$("#plancards-crop_name").html(res[2]);	
					} else {
						$("#channelpartners-user_id").html('<option value="">Select Village</option>');
						//$("#plancards-product_name").html('<option value="">Select Product</option>');
						//$("#plancards-crop_name").html('<option value="">Select Crop</option>');
					}
				}
			});
		});
JS;
$this->registerJs($script);
?>