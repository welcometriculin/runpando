<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sub_activity".
 *
 * @property integer $sub_activity_id
 * @property integer $activity_id
 * @property string $sub_activity_name
 * @property integer $company_id
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 */
class SubActivity extends Kg
{
	public $activity_name;//for grid view column
    public $bulkactivities;//for bulk upload
    public $free_text_search;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sub_activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_id', 'sub_activity_name', 'company_id', 'created_by', 'created_date', 'updated_by', 'updated_date'], 'required'],
            [['activity_id', 'company_id', 'created_by', 'updated_by'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['sub_activity_name'], 'string', 'max' => 255],
            [['sub_activity_name'], 'uniquecheck'],
            ['bulkactivities', 'required'],
            [['bulkactivities'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, csv'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sub_activity_id' => 'Sub Activity ID',
            'activity_id' => 'Activity ID',
            'sub_activity_name' => 'Sub Activity Name',
            'company_id' => 'Company ID',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
        	'bulkactivities'=>'Bulk Activites'	
        ];
    }
     /*subactivites list for web service*/
    public static function subActivitieslist() 
    {
    	$comapny_id = Yii::$app->user->identity->input_company_id;
    	$sub_actvities_list = self::find()->select('sub_activity_id,activity_id,ucfirst(sub_activity_name) as sub_activity_name,company_id')
    										->where(['company_id' => $comapny_id, 'is_deleted' => 0])->asArray()->all();
    	return $sub_actvities_list;
    	
    }
    //for sub activity unique check
    public function uniquecheck()
    {
    	$activity_id = trim($this->activity_id);
    	$sub_activity_name = trim(strip_tags($this->sub_activity_name));
    	$comp_id = Yii::$app->user->identity->input_company_id;
    	if (Yii::$app->controller->action->id == 'create') {
    		$condition = '';
    	} else {
    		$condition = "AND guid != '".$this->guid."'";
    	}
    	$query = "SELECT sub_activity_name FROM sub_activity 
    			WHERE activity_id = '".$activity_id."' 
    			AND company_id = '".$comp_id."' 
    			AND is_deleted = 0 $condition";
    	$res_arr = Yii::$app->db->createCommand($query)
    							->queryColumn();
    	
    	if (in_array(strtolower($sub_activity_name), array_map('strtolower', $res_arr))) {
    		$this->addError('sub_activity_name', 'Already Exist');
    		return false;
    	} else {
    		return true;
    	}
    }
    //for bulk upload unique sub activities
    public function uniqueCheckUpload()
    {
    	$comp_id = Yii::$app->user->identity->input_company_id;
    	$query = "SELECT sub_activity_name FROM sub_activity
    			WHERE company_id = '".$comp_id."'
    			AND is_deleted = 0";
    	$res_arr = Yii::$app->db->createCommand($query)
    	->queryColumn();
    	$res_arr = array_map('strtolower', $res_arr);
    	return $res_arr;
    }
}
