<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Roles;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Edit User';
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['profile']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
$kgadmin_role_id = Roles::KGADMIN;
$icadmin_role_id = Roles::ICADMIN;
$manager_role_id = Roles::MANAGER;
$ffofficer_role_id = Roles::FIELDFORCE;
?>
<div class="users-update">

		    <div class="alert alert-danger" style="display:none;" id="dependency">
            <!-- for dependency flash -->
        	</div>
  
    <?php $form = ActiveForm::begin(['options'=> ['enctype'=>'multipart/form-data']]); ?>

<div class="panel-body panel-bg">
	<div class="form row col-md-12 mt20">
			 
		<div class="form-group  col-xs-12 col-sm-6 col-md-4">
    	<?= $form->field($model, 'first_name')->textInput(['maxlength' => true,'placeholder'=>'Enter Name']) ?>
		</div>
		<div class="form-group  col-xs-12 col-sm-6 col-md-2">
    	<?= $form->field($model, 'employee_number')->textInput(['maxlength' => true,'placeholder'=>'Enter Employee ID'])->label('Employee ID') ?>
		</div>
		<div class="form-group  col-xs-12 col-sm-6 col-md-4">
    	<?= $form->field($model, 'email_address')->textInput(['maxlength' => true,'placeholder'=>'Enter Email Address']) ?>
		</div>
		<div class="form-group  col-xs-12 col-sm-6 col-md-2">
    	<?= $form->field($model, 'phone_number')->textInput(['maxlength' => true,'placeholder'=>'Enter Phone No.']) ?>
		</div>
		</div>
		
			 <div class="hr"></div>
			 
			 <div class="form row col-md-12 mt20">
			<div class="form-group  col-xs-12 col-sm-6 col-md-4">
		<?php 
		if (Yii::$app->user->identity->roleid == ($kgadmin_role_id || $icadmin_role_id || $manager_role_id || $ffofficer_role_id)) {
			$roles = Roles::find()->where(['!=', 'id', $kgadmin_role_id])->all();
		}
		?>
    	<?= $form->field($model, 'roleid')->dropDownList(ArrayHelper::map($roles, 'id', 'role_name'),['prompt' => 'Select Role']) ?>
		</div>
		<div class="form-group  col-xs-12 col-sm-6 col-md-4" id="r_user_role" style="display:none;">
		<?php 
		if (Yii::$app->user->identity->roleid == $kgadmin_role_id) {
			$roles2 = Roles::find()->where(['!=', 'id', $kgadmin_role_id])->all();
		} else if(Yii::$app->user->identity->roleid == $icadmin_role_id) {
			$roles2 = Roles::find()->where(['!=', 'id', $kgadmin_role_id])->all();
		} else if(Yii::$app->user->identity->roleid == $manager_role_id) {
			$roles2 = Roles::find()->where(['!=', 'id', $kgadmin_role_id])->andWhere(['!=', 'id', $icadmin_role_id])->all();
		}
		?>
    	<?= $form->field($model, 'reporting_user_role')->dropDownList(ArrayHelper::map($roles2, 'id', 'role_name'),['prompt' => 'Select reporting manager role']) ?>
		</div>
		<div class="form-group  col-xs-12 col-sm-6 col-md-4" id="r_user_id" style="display:none;">
    	<?= $form->field($model, 'reporting_user_id')->dropDownList(['' => 'Select Reporting manager name']) ?>
		</div>
		
			 </div>
			 
			 <div class="hr"></div>
			 
			 <div class="form row col-md-12 mt20">
			 <div class="form-group  col-xs-12 col-sm-6 col-md-4">
		    <?= $form->field($model, 'state')->textInput(['maxlength' => true,'placeholder'=>'Enter State']) ?>
		</div>
		<div class="form-group  col-xs-12 col-sm-6 col-md-4">
    		<?= $form->field($model, 'district')->textInput(['maxlength' => true,'placeholder'=>'Enter District']) ?>	
		</div>
		<div class="form-group  col-xs-12 col-sm-6 col-md-4">
    		<?= $form->field($model, 'head_quarters')->textInput(['maxlength' => true,'placeholder'=>'Enter Headquarters']) ?>
		</div>
		<div class="form-group  col-xs-12 col-sm-6 col-md-4">
    		<?= $form->field($model, 'area_of_operatoin')->textInput(['maxlength' => true,'placeholder'=>'Enter Area of Operation']) ?>
		</div>
		<div class="form-group  col-xs-12 col-sm-6 col-md-4">
		    <?= $form->field($model, 'photo')->fileInput(['maxlength' => true]) ?>
			
		</div>
			 </div>
			 
			 <div class="hr"></div>
			  <div class="col-md-12 text-center">
					<?= Html::submitButton('Save', ['class' => 'btn btn-primary save', 'name' => 'save', 'value' => 'saved']) ?>
					<?= Html::submitButton(($model->status == 'inactive')? 'Save & Activate':'De-Activate', ['class' => 'btn btn-info save', 'name' => 'save', 'value' => ($model->status == 'inactive')? 'saveactivate':'saveinactivate']) ?>
					<?= Html::a('Cancel', ['profile'], ['class' => 'btn btn-danger']) ?>
			</div>

			 
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$url = Url::home();
$url = $url.'/users/reportinglistsupdate/';
$url2 = Url::home().'/users/reportinguserroles/';
$dependency_url = Url::home().'/users/dependencyusers/';
$script = <<< JS
$(document).ready(function(){
var changeid = 0; 
var employee_role = $('#users-roleid').val();
//onload employee role or email exist
	if ($('#users-roleid').val() == $icadmin_role_id) {
		$('#r_user_role, #r_user_id').css('display','none');
		$.get('$url2'+employee_role, function(data){	
		    res = eval(data);
		    $("#users-reporting_user_role").html(res[0]);
			$("#users-reporting_user_id").html(res[1]);
		});
	} else {
		$('#r_user_role, #r_user_id').css('display','block');
		$.get('$url'+changeid+'/$model->id/'+employee_role, function(data){
        res = eval(data);
 		//console.log(data);		
 		$("#users-reporting_user_role").html(res[0]);
		$("#users-reporting_user_id").html(res[1]);
		
	});
	}
//onload employee role or email exist end

//onchange employee role
	$('#users-roleid').change(function(){
		if ($('#users-roleid').val() =='') {
			$("#r_user_role, #r_user_id").css('display', 'none');
			$("#users-reporting_user_role").html('<option value="">Select Reporting Manager Role</option>');
			$("#users-reporting_user_id").html('<option value="">Select Reporting Manager Name</option>');
		} else if ($('#users-roleid').val() == $icadmin_role_id) {
			$('#r_user_role, #r_user_id').css('display','none');
			$.get('$url2'+$('#users-roleid').val(), function(data){	
			    res = eval(data);
			    $("#users-reporting_user_role").html(res[0]);
				$("#users-reporting_user_id").html(res[1]);
			});
		} else if($('#users-roleid').val() != $icadmin_role_id) {
			$('#r_user_role, #r_user_id').css('display','block');
			$.get('$url2'+$('#users-roleid').val(), function(data){
	    		res = eval(data);
				//$("#permissions-action-name").show();
		 		$("#users-reporting_user_role").html(res[0]);
				$("#users-reporting_user_id").html(res[1]);
			});
		}
	});
//onchange employee role end

//onchange reporting manager role after changing employee role
	$('#users-reporting_user_role').change(function(){
	var changeid = $(this).val();
	if (changeid =='') {
		$("#users-reporting_user_id").html('<option value="">Select Reporting Manager Name</option>');
	} else {
		$.post('$url'+changeid+'/$model->id/'+$('#users-roleid').val(), function(data){
    		res = eval(data);
			//$("#permissions-action-name").show();
 		$("#users-reporting_user_role").html(res[0]);
		$("#users-reporting_user_id").html(res[1]);
		});
	}
	});	
//onchange reporting manager role after changing employee role end
//for dependency users start
	dependency_result = false;
	$('.save').click(function(){
		var emp_role = $('#users-roleid').val();
		var role_id = $model->roleid;
		var manager_id = $model->id;
		var reporting_user_id = $('#users-reporting_user_id').val();
		var flash = "Due to dependency you can't assign other role or de-activate this user";
		if (manager_id == '') {
			dependency_result = false;
		} else {
			$.ajax({
				url: '$dependency_url',
				data:{manager_id : manager_id, reporting_user_id : reporting_user_id, role_id : role_id, emp_role : emp_role},
				type:'post',
				async:false, 
				success: function(data){
						if (data == 'users exist') {
			 				$('#dependency').html(flash).fadeIn().delay(3000).fadeOut();;
							dependency_result = false;
						} else {
							dependency_result = true;
						}
			}});
		return dependency_result;	
		}
	});
//for dependency users end
});
JS;
$this->registerJs($script);
?>
					   