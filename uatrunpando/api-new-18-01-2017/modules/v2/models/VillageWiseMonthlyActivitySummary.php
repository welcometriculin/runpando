<?php

namespace app\api\modules\v2\models;

use Yii;

/**
 * This is the model class for table "village_wise_monthly_activity_summary".
 *
 * @property string $id
 * @property string $user_id
 * @property string $village_name
 * @property string $demo
 * @property string $fgm
 * @property string $mc
 * @property string $fhv
 * @property string $total
 * @property string $day
 * @property string $month
 */
class VillageWiseMonthlyActivitySummary extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'village_wise_monthly_activity_summary';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
				[['user_id', 'village_name', 'demo', 'fgm', 'mc', 'fhv', 'total', 'day', 'month','year','village_id'], 'required'],
				[['user_id', 'demo', 'fgm', 'mc', 'fhv', 'total', 'day', 'month','village_id'], 'integer'],
				[['village_name'], 'string', 'max' => 100]
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
				'demo' => 'Demo',
				'fgm' => 'Fgm',
				'mc' => 'Mc',
				'fhv' => 'Fhv',
				'total' => 'Total',
				'day' => 'Day',
				'month' => 'Month',
		];
	}
	public static function villageMonthlyPerformance($user_id, $time)
	{
		$current_year = date('Y');
		$current_month = date('m');
		$query = (new \yii\db\Query());
		$village_wise_activity_summary = $query->select('mv.village_name,va.village_id,SUM(va.demo) as demo, SUM(va.fgm) as fgm, SUM(va.mc) as mc, SUM(va.fhv) as fhv, SUM(va.total) as total')
												->from('village_wise_monthly_activity_summary as va')
												->innerJoin('villages_master mv','va.village_id = mv.village_id')
												->where(['va.user_id' => $user_id, 'va.year' => $current_year,'va.month' =>$current_month ])
												->groupBy('va.village_id')
												->orderBy('mv.village_name desc')
												->all();
 		/* $total_value = 0;
 		$actvity_total = 0; */
		if(!empty($village_wise_activity_summary)) {
			$actvities = array('fgm','fhv','demo','mc');
			foreach($actvities as $activity) {
				$dataPoints = array();
				//village activity summary
//  				$actvity_total = 0;
				foreach ($village_wise_activity_summary as $village) {
					$labelvalue = $value = round($village[$activity]/$village['total'],2)*100;
					$label = strlen($village['village_name']) > 16 ? substr($village['village_name'], 0, 10). '.. ('.$village['total'].')' : $village['village_name'].' ('.$village['total'].')';
					if($value==0) {
						$label = $labelvalue ='';
						$percent = "";
						} else {
							$percent = "#percent";
						}
					$dataPoints[] = array('y' => $value,
							'label' => $label,
							'indexLabel' => "'".$labelvalue."'",
							'indexLabelFontColor' =>'white',
							'indexLabelFontSize' =>'12',
							'indexLabelOrientation'=> 'horizontal',
							'indexLabelPlacement'=> 'inside',
							'indexLabel' => $percent,
					);
 					/* $total_value = $village[$activity] + $total_value;
 					$actvity_total = $village[$activity] + $actvity_total; */
				}
				 /* $dataPoints[] = array('y' => $actvity_total,
						'label' => 'Total('.$total_value.')',
						'indexLabel' => "$actvity_total",
						'indexLabelFontColor' =>'white',
						'indexLabelFontSize' =>'12',
						'indexLabelOrientation'=> 'horizontal',
						'indexLabelPlacement'=> 'inside',
						'indexLabel' => "#percent%",);  */
					if( $activity == 'fgm') {
						$legendText = 'Group Meeting';
					} elseif ($activity == 'fhv') {
						$legendText = 'Farm and Home Visit';
					} elseif($activity == 'mc') {
						$legendText = 'Mass Campaign';
					} elseif($activity == 'demo') {
						$legendText = 'Demonstration';
					}
				$data[] = array( 'type'=>'stackedBar100',
						'showInLegend'=>true,
						'legendText'=>$legendText,
						'percentFormatString'=> "#",
						'dataPoints'=>$dataPoints);
			}
		return $data;
		}
	}
}
