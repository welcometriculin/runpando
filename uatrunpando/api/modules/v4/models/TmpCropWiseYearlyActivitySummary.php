<?php

namespace app\api\modules\v4\models;

use Yii;

/**
 * This is the model class for table "tmp_crop_wise_yearly_activity_summary".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $crop_name
 * @property integer $demo
 * @property integer $fgm
 * @property integer $mc
 * @property integer $fhv
 * @property integer $total
 * @property integer $month
 * @property string $year
 */
class TmpCropWiseYearlyActivitySummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tmp_crop_wise_yearly_activity_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'crop_name', 'demo', 'fgm', 'mc', 'fhv', 'total', 'crop_id','month', 'year'], 'required'],
            [['user_id', 'demo', 'fgm', 'mc', 'fhv', 'total', 'month','crop_id'], 'integer'],
            [['year'], 'safe'],
            [['crop_name'], 'string', 'max' => 100]
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
            'crop_name' => 'Crop Name',
            'demo' => 'Demo',
            'fgm' => 'Fgm',
            'mc' => 'Mc',
            'fhv' => 'Fhv',
            'total' => 'Total',
            'month' => 'Month',
            'year' => 'Year',
        ];
    }
    
    public static function groupCampaignsPerformance($user_id, $time, $current_year)
    {
    	$act = array('fgm','fhv','demo','mc');
    	$result = array();
    	$temp = array();
    	$tmpArray = $count = array();
    	$sum_of_total = array();
    	$average_of_total = array();
    	foreach($act as $actvity) {
    		$group_campaigns_year_summary = self::find()
    		->select('SUM('.$actvity.') as '.$actvity.' ,month')
    		->where(['user_id' => $user_id,'year' => $current_year])
    		->groupBy('month')
    		->asArray()
    		->all();
    		$year_activity_max = self::find()
    		->select('max(month)')
    		->where(['user_id' =>$user_id,'year' =>$current_year ])
    		->scalar();
    		if (!empty($group_campaigns_year_summary)) {
    			for ($k =1;$k<$year_activity_max;$k++) {
    				$count[$k]  = 0;
    			}
    			foreach ($group_campaigns_year_summary as $log) {
    				$month = (int)$log['month'];
    				$count[$month]  = intval($log[$actvity]);
    			}
    			$tmpArray = array_values($count);
    			// 					foreach ($count as $cnt=>$details) {
    			// 						$tmpArray[] = $details;
    			$tmpArray2 = array_sum($tmpArray);
    			if ($tmpArray2 == 0) {
    				$result [$actvity] = 0;
    				$sum[$actvity] = 0;
    				$avg[$actvity] = 0;
    				$sum_of_total[$actvity] = '<span>Total</span><span class="value">'.$sum[$actvity].'</span>';
    				$average_of_total[$actvity] = '<span>Monthly Average</span><span class="value">'.$avg[$actvity].'</span>';
    			} else {
    				$result [$actvity] = $tmpArray;
    				$sum[$actvity] = array_sum($tmpArray);
    				$avg[$actvity] = round($sum[$actvity]/count($tmpArray));
    				$sum_of_total[$actvity] = '<span>Total</span><span class="value">'.$sum[$actvity].'</span>';
    				$average_of_total[$actvity] = '<span>Monthly Average</span><span class="value">'.$avg[$actvity].'</span>';
    			}
    		}
    	}
    	return [$result, $sum_of_total, $average_of_total];
    }
    /* web service for activity wise crop start */
    public static function totalActivityWise($user_id, $current_year, $activity)
    {
    	$result = array();
    	$temp = array();
//     	$crops[$activity]  =  self::find()->select('crop_name,sum('.$activity.') as value')->where(['user_id' => $user_id,'year' => $current_year])->orderBy('value desc')->groupBy('crop_name,month')->asArray()->all(); 
    	$query = 'SELECT IF( tc.crop_id = 2147483647,  "others", cr.crop_name ) AS crop_name, SUM( tc.'.$activity.' ) AS value
    	FROM  tmp_crop_wise_yearly_activity_summary tc
    	LEFT JOIN crops cr ON cr.id = tc.crop_id
    	WHERE tc.user_id = "'.$user_id.'"
    	AND tc.year = "'.$current_year.'"
    	GROUP BY tc.crop_id
    	ORDER BY  value DESC';
    	$crops[$activity] = Yii::$app->db->createCommand($query)->queryAll();
    	$count = count($crops[$activity]);
    	$log = $crops[$activity];
    	if($count > 4 && $count != 4) {
    		$crop_array = array_slice($log, 3, $count);
    		foreach ($crop_array as $crop) {
    			$temp[] = $crop['value'];
    		}
    		$other_crop = array('crop_name' => 'Others', 'value' => array_sum($temp));
    		$total_crops = array_slice($log, 0, 3);
    		array_push($total_crops, $other_crop);
    	} else {
    		$total_crops = $log;
    	}
    	return $total_crops;
    }
    /* web service for activity wise crop end */
}
