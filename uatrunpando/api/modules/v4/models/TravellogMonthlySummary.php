<?php

namespace app\api\modules\v4\models;

use Yii;

/**
 * This is the model class for table "travellog_monthly_summary".
 *
 * @property string $id
 * @property string $user_id
 * @property string $total_distance
 * @property string $day
 * @property string $month
 * @property string $year
 */
class TravellogMonthlySummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travellog_monthly_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'total_distance', 'day', 'month', 'year'], 'required'],
            [['user_id', 'day', 'month'], 'integer'],
            [['total_distance'], 'number'],
            [['year'], 'safe'],
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
            'total_distance' => 'Total Distance',
            'day' => 'Day',
            'month' => 'Month',
            'year' => 'Year',
        ];
    }
    public static function travelMonthDistanceChart($user_id,$current_year,$current_month) 
    {
    	$distance = self::find()->select('day,total_distance')
    	->where(['year' => $current_year,'month' => $current_month,'user_id' =>$user_id])
    	->asArray()
    	->all();
    	if (!empty($distance)) {
    		$month_travellog_max = self::find()->select('max(day)')
    		->where(['year' => $current_year,'user_id' =>$user_id,'month' => $current_month])
    		->asArray()
    		->scalar();
    		$dis = array();
    		foreach ($distance as $log) {
    			$dis[$log['day']]  = $log['total_distance'];
    		}
    		for($i=1;$i<= $month_travellog_max; $i++) {
    			if(!array_key_exists($i,$dis)) {
    				$dis[$i] = "0";
    			}
    			$temp[] = floatval($dis[$i]);
    		}
    		
//     		$i=1;
//     		foreach($temp as $dis) {
//     			$date = $current_year.'-'.$current_month.'-'.$i;
//     			$current_date = strtotime($date);
//     			$t[] = array("Date.UTC($current_year,$current_month,$i)",$dis);
//     			$i = $i+1;
//     		}
    		$sum = array_sum($temp);
    		$avg = round($sum/count($temp),2);
    		$sum_of_distance = '<span>Distance</span><span class="value">'.$sum.' Km</span>' ;
    		$average_of_distance = '<span>Daily Average</span><span class="value">'.$avg.' Km</span>' ;
			
    		return [$temp,$sum_of_distance,$average_of_distance];
    	}
    }
}
