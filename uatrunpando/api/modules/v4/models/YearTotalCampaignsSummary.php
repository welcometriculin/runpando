<?php

namespace app\api\modules\v4\models;

use Yii;

/**
 * This is the model class for table "year_total_campaigns_summary".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $total
 * @property integer $month
 * @property string $year
 */
class YearTotalCampaignsSummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'year_total_campaigns_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'total', 'month', 'year'], 'required'],
            [['user_id', 'total', 'month'], 'integer'],
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
            'year' => 'Year',
        ];
    }
    
    public static function totalCampaignPerformance($user_id, $time, $current_year)
    {
    	$result = array();
    	if ($time == 'year') {
    		$y = array();
    		$year_campaigns_max = self::find()->select('max(month)')->where(['user_id' => $user_id, 'year' => $current_year])->scalar();
    		$year_campaigns = self::find()->select('*, SUM(total) as total')->where(['user_id' => $user_id, 'year' => $current_year])->groupBy('month')->asArray()->all();
    		$campaigns = array();
    		if (!empty($year_campaigns)) {
    			$existimbg_months = array();
    			foreach ($year_campaigns as $log) {
    				$campaigns[$log['month']]  = $log['total'];
    			}
    		}
    		for ($i = 1; $i <= $year_campaigns_max; $i++) {
    			if (!array_key_exists($i, $campaigns)) {
    				$campaigns[$i] = "0";
    			}
    			$result[] = intval($campaigns[$i]);//intval for high charts
    		}
    		$sum = array_sum($result);
    		if (count($result) == 0) {
    			$avg = 0;
    		} else {
    			$avg = round($sum/count($result));
    		}
    		$sum_of_total = '<span>Total</span><span class="value">'.$sum.'</span>';
    		$average_of_total = '<span>Monthly Average</span><span class="value">'.$avg.'</span>';
    		return [$result, $sum_of_total, $average_of_total];
    	}
    }
}
