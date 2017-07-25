<?php

namespace app\api\modules\v4\models;

use Yii;
use yii\helpers\Arrayhelper;
/**
 * This is the model class for table "crops".
 *
 * @property integer $id
 * @property string $crop_name
 * @property integer $comp_id
 * @property integer $user_id
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 *
 * @property Users $user
 * @property InputCompanies $comp
 */
class Crops extends Kg
{
	public $bulkcrops;
	public $free_text_search;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'crops';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['crop_name', 'comp_id', 'user_id', 'created_by', 'created_date', 'updated_by', 'updated_date'], 'required'],
            [['comp_id', 'user_id', 'created_by', 'updated_by', 'role_id'], 'integer'],
            [['created_date', 'updated_date', 'role_id'], 'safe'],
            [['crop_name'], 'string', 'max' => 100],
            [['crop_name'], 'uniqueCrops'],
            ['bulkcrops', 'required'],
            [['bulkcrops'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, csv'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'crop_name' => (count($label_names_display = LabelNames::labelNamesDisplay()) > 0 ? ucfirst($label_names_display['crop_label']) :'Crop').' Name',
            'comp_id' => 'Comp ID',
            'user_id' => 'User ID',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'role_id' => 'Role Id',
        	'bulkcrops' => 'Bulk '.(count($label_names_display = LabelNames::labelNamesDisplay()) > 0 ? ucfirst($label_names_display['crop_label']) :'Crops'),	
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComp()
    {
        return $this->hasOne(InputCompanies::className(), ['id' => 'comp_id']);
    }
    /* public static function cropList($assign_to, $flag)
    {
    	$list = self::find()->select('id, crop_name')->where(['user_id' => $assign_to])->asArray()->all();
    	if ($flag == 'create') {
    	$dropdown = '<option value = "" >Select Crop </option>';
    	if(!empty($list)) {
    		foreach ($list as $drop) {
    			$dropdown .= "<option value = '".$drop['crop_name']."' >".$drop['crop_name']."</option>";
    		}
    	}
    	$dropdown .='<option value = "add-new-elements" style = "background-color:#5e4091;color:white">Add New</option>';
    	return $dropdown;
    	} else {
    		return $list;
    	}
    	/* $user_id = Yii::$app->user->identity->id;
    	$sql="SELECT c.crop_name from users u
		JOIN crops c ON c.user_id = u.id where u.reporting_user_id = $user_id";
    	return $q = Yii::$app->db->createCommand($sql)->queryAll(); */
    	//return $list=self::find()->select('crop_name,id')->where(['comp_id'=>$company_id])->all();
   /* } */
    //for web crops dropdown build plan
    public static function cropList()
    {
    	$company_id = Yii::$app->user->identity->input_company_id;
    	$list = self::find()->select('id, crop_name')->where(['comp_id' => $company_id, 'is_deleted' => 0])->andWhere(['!=', 'role_id', 0])->orderBy(['crop_name' => SORT_ASC])->all();
    	$listData = ArrayHelper::map($list, 'id', 'crop_name');
    	return $listData;
    }
    
    public static function cropsData($date,$id)
    {
    $crops = array();
    	if(!$date){
    		$crops=Yii::$app->db->createCommand("select crop_name from crops where user_id=$id")->queryAll();
    		if(empty($crops))
    		{
    			return $crops;
    		}
    	}else{
    		$crops=Yii::$app->db->createCommand("select crop_name from crops where user_id=$id $date")->queryAll();
    		if(empty($crops))
    		{
    			return $crops;
    		}
    	}
    	foreach($crops as $key => $v){
    		$crop[] = $v['crop_name'];
    	}	
    	return $crop;
    }
    
    public static function addNewCropSave($new_crop, $assign_to)
    {
    	$company_id = Yii::$app->user->identity->input_company_id;
    	$model = new Crops();
    	$new_crop_count = Crops::find()
				    	->select('COUNT(*)')
				    	->where(['crop_name' => $new_crop, 'comp_id' => $company_id, 'user_id' => $assign_to])
				    	->count();
    	if ($new_crop_count == 0) {
    		$model->crop_name = $new_crop;
    		$model->comp_id = $company_id;
    		$model->user_id = $assign_to;
    		$model->save(false);
    	}
    }
    /* master crops web service  start */ 
    public static function masteCrops()
    {
    	$company_id = Yii::$app->user->identity->input_company_id;
    	$user_id = Yii::$app->user->identity->id;
    	/*$master_data = Crops::find()->select("c.id,c.crop_name,c.comp_id,IF(fc.crop_id, '`1`' ,'`0`') as is_fav")
    								->from('crops c')
    								->leftJoin('fav_crops fc','fc.crop_id = c.id')
    								->where(['c.comp_ids' => $company_id])->andWhere(['!=','c.role_id',0])
    								->asArray()->all();*/
    	$sql = "SELECT c.id, c.crop_name, c.comp_id, IF(fc.crop_id, 1, 0) AS is_fav 
    			FROM crops c 
    			LEFT JOIN fav_crops fc ON fc.crop_id = c.id AND fc.user_id = $user_id
    			WHERE c.comp_id = $company_id 
    			AND c.role_id != 0
    			AND c.is_deleted = 0
    			ORDER BY c.crop_name";
    	$master_data = Yii::$app->db->createCommand($sql)->queryAll();
		return $master_data;
    }
    /* master crops web service  end */
    
    //for sub crops unique check
    public function uniqueCrops()
    {
    	$crop_name = strip_tags(trim($this->crop_name));
    	$comp_id = Yii::$app->user->identity->input_company_id;
    	if (Yii::$app->controller->action->id == 'create') {
    		$condition = '';
    	} else {
    		$condition = "AND guid != '".$this->guid."'";
    	}
    	$query = "SELECT crop_name FROM crops
    	WHERE comp_id = '".$comp_id."'
        AND is_deleted = 0 
    	AND role_id != 0 $condition";
    	$res_arr = Yii::$app->db->createCommand($query)
    	->queryColumn();
    	 
    	if (in_array(strtolower($crop_name), array_map('strtolower', $res_arr))) {
    		$this->addError('crop_name', 'Already Exist');
    		return false;
    	} else {
    		return true;
    	}
    }
    //for bulk upload unique crops
    public function uniqueCropsUpload()
    {
    	$comp_id = Yii::$app->user->identity->input_company_id;
    	$query = "SELECT crop_name FROM crops
    			WHERE comp_id = '".$comp_id."'
    			AND is_deleted = 0";
    	$res_arr = Yii::$app->db->createCommand($query)
    	->queryColumn();
    	$res_arr = array_map('strtolower', $res_arr);
    	return $res_arr;
    }
}
