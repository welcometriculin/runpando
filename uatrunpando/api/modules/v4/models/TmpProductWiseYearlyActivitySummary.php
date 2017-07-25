<?php

namespace app\api\modules\v4\models;

use Yii;

/**
 * This is the model class for table "tmp_product_wise_yearly_activity_summary".
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
 * @property string $year
 */
class TmpProductWiseYearlyActivitySummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tmp_product_wise_yearly_activity_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'product_name', 'demo', 'fgm', 'mc', 'fhv', 'total', 'month', 'year', 'product_id'], 'required'],
            [['user_id', 'demo', 'fgm', 'mc', 'fhv', 'total', 'month', 'product_id'], 'integer'],
            [['year'], 'safe'],
            [['product_name'], 'string', 'max' => 100],
            [['user_id', 'year', 'month', 'product_name', 'product_id'], 'unique', 'targetAttribute' => ['user_id', 'year', 'month', 'product_name', 'product_id'], 'message' => 'The combination of User ID, Product Name, Month and Year has already been taken.']
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
            'year' => 'Year',
        ];
    }
    /* web service for activity wise products start */
    public static function totalActivityWise($user_id, $current_year, $activity)
    {
    	$result = array();
    	$temp = array();
		//$products[$activity] = self::find()->select('product_name,sum('.$activity.') as value')->where(['user_id' => $user_id,'year' => $current_year])->orderBy('value desc')->groupBy('product_name,month')->asArray()->all();    	
    	$query = 'SELECT IF( tp.product_id = 2147483647,  "others", pr.product_name ) AS product_name, SUM( tp.'.$activity.' ) AS value
    	FROM  tmp_product_wise_yearly_activity_summary tp
    	LEFT JOIN products pr ON pr.id = tp.product_id
    	WHERE tp.user_id = "'.$user_id.'"
    	AND tp.year = "'.$current_year.'"
    	GROUP BY tp.product_id
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
