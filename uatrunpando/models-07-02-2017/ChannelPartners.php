<?php

namespace app\models;

use Yii;
use yii\helpers\Arrayhelper;
/**
 * This is the model class for table "channel_partners".
 *
 * @property integer $id
 * @property string $channel_partner_name
 * @property integer $comp_id
 * @property integer $user_id
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 */
class ChannelPartners extends Kg
{
    /**
     * @inheritdoc
     */
	// for channel menu
	public $status; 
	public $month;
	public $product_id;
	public $product_name;
	public $liquidation_status;
	public $demand_volume;
	public $fieldforce_name;
	public $product_unit;
	public $dates_visited;
	public $target_value;
	public $actual_value;
	public $bulkretailer;
	public $season_progress;
	public $managefield;
	public $free_text_search;
	public $product;
	
    public static function tableName()
    {
        return 'channel_partners';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comp_id', 'created_by', 'created_date', 'user_id','updated_by', 'updated_date','bulkretailer','channel_partner_name'], 'required'],
            [['comp_id', 'created_by', 'updated_by'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
        	[['user_id'],'integer','message' => 'Field Force Name cannot be blank.'],
            [['channel_partner_name'], 'string', 'max' => 100],
         	[['bulkretailer'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, csv'],	
        	//[['channel_partner_name'], 'match', 'pattern' => '/^[a-zA-Z0-9\s]+$/'],
        	[['managefield'],'required','message' => 'Manager Name cannot be blank.'],
        	//['product','required']
        		
        		
        ];
    }
    public function scenarios()
    {
    	$scenarios = parent::scenarios();
    	$scenarios['bulkupload'] = ['bulkretailer'];
    	return $scenarios;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channel_partner_name' => 'Your '.(count($label_names_display = LabelNames::labelNamesDisplay()) > 0 ? ucfirst($label_names_display['partner_label']) :'Partner Name'),
            'comp_id' => 'Comp ID',
            'user_id' => 'Field Force Name',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
        	'bulkretailer' => 'Bulk '.(count($label_names_display = LabelNames::labelNamesDisplay()) > 0 ? ucfirst($label_names_display['partner_label']) :'Partners'),	
        	'product'      => (count($label_names_display = LabelNames::labelNamesDisplay()) > 0 ? ucfirst($label_names_display['product_label']) :'Product'),
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
	public static function partnersList($assign_to,$flag)
 	{

 		$user_id=Yii::$app->user->identity->id;
 		// $sql="SELECT channel_partner_name from channel_partners
 		//WHERE user_id = $assign_to and is_deleted = 0"; 
 		$sql = ChannelPartners::find()->where(['user_id' => $assign_to,'is_deleted' => 0])->orderBy('channel_partner_name')->all();
  		//return $q = Yii::$app->db->createCommand($sql)->queryAll();
 		if ($flag == 'create') {
 			$dropdown = '<option value = "" >Select Partner</option>';
 			if(!empty($sql)) {
 				foreach ($sql as $drop) {
 					$dropdown .= "<option value = '".$drop['channel_partner_name']."' >".ucfirst($drop['channel_partner_name'])."</option>";
 				}
 			}
 			//	$dropdown .='<option value = "add-new-elements" style = "background-color:#5e4091;color:white">Add New</option>';
 			return $dropdown;
 		} else {
 			return $sql;
 		}
 	}
    public static function  partnersdata($date,$id)
    {
    	$partners = array();
    	if(!$date){
    		$partners=Yii::$app->db->createCommand("select channel_partner_name from channel_partners where user_id=$id")->queryAll();
    		if(empty($partners))
    		{
    			return $partners;
    		}
    	}else{
    		$partners=Yii::$app->db->createCommand("select channel_partner_name from channel_partners where user_id=$id $date")->queryAll();
    		if(empty($partners))
    		{
    			return $partners;
    		}
    	}
    	foreach($partners as $key => $v){
    		$par[] = $v['channel_partner_name'];
    	}
    	return $par;
    }
    public static function addNewChannelPartnerSave($new_channel_partner, $assign_to)
    {
    	$company_id = Yii::$app->user->identity->input_company_id;
    	$model = new ChannelPartners();
    	$new_channel_partner_count = ChannelPartners::find()
					    	->select('COUNT(*)')
					    	->where(['channel_partner_name' => $new_channel_partner, 'comp_id' => $company_id, 'user_id' => $assign_to])
					    	->count();
    	if ($new_channel_partner_count == 0) {
    		$model->channel_partner_name = $new_channel_partner;
    		$model->comp_id = $company_id;
    		$model->user_id = $assign_to;
    		$model->save(false);
    	}
    }
    //for web channel menu
    public static function channelPartnersList()
    {
    	$user_id = Yii::$app->user->identity->id;
    	$partners_list = self::find()->select('ch.channel_partner_name')
    								->from("channel_partners ch")
    								->innerJoin("users u","ch.user_id = u.id")
    								->where("u.reporting_user_id = $user_id")
    								->asArray()
    								->all();
    			return $partners_list;
    }
    
    //for web channel menu current year months till date
    public static function currentYearMonthsList()
    {
    	$months = array();
    	$current_month = date('m');
		for ($i = 0; $i < $current_month; $i++) {
			$month_numbers = date('m', strtotime(date( 'Y-m-01' )." -$i months"));
			$month_names = date('M', strtotime(date( 'Y-m-01' )." -$i months"));
			$months[$month_numbers] = $month_names;
		}
		ksort($months);
    	return $months;
    }
    //for check retailer in web 
    public function uniqueRetailer()
    {
    	$village_name_check = ChannelPartners::find()->select('count(*)')->where(['channel_partner_name' => trim($this->channel_partner_name),'user_id' => $this->user_id])->count();
    	if($village_name_check > 0) {
    		$this->addError('channel_partner_name', 'user already have this partner');
    		return false;
    	} else {
    		return true;
    	}
    }
    public function uniqueRetailersUpload($email)
    {
    	$user = Users::find()->select('id')->where(['email_address' => $email])->asArray()->one();
    	$user_id = $user['id'];
    	$comp_id = Yii::$app->user->identity->input_company_id;
    	$query = "SELECT channel_partner_name FROM channel_partners
    				  WHERE comp_id = '".$comp_id."' and user_id = '".$user_id."'
    				  AND is_deleted = 0";
    	$res_arr = Yii::$app->db->createCommand($query)
    	->queryColumn();
    	$res_arr = array_map('strtolower', $res_arr);
    	return $res_arr;
    }
    //for fav web services
    public function masertRetailers()
    {
    	$user_id = Yii::$app->user->identity->id;
    	$sql = 'SELECT ch.id, ch.comp_id, ch.channel_partner_name, IF(fch.channel_partner_id, 1, 0) AS is_fav 
    			FROM channel_partners ch
    			LEFT JOIN fav_channelpartners fch ON fch.channel_partner_id = ch.id
                WHERE ch.user_id = "'.$user_id.'"
    			AND ch.is_deleted = 0
                ORDER BY ch.channel_partner_name';
    	$master_data = Yii::$app->db->createCommand($sql)->queryAll();
    	return $master_data;
    }
    // forbatches page
    public static function RetailerList()
    {
    	$user_id = Yii::$app->user->identity->id;
    	$partners_list = self::find()->select('ch.id,ch.channel_partner_name')
    	->from("channel_partners ch")
    	->innerJoin("users u","ch.user_id = u.id")
    	->where("u.reporting_user_id = $user_id")
    	->asArray()
    	->all();
    	$retailerList = ArrayHelper::map($partners_list, 'id', 'channel_partner_name');
    	return $retailerList;
    }
}
