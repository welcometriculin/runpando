<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="home pull-right"><a href="<?= Url::home();?>"><i class="fa fa-home"></i></a></div>
        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text-center">
                            <h1><a href="<?= Url::home();?>"><img src="<?= Yii::getAlias('@weburl'); ?>/img/login-logo.png"></a></h1>
                            </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        		<?php if (Yii::$app->session->getFlash('forgot-password-success')) {?>
                             		<div class="alert alert-success">
                             		we have sent link to your e-mail address
                             		</div>
                             	<?php } else if (Yii::$app->session->getFlash('forgot-password-fail')) {?>
                             		<div class="alert alert-danger">
                             		Your account is not activated
                             		</div>
                             	<?php } else if (Yii::$app->session->getFlash('forgot-password-failure')) {?>
                             		<div class="alert alert-danger">
                             		The information provided does not match our database. Please try again with the correct Email Address.
                             		</div>
                             		<?php }?>
                        			<h3>Forgot Password</h3>
                            		</div>
                        		
                            </div>
                            <div class="form-bottom">
                            <?php $form = ActiveForm::begin([
								        'id' => 'forgot-password-form',
								        'options' => ['class' => 'login-form'], ]); ?>
			          				<div class="form-group">
			                    		<label class="sr-only" for="form-username">Email ID</label>
			                    		<?= $form->field($model, 'email_address')->textInput(['maxlength' => true, 'placeholder' => 'Enter Your Email Address'])->label(false); ?>
			                        </div>
			                        <?= Html::submitButton('SUBMIT', ['class' => 'btn']) ?>
							    
								<?php ActiveForm::end(); ?>
									<a href="<?= Url::to(['site/login']);?>" class="pull-left login-footer">Login</a>
									<a href="<?= Url::to(['inputcompanies/create']);?>" class="pull-right login-footer">Register</a>
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
