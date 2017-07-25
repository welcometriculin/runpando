<?php

namespace app\api\modules\v3\models;

use Yii;
use app\api\modules\v3\models\PlanCards;
use yii\db\Expression;
/**
 * This is the model class for table "user_travellog".
 *
 * @property string $id
 * @property string $user_id
 * @property string $latitude_position
 * @property string $longitude_position
 * @property string $location_name
 * @property string $date_time
 * @property string $type
 *
 * @property Users $user
 */
class UserTravellog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_travellog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'latitude_position', 'longitude_position', 'location_name','distance_travelled','start_time'], 'required'],
            [['user_id','order_number'], 'integer'],
            [['latitude_position', 'longitude_position'], 'number'],
            [['date_time','start_time'], 'safe'],
            [['type'], 'string'],
            [['location_name'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'latitude_position' => 'Latitude Position',
            'longitude_position' => 'Longitude Position',
            'location_name' => 'Location Name',
            'date_time' => 'Date Time',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /* web service for distance calculation start */
    public static function getDistance($lat,$long,$prev_lat,$prev_long)
    {
    	$url = "https://maps.googleapis.com/maps/api/directions/json?origin=".$prev_lat.",".$prev_long."&destination=".$lat.",".$long."&sensor=false&mode=driving&alternatives=true";
    	$json = @file_get_contents($url);
    	$data = json_decode($json);
    	$distance = $data->routes[0]->legs[0]->distance->text;
    	$distance_array = explode(' ',$distance);
    	if(strtolower($distance_array[1]) == 'm') {
    		$distance_value = $distance_array[0]/1000;
    	} else {
    		$distance_value = $distance_array[0];
    	}
    	$location = $data->routes[0]->legs[0]->end_address;
    	return ['distnace' => $distance_value,'location' => $location];
    }
    /* web service for distance calculation end */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
    /* travelog start stop web service */
    public static function travellogstart($params)
    {
    	
    	$user_id = Yii::$app->user->identity->id;
    	$model = new UserTravellog();
    	$last_insert_id = UserTravellog::find()->select('id')->orderBy('id DESC')->one();
    	$model->mobile_timestamp = $last_insert_id['id'] + 1;
    	$model->user_id = $user_id;
    	$model->mode = 'online';
    	/* $location = $params['location_name'];
    	$lat = $params['latitude_position'];
    	$long = $params['longitude_position'];
    	if ($location == 'Location not available') {
    		$location = PlanCards::getAddress($lat, $long);
    	} */
    	if ($params['type'] == 'start') {
    		$distance = 0;
    		$location_name = PlanCards::getAddress($params['latitude_position'], $params['longitude_position']);
    		//$location_name = 'raybiz';
    	} else {
    		$distance_location = self::getDistance($params['latitude_position'],$params['longitude_position'],$params['prev_latitude_position'],$params['prev_longitude_position']);
    		 $distance = $distance_location['distnace'];
    		$location_name = $distance_location['location'];
    	/* 	$distance = 1;
    		$location_name = 'raybiz'; */
    	}
    	$model->distance_travelled = $distance;
    	$model->location_name = $location_name;
    	$model->latitude_position = $params['latitude_position'];
    	$model->longitude_position = $params['longitude_position'];
    	$model->type = $params['type'];
    	//$model->date_time = new Expression('NOW()');
    	$model->order_number = $params['order_number'];
    	$model->date_time = date("Y-m-d H:i:s", $params['mobile_timestamp']/1000);
    	$start_time = self::travelstart_time($params['mobile_timestamp']);
    	$model->start_time = $start_time;
    	if ($model->save(false)) {
    		$message = 'Successfully saved';
    	} else {
    		$message = 'Not saved';
    	}
		return $message;
    }
    /* travelog start stop web service end */
    
    /* for user travelog start_time web service start */
    public static function travellogstart_time($sTimestamp) 
    {
    	 
    	$user_id = Yii::$app->user->identity->id;
    	//$current_date = date('Y-m-d');
    	$current_date = date("Y-m-d", $sTimestamp/1000);
    	$currentTimeStamp = date("Y-m-d H:i:s", $sTimestamp/1000);
	    $usertravellog = UserTravellog::find()->select('date_time')
														    ->where(['user_id' => $user_id])
														    ->andWhere(['type' => 'start','DATE(date_time)' => $current_date])
														    ->orderBy('id DESC')
														    ->one();
//  	    echo '<pre>';print_r($usertravellog);exit;
	  /*  if(empty($usertravellog)) {
	    	$usertravellog_time = strtotime(date('Y-m-d H:i:s'));
	    	$usertravellog['date_time'] = date('Y-m-d H:i:s');
	    } else {
	    	$usertravellog_time = strtotime($usertravellog['date_time']);
	    }*/
	    $plancards_updatetime = PlanCards::find()->select('updated_date')
														    ->where(['assign_to' => $user_id])
														    ->andWhere(['status' => 'submitted','DATE(updated_date)' => $current_date])
														    ->orderBy('updated_date DESC')
														    ->one();
	    if($plancards_updatetime['updated_date'] != '' && $usertravellog['date_time'] != ''){
	    	if(strtotime($plancards_updatetime['updated_date']) > strtotime($usertravellog['date_time'])){
	    		$start_time = $plancards_updatetime['updated_date'];
	    	}
	    	else{
	    		$start_time = $usertravellog['date_time'];
	    	}	    	
	    }
	    else if($plancards_updatetime['updated_date'] != ''){
	    	$start_time = $plancards_updatetime['updated_date'];
	    }
	    else if($usertravellog['date_time'] != ''){
	    	$start_time = $usertravellog['date_time'];
	    }
	    else{
	    	$start_time = $currentTimeStamp;
	    }
	    
	   /* if(empty($plancards_updatetime)) {
	    	$plancards_time = $usertravellog_time;
	    	$plancards_updatetime['updated_date'] = $usertravellog_time;
	    } else {
	        $plancards_time = strtotime($plancards_updatetime['updated_date']);
	    } 
	    if ($usertravellog_time == $plancards_time){
	    	$start_time = $usertravellog['date_time'];
	    }
	    	elseif ($usertravellog_time > $plancards_time) {
	    	$start_time = $usertravellog['date_time'];
	    }	elseif ($usertravellog_time < $plancards_time){
	    	$start_time = $plancards_updatetime['updated_date'];
	    }*/
	   
	    return $start_time;
    }
    /* for user travelog start_time web service end */
    
    // start stop per day web service
    public static function startStop($user_id,$date_time)
    {
    	$query = self::find()->select('user_id,latitude_position as lat_position,longitude_position as long_position,location_name,distance_travelled,date_time as end_time,start_time,type as activity,')
						    	->where(['user_id' => $user_id])
						    	->andWhere(["DATE_FORMAT(date_time, '%Y-%m-%d')" => "$date_time"])
						    	->asArray()
						    	->all();
    	return $query;
    }
    
    // for only user travel log service
    public static function travelstart_time($startTimestamp)
    {
    	$user_id = Yii::$app->user->identity->id;
    	$current_date = date("Y-m-d", $startTimestamp/1000);
    	$currentTimeStamp = date("Y-m-d H:i:s", $startTimestamp/1000);
    	$usertravellog = UserTravellog::find()->select('date_time')
													    	->where(['user_id' => $user_id,'date(date_time)' => $current_date])
													    	->orderBy('id DESC')
													    	->one();
     if(empty($usertravellog)) {
     		
	    	$usertravellog_time = strtotime($currentTimeStamp);
	    	$usertravellog['date_time'] = $currentTimeStamp;
	    } else {
	    	$usertravellog_time = strtotime($usertravellog['date_time']);
	    }
    	$plancards_updatetime = PlanCards::find()->select('updated_date')
													    	->where(['assign_to' => $user_id])
													    	->andWhere(['status' => 'submitted','date(updated_date)' => $current_date])
													    	->orderBy('updated_date DESC')
													    	->one();
    	 if(empty($plancards_updatetime)) {
	    	$plancards_time = $usertravellog_time;
	    	$plancards_updatetime['updated_date'] = $usertravellog_time;
	    } else {
	        $plancards_time = strtotime($plancards_updatetime['updated_date']);
	    } 
	    if ($usertravellog_time == $plancards_time){
	    	$start_time = $usertravellog['date_time'];
	    }
	    elseif ($usertravellog_time > $plancards_time) {
	    	$start_time = $usertravellog['date_time'];
	    } elseif ($usertravellog_time < $plancards_time){
	    	$start_time = $plancards_updatetime['updated_date'];
	    } 
	   
	    return $start_time;
    }
    //for user travelog offline start_time web service start
    public static function travellogofflinestart_time()
    {
    
    	$user_id = Yii::$app->user->identity->id;
    	$current_date = date('Y-m-d');
    	$usertravellog = UserTravellog::find()->select('date_time')
    	->where(['user_id' => $user_id])
    	->andWhere(['type' => 'start','DATE(date_time)' => $current_date])
    	->orderBy('id DESC')
    	->one();
    	
    	$plancards_updatetime = PlanCards::find()->select('updated_date')
    	->where(['assign_to' => $user_id])
    	->andWhere(['status' => 'submitted','DATE(updated_date)' => $current_date])
    			->orderBy('updated_date DESC')
    			->one();
    			if($plancards_updatetime['updated_date'] != '' && $usertravellog['date_time'] != ''){
    			if(strtotime($plancards_updatetime['updated_date']) > strtotime($usertravellog['date_time'])){
    				$start_time = $plancards_updatetime['updated_date'];
    			}
    			else{
    			$start_time = $usertravellog['date_time'];
    			}
    			}
    			else if($plancards_updatetime['updated_date'] != ''){
    				$start_time = $plancards_updatetime['updated_date'];
    			}
    			else if($usertravellog['date_time'] != ''){
    					$start_time = $usertravellog['date_time'];
    			}
    			else{
	    	$start_time = date('Y-m-d H:i:s');
    }
    return $start_time;
    }
    
    /* order for travellog data - web service */
    
    public static function orderValue() 
    {
    	$userId = Yii::$app->user->identity->id;
    	$query1 = (new \yii\db\Query())
    	->select("order_number")
    	->from('plan_cards')
    	->where(['assign_to' => $userId]);
    	 
    	$query2 = (new \yii\db\Query())
    	->select("order_number")
    	->from('user_travellog')
    	->where(['user_id' => $userId]);
    	 
    	return $unionQuery = (new \yii\db\Query())
    	->select('max(order_number) as orderValue')
    	->from(['dummy_name' => $query1->union($query2)])
    	->scalar();
    }
    /* order for travellog data - web service */
}