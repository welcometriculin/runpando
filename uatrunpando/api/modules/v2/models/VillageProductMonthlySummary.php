<?php

namespace app\api\modules\v2\models;

use Yii;

/**
 * This is the model class for table "village_product_monthly_summary".
 *
 * @property string $id
 * @property string $user_id
 * @property string $village_name
 * @property string $product1
 * @property integer $product1_total
 * @property string $product2
 * @property integer $product2_total
 * @property string $product3
 * @property integer $product3_total
 * @property string $product4
 * @property integer $product4_total
 * @property string $total
 * @property string $month
 * @property string $year
 */
class VillageProductMonthlySummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'village_product_monthly_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'village_name', 'product1', 'product2', 'product3', 'product4', 'total', 'month', 'year','village_id'], 'required'],
            [['user_id', 'product1', 'product2', 'product3', 'product4', 'product1_total', 'product2_total', 'product3_total', 'product4_total', 'total', 'month','village_id'], 'integer'],
            [['year'], 'safe'],
            [['village_name', 'product1', 'product2', 'product3', 'product4'], 'string', 'max' => 100]
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
            'village_name' => 'Village Name',
            'product1' => 'Product1',
            'product1_total' => 'Product1 Total',
            'product2' => 'Product2',
            'product2_total' => 'Product2 Total',
            'product3' => 'Product3',
            'product3_total' => 'Product3 Total',
            'product4' => 'Product4',
            'product4_total' => 'Product4 Total',
            'total' => 'Total',
            'month' => 'Month',
            'year' => 'Year',
        ];
    }
    public static function villageProductMonthlyPerformance($user_id, $time, $current_year,$current_month)
    {
    	/* $village_product_summary = self::find()->select('village_name, product1, SUM(product1_total) AS product1_total, product2, SUM(product2_total) AS product2_total, product3, SUM(product3_total) AS product3_total, product4, SUM(product4_total) AS product4_total, SUM(total) as total')
    	->where(['user_id' => $user_id, 'year' => $current_year, 'month' =>$current_month])
    	->groupBy('village_name, product1, product2, product3, product4')
    	->asArray()
    	->all(); */
    	$query = 'SELECT if(vp.product4 = 2147483647, "others", ifnull(pr4.product_name,"N/A")) AS product4, vp.village_id, mv.village_name, ifnull(pr1.product_name,"N/A") AS product1, SUM(vp.product1_total) AS product1_total, ifnull(pr2.product_name,"N/A") AS product2, SUM(vp.product2_total) AS product2_total, ifnull(pr3.product_name,"N/A") AS product3, SUM(vp.product3_total) AS product3_total, SUM(vp.product4_total) AS product4_total, SUM(vp.total) as total
    	FROM village_product_monthly_summary vp
  		LEFT JOIN villages_master mv ON mv.village_id = vp.village_id	
    	LEFT JOIN products pr1 ON pr1.id = vp.product1
    	LEFT JOIN products pr2 ON pr2.id = vp.product2
    	LEFT JOIN products pr3 ON pr3.id = vp.product3
    	LEFT JOIN products pr4 ON pr4.id = vp.product4
    	WHERE vp.user_id = "'.$user_id.'"
    	AND vp.year = "'.$current_year.'"
    	AND vp.month = "'.$current_month.'"
    	GROUP BY vp.village_id, vp.product1, vp.product2, vp.product3, vp.product4
    	ORDER BY mv.village_name asc';
    	$village_product_summary = Yii::$app ->db->createCommand($query)->queryAll();
    	//echo '<pre>'; print_r($village_product_summary);exit;
    	$village_product_summary_content = '';
    	if (!empty($village_product_summary)) {
    		$village_product_summary_content = "<tbody>";
    		foreach ($village_product_summary as $village_product) {
    			$village_product_summary_content .= "<tr>
    												<th><p>".$village_product['village_name']."</p><span class='pull-right'>".$village_product['total']."</span></th>
													<td><p>".$village_product['product1']."</p><span class='pull-right'>".$village_product['product1_total']."</span></td>
													<td><p>".$village_product['product2']."</p><span class='pull-right'>".$village_product['product2_total']."</span></td>
													<td><p>".$village_product['product3']."</p><span class='pull-right'>".$village_product['product3_total']."</span></td>
													<td><p>".$village_product['product4']."</p><span class='pull-right'>".$village_product['product4_total']."</span></td>
												</tr>";
    		}
    		$village_product_summary_content .= "</tbody>";
    	}
    	return $village_product_summary_content;
    }
}
