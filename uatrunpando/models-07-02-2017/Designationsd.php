<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "designations".
 *
 * @property integer $designation_id
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
            [['company_id', 'created_by', 'updated_by', 'created_date', 'updated_date','designation_name','company_id'], 'required'],
            [['company_id', 'created_by', 'updated_by'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['designation_name'], 'string', 'max' => 255],
            [['designation_name'], 'unique', 'targetAttribute' => ['designation_name','company_id'], 'message' => 'Designation has already been taken.'],
        ]; 
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'designation_id' => Yii::t('app', 'Designation ID'),
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
    	$desigList = Designations::find()->where(['company_id' =>Yii::$app->user->identity->input_company_id])->all();
    	 if($flag == 'create') {
    		$desigList = ArrayHelper::map($desigList, 'designation_id','designation_name');
    	} elseif($flag == 'upload') {
    		$desigList = ArrayHelper::map($desigList, 'designation_id', function ($element) {
  			return strtolower($element['designation_name']);
  		});
    	} 
    	
    	return $desigList;
    }
}
