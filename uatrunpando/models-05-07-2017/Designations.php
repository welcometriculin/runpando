<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "designations".
 *
 * @property integer $designation_id
 * @property string $guid
 * @property string $designation_name
 * @property integer $company_id
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_date
 * @property string $updated_date
 */
class Designations extends Kg
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'designations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'created_by', 'updated_by', 'created_date', 'updated_date','designation_name'], 'required'],
           // [['company_id', 'created_by', 'updated_by'], 'integer'],
            [['created_date', 'updated_date','created_by', 'updated_by'], 'safe'],
            [['designation_name'], 'string', 'max' => 255],
           // [['designation_name'], 'unique', 'targetAttribute' => ['designation_name', 'company_id'], 'message' => 'The combination of Designation Name and Company ID has already been taken.'],
           
           ['designation_name','trim'],
       //  ['designation_name','designationDupliacte'],
        		
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'designation_id' => Yii::t('app', 'Designation ID'),
            'guid' => Yii::t('app', 'Guid'),
            'designation_name' => Yii::t('app', 'Designation'),
            'company_id' => Yii::t('app', 'Company ID'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_date' => Yii::t('app', 'Created Date'),
            'updated_date' => Yii::t('app', 'Updated Date'),
        ];
    }
    public static function designationList($flag)
    {
    	$desigList = Designations::find()->where(['company_id' =>Yii::$app->user->identity->input_company_id,'is_deleted' => 0])->orderBy('designation_name ASC')->all();
    	if($flag == 'create') {
    		$desigList = ArrayHelper::map($desigList, 'designation_id','designation_name');
    	} elseif($flag == 'upload') {
    		$desigList = ArrayHelper::map($desigList, 'designation_id', function ($element) {
    			return strtolower($element['designation_name']);
    		});
    	}
    	 
    	return $desigList;
    }
    public static function designationName($did)
    {
    	$designation = Designations::find()->select('designation_name')->where(['designation_id'=>$did])->column();
    	if(empty($designation)) {
    		return $designation = '';
    	} else {
    		return $designation[0];
    	}
    }
    public function designationDupliacte()
    {
    	
   		 $controller = strtolower(Yii::$app->controller->id);
    	 $action = strtolower(Yii::$app->controller->action->id);
			if($controller == 'designation' && $action == 'create') {
				$deignationCheck = Designations::find()->select('designation_names')->where(['designation_name'=>$this->designation_name,'company_id' => Yii::$app->user->identity->input_company_id])->count();
				
				if($deignationCheck > 0) {
		    	$this->addError('designation_name', 'Designation already exist');
		    	return false;
			    } else {
			    	return true;
			    }
			} else {
				//echo $deignationCheck;exit;
				$deignationCheck = Designations::find()->select('designation_names')->where(['designation_name'=>$this->designation_name,'company_id' => Yii::$app->user->identity->input_company_id])->andWhere(['!=','guid',$this->guid])->count();
				//echo $deignationCheck;exit;
				if($deignationCheck == 1) {
					$this->addError('designation_name', 'Designation already exist');
					return false;
				} else if($deignationCheck < 1) {
					return true;
				}
			}
    }
}
