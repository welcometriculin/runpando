<?php

namespace app\models;

use Yii;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "plan_cards".
 *
 * @property integer $id
 * @property string $guid
 * @property integer $assign_to
 * @property string $card_type
 * @property string $planned_date
 * @property string $plan_type
 * @property string $crop_name
 * @property string $product_name
 * @property string $channel_partner
 * @property string $village_name
 * @property string $activity
 * @property string $distance_travelled
 * @property string $status
 * @property string $plan_approval_status
 * @property string $created_date
 * @property integer $created_by
 * @property string $updated_date
 * @property integer $updated_by
 * @property integer $is_deleted
 *
 * @property CampaignCardActivities[] $campaignCardActivities
 * @property ChannelCardActivities[] $channelCardActivities
 * @property ChannelCardActivities[] $channelCardActivities0
 * @property Users $assignTo
 */
class TravelLog extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public $plan_card_count; //for travellog search model
	public $end_time; //for travellog search model details method
	public $free_text_search;//for keyword search

	public static function tableName()
	{
		return 'plan_cards';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
				[['guid', 'assign_to', 'card_type', 'planned_date', 'plan_type', 'crop_name', 'product_name', 'channel_partner', 'village_name', 'activity', 'distance_travelled', 'created_date', 'created_by', 'updated_date', 'updated_by', 'is_deleted'], 'required'],
				[['assign_to', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
				[['card_type', 'plan_type', 'activity', 'status', 'plan_approval_status'], 'string'],
				[['planned_date', 'created_date', 'updated_date'], 'safe'],
				[['distance_travelled'], 'number'],
				[['guid', 'village_name'], 'string', 'max' => 50],
				[['crop_name', 'channel_partner'], 'string', 'max' => 255],
				[['product_name'], 'string', 'max' => 100]
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
				'assign_to' => 'Assign To',
				'card_type' => 'Card Type',
				'planned_date' => 'Planned Date',
				'plan_type' => 'Plan Type',
				'crop_name' => 'Crop Name',
				'product_name' => 'Product Name',
				'channel_partner' => 'Channel Partner',
				'village_name' => 'Village Name',
				'activity' => 'Activity',
				'distance_travelled' => 'Distance Travelled',
				'status' => 'Status',
				'plan_approval_status' => 'Plan Approval Status',
				'created_date' => 'Created Date',
				'created_by' => 'Created By',
				'updated_date' => 'Updated Date',
				'updated_by' => 'Updated By',
				'is_deleted' => 'Is Deleted',
		];
	}

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
	//for travel log group concat location view and also for map
	public static function villagenames($assign_to, $updated_date)
	{
		$updated_date = explode(' ', $updated_date);
		$query = new \yii\db\Query;
		$query->select('location_name as DisplayText, lat_position, long_position,updated_date as end_time')
		->from('plan_cards')
		->where(['status' => 'submitted'])
		->andWhere(['assign_to' => $assign_to])
		->andWhere(['DATE(updated_date)' => $updated_date[0]]);
		$query = $query->createCommand()->queryAll();
		/* $query2 = UserTravellog::find()->select('location_name as DisplayText, latitude_position as lat_position, longitude_position as long_position,date_time as end_time')
		->where(['user_id' => $assign_to])
		->andWhere(['DATE(date_time)' => $updated_date[0]]);
		$unionQuery = (new \yii\db\Query())
		->from(['dummy_name' => $query->union($query2)])
		->orderBy(['end_time' => SORT_DESC])
		->all(); */
		if(!empty($query)) {
			foreach ($query as $latlong) {
				$latlong['DisplayText'] = addslashes($latlong['DisplayText']); //for map display in view
				$latlong['DisplayText'] = str_replace("\'", '\"', $latlong['DisplayText']);//for map display in view
				$latlong['LatitudeLongitude'] = $latlong['lat_position'].','.$latlong['long_position'];
				$s[] = $latlong;
			}
			$result = json_encode($s);
			return $result;
		} elseif (empty($query)) {
			$latlong['DisplayText'] = 'No Location';//for map display in view
			$latlong['lat_position'] = 0;
			$latlong['long_position'] = 0;
			$latlong['LatitudeLongitude'] = null;//for map empty display
			$s[] = $latlong;
			$result = json_encode($s);
			return $result;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
	//for travel log group concat location view and also for map end
	//for travel log distance travelled view
	public static function distance_travelled($assign_to, $updated_date)
	{
		$updated_date = explode(' ', $updated_date);
		$query = new \yii\db\Query;
		$query->select('SUM(distance_travelled) AS distance_travelled')
		->from('plan_cards')
		->where(['status' => 'submitted'])
		->andWhere(['assign_to' => $assign_to])
		->andWhere(['DATE(updated_date)' => $updated_date[0]]);
		$query = $query->createCommand()->queryOne();
		return $query;
	}
	//for travel log distance travelled view end
	//for travel log list of cards start
	public static function travellog_cardslist($assign_to, $updated_date)
	{
		$updated_date = explode(' ', $updated_date);
		$travellog_info_query = new \yii\db\Query;
		$travellog_info_query->select('COUNT(id) AS number_of_cards, SUM(distance_travelled) AS distance_travelled, updated_date')
		->from('plan_cards')
		->where(['status' => 'submitted'])
		->andWhere(['assign_to' => $assign_to])
		->andWhere(['DATE(updated_date)' => $updated_date[0]])
		->groupBy(['DATE(updated_date)'])
		->orderBy('DATE(updated_date) DESC');
		$travellog_info_query = $travellog_info_query->createCommand()->queryOne();

		/*$travellog_list_query = new \yii\db\Query;
		 $travellog_list_query->select('id, village_name, distance_travelled, start_time, updated_date as end_time')
		 ->from('plan_cards')
		 ->where(['status' => 'submitted'])
		 ->andWhere(['assign_to' => $assign_to])
		 ->andWhere(['DATE(updated_date)' => $updated_date[0]])
		 ->orderBy('DATE(updated_date) DESC');
		 $travellog_list_query = $travellog_list_query->createCommand()->queryAll();
		*/
		$result_array = array();
		$result_array[0] = $travellog_info_query;
		/*$result_array[1] = $travellog_list_query;*/
		return $result_array;
	}
	// //for travel log list of cards end
	//for getting travellog ff id
	public static function travellogFfId($id)
	{
		$sql = TravelLog::find()->select('assign_to')
								->from('plan_cards')
								->where(['guid' => $id])
								->one();
		return $sql;
	  
	}
	//for travellog grid sum distance in web
	public static function travellogsumdistance($user_id, $updated_date)
	{
	/* 	 $query = TravelLog::find()->select('distance_travelled')
								    	 ->from('plan_cards')
								    	 ->where(['status' => 'submitted'])
								    	 ->andWhere(['assign_to' => 560])
								    	 ->andWhere(['DATE_FORMAT(updated_date, "%Y-%m-%d")' => date('Y-m-d',strtotime($updated_date))]);
    	
    	$query2 = UserTravellog::find()->select('distance_travelled')
								    	->where(['user_id' => 560])
								    	->andWhere(["DATE_FORMAT(date_time, '%Y-%m-%d')" => date('Y-m-d',strtotime($updated_date))]);
    	
    	$distance_travelled = (new \yii\db\Query())
    					->select('SUM(distance_travelled) AS distance_travelled ')
				    	->from(['dummy_name' => $query->union($query2)])
    					->one();  */
    	

    	
    	$query = TravelLog::find()->select('id, location_name, activity, distance_travelled, start_time, updated_date as end_time')
    							  ->from('plan_cards')
    							->where(['status' => 'submitted'])
    							->andWhere(['assign_to' => $user_id])
    							->andWhere(['DATE_FORMAT(updated_date, "%Y-%m-%d")' => date('Y-m-d',strtotime($updated_date))]);
    	$query2 = UserTravellog::find()->select('id, location_name, type as activity, distance_travelled, start_time, date_time as end_time')
    									->where(['user_id' => $user_id])
    									->andWhere(["DATE_FORMAT(date_time, '%Y-%m-%d')" => date('Y-m-d',strtotime($updated_date))]);
    	$distance_travelled = (new \yii\db\Query())
    				->select('sum(distance_travelled) as distance_travelled ')
    				->from(['dummy_name' => $query->union($query2)])
    				->one();	
    	return substr($distance_travelled['distance_travelled'], 0 ,strpos($distance_travelled['distance_travelled'], '.')+4);
		 
	}
	public static function travellogtime($init)
	{
		$hours = floor($init / 3600);
		$hours = strlen($hours)==1?'0'.$hours:$hours;
		$minutes = floor(($init / 60) % 60);
		$minutes = strlen($minutes)==1?'0'.$minutes:$minutes;
		$seconds = $init % 60;
		$seconds = strlen($seconds)==1?'0'.$seconds:$seconds;
		return  $hours.':'. $minutes.':'. $seconds;
	}
}
