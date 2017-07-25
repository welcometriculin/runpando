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
                            <h1><a href="<?= Url::home();?>"><img src="<?= Yii::getAlias('@weburl'); ?>/img/login-logo.png"></a></h1>
                            </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Login</h3>
                            		</div>
                        		
                            </div>
                            <div class="form-bottom">
                            
			                   <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal','enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
			                    	 <?= $form->field($model, 'email_address')->textInput(['placeholder'=>'Email address'])->label(false); ?>

        							<?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Password'])->label(false) ?>
        						
        						<p class="help-block help-block-error" style="color:#a94442"><?php echo $message; ?></p>
        						 <?php //echo '<span style="color:red">'.$message.'</span>'; ?>
			                    <?= Html::submitButton('LOGIN', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
			                   
							    <?php ActiveForm::end(); ?>
								
									<a href="<?= Url::to(['site/forgotpassword']);?>" class="pull-left login-footer">Forgot Password?</a>
									<a href="<?= Url::to(['inputcompanies/create']);?>" class="pull-right login-footer">Register</a>
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