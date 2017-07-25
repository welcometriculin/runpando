<?php

namespace app\api\modules\v3\models;

use Yii;

/**
 * This is the model class for table "form_builder".
 *
 * @property integer $form_builder_id
 * @property integer $form_builder_activity_id
 * @property integer $step
 * @property integer $require
 * @property integer $mandatory
 * @property string $label
 * @property string $data_type
 * @property string $validation_type
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_date
 * @property string $updated_date
 *
 * @property FormBuilderActivities $formBuilderActivity
 * @property FormValue[] $formValues
 */
class FormBuilder extends Kg
{
    /**
     * @inheritdoc
     */
	public $activity;
	public $company_id;
	public $step_1_field1_no_chars;
	public $step_1_field1_require;
	public $step_1_field1_mandatory;
	public $step_1_field1_label;
	public $step_1_field1_data_type;
	public $step_1_field1_validation_type;
	public $step_2_field1_no_chars; 
	public $step_2_field1_require;
	public $step_2_field1_mandatory;
	public $step_2_field1_label;
	public $step_2_field1_field_value;
	public $step_2_field1_data_type;
	public $step_2_field1_validation_type;
	public $step_3_field1_no_chars;
	public $step_3_field2_no_chars;
	public $step_3_field3_no_chars;
	public $step_3_field4_no_chars;
	public $step_3_field5_no_chars;
	public $step_3_field1_require;
	public $step_3_field1_mandatory;
	public $step_3_field1_label;
	public $step_3_field1_field_value;
	public $step_3_field1_data_type;
	public $step_3_field1_validation_type;
	public $step_3_field2_require;
	public $step_3_field2_mandatory;
	public $step_3_field2_label;
	public $step_3_field2_field_value;
	public $step_3_field2_data_type;
	public $step_3_field2_validation_type;
	public $step_3_field3_require;
	public $step_3_field3_mandatory;
	public $step_3_field3_label;
	public $step_3_field3_field_value;
	public $step_3_field3_data_type;
	public $step_3_field3_validation_type;
	public $step_3_field4_require;
	public $step_3_field4_mandatory;
	public $step_3_field4_label;
	public $step_3_field4_field_value;
	public $step_3_field4_data_type;
	public $step_3_field4_validation_type;
	public $step_3_field5_require;
	public $step_3_field5_mandatory;
	public $step_3_field5_label;
	public $step_3_field5_field_value;
	public $step_3_field5_data_type;
	public $step_3_field5_validation_type;
	public $step_4_field1_no_chars;
	public $step_4_field1_require;
	public $step_4_field1_mandatory;
	public $step_4_field1_label;
	public $step_4_field1_field_value;
	public $step_4_field1_data_type;
	public $step_4_field1_validation_type;
	public $step_5_field1_require;
	public $step_5_field1_mandatory;
	public $step_5_field1_label;
	public $step_5_field1_field_value;
	public $step_5_field1_data_type;
	public $step_5_field1_validation_type;
	public $step_1_field1_stepno;
	public $step_2_field1_stepno;
	public $step_3_field1_stepno;
	public $step_3_field2_stepno;
	public $step_3_field3_stepno;
	public $step_3_field4_stepno;
	public $step_3_field5_stepno;
	public $step_4_field1_stepno;
	public $step_5_field1_stepno;
	public $step_5_field1_no_chars;
	public $step_1_field1_no_of_images;
	public $step_2_field1_no_of_images;
	public $step_3_field1_no_of_images;
	public $step_3_field2_no_of_images;
	public $step_3_field3_no_of_images;
	public $step_3_field4_no_of_images;
	public $step_3_field5_no_of_images;
	public $step_4_field1_no_of_images;
	public $step_5_field1_no_of_images;
	//for product setting dynamic form
	public $companyid;
	public $step_1_field1_chno_chars;
	public $step_1_field1_chstepno;
	public $step_1_field1_chrequire;
	public $step_1_field1_chmandatory;
	public $step_1_field1_chlabel;
	public $step_1_field1_chdata_type;
	public $step_1_field1_chvalidation_type;
	public $step_1_field1_chfield_value;
	public $step_1_field1_chno_of_images;
	
	public $step_1_field2_chno_chars;
	public $step_1_field2_chstepno;
	public $step_1_field2_chrequire;
	public $step_1_field2_chmandatory;
	public $step_1_field2_chlabel;
	public $step_1_field2_chdata_type;
	public $step_1_field2_chvalidation_type;
	public $step_1_field2_chfield_value;
	public $step_1_field2_chno_of_images;
	
	public $step_1_field3_chno_chars;
	public $step_1_field3_chstepno;
	public $step_1_field3_chrequire;
	public $step_1_field3_chmandatory;
	public $step_1_field3_chlabel;
	public $step_1_field3_chdata_type;
	public $step_1_field3_chvalidation_type;
	public $step_1_field3_chfield_value;
	public $step_1_field3_chno_of_images;
	
	public $step_1_field4_chno_chars;
	public $step_1_field4_chstepno;
	public $step_1_field4_chrequire;
	public $step_1_field4_chmandatory;
	public $step_1_field4_chlabel;
	public $step_1_field4_chdata_type;
	public $step_1_field4_chvalidation_type;
	public $step_1_field4_chfield_value;
	public $step_1_field4_chno_of_images;
	
	public $step_1_field5_chno_chars;
	public $step_1_field5_chstepno;
	public $step_1_field5_chrequire;
	public $step_1_field5_chmandatory;
	public $step_1_field5_chlabel;
	public $step_1_field5_chdata_type;
	public $step_1_field5_chvalidation_type;
	public $step_1_field5_chfield_value;
	public $step_1_field5_chno_of_images;
	
	public $step_2_field1_chno_chars;
	public $step_2_field1_chstepno;
	public $step_2_field1_chrequire;
	public $step_2_field1_chmandatory;
	public $step_2_field1_chlabel1;
	public $step_2_field2_chlabel2;
	public $step_2_field3_chlabel3;
	public $step_2_field1_chdata_type;
	public $step_2_field1_chvalidation_type;
	public $step_2_field1_chfield_value;
	public $step_2_field1_chno_of_images;
	
	public $step_3_field1_chno_chars;
	public $step_3_field1_chrequire;
	public $step_3_field1_chstepno;
	public $step_3_field1_chmandatory;
	public $step_3_field1_chlabel;
	public $step_3_field1_chdata_type;
	public $step_3_field1_chvalidation_type;
	public $step_3_field1_chfield_value;
	public $step_3_field1_chno_of_images;
	
	public $step_4_field1_chno_chars;
	public $step_4_field1_chrequire;
	public $step_4_field1_chstepno;
	public $step_4_field1_chmandatory;
	public $step_4_field1_chlabel;
	public $step_4_field1_chdata_type;
	public $step_4_field1_chvalidation_type;
	public $step_4_field1_chfield_value;
	public $step_4_field1_chno_of_images;
	
	public $product_id;
	public $product_unit;
	
	Public $step_3_require;
	public $step_1_chrequire;
	
    public static function tableName()
    {
        return 'form_builder';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
         return [
            [['form_builder_activity_id','activity','company_id','created_by', 'updated_by', 'created_date', 'updated_date', 'companyid'], 'required'],
            [['form_builder_activity_id', 'step', 'require', 'mandatory', 'created_by', 'updated_by', 'step_5_field1_no_of_images', 'step_4_field1_chno_of_images'], 'integer'],
            [['created_date', 'updated_date','step_2_field1_chvalidation_type','step_1_field1_no_chars','step_2_field1_no_chars','step_3_field1_no_chars','step_3_field2_no_chars','step_3_field3_no_chars','step_3_field4_no_chars','step_3_field5_no_chars','step_3_field4_no_chars','step_4_field1_no_chars','step_5_field1_no_chars', 'step_1_field1_chno_chars','step_2_field1_chno_chars'], 'safe'],
         	['step_1_field1_label', 'default', 'value' => null],
            [['step_1_field1_mandatory','step_1_field1_label',],'required', 'when' => function($model) {
        		return $model->step_1_require == 1;
    		},'whenClient' => "function (attribute, value) {
        		return $('input:radio[name=\"FormBuilder[step_1_field1_require]\"]:checked').val() == 1;
    		}"],
    		//step 2
          	[['step_2_field1_mandatory','step_2_field1_label','step_2_field1_data_type'],'required','when' => function($model) {
        		return $model->step_2_require == 1;
    		},'whenClient' => "function (attribute, value) {
        		return $('input:radio[name=\"FormBuilder[step_2_field1_require]\"]:checked').val() == 1;
    		}"],
		    [['step_2_field1_field_value'],'required','when' => function($model) {
		    	return $model->step_2_field1_data_type != 'edittext';
		    },'whenClient' => "function (attribute, value) {
		        return $('#formbuilder-step_2_field1_data_type').val() == 'radio'||  $('#formbuilder-step_2_field1_data_type').val() == 'checkbox' || $('#formbuilder-step_2_field1_data_type').val() == 'selectbox';
		    }"],
		    [['step_2_field1_validation_type'],'required','when' => function($model) {
		        return $model->step_2_field1_data_type == 'edittext';
		    },'whenClient' => "function (attribute, value) {
		        return $('#formbuilder-step_2_field1_data_type').val() == 'edittext';
		    }"],
		    //step 4
		    [['step_4_field1_mandatory','step_4_field1_label','step_4_field1_data_type'],'required','when' => function($model) {
		    	return $model->step_4_field5_require == 1;
		    },'whenClient' => "function (attribute, value) {
		        return $('input:radio[name=\"FormBuilder[step_4_field1_require]\"]:checked').val() == 1;
		    }"],
		
		    [['step_4_field1_field_value'],'required','when' => function($model) {
		    	return $model->step_4_field1_data_type != 'edittext';
		    },'whenClient' => "function (attribute, value) {
		        return $('#formbuilder-step_4_field1_data_type').val() == 'radio' ||  $('#formbuilder-step_4_field1_data_type').val() == 'checkbox' || $('#formbuilder-step_4_field1_data_type').val() == 'selectbox';
		    }"],
        	[['step_4_field1_validation_type'],'required','when' => function($model) {
        		return $model->step_4_field1_data_type == 'edittext';
        	},'whenClient' => "function (attribute, value) {
        		return $('#formbuilder-step_4_field1_data_type').val() == 'edittext';
    		}"],
    		//step 5
    		[['step_5_field1_mandatory','step_5_field1_label'],'required','when' => function($model) {
    			return $model->step_5_field1_require == 1;
    		},'whenClient' => "function (attribute, value) {
        		return $('input:radio[name=\"FormBuilder[step_5_field1_require]\"]:checked').val() == 1;
    		}"],   
    		/*[['step_5_field1_field_value'],'required','when' => function($model) {
    			return $model->step_5_field1_data_type != 'edittext';
    		},'whenClient' => "function (attribute, value) {
    			if($('#formbuilder-step_5_field1_data_type').val() == 'edittext' || $('#formbuilder-step_5_field1_data_type').val() == 'textarea') {
    				return false;
   			 	} else {
    				return false;
            	}
        	//return $('#formbuilder-step_5_field1_data_type').val() != 'edittext' &&  $('#formbuilder-step_5_field1_data_type').val() != 'textarea' && $('#formbuilder-step_5_field1_data_type').val() != '';
    		}"],*/
        	/*[['step_5_field1_validation_type'],'required','when' => function($model) {
        		return $model->step_5_field1_data_type == 'edittext';
        	},'whenClient' => "function (attribute, value) {
        	return $('#formbuilder-step_5_field1_data_type').val() == 'edittext';
    		}"],*/
    		// step 3 field 1
    		[['step_3_field1_mandatory','step_3_field1_label','step_3_field1_data_type'],'required','when' => function($model) {
    			return $model->step_3_field1_require == 1;
    		},'whenClient' => "function (attribute, value) {
        		return $('input:radio[name=\"FormBuilder[step_3_field1_require]\"]:checked').val() == 1 && $('input:radio[name=\"FormBuilder[step_3_require]\"]:checked').val() == 1;
    		}"],
    		[['step_3_field1_field_value'],'required','when' => function($model) {
    			return $model->$step_3_field1_data_type != 'edittext';
    		},'whenClient' => "function (attribute, value) {
    			var step_3_fieldvalue = $('input:radio[name=\"FormBuilder[step_3_field1_require]\"]:checked').val();
    			var step3_require = $('input:radio[name=\"FormBuilder[step_3_require]\"]:checked').val();	
    			if($('#formbuilder-step_3_field1_data_type').val() == 'edittext' || $('#formbuilder-step_3_field1_data_type').val() == 'textarea'  || $('#formbuilder-step_3_field1_data_type').val() == 'rating' || step3_require == 0 || step_3_fieldvalue == 0) {
    				return false;
   			 	} else {
    				return true;
            	}
        	//return $('#formbuilder-step_3_field1_data_type').val() != 'edittext' &&  $('#formbuilder-step_3_field1_data_type').val() != 'textarea' && $('#formbuilder-step_3_field1_data_type').val() != '';
    		}"],
        	[['step_3_field1_validation_type'],'required','when' => function($model) {
        		return $model->step_3_field1_data_type == 'edittext';
        	},'whenClient' => "function (attribute, value) {
        		return $('#formbuilder-step_3_field1_data_type').val() == 'edittext';
    		}"],
		    // step 3 field 2
		    [['step_3_field2_mandatory','step_3_field2_label','step_3_field2_data_type'],'required','when' => function($model) {
		    	return $model->step_3_field2_require == 1;
		    },'whenClient' => "function (attribute, value) {
		        return $('input:radio[name=\"FormBuilder[step_3_field2_require]\"]:checked').val() == 1 && $('input:radio[name=\"FormBuilder[step_3_require]\"]:checked').val() == 1;
		    }"],
		    
		    [['step_3_field2_field_value'],'required','when' => function($model) {
		    	return $model->step_3_field2_data_type != 'edittext';
		    },'whenClient' => "function (attribute, value) {
		    	var step_3_fieldvalue = $('input:radio[name=\"FormBuilder[step_3_field2_require]\"]:checked').val();
		    	var step3_require = $('input:radio[name=\"FormBuilder[step_3_require]\"]:checked').val();	
		    	if($('#formbuilder-step_3_field2_data_type').val() == 'edittext' || $('#formbuilder-step_3_field2_data_type').val() == 'textarea' || $('#formbuilder-step_3_field2_data_type').val() == 'rating' || step_3_fieldvalue == 0 || step3_require == 0) {
		    		return false;
		   		} else {
		    		return true;
		        }
		        //return $('#formbuilder-step_3_field2_data_type').val() != 'edittext' &&  $('#formbuilder-step_3_field2_data_type').val() != 'textarea' &&  $('#formbuilder-step_3_field2_data_type').val() != '';
		    }"],
		    [['step_3_field2_validation_type'],'required','when' => function($model) {
		    	return $model->step_3_field2_data_type == 'edittext';
		    },'whenClient' => "function (attribute, value) {
		        return $('#formbuilder-step_3_field2_data_type').val() == 'edittext';
		    }"],
		    //step field3 
		    [['step_3_field3_mandatory','step_3_field3_label','step_3_field3_data_type'],'required','when' => function($model) {
		    	return $model->step_3_field3_require == 1;
		    },'whenClient' => "function (attribute, value) {
		    	if($('#formbuilder-activity').val() == 1 ){
		    		return false;
		    	} else if($('#formbuilder-activity').val() == 2 || $('#formbuilder-activity').val() == 4 || $('#formbuilder-activity').val() == 3) {
		    		return $('input:radio[name=\"FormBuilder[step_3_field3_require]\"]:checked').val() == 1 && $('input:radio[name=\"FormBuilder[step_3_require]\"]:checked').val() == 1;
		    	}
		    }"],
		    [['step_3_field3_field_value'],'required','when' => function($model) {
		    	return $model->step_3_field3_data_type != 'edittext';
		    },'whenClient' => "function (attribute, value) {
		    	var step_3_field3_value = $('input:radio[name=\"FormBuilder[step_3_field3_require]\"]:checked').val();
		    	var step3_require = $('input:radio[name=\"FormBuilder[step_3_require]\"]:checked').val();	
		    		if($('#formbuilder-step_3_field3_data_type').val() == 'edittext' || $('#formbuilder-step_3_field3_data_type').val() == 'textarea' || $('#formbuilder-step_3_field3_data_type').val() == 'rating' || $('#formbuilder-activity').val() == 1 || step_3_field3_value == 0 || step3_require == 0 ) {
		    		return false;
		   		} else {
		    		return true;
		        }
		       // return $('#formbuilder-step_3_field3_data_type').val() != 'edittext' &&  $('#formbuilder-step_3_field3_data_type').val() != 'textarea' && $('#formbuilder-step_3_field3_data_type').val() != 'textarea';
		    }"],
		    [['step_3_field3_validation_type'],'required','when' => function($model) {
		        return $model->step_3_field3_data_type == 'edittext';
		    },'whenClient' => "function (attribute, value) {
		        return $('#formbuilder-step_3_field3_data_type').val() == 'edittext';
		    }"],
		    //step_3 field4
		    [['step_3_field4_mandatory','step_3_field4_label','step_3_field4_data_type'],'required','when' => function($model) {
		        return $model->step_3_field4_require == 1;
		    },'whenClient' => "function (attribute, value) {
		    	if($('#formbuilder-activity').val() == 1 ||  $('#formbuilder-activity').val() == 2 ){
		    		return false;
		    	} else if ($('#formbuilder-activity').val() == 3 || $('#formbuilder-activity').val() == 4) {
		    		return $('input:radio[name=\"FormBuilder[step_3_field4_require]\"]:checked').val() == 1 && $('input:radio[name=\"FormBuilder[step_3_require]\"]:checked').val() == 1;
		        }
		    }"],
		    
		    [['step_3_field4_field_value'],'required','when' => function($model) {
		    	return $model->step_3_field4_data_type != 'edittext';
		    },'whenClient' => "function (attribute, value) {
		        var step_3_field4_value = $('input:radio[name=\"FormBuilder[step_3_field4_require]\"]:checked').val();
		    	var step3_require = $('input:radio[name=\"FormBuilder[step_3_require]\"]:checked').val();	
		    		if($('#formbuilder-step_3_field4_data_type').val() == 'edittext' || $('#formbuilder-step_3_field4_data_type').val() == 'textarea' || $('#formbuilder-step_3_field4_data_type').val() == 'rating' || $('#formbuilder-activity').val() == 1 || $('#formbuilder-activity').val() == 2 || step_3_field4_value == 0 || step3_require == 0) {
		    		return false;
		   		} else {
		    		return true;
		        }
		    }"],
		    [['step_3_field4_validation_type'],'required','when' => function($model) {
		    	return $model->step_3_field4_data_type == 'edittext';
		    },'whenClient' => "function (attribute, value) {
		        return $('#formbuilder-step_3_field4_data_type').val() == 'edittext';
		    }"],
		    //step_3 field5
		    [['step_3_field5_mandatory','step_3_field5_label','step_3_field5_data_type'],'required','when' => function($model) {
		    	return $model->step_3_field5_require == 1;
		    },'whenClient' => "function (attribute, value) {
		    	if($('#formbuilder-activity').val() == 1 ||  $('#formbuilder-activity').val() == 2 ||  $('#formbuilder-activity').val() == 3 ){
		    		return false;
		    	} else if ($('#formbuilder-activity').val() == 4) {
		    		return $('input:radio[name=\"FormBuilder[step_3_field5_require]\"]:checked').val() == 1 && $('input:radio[name=\"FormBuilder[step_3_require]\"]:checked').val() == 1;
		        }
		    }"],
		    [['step_3_field5_field_value'],'required','when' => function($model) {
		    	return $model->step_3_field5_data_type != 'edittext';
		    },'whenClient' => "function (attribute, value) {
		        var step_3_field5_value = $('input:radio[name=\"FormBuilder[step_3_field5_require]\"]:checked').val();
		    	var step3_require = $('input:radio[name=\"FormBuilder[step_3_require]\"]:checked').val();	
		    		if($('#formbuilder-step_3_field5_data_type').val() == 'edittext' || $('#formbuilder-step_3_field5_data_type').val() == 'textarea' || $('#formbuilder-step_3_field5_data_type').val() == 'rating' || $('#formbuilder-activity').val() == 1 || $('#formbuilder-activity').val() == 2 || $('#formbuilder-activity').val() == 3 || step_3_field5_value == 0 || step3_require == 0) {
		    		return false;
		   		} else {
		    		return true;
		        }
		    }"],
		    [['step_3_field5_validation_type'],'required','when' => function($model) {
		    	return $model->step_3_field5_data_type == 'edittext';
		    },'whenClient' => "function (attribute, value) {
		        return $('#formbuilder-step_3_field5_data_type').val() == 'edittext';
		    }"],
            [['label', 'data_type', 'validation_type'], 'string', 'max' => 255],
            // channel card validations
            [['companyid'],'required'],
            [['product_id'],'required','whenClient' => "function (attribute, value) {
		        return $('input:radio[name=\"FormBuilder[step_1_chrequire]\"]:checked').val() == 1;
		    }"],
            [['step_1_field1_chmandatory','step_1_field1_chlabel','step_1_field1_chdata_type'],'required', 'when' => function($model) {
            	return $model->step_1_field1_chrequire == 1;
            },'whenClient' => "function (attribute, value) {
        		return $('input:radio[name=\"FormBuilder[step_1_field1_chrequire]\"]:checked').val() == 1;
    		}"],
    		[['step_1_field1_chfield_value'],'required','when' => function($model) {
    			return $model->step_1_field1_chdata_type != 'edittext';
    		},'whenClient' => "function (attribute, value) {
    			if($('#formbuilder-step_1_field1_chdata_type').val() == 'edittext' || $('#formbuilder-step_1_field1_chdata_type').val() == 'textarea' || $('#formbuilder-step_1_field1_chdata_type').val() == 'rating' || $('#formbuilder-step_1_field1_chdata_type').val() == '' || $('input:radio[name=\"FormBuilder[step_1_chrequire]\"]:checked').val() == 0) {
			    	return false;
			   	} else {
			    	return true;
			    }
		        //return $('#formbuilder-step_1_field1_chdata_type').val() != 'edittext' && $('#formbuilder-step_1_field1_chdata_type').val() != 'textarea' && $('input:radio[name=\"FormBuilder[step_1_chrequire]\"]:checked').val() == 1;
		    }"],
    		 [['step_1_field1_chvalidation_type'],'required','when' => function($model) {
    				    	return $model->step_1_field1_chdata_type == 'edittext';
    				    },'whenClient' => "function (attribute, value) {
		        return $('#formbuilder-step_1_field1_chdata_type').val() == 'edittext';
		    }"],
		    //step1 filed2
		    [['step_1_field2_chmandatory','step_1_field2_chlabel','step_1_field2_chdata_type'],'required', 'when' => function($model) {
		    	return $model->step_1_field2_chrequire == 1;
		    },'whenClient' => "function (attribute, value) {
        		return $('input:radio[name=\"FormBuilder[step_1_field2_chrequire]\"]:checked').val() == 1;
    		}"],
		        		[['step_1_field2_chfield_value'],'required','when' => function($model) {
		        			return $model->step_1_field2_chdata_type != 'edittext';
		        		},'whenClient' => "function (attribute, value) {
		        			if($('#formbuilder-step_1_field2_chdata_type').val() == 'edittext' || $('#formbuilder-step_1_field2_chdata_type').val() == 'textarea' || $('#formbuilder-step_1_field2_chdata_type').val() == 'rating' || $('#formbuilder-step_1_field2_chdata_type').val() == '' || $('input:radio[name=\"FormBuilder[step_1_chrequire]\"]:checked').val() == 0) {
						    	return false;
						   	} else {
						    	return true;
						    }
		        //return $('#formbuilder-step_1_field2_chdata_type').val() != 'edittext' && $('#formbuilder-step_1_field2_chdata_type').val() != 'textarea' &&  $('input:radio[name=\"FormBuilder[step_1_chrequire]\"]:checked').val() == 1;
		    }"],
		    		    [['step_1_field2_chvalidation_type'],'required','when' => function($model) {
		    		    	return $model->step_1_field2_chdata_type == 'edittext';
		    		    },'whenClient' => "function (attribute, value) {
		        return $('#formbuilder-step_1_field2_chdata_type').val() == 'edittext';
		    }"],
		    //step1 filed3
		    [['step_1_field3_chmandatory','step_1_field3_chlabel','step_1_field3_chdata_type'],'required', 'when' => function($model) {
		    	return $model->step_1_field3_chrequire == 1;
		    },'whenClient' => "function (attribute, value) {
        		return $('input:radio[name=\"FormBuilder[step_1_field3_chrequire]\"]:checked').val() == 1;
    		}"],
		        		[['step_1_field3_chfield_value'],'required','when' => function($model) {
		        			return $model->step_1_field3_chdata_type != 'edittext';
		        		},'whenClient' => "function (attribute, value) {
		        			if($('#formbuilder-step_1_field3_chdata_type').val() == 'edittext' || $('#formbuilder-step_1_field3_chdata_type').val() == 'textarea' || $('#formbuilder-step_1_field3_chdata_type').val() == 'rating' || $('#formbuilder-step_1_field3_chdata_type').val() == '' || $('input:radio[name=\"FormBuilder[step_1_chrequire]\"]:checked').val() == 0) {
						    	return false;
						   	} else {
						    	return true;
						    }	
		        //return $('#formbuilder-step_1_field3_chdata_type').val() != 'edittext' && $('#formbuilder-step_1_field3_chdata_type').val() != 'textarea' && $('input:radio[name=\"FormBuilder[step_1_chrequire]\"]:checked').val() == 1;
		    }"],
		    		    [['step_1_field3_chvalidation_type'],'required','when' => function($model) {
		    		    	return $model->step_1_field3_chdata_type == 'edittext';
		    		    },'whenClient' => "function (attribute, value) {
		        return $('#formbuilder-step_1_field3_chdata_type').val() == 'edittext';
		    }"],
		    //step1 filed4
		    [['step_1_field4_chmandatory','step_1_field4_chlabel','step_1_field4_chdata_type'],'required', 'when' => function($model) {
		    	return $model->step_1_field4_chrequire == 1;
		    	},'whenClient' => "function (attribute, value) {
        		return $('input:radio[name=\"FormBuilder[step_1_field4_chrequire]\"]:checked').val() == 1;
    		}"],
		    [['step_1_field4_chfield_value'],'required','when' => function($model) {
		    	return $model->step_1_field4_chdata_type != 'edittext';
		    	},'whenClient' => "function (attribute, value) {
			    if($('#formbuilder-step_1_field4_chdata_type').val() == 'edittext' || $('#formbuilder-step_1_field4_chdata_type').val() == 'textarea' || $('#formbuilder-step_1_field4_chdata_type').val() == 'rating' || $('#formbuilder-step_1_field4_chdata_type').val() == '' || $('input:radio[name=\"FormBuilder[step_1_chrequire]\"]:checked').val() == 0) {
					return false;
				} else {
					return true;
				}
			    //return $('#formbuilder-step_1_field4_chdata_type').val() != 'edittext' && $('#formbuilder-step_1_field4_chdata_type').val() != 'textarea' &&  $('input:radio[name=\"FormBuilder[step_1_chrequire]\"]:checked').val() == 1;
		    }"],
		    [['step_1_field4_chvalidation_type'],'required','when' => function($model) {
		   		return $model->step_1_field4_chdata_type == 'edittext';
		    	},'whenClient' => "function (attribute, value) {
		    	return $('#formbuilder-step_1_field4_chdata_type').val() == 'edittext';
		    }"],
		    //step1 filed5
		    [['step_1_field5_chmandatory','step_1_field5_chlabel','step_1_field5_chdata_type'],'required', 'when' => function($model) {
		    	return $model->step_1_field5_chrequire == 1;
		    },'whenClient' => "function (attribute, value) {
        		return $('input:radio[name=\"FormBuilder[step_1_field5_chrequire]\"]:checked').val() == 1;
    		}"],
		    [['step_1_field5_chfield_value'],'required','when' => function($model) {
		        return $model->step_1_field5_chdata_type != 'edittext';
		        },'whenClient' => "function (attribute, value) {
			    if($('#formbuilder-step_1_field5_chdata_type').val() == 'edittext' || $('#formbuilder-step_1_field5_chdata_type').val() == 'textarea' || $('#formbuilder-step_1_field5_chdata_type').val() == 'rating' || $('#formbuilder-step_1_field5_chdata_type').val() == '' || $('input:radio[name=\"FormBuilder[step_1_chrequire]\"]:checked').val() == 0) {
					return false;
				} else {
					return true;
				}
			    //return $('#formbuilder-step_1_field5_chdata_type').val() != 'edittext' && $('#formbuilder-step_1_field5_chdata_type').val() != 'textarea' &&  $('input:radio[name=\"FormBuilder[step_1_chrequire]\"]:checked').val() == 1;
		    }"],
		    [['step_1_field5_chvalidation_type'],'required','when' => function($model) {
		    	return $model->step_1_field5_chdata_type == 'edittext';
		    	},'whenClient' => "function (attribute, value) {
		    	return $('#formbuilder-step_1_field5_chdata_type').val() == 'edittext';
		    }"],
		    //step2 field1
		    [['step_2_field1_chmandatory','step_2_field1_chlabel1','step_2_field2_chlabel2','step_2_field3_chlabel3'],'required', 'when' => function($model) {
		    	return $model->step_2_field1_chrequire == 1;
		    },'whenClient' => "function (attribute, value) {
        		return $('input:radio[name=\"FormBuilder[step_2_field1_chrequire]\"]:checked').val() == 1;
    		}"],
    		//step3 filed1
    		[['step_3_field1_chmandatory','step_3_field1_chlabel','step_3_field1_chdata_type'],'required', 'when' => function($model) {
    			return $model->step_3_field1_chrequire == 1;
    		},'whenClient' => "function (attribute, value) {
        		return $('input:radio[name=\"FormBuilder[step_3_field1_chrequire]\"]:checked').val() == 1;
    		}"],
    		    		[['step_3_field1_chfield_value'],'required','when' => function($model) {
    		    			return $model->step_3_field1_chdata_type != 'edittext';
    		    		},'whenClient' => "function (attribute, value) {
    		    		if($('#formbuilder-step_3_field1_chdata_type').val() == 'edittext' || $('#formbuilder-step_3_field5_data_type').val() == 'textarea' || $('#formbuilder-step_3_field5_data_type').val() == 'rating' || $('#formbuilder-step_3_field5_data_type').val() == '') {
			    			return false;
			   			} else {
			    			return true;
			        	}
		        //return $('#formbuilder-step_3_field1_chdata_type').val() != 'edittext' || $('#formbuilder-step_3_field1_chdata_type').val() != 'textarea';
		    }"],
    				    [['step_3_field1_chvalidation_type'],'required','when' => function($model) {
    				    	return $model->step_3_field1_chdata_type == 'edittext';
    				    },'whenClient' => "function (attribute, value) {
		        return $('#formbuilder-step_3_field1_chdata_type').val() == 'edittext';
		    }"],
		    [['step_2_field1_no_chars'],'required','when' => function($model) {
		    	return $model->step_2_field1_data_type == 'edittext' && $model->step_2_field1_data_type == 'textarea';
		    },'whenClient' => "function (attribute, value) {
		        return $('#formbuilder-step_2_field1_data_type').val() == 'edittext' || $('#formbuilder-step_2_field1_data_type').val() == 'textarea';
		    }"],
		    [['step_3_field1_no_chars'],'required','when' => function($model) {
		    	return $model->step_3_field1_data_type == 'edittext' && $model->step_3_field1_data_type == 'textarea';
		    },'whenClient' => "function (attribute, value) {
		        return $('#formbuilder-step_3_field1_data_type').val() == 'edittext' || $('#formbuilder-step_3_field1_data_type').val() == 'textarea';
		    }"],
		    [['step_3_field2_no_chars'],'required','when' => function($model) {
		    	return $model->step_3_field2_data_type == 'edittext' && $model->step_3_field2_data_type == 'textarea';
		    },'whenClient' => "function (attribute, value) {
		        return $('#formbuilder-step_3_field2_data_type').val() == 'edittext' || $('#formbuilder-step_3_field2_data_type').val() == 'textarea';
		    }"],
		    [['step_3_field3_no_chars'],'required','when' => function($model) {
		    	return $model->step_3_field3_data_type == 'edittext' && $model->step_3_field3_data_type == 'textarea';
		    },'whenClient' => "function (attribute, value) {
		        return $('#formbuilder-step_3_field3_data_type').val() == 'edittext' || $('#formbuilder-step_3_field3_data_type').val() == 'textarea';
		    }"],
		    [['step_3_field4_no_chars'],'required','when' => function($model) {
		    	return $model->step_3_field4_data_type == 'edittext' && $model->step_3_field4_data_type == 'textarea';
		    },'whenClient' => "function (attribute, value) {
		        return $('#formbuilder-step_3_field4_data_type').val() == 'edittext' || $('#formbuilder-step_3_field4_data_type').val() == 'textarea';
		    }"],
		    [['step_3_field5_no_chars'],'required','when' => function($model) {
		    	return $model->step_3_field5_data_type == 'edittext' && $model->step_3_field5_data_type == 'textarea';
		    },'whenClient' => "function (attribute, value) {
		        return $('#formbuilder-step_3_field5_data_type').val() == 'edittext' || $('#formbuilder-step_3_field5_data_type').val() == 'textarea';
		    }"],
		    [['step_4_field1_no_chars'],'required','when' => function($model) {
		    	return $model->step_4_field1_data_type == 'edittext' && $model->step_4_field1_data_type == 'textarea';
		    },'whenClient' => "function (attribute, value) {
		        return $('#formbuilder-step_4_field1_data_type').val() == 'edittext' || $('#formbuilder-step_4_field1_data_type').val() == 'textarea';
		    }"],
		    [['step_1_field1_chno_chars'],'required','when' => function($model) {
		    	return $model->step_1_field1_chdata_type == 'edittext' && $model->step_1_field1_chdata_type == 'textarea';
		    },'whenClient' => "function (attribute, value) {
		        return $('#formbuilder-step_1_field1_chdata_type').val() == 'edittext' || $('#formbuilder-step_1_field1_chdata_type').val() == 'textarea';
		    }"],
		    [['step_1_field2_chno_chars'],'required','when' => function($model) {
		    		    	return $model->step_1_field2_chdata_type == 'edittext' && $model->step_1_field2_chdata_type == 'textarea';
		    		    },'whenClient' => "function (attribute, value) {
		        return $('#formbuilder-step_1_field2_chdata_type').val() == 'edittext' || $('#formbuilder-step_1_field2_chdata_type').val() == 'textarea';
		    }"],
		    [['step_1_field3_chno_chars'],'required','when' => function($model) {
		    		 	return $model->step_1_field3_chdata_type == 'edittext' && $model->step_1_field3_chdata_type == 'textarea';
		    		    },'whenClient' => "function (attribute, value) {
		        return $('#formbuilder-step_1_field3_chdata_type').val() == 'edittext' || $('#formbuilder-step_1_field3_chdata_type').val() == 'textarea';
		    }"],
		    [['step_1_field4_chno_chars'],'required','when' => function($model) {
		    	return $model->step_1_field4_chdata_type == 'edittext' && $model->step_1_field4_chdata_type == 'textarea';
		    },'whenClient' => "function (attribute, value) {
		        return $('#formbuilder-step_1_field4_chdata_type').val() == 'edittext' || $('#formbuilder-step_1_field4_chdata_type').val() == 'textarea';
		    }"],
		    [['step_1_field5_chno_chars'],'required','when' => function($model) {
		    	return $model->step_1_field5_chdata_type == 'edittext' && $model->step_1_field5_chdata_type == 'textarea';
		    },'whenClient' => "function (attribute, value) {
		        return $('#formbuilder-step_1_field5_chdata_type').val() == 'edittext' || $('#formbuilder-step_1_field5_chdata_type').val() == 'textarea';
		    }"],
		    [['step_3_field1_chno_chars'],'required','when' => function($model) {
		    	return $model->step_3_field1_chdata_type == 'edittext' && $model->step_3_field1_chdata_type == 'textarea';
		    },'whenClient' => "function (attribute, value) {
		        return $('#formbuilder-step_3_field1_chdata_type').val() == 'edittext' || $('#formbuilder-step_3_field1_chdata_type').val() == 'textarea';
		    }"],
		    [['step_4_field1_chmandatory','step_4_field1_chlabel'],'required','when' => function($model) {
		    	return $model->step_4_field1_chrequire == 1;
		    },'whenClient' => "function (attribute, value) {
        		return $('input:radio[name=\"FormBuilder[step_4_field1_chrequire]\"]:checked').val() == 1;
    		}"],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
      return [
	'company_id' => 'Company',
    'companyid' => 'Company',
	'step_1_field1_require'=>  '',
	'step_1_field1_mandatory' =>  '',
	'step_1_field1_label' =>  'Field Name',
	'step_1_field1_data_type' =>  'Select Data Type',
	'step_1_field1_validation_type' =>  'Validation Type',
	'step_2_field1_require' =>  '',
	'step_2_field1_mandatory' =>  '',
	'step_2_field1_label' =>'Field Name',
	'step_2_field1_field_value' =>  'Multiple Answers',
	'step_2_field1_data_type' =>  'Select Data Type',
	'step_2_field1_validation_type' =>  'Validation Type',
	'step_3_field1_require' =>  '',
	'step_3_field1_mandatory' =>  '',
	'step_3_field1_label' => 'Field Name',
	'step_3_field1_field_value' =>  '',
	'step_3_field1_data_type' =>  'Select Data Type',
	'step_3_field1_validation_type' =>  'Validation Type',
	'step_3_field2_require' =>  '',
	'step_3_field2_mandatory' =>  '',
	'step_3_field2_label' =>  'Field Name',
	'step_3_field2_field_value' =>  'Multiple Answers',
	'step_3_field2_data_type' =>  'Select Data Type',
	'step_3_field2_validation_type' =>  'Validation Type',
	'step_3_field3_require' =>  '',
	'step_3_field3_mandatory' =>  '',
	'step_3_field3_label' =>  'Field Name',
	'step_3_field3_field_value' =>  'Multiple Answers',
	'step_3_field3_data_type' =>  'Select Data Type',
	'step_3_field3_validation_type' =>  'Validation Type',
	'step_3_field4_require' =>  '',
	'step_3_field4_mandatory' =>  '',
	'step_3_field4_label' =>  'Field Name',
	'step_3_field4_field_value' =>  'Multiple Answers',
	'step_3_field4_data_type' =>  'Select Data Type',
	'step_3_field4_validation_type' =>  'Validation Type',
	'step_3_field5_require' =>  '',
	'step_3_field5_mandatory' =>  '',
	'step_3_field5_label' =>  'Field Name',
	'step_3_field5_field_value' =>  'Multiple Answers',
	'step_3_field5_data_type' =>  'Select Data Type',
	'step_3_field5_validation_type' =>  'Validation Type',
	'step_4_field1_require' =>  '',
	'step_4_field1_mandatory' =>  '',
	'step_4_field1_label' =>  'Field Name',
	'step_4_field1_field_value' =>  'Multiple Answers',
	'step_4_field1_data_type' =>  'Select Data Type',
	'step_4_field1_validation_type' =>  'Validation Type',
	'step_5_field1_require' =>  '',
	'step_5_field1_mandatory' =>  '',
	'step_5_field1_label' =>  'Field Name',
	'step_5_field1_field_value' =>  'Multiple Answers',
	'step_5_field1_data_type' =>  'Select Data Type',
	'step_5_field1_validation_type' =>  'Validation Type',
	'step_1_field1_stepno' =>  '',
	'step_2_field1_stepno' =>  '',
	'step_3_field1_stepno' =>  '',
	'step_3_field2_stepno' =>  '',
	'step_3_field3_stepno' =>  '',
	'step_3_field4_stepno' =>  '',
	'step_3_field5_stepno' =>  '',
	'step_4_field1_stepno' => '',
	'step_5_field1_stepno' => '',
	'step_1_field1_chstepno' => '',
	'step_1_field1_chrequire' => '',
	'step_1_field1_chmandatory' => '',
	'step_1_field1_chlabel' => 'Field Name',
	'step_1_field1_chdata_type' =>  'Select Data Type',
	'step_1_field1_chvalidation_type' =>  'Validation Type',
	'step_1_field1_chfield_value' =>  'Multiple Answers',
	'step_1_field2_chstepno' => '',
	'step_1_field2_chrequire' => '',
	'step_1_field2_chmandatory' => '',
	'step_1_field2_chlabel' => 'Field Name',
	'step_1_field2_chdata_type' =>  'Select Data Type',
	'step_1_field2_chvalidation_type' =>  'Validation Type',
	'step_1_field2_chfield_value' =>  'Multiple Answers',
	'step_1_field3_chstepno' => '',
	'step_1_field3_chrequire' => '',
	'step_1_field3_chmandatory' => '',
	'step_1_field3_chlabel' => 'Field Name',
	'step_1_field3_chdata_type' =>  'Select Data Type',
	'step_1_field3_chvalidation_type' =>  'Validation Type',
	'step_1_field3_chfield_value' =>  'Multiple Answers',
    'step_1_field4_chstepno' => '',
    'step_1_field4_chrequire' => '',
    'step_1_field4_chmandatory' => '',
    'step_1_field4_chlabel' => 'Field Name',
    'step_1_field4_chdata_type' =>  'Select Data Type',
    'step_1_field4_chvalidation_type' =>  'Validation Type',
    'step_1_field4_chfield_value' =>  'Multiple Answers',
    'step_1_field5_chstepno' => '',
    'step_1_field5_chrequire' => '',
    'step_1_field5_chmandatory' => '',
    'step_1_field5_chlabel' => 'Field Name',
    'step_1_field5_chdata_type' =>  'Select Data Type',
    'step_1_field5_chvalidation_type' =>  'Validation Type',
    'step_1_field5_chfield_value' =>  'Multiple Answers',      		
	'step_2_field1_chstepno' => '',
	'step_2_field1_chrequire' => '',
	'step_2_field1_chmandatory' => '',
	'step_2_field1_chlabel1' => 'Title',
	'step_2_field2_chlabel2' => 'Label1',
	'step_2_field3_chlabel3' => 'Label2',
	'step_2_field1_chdata_type' =>  'Select Data Type',
	'step_2_field1_chvalidation_type' =>  'Validation Type',
	'step_2_field1_chfield_value' =>  'Multiple Answers',
	'step_3_field1_chrequire' => '',
	'step_3_field1_chstepno' => '',
	'step_3_field1_chmandatory' => '',
	'step_3_field1_chlabel' => 'Field Name',
	'step_3_field1_chdata_type' =>  'Select Data Type',
	'step_3_field1_chvalidation_type' =>  'Validation Type',
	'step_3_field1_chfield_value' =>  'Multiple Answers',
    'step_4_field1_chrequire' => '',
    'step_4_field1_chstepno' => '',
    'step_4_field1_chmandatory' => '',
    'step_4_field1_chlabel' => 'Field Name',
    'step_4_field1_chdata_type' =>  'Select Data Type',
    'step_4_field1_chvalidation_type' =>  'Validation Type',
    'step_4_field1_chfield_value' =>  'Multiple Answers',
    'step_4_field1_chno_of_images' => 'No of Images',
	'product_id' => 'Product Name',
	'product_unit' => '',
	'step_3_require' => '',
	'step_1_chrequire' => '',
	'step_5_field1_no_of_images' => 'No of Images',
	'step_2_field1_no_chars' => 'No of Chars',
	'step_1_field1_chno_chars' =>'No of chars',
	'step_1_field2_chno_chars' =>'No of chars',
	'step_1_field3_chno_chars' =>'No of chars',
    'step_1_field4_chno_chars' =>'No of chars',
    'step_1_field5_chno_chars' =>'No of chars',
	'step_3_field1_chno_chars' =>'No of chars',
	'step_3_field1_no_chars' => 'No of Chars',
	'step_3_field2_no_chars' => 'No of Chars',
	'step_3_field3_no_chars' => 'No of Chars',
	'step_3_field4_no_chars' => 'No of Chars',
	'step_3_field5_no_chars' => 'No of Chars',
	'step_4_field1_no_chars' => 'No of Chars',
	
	
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormBuilderActivity()
    {
        return $this->hasOne(FormBuilderActivities::className(), ['form_builder_activity_id' => 'form_builder_activity_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormValues()
    {
        return $this->hasMany(FormValue::className(), ['form_builder_id' => 'form_builder_id']);
    }
    
    public static function activityLabels($activty_name)
    {
   	$company_id = Yii::$app->user->identity->input_company_id;
   	$labels_final_result = array();
	$labels_query = 'SELECT fb.label,fb.step
				FROM form_builder_activities fba
				LEFT JOIN form_builder fb ON fb.form_builder_activity_id = fba.form_builder_activity_id
				LEFT JOIN activity ac ON ac.activity_id = fba.activity_id
				WHERE ac.activity_name = "'.$activty_name.'"
				AND fba.company_id = "'.$company_id.'"	
				GROUP BY fb.form_builder_id';
	$labels_query_execute = Yii::$app->db->createCommand($labels_query)->queryAll();
	if(empty($labels_query_execute)) {
		return $labels_final_result;
	}
	else if($labels_query_execute[0]['label'] == '' && $labels_query_execute[0]['step'] == '') {
		return $labels_final_result;
	}
	if (!empty($labels_query_execute)) {
		foreach ($labels_query_execute as $labels) {
			$labels_final_result['step'.$labels['step']][] = $labels['label'];
		}
	}
    return $labels_final_result;
    }
    
    /*  public function stepsValidation() 
    {
    	$session = Yii::$app->session;
    	$session->set('activity', $this->activity);
    	$bulk_steps = array();
    	$form_data = Yii::$app->request->post('FormBuilder');
    	
//     	echo '<pre>';print_r($form_data);exit;
    	   
//     	if($form_data['step_3_require'] == 0) {
//     		$flash = Yii::$app->session->setFlash('minimum2','Minimu 2 fields required for step3');
//     		//$this->addError('step_3_require', 'Minimum 2 fields required for step3');
//     		return false;
//     	} else {
//     		return true;
//     	}
    	$activity_value = $form_data['activity'];
    	unset($form_data['step_3_require']);
    	unset($form_data['company_id'],$form_data['activity']);
    	if(!empty($form_data)) {
    		foreach ($form_data as $key => $data) {
    			$steps_array = explode('_',$key);
    		 	if($steps_array['1'] == 3) {
    				$bulk_steps['step3'][$steps_array['2']][] = $data;
    			} 
    		}
    	}
    	if (!empty($bulk_steps)) {
    		foreach($bulk_steps as $steps) {
    			foreach($steps as $array) {
    				//echo '<pre>';print_r($array);exit;
    				$batchinsert[] = $array;
    			}
    		}
    	}
    	if(!empty($batchinsert)) {
    		foreach($batchinsert as $batch) {
    			$require_array[] = $batch[1];
    			
    		}

    		$count_values = array_count_values($require_array);
    		
//     		echo '<pre>';print_r($count_values);exit;
    		
    		$require_values = array_keys($count_values);
    		if (in_array(0,$require_values)) {
    			if($activity_value == 1) {
    				if ($count_values[0] >= 2) {
    					//$flash = Yii::$app->session->setFlash('minimum2','Minimum 2 fields required for step3');
    					$this->addError('step_3_require', 'Minimum 2 fields required for step3');
    					return false;
    				} else {
    					return true;
    				}
    			} elseif($activity_value == 2) {
    				if ($count_values[0] >= 2) {
//     					$flash = Yii::$app->session->setFlash('minimum2','Minimum 2 fields required for step3');
    					$this->addError('step_3_require', 'Minimum 2 fields required for step3');
    					return false;
    				} else {
    					return true;
    				}
    			} elseif($activity_value == 3) {
    				if ($count_values[0] >= 3) {
//     					$flash = Yii::$app->session->setFlash('minimum2','Minimum 2 fields required for step3');
    					$this->addError('step_3_require', 'Minimum 2 fields required for step3');
    					return false;
    				} else {
    					return true;
    				}
    			} elseif($activity_value == 4) {
    				if ($count_values[0] >= 4) {
//     					$flash = Yii::$app->session->setFlash('minimum2','Minimum 2 fields required for step3');
    					$this->addError('step_3_require', 'Minimum 2 fields required for step3');
    					return false;
    				} else {
    					return true;
    				}
    			}
    		} else {
    			return true;
    		}
    	} else {
    		return true;
    	}*/
    
//     	echo '<pre>';print_r($require_values);exit;
    	
    	/* if(count($bulk_steps['step3']) <= 1) {
    		//$flash = Yii::$app->session->setFlash('minimum','Minimu 2 fields required for step3');
    		$this->addError('step_3_require', 'Minimum 2 fields required for step3');
    		return false;
    	}  */
    	
  /* }  */
}
