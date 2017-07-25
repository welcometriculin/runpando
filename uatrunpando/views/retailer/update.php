<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\ChannelPartners */

$this->title = 'Edit '.(count($label_names_display) > 0 ? ucfirst($label_names_display['partner_label']) :'Partner');
$this->params['breadcrumbs'][] = ['label' => (count($label_names_display) > 0 ? ucfirst($label_names_display['partner_label']) :'Partners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Edit '.(count($label_names_display) > 0 ? ucfirst($label_names_display['partner_label']) :'Partner');
?>
<div class="channel-partners-update">

 <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']]); ?>
      
	<?= $form->field($model, 'managefield',['template' => "{label}\n<div class='col-xs-12 col-sm-5 col-md-4'>{input}\n{hint}\n{error}</div>"])->dropDownList($mmlist,['prompt' => 'Select Manager Name','disabled'=>'disabled'])->label('Manager Name',['class'=>'col-xs-12 col-sm-5 col-md-4 control-label'])  ?>

      
	<?= $form->field($model, 'user_id',['template' => "{label}\n<div class='col-xs-12 col-sm-5 col-md-4'>{input}\n{hint}\n{error}</div>"])->dropDownList($fflist,['prompt' => 'Select Field Force Name','disabled'=>'disabled'])->label('Field Force Name',['class'=>'col-xs-12 col-sm-5 col-md-4 control-label'])  ?>
          
    <?= $form->field($model, 'channel_partner_name',['template' => "{label}\n<div class='col-xs-12 col-sm-5 col-md-4 '>{input}\n{hint}\n{error}</div>"])->textInput(['maxlength' => true])->label((count($label_names_display) > 0 ? ucfirst($label_names_display['partner_label']) :'Partner Name'),['class'=>'col-xs-12 col-sm-5 col-md-4 control-label'])  ?>
      
       <div class="form-group alg_center">
    <div class="col-xs-12 col-md-offset-4 col-md-6">
   
        <?= Html::submitButton($model->isNewRecord ? 'Add' : 'Edit', ['class' => $model->isNewRecord ? 'btn btn-primary mar0' : 'btn btn-primary mar0']) ?>
        <a href="<?php echo Url::to(['retailer/index']);?>" type="button"
				class="btn btn-danger mar0">Cancel</a>
  
    </div>
	</div>
    <?php ActiveForm::end(); ?>

</div>
<?php
$url = Url::home();
$list_url = $url.'/villages/repotmanager';
$script = <<< JS

			var ff_id = $('#channelpartners-user_id').val();
			$.ajax({
			 	type: 'post',
			 	url:'$list_url',
				data:{ff_id:ff_id},
				success: function(response){
					 res = eval(response);
						console.log(res);
						$("#channelpartners-managefield").html(res);	

				}
			});
JS;
$this->registerJs($script);
?>