<?php
namespace app\api\modules\v4\controllers;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\filters\ContentNegotiator;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
//use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\db\Query;
use yii;
use yii\web\UnauthorizedHttpException;
use app\api\modules\v4\models\PlanCards;
use app\api\modules\v4\models\WebService;
use app\api\modules\v4\models\UserTravellog;
use app\api\modules\v4\models\CampaignCardActivities;
use app\api\modules\v4\models\FavCrops;
use app\api\modules\v4\models\FavProducts;
use app\api\modules\v4\controllers\SyncdbController;
use yii\db\Expression;
use app\api\modules\v4\models\FavVillages;
use app\api\modules\v4\models\FavChannelpartners;
use app\api\modules\v4\models\Villages;
use app\api\modules\v4\models\ChannelPartners;
use app\api\modules\v4\models\ChannelCardTrackingInfo;
use app\api\modules\v4\models\ChannelCardActivities;


class PlancardController extends ActiveController
{
	public $modelClass = 'app\api\modules\v4\models\PlanCards';
	
	public function behaviors()
	{
		$behaviors = parent::behaviors();
		$behaviors['authenticator'] = [
				'class' => CompositeAuth::className(),
				'authMethods' => [
						//HttpBasicAuth::className(),
						//HttpBearerAuth::className(),
						QueryParamAuth::className(),
				],
		];
		$behaviors['contentNegotiator'] = [
				'class' => ContentNegotiator::className(),
				'formats' => [
						'application/json' => Response::FORMAT_JSON,
						//'application/xml' => Response::FORMAT_XML,
				],
		];

		return $behaviors;
	}
	
	public function actions()
	{
		$actions = parent::actions();

		unset($actions['login'],$actions['delete'],$actions['view']);
		// customize the data provider preparation with the "prepareDataProvider()" method
		//$actions['login']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

		return $actions;
	}
	
//plancard creation 
	public function actionCreatecard()
	{
		$params = Yii::$app->getRequest()->getBodyParams();
		// webservice data checking
		  $obj = new WebService();
		$jsondata = json_encode($params);
		$obj->params = $jsondata;
		$obj->service_name = 'create card';
		$obj->save(); 
		//end of data insertion
		$user_id = Yii::$app->user->identity->id;
		$plan_date = date("Y-m-d", strtotime($params['planned_date']));
		$plan_type=PlanCards::planType($plan_date,date('Y-m-d H:i:s'));
		$model = new PlanCards();
		$model->assign_to = Yii::$app->user->identity->id;
		$model->plan_type=$plan_type;
		$model->planned_date = date("Y-m-d", strtotime($params['planned_date']));
		$last_insert_id = PlanCards::find()->select('id')->orderBy('id DESC')->one();
		$model->mobile_timestamp = $last_insert_id['id'] + 1;
		$model->creation_mode = 'online';
		$mobileTimestamp = date("Y-m-d H:i:s", $params['mobile_timestamp']/1000);
		$model->created_date = $mobileTimestamp;
		$model->updated_date = $mobileTimestamp;
		$model->attributes = $params;
		if($params['activity'] == "Partner Visit")
		{
			$model->card_type = 'channel card';
			$model->activity = 'Channel Card';
		} else {
			$model->channel_partner = NULL;
		}
		if ($model->save(false)) {
			$details = 'card created successfully';
		} else{
			$details = 'card not created';
		}
		
		$date_time=$params['hit_timestamp'];
		if ($date_time == '') {
			$date= "";
		} else {
			$date= "and created_date > '".$date_time."'";
		}
		//villages list ,crops list,products list
		//$res= PlanCards::cardCreate($params);
		$villages = Villages::villageData($date,$user_id);
		$channel_partners = ChannelPartners::partnersdata($date,$user_id);
		$crops_favourites = FavCrops::favCropsInsert($params, $user_id);
// 		$products_favourites = FavProducts::favProductsInsert($params, $user_id);
		if (array_key_exists('products_favourites', $params)) {
			$products_fav = $params['products_favourites'];
			if (array_key_exists('campaign_favourites', $products_fav)) {
				$products_favourites = FavProducts::favProductsInsert($products_fav, $user_id);
			}
			if (array_key_exists('channel_favourites', $products_fav)) {
				$products_favourites = FavProducts::favProductsInsert($products_fav, $user_id);
			}
		}
		$village_favourites = FavVillages::favVillagesInsert($params, $user_id);
		$channel_partners_favourites = FavChannelpartners::favPartnersInsert($params, $user_id);
		return  ['details'=> $details,
				'villages'=> $villages,
				'channel_partners'=> $channel_partners,
				'hit_timestamp' => date('Y-m-d H:i:s'),
				'status'=>true];
		
	}
	public function actionSubmit()
	{
		 $params = Yii::$app->getRequest()->getBodyParams();
		 $id = Yii::$app->user->identity->id;
		 $current_date = date('Y-m-d');
		  $web_model = new WebService();
		 $web_model->user_id = $id;
		 $web_model->params = json_encode($params);
		 $web_model->service_name = 'online complete card service';
		 $web_model->mode = 'online';
		 $web_model->save(false); 
		 $offline_response = (object) [];
		 if(array_key_exists('offline',$params)) {
		 	$offline_data = $params['offline'];
		 	$sync_controller = new SyncdbController('dummy1','dummy2');
		 	$offline_response = $sync_controller->actionOriginoffline($offline_data);
		 }
		 //user travel log type checking
		 /*$user_travelog_type = UserTravellog::find()->select('type')
											 ->where(['user_id' => $id,'date(date_time)' => $current_date])
											 ->orderBy('id DESC')
											 ->one();
		if (empty($user_travelog_type)) {
			return ['message' => 'Please click start before submitting plan', 'status' => false];
		} else if($user_travelog_type['type'] == 'stop') {
			return ['message' => 'Please click start before submitting plan', 'status' => false];
		}*/
		 $is_deleted = PlanCards::find()->select('is_deleted')
		 								->where(['id' => $params['data']['plan_card_id']])
		 								->column();
		 if($is_deleted['0'] == 1){
		 	return ['message' => 'This plan has deleted', 'status' => false];
		 }
		if($is_deleted)
		$card_duplicate = CampaignCardActivities::find()->select('id')
														->where(['plan_card_id' => $params['data']['plan_card_id']])
														->count();
				
			if($card_duplicate >= 1) {
				return ['message' => 'This plan has submitted previously', 'status' => false];
			}												
		//user travel log type checking end
		 $result= PlanCards::dataSubmit($params,$id);
		 $locations = CampaignCardActivities::locationList();
		 return ['data' => $result,'locations' => $locations,'status' => true,'offline_response' =>$offline_response];
	}
	
	public function actionGetdata()
	{
		return $_GET['kiran'];
	}
	public function actionDate()
	{
		return $date = date("Y/m/d");
		
	}
	public function actionComplete()
	{	
		$params = Yii::$app->getRequest()->getBodyParams();
		$user_id=Yii::$app->user->identity->id;
		$date_time= $params['date_time'];
		/* $web_model = new WebService();
		$web_model->user_id = $user_id;
		$web_model->params = json_encode($params);
		$web_model->service_name = 'online complete card service';
		$web_model->mode = 'online';
		$web_model->save(false); */
		$offline_response = (object) [];
		if ($date_time == '') {
			  $date = ""; 
		} else {
			  $date= $date_time;
		}
		if(array_key_exists('offline',$params)) {
			$offline_data = $params['offline'];
			$sync_controller = new SyncdbController('dummy1','dummy2');
			$offline_response = $sync_controller->actionOriginoffline($offline_data);
		}
		$list = PlanCards::completeCards($date);
		//$history = array('data' => $list);
		return ['data' => $list ,'status'=>true,'time_stamp'=> date('Y-m-d H:i:s'),'offline_response' => $offline_response];
		//return $list;
	}
	
	public function actionLocation()
	{
			$list = CampaignCardActivities::locationList();
			if(empty($list)){
				return ['message'=>'No results found','status'=>true,'current_date'=> date("Y-m-d")];
			}
			return ['data'=>$list,'status'=>true,'current_date'=> date("Y-m-d")];
	}
	
	public function actionAllcards()
	{
		$params =Yii::$app->getRequest()->getBodyParams();
		$user_id=Yii::$app->user->identity->id;
    	$status = $params['status'];
    	$date_time = $params['date_time'];
    	if ($date_time == '') {
    		$date= "";
    	} else {
    		$date= "and updated_date > '".$date_time."'";
    	}
    	$model = $this->modelClass;
     	$data = $model::getAllCards($date);
     	$sum_pendingcards = PlanCards::countCards($user_id);
     	$week_pendingcards = PlanCards::wcountCards($user_id);
    	return  ['cards' =>$data,'day_count'=>$sum_pendingcards[0]['cards_count'],'week_count'=>$week_pendingcards[0]['count']];
	}
	
	public function actionProducts()
	{
		$params =Yii::$app->getRequest()->getBodyParams();
		$data = MasterProducts::products($params['hit_timestamp']);
		return ['data' => $data,'status' => true,'hit_timestamp' => date('Y-m-d H:i:s')];
	}
	//channel card submission
	public function actionChcard()
	{
		$params = Yii::$app->getRequest()->getBodyParams();
		$id = Yii::$app->user->identity->id;
		
		$web_model = new WebService();
		$web_model->user_id = $id;
		$web_model->params = json_encode($params);
		$web_model->save(false);
		
		$current_date = date('Y-m-d');
		if (array_key_exists('products_favourites', $params)) {
			$products_fav = $params['products_favourites'];
			if (array_key_exists('campaign_favourites', $products_fav)) {
				$products_favourites = FavProducts::favProductsInsert($products_fav, $id);
			}
			if (array_key_exists('channel_favourites', $products_fav)) {
				$products_favourites = FavProducts::favProductsInsert($products_fav, $id);
			}
		}
		
		$offline_response = (object) [];
		if(array_key_exists('offline',$params)) {
			$offline_data = $params['offline'];
			$sync_controller = new SyncdbController('dummy1','dummy2');
			$offline_response = $sync_controller->actionOriginoffline($offline_data);
		}
		$data = $params['data'];
		$lat = $data['lat_position'];
		$long = $data['long_position'];
		/* $location = $data['location_name'];
		if ($location == 'Location not available') {
			$location = PlanCards::getAddress($lat, $long);
		} */
		$card_id = $params['data']['plan_card_id'];
		//$distance = $data['distance_travelled'];
		$prev_lat = $data['prev_lat_position'];
		$prev_long = $data['prev_long_position'];
		$distance_location = UserTravellog::getDistance($lat,$long,$prev_lat,$prev_long);
		$distance = $distance_location['distnace'];
		$location = $distance_location['location'];
		/* $distance = 1;
		$location = 'madhapur'; */
		//$timeStamp = date("Y-m-d H:i:s", $data['mobile_timestamp']/1000);
		$orderValue = $data['order_number'];
		$TimeStampV = date("Y-m-d H:i:s", $data['mobile_timestamp']/1000);
		$start_time = UserTravellog::travellogstart_time($data['mobile_timestamp']); //usertravellog start_time
		$chct_info = $params['data']['products'];
		/*$user_travelog_type = UserTravellog::find()->select('type')
													->where(['user_id' => $id,'date(date_time)' => $current_date])
													->orderBy('id DESC')
													->one();
		if (empty($user_travelog_type)) {
			return ['message' => 'Please restart the field activity to submit the plan.Do you want to restart it?', 'status' => false];
		} else if($user_travelog_type['type'] == 'stop') {
			return ['message' => 'Please restart the field activity to submit the plan.Do you want to restart it?', 'status' => false];
		}*/
		/*$card_duplicate = CampaignCardActivities::find()->select('id')
														->where(['plan_card_id' => $card_id])
														->count();*/
		$card_duplicate = PlanCards::find()->select('id')
											->where(['id' => $params['data']['plan_card_id']])
											->andWhere(['status' => 'submitted'])
											->count();
		if($card_duplicate >= 1) {
			return ['message' => 'already this plan submitted', 'status' => false];
		}
		if(!empty($chct_info)) {
			$chct_info = ChannelCardTrackingInfo::trackinginfo($chct_info,$params);
		}
		$chc_activities = ChannelCardActivities::channelcardinfo($params);
		$locations = CampaignCardActivities::locationList();
		$command = yii::$app->db->createCommand('UPDATE plan_cards SET status = "submitted", submission_mode = "online", lat_position ='.$lat.', long_position ='.$long.', location_name = "'.$location.'", distance_travelled = "'.$distance.'" , updated_date = "'.$TimeStampV.'", start_time = "'.$start_time.'", order_number = "'.$orderValue.'" WHERE id="'.$card_id.'"');
		$command->execute();
		return ['message'=> 'Plancard submitted successfully','locations' =>$locations,'offline_response' => $offline_response, 'status' => true];
	}
	//web service for travellog
	public function actionTravellog()
	{
		$params = Yii::$app->getRequest()->getBodyParams();
		//$travel_log_info = \app\models\PlanCards::travellog($params);
		$web_model = new WebService();
		$web_model->user_id = Yii::$app->user->identity->id;
		$web_model->params = json_encode($params);
		$web_model->service_name = 'travelog';
		$web_model->save(false);
		$travel_log_info = PlanCards::travelDetails($params);
		if (empty($travel_log_info)) {
			return ['message'=> 'No Results Found', 'status' => true];
		}
		return ['data'=> $travel_log_info, 'status' => true];
		
	}
	//web service for travellog end
	//web service for travellogstartstop
	public function actionTravellogstartstop()
	{
		$params = Yii::$app->getRequest()->getBodyParams();
		$id = Yii::$app->user->identity->id;
		$web_model = new WebService();
		$web_model->user_id = $id;
		$web_model->params = json_encode($params);
		$web_model->save(false);
		/* $automatic_time_zone = $params['automatic_time_zone'];
		$automatic_date_time = $params['automatic_date_time'];
		$mobileTimeStamp = date("Y-m-d H:i:s", $params['mobile_timestamp']/1000);
		$service_name = 'startStop';
		$mode = 'online';
		$this->actionMobiletime($automatic_time_zone,$automatic_date_time,$mobileTimeStamp,$params,$service_name,$mode); */
		$travel_log_start = UserTravellog::travellogstart($params);
		if($travel_log_start == 'Successfully saved')
		return ['data'=> $travel_log_start, 'start_stop_status' => true];
		else
		return ['data'=> $travel_log_start, 'start_stop_status' => false];
	}
	//web service for travellogstartstop end
}
