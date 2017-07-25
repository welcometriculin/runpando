<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\Privileges */

$this->title = 'Create Privileges';
$this->params['breadcrumbs'][] = ['label' => 'Privileges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="privileges-create">

    <h1><?= Html::encode($this->title) ?></h1>
<div class="privileges-form">
	<?php if(Yii::$app->session->hasFlash('permission-success')):?>
    <div class="info" style="color:green">
        <?php echo Yii::$app->session->getFlash('permission-success'); ?>
    </div>
	<?php endif; ?>
	
    <?php $form = ActiveForm::begin(); ?>
    <?php ?><?php 
    $controllername = array();
    foreach(Yii::$app->metadata->getControllers() as $c){
	$cid = str_replace('Controller', '', $c);
	$cid = strtolower($cid);
	$controllername[$cid] = $c;
	}
    ?>
    <?= $form->field($model, 'controller')->dropdownList($controllername, ['prompt' => 'Selct Controller'])  ?>
        
    <?/*= $form->field($model, 'controller')->dropdownList($controllername, ['prompt' => 'Selct Controller'])*/  ?>

   <div id="privileges-action-name">
   </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',  'id'=> 'button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>
<?php
$url = Url::home();
$url = $url.'/privileges/privilegeactions/';
$model->id = 0;
$script = <<< JS
$(document).ready(function(){

$('#privileges-controller').change(function(){
	var controller = $(this).val();
	if(controller =='')
	{
		$("#privileges-action-name").find('input:checkbox').removeAttr('checked');
		$("#privileges-action-name").hide();
	} else {
		$.ajax({
			 	type: 'post',
			 	url:'$url',
				data:{controller:controller, id:$model->id},
				success: function(response){
					$("#privileges-action-name").show();
					$("#privileges-action-name").html(response);
				}
		});
	}
	});
		
	$('#button').click(function(){
	if($("#privileges-action-name").find('input:checkbox').length == 0){
		alert('No data available');
		return false;
	}
	else if($('input[name="actionnames[]"]:checked').length == 0){
		alert('check atleast one');
		return false;
	}
	});
		
});
JS;
$this->registerJs($script);
?>

</div>
