<?php

namespace app\api\modules\v3\models;

use Yii;

/**
 * This is the model class for table "travellog_yearly_summary".
 *
 * @property string $id
 * @property string $user_id
 * @property string $month
 * @property string $year
 * @property string $total_distance
 */
class TravellogYearlySummary extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'travellog_yearly_summary';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
				[['user_id', 'month', 'year', 'total_distance'], 'required'],
				[['user_id', 'month'], 'integer'],
				[['year'], 'safe'],
				[['total_distance'], 'number'],
				[['year', 'month', 'user_id'], 'unique', 'targetAttribute' => ['year', 'month', 'user_id'], 'message' => 'The combination of User ID, Month and Year has already been taken.']
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
				'month' => 'Month',
				'year' => 'Year',
				'total_distance' => 'Total Distance',
		];
	}
	public static function travelDistanceChart($user_id,$current_year)
	{
		$model = new TravellogYearlySummary;
		$distance = $model->find()->select('month,total_distance')
		->where(['year' => $current_year,'user_id' =>$user_id])
		->groupBy('month')
		->asArray()
		->all();
		//echo '<pre>';print_r($distance);
		if (!empty($distance)) {
			$year_travellog_max = $model->find()->select('MAX(month)')
			->where(['year' => $current_year,'user_id' =>$user_id])
			->asArray()
			->scalar();
			$dis = array();
			foreach ($distance as $log) {
				$dis[$log['month']]  = $log['total_distance'];
			}
			for($i=1;$i<= $year_travellog_max; $i++) {
				if(!array_key_exists($i,$dis)) {
					$dis[$i] = "0";
				}
				$temp[] = (float)($dis[$i]);
			}
			$sum = array_sum($temp);
			$avg = round($sum/count($temp),2);
			$sum_of_distance = '<span>Distance</span><span class="value">'.$sum.' Km</span>' ;
			$average_of_distance = '<span>Monthly Average</span><span class="value">'.$avg.' Km</span>' ;
				
			return [$temp,$sum_of_distance,$average_of_distance];
		}
	}
}
