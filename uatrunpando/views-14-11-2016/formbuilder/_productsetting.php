<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\FormBuilder */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="panel-group" id="accordion2" role="tablist"
	aria-multiselectable="true">
	<div class="panel-body panel-bg">
		<!-- 							<h3 class="panel-title">Organization Profile</h3>
 -->
		<div class="col-md-12 mt20 listview clearfix label_frm">
			<div class=" cmpy_details">
				<div class="row">
				<div id ="partner-refresh">
					<div class="col-xs-12 col-md-12 padd_zero">
						<?php $form = ActiveForm::begin([ 'id' => 'dynamic-channel-form-save', 'validateOnType'=>true,'enableClientValidation'=> true,'action' =>'channelcreate'],['clientOptions'=>['hideErrorMessage'=>false]]); ?>
						<?= $form->field($model, 'companyid',['template' => "<div class='row'><div class='col-xs-12 col-sm-4 col-md-3 col-lg-2'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(ArrayHelper::map($companyList, 'id', 'organization_name'), ['prompt' => 'Select'])->label('Company') ?>
						<div class = "hide">
						<?= $form->field($model, 'activity',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-3  col-lg-2'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->hiddenInput(['value'=> 5, 'id' => 'ch_activity_id'])->label(false); ?>
						</div>
						<div class="panel-group form-accordion" id="accordion2">
							<div class="panel panel-default">
								<div id="refresh_form_1">
									<div class="panel-heading">
										<a class="accordion-toggle" data-toggle="collapse"
											data-parent="#accordion2" href="#collapseOne2">
											<h4 class="panel-title">
												<span> <i class="indicator fa fa-minus fa-minus2"></i> SECTION
													1
												</span>
											</h4>
										</a>
									</div>
									<div id="collapseOne2" class="accordion-product panel-collapse collapse in">
										<div class="panel-body">
										<div class="white-box fgmb0 ">
										<?php $model->step_1_chrequire = '1'; ?>
										
											<?php //$form->field($model, 'step_1_chrequire')->radioList(array('1'=>'yes','0'=>'no'))->label('Do you need this step ?'); ?>
											<?= $form->field($model, 'step_1_chrequire',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
		                              		'item' => function($index, $label, $name, $checked, $value) {
		                                    $return = '<label class="modal-radio">';
		                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '"  '.($value == 1 ? 'checked' : '').'>';
		                                    $return .= '<span>' . ucwords($label) . '</span>';
		                                    $return .= '</label>';
		                                    return $return;
                              				  } ,'class' => 'toggle-switch'])->label('Do you need this step ?',['class'=>'lbl-switch']); ?></div>
											<div id="total_ch_fields">
											<div class="white-box mb15">	<?= $form->field($model, 'product_id',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['' => 'Select Product']) ?></div>
												<div id="step_1_sub">
												<div class="white-box mb15">
													<h3>1. Field 1</h3>
													<?php $model->step_1_field1_chrequire = '1'; ?>
													<?= $form->field($model, 'step_1_field1_chstepno')->hiddenInput(['value'=> 1])->label(false); ?>
													<?php //$form->field($model, 'step_1_field1_chrequire')->radioList(array('1'=>'yes','0'=>'no'))->label('Do you require field 1 ?'); ?>
													<?= $form->field($model, 'step_1_field1_chrequire',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
					                              		'item' => function($index, $label, $name, $checked, $value) {
					                                    $return = '<label class="modal-radio">';
					                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '"  '.($value == 1 ? 'checked' : '').'>';
					                                    $return .= '<span>' . ucwords($label) . '</span>';
					                                    $return .= '</label>';
					                                    return $return;
			                              				  } ,'class' => 'toggle-switch'])->label('Do you require field 1 ?',['class'=>'lbl-switch']); ?>
													<div id="step_1_chfield1">
														
														<?= $form->field($model, 'step_1_field1_chlabel',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->textInput(['maxlength' => true, 'value' => 'Supplied']) ?>
														
														<?php $model->step_1_field1_chmandatory = '1'; ?>
														<?php //$form->field($model, 'step_1_field1_chmandatory')->radioList(array('1'=>'yes','0'=>'no'))->label('Do you require Mandatory field?'); ?>
														<?= $form->field($model, 'step_1_field1_chmandatory',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
					                              		'item' => function($index, $label, $name, $checked, $value) {
					                                    $return = '<label class="modal-radio">';
					                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '"  '.($value == 1 ? 'checked' : '').'>';
					                                    $return .= '<span>' . ucwords($label) . '</span>';
					                                    $return .= '</label>';
					                                    return $return;
			                              				  } ,'class' => 'toggle-switch'])->label('Do you require Mandatory field?',['class'=>'lbl-switch']); ?>
														<?= $form->field($model, 'step_1_field1_chdata_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['edittext' => 'Text Box', 'textarea' => 'Text Area', 'radio' => 'Radio Button','checkbox' => 'Check Box','selectbox' =>'Dropdown','rating' =>'Rating'], ['prompt' => 'Select DataType']) ?>
														<div id ="step_1_field1_chno_of_chars" style= "display:none">
   										   				<?= $form->field($model, 'step_1_field1_chno_chars',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-7 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['50' => '50', '100' => '100', '150' => '150', '200' => '200','250' => '250'], ['prompt' => 'Select No of Chars']) ?>
   										    			</div>
														<div id="step_1_field1_chvalidation_type"
															style="display: none">
															<?= $form->field($model, 'step_1_field1_chvalidation_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['numeric' => 'Numeric', 'alphanumeric' => 'AlphaNumeric', 'alphabets' => 'Alphabets', 'mobileno' => 'Mobile No'], ['prompt' => 'Select ValidationType']) ?>
														</div>
														<div id="step_1_field1_chvlaue" style="display: none">
															<?= $form->field($model, 'step_1_field1_chfield_value',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'><div class='dd-check'><span class='pull-left'>{input}</span> &nbsp; <span class='cb'><a href='#' class='btn btn-success btn-xs add-txt'><i class='fa fa-plus'> </i></a></span></div></div>\n{error}<div class='help-error'></div></div>\n{hint}
   												"])->textInput(['maxlength' => true,'name' =>'step_1_field1_chfield_boxes[]']); ?>
														</div>
													</div>
											<div class = "hide">
   								    	<?= $form->field($model, 'step_1_field1_chno_of_images',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->hiddenInput(['value' => 0])->label(false) ?>
                                            </div>
													</div>
													<div class="white-box mb15">
													<h3>Field 2</h3>
													<?php $model->step_1_field2_chrequire = '1'; ?>
													<?= $form->field($model, 'step_1_field2_chstepno')->hiddenInput(['value'=> 1])->label(false); ?>
													<?php //$form->field($model, 'step_1_field2_chrequire')->radioList(array('1'=>'yes','0'=>'no'))->label('Do you require field 2 ?'); ?>
													<?= $form->field($model, 'step_1_field2_chrequire',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
					                              		'item' => function($index, $label, $name, $checked, $value) {
					                                    $return = '<label class="modal-radio">';
					                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '"  '.($value == 1 ? 'checked' : '').'>';
					                                    $return .= '<span>' . ucwords($label) . '</span>';
					                                    $return .= '</label>';
					                                    return $return;
			                              				  } ,'class' => 'toggle-switch'])->label('Do you require field 2 ?',['class'=>'lbl-switch']); ?>
													<div id="step_1_chfield2">
														
														<?= $form->field($model, 'step_1_field2_chlabel',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->textInput(['maxlength' => true, 'value' => 'Liquidated']) ?>
														
														
														<?php $model->step_1_field2_chmandatory = '1'; ?>
														<?php //$form->field($model, 'step_1_field2_chmandatory')->radioList(array('1'=>'yes','0'=>'no'))->label('Do you require Mandatory field?'); ?>
														<?= $form->field($model, 'step_1_field2_chmandatory',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
					                              		'item' => function($index, $label, $name, $checked, $value) {
					                                    $return = '<label class="modal-radio">';
					                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '"  '.($value == 1 ? 'checked' : '').'>';
					                                    $return .= '<span>' . ucwords($label) . '</span>';
					                                    $return .= '</label>';
					                                    return $return;
			                              				  } ,'class' => 'toggle-switch'])->label('Do you require Mandatory field?',['class'=>'lbl-switch']); ?>
														<?= $form->field($model, 'step_1_field2_chdata_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['edittext' => 'Text Box', 'textarea' => 'Text Area', 'radio' => 'Radio Button','checkbox' => 'Check Box','selectbox' =>'Dropdown','rating' =>'Rating'], ['prompt' => 'Select DataType']) ?>
														<div id ="step_1_field2_chno_of_chars" style= "display:none">
   										   				<?= $form->field($model, 'step_1_field2_chno_chars',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-7 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['50' => '50', '100' => '100', '150' => '150', '200' => '200','250' => '250'], ['prompt' => 'Select No of Chars']) ?>
   										    			</div>
														<div id="step_1_field2_chvalidation_type"
															style="display: none">
															<?= $form->field($model, 'step_1_field2_chvalidation_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['numeric' => 'Numeric', 'alphanumeric' => 'AlphaNumeric', 'alphabets' => 'Alphabets', 'mobileno' => 'Mobile No'], ['prompt' => 'Select ValidationType']) ?>
														</div>
														<div id="step_1_field2_chvlaue" style="display: none">
															<?= $form->field($model, 'step_1_field2_chfield_value',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'><div class='dd-check'><span class='pull-left'>{input}</span> &nbsp; <span class='cb'><a href='#' class='btn btn-success btn-xs add-txt'><i class='fa fa-plus'> </i></a></span></div></div>\n{error}<div class='help-error'></div></div>\n{hint}
   												"])->textInput(['maxlength' => true,'name' =>'step_1_field2_chfield_boxes[]']); ?>
														</div>
													</div>
										<div class = "hide">
   								    	<?= $form->field($model, 'step_1_field2_chno_of_images',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->hiddenInput(['value' => 0])->label(false) ?>
                                            </div>
</div>
<div class="white-box mb15">
													<h3>Field 3</h3>
													<?php $model->step_1_field3_chrequire = '1'; ?>
													<?= $form->field($model, 'step_1_field3_chstepno')->hiddenInput(['value'=> 1])->label(false); ?>
													<?php //$form->field($model, 'step_1_field3_chrequire')->radioList(array('1'=>'yes','0'=>'no'))->label('Do you require field 2 ?'); ?>
													<?= $form->field($model, 'step_1_field3_chrequire',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
					                              		'item' => function($index, $label, $name, $checked, $value) {
					                                    $return = '<label class="modal-radio">';
					                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '"  '.($value == 1 ? 'checked' : '').'>';
					                                    $return .= '<span>' . ucwords($label) . '</span>';
					                                    $return .= '</label>';
					                                    return $return;
			                              				  } ,'class' => 'toggle-switch'])->label('Do you require field 3 ?',['class'=>'lbl-switch']); ?>
													<div id="step_1_chfield3">
														
														<?= $form->field($model, 'step_1_field3_chlabel',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->textInput(['maxlength' => true, 'value' => 'Season Progress']) ?>
														
														<?php $model->step_1_field3_chmandatory = '1'; ?>
														<?php //$form->field($model, 'step_1_field3_chmandatory')->radioList(array('1'=>'yes','0'=>'no'))->label('Do you require Mandatory field?'); ?>
														<?= $form->field($model, 'step_1_field3_chmandatory',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
					                              		'item' => function($index, $label, $name, $checked, $value) {
					                                    $return = '<label class="modal-radio">';
					                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '"  '.($value == 1 ? 'checked' : '').'>';
					                                    $return .= '<span>' . ucwords($label) . '</span>';
					                                    $return .= '</label>';
					                                    return $return;
			                              				  } ,'class' => 'toggle-switch'])->label('Do you require Mandatory field?',['class'=>'lbl-switch']); ?>
														
														<?= $form->field($model, 'step_1_field3_chdata_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['edittext' => 'Text Box', 'textarea' => 'Text Area', 'radio' => 'Radio Button','checkbox' => 'Check Box','selectbox' =>'Dropdown','rating' =>'Rating'], ['prompt' => 'Select DataType']) ?>
														<div id ="step_1_field3_chno_of_chars" style= "display:none">
   										   				<?= $form->field($model, 'step_1_field3_chno_chars',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-7 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['50' => '50', '100' => '100', '150' => '150', '200' => '200','250' => '250'], ['prompt' => 'Select No of Chars']) ?>
   										    			</div>
														<div id="step_1_field3_chvalidation_type"
															style="display: none">
															<?= $form->field($model, 'step_1_field3_chvalidation_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['numeric' => 'Numeric', 'alphanumeric' => 'AlphaNumeric', 'alphabets' => 'Alphabets', 'mobileno' => 'Mobile No'], ['prompt' => 'Select ValidationType']) ?>
														</div>
														<div id="step_1_field3_chvlaue" style="display: none">
															<?= $form->field($model, 'step_1_field3_chfield_value',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'><div class='dd-check'><span class='pull-left'>{input}</span> &nbsp; <span class='cb'><a href='#' class='btn btn-success btn-xs add-txt'><i class='fa fa-plus'> </i></a></span></div></div>\n{error}<div class='help-error'></div></div>\n{hint}
   												"])->textInput(['maxlength' => true,'name' =>'step_1_field3_chfield_boxes[]']); ?>
														</div>
													</div>
										<div class = "hide">
   								    	<?= $form->field($model, 'step_1_field3_chno_of_images',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->hiddenInput(['value' => 0])->label(false) ?>
                                            </div>
</div>
<div class="white-box mb15">
													<h3>Field 4</h3>
													<?php $model->step_1_field4_chrequire = '1'; ?>
													<?= $form->field($model, 'step_1_field4_chstepno')->hiddenInput(['value'=> 1])->label(false); ?>
													<?php //$form->field($model, 'step_1_field4_chrequire')->radioList(array('1'=>'yes','0'=>'no'))->label('Do you require field 2 ?'); ?>
													<?= $form->field($model, 'step_1_field4_chrequire',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
					                              		'item' => function($index, $label, $name, $checked, $value) {
					                                    $return = '<label class="modal-radio">';
					                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '"  '.($value == 1 ? 'checked' : '').'>';
					                                    $return .= '<span>' . ucwords($label) . '</span>';
					                                    $return .= '</label>';
					                                    return $return;
			                              				  } ,'class' => 'toggle-switch'])->label('Do you require field 4 ?',['class'=>'lbl-switch']); ?>
													<div id="step_1_chfield4">
														
														<?= $form->field($model, 'step_1_field4_chlabel',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->textInput(['maxlength' => true, 'value' => 'Season Progress']) ?>
														
														<?php $model->step_1_field4_chmandatory = '1'; ?>
														<?php //$form->field($model, 'step_1_field4_chmandatory')->radioList(array('1'=>'yes','0'=>'no'))->label('Do you require Mandatory field?'); ?>
														<?= $form->field($model, 'step_1_field4_chmandatory',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
					                              		'item' => function($index, $label, $name, $checked, $value) {
					                                    $return = '<label class="modal-radio">';
					                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '"  '.($value == 1 ? 'checked' : '').'>';
					                                    $return .= '<span>' . ucwords($label) . '</span>';
					                                    $return .= '</label>';
					                                    return $return;
			                              				  } ,'class' => 'toggle-switch'])->label('Do you require Mandatory field?',['class'=>'lbl-switch']); ?>
														
														<?= $form->field($model, 'step_1_field4_chdata_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['edittext' => 'Text Box', 'textarea' => 'Text Area', 'radio' => 'Radio Button','checkbox' => 'Check Box','selectbox' =>'Dropdown','rating' =>'Rating'], ['prompt' => 'Select DataType']) ?>
														<div id ="step_1_field4_chno_of_chars" style= "display:none">
   										   				<?= $form->field($model, 'step_1_field4_chno_chars',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-7 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['50' => '50', '100' => '100', '150' => '150', '200' => '200','250' => '250'], ['prompt' => 'Select No of Chars']) ?>
   										    			</div>
														<div id="step_1_field4_chvalidation_type"
															style="display: none">
															<?= $form->field($model, 'step_1_field4_chvalidation_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['numeric' => 'Numeric', 'alphanumeric' => 'AlphaNumeric', 'alphabets' => 'Alphabets', 'mobileno' => 'Mobile No'], ['prompt' => 'Select ValidationType']) ?>
														</div>
														<div id="step_1_field4_chvlaue" style="display: none">
															<?= $form->field($model, 'step_1_field4_chfield_value',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'><div class='dd-check'><span class='pull-left'>{input}</span> &nbsp; <span class='cb'><a href='#' class='btn btn-success btn-xs add-txt'><i class='fa fa-plus'> </i></a></span></div></div>\n{error}<div class='help-error'></div></div>\n{hint}
   												"])->textInput(['maxlength' => true,'name' =>'step_1_field4_chfield_boxes[]']); ?>
														</div>
													</div>
										<div class = "hide">
   								    	<?= $form->field($model, 'step_1_field4_chno_of_images',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->hiddenInput(['value' => 0])->label(false) ?>
                                            </div>
</div>
<div class="white-box mb15">
													<h3>Field 5</h3>
													<?php $model->step_1_field5_chrequire = '1'; ?>
													<?= $form->field($model, 'step_1_field5_chstepno')->hiddenInput(['value'=> 1])->label(false); ?>
													<?php //$form->field($model, 'step_1_field5_chrequire')->radioList(array('1'=>'yes','0'=>'no'))->label('Do you require field 2 ?'); ?>
													<?= $form->field($model, 'step_1_field5_chrequire',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
					                              		'item' => function($index, $label, $name, $checked, $value) {
					                                    $return = '<label class="modal-radio">';
					                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '"  '.($value == 1 ? 'checked' : '').'>';
					                                    $return .= '<span>' . ucwords($label) . '</span>';
					                                    $return .= '</label>';
					                                    return $return;
			                              				  } ,'class' => 'toggle-switch'])->label('Do you require field 5 ?',['class'=>'lbl-switch']); ?>
													<div id="step_1_chfield5">
														
														<?= $form->field($model, 'step_1_field5_chlabel',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->textInput(['maxlength' => true, 'value' => 'Season Progress']) ?>
														
														<?php $model->step_1_field5_chmandatory = '1'; ?>
														<?php //$form->field($model, 'step_1_field5_chmandatory')->radioList(array('1'=>'yes','0'=>'no'))->label('Do you require Mandatory field?'); ?>
														<?= $form->field($model, 'step_1_field5_chmandatory',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
					                              		'item' => function($index, $label, $name, $checked, $value) {
					                                    $return = '<label class="modal-radio">';
					                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '"  '.($value == 1 ? 'checked' : '').'>';
					                                    $return .= '<span>' . ucwords($label) . '</span>';
					                                    $return .= '</label>';
					                                    return $return;
			                              				  } ,'class' => 'toggle-switch'])->label('Do you require Mandatory field?',['class'=>'lbl-switch']); ?>
														
														<?= $form->field($model, 'step_1_field5_chdata_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['edittext' => 'Text Box', 'textarea' => 'Text Area', 'radio' => 'Radio Button','checkbox' => 'Check Box','selectbox' =>'Dropdown','rating' =>'Rating'], ['prompt' => 'Select DataType']) ?>
														<div id ="step_1_field5_chno_of_chars" style= "display:none">
   										   				<?= $form->field($model, 'step_1_field5_chno_chars',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-7 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['50' => '50', '100' => '100', '150' => '150', '200' => '200','250' => '250'], ['prompt' => 'Select No of Chars']) ?>
   										    			</div>
														<div id="step_1_field5_chvalidation_type"
															style="display: none">
															<?= $form->field($model, 'step_1_field5_chvalidation_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['numeric' => 'Numeric', 'alphanumeric' => 'AlphaNumeric', 'alphabets' => 'Alphabets', 'mobileno' => 'Mobile No'], ['prompt' => 'Select ValidationType']) ?>
														</div>
														<div id="step_1_field5_chvlaue" style="display: none">
															<?= $form->field($model, 'step_1_field5_chfield_value',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'><div class='dd-check'><span class='pull-left'>{input}</span> &nbsp; <span class='cb'><a href='#' class='btn btn-success btn-xs add-txt'><i class='fa fa-plus'> </i></a></span></div></div>\n{error}<div class='help-error'></div></div>\n{hint}
   												"])->textInput(['maxlength' => true,'name' =>'step_1_field5_chfield_boxes[]']); ?>
														</div>
													</div>
										<div class = "hide">
   								    	<?= $form->field($model, 'step_1_field5_chno_of_images',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->hiddenInput(['value' => 0])->label(false) ?>
                                            </div>
</div>

												</div>

											</div>
										</div>
									</div>
								</div>
							</div>
							
								<div id="refresh_form_2_3">
								<!-- <div class="hide">
								<div class="panel panel-default">
									<div class="panel-heading">

										<a class="accordion-toggle" data-toggle="collapse"
											data-parent="#accordion2" href="#collapseTwo2"><h4
												class="panel-title">
												<span> <i class="indicator fa fa-plus fa-plus2"></i> SECTION 2
												</span>
											</h4> </a>
									</div>
									<div id="collapseTwo2" class="accordion-product panel-collapse collapse">
										<div class="panel-body">
										<div class="white-box">
											<h3>1. Field 1</h3>
											<?php $model->step_2_field1_chrequire = '1'; ?>
											<div class="hide"><?= $form->field($model, 'step_2_field1_chstepno')->hiddenInput(['value'=> 5])->label(false); ?></div>
											<?php //$form->field($model, 'step_2_field1_chrequire')->radioList(array('1'=>'yes','0'=>'no'))->label('Do you require field 1 ?'); ?>
											<?= $form->field($model, 'step_2_field1_chrequire',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
					                              		'item' => function($index, $label, $name, $checked, $value) {
					                                    $return = '<label class="modal-radio">';
					                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '"  '.($value == 1 ? 'checked' : '').'>';
					                                    $return .= '<span>' . ucwords($label) . '</span>';
					                                    $return .= '</label>';
					                                    return $return;
			                              				  } ,'class' => 'toggle-switch'])->label('Do you need this step ?',['class'=>'lbl-switch']); ?>
											<div id="step_2_chfield1">
												
												<?= $form->field($model, 'step_2_field1_chlabel1',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->textInput(['maxlength' => true, 'value' => 'Collection']);?>
												<?= $form->field($model, 'step_2_field2_chlabel2',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->textInput(['maxlength' => true, 'value' => 'Target']);?>
												<?= $form->field($model, 'step_2_field3_chlabel3',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->textInput(['maxlength' => true, 'value' => 'Status']); ?>
												<?php $model->step_2_field1_chmandatory = '1'; ?>
												<?php //$form->field($model, 'step_2_field1_chmandatory')->radioList(array('1'=>'yes','0'=>'no'))->label('Do you require Mandatory field?'); ?>
												<div class ="hide">
												<?= $form->field($model, 'step_2_field1_chmandatory',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
					                              		'item' => function($index, $label, $name, $checked, $value) {
					                                    $return = '<label class="modal-radio">';
					                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '"  '.($value == 1 ? 'checked' : '').'>';
					                                    $return .= '<span>' . ucwords($label) . '</span>';
					                                    $return .= '</label>';
					                                    return $return;
			                              				  } ,'class' => 'toggle-switch'])->label('Do you require Mandatory field?',['class'=>'lbl-switch']); ?>
												</div>
												<div id="step_2_chfield1_validation_type"
													style="display: none">
													<?= $form->field($model, 'step_2_field1_chdata_type')->textInput(['maxlength' => true,'value' => 'edittext']) ?>
												   	<?= $form->field($model, 'step_2_field1_chno_chars')->textInput(['maxlength' => true,'value' => 0]) ?>
													<?= $form->field($model, 'step_2_field1_chvalidation_type')->textInput(['maxlength' => true,'value' => 'numeric']) ?>
												</div>
											</div>
											<div class = "hide">
   								    	<?= $form->field($model, 'step_2_field1_chno_of_images',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->hiddenInput(['value' => 0])->label(false) ?>
                                            </div>
											</div>
										</div>
									</div>
										</div>
										</div> -->
									<div class="panel panel-default">
										<div class="panel-heading">

											<a class="accordion-toggle" data-toggle="collapse"
												data-parent="#accordion2" href="#collapseThree2">
												<h4 class="panel-title">
													<span> <i class="indicator fa fa-plus fa-plus2"></i> SECTION 2
													</span>
												</h4>
											</a>
										</div>
										<div id="collapseThree2" class="accordion-product panel-collapse collapse">
											<div class="panel-body">
											<div class="white-box">
												<h3>1. Field 1</h3>
												<?php $model->step_3_field1_chrequire = '1'; ?>
												<?= $form->field($model, 'step_3_field1_chstepno')->hiddenInput(['value'=> 2])->label(false); ?>
												<?php //$form->field($model, 'step_3_field1_chrequire')->radioList(array('1'=>'yes','0'=>'no'))->label('Do you need this step ?'); ?>
												<?= $form->field($model, 'step_3_field1_chrequire',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
					                              		'item' => function($index, $label, $name, $checked, $value) {
					                                    $return = '<label class="modal-radio">';
					                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '"  '.($value == 1 ? 'checked' : '').'>';
					                                    $return .= '<span>' . ucwords($label) . '</span>';
					                                    $return .= '</label>';
					                                    return $return;
			                              				  } ,'class' => 'toggle-switch'])->label('Do you need this step ?',['class'=>'lbl-switch']); ?>
												<div id="step_3_chfield1">
													
													<?= $form->field($model, 'step_3_field1_chlabel',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->textInput(['maxlength' => true, 'value' => 'Remarks'])->label('Label');  ?>
													
													<?php $model->step_3_field1_chmandatory = '1'; ?>
													<?php //$form->field($model, 'step_3_field1_chmandatory')->radioList(array('1'=>'yes','0'=>'no'))->label('Do you require Mandatory field?'); ?>
													<?= $form->field($model, 'step_3_field1_chmandatory',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
					                              		'item' => function($index, $label, $name, $checked, $value) {
					                                    $return = '<label class="modal-radio">';
					                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '"  '.($value == 1 ? 'checked' : '').'>';
					                                    $return .= '<span>' . ucwords($label) . '</span>';
					                                    $return .= '</label>';
					                                    return $return;
			                              				  } ,'class' => 'toggle-switch'])->label('Do you require Mandatory field?',['class'=>'lbl-switch']); ?>
													<?= $form->field($model, 'step_3_field1_chdata_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['edittext' => 'Text Box', 'textarea' => 'Text Area', 'radio' => 'Radio Button','checkbox' => 'Check Box','selectbox' =>'Dropdown','rating' =>'Rating'], ['prompt' => 'Select DataType']); ?>
													<div id ="step_3_field1_chno_of_chars" style= "display:none">
   										   				<?= $form->field($model, 'step_3_field1_chno_chars',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-7 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['50' => '50', '100' => '100', '150' => '150', '200' => '200','250' => '250'], ['prompt' => 'Select No of Chars']) ?>
   										    			</div>
													<div id="step_3_field1_chvalidation_type"
														style="display: none">
														<?= $form->field($model, 'step_3_field1_chvalidation_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['numeric' => 'Numeric', 'alphanumeric' => 'AlphaNumeric', 'alphabets' => 'Alphabets', 'mobileno' => 'Mobile No'], ['prompt' => 'Select ValidationType']) ?>
													</div>
													<div id="step_3_field1_chvlaue" style="display: none">
														<?= $form->field($model, 'step_3_field1_chfield_value',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'><div class='dd-check'><span class='pull-left'>{input}</span> &nbsp; <span class='cb'><a href='#' class='btn btn-success btn-xs add-txt'><i class='fa fa-plus'> </i></a></span></div></div>\n{error}<div class='help-error'></div></div>\n{hint}
   												"])->textInput(['maxlength' => true,'name' =>'step_3_field1_chfield_boxes[]']); ?>
													</div>
												</div>
												<div class = "hide">
   								    	<?= $form->field($model, 'step_3_field1_chno_of_images',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->hiddenInput(['value' => 0])->label(false) ?>
                                            </div>
												</div>
											</div>
										</div>
									</div>
							<div class="panel panel-default">
                                    <div class="panel-heading">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFour2">
                                            <h4 class="panel-title">
                                       <span>  
                                    SECTION 3
                                       <i class="indicator fa fa-plus  pull-left"></i> </span>
                                    </h4></a>
                                    </div>
                                    <div id="collapseFour2" class="accordion panel-collapse collapse">
                                        <div class="panel-body">
                                         <div class="white-box">
                                       <h3>1. Field 1</h3>
												<?php $model->step_4_field1_chrequire = '1'; ?>
												<?= $form->field($model, 'step_4_field1_chstepno')->hiddenInput(['value'=> 3])->label(false); ?>
												<?php //$form->field($model, 'step_4_field1_chrequire')->radioList(array('1'=>'yes','0'=>'no'))->label('Do you need this step ?'); ?>
												<?= $form->field($model, 'step_4_field1_chrequire',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
					                              		'item' => function($index, $label, $name, $checked, $value) {
					                                    $return = '<label class="modal-radio">';
					                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '"  '.($value == 1 ? 'checked' : '').'>';
					                                    $return .= '<span>' . ucwords($label) . '</span>';
					                                    $return .= '</label>';
					                                    return $return;
			                              				  } ,'class' => 'toggle-switch'])->label('Do you need this step ?',['class'=>'lbl-switch']); ?>
												<div id="step_4_chfield1">
   										  
   										 <?= $form->field($model, 'step_4_field1_chlabel',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->textInput(['maxlength' => true, 'value' => 'Images'])->label('Label');  ?>
										<?php $model->step_4_field1_chmandatory = '1'; ?>
										<?= $form->field($model, 'step_4_field1_chmandatory',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->radioList(array('1'=>'','0'=>''),[
		                              		'item' => function($index, $label, $name, $checked, $value) {
		                                    $return = '<label class="modal-radio">';
		                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" '.($value == 1 ? 'checked' : '').'>';
		                                    $return .= '<span>' . ucwords($label) . '</span>';
		                                    $return .= '</label>';
		                                    return $return;
                              				  } ,'class' => 'toggle-switch'])->label('Do you require Mandatory field?',['class'=>'lbl-switch']); ?>
   										
   										
   										
   										
   										<?php //$form->field($model, 'step_5_field1_stepno')->hiddenInput(['value'=> 5])->label(false); ?>
   										<div style = "display:none">
   								     <?= $form->field($model, 'step_4_field1_chdata_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->textInput(['maxlength' => true,'value' =>'image']) ?>
   								   	<?= $form->field($model, 'step_4_field1_chno_chars')->textInput(['maxlength' => true,'value' => 0]) ?>
   								   	<?= $form->field($model, 'step_4_field1_chvalidation_type',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->textInput(['maxlength' => true]) ?>
   											
   								    	</div>
   										
   									<?= $form->field($model, 'step_4_field1_chno_of_images',['template' => "<div class='row'><div class='col-xs-12 col-sm-6 col-md-5  col-lg-4'>{label}</div>\n<div class='col-xs-12 col-sm-6 col-md-7 col-lg-4'>{input}</div>\n{error}</div>\n{hint}"])->dropDownList(['1' => 1, '2' => 2, '3' => 3]) ?>
   										 
                                        </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
							</div>


							<div class="form-group text-center">
								<?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn  btn-success']) ?>
							</div>

							<?php ActiveForm::end(); ?>

						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
$js = <<<JS
$(document).ready(function() {
/*getting product names from db if exist start*/
	$('#formbuilder-companyid').on('change', function(){
		var company_id_val = $('#formbuilder-companyid').val();
		if (company_id_val != '') {
			$.ajax({
  				method: "GET",
  				url: "productslist",
				async: false,
  				data: { company_id: company_id_val },
				success: function(data) {
					res = eval(data);
					if (res != 0) {
						$("#formbuilder-product_id").html(res);
					} else {
						$("#formbuilder-product_id").html('<option value="">Select Product</option>');
					}
				}
			});
		} else {
			$("#formbuilder-product_id").html('<option value="">Select Product</option>');
		}
	});
/*getting product names from db if exist end*/		
});   
JS;
$this->registerJs($js);
?>