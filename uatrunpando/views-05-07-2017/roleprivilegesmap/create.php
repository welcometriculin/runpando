<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Roles;
use app\models\Privileges;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\RolePrivilegesMap */

$this->title = 'Create Role Privileges Map';
$this->params['breadcrumbs'][] = ['label' => 'Role Privileges Maps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-privileges-map-create">

    <h1><?= Html::encode($this->title) ?></h1>
    
     <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'role_id')->dropdownList(ArrayHelper::map(Roles::find()->all(), 'id','role_name'), ['prompt' => 'Selct Role'])  ?>
    
    <?= $form->field($model, 'controller_id')->dropdownList(ArrayHelper::map(Privileges::find()->all(), 'controller','controller'), ['prompt' => 'Selct Controller'])  ?>
    
   <div id="permissions-action-name">
   </div>
    
    <div class="form-group">
     <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',  'id'=> 'button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$url = Url::home();
$url = $url.'/roleprivilegesmap/permissionactions';
$model->role_id = 0;
$script = <<< JS
$(document).ready(function(){

$('#roleprivilegesmap-role_id, #roleprivilegesmap-controller_id').bind('change',function(){
	var roleid = $('#roleprivilegesmap-role_id').val();
	var controllername = $('#roleprivilegesmap-controller_id').val();

	if(roleid !='' && controllername != '')
	{
		$.get('$url',{roleid:roleid, controllername:controllername}, function(data){
			$("#permissions-action-name").show();
			$("#permissions-action-name").html(data);
		});
	}
	else{
		$("#permissions-action-name").find('input:checkbox').removeAttr('checked');
		$("#permissions-action-name").hide();
		}
	});
		
	$('#button').click(function(){
		var roleid1 = $('#roleprivilegesmap-role_id').val();
		var controllername1 = $('#roleprivilegesmap-controller_id').val();
		if(roleid1 != '' && controllername1 != ''){
			if($("#permissions-action-name").find('input:checkbox').length == 0){
				alert('No data available');
				return false;
			}
			//else if($('input[name="actionnames[]"]:checked').length == 0){
				//alert('check atleast one');
				//return false;
			//}
		}
	});
		
});
JS;
$this->registerJs($script);
?>