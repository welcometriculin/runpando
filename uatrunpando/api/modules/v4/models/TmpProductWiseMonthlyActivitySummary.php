<?php

namespace app\api\modules\v4\models;

use Yii;

/**
 * This is the model class for table "tmp_product_wise_monthly_activity_summary".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $product_name
 * @property integer $demo
 * @property integer $fgm
 * @property integer $mc
 * @property integer $fhv
 * @property integer $total
 * @property integer $month
 * @property integer $day
 * @property string $year
 */
class TmpProductWiseMonthlyActivitySummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tmp_product_wise_monthly_activity_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'product_name', 'demo', 'fgm', 'mc', 'fhv', 'total', 'month', 'day', 'year','product_id'], 'required'],
            [['user_id', 'demo', 'fgm', 'mc', 'fhv', 'total', 'month', 'day','product_id'], 'integer'],
            [['year'], 'safe'],
            [['product_name'], 'string', 'max' => 100],
            [['user_id', 'year', 'month', 'day', 'product_id'], 'unique', 'targetAttribute' => ['user_id', 'year', 'month', 'day', 'product_id'], 'message' => 'The combination of User ID, Product Name, Month, Day and Year has already been taken.']
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
            'product_name' => 'Product Name',
            'demo' => 'Demo',
            'fgm' => 'Fgm',
            'mc' => 'Mc',
            'fhv' => 'Fhv',
            'total' => 'Total',
            'month' => 'Month',
            'day' => 'Day',
            'year' => 'Year',
        ];
    }
    /* web service for activity wise products start */
    public static function totalActivityWise($user_id, $current_year, $current_month, $activity)
    {
    	$result = array();
    	$temp = array();
//     	$products[$activity] = self::find()->select('product_name,sum('.$activity.') as value')->where(['user_id' => $user_id,'month' => $current_month])->orderBy('value desc')->groupBy('product_name')->asArray()->all();
    	$query = 'SELECT IF( tc.product_id = 2147483647,  "others", pr.product_name ) AS product_name, SUM( tc.'.$activity.' ) AS value
    	FROM  tmp_product_wise_monthly_activity_summary tc
    	LEFT JOIN products pr ON pr.id = tc.product_id
    	WHERE tc.user_id = "'.$user_id.'"
    	AND tc.month = "'.$current_month.'"
    	GROUP BY tc.product_id
    	ORDER BY  value DESC';
    	$products[$activity] = Yii::$app->db->createCommand($query)->queryAll();
    	$count = count($products[$activity]);
    	$log = $products[$activity];
    	if($count > 4 && $count != 4) {
    		$products_array = array_slice($log, 3, $count);
    		foreach ($products_array as $product) {
    			$temp[] = $product['value'];
    		}
    		$other_product = array('product_name' => 'Others', 'value' => array_sum($temp));
    		$total_products = array_slice($log, 0, 3);
    		array_push($total_products, $other_product);
    	} else {
    		$total_products = $log;
    	}
    	return $total_products;
    }
    /* web service for activity wise products end */
}
