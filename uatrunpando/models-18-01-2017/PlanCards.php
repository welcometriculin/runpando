<?php

namespace app\models;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\helpers\BaseFileHelper;
use yii\helpers\ArrayHelper;
use Yii;
use yii\db\Query;
use app\models\Roles;
use app\models\LabelNames;


/**
 * This is the model class for table "plan_cards".
 *
 * @property integer $id
 * @property integer $assign_to
 * @property string $card_type
 * @property string $planned_date
 * @property string $crop_name
 * @property string $channel_partner
 * @property string $village_name
 * @property string $activity
 * @property string $status
 * @property string $created_date
 * @property integer $created_by
 * @property string $updated_date
 * @property integer $updated_by
 *
 * @property CampaignCardActivities[] $campaignCardActivities
 * @property ChannelCardActivities[] $channelCardActivities
 * @property ChannelCardActivities[] $channelCardActivities0
 * @property Users $assignTo
 */
class PlanCards extends Kg
{
	/**
	 * @inheritdoc
	 */
	/*public function behaviors()
	 {
	return [
	[
	'class' => TimestampBehavior::className(),
	'createdAtAttribute' => 'created_date',
	'updatedAtAttribute' => 'updated_date',
	'value' => new Expression('NOW()'),
	],
	];
	}*/
	public $page;
	public $employee_number;
	public $assignee;//for plan page
	public $createdby;
	public $assignee_name; //for history page
	public $add_new_elements;//for new village,crop,product adding
	public $free_text_search;//for keyword search

	public static function tableName()
	{
		return 'plan_cards';
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios()
	{
		$scenarios = parent::scenarios();
		//$scenarios['signin'] = ['username', 'password'];
		$scenarios['create'] = ['planned_date', 'assign_to', 'crop_id', 'activity','channel_partner','product_id','village_id'];
		$scenarios['update'] = ['planned_date', 'assign_to', 'crop_id', 'activity','product_id','status','plan_approval_status','updated_by','village_id','channel_partner'];
		return $scenarios;
	}
	public function rules()
	{
		return [
		[['assign_to', 'card_type', 'planned_date', 'channel_partner', 'village_id','activity','status','lat_position',
		'long_position','location_name','plan_approval_status','created_date', 'created_by', 'updated_date', 'updated_by', 'add_new_elements'], 'required'],
		[['crop_id'], 'required'],
		[['product_id'], 'required'],
		[['crop_id', 'product_id','village_id','order_number'], 'integer'],
		[['card_type', 'activity', 'status','plan_approval_status'], 'string'],
		[['planned_date', 'created_date', 'updated_date', 'planned_date', 'card_type'], 'safe'],
		[['crop_name', 'channel_partner'], 'string', 'max' => 255],
		//['planned_date','pdate'],
		[['village_name'], 'string', 'max' => 50]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
		'id' => 'ID',
		'assign_to' => 'Assign To',
		'card_type' => 'Card Type',
		'planned_date' => 'Date',
		'crop_name' => 'Crop Name',
		'channel_partner' => (count($label_names_display = LabelNames::labelNamesDisplay()) > 0 ? ucfirst($label_names_display['partner_label']) :'Partner'),
		'village_name' => 'Village',
		'activity' => 'Activity',
		'status' => 'Status',
		'created_date' => 'Created Date',
		'created_by' => 'Created By',
		'updated_date' => 'Updated Date',
		'updated_by' => 'Updated By',
		'plan_approval_status'=>'Plan Approval Status',
		'product_name'=>'Product Name',
		'crop_id' => (count($label_names_display = LabelNames::labelNamesDisplay()) > 0 ? ucfirst($label_names_display['crop_label']) :'Crop'),
		'product_id' => (count($label_names_display = LabelNames::labelNamesDisplay()) > 0 ? ucfirst($label_names_display['product_label']) :'Product'),
		'village_id'=> (count($label_names_display = LabelNames::labelNamesDisplay()) > 0 ? ucfirst($label_names_display['village_label']) :'Village')
		];
	}

	public function fields()
	{
		return [
		// field name is the same as the attribute name
		'id',
		'activity' => 'activity',
		'village_name' => 'village_name',
		'crop_name'		=>'crop_name',
		'planned_date'  =>'planned_date',
		'status'		=>'status',
		'product_name'  =>'product_name',
		];
	}
	/* public function extraFields()
	 {
	return ['CampaignCardActivities'];
	}*/
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCampaignCardActivities()
	{
		return $this->hasMany(CampaignCardActivities::className(), ['plan_card_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getChannelCardActivities()
	{
		return $this->hasMany(ChannelCardActivities::className(), ['plan_card_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getChannelCardActivities0()
	{
		return $this->hasMany(ChannelCardActivities::className(), ['plan_card_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getAssignTo()
	{
		return $this->hasOne(Users::className(), ['id' => 'assign_to']);
	}


	public static function Userslist()
	{
		$id = Yii::$app->user->identity->id;
		$ffofficer_role_id = Roles::FIELDFORCE;
		$query = new \yii\db\Query();
		$query->select('uu.id,uu.first_name,uu.email_address')
		->from('users u')
		->innerJoin('users uu', 'u.id = uu.reporting_user_id')
		->where(['u.id' => $id, 'uu.roleid' => $ffofficer_role_id, 'uu.status' => 'active'])
		->andWhere(['or', 'uu.is_deleted = 0', 'uu.is_blocked = 0'])
		->andWhere(['!=', 'uu.id', $id]);
		$query = $query->createCommand();
		$queryresp = $query->queryAll();
		$listData = ArrayHelper::map($queryresp,'id',function ($element) {
			return $element['first_name'] . ' ('. $element['email_address'].')';
		});
		return $listData;
	}
	public static function Campcard($id)
	{
		return CampaignCardActivities::findOne($id);
	}

	public static function createUser()
	{
		$id=Yii::$app->user->identity->id;
		$sql=Users::find()->select('first_name')->where(['id'=>$id])->one();
		return $sql->first_name;
	}
	public static function updateUser($id)
	{
			
		$query = new \yii\db\Query;
		$query->select('u.first_name as updatedby,uu.first_name as createdby')
		->from('plan_cards p')
		->innerJoin('users u','p.updated_by=u.id')
		->innerJoin('users uu','p.created_by=uu.id')
		->where(['p.guid'=>$id]);
		$command = $query->createCommand();
		return $response = $command->queryOne();
	}
	public static function planType($planned_date,$time_stamp)
	{
		$timeStamp = $time_stamp;
		$ct =strtotime($timeStamp);
		$plannedDate = $planned_date;
		$pDate =strtotime($plannedDate);
		$cwf = date("Y-m-d 12:30:00", strtotime( "this week friday" ));
		$cwf = strtotime($cwf);
		$cws = date("Y-m-d 23:59:59", strtotime( "this week sunday" ));
		$cws = strtotime($cws);
		$nws = date("Y-m-d 23:59:59", strtotime( "next week sunday" ));
		$nws = strtotime($nws);
		if(($pDate <= $cws) || ($pDate > $cws && $pDate < $nws && $ct > $cwf)){
			return  'adhoc';
		}else{
			return  'planned';
		}

	}

}
