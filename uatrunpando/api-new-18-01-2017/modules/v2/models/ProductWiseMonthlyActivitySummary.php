<?php

namespace app\api\modules\v2\models;

use Yii;

/**
 * This is the model class for table "product_wise_monthly_activity_summary".
 *
 * @property string $id
 * @property string $user_id
 * @property string $product_name
 * @property string $demo
 * @property string $fgm
 * @property string $mc
 * @property string $fhv
 * @property string $total
 * @property string $day
 * @property string $month
 */
class ProductWiseMonthlyActivitySummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_wise_monthly_activity_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'product_name', 'demo', 'fgm', 'mc', 'fhv', 'total', 'day', 'month','year','product_id'], 'required'],
            [['user_id', 'demo', 'fgm', 'mc', 'fhv', 'total', 'day', 'month','product_id'], 'integer'],
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
            'user_id' => 'User ID',
            'product_name' => 'Product Name',
            'demo' => 'Demo',
            'fgm' => 'Fgm',
            'mc' => 'Mc',
            'fhv' => 'Fhv',
            'total' => 'Total',
            'day' => 'Day',
            'month' => 'Month',
        ];
    }
    public static function productActivityMonthlyPerformance($user_id, $time, $current_year,$current_month)
    {
//     	$product_year_log = self::find()->select('product_name,sum(fgm) as fgm,sum(fhv) as fhv,sum(mc) as mc,sum(demo) as demo,sum(total) as total')
//     	->where(['user_id' => $user_id,'year' => $current_year, 'month' =>$current_month ])
//     	->groupBy('product_name')
//     	->orderBy('total desc')
//     	->asArray()->all();
    	$query = 'SELECT IF( pm.product_id = 2147483647,  "others", pr.product_name ) as product_name, SUM( pm.fgm ) AS fgm, SUM( pm.fhv ) AS fhv, SUM( pm.mc ) AS mc, SUM( pm.demo ) AS demo, SUM( pm.total ) AS total
					FROM product_wise_monthly_activity_summary pm
					LEFT JOIN products pr ON pr.id = pm.product_id
					WHERE pm.user_id = "'.$user_id.'"
					AND pm.month = 	"'.$current_month.'"
					AND pm.year = "'.$current_year.'"
					GROUP BY pm.product_id
					ORDER BY FIELD( pm.product_id,  "2147483647" ) DESC , total ASC,pr.product_name';
			$product_year_log = Yii::$app->db->createCommand($query)->queryAll();
    	 
    	//product wise activity summary
    	if(!empty($product_year_log)) {
    		$actvities = array('fgm','fhv','demo','mc');
    		foreach($actvities as $activity) {
    			$product_dataPoints = array();
    			foreach ($product_year_log as $product) {
    				$labelvalue = $value = round(($product[$activity]/$product['total']) * 100,0);
    				//$label = $product['product_name'].' ('.$product['total'].')';
    				$label = strlen($product['product_name']) > 6 ? substr($product['product_name'], 0, 6). '.. ('.$product['total'].')' : $product['product_name'].' ('.$product['total'].')';
    				
    				if($value==0) {
    					$label = $labelvalue ='';
    					}
    				$product_dataPoints[] = array('y' => $value,
    						'label' => $label,
    						'indexLabel' => "'".$labelvalue."'",
    						'indexLabelFontColor' =>'white',
    						'indexLabelFontSize' =>'12',
    						'indexLabelOrientation'=> 'horizontal',
    						'indexLabelPlacement'=> 'inside',
    						//'indexLabel' => $percent,
    						'toolTipContent' =>  "{$activity}: {$value}%",
    				);
    			}
    			$product_data[] = array( 'type'=>'stackedBar100',
    					'showInLegend'=>true,
    					'legendText'=>strtoupper($activity),
    					'dataPoints'=>$product_dataPoints);
    		}
    		return $product_data;
    	}
    }
    public static function ActivityWiseProductsMonthlyPerformance($user_id, $time, $current_year, $current_month)
    {
    	$act = array('fgm','fhv','mc','demo');
    	$activity_wise = array();
    	//activity wise products
    	foreach ($act as $activity ) {
    		$products[$activity] = TmpProductWiseMonthlyActivitySummary::totalActivityWise($user_id, $current_year, $current_month, $activity);
    	}
    	$activities = $products;
    	//echo '<pre>';print_r($activities);exit;
    	$fgm = $activities['fgm'];
    	$fhv = $activities['fhv'];
    	$mc = $activities['mc'];
    	$demo = $activities['demo'];
    	$fgm_product_dataPoints = array();
    	$fhv_product_dataPoints = array();
    	$mc_product_dataPoints = array();
    	$demo_product_dataPoints = array();
    	if (!empty($activities)) {
    		if (!empty($fgm)) {
    			foreach ($fgm as $fgm_values) {
    				if ($fgm_values['value'] != 0) {
	    				$fgm_value = intval($fgm_values['value']);
	    				$fgm_product_name = $fgm_values['product_name'];
	    				$fgm_product_dataPoints[] = array('y' => $fgm_value,
	    						'legendText' => $fgm_product_name,
	    				);
    				}
    			}
    		}
    		if (!empty($fhv)) {
    			foreach ($fhv as $fhv_values) {
    				if ($fhv_values['value'] != 0) {
	    				$fhv_value = intval($fhv_values['value']);
	    				$fhv_product_name = $fhv_values['product_name'];
	    				$fhv_product_dataPoints[] = array('y' => $fhv_value,
	    						'legendText' => $fhv_product_name,
	    				);
    				}
    			}
    		}
    		if (!empty($mc)) {
    			foreach ($mc as $mc_values) {
    				if ($mc_values['value'] != 0) {
	    				$mc_value = intval($mc_values['value']);
	    				$mc_product_name = $mc_values['product_name'];
	    				$mc_product_dataPoints[] = array('y' => $mc_value,
	    						'legendText' => $mc_product_name,
	    				);
    				}
    			}
    		}
    		if (!empty($demo)) {
    			foreach ($demo as $demo_values) {
    				if ($demo_values['value'] != 0) {
	    				$demo_value = intval($demo_values['value']);
	    				$demo_product_name = $demo_values['product_name'];
	    				$demo_product_dataPoints[] = array('y' => $demo_value,
	    						'legendText' => $demo_product_name,
	    				);
    				}
    			}
    		}
    	}
    	$allresult = array();
    	$allresult['fgm'] = $fgm_product_dataPoints;
    	$allresult['fhv'] = $fhv_product_dataPoints;
    	$allresult['mc'] = $mc_product_dataPoints;
    	$allresult['demo'] = $demo_product_dataPoints;
    	//echo '<pre>';print_r($allresult);exit;
    	return $allresult;
    }
}
