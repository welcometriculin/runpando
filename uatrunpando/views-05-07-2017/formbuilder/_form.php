<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\FormBuilder */
/* @var $form yii\widgets\ActiveForm */
$activity = Yii::$app->session->get('activity');
Yii::$app->session->remove('activity');
if($activity) {
	$model->activity = $activity;
} else {
	
	$model->activity = 1;
}
?>
<div class="">
	<?php 
	if(Yii::$app->session->hasFlash('label-names-create')){?>
        <div class="alert alert-success">
		<?php echo Yii::$app->session->getFlash('label-names-create'); ?>
        </div>
	<?php 
	}
	if (Yii::$app->session->hasFlash('dynamic-form-save') && Yii::$app->session->hasFlash('dynamic-form-not-exist')) {?>
		<div class="alert alert-success">
		Data Saved Successfully.
		</div>
	<?php 
	}
	if (Yii::$app->session->hasFlash('dynamic-form-save') && Yii::$app->session->hasFlash('dynamic-form-exist')) {?>
		<div class="alert alert-success">
		Data Saved Successfully.
		</div>
	<?php 
	}
	if (!Yii::$app->session->hasFlash('dynamic-form-save') && (Yii::$app->session->hasFlash('dynamic-form-not-exist') || Yii::$app->session->hasFlash('dynamic-form-exist'))) {?>
		<div class="alert alert-success">
		No Data Selected.
		</div>
	<?php 
	}
	if (Yii::$app->session->hasFlash('dynamic-productform-save')) {?>
		<div class="alert alert-success">
		Data Saved Successfully.
		</div>
	<?php 
	}
	?>
	<!-- <h1>Profile</h1> -->
	<div role="tabpanel" class="tabs">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#Dynamicform"
				aria-controls="home" role="tab" data-toggle="tab">Campaign Form</a></li>
			<li role="presentation" class=""><a href="#Productsettings"
				aria-controls="home" role="tab" data-toggle="tab">Partners Form
					</a></li>
			<li role="presentation" class=""><a href="#Labelsettings"
				aria-controls="home" role="tab" data-toggle="tab">Master Label Settings
					</a></li>

		</ul>

		<!-- Tab panes -->
		<div class="tab-content clearfix  padd_zero">

			<!-- --------------  Dyamic form Tab-Panel ------------------- -->

			<div role="tabpanel" class="tab-pane active" id="Dynamicform">
				<div class="panel-group" id="accordion" role="tablist"
					aria-multiselectable="true">
					<div class="panel-body panel-bg ">
						<!-- <h3 class="panel-title">User Profile</h3> -->
						<div class="col-md-12 mt20 listview label_frm form_mobile">
							<div class="row">
						<div class="col-xs-12 col-md-12 padd_zero">
 <?php $form = ActiveForm::begin([ 'id' => 'dynamic-form-save', 'validateOnType'=>true,'enableClientValidation'=> true,],['clientOptions'=>['hideErrorMessage'=>false]]); ?>
   	   <?= $form->field($model, 'company_id',['template' => "<div class='row'><div class='col-xs-12 col-sm-4 col-md-3 col-lg-2'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(ArrayHelper::map($companyList, 'id', 'organization_name'), ['prompt' => 'Select'])->label('Company') ?>
 
   
    	<?= $form->field($model, 'activity',['template' => "<div class='row'><div class='col-xs-12 col-sm-4 col-md-3 col-lg-2'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['1' => 'Farm and Home Visit', '2' => 'Farmer Group Meeting', '3' => 'Mass Campaign','4' => 'Demonstration'], ['prompt' => 'Select Activity']) ?>
    <div id = "refresh_form">
          
      
     <div class="panel-group form-accordion" id="accordion">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                            <h4 class="panel-title">
                                       <span>   <i class="indicator fa fa-minus"></i> 
                                     	SECTION 1
                                       </span>
                                    </h4></a>
                                    </div>
                                    <div id="collapseOne" class="accordion panel-collapse collapse in">
                                        <div class="panel-body">
                                        <div id ="fhv">
                                        
                                      
                                              
        <div class="white-box">
          <h3>Field 1</h3>
     
                                      <div class="hidden"> <?= $form->field($model, 'step_1_field1_stepno')->hiddenInput(['value'=> 1])->label(false); ?></div>
                                       
                                        <?php $model->step_1_field1_require = '1'; ?>
                                         <?= $form->field($model, 'step_1_field1_require',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
		                              		'item' => function($index, $label, $name, $checked, $value) {
		                                    $return = '<label class="modal-radio">';
		                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '"  '.($value == 1 ? 'checked' : '').'>';
		                                    $return .= '<span>' . ucwords($label) . '</span>';
		                                    $return .= '</label>';
		                                    return $return;
                              				  } ,'class' => 'toggle-switch'])->label('Do you need this step ?',['class'=>'lbl-switch']); ?>
   										  <div id = "step_1_subb">
   										
   										 <?= $form->field($model, 'step_1_field1_label',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->textInput(['maxlength' => true, 'value' => 'Sub Activity']) ?>
   								    	  <?php $model->step_1_field1_mandatory = '1'; ?>
   										  <?= $form->field($model, 'step_1_field1_mandatory',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
		                              		'item' => function($index, $label, $name, $checked, $value) {
		                                    $return = '<label class="modal-radio">';
		                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" '.($value == 1 ? 'checked' : '').'>';
		                                    $return .= '<span>' . ucwords($label) . '</span>';
		                                    $return .= '</label>';
		                                    return $return;
                              				  } ,'class' => 'toggle-switch'])->label('Is it Mandatory ?',['class'=>'lbl-switch']); ?>
   								    	
   								    	<div style = "display:none" class = "hide">
   								    <?= $form->field($model, 'step_1_field1_data_type')->textInput(['maxlength' => true,'value'=>'selectbox']) ?>
   									<?= $form->field($model, 'step_1_field1_no_chars')->textInput(['maxlength' => true,'value' => 0]) ?>
   								   	<?= $form->field($model, 'step_1_field1_validation_type')->textInput(['maxlength' => true]) ?>
   								    	
   								    	</div>
   								    	
   								    	</div>
   								    	<div class = "hide">
   								    	<?= $form->field($model, 'step_1_field1_no_of_images',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->hiddenInput(['value' => 0])->label(false) ?>
                                            </div>
                                             </div>                            
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        
                                      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><h4 class="panel-title">  <span> <i class="indicator fa fa-plus"></i>
                                     SECTION 2
                                       </span>
                                    </h4></a>
                                    </div>
                                    <div id="collapseTwo" class="accordion panel-collapse collapse">
                                        <div class="panel-body">
                                          <div class="white-box">
                                           <h3>Field 1</h3><?php $model->step_2_field1_require = '1'; ?>
                                        <div class="hidden"> <?= $form->field($model, 'step_2_field1_stepno')->hiddenInput(['value'=> 2])->label(false); ?></div>
                                         
                                         <?= $form->field($model, 'step_2_field1_require',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
		                              		'item' => function($index, $label, $name, $checked, $value) {
		                                    $return = '<label class="modal-radio">';
		                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" '.($value == 1 ? 'checked' : '').'>';
		                                    $return .= '<span>' . ucwords($label) . '</span>';
		                                    $return .= '</label>';
		                                    return $return;
                              				  } ,'class' => 'toggle-switch'])->label('Do you require this step ?',['class'=>'lbl-switch']); ?>
                              				 
   										  <div id = "step_2_sub">
   										 
   										 <?= $form->field($model, 'step_2_field1_label',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->textInput(['maxlength' => true, 'value' => 'Purpose'])->label('Label');  ?>
   										  
   										  <?php $model->step_2_field1_mandatory = '1'; ?>
   										  <?= $form->field($model, 'step_2_field1_mandatory',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
		                              		'item' => function($index, $label, $name, $checked, $value) {
		                                    $return = '<label class="modal-radio">';
		                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" '.($value == 1 ? 'checked' : '').'>';
		                                    $return .= '<span>' . ucwords($label) . '</span>';
		                                    $return .= '</label>';
		                                    return $return;
                              				  } ,'class' => 'toggle-switch'])->label('Do you require Mandatory field?',['class'=>'lbl-switch']); ?>
   										 <?= $form->field($model, 'step_2_field1_data_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['edittext' => 'Text Box', 'textarea' => 'Text Area', 'radio' => 'Radio Button','checkbox' => 'Check Box','selectbox' =>'Dropdown','rating' =>'Rating'], ['prompt' => 'Select DataType']); ?>
   										    <div id ="step_2_field1_no_of_chars" style= "display:none">
   										   <?= $form->field($model, 'step_2_field1_no_chars',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-7 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['50' => '50', '100' => '100', '150' => '150', '200' => '200','250' => '250'], ['prompt' => 'Select No of Chars']) ?>
   										    </div>
   										     <div id ="step_2_field1_validation_type" style= "display:none">
   										  <?= $form->field($model, 'step_2_field1_validation_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-7 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['numeric' => 'Numeric', 'alphanumeric' => 'AlphaNumeric', 'alphabets' => 'Alphabets', 'mobileno' => 'Mobile No'], ['prompt' => 'Select ValidationType']) ?>
   										  </div>
   										 <div id ="step_2_field1_feild_vlaue" style= "display:none">
   										<?= $form->field($model, 'step_2_field1_field_value',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-8 col-md-7 col-lg-4'><div class='dd-check'><span class='pull-left'>{input}</span> &nbsp; <span class='cb'><a href='#' class='btn btn-success btn-xs add-txt'><i class='fa fa-plus'> </i></a></span></div></div>\n{error}<div class='help-error'></div></div>\n{hint}
   												"])->textInput(['maxlength' => true,'name' =>'step_2_field1_field_boxes[]']); ?>
   										 </div>
                                        </div>
                                        <div class = "hide">
                                        <?= $form->field($model, 'step_2_field1_no_of_images',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->hiddenInput(['value' => 0])->label(false) ?>
                                    	</div>
                                    </div>
                                     </div>
                                </div>
                                   </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                     
                                      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">    <h4 class="panel-title">  <span>  <i class="indicator fa fa-plus"></i>
                                     SECTION 3
                                      </span>
                                    </h4></a>
                                    </div>
                                    <div id="collapseThree" class="accordion panel-collapse collapse">
                                        <div class="panel-body">
                                        <div class="white-box fgmb0 mb15">
                                        <?= $form->field($model, 'step_3_require',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
		                              		'item' => function($index, $label, $name, $checked, $value) {
		                                    $return = '<label class="modal-radio">';
		                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" '.($value == 1 ? 'checked' : '').'>';
		                                    $return .= '<span>' . ucwords($label) . '</span>';
		                                    $return .= '</label>';
		                                    return $return;
                              				  } ,'class' => 'toggle-switch'])->label('Do you require this step ?',['class'=>'lbl-switch']); ?>
                              				  </div>
                                        <div id="step_3_fields">
                                        <div id ="fhv">
                                        <div class="white-box mb15">
                                            <h3>Field 1</h3><?php $model->step_3_field1_require = '1'; ?>
                                          <div class="hidden"><?= $form->field($model, 'step_3_field1_stepno')->hiddenInput(['value'=> 3])->label(false); ?>   </div>
                                          
                                         <?= $form->field($model, 'step_3_field1_require',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
		                              		'item' => function($index, $label, $name, $checked, $value) {
		                                    $return = '<label class="modal-radio">';
		                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" '.($value == 1 ? 'checked' : '').'>';
		                                    $return .= '<span>' . ucwords($label) . '</span>';
		                                    $return .= '</label>';
		                                    return $return;
                              				  } ,'class' => 'toggle-switch'])->label('Do you require field 1 ?',['class'=>'lbl-switch']); ?>
   										  <div id = "step_3_field1">
   										 
   										 <?= $form->field($model, 'step_3_field1_label',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->textInput(['maxlength' => true, 'value' => 'Farmer Name']) ?>
   										 
   										  <?php $model->step_3_field1_mandatory = '1'; ?>
   										  <?= $form->field($model, 'step_3_field1_mandatory',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
		                              		'item' => function($index, $label, $name, $checked, $value) {
		                                    $return = '<label class="modal-radio">';
		                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" '.($value == 1 ? 'checked' : '').'>';
		                                    $return .= '<span>' . ucwords($label) . '</span>';
		                                    $return .= '</label>';
		                                    return $return;
                              				  } ,'class' => 'toggle-switch'])->label('Do you require Mandatory field?',['class'=>'lbl-switch']); ?>
   										 
   										 <?= $form->field($model, 'step_3_field1_data_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['edittext' => 'Text Box', 'textarea' => 'Text Area', 'radio' => 'Radio Button','checkbox' => 'Check Box','selectbox' =>'Dropdown','rating' =>'Rating'], ['prompt' => 'Select DataType']) ?>
   										 <div id ="step_3_field1_no_of_chars" style= "display:none">
   										   <?= $form->field($model, 'step_3_field1_no_chars',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-7 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['50' => '50', '100' => '100', '150' => '150', '200' => '200','250' => '250'], ['prompt' => 'Select No of Chars']) ?>
   										    </div>
   										 <div id ="step_3_field1_validation_type" style= "display:none">
   										  <?= $form->field($model, 'step_3_field1_validation_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['numeric' => 'Numeric', 'alphanumeric' => 'AlphaNumeric', 'alphabets' => 'Alphabets', 'mobileno' => 'Mobile No'], ['prompt' => 'Select ValidationType']) ?>
   										  </div>
   										 <div id ="step_3_field1_vlaue" style= "display:none">
   										 <?= $form->field($model, 'step_3_field1_field_value',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'><div class='dd-check'><span class='pull-left'>{input}</span> &nbsp; <span class='cb'><a href='#' class='btn btn-success btn-xs add-txt'><i class='fa fa-plus'> </i></a></span></div></div>\n{error}<div class='help-error'></div></div>\n{hint}
   												"])->textInput(['maxlength' => true,'name' =>'step_3_field1_field_boxes[]']); ?>
   										 </div>
   										 <div class = "hide">
   										 <?= $form->field($model, 'step_3_field1_no_of_images',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->hiddenInput(['value' => 0])->label(false) ?>
                                        </div>
                                        </div>
                                        </div>
                                         <div class="white-box mb15">
                                       <h3> Field 2</h3><?php $model->step_3_field2_require = '1'; ?>
                                       <div class="hidden"> <?= $form->field($model, 'step_3_field2_stepno')->hiddenInput(['value'=> 3])->label(false); ?></div>
                                        
                                         <?= $form->field($model, 'step_3_field2_require',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
		                              		'item' => function($index, $label, $name, $checked, $value) {
		                                    $return = '<label class="modal-radio">';
		                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" '.($value == 1 ? 'checked' : '').'>';
		                                    $return .= '<span>' . ucwords($label) . '</span>';
		                                    $return .= '</label>';
		                                    return $return;
                              				  } ,'class' => 'toggle-switch'])->label('Do you require field 2 ?',['class'=>'lbl-switch']); ?>
   										  <div id = "step_3_field2">
   										 
   										 <?= $form->field($model, 'step_3_field2_label',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->textInput(['maxlength' => true, 'value' => 'Mobile Number']) ?>
   										  
   										  <?php $model->step_3_field2_mandatory = '1'; ?>
   										  <?= $form->field($model, 'step_3_field2_mandatory',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
		                              		'item' => function($index, $label, $name, $checked, $value) {
		                                    $return = '<label class="modal-radio">';
		                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" '.($value == 1 ? 'checked' : '').'>';
		                                    $return .= '<span>' . ucwords($label) . '</span>';
		                                    $return .= '</label>';
		                                    return $return;
                              				  } ,'class' => 'toggle-switch'])->label('Do you require Mandatory field?',['class'=>'lbl-switch']); ?>
   										 
   										 <?= $form->field($model, 'step_3_field2_data_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['edittext' => 'Text Box', 'textarea' => 'Text Area', 'radio' => 'Radio Button','checkbox' => 'Check Box','selectbox' =>'Dropdown','rating' =>'Rating'], ['prompt' => 'Select DataType']) ?>
   										  <div id ="step_3_field2_no_of_chars" style= "display:none">
   										   <?= $form->field($model, 'step_3_field2_no_chars',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-7 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['50' => '50', '100' => '100', '150' => '150', '200' => '200','250' => '250'], ['prompt' => 'Select No of Chars']) ?>
   										    </div>
   										 <div id ="step_3_field2_validation_type" style= "display:none">
   										  <?= $form->field($model, 'step_3_field2_validation_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['numeric' => 'Numeric', 'alphanumeric' => 'AlphaNumeric', 'alphabets' => 'Alphabets', 'mobileno' => 'Mobile No'], ['prompt' => 'Select ValidationType']) ?>
   										  </div>
   										 <div id ="step_3_field2_vlaue" style= "display:none">
   										<?= $form->field($model, 'step_3_field2_field_value',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'><div class='dd-check'><span class='pull-left'>{input}</span> &nbsp; <span class='cb'><a href='#' class='btn btn-success btn-xs add-txt'><i class='fa fa-plus'> </i></a></span></div></div>\n{error}<div class='help-error'></div></div>\n{hint}
   												"])->textInput(['maxlength' => true,'name' =>'step_3_field2_field_boxes[]']); ?>
   										 </div>
   										 <div class = "hide">
   										 <?= $form->field($model, 'step_3_field2_no_of_images',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->hiddenInput(['value' => 0])->label(false) ?>
                                        </div>
                                        </div>
                                        </div>
                                        <div id = "fgm">
                                         <div class="white-box mb15">
                                       <h3> Field 3</h3><?php $model->step_3_field3_require = '1'; ?>
                                        <div class="hidden"><?= $form->field($model, 'step_3_field3_stepno')->hiddenInput(['value'=> 3])->label(false); ?></div>
                                        
                                        <?= $form->field($model, 'step_3_field3_require',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
		                              		'item' => function($index, $label, $name, $checked, $value) {
		                                    $return = '<label class="modal-radio">';
		                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" '.($value == 1 ? 'checked' : '').'>';
		                                    $return .= '<span>' . ucwords($label) . '</span>';
		                                    $return .= '</label>';
		                                    return $return;
                              				  } ,'class' => 'toggle-switch'])->label('Do you require field 3 ?'); ?>
                                         <div id = "step_3_field3">
   										 
   										 <?= $form->field($model, 'step_3_field3_label',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->textInput(['maxlength' => true]) ?>
   										 
   										  <?php $model->step_3_field3_mandatory = '1'; ?>
   										  <?= $form->field($model, 'step_3_field3_mandatory',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
		                              		'item' => function($index, $label, $name, $checked, $value) {
		                                    $return = '<label class="modal-radio">';
		                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" '.($value == 1 ? 'checked' : '').'>';
		                                    $return .= '<span>' . ucwords($label) . '</span>';
		                                    $return .= '</label>';
		                                    return $return;
                              				  } ,'class' => 'toggle-switch'])->label('Do you require Mandatory field?',['class'=>'lbl-switch']); ?>
   										 
   										 <?= $form->field($model, 'step_3_field3_data_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['edittext' => 'Text Box', 'textarea' => 'Text Area', 'radio' => 'Radio Button','checkbox' => 'Check Box','selectbox' =>'Dropdown','rating' =>'Rating'], ['prompt' => 'Select DataType']) ?>
   										 <div id ="step_3_field3_no_of_chars" style= "display:none">
   										   <?= $form->field($model, 'step_3_field3_no_chars',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-7 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['50' => '50', '100' => '100', '150' => '150', '200' => '200','250' => '250'], ['prompt' => 'Select No of Chars']) ?>
   										    </div>
   										 <div id ="step_3_field3_validation_type" style= "display:none">
   										  <?= $form->field($model, 'step_3_field3_validation_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['numeric' => 'Numeric', 'alphanumeric' => 'AlphaNumeric', 'alphabets' => 'Alphabets', 'mobileno' => 'Mobile No'], ['prompt' => 'Select ValidationType']) ?>
   										  </div>
   										 <div id ="step_3_field3_vlaue" style= "display:none">
   										<?= $form->field($model, 'step_3_field3_field_value',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'><div class='dd-check'><span class='pull-left'>{input}</span> &nbsp; <span class='cb'><a href='#' class='btn btn-success btn-xs add-txt'><i class='fa fa-plus'> </i></a></span></div></div>\n{error}<div class='help-error'></div></div>\n{hint}
   												"])->textInput(['maxlength' => true,'name' =>'step_3_field3_field_boxes[]']); ?>
   										 </div>
                                        </div>
                                        <div class = "hide">
                                        <?= $form->field($model, 'step_3_field3_no_of_images',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->hiddenInput(['value' => 0])->label(false) ?>
                                       </div>
                                       </div>
                                        </div>
                                         <div id = "mc">
                                          <div class="white-box mb15">
                                        <h3> Field 4</h3><?php $model->step_3_field4_require = '1'; ?>
                                       <div class="hidden"> <?= $form->field($model, 'step_3_field4_stepno')->hiddenInput(['value'=> 3])->label(false); ?></div>
                                        
                                         <?= $form->field($model, 'step_3_field4_require',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
		                              		'item' => function($index, $label, $name, $checked, $value) {
		                                    $return = '<label class="modal-radio">';
		                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" '.($value == 1 ? 'checked' : '').'>';
		                                    $return .= '<span>' . ucwords($label) . '</span>';
		                                    $return .= '</label>';
		                                    return $return;
                              				  } ,'class' => 'toggle-switch'])->label('Do you require field 4 ?',['class'=>'lbl-switch']); ?>
   										  <div id = "step_3_field4">
   										 
   										 <?= $form->field($model, 'step_3_field4_label',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->textInput(['maxlength' => true]) ?>
   										 
   										  <?php $model->step_3_field4_mandatory = '1'; ?>
   										  <?= $form->field($model, 'step_3_field4_mandatory',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
		                              		'item' => function($index, $label, $name, $checked, $value) {
		                                    $return = '<label class="modal-radio">';
		                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" '.($value == 1 ? 'checked' : '').'>';
		                                    $return .= '<span>' . ucwords($label) . '</span>';
		                                    $return .= '</label>';
		                                    return $return;
                              				  } ,'class' => 'toggle-switch'])->label('Do you require Mandatory field?',['class'=>'lbl-switch']); ?>
   										 
   										 
   										 <?= $form->field($model, 'step_3_field4_data_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['edittext' => 'Text Box', 'textarea' => 'Text Area', 'radio' => 'Radio Button','checkbox' => 'Check Box','selectbox' =>'Dropdown','rating' =>'Rating'], ['prompt' => 'Select DataType']) ?>
   										 <div id ="step_3_field4_no_of_chars" style= "display:none">
   										   <?= $form->field($model, 'step_3_field4_no_chars',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-7 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['50' => '50', '100' => '100', '150' => '150', '200' => '200','250' => '250'], ['prompt' => 'Select No of Chars']) ?>
   										    </div>
   										 <div id ="step_3_field4_validation_type" style= "display:none">
   										  <?= $form->field($model, 'step_3_field4_validation_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['numeric' => 'Numeric', 'alphanumeric' => 'AlphaNumeric', 'alphabets' => 'Alphabets', 'mobileno' => 'Mobile No'], ['prompt' => 'Select ValidationType']) ?>
   										  </div>
   										 <div id ="step_3_field4_vlaue" style= "display:none">
   										<?= $form->field($model, 'step_3_field4_field_value',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'><div class='dd-check'><span class='pull-left'>{input}</span> &nbsp; <span class='cb'><a href='#' class='btn btn-success btn-xs add-txt'><i class='fa fa-plus'> </i></a></span></div></div>\n{error}<div class='help-error'></div></div>\n{hint}
   												"])->textInput(['maxlength' => true,'name' =>'step_3_field4_field_boxes[]']); ?>
   										 </div>
                                        </div>
                                        <div class = "hide">
                                        <?= $form->field($model, 'step_3_field4_no_of_images',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->hiddenInput(['value' => 0])->label(false) ?>
                                        </div>
                                        </div>
                                        </div>
                                        <div id = "demo">
                                         <div class="white-box">
                                         
                                        <h3> Field 5</h3>
                                        
                                        <?php $model->step_3_field5_require = '1'; ?>
                                       <div class="hidden"> <?= $form->field($model, 'step_3_field5_stepno')->hiddenInput(['value'=> 3])->label(false); ?></div>
                                        
                                         <?= $form->field($model, 'step_3_field5_require',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
		                              		'item' => function($index, $label, $name, $checked, $value) {
		                                    $return = '<label class="modal-radio">';
		                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" '.($value == 1 ? 'checked' : '').'>';
		                                    $return .= '<span>' . ucwords($label) . '</span>';
		                                    $return .= '</label>';
		                                    return $return;
                              				  } ,'class' => 'toggle-switch'])->label('Do you require field 5 ?',['class'=>'lbl-switch']); ?>
   										  <div id = "step_3_field5">
   										  
   										 <?= $form->field($model, 'step_3_field5_label',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->textInput(['maxlength' => true]) ?>
   										
   										<?php $model->step_3_field5_mandatory = '1'; ?>
   										  <?= $form->field($model, 'step_3_field5_mandatory',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
		                              		'item' => function($index, $label, $name, $checked, $value) {
		                                    $return = '<label class="modal-radio">';
		                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" '.($value == 1 ? 'checked' : '').'>';
		                                    $return .= '<span>' . ucwords($label) . '</span>';
		                                    $return .= '</label>';
		                                    return $return;
                              				  } ,'class' => 'toggle-switch'])->label('Do you require Mandatory field?',['class'=>'lbl-switch']); ?>
   										
   										
   										 <?= $form->field($model, 'step_3_field5_data_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['edittext' => 'Text Box', 'textarea' => 'Text Area', 'radio' => 'Radio Button','checkbox' => 'Check Box','selectbox' =>'Dropdown','rating' =>'Rating'], ['prompt' => 'Select DataType']) ?>
   										  <?php // $form->field($model, 'step_3_field5_stepno')->hiddenInput(['value'=> 3])->label(false); ?>
   										<div id ="step_3_field5_no_of_chars" style= "display:none">
   										   <?= $form->field($model, 'step_3_field5_no_chars',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-7 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['50' => '50', '100' => '100', '150' => '150', '200' => '200','250' => '250'], ['prompt' => 'Select No of Chars']) ?>
   										    </div>
   										<div id ="step_3_field5_validation_type" style= "display:none">
   										  <?= $form->field($model, 'step_3_field5_validation_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['numeric' => 'Numeric', 'alphanumeric' => 'AlphaNumeric', 'alphabets' => 'Alphabets', 'mobileno' => 'Mobile No'], ['prompt' => 'Select ValidationType']) ?>
   										  </div>
   										 <div id ="step_3_field5_vlaue" style= "display:none">
   										<?= $form->field($model, 'step_3_field5_field_value',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'><div class='dd-check'><span class='pull-left'>{input}</span> &nbsp; <span class='cb'><a href='#' class='btn btn-success btn-xs add-txt'><i class='fa fa-plus'> </i></a></span></div></div>\n{error}<div class='help-error'></div></div>\n{hint}
   												"])->textInput(['maxlength' => true,'name' =>'step_3_field5_field_boxes[]']); ?>
   										 </div>
                                        </div>
                                        <div class = "hide">
                                        <?= $form->field($model, 'step_3_field5_no_of_images',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->hiddenInput(['value' => 0])->label(false) ?>
                                        </div>
                                        </div>
                                        </div>
                                        
                                        </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                                            <h4 class="panel-title">
                                       <span>  
                                    SECTION 4
                                       <i class="indicator fa fa-plus  pull-left"></i> </span>
                                    </h4></a>
                                    </div>
                                    <div id="collapseFour" class="accordion panel-collapse collapse">
                                        <div class="panel-body">
											<div id ="fhv">
											 <div class="white-box">
											<h3> Field 1</h3><?php $model->step_4_field1_require = '1'; ?>
											<div class="hidden"><?= $form->field($model, 'step_4_field1_stepno')->hiddenInput(['value'=> 4])->label(false); ?></div>
                                         
                                         <?= $form->field($model, 'step_4_field1_require',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
		                              		'item' => function($index, $label, $name, $checked, $value) {
		                                    $return = '<label class="modal-radio">';
		                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" '.($value == 1 ? 'checked' : '').'>';
		                                    $return .= '<span>' . ucwords($label) . '</span>';
		                                    $return .= '</label>';
		                                    return $return;
                              				  } ,'class' => 'toggle-switch'])->label('Do you require this step ?',['class'=>'lbl-switch']); ?>
   										  <div id = "step_4_field1">
   										 
   										 <?= $form->field($model, 'step_4_field1_label',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->textInput(['maxlength' => true, 'value' => 'Remarks']) ?>
   										 
   										 
   										  <?php $model->step_4_field1_mandatory = '1'; ?>
   										  <?= $form->field($model, 'step_4_field1_mandatory',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
		                              		'item' => function($index, $label, $name, $checked, $value) {
		                                    $return = '<label class="modal-radio">';
		                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" '.($value == 1 ? 'checked' : '').'>';
		                                    $return .= '<span>' . ucwords($label) . '</span>';
		                                    $return .= '</label>';
		                                    return $return;
                              				  } ,'class' => 'toggle-switch'])->label('Do you require Mandatory field?',['class'=>'lbl-switch']); ?>
   										 
   										 <?= $form->field($model, 'step_4_field1_data_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['edittext' => 'Text Box', 'textarea' => 'Text Area', 'radio' => 'Radio Button','checkbox' => 'Check Box','selectbox' =>'Dropdown','rating' =>'Rating'], ['prompt' => 'Select DataType']) ?>
   										 <?php  //$form->field($model, 'step_4_field1_stepno')->hiddenInput(['value'=> 4])->label(false); ?>
   										 <div id ="step_4_field1_no_of_chars" style= "display:none">
   										   <?= $form->field($model, 'step_4_field1_no_chars',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-7 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['50' => '50', '100' => '100', '150' => '150', '200' => '200','250' => '250'], ['prompt' => 'Select No of Chars']) ?>
   										    </div>
   										 <div id ="step_4_field1_validation_type" style= "display:none">
   										  <?= $form->field($model, 'step_4_field1_validation_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['numeric' => 'Numeric', 'alphanumeric' => 'AlphaNumeric', 'alphabets' => 'Alphabets', 'mobileno' => 'Mobile No'], ['prompt' => 'Select ValidationType']) ?>
   										  </div>
   										 <div id ="step_4_field1_vlaue" style= "display:none">
   										<?= $form->field($model, 'step_4_field1_field_value',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'><div class='dd-check'><span class='pull-left'>{input}</span> &nbsp; <span class='cb'><a href='#' class='btn btn-success btn-xs add-txt'><i class='fa fa-plus'> </i></a></span></div></div>\n{error}<div class='help-error'></div></div>\n{hint}
   												"])->textInput(['maxlength' => true,'name' =>'step_4_field1_field_boxes[]']); ?>
   										 </div>
                                        </div>
                                        <div class = "hide">
                                        <?= $form->field($model, 'step_4_field1_no_of_images',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->hiddenInput(['value' => 0])->label(false) ?>
											</div>
											</div>
											</div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
                                            <h4 class="panel-title">
                                       <span>  
                                    SECTION 5
                                       <i class="indicator fa fa-plus  pull-left"></i> </span>
                                    </h4></a>
                                    </div>
                                    <div id="collapseFive" class="accordion panel-collapse collapse">
                                        <div class="panel-body">
                                         <div class="white-box">
                                       <div class="hidden"><?= $form->field($model, 'step_5_field1_stepno')->hiddenInput(['value'=> 5])->label(false); ?></div>
 									<h3> Field 1</h3><?php $model->step_5_field1_require = '1'; ?>
                                         <?= $form->field($model, 'step_5_field1_require',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
		                              		'item' => function($index, $label, $name, $checked, $value) {
		                                    $return = '<label class="modal-radio">';
		                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" '.($value == 1 ? 'checked' : '').'>';
		                                    $return .= '<span>' . ucwords($label) . '</span>';
		                                    $return .= '</label>';
		                                    return $return;
                              				  } ,'class' => 'toggle-switch'])->label('Do you require this step ?',['class'=>'lbl-switch']); ?>
   										  <div id = "step_5_field1">
   										  
   										 <?= $form->field($model, 'step_5_field1_label',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->textInput(['maxlength' => true, 'value'=> 'Images']) ?>
   										
   										<?php $model->step_5_field1_mandatory = '1'; ?>
   										  <?= $form->field($model, 'step_5_field1_mandatory',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
		                              		'item' => function($index, $label, $name, $checked, $value) {
		                                    $return = '<label class="modal-radio">';
		                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" '.($value == 1 ? 'checked' : '').'>';
		                                    $return .= '<span>' . ucwords($label) . '</span>';
		                                    $return .= '</label>';
		                                    return $return;
                              				  } ,'class' => 'toggle-switch'])->label('Do you require Mandatory field?',['class'=>'lbl-switch']); ?>
   										
   										
   										
   										
   										<?php //$form->field($model, 'step_5_field1_stepno')->hiddenInput(['value'=> 5])->label(false); ?>
   										<div style = "display:none">
   								     <?= $form->field($model, 'step_5_field1_data_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->textInput(['maxlength' => true,'value' =>'image']) ?>
   								   	<?= $form->field($model, 'step_5_field1_no_chars')->textInput(['maxlength' => true,'value' => 0]) ?>
   								   	<?= $form->field($model, 'step_5_field1_validation_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->textInput(['maxlength' => true]) ?>
   											
   								    	</div>
   										 <?php /*
   										    								    <?= $form->field($model, 'step_5_field1_field_value')->textInput(['maxlength' => true]); ?>

   										 <?= $form->field($model, 'step_5_field1_data_type')->dropDownList(['edittext' => 'Edit Text', 'textarea' => 'Textarea', 'radio' => 'Radio','checkbox' => 'Check Box','selectbox' =>'Select Box','linear' =>'Linear'], ['prompt' => 'Select DataType']) ?>
   										 <div id ="step_5_field1_validation_type" style= "display:none">
   										  <?= $form->field($model, 'step_5_field1_validation_type')->dropDownList(['numeric' => 'Numeric', 'alphanumeric' => 'AlphaNumeric', 'alphabets' => 'Alphabets'], ['prompt' => 'Select ValidationType','disabled' =>'disabled']) ?>
   										  </div>
   										 <div id ="step_5_field1_vlaue" style= "display:none">
   										<?= $form->field($model, 'step_5_field1_field_value',['template' => "{label}\n<div>{input}<a href='#' class='btn btn-success btn-xs add-txt'>Add More</a>
   												</div>\n{hint}\n{error}"])->textInput(['maxlength' => true,'disabled'=>'disabled','name' =>'step_5_field1_boxes[]']); ?>
   										 </div>*/
   										 ?> 
   									<?= $form->field($model, 'step_5_field1_no_of_images',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['1' => 1, '2' => 2, '3' => 3]) ?>
   										 
                                        </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                         


    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary btn-success']) ?>
    </div>
    </div>
</div>		
<?php ActiveForm::end(); ?>

						</div>
							</div>
						</div>
					</div>

					</div>
				</div>
				<!-- -------------- USER PROFILE Tab-Panel END ------------------- -->

				<!-- --------------  Product Setting Tab-Panel Start ------------------- -->

			<div role="tabpanel" class="tab-pane" id="Productsettings">
				<?php echo $this->render('_productsetting', ['model' => $model,'companyList' => $companyList])?>
			</div>
			<!-- --------------  Product Setting Tab-Panel end ------------------- -->

				<!-- --------------  Label Setting Tab-Panel Start ------------------- -->
				<div role="tabpanel" class="tab-pane" id="Labelsettings">
					<div class="panel-group" id="accordion" role="tablist"
						aria-multiselectable="true">
						<div class="panel-body panel-bg">
<!-- 							<h3 class="panel-title">Labels</h3>
 -->							<div class="col-md-12 mt20 listview clearfix label_frm">
								<div class="col-md-12  cmpy_details">
								<?php $form = ActiveForm::begin(['action' => 'labelnamescreate', 'id' => 'label_setting']); ?>
								<?= $form->field($label_names, 'company_id',['template' => "<div class='row'><div class='col-xs-12 col-sm-4 col-md-3 col-lg-2'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n<div class='col-xs-12 col-md-12 col-lg-6'>{error}</div></div>\n{hint}"])->dropDownList(ArrayHelper::map($companyList, 'id', 'organization_name'), ['prompt' => 'Select'])->label('Company') ?>
								<?= $form->field($label_names, 'crop_label',['template' => "<div class='row'><div class='col-xs-12 col-sm-4 col-md-3 col-lg-2'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n<div class='col-xs-12 col-md-12 col-lg-6'>{error}</div></div>\n{hint}"])->textInput(['maxlength' => true, 'value' => 'Crop']) ?>
								<?= $form->field($label_names, 'product_label',['template' => "<div class='row'><div class='col-xs-12 col-sm-4 col-md-3 col-lg-2'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n<div class='col-xs-12 col-md-12 col-lg-6'>{error}</div></div>\n{hint}"])->textInput(['maxlength' => true, 'value' => 'Product']) ?>
								<?= $form->field($label_names, 'village_label',['template' => "<div class='row'><div class='col-xs-12 col-sm-4 col-md-3 col-lg-2'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n<div class='col-xs-12 col-md-12 col-lg-6'>{error}</div></div>\n{hint}"])->textInput(['maxlength' => true, 'value' => 'Village']) ?>
								<?= $form->field($label_names, 'partner_label',['template' => "<div class='row'><div class='col-xs-12 col-sm-4 col-md-3 col-lg-2'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n<div class='col-xs-12 col-md-12 col-lg-6'>{error}</div></div>\n{hint}"])->textInput(['maxlength' => true, 'value' => 'Partner']) ?>
									<div class="form-group">
									<div class="row">
<div class="col-xs-12  col-sm-3 col-sm-offset-4 col-md-6 col-md-offset-4 col-lg-5 col-lg-offset-2 save-lbel">
								        <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary ' : 'btn btn-success']) ?>
								    </div></div>
								    </div>
								<?php ActiveForm::end(); ?>
								</div>
							</div>   
						</div>
					</div>
				</div>
				<!-- --------------  Label Setting Tab-Panel End ------------------- -->
				
			</div>

		</div>

	</div>


  
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/js/dynamicform.js',['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/js/dynamic_product.js',['depends' => [\yii\web\JqueryAsset::className()]]); ?>

<?php
$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
$js = <<<JS
$(document).ready(function() {		
/*getting label names from db if exist start*/
	$('#labelnames-company_id').on('change', function(){
		var company_id_val = $('#labelnames-company_id').val();
		if (company_id_val != '') {
			$.ajax({
  				method: "GET",
  				url: "labelnameslist",
  				data: { company_id: company_id_val },
				success: function(data) {
				res = $.parseJSON(data);
				if (res['crop_label'] != '' || res['product_label'] != '' || res['partner_label'] != '') {	
					$('#labelnames-crop_label').val(res['crop_label']);
					$('#labelnames-product_label').val(res['product_label']);
					$('#labelnames-village_label').val(res['village_label']);
					$('#labelnames-partner_label').val(res['partner_label']);
				} else {
					$('#labelnames-crop_label').val('Crop');
					$('#labelnames-product_label').val('Product');
					$('#labelnames-village_label').val('Village');
					$('#labelnames-partner_label').val('Partner');
				}
				}
			});
		}
	});
/*getting label names from db if exist end*/		
});   
JS;
$this->registerJs($js);
?>
