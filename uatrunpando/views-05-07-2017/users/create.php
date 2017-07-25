<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Roles;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Add New User';
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['profile']];
$this->params['breadcrumbs'][] = $this->title;
$kgadmin_role_id = Roles::KGADMIN;
$icadmin_role_id = Roles::ICADMIN;
$manager_role_id = Roles::MANAGER;
$ffofficer_role_id = Roles::FIELDFORCE;
?>
<div class="users-create">

  
	
    <?php $form = ActiveForm::begin(['options'=> ['enctype'=>'multipart/form-data']]); ?>

<div class="panel-body panel-bg user_form">
									<div class="form row mt20">
											 
		<div class=" col-xs-12 col-md-6 col-lg-4">
    		<?= $form->field($model, 'first_name')->textInput(['maxlength' => true,'placeholder'=>'Enter Name']) ?>
		</div>
		<div class="col-xs-12 col-md-6 col-lg-2">
    		<?= $form->field($model, 'employee_number')->textInput(['maxlength' => true,'placeholder'=>'Enter Employee ID'])->label('Employee ID') ?>
		</div>
		<div class="col-xs-12 col-md-6 col-lg-4">
		  	<?= $form->field($model, 'email_address')->textInput(['maxlength' => true,'placeholder'=>'Enter Email Address']) ?>
		</div>
		<div class="col-xs-12 col-md-6 col-lg-2">
		  	<?= $form->field($model, 'phone_number')->textInput(['maxlength' => true,'placeholder'=>'Enter Phone No.']) ?>
		</div>
		</div>
		
			 <div class="hr"></div>
			 
			 <div class="form row mt20">
			 		<div class=" col-xs-12 col-md-6 col-lg-4">
		    <?= $form->field($model, 'designation_id')->dropDownList($designations,['prompt' => 'Select Designation']) ?>
			</div>
			<div class=" col-xs-12 col-md-6 col-lg-4">
		<?php 
		if (Yii::$app->user->identity->roleid == ($kgadmin_role_id || $icadmin_role_id || $manager_role_id || $ffofficer_role_id)) {
			$roles = Roles::find()->where(['!=', 'id', $kgadmin_role_id])->all();
		}
		?>
		     <?= $form->field($model, 'roleid')->dropDownList(ArrayHelper::map($roles, 'id', 'role_name'),['prompt' => 'Select Role']) ?>
			</div>
		<div class=" col-xs-12 col-md-6 col-lg-4" id="r_user_role" style="display:none;">
		<?php 
		if (Yii::$app->user->identity->roleid == $kgadmin_role_id) {
			$roles2 = Roles::find()->where(['!=', 'id', $kgadmin_role_id])->all();
		} else if(Yii::$app->user->identity->roleid == $icadmin_role_id) {
			$roles2 = Roles::find()->where(['!=', 'id', $kgadmin_role_id])->all();
		} else if(Yii::$app->user->identity->roleid == $manager_role_id) {
			$roles2 = Roles::find()->where(['!=', 'id', $kgadmin_role_id])->andWhere(['!=', 'id', $icadmin_role_id])->all();
		}
		?>
   			<?= $form->field($model, 'reporting_user_role')->dropDownList(ArrayHelper::map($roles2, 'id', 'role_name'),['prompt' => 'Select Reporting Manager Role']) ?>
			
		</div>
		</div>
		<div class="row">
		<div class="form-group  col-xs-12 col-md-6 col-lg-4" id="r_user_id" style="display:none;">
		    <?= $form->field($model, 'reporting_user_id')->dropDownList(['' => 'Select Reporting Manager Role Name']) ?>
			</div>
		
			 </div>
			 
			 <div class="hr"></div>
			 
			 <div class="form row mt20">
			<div class="form-group  col-xs-12 col-md-6 col-lg-4">
		    <?= $form->field($model, 'state')->textInput(['maxlength' => true,'placeholder'=>'Enter State']) ?>
			
		</div>
		<div class="form-group  col-xs-12 col-md-6 col-lg-4">
    		<?= $form->field($model, 'district')->textInput(['maxlength' => true,'placeholder'=>'Enter District']) ?>
			
		</div>
		<div class="form-group  col-xs-12 col-md-6 col-lg-4">
    		<?= $form->field($model, 'head_quarters')->textInput(['maxlength' => true,'placeholder'=>'Enter Headquarters']) ?>
			
		</div>
		<div class="form-group  col-xs-12 col-md-6 col-lg-4">
    		<?= $form->field($model, 'area_of_operatoin')->textInput(['maxlength' => true,'placeholder'=>'Enter Area of Operation']) ?>
			
		</div>
		<div class="form-group  col-xs-12 col-md-6 col-lg-4">
		    <?= $form->field($model, 'photo')->fileInput(['maxlength' => true]) ?>
			
		</div>
		
			 </div>
			 
			 <div class="hr"></div>
			 
			 <div class="col-sm-12 text-center mbl_padd">
					<?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'save', 'value' => 'saved']) ?>
					<?= Html::submitButton('Save & Activate', ['class' => 'btn btn-info', 'name' => 'save', 'value' => 'saveactivate']) ?>
					<?= Html::a('Cancel', ['profile'], ['class' => 'btn btn-danger']) ?>
			</div>
						 
    </div>
    

    <?php ActiveForm::end(); ?>

</div>
<?php
$url = Url::home();
$url2 = Url::home();
$url = $url.'/users/reportinglists/';
$url2 = $url2.'/users/reportinguserroles/';
$script = <<< JS
jQuery(document).ready(function($){
// $.get('$url'+$('#users-reporting_user_role').val(), function(data){
// $("#users-reporting_user_id").html(data);	
// 	});
	//onload if email exist
	if ($('#users-roleid').val() != '') {
		if ($('#users-roleid').val() == $icadmin_role_id) {
			$.get('$url2'+$('#users-roleid').val(), function(data){	
			    res = eval(data);
			    $("#users-reporting_user_role").html(res[0]);
				$("#users-reporting_user_id").html(res[1]);
			});
		} else {
			$('#r_user_role, #r_user_id').css('display','block');
			$('#users-reporting_user_role,#users-reporting_user_id').find('option:eq(0)').attr('value','');
			$.get('$url2'+$('#users-roleid').val(), function(data){	
			    res = eval(data);
			    $("#users-reporting_user_role").html(res[0]);
				$("#users-reporting_user_id").html(res[1]);
			});
		}
	}
	//onload if email exist end
	//onchange employee role
	$('#users-roleid').change(function(){
		if ($('#users-roleid').val() == '') {
			$("#r_user_role, #r_user_id").css('display', 'none');
			$("#users-reporting_user_role").html('<option value="">Select Reporting Manager Role</option>');
			$("#users-reporting_user_id").html('<option value="">Select Reporting Manager Name</option>');
		} else {
			if ($('#users-roleid').val() == $icadmin_role_id) {
				$('#r_user_role, #r_user_id').css('display','none');
			} else if($('#users-roleid').val() != $icadmin_role_id) {
				$('#r_user_role, #r_user_id').css('display','block');
				$('#users-reporting_user_role,#users-reporting_user_id').find('option:eq(0)').attr('value','');
			}
				$.get('$url2'+$('#users-roleid').val(), function(data){	
				    res = eval(data);
				    $("#users-reporting_user_role").html(res[0]);
					$("#users-reporting_user_id").html(res[1]);
				});
			}
	});
	//onchange employee role end	
	//onchange reporting manager role
	$('#users-reporting_user_role').change(function(){
		if($(this).val() == '') {
			$("#users-reporting_user_id").html('<option value="">Select Reporting Manager Name</option>');
		} else {
			$.post("$url"+$(this).val(), function(data){
				$("#users-reporting_user_id").html(data);
			});
		}
	});
	//onchange reporting manager role end		
});
JS;
$this->registerJs($script);
?>