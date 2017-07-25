<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Change Password';
$this->params['breadcrumbs'][] = $this->title;
?>

								<h3 class="panel-title">Change Password</h3>
									<div class="form row col-sm-12 mt20">
								
				
					<div class="login-box">
						
						<div class="header">
							<span class="text-center">Change Password</span>
						</div>						
						<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
							<fieldset class="col-sm-12 group-addon-form">
								
								<div class="form-group">
									<div class="controls">
										<div class="input-group col-sm-12 forgot_psw">	
                 			 				<?= $form->field($model, 'old_password')->passwordInput(['placeholder'=>'Enter Your Old Password'])->label(false); ?>
											<span class="input-group-addon"><i class="fa fa-key"></i></span>
										</div>	
									</div>
								</div>
								<div class="form-group">
									<div class="controls">
										<div class="input-group col-sm-12 forgot_psw">	
			                    			<?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Enter Your New Password'])->label(false); ?>
											<span class="input-group-addon"><i class="fa fa-key"></i></span>
										</div>	
									</div>
								</div>
								<div class="form-group">
									<div class="controls">
										<div class="input-group col-sm-12 forgot_psw">	
			                    			<?= $form->field($model, 'confirm_password')->passwordInput(['placeholder'=>'Confirm Your New Password'])->label(false); ?>
											<span class="input-group-addon"><i class="fa fa-key"></i></span>
										</div>	
									</div>
								</div>
								
								<div class="form-group">
								    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary col-xs-12', 'name' => 'login-button']) ?>
																
								</div>
									
							</fieldset>	

						<?php ActiveForm::end(); ?>
						
						<div class="clearfix"></div>				
							
					</div>
				
			
			
								
</div>
   
