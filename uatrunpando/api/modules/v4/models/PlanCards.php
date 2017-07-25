<?php

namespace app\api\modules\v4\models;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\helpers\BaseFileHelper;
use yii\helpers\ArrayHelper;
use Yii;
use yii\db\Query;
use app\api\modules\v4\models\Roles;
use app\api\modules\v4\models\LabelNames;
use app\api\modules\v4\models\UserTravellog;


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
		[['crop_id', 'product_id','village_id','order_number','channel_partner_id'], 'integer'],
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
	/* pending cards list service start */
	public static function getAllCards($date)
	{
		$user_id = Yii::$app->user->identity->id;
		if(!$date){
			$st='not_submitted';
			$check_id = self::find()->where(['assign_to'=>$user_id])->all();
			if(count($check_id)>0)
			{
				$sql = "SELECT p.id,IF(p.updated_by ='".$user_id."','self','manager') as created_by, p.assign_to, p.planned_date, p.product_id, p.plan_type, IF(p.activity ='Channel Card','Partner Visit',p.activity) as activity, ifnull(ucfirst(mv.village_name),'') as village_name, p.crop_id, p.channel_partner, p.status, ifnull(c.crop_name,'') as crop_name, ifnull(pr.product_name,'') as product_name
						FROM plan_cards p
						LEFT JOIN crops c on c.id = p.crop_id
						LEFT JOIN products pr on pr.id = p.product_id
						LEFT JOIN villages_master mv on mv.village_id = p.village_id
						WHERE p.assign_to='".$user_id."'
								and (p.status='not_submitted' or p.status='rejected')
								and p.is_deleted = 0
								order by p.id desc";
				$cards = Yii::$app->db->createCommand($sql)->queryAll();
				//$info = self::find()->where(['assign_to'=>$user_id,'status'=>$st,'is_deleted'=>0])->orWhere(['status'=>'rejected'])->all();
				if(count($cards)== 0){
					return ['message'=> 'No Results Found', 'status' => true,'time_stamp'=> date('Y-m-d H:i:s')];
				}else{
					return ['data'=> $cards, 'status' => true,'time_stamp'=> date('Y-m-d H:i:s')];
				}
			}else{
				return ['message'=>'No Results Found', 'status' => true];
			}
		}else {
			$sql = "SELECT p.id,IF(p.updated_by ='".$user_id."','self','manager') as created_by, p.assign_to, p.planned_date, p.product_id, p.plan_type, IF(p.activity ='Channel Card','Partner Visit',p.activity) as activity, ifnull(ucfirst(mv.village_name),'') as village_name, p.crop_id, p.channel_partner, p.status, ifnull(c.crop_name,'') as crop_name, ifnull(pr.product_name,'') as product_name
					FROM plan_cards p
					LEFT JOIN crops c on c.id = p.crop_id
					LEFT JOIN products pr on pr.id = p.product_id
					LEFT JOIN villages_master mv on mv.village_id = p.village_id
					WHERE p.assign_to='".$user_id."'
					and (p.status='not_submitted' or p.status='rejected')
					and p.is_deleted = 0 $date
					order by p.id desc";
			$cards = Yii::$app->db->createCommand($sql)->queryAll();
			return ['data'=>$cards,'status'=>true,'time_stamp'=> date('Y-m-d H:i:s')];

		}

	}
	/* pending cards list service end */
	
	/* getting address service start */ 
	public static function getAddress($lat, $lon){
		$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=". $lat.",".$lon."&sensor=false";
		$json = @file_get_contents($url);
		$data = json_decode($json);
		$status = $data->status;
		$address = '';
		if($status == "OK"){
			$address = $data->results[0]->formatted_address;
		}
		return $address;
	}
	/* getting address service end */
	
/* web service for campign card submission start */
	public static function dataSubmit($params,$id)
	{
		$model1 = new CampaignCardActivities();
		$model2 = new PlanCards();
		$data = $params['data'];
		$card_id = $params['data']['plan_card_id'];
		$images = $params['images'];
		$lat = $data['lat_position'];
		$long = $data['long_position'];
		$prev_lat = $data['prev_lat_position'];
		$prev_long = $data['prev_long_position'];
		$distance_location = UserTravellog::getDistance($lat,$long,$prev_lat,$prev_long);
		$distance = $distance_location['distnace'];
		$location = $distance_location['location'];
		/* $distance = 1;
		$location = 'raybiz'; */
		$orderValue = $data['order_number'];
		$timeStampV = date("Y-m-d H:i:s", $data['mobile_timestamp']/1000);
		$start_time = UserTravellog::travellogstart_time($data['mobile_timestamp']);            //usertravellog start_time
		$card_status_before_submit = PlanCards::find()->select('status')->where(['id' => $card_id])->one();
		if ($card_status_before_submit['status'] != 'rejected') {

			$de_images = self::decodeImage($images,$id);
			if($data['activity']!='Partner Visit')
			{
				$model1->userid = $id;
				if (array_key_exists("activity",$data))
				{
					unset($data['activity'],$data['lat_position'],$data['long_position'],$data['location_name']);
				}
				$last_insert_id = CampaignCardActivities::find()->select('id')->orderBy('id DESC')->one();
				$model1->mobile_timestamp = $last_insert_id['id'] + 1;
				$model1->mode = 'online';
				$model1->attributes = $data;
				$s=$model1->attributes;
				$pic='picture';
				$j=1;
				for($i=0; $i<count($de_images); $i++)
				{
					$pictures = $pic.$j;
					$uri=$pictures.'_uri';
				 $model1->$pictures = end((explode("/",$de_images[$i])));
				 $model1->$uri = str_replace(end((explode("/",$de_images[$i]))),'',str_replace('../web/','',$de_images[$i]));
				 $j++;
				}

				$s = $model1->save(false);
				if(!$s) {
					$res = 'plan card not inserting failure';
				} else {
					$res = 'plan cards submitted successfully';
					$command = yii::$app->db->createCommand('UPDATE plan_cards SET status="submitted", submission_mode = "online", lat_position ='.$lat.',long_position ='.$long.',location_name = "'.$location.'", updated_date="'.$timeStampV.'",distance_travelled = "'.$distance.'", start_time = "'.$start_time.'",order_number = "'.$orderValue.'" WHERE id="'.$card_id.'"');
					$command->execute();
				}
			} else {
				$res = 'channel card activity';
			}
		}
		else {
			$res = 'Card is rejected';
		}
		return $res;
	}
	public static function decodeImage($images,$id)
	{
		$file = $im = array();
		$comp_id =  Yii::$app->user->identity->input_company_id;
		$com_path ='../web/field_images/'.$comp_id.'/';
		$user_path ='../web/field_images/'.$comp_id.'/'.$id.'/';
		$i = 0;
		foreach($images as $image)
		{
			if($image){
				header("Content-type:jpg");
				$data = base64_decode($image);
				if(!is_dir($com_path))
				{
					BaseFileHelper::createDirectory($com_path, $mode = 0777, $recursive = true );
					BaseFileHelper::createDirectory($user_path, $mode = 0777, $recursive = true );
					$file = $user_path.date("Ymdhis").uniqid().'.jpg';
				}
				else{
					if(!is_dir($user_path))
					{
						BaseFileHelper::createDirectory($user_path, $mode = 0777, $recursive = true );
						$file = $user_path.date("Ymdhis").uniqid().'.jpg';
					}else{
						$file = $user_path.date("Ymdhis").uniqid().'.jpg';
					}
				}
				$imageSave = file_put_contents($file, $data);
				$im[] = $file;
					
			}
		}
		return $im;
			
	}
	/* web service for campign card submission end */
	
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

	public static function synCards($cards)
	{
		$user_id = Yii::$app->user->identity->id;
		foreach($cards as $card)
		{
			$plan_date = date("Y-m-d", strtotime($card['planned_date']));
			$plan_type=PlanCards::planType($plan_date,date('Y-m-d H:i:s'));
			$model=new PlanCards;
			if($card['activity'] == "Channel Card")
			{
				$model->card_type = 'channel card';
			}
			$model->assign_to = $user_id;
			$model->plan_type = $plan_type;
			$model->planned_date = $plan_date;
			$model->attributes=$card;
			$res= PlanCards::cardCreate($card);
			if (!$model->save(false)) {
				$check = 0;
			} else {
				$check = 1;
			}
		}
		return $check;
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

	public static function cardCreate($params)
	{
			
		$id = Yii::$app->user->identity->id;
		$comp_id = Yii::$app->user->identity->input_company_id;
		//$q = Yii::$app->db->createCommand('select input_company_id from users where id='.$id)->queryOne();

		//     	$model=new Crops();
		$model1=new Villages();
		//     	$model2=new Products();
		$model3 = new ChannelPartners();
		/* 	$model->crop_name = $params['crop_name'];
		 $model->comp_id = $q['input_company_id'];
		$model->user_id = $id; */
			
		$model1->user_id = $id;
		$model1->comp_id = $comp_id;
		$model1->village_name = $params['village_name'];
			
		/* 	$model2->user_id = $id;
		 $model2->comp_id = $q['input_company_id'];
		$model2->product_name = $params['product_name']; */
			
		$model3->user_id = $id;
		$model3->comp_id = $comp_id;
		$model3->channel_partner_name = $params['channel_partner'];
			
		//$count=Yii::$app->db->createCommand("select count(*) from crops where crop_name = '".addslashes($params['crop_name'])."' and user_id='".$id."'")->queryScalar();
		$count1=Yii::$app->db->createCommand("select count(*) from villages where village_name = '".addslashes($params['village_name'])."' and user_id='".$id."'")->queryScalar();
		//$count2=Yii::$app->db->createCommand("select count(*) from products where product_name = '".addslashes($params['product_name'])."' and user_id='".$id."'")->queryScalar();
		$count3=Yii::$app->db->createCommand("select count(*) from channel_partners where channel_partner_name = '".addslashes($params['channel_partner'])."' and user_id='".$id."'")->queryScalar();

		/* if($count<1 && $params['crop_name'] != '')
		 {
		$model->save(false);
		} */
		if($count1<1 && $params['village_name']  != '')
		{
			$model1->save(false);
		}
		/* if($count2<1 && $params['product_name'] != '')
		 {
		$model2->save(false);
		} */
		if($count3<1 && $params['channel_partner'] != '')
		{
			$model3->save(false);
		}
		/*  	$crops = Yii::$app->db->createCommand("select crop_name from crops where user_id='".$id."'")->queryAll();
		 $villages = Yii::$app->db->createCommand("select village_name from villages where user_id='".$id."'")->queryAll();
		$products = Yii::$app->db->createCommand("select product_name from products where user_id='".$id."'")->queryAll();
		$partners = Yii::$app->db->createCommand("select channel_partner_name from  channel_partners where user_id='".$id."'")->queryAll();

		foreach($villages as $key => $v){
		$vil[] = $v['village_name'];
		}
		foreach($crops as $key => $v){
		$crop[] = $v['crop_name'];
		}
		foreach($products as $key => $v){
		$product[] = $v['product_name'];
		}
		foreach($partners as $key => $v){
		$partner[] = $v['channel_partner_name'];
		}

		//	return ['crops'=>$crop,'villages'=>$vil,'products'=>$product,'partners' => $partner]; */

	}
	/* web service - getting plantype */
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
	/* web service - getting plantype */
	
/* web service for history service start */
	public static function completeCards($date)
	{
		$user_id = Yii::$app->user->identity->id;
		$company_id = Yii::$app->user->identity->input_company_id;
		$plancardProducts = $final_labels = array();
		if(!$date)
		{
			/*$query =new yii\db\Query;
			 $query->select("p.id,IF(p.created_by ='".$user_id."','self','manager') as created_by, p.id,p.planned_date,p.village_name,p.crop_name,p.activity,p.plan_type,p.card_type,p.status,c.picture1,c.picture2,c.picture3,
			 		c.no_of_farmers,c.no_of_female_farmers,c.no_of_retailers,c.no_of_villages,
			 		c.feedback,c.purpose,c.updated_date,c.picture1_uri,picture2_uri,picture3_uri,u.first_name as created")
			->from('plan_cards p')
			->innerJoin('users uu','p.assign_to = uu.id')
			->innerJoin('users u','p.created_by = u.id')
			->leftJoin('campaign_card_activities c','p.id =c.plan_card_id')
			->where(['p.assign_to'=>$user_id])->andWhere(['p.status'=>'submitted'])
			->orderBy(['c.id'=>SORT_DESC]);
			$command = $query->createCommand();*/
			/* $sql = "select  p.id as plan_card_id_d,IF( p.created_by ='".$user_id."',  'self',  'manager' ) AS plan_created_by,p.planned_date, ucfirst(mv.village_name) as village_name, p.product_id, p.crop_id ,
					IF(p.activity ='Channel Card','Partner Visit',p.activity) as activity,  p.plan_type, p.card_type ,p.channel_partner,p.status ,p.updated_date,p.lat_position,p.long_position,p.location_name,
					IF(c.contacted_person_name is null or c.contacted_person_name = '', '--', c.contacted_person_name) as contacted_person_name,
					IF(c.contacted_person_phone is null or c.contacted_person_phone = '', '--', c.contacted_person_phone) as contacted_person_phone,
					IF(c.no_of_farmers is null or c.no_of_farmers = '', '--', c.no_of_farmers) as no_of_farmers,
					IF(c.no_of_female_farmers is null or c.no_of_female_farmers = '', '--', c.no_of_female_farmers) as no_of_female_farmers,
					IF(c.no_of_villages is null or c.no_of_villages = '', '--', c.no_of_villages) as no_of_villages,
					IF(c.no_of_retailers is null or c.no_of_retailers = '', '--', c.no_of_retailers) as no_of_retailers,
					IF(c.no_of_dealers is null or c.no_of_dealers = '', '--', c.no_of_dealers) as no_of_dealers,
					IF(c.feedback is null or c.feedback = '', '--', c.feedback) as feedback,
					IF(c.purpose is null or c.purpose = '', '--', c.purpose) as purpose,
					c.picture1,c.picture2,c.picture3,c.picture1_uri,c.picture2_uri,c.picture3_uri,
					IF(ch.target_value is null or ch.target_value = '', '--', ch.target_value) as target_value,
					IF(ch.actual_value is null or ch.actual_value = '', '--', ch.actual_value) as actual_value,
					IF(ch.feedback is null or ch.feedback = '', '--', ch.feedback) as cfeedback,
					sa.sub_activity_name,ucfirst(cr.crop_name) as crop_name,ucfirst(pr.product_name) as product_name
					from plan_cards p
					left join campaign_card_activities c on c.plan_card_id=p.id
					left join channel_card_activities ch on ch.plan_card_id = p.id
					left join sub_activity sa on sa.sub_activity_id = c.sub_activity_id
					left join crops cr on cr.id = p.crop_id
					left join products pr on pr.id = p.product_id
					left join villages_master mv on mv.village_id = p.village_id
					where p.status='submitted'
					and p.assign_to='".$user_id."'
					group by c.plan_card_id, ch.plan_card_id
					ORDER BY p.updated_date DESC, c.mobile_timestamp DESC, ch.mobile_timestamp DESC
					LIMIT 40"; */	
			$sql = "select  p.id as plan_card_id_d,IF( p.created_by ='".$user_id."',  'self',  'manager' ) AS plan_created_by,p.planned_date, ucfirst(mv.village_name) as village_name, p.product_id, p.crop_id ,
					IF(p.activity ='Channel Card','Partner Visit',p.activity) as activity,  p.plan_type, p.card_type ,p.channel_partner,p.status ,p.updated_date,p.lat_position,p.long_position,p.location_name,p.order_number,
					IF(c.contacted_person_name is null or c.contacted_person_name = '', '--', c.contacted_person_name) as contacted_person_name,
					IF(c.contacted_person_phone is null or c.contacted_person_phone = '', '--', c.contacted_person_phone) as contacted_person_phone,
					IF(c.no_of_farmers is null or c.no_of_farmers = '', '--', c.no_of_farmers) as no_of_farmers,
					IF(c.no_of_female_farmers is null or c.no_of_female_farmers = '', '--', c.no_of_female_farmers) as no_of_female_farmers,
					IF(c.no_of_villages is null or c.no_of_villages = '', '--', c.no_of_villages) as no_of_villages,
					IF(c.no_of_retailers is null or c.no_of_retailers = '', '--', c.no_of_retailers) as no_of_retailers,
					IF(c.no_of_dealers is null or c.no_of_dealers = '', '--', c.no_of_dealers) as no_of_dealers,
					IF(c.feedback is null or c.feedback = '', '--', c.feedback) as feedback,
					IF(c.purpose is null or c.purpose = '', '--', c.purpose) as purpose,
					c.picture1,c.picture2,c.picture3,c.picture1_uri,c.picture2_uri,c.picture3_uri,
					IF(ch.feedback is null or ch.feedback = '', '--', ch.feedback) as cfeedback,
					sa.sub_activity_name,ucfirst(cr.crop_name) as crop_name,ucfirst(pr.product_name) as product_name,
					GROUP_CONCAT(CONCAT(ci.image_path,ci.image_name)) as imagepath from plan_cards p
					left join campaign_card_activities c on c.plan_card_id=p.id
					left join channel_card_activities ch on ch.plan_card_id = p.id
					left join channel_card_images ci on ci.plan_card_id = p.id
					left join sub_activity sa on sa.sub_activity_id = c.sub_activity_id
					left join crops cr on cr.id = p.crop_id
					left join products pr on pr.id = p.product_id
					left join villages_master mv on mv.village_id = p.village_id
					where p.status='submitted'
					and p.assign_to='".$user_id."'
					group by c.plan_card_id, ch.plan_card_id
					ORDER BY p.order_number desc,p.updated_date desc
					LIMIT 40";
			$q = Yii::$app->db->createCommand($sql)->queryAll();
			if(empty($q)) {
				return ['message' => 'No Results Found','status'=>false,'time_stamp'=> date('Y-m-d H:i:s')];
			}
		} else {
			/* $sql = "select  p.id as plan_card_id_d,IF( p.created_by ='".$user_id."',  'self',  'manager' ) AS plan_created_by,p.planned_date, ucfisrt(mv.village_name) as village_name, p.product_name, p.crop_name ,
					IF(p.activity ='Channel Card','Partner Visit',p.activity) as activity,  p.plan_type, p.card_type ,p.channel_partner,p.status ,p.updated_date,p.lat_position,p.long_position,p.location_name,
					IF(c.contacted_person_name is null or c.contacted_person_name = '', '--', c.contacted_person_name) as contacted_person_name,
					IF(c.contacted_person_phone is null or c.contacted_person_phone = '', '--', c.contacted_person_phone) as contacted_person_phone,
					IF(c.no_of_farmers is null or c.no_of_farmers = '', '--', c.no_of_farmers) as no_of_farmers,
					IF(c.no_of_female_farmers is null or c.no_of_female_farmers = '', '--', c.no_of_female_farmers) as no_of_female_farmers,
					IF(c.no_of_villages is null or c.no_of_villages = '', '--', c.no_of_villages) as no_of_villages,
					IF(c.no_of_retailers is null or c.no_of_retailers = '', '--', c.no_of_retailers) as no_of_retailers,
					IF(c.no_of_dealers is null or c.no_of_dealers = '', '--', c.no_of_dealers) as no_of_dealers,
					IF(c.feedback is null or c.feedback = '', '--', c.feedback) as feedback,
					IF(c.purpose is null or c.purpose = '', '--', c.purpose) as purpose,
					c.picture1,c.picture2,c.picture3,c.picture1_uri,c.picture2_uri,c.picture3_uri,
					IF(ch.target_value is null or ch.target_value = '', '--', ch.target_value) as target_value,
					IF(ch.actual_value is null or ch.actual_value = '', '--', ch.actual_value) as actual_value,
					IF(ch.feedback is null or ch.feedback = '', '--', ch.feedback) as cfeedback,
					sa.sub_activity_name,ucfirst(cr.crop_name) as crop_name,ucfisrt(pr.product_name) as product_name
					from plan_cards p
					left join campaign_card_activities c on c.plan_card_id=p.id
					left join channel_card_activities ch on ch.plan_card_id = p.id
					left join sub_activity sa on sa.sub_activity_id = c.sub_activity_id
					left join crops cr on cr.id = p.crop_id
					left join products pr on pr.id = p.product_id
					left join villages_master mv on mv.village_id = p.village_id
					where p.status='submitted' and p.assign_to = '".$user_id."' 
					and p.updated_date > '".$date."'
					group by c.plan_card_id, ch.plan_card_id
					ORDER BY p.updated_date DESC , c.mobile_timestamp DESC, ch.mobile_timestamp DESC
					LIMIT 40"; */
			$sql = "select  p.id as plan_card_id_d,IF( p.created_by ='".$user_id."',  'self',  'manager' ) AS plan_created_by,p.planned_date, ucfisrt(mv.village_name) as village_name, p.product_name, p.crop_name ,
					IF(p.activity ='Channel Card','Partner Visit',p.activity) as activity,  p.plan_type, p.card_type ,p.channel_partner,p.status ,p.updated_date,p.lat_position,p.long_position,p.location_name,p.order_number,
					IF(c.contacted_person_name is null or c.contacted_person_name = '', '--', c.contacted_person_name) as contacted_person_name,
					IF(c.contacted_person_phone is null or c.contacted_person_phone = '', '--', c.contacted_person_phone) as contacted_person_phone,
					IF(c.no_of_farmers is null or c.no_of_farmers = '', '--', c.no_of_farmers) as no_of_farmers,
					IF(c.no_of_female_farmers is null or c.no_of_female_farmers = '', '--', c.no_of_female_farmers) as no_of_female_farmers,
					IF(c.no_of_villages is null or c.no_of_villages = '', '--', c.no_of_villages) as no_of_villages,
					IF(c.no_of_retailers is null or c.no_of_retailers = '', '--', c.no_of_retailers) as no_of_retailers,
					IF(c.no_of_dealers is null or c.no_of_dealers = '', '--', c.no_of_dealers) as no_of_dealers,
					IF(c.feedback is null or c.feedback = '', '--', c.feedback) as feedback,
					IF(c.purpose is null or c.purpose = '', '--', c.purpose) as purpose,
					c.picture1,c.picture2,c.picture3,c.picture1_uri,c.picture2_uri,c.picture3_uri,
					IF(ch.feedback is null or ch.feedback = '', '--', ch.feedback) as cfeedback,
					sa.sub_activity_name,ucfirst(cr.crop_name) as crop_name,ucfisrt(pr.product_name) as product_name,
					GROUP_CONCAT(CONCAT(ci.image_path,ci.image_name)) as imagepath from plan_cards p
					left join campaign_card_activities c on c.plan_card_id=p.id
					left join channel_card_activities ch on ch.plan_card_id = p.id
					left join channel_card_images ci on ci.plan_card_id = p.id
					left join sub_activity sa on sa.sub_activity_id = c.sub_activity_id
					left join crops cr on cr.id = p.crop_id
					left join products pr on pr.id = p.product_id
					left join villages_master mv on mv.village_id = p.village_id
					where p.status='submitted' and p.assign_to = '".$user_id."'
					and p.updated_date > '".$date."'
					group by c.plan_card_id, ch.plan_card_id
					ORDER BY p.order_number desc,p.updated_date desc
					LIMIT 40";
			$q = Yii::$app->db->createCommand($sql)->queryAll();
		}
		/* $sql2 = "select ct.plan_card_id,cth.product_id,cth.product_unit,cth.liquidation_status,cth.demand_volume,
				p.product_name,cth.season_progress from channel_card_activities ct
				JOIN channel_card_tracking_info cth ON cth.plan_card_id = ct.plan_card_id
				JOIN products p ON  p.id = cth.product_id";
		$query = Yii::$app->db->createCommand($sql2)->queryAll(); */
		$sql2 = "select ct.plan_card_id,cth.product_id,cth.product_unit,IF(cth.liquidation_status is null or cth.liquidation_status = '', '--',cth.liquidation_status) as liquidation_status,IF(cth.demand_volume is null or cth.demand_volume = '', '--',cth.demand_volume) as demand_volume ,
				IF(cth.season_progress is null or cth.season_progress = '', '--',cth.season_progress) as season_progress,IF(cth.collection_value_four is null or cth.collection_value_four = '', '--',cth.collection_value_four) as collection_value_four,
				p.product_name,IF(cth.collection_value_five is null or cth.collection_value_five = '', '--',cth.collection_value_five) as collection_value_five from channel_card_activities ct
				JOIN channel_card_tracking_info cth ON cth.plan_card_id = ct.plan_card_id
				JOIN products p ON  p.id = cth.product_id";
		$query = Yii::$app->db->createCommand($sql2)->queryAll();
		$productIds  = array();
		if (!empty($query)) {
			foreach ($query as $key=>$value){
				$productIds[] = $value['product_id']; // get all products ids
			}
			$product_Ids = implode(',', $productIds);
		/* 	$partnerLabelQuery = "select temp.form_builder_id, temp.form_builder_activity_id, temp.product_id,group_concat(replace(temp.label, ' ','_') separator '~') as label, unit from (SELECT fb.form_builder_id, fb.form_builder_activity_id,  pi.product_id,fb.label, GROUP_CONCAT( pi.product_unit ) as unit
					FROM form_builder fb
					JOIN product_info pi ON pi.form_builder_activity_id = fb.form_builder_activity_id
					WHERE fb.step =1 and pi.product_id in(".$product_Ids.")
							GROUP BY fb.form_builder_id) as temp
							group by temp.form_builder_activity_id, temp.product_id"; */
			$partnerLabelQuery = "SELECT fb.form_builder_id, fb.form_builder_activity_id, fb.product_id, group_concat( replace( fb.label, ' ', '_' ) order by fb.form_builder_id
					SEPARATOR '~' ) AS label
					FROM form_builder fb
					WHERE fb.step =1
					AND fb.product_id IN (".$product_Ids.")
					GROUP BY fb.form_builder_activity_id, fb.product_id";
			$partnerLabelQueryResult = Yii::$app->db->createCommand($partnerLabelQuery)->queryAll();
			$productLabelArray = array();
			if(!empty($partnerLabelQueryResult)) {
				//$i = 0;
				foreach($partnerLabelQueryResult as $productResult) {
					$labelProducts[] = $productResult['product_id'];
					$productLabelArray[$productResult['label']][] = $productResult['product_id'];
				}
				$uniqProductIds = array_unique($productIds);
				$uniqProductIds = array_values($uniqProductIds);
				$result_array_diff = array_diff($uniqProductIds,$labelProducts);
				$productLabelArray['liquidation_status~demand_volume~season_progress'] = $result_array_diff;
			}
			foreach ($query as $value) {
				$channelLabels = array('product_id' => $value['product_id'],'product_name'=>$value['product_name'],
						'product_unit'=>$value['product_unit'],
						'liquidation_status'=>$value['liquidation_status'],
						'demand_volume'=>$value['demand_volume'],
						'season_progress'=>$value['season_progress'],
						'collection_value_four' => $value['collection_value_four'],
						'collection_value_five' => $value['collection_value_five']);
					
				$plancardProducts[$value['plan_card_id']][] = $channelLabels;
			}
		}
		
		if (!empty($q)) {
			$product_label = array();
			foreach($q as $key=>$data){
				$id = $data['plan_card_id_d'];
				if(array_key_exists ($id,$plancardProducts) ){
					$productMap = array();
					foreach($plancardProducts[$id] as $productDetails) {
						foreach($productLabelArray as $key1 => $productfinal) {
							if(in_array($productDetails['product_id'],$productfinal)){
								$productMap[$key1][] = $productDetails;
							}
						}

					}
					$q[$key]['Products'] = $productMap;
				}
			}
		}
		//echo '<pre>';print_r($q);exit;
		if(!empty($q)) {
		foreach( $q as $key => $infoArr){
			$pArr = array();
			$pArr1 = array();
			if($infoArr['activity'] == 'Partner Visit'){
				if (array_key_exists('Products', $infoArr)) {
					foreach($infoArr['Products'] as $k => $pDetail){
						$labelarray = explode('~',str_replace("_"," ",$k));
						$pArr['liquidation_status'] = (isset($labelarray[0])  && $labelarray[0] != '') ? $labelarray[0] : '';
						$pArr['demand_volume'] = (isset($labelarray[1])  && $labelarray[1] != '') ? $labelarray[1] : '';
						$pArr['season_progress'] = (isset($labelarray[2])  && $labelarray[2] != '') ? $labelarray[2] : '';
						$pArr['collection_value_four'] = (isset($labelarray[3])  && $labelarray[3] != '') ? $labelarray[3] : '';
						$pArr['collection_value_five'] =(isset($labelarray[4])  && $labelarray[4] != '') ? $labelarray[4] : '';
						$pArr['product_details'] = $pDetail;
						$pArr1[] = $pArr;
					}
				} else {
					$infoArr['Products'] = array();
				}
				$infoArr['Products'] = $pArr1;
				$q[$key]['Products'] = $infoArr['Products'];
			}
		}
		//echo '<pre>';print_r($q);exit;
		}
		if(!empty($q)) {
			foreach( $q as $key => $planDetails){
				$pArr2 = array();
				if($planDetails['activity'] == 'Partner Visit'){
					if (array_key_exists('Products', $planDetails)) {
						foreach($planDetails['Products'] as $productDe) {
							foreach($productDe['product_details'] as $productLa) {
								//echo '<pre>';print_r($productLa);exit;
								$productLa['liquidation_status1'] = $productDe['liquidation_status'];
								$productLa['demand_volume1'] = $productDe['demand_volume'];
								$productLa['season_progress1'] = $productDe['season_progress'];
								$productLa['collection_value_four1'] = $productDe['collection_value_four'];
								$productLa['collection_value_five1'] = $productDe['collection_value_five'];
								$pArr2[] = $productLa;
												
							} 
						}
					} else {
						$planDetails['Products'] = array();
					}
					$planDetails['Productsk'] = $pArr2;
					$q[$key]['Products'] = $planDetails['Productsk'];
				}
			}
		}
		$steps = array();
		$labels_query = 'SELECT fba.form_builder_activity_id,fb.form_builder_activity_id, fb.step, fb.label,if(ac.activity_name = "Channel Card","Partner Visit",ac.activity_name) as activity_name
				FROM form_builder_activities fba
				LEFT JOIN form_builder fb ON fb.form_builder_activity_id = fba.form_builder_activity_id
				LEFT JOIN activity ac ON ac.activity_id = fba.activity_id
				WHERE fba.company_id = "'.$company_id.'"
						GROUP BY fb.form_builder_id';
		$labels_query_execute = Yii::$app->db->createCommand($labels_query)->queryAll();
		$channelStepsArray1 = $campaignStepsArray2 =  array();
		if(!empty($labels_query_execute)) {
			foreach($labels_query_execute as $result_label) {
				//if($result_label['activity_name'] == 'Partner Visit') {
					//$channelStepsArray1[$result_label['activity_name']] =  $result_label['step'];
				/* } else {
					$campaignStepsArray2[$result_label['activity_name']][] =  $result_label['step'];
				} */
				$totalStepsArray1[$result_label['activity_name']][] =  $result_label['step'];
			}
// 			echo '<pre>';print_r(array_search(1, $totalStepsArray1['Partner Visit']));exit;
			foreach($labels_query_execute as $labels) {
// 				if(in_array(1,))
				//echo '<pre>';print_r($totalStepsArray1[$labels['activity_name']]);exit;
				if($labels['activity_name'] != 'Partner Visit') {
					if (in_array(1 , $totalStepsArray1[$labels['activity_name']])) {
						if($labels['step'] == 1) {
							$final_labels[$labels['activity_name']]['step'.$labels['step']] = ucfirst($labels['label']);
						}
					} else {
						$final_labels[$labels['activity_name']]['step1'] = null;
					}
					
				}  
				if (!in_array(2 , $totalStepsArray1[$labels['activity_name']])) {
					$final_labels[$labels['activity_name']]['step2'] = null;			 	
				} else {
					if($labels['step'] == 2 && $labels['activity_name'] == 'Partner Visit') {
						$final_labels[$labels['activity_name']]['step'.$labels['step']][] = ucfirst($labels['label']);
					} else if($labels['step'] == 2) {
						$final_labels[$labels['activity_name']]['step'.$labels['step']] = ucfirst($labels['label']);
					}
				}
				if (!in_array(3 , $totalStepsArray1[$labels['activity_name']])) {
					$final_labels[$labels['activity_name']]['step3'] = null;
				} else {
					if($labels['step'] == 3 && $labels['activity_name'] == 'Partner Visit') {
						$final_labels[$labels['activity_name']]['step'.$labels['step']] = ucfirst($labels['label']);
					} else if($labels['step'] == 3) {
						$final_labels[$labels['activity_name']]['step'.$labels['step']][] = ucfirst($labels['label']);
					}
				}
				if ($labels['activity_name'] != 'Partner Visit') {
					if (!in_array(4 , $totalStepsArray1[$labels['activity_name']])) {
						$final_labels[$labels['activity_name']]['step4'] = null;
					} else {
						if($labels['step'] == 4) {
							$final_labels[$labels['activity_name']]['step'.$labels['step']] = ucfirst($labels['label']);
						}
					}
					if (!in_array(5 , $totalStepsArray1[$labels['activity_name']])) {
						$final_labels[$labels['activity_name']]['step5'] = null;
					} else {
						if($labels['step'] == 5) {
							$final_labels[$labels['activity_name']]['step'.$labels['step']] = ucfirst($labels['label']);
						}
					}
				}		
		/* 		} else if($labels['step'] == 2) {
					if($labels['activity_name'] == 'Partner Visit') {
						$final_labels[$labels['activity_name']]['step'.$labels['step']][] = $labels['label'];
					} else {
						if($labels['step'] != 1) {
							$final_labels[$labels['activity_name']]['step'.$labels['step']] = $labels['label'];
						}
					}
				} else if ($labels['step'] == 3) {
					if($labels['activity_name'] == 'Partner Visit') {
						$final_labels[$labels['activity_name']]['step'.$labels['step']] = $labels['label'];
					} else {
						$final_labels[$labels['activity_name']]['step'.$labels['step']][] = $labels['label'];
					}
				} else if ($labels['step'] == 4){
					$final_labels[$labels['activity_name']]['step'.$labels['step']] = $labels['label'];
				}  else if ($labels['step'] == 5){
					$final_labels[$labels['activity_name']]['step'.$labels['step']] = $labels['label'];
				} */
			}
// 			echo '<pre>';print_r($final_labels);exit;		
		}
		$array_keys = array_keys($final_labels);
		if(!empty($q)) {
			foreach($q as $info) {
				if(array_key_exists($info['activity'],$final_labels)) {
					if($info['activity'] == 'Farm and Home Visit') {
						$info['step1'] = $final_labels['Farm and Home Visit']['step1'];
						$info['step2'] = $final_labels['Farm and Home Visit']['step2'];
						$info['step3'] = $final_labels['Farm and Home Visit']['step3'];
						$info['step4'] = $final_labels['Farm and Home Visit']['step4'];
						$info['step5'] = $final_labels['Farm and Home Visit']['step5'];
					}
					else if($info['activity'] == 'Demonstration') {
						$info['step1'] =  $final_labels['Demonstration']['step1'];
						$info['step2'] = $final_labels['Demonstration']['step2'];
						$info['step3'] = $final_labels['Demonstration']['step3'];
						$info['step4'] = $final_labels['Demonstration']['step4'];
						$info['step5'] = $final_labels['Demonstration']['step5'];
					} else if($info['activity'] == 'Mass Campaign') {
						$info['step1'] =  $final_labels['Mass Campaign']['step1'];
						$info['step2'] = $final_labels['Mass Campaign']['step2'];
						$info['step3'] = $final_labels['Mass Campaign']['step3'];
						$info['step4'] = $final_labels['Mass Campaign']['step4'];
						$info['step5'] = $final_labels['Mass Campaign']['step5'];
					} else if($info['activity'] == 'Farmer Group Meeting') {
						$info['step1'] =  $final_labels['Farmer Group Meeting']['step1'];
						$info['step2'] = $final_labels['Farmer Group Meeting']['step2'];
						$info['step3'] = $final_labels['Farmer Group Meeting']['step3'];
						$info['step4'] = $final_labels['Farmer Group Meeting']['step4'];
						$info['step5'] = $final_labels['Farmer Group Meeting']['step5'];
					} else if($info['activity'] == 'Partner Visit') {
						$info['step3'] = $final_labels['Partner Visit']['step2'];
						$info['step4'] = $final_labels['Partner Visit']['step3'];
					}
				} else {
					if($info['activity'] == 'Farmer Group Meeting') {
						$info['step1'] = 'Sub Activity';
						$info['step2'] = 'Purpose';
						$info['step3'] = array('Farmers','Female Farmers','Partners');
						$info['step4'] = 'Remarksssss';
						$info['step5'] = 'image';
					}else if($info['activity'] == 'Farm and Home Visit')
					{
						$info['step1'] = 'Sub Activity';
						$info['step2'] = 'Purpose';
						$info['step3'] = array('Farmer Name','Mobile No');
						$info['step4'] = 'Remarksssss';
						$info['step5'] = 'image';
					}  else if($info['activity'] == 'Mass Campaign') {
						$info['step1'] = 'Sub Activity';
						$info['step2'] = 'Purpose';
						$info['step3'] = array('Farmers','Female Farmers','Partners','Villages');
						$info['step4'] = 'Remarkssss';
						$info['step5'] = 'image';
					} else if($info['activity'] == 'Demonstration') {
						$info['step1'] = 'Sub Activity';
						$info['step2'] = 'Observation';
						$info['step3'] = array('Farmer Name','Mobile Number','Farmers','Female Farmers','Partners');
						$info['step4'] = 'Remarksssssssssss';
						$info['step5'] = 'image';
					} else if($info['activity'] == 'Partner Visit') {
						$info['step3'] = array('collection','Target','status');
						$info['step4'] = 'remarkssss';
					}
				}
				$final_data[] = $info;
			}
		}
		//return $final_data;
		//echo '<pre>';print_r($final_data);exit;
		$images = $channelImages = array();
		if(!empty($final_data)) {
			foreach($final_data as $Card) {
				$images = array();
				if($Card['card_type'] != 'channel card') {
					if($Card['picture1'] != '') {
						$images[] = $Card['picture1_uri']. $Card['picture1'];
					}
					if($Card['picture2'] != '') {
						$images[] = $Card['picture2_uri']. $Card['picture2'];	
					}
					if($Card['picture3'] != '') {
						$images[] = $Card['picture3_uri']. $Card['picture3'];
					}
					unset($Card['picture1_uri'],$Card['picture1'],$Card['picture2_uri'],$Card['picture2'],$Card['picture3'],$Card['picture3_uri'],$Card['imagepath']);
					$Card['images'] = $images;
					$finalData[] = $Card;
				} else {
					if($Card['imagepath'] != '' ) {
						$channelImages = explode(",",$Card['imagepath']);
					}
					unset($Card['picture1_uri'],$Card['picture1'],$Card['picture2_uri'],$Card['picture2'],$Card['picture3'],$Card['picture3_uri'],$Card['imagepath']);
						$Card['images'] = $channelImages;
						$finalData[] = $Card;
				}
			}
		}
		return $finalData;
	}
	
	/* web service for history service end */
	
	public static function pendingCards($date,$user_id)
	{
		$sql = "SELECT id,IF(created_by ='".$user_id."','self','manager') as created_by,assign_to,product_name,activity,village_name,crop_name,status FROM `plan_cards` WHERE assign_to='".$user_id."' and (status='not_submitted' or status='rejected') and is_deleted=0 $date order by id desc";
		return $q = Yii::$app->db->createCommand($sql)->queryAll();
	}
	/* web service for dashboard service start */
	public static function countcards($user_id)
	{
		$cur_date = date("Y-m-d");
		//$sql="SELECT count(id) as cards_count,status FROM plan_cards WHERE assign_to=$user_id and status='not_submitted' and is_deleted=0 and DATE_FORMAT(planned_date, '%Y-%m-%d')  = CURDATE()";
		$query =new Query;
		$query->select('count(id) as cards_count,status')
		->from('plan_cards')
		->where(['assign_to' => $user_id])
		->andWhere(['status' =>'not_submitted','is_deleted' => 0])
		->andWhere(['=','planned_date',$cur_date]);
		$command = $query->createCommand();
		$q = $command->queryAll();
		$query2 =new Query;
		$query2->select('sum(distance_travelled) as total_distance')
		->from('plan_cards')
		->where(['assign_to' => $user_id,'status' =>'submitted','is_deleted' => 0,"DATE_FORMAT(updated_date, '%Y-%m-%d')" => "$cur_date"]);
		//$command2 = $query2->createCommand();
		$query3 =new Query;
		$query3->select('sum(ut.distance_travelled) as total_distance')
		->from('user_travellog ut')
		->where(['ut.user_id' => $user_id, "DATE_FORMAT(ut.date_time, '%Y-%m-%d')" => "$cur_date"]);
		//$command2 = $query2->createCommand();
		$union =new Query;
		$union->select('sum(total_distance) as total_distance')->from(['dummy'=> $query2->union($query3)]);
		$q2 = $union->all();
			
		if ($q2[0]['total_distance'] == null) {
			$q2[0]['total_distance'] = 0;
		}
		$q['distance'] = round($q2[0]['total_distance'],2);
		return $q;
	}
	/* web service for dashboard service end */
	
	/* web service for weekly count start */ 
	public static function wcountcards($user_id)
	{
		$sunday =  date('Y-m-d',strtotime("monday this week"));
		$one_week =  date('Y-m-d', strtotime($sunday. ' + 6 day'));
		$query =new Query;
		$query->select('count(id) as count')
		->from('plan_cards')
		->where(['between','planned_date',$sunday,$one_week])
		->andwhere(['assign_to' => $user_id])
		->andWhere(['status' =>'not_submitted','is_deleted' => 0]);
		$command = $query->createCommand();
		return $q = $command->queryAll();
		//     	$sql="SELECT count(id) as count
		//     		   FROM plan_cards
		//     		   WHERE planned_date BETWEEN CURDATE() AND '".$one_week."'  and  status = 'not_submitted' and is_deleted = 0 and  assign_to = $user_id";
		//     return $q = Yii::$app->db->createCommand($sql)->queryAll();
	}
	
	/* web service for weekly count end */
	
	//web service for travel log list start
	public static function travellog($params)
	{
		$user_id = Yii::$app->user->identity->id;
		//$params['updated_date'] = explode(' ', $params['updated_date']);
		$result = $travel = array();
		if ($params['updated_date'] == '') {
			$sql = "SELECT COUNT(id) AS number_of_cards, SUM(distance_travelled) AS distance_travelled, status,updated_date FROM plan_cards WHERE assign_to = '".$user_id."' AND status = 'submitted' GROUP BY DATE_FORMAT(updated_date, '%Y-%m-%d')  ORDER BY DATE_FORMAT(updated_date, '%Y-%m-%d') DESC";
			$sql = Yii::$app->db->createCommand($sql)->queryAll();
			$user_travel_log = UserTravellog::find()->select('date_time')->where(['user_id' => $user_id])->asArray()->all();
			if(empty($sql) && empty($user_travel_log)){
				return array();  // for no results found
			}
			if(!empty($user_travel_log)) {
				foreach($user_travel_log as $log) {
					$travel =explode(' ',  $log['date_time']);
					$travel_end_time[] = $travel[0];
				}
					
				if(!empty($sql)) {
					foreach($sql as $travel_card) {
						$plan_card_time =explode(' ',  $travel_card['updated_date']);
						$plan_card_update[] = $plan_card_time[0];
					}
				} else {
					$plan_card_update = array();
				}
				$dif_result = array_diff($travel_end_time, $plan_card_update);
				$unique_array = array_unique($dif_result);
				foreach($unique_array as $result) {
					$travel_array = array('number_of_cards' => 0,'distance_travelled' => 0,'status' => 'submitted','updated_date' => $result.' 00:00:00');
					array_push($sql,$travel_array);
				}
			}
			if (!empty($sql)) {
					
				foreach ($sql as $res) {
					$res['updated_date'] = explode(' ', $res['updated_date']);
					$date_time = $res['updated_date'][0];
					$cards_details = "select  p.id as plan_card_id, p.village_name, p.planned_date, p.distance_travelled,
							p.updated_date, p.activity, p.card_type, p.status, p.lat_position, p.long_position, p.location_name,
							p.start_time, p.updated_date as end_time
							FROM plan_cards p
							WHERE p.status='submitted' AND p.assign_to= '".$user_id."' AND
									DATE_FORMAT(p.updated_date, '%Y-%m-%d') = '".$res['updated_date'][0]."'
											ORDER BY p.updated_date DESC";
					$cards_details = Yii::$app->db->createCommand($cards_details)->queryAll();
					if(empty($cards_details)) {

						$flag = 1;
						$res['results'] = array();
						//     					echo '<pre>';print_r($res);exit;
					} else {
						$res['results'] = $cards_details;
					}
					//array preparation for appending results to old result query to $sql
					$res['updated_date'] = implode(' ', $res['updated_date']);

					//// start stop per day web service
					$start_stop = UserTravellog::startStop($user_id,$date_time);
					if(!empty($start_stop)) {
						foreach ($start_stop as $start) {
							array_push($res['results'],$start);
						}
						$sort = array();
						$distance = 0;
						foreach ($res['results'] as $key => $part) {
							$sort[$key] = strtotime($part['end_time']);
							$distance = $distance + $part['distance_travelled'];
						}
						$res['distance_travelled'] = $distance;
						array_multisort($sort, SORT_DESC, $res['results']);
					}
					// start stop per day web service
					$final_result[] = $res;
				}
			}
		}
		foreach ($final_result as $order) {
			$sort_array[] = $order['updated_date'];
		}
		array_multisort($sort_array, SORT_DESC, $final_result);
		return $final_result;
	}
	//web service for travel log list end
	
	/* service for image sync start*/
	public static function imagesSyncing($params,$user_id)
	{
		$plan_card_id = $params['plan_card_id'];
		$planCardType = PlanCards::find()->select(['card_type'])->where(['id' => $plan_card_id])->column();
		if($planCardType[0] != 'channel card') {
		$images = $params['images'];
		$file = $im = array();
		$userid = Yii::$app->user->identity->id;
		$comp_id = Yii::$app->user->identity->input_company_id;
		//     	$sql = \app\models\Users::find()->select(['input_company_id'])->where(['id'=>$id])->one();
		//     	$comp_id = $sql['input_company_id'];
		$com_path = '../web/field_images/'.$comp_id.'/';
		$user_path = '../web/field_images/'.$comp_id.'/'.$user_id.'/';
		$i = 0;
		if (!empty($images)) {
			$pic_name = 'picture';
			$pictures = array();
			$fileName = '';
			foreach($images as $key => $image) {
				if ($image != '') {
					//$imageData1 = str_replace('data:image/jpg;base64,', '', $image);
					$imageData1 = $image;
					if ($imageData1 != '') {
						$key = $key+1;
						$fileName = $plan_card_id . '_file'.$key.'.jpg';
						if (!is_dir($com_path)) {
							BaseFileHelper::createDirectory($com_path, $mode = 0777, $recursive = true );
							BaseFileHelper::createDirectory($user_path, $mode = 0777, $recursive = true );
							$file = $user_path . $fileName;
						} else {
							if(!is_dir($user_path)) {
								BaseFileHelper::createDirectory($user_path, $mode = 0777, $recursive = true );
								$file = $user_path . $fileName;
							} else {
								$file = $user_path . $fileName;
							}
						}
						$pictures['picture'.$key] = $fileName;
						$pictures['picture'.$key.'_uri'] = str_replace('../web/','',$user_path);;
						$imgSuc = file_put_contents($file, base64_decode($imageData1));
						if($imgSuc != false){
							$temp = $imgSuc;
						}
					}
				}

			}
			//$result = false;
			if($fileName != ''){
				$result = Yii::$app->db->createCommand()
				->update('campaign_card_activities', $pictures, "plan_card_id = ".$plan_card_id)
				->execute();
				return ['plan_card_id' => $plan_card_id, 'image_status' => true];
			}
			else {
				return ['plan_card_id' => $plan_card_id, 'image_status' => true];
			}
		}
		} else {
				$chImages = $params['images'];
				if(!empty($chImages)) {
					$de_images = PlanCards::decodeImage($chImages,$user_id);
					if(!empty($de_images)) {
						foreach($de_images as $Imgage) {
							$ImageName = end((explode("/",$Imgage)));
							$imagePath = str_replace(end((explode("/",$Imgage))),'',str_replace('../web/','',$Imgage));
							$imagesArray[] = array($ImageName, $imagePath,  $plan_card_id, $user_id, $user_id, new Expression('NOW()'), new Expression('NOW()'));
						}
					}
					$imageBatchInsert = Yii::$app->db->createCommand()->batchInsert('channel_card_images', ['image_name', 'image_path','plan_card_id','updated_by','created_by','created_date','updated_date'], $imagesArray)->execute();
					return ['plan_card_id' => $plan_card_id, 'image_status' => true];
				} else {
					return ['plan_card_id' => $plan_card_id, 'image_status' => true];
				}
			}
	}
	/* service for image sync end*/
	
	/*  web service for travel details list start*/
	public static function travelDetails()
	{
		$user_id = Yii::$app->user->identity->id;
		/* 	$query1 = PlanCards::find()->select("date(updated_date) as req_date,count(id) as plan_cnt, sum(distance_travelled) as distance_travelled")
		 ->where(['assign_to' => $user_id,'status' => 'submitted'])
		->groupBy('date(updated_date)')
		->orderBy('updated_date desc')
		->limit(21);
		$query2 = UserTravellog::find()->select("date(date_time) as req_date, '0' as plan_cnt,sum(distance_travelled) as distance_travelled")
		->where(['user_id' => $user_id])
		->groupBy('date(date_time)')
		->orderBy('date_time desc')
		->limit(21);
		$plan_distance_details = (new \yii\db\Query())
		->select('temp.*')
		->from(['temp' => $query1->union($query2)])
		->orderBY('temp.updated_date desc')
		->limit(21)
		->all(); */
		$date_details = array();
		$plan_distace = "select temp.* from
		((SELECT updated_date, date_format(updated_date,'%Y-%m-%d') as req_date, count(id) as plan_cnt, sum(distance_travelled) as distance_travelled
		FROM plan_cards
		WHERE assign_to = $user_id and status='submitted'
		group by date_format(updated_date,'%Y-%m-%d')
		order by updated_date desc limit 42)
		UNION
		(SELECT date_time as updated_date, date_format(date_time,'%Y-%m-%d') as req_date, 0 as plan_cnt,sum(distance_travelled) as distance_travelled
		FROM user_travellog
		WHERE user_id = $user_id
		group by date_format(date_time,'%Y-%m-%d')
		order by date_time desc limit 42)) as temp
		where 1
		order by temp.updated_date desc limit 42";
		$plan_distance_details = Yii::$app->db->createCommand($plan_distace)->queryAll();
		if(empty($plan_distance_details)) {
			return array();
		}
		if(!empty($plan_distance_details)) {
			foreach($plan_distance_details as $dates) {
				// echo '<pre>';
				// print_r($dates);
				$date_details[$dates['req_date']][] = array('plans_count' => $dates['plan_cnt'],'distance' => $dates['distance_travelled']);
			}
		}
		// 		echo '<pre>';
		// 		print_r($date_details);
		// 		exit;
		$k = 0;
		foreach($date_details as $key => $dates) {
			$no_plans = 0;
			$dist = 0;
			foreach($dates as $date_details){
				$dist += $date_details['distance'];
				$no_plans += $date_details['plans_count'];
			}


			$total_dates[$key] = array('plans_count' => $no_plans, 'distance' => $dist);
			$k++;
			if($k==20){
				break;
			}
		}
		// 		 echo '<pre>';
		// 		print_r($total_dates);exit;
		$datee_keys = array_keys($total_dates);
		//echo '<pre>';
		//print_r($datee_keys);
		//exit;
		$dates_string = "'".implode("','",$datee_keys)."'";
		$plan_log_details = "select temp.* from
		((SELECT id as plan_id,0 as travell_id, lat_position,long_position, location_name,start_time,updated_date as end_time, IF(activity ='Channel Card','Partner Visit',activity) as activity, date_format(updated_date,'%Y-%m-%d') as req_date,distance_travelled,order_number
		FROM plan_cards
		WHERE assign_to = $user_id and status='submitted'
		and date_format(updated_date,'%Y-%m-%d') in($dates_string)
		order by updated_date desc )
		UNION
		(SELECT 0 as plan_id, id as travell_id, latitude_position as lat_position,longitude_position as long_position,location_name,start_time, date_time as end_time, type as activity, date_format(date_time,'%Y-%m-%d') as req_date,distance_travelled,order_number
		FROM user_travellog
		WHERE user_id = $user_id
		and  date_format(date_time,'%Y-%m-%d') in($dates_string)
		order by date_time desc )) as temp
		where 1
		order by temp.order_number desc,temp.end_time desc ";
		$plan_log_details = Yii::$app->db->createCommand($plan_log_details)->queryAll();

		$plan_travell_log_details = array();
		foreach($plan_log_details as $plan_log_detail){
			$plan_travell_log_details[$plan_log_detail['req_date']][] = $plan_log_detail;
		}
		$data = $total_data = array();

		foreach($total_dates as $key => $updated_date) {
			$data['number_of_cards']  = $updated_date['plans_count'];
			$data['distance_travelled'] = $updated_date['distance'];
			$data['updated_date'] = $key . ' 00:00:00';
			$data['results'] = $plan_travell_log_details[$key];
    			$total_data[] = $data;
    }
    return $total_data;
    
    }
    /*  web service for travel details list end */
}
