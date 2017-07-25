<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;


?>
<div class="login-bg" style="width:100%;height:100%">
<div class="home pull-right"><a href="<?= Url::home();?>"><i class="fa fa-home"></i></a></div>
        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text-center">
                            <h1><a href="index"><img src="<?= Yii::getAlias('@weburl'); ?>/img/login-logo.png"></a></h1>
                            </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        	<?php if (Yii::$app->session->hasFlash('reset-password-success')) {?>
                             		<div class="alert alert-success">
                             		<?php echo Yii::$app->session->getFlash('reset-password-success'); ?>
                             		</div>
                             	<?php }?>
                             	
                              	<?php if (Yii::$app->session->hasFlash('reset-password-failure')) {?>
                             		<div class="alert alert-danger">
                             		<?php echo Yii::$app->session->getFlash('reset-password-failure'); ?>
                             		</div>
                             	<?php }?>
                        		<div class="form-top-left">
                        			<h3>Reset Password</h3>
                            		</div>
                        		
                            </div>
                            <div class="form-bottom">
                 			 <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
			                    	 <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Password'])->label(false); ?>

        							<?= $form->field($model, 'confirm_password')->passwordInput(['placeholder'=>'Confirm Password'])->label(false) ?>
        						<p class="help-block help-block-error"></p>
        						 <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
							    <?php ActiveForm::end(); ?>
									<a href="<?= Url::to(['site/login']);?>" class="pull-left login-footer">Login</a>
								 </div>
                        </div>
                    </div>
                    </div>
            </div>
            
        </div>
        </div>

      <?php 
$script = <<< JS

$('#navhead').hide();
$('.footer').hide();		

JS;
$this->registerJs($script);
?>