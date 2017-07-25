<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

if (!Yii::$app->user->isGuest) {
$this->title = 'Add New Organization';
}
$this->params['breadcrumbs'][] = $this->title;
$loginsession = Yii::$app->session->get('loginid');
?>

<div class="login-bg user_form" style="width:100%;height:100%">
  <?php if ($loginsession == '') { ?>
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
                        		<?php 
                        	if (Yii::$app->user->isGuest) {
							if (Yii::$app->session->hasFlash('company-created')) {?>
							        <div class="alert alert-success">
						            Registration details are submitted successfully
						        	</div>
							<?php } }?>
                        		<div class="form-top-left">
                        			<h3>REGISTRATION</h3>
                            		</div>
                        		
                            </div>
                            <div class="form-bottom">
                          <?php $form = ActiveForm::begin(); ?> 
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">Email</label>
			                        <?= $form->field($model, 'contact_email')->textInput(['maxlength' => true,'placeholder'=>'Enter Your Email Address'])->label(false); ?></div>
									<div class="form-group">
			                    		<label class="sr-only" for="form-username">Password</label>
			                        	<?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'placeholder'=>'Enter Your Password'])->label(false); ?></div>
									<div class="form-group">
			                    		<label class="sr-only" for="form-username">Confirm Password</label>
										<?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => true, 'placeholder'=>'Confirm Your Password'])->label(false); ?>			                        </div>
									<div class="form-group">
			                    		<label class="sr-only" for="form-username">Phone Number</label>
			                        	<?= $form->field($model, 'phone_number')->textInput(['maxlength' => true, 'placeholder'=>'Enter Your Phone Number'])->label(false); ?></div>
									<!-- <div class="form-group">
			                    		<label class="sr-only" for="form-username">Email Address </label>
			                        	<input type="text" name="form-username" placeholder="Email Address" class="form-username form-control" id="form-username">
			                        </div>
									<div class="form-group">
			                        	<label class="sr-only" for="form-password">Password</label>
			                        	<input type="password" name="form-password" placeholder="Password" class="form-password form-control" id="form-password">
			                        </div>
									<div class="form-group">
			                    		<label class="sr-only" for="form-username">Apps Required:</label>
			                        	<select class="form-control">
										<option>Select Apps</option>
										<option>0-50</option>
										<option>51-200</option>
										</select>
			                        </div> -->
									 <div class="checkbox">
          <?= $form->field($model, 'checkbox')->checkboxList(['termsandconditions'=>'I agree Terms and Conditions'])->label('') ?>
 				 </div>
			                        
			        <?= Html::submitButton('SUBMIT', ['class' => 'btn', 'name' => 'save', 'value' => 'saved']) ?>
					<?php ActiveForm::end(); ?>
								<a href="<?= Url::to(['site/forgotpassword']);?>" class="pull-left login-footer">Forgot Password?</a>
								<a href="<?= Url::to(['site/login']);?>" class="pull-right login-footer">Login</a>
		                   
    
		                    </div>
                        </div>
                    </div>
                    </div>
            </div>
            
        </div>
         <?php } else {?>
		                    
	<?php $form = ActiveForm::begin(); ?> 

			<div class="form row col-sm-12 mt20">
					 
				<div class="form-group col-sm-6 col-md-4">
    <?= $form->field($model, 'person_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Name']) ?>
				
				</div>
				<div class="form-group col-sm-6 col-md-4">
    <?= $form->field($model, 'designation')->textInput(['maxlength' => true, 'placeholder' => 'Enter Designation']) ?>
				
				</div>
				<div class="form-group col-sm-6 col-md-4">
    <?= $form->field($model, 'organization_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Organization']) ?>
				
				</div>
				<div class="form-group col-sm-6 col-md-4">
    <?= $form->field($model, 'employee_number')->textInput(['maxlength' => true, 'placeholder' => 'Enter Employee ID']) ?>
				
				</div>
				</div>
				
					 <div class="hr"></div>
					 
					 <div class="form row col-sm-12 mt20">
					 
					 <div class="form-group col-sm-6 col-md-4">
    <?= $form->field($model, 'contact_email')->textInput(['maxlength' => true, 'placeholder' => 'Enter Email Address']) ?>
					 
				  
				</div>
					<div class="form-group col-sm-6 col-md-4">
	<?= $form->field($model, 'contact_person_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Contact Person Name']) ?>
				</div>
				<div class="form-group col-sm-6 col-md-4">
    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true, 'placeholder' => 'Enter Phone Number']) ?>
				
				</div>
				
				
				
					 </div>
					 
					 <div class="hr"></div>
					 
					 <div class="form row col-sm-12 mt20">
					 <div class="form-group col-sm-6 col-md-4">
	<?= $form->field($model, 'license_information')->textInput(['maxlength' => true, 'placeholder' => 'Enter License Information']) ?>
				</div>
					 <div class="form-group col-sm-6 col-md-4">
    <?= $form->field($model, 'paid_amount')->textInput(['maxlength' => true, 'placeholder' => 'Enter Amount']) ?>
					 
				</div>
					<div class="form-group col-sm-6 col-md-4">
    <?= $form->field($model, 'number_of_licences')->dropDownList([ '50' => '1-50', '100' => '51-100', '200' => '101-200' ], ['prompt' => 'Select'])  ?>
					
				</div>
				
				 <div class="hr"></div>
					 
					 <div class="form row col-sm-12 mt20">
				<div class="form-group col-sm-10">
					<div class="checkbox">
    <?= $form->field($model, 'checkbox')->checkboxList(['termsandconditions'=>'Customer accepts Terms and Conditions'])->label('') ?>
					
  </div>
			</div>
			
			
			
				 </div>
				 
				 <div class="hr"></div>
				 
				 <div class="col-sm-12 text-center mbl_padd">
					<?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'save', 'value' => 'saved']) ?>
					<?= Html::submitButton('Save & Activate', ['class' => 'btn btn-info', 'name' => 'save', 'value' => 'saveactivate']) ?>
					<?= Html::a('Cancel', ['index'], ['class' => 'btn btn-danger']) ?>
					</div>
											 
					    </div>

    <?php ActiveForm::end(); ?>
    <?php } ?>
        	</div>
             <?php 
$script = <<< JS
$(document).ready(function(){
	$('#navhead').hide();
	$('.footer').hide();
	$('.field-inputcompanies-checkbox').removeClass('required');
	$('#inputcompanies-checkbox').addClass('required');
	$('#inputcompanies-checkbox').find('label').addClass('control-label');	
});
		

JS;
$this->registerJs($script);
?>

