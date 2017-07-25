<?php

namespace app\models;

use Yii;
use app\models\Villages;
/**
 * This is the model class for table "villages".
 *
 * @property integer $id
 * @property string $guid
 * @property string $village_name
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
class Villages extends  Kg
{
	
	const IS_DELETED = 0;
	public $bulkvillages;
	public $managefield;
	public $free_text_search;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'villages';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
    	$scenarios = parent::scenarios();
    	$scenarios['bulkupload'] = ['bulkvillages'];
    	$scenarios['villagescreate'] = ['village_name','user_id','managefield'];
    	return $scenarios;
    }
    
    public function rules()
    {
        return [
            [['guid', 'village_name', 'user_id','comp_id','created_by', 'created_date', 'updated_by', 'updated_date','bulkvillages'], 'required'],
            [['comp_id', 'created_by', 'updated_by'], 'integer'],
        	[['user_id'],'integer','message' => 'Field Force Name cannot be blank.'],	
            [['created_date', 'updated_date'], 'safe'],
            [['guid', 'village_name'], 'string', 'max' => 100],
        	[['bulkvillages'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, csv'],
        	//[['village_name'], 'match', 'pattern' => '/^[a-zA-Z0-9\s]+$/'],
        	[['managefield'],'required','message' => 'Manager Name cannot be blank.'],
        		
        		
        		
                ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'guid' => 'Guid',
            'village_name' => (count($label_names_display = LabelNames::labelNamesDisplay()) > 0 ? ucfirst($label_names_display['village_label']) :'Village').' Name',
            'comp_id' => 'Comp ID',
            'user_id' => 'Field Force Name',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
        	'bulkvillages' =>'Bulk '.(count($label_names_display = LabelNames::labelNamesDisplay()) > 0 ? ucfirst($label_names_display['village_label']) :'Villages'),	
        ];
    }
public function uniqueVillage()
{
		/* $village_name_check = Villages::find()
										->select('count(*)')
										->where(['village_name' => $this->village_name,'user_id' => $this->user_id])
										->count(); */
		
		$village_name_check = (new \yii\db\Query())
											->from('villages v')
											->select('count(v.*)')
											->innerJoin('villages_master vm','vm.village_id = v.village_id')
											->where(['vm.village_name' => trim($this->village_name),'v.user_id' => $this->user_id])
											->count();
		if($village_name_check > 0) {
			$this->addError('village_name', 'user already have this village');
			return false;
		} else {
			return true;
		}
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

    
    public static function villageList($assign_to, $flag)
    {
    	
    /* 	$list = self::find()->select('id, village_name')
    						->where(['user_id' => $assign_to])
    						->orderBy(['village_name' => SORT_ASC])
    						->groupBy('village_name')->asArray()->all(); */
    	$list = (new \yii\db\Query())
		    	->select('mv.village_id, mv.village_name')
		    	->from('villages v')
		    	->innerJoin('villages_master mv','mv.village_id = v.village_id')
		    	->where(['v.user_id' => $assign_to,'v.is_deleted' => Villages::IS_DELETED])
		    	->orderBy(['mv.village_name' => SORT_ASC])
		    	->groupBy('mv.village_name')->all();
    	if ($flag == 'create') {
   			$dropdown = '<option value = "" >Select Village </option>';
    		if(!empty($list)) {
    			foreach ($list as $drop) {
    				$dropdown .= "<option value = '".$drop['village_id']."' >".$drop['village_name']."</option>";
    			}
    		}
    	//	$dropdown .='<option value = "add-new-elements" style = "background-color:#5e4091;color:white">Add New</option>';
    		return $dropdown;
    	} else {
    		return $list;
    	}
    	
    	/* $user_id=Yii::$app->user->identity->id;
    	
    	$sql="SELECT v.village_name from users u 
	JOIN villages v ON v.user_id = u.id where u.reporting_user_id = $user_id";
    	return $q = Yii::$app->db->createCommand($sql)->queryAll(); */
    	//return $list=self::find()->select('village_name,id')->where(['user_id'=>$user_id])->all();	
    }
    //list of villages services
    public static function  villageData($date,$id)
    {
    	$villages = array();
    	if (!$date) {
    		$villages = Yii::$app->db->createCommand("SELECT village_name FROM villages WHERE user_id = $id")->queryAll();
    		if (empty($villages)) {
    			return $villages;
    		}
    	} else {
    		$villages = Yii::$app->db->createCommand("SELECT village_name FROM villages WHERE user_id = $id $date")->queryAll();
    		if (empty($villages)) {
    			return $villages;
    		}
    	}	
    	foreach ($villages as $key => $v) {
    		$vil[] = $v['village_name'];
    	}
    	return $vil;
    }
    
    public static function addNewVillageSave($new_village, $assign_to)
    {
    	$company_id = Yii::$app->user->identity->input_company_id;
    	$model = new Villages();
    	$new_village_count = Villages::find()
					    	->select('COUNT(*)')
					    	->where(['village_name' => $new_village, 'comp_id' => $company_id, 'user_id' => $assign_to])
					    	->count();
    	if ($new_village_count == 0) {
    		$model->village_name = $new_village;
    		$model->comp_id = $company_id;
    		$model->user_id = $assign_to;
    		$model->save(false);
    	}
    }
    public function uniqueVillagesUpload($email) 
    {
		   $user = Users::find()->select('id')->where(['email_address' => $email])->asArray()->one();
		   $user_id = $user['id'];
		   $comp_id = Yii::$app->user->identity->input_company_id;
		   $query = "SELECT vm.village_name FROM villages v
		   			JOIN villages_master vm ON vm.village_id = v.village_id
    				  WHERE v.comp_id = '".$comp_id."' and v.user_id = '".$user_id."'
    				  AND v.is_deleted = 0";
    		$res_arr = Yii::$app->db->createCommand($query)
    									->queryColumn();
    	$res_arr = array_map('strtolower', $res_arr);
//     	echo '<pre>';print_r($res_arr);exit;
    	return $res_arr; 
    }
    //webservice for fav villages
    public function  masterVillages()
    {
    	$user_id = Yii::$app->user->identity->id;
    	$sql = 'SELECT mv.village_id as id, v.comp_id,mv.village_name, IF(fv.village_id, 1, 0) AS is_fav
    	FROM villages v
    	JOIN villages_master mv ON mv.village_id = v.village_id 		
    	LEFT JOIN fav_villages fv ON fv.village_id = v.village_id and v.user_id = fv.user_id
    	where v.user_id = "'.$user_id.'"
    	AND v.is_deleted = 0
    	group by v.user_id,v.village_id		
    	order by mv.village_name';
    	$master_data = Yii::$app->db->createCommand($sql)->queryAll();
    	return $master_data; 
    }
    
}
