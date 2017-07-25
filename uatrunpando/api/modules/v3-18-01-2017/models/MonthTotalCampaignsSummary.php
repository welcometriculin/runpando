<?php

namespace app\api\modules\v3\models;

use Yii;

/**
 * This is the model class for table "month_total_campaigns_summary".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $total
 * @property integer $month
 * @property integer $day
 * @property string $year
 */
class MonthTotalCampaignsSummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'month_total_campaigns_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'total', 'month', 'day', 'year'], 'required'],
            [['user_id', 'total', 'month', 'day'], 'integer'],
            [['year'], 'safe']
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
            'total' => 'Total',
            'month' => 'Month',
            'day' => 'Day',
            'year' => 'Year',
        ];
    }
    public static function totalCampaignMonthlyPerformance($user_id, $time, $current_year,$current_month)
    {
    	$result = array();
    		$y = array();
    		$year_campaigns_max = self::find()->select('max(day)')->where(['user_id' => $user_id, 'year' => $current_year, 'month' => $current_month])->scalar();
    		$year_campaigns = self::find()->select('*, total')->where(['user_id' => $user_id, 'year' => $current_year,'month' => $current_month])->asArray()->all();
    		$campaigns = array();
    		if (!empty($year_campaigns)) {
    			$existimbg_months = array();
    			foreach ($year_campaigns as $log) {
    				$campaigns[$log['day']]  = $log['total'];
    			}
    		
    		for ($i = 1; $i <= $year_campaigns_max; $i++) {
    			if (!array_key_exists($i, $campaigns)) {
    				$campaigns[$i] = 0;
    			}
    			$result[] = intval($campaigns[$i]);//intval for high charts
    		}
    		$sum = array_sum($result);
    		$avg = round($sum/count($result));
    		$sum_of_total = '<span>Total</span><span class="value">'.$sum.'</span>';
    		$average_of_total = '<span>Daily Average</span><span class="value">'.$avg.'</span>';
    		return [$result, $sum_of_total, $average_of_total];
    		}
    }
}
