<?php

namespace app\api\modules\v4\models;

use Yii;

/**
 * This is the model class for table "village_product_yearly_summary".
 *
 * @property string $id
 * @property string $user_id
 * @property string $village_name
 * @property string $product1
 * @property string $product2
 * @property string $product3
 * @property string $product4
 * @property string $total
 * @property string $month
 * @property string $year
 */
class VillageProductYearlySummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'village_product_yearly_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'village_name', 'product1', 'product2', 'product3', 'product4', 'total', 'month', 'year','village_id'], 'required'],
            [['user_id', 'total', 'month','village_id'], 'integer'],
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
            'product2' => 'Product2',
            'product3' => 'Product3',
            'product4' => 'Product4',
            'total' => 'Total',
            'month' => 'Month',
            'year' => 'Year',
        ];
    }
    public static function villageProductPerformance($user_id, $time, $current_year)
    {
    	/* $village_product_summary = self::find()->select('village_name, product1, SUM(product1_total) AS product1_total, product2, SUM(product2_total) AS product2_total, product3, SUM(product3_total) AS product3_total, product4, SUM(product4_total) AS product4_total, SUM(total) as total')
    	->where(['user_id' => $user_id, 'year' => $current_year])
    	->groupBy('village_name, product1, product2, product3, product4, month')
    	->asArray()
    	->all(); */
    	$query = "SELECT if(vc.product4 = 2147483647, 'others', ifnull(pr4.product_name,'N/A')) AS product4, vc.village_id, mv.village_name, ifnull(pr1.product_name,'N/A') AS product1, SUM(vc.product1_total) AS product1_total, ifnull(pr2.product_name,'N/A') AS product2, SUM(vc.product2_total) AS product2_total, ifnull(pr3.product_name,'N/A') AS product3, SUM(vc.product3_total) AS product3_total, SUM(vc.product4_total) AS product4_total, SUM(vc.total) as total
    	FROM village_product_yearly_summary vc
    	LEFT JOIN villages_master mv ON mv.village_id = vc.village_id
    	LEFT JOIN products pr1 ON pr1.id = vc.product1
    	LEFT JOIN products pr2 ON pr2.id = vc.product2
    	LEFT JOIN products pr3 ON pr3.id = vc.product3
    	LEFT JOIN products pr4 ON pr4.id = vc.product4
    	WHERE vc.user_id = $user_id
    	AND vc.year = $current_year
    	GROUP BY vc.village_id, vc.product1, vc.product2, vc.product3, vc.product4, vc.month
    	ORDER BY mv.village_name asc";
    	$village_product_summary = Yii::$app ->db->createCommand($query)->queryAll();
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
