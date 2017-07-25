<?php

namespace app\api\modules\v3\models;

use Yii;
use app\models\TmpCropWiseYearlyActivitySummary;
/**
 * This is the model class for table "crop_wise_activity_year_summary".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $activity
 * @property integer $count_activity
 * @property string $year
 * @property string $crop_name
 */
class CropWiseActivityYearSummary extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'crop_wise_yearly_activity_summary';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
		[['user_id', 'year', 'crop_name', 'demo','fgm','mc','fhv','total','crop_id'], 'required'],
		[['user_id','crop_id'], 'integer'],
		[['demo','fgm','mc','fhv','total','month','year'], 'safe'],
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
		'year' => 'Year',
		'crop_name' => 'Crop Name',
		];
	}
	public static function cropActivityPerformance($user_id, $time, $current_year)
	{
	/* 	$crop_year_log = self::find()->select('crop_name,sum(fgm) as fgm,sum(fhv) as fhv,sum(mc) as mc,sum(demo) as demo,sum(total) as total')
		->where(['user_id' => $user_id,'year' => $current_year])
		->groupBy('crop_name')
		->orderBy('total desc')
		->asArray()->all(); */
		$query = 'SELECT IF( cy.crop_id = 2147483647,  "others", cr.crop_name ) as crop_name, SUM( cy.fgm ) AS fgm, SUM( cy.fhv ) AS fhv, SUM( cy.mc ) AS mc, SUM( cy.demo ) AS demo, SUM( cy.total ) AS total
		FROM crop_wise_yearly_activity_summary cy
		LEFT JOIN crops cr ON cr.id = cy.crop_id
		WHERE cy.user_id = "'.$user_id.'"
		AND cy.year = "'.$current_year.'"
		GROUP BY cy.crop_id
		ORDER BY FIELD( cy.crop_id,  "2147483647" ) DESC , total ASC, cr.crop_name desc';
		$crop_year_log = Yii::$app->db->createCommand($query)->queryAll();
// 		$total_value = 0;
// 		$actvity_total = 0;
		if(!empty($crop_year_log)) {
		$actvities = array('fgm','fhv','demo','mc');
		foreach($actvities as $activity) {
			//crop wise activity summary
// 			$actvity_total = 0;
			$crop_dataPoints = array();
			foreach ($crop_year_log as $crop) {
				$labelvalue = $value = round(($crop[$activity]/$crop['total']) * 100,0);
				$label = strlen($crop['crop_name']) > 6 ? substr($crop['crop_name'], 0, 6). '.. ('.$crop['total'].')' : $crop['crop_name'].' ('.$crop['total'].')';;
				if($value==0) {
					$label = $labelvalue ='';
					}
				$crop_dataPoints[] = array('y' => $value,
						'label' => $label,
						'indexLabel' => "'".$labelvalue."'",
						'indexLabelFontColor' =>'white',
						'indexLabelFontSize' =>'12',
						'indexLabelOrientation'=> 'horizontal',
						'indexLabelPlacement'=> 'inside',
						//'indexLabel' => $percent,
						'toolTipContent' =>  "{$activity}: {$value}%",
						
				);
				/* $total_value = $crop[$activity] + $total_value;
				$actvity_total = $crop[$activity] + $actvity_total; */
			}
			/* $crop_dataPoints[] = array('y' => $actvity_total,
					'label' => 'Total('.$total_value.')',
					'indexLabel' => "$actvity_total",
					'indexLabelFontColor' =>'white',
					'indexLabelFontSize' =>'12',
					'indexLabelOrientation'=> 'horizontal',
					'indexLabelPlacement'=> 'inside',
					'indexLabel' => "#percent",
					 'toolTipContent' => "{$activity}: #percent% ",
			); */
			$crop_data[] = array( 'type'=>'stackedBar100',
					'showInLegend'=>true,
					'percentFormatString' => "#0",
					'legendText'=>strtoupper($activity),
					'dataPoints'=>$crop_dataPoints);
			}
			return $crop_data;
		}
	}


	
	public static function ActivityWiseCropsPerformance($user_id, $time, $current_year)
	{
		$act = array('fgm','fhv','mc','demo');
			$activity_wise = array();
			//activity wise crops
			foreach ($act as $activity ) {
				$crops[$activity] = TmpCropWiseYearlyActivitySummary::totalActivityWise($user_id, $current_year, $activity);
			}
			$activities = $crops;
			$fgm = $activities['fgm'];
			$fhv = $activities['fhv'];
			$mc = $activities['mc'];
			$demo = $activities['demo'];
			$activity_totals = self::find()->select('sum(fgm) as fgm, sum(fhv) as fhv, sum(mc) as mc, sum(demo) as demo')->where(['user_id' => $user_id, 'year' => $current_year])->limit(4)->orderBy('fgm, fhv, mc, demo desc')->asArray()->one();
			$fgm_total = $activity_totals['fgm'];
			$fhv_total = $activity_totals['fhv'];
			$mc_total = $activity_totals['mc'];
			$demo_total = $activity_totals['demo'];
			$result = '';
			$result2 = '';
			$result3 = '';
			$result4 = '';
			if (!empty($activities)) {
				if (!empty($fgm)) {
					//for sorting arrays desc
					foreach ($fgm as $fgm_vals) {
						$fgm_val[] = $fgm_vals['value'];
					}
					$fgmValues = array_values($fgm_val);
					array_multisort($fgmValues, SORT_DESC, $fgm);
					//for sorting arrays desc end
					$i = 1;
					$crop_name =array();
					foreach ($fgm as $fgm_values) {
						if ($fgm_values['value'] != 0) {
							if ($fgm_total == 0) {
								$fgm_percent = 0;//for division by zero issue
							} else {
								$fgm_percent = ($fgm_values['value']/$fgm_total)*100;
							}
							$width_percentages = self::percentageMethod($fgm_percent);	
							$width = $width_percentages;
							$height = $width;
							$fgm_crop_name[] = $fgm_values['crop_name'];
							$result .= "<div class='block-1'>
									<div class='box_1'>
									<div class='block_a' id='activity_".$i."' style='width:".$width."px;height:".$height."px;'>
											<span>".$fgm_values['value']."</span>
													
										</div>
									</div>				
									</div>";
							$i++;
						}
					}
					if(!empty($fgm_crop_name)) {
					$result .='<div class="lagends">';
						foreach ($fgm_crop_name as $crop) {
							$result .="<span class='block_name'>".$crop."</span>";
						}
					$result .="</div>";
					}
				}
				if (!empty($fhv)) {
					//for sorting arrays desc
					foreach ($fhv as $fhv_vals) {
						$fhv_val[] = $fhv_vals['value'];
					}
					$fhvValues = array_values($fhv_val);
					array_multisort($fhvValues, SORT_DESC, $fhv);
					//for sorting arrays desc end
					$i = 1;
					foreach ($fhv as $fhv_values) {
						if ($fhv_values['value'] != 0) {
							if ($fhv_total == 0) {
								$fhv_percent = 0;
							} else {
								$fhv_percent = ($fhv_values['value']/$fhv_total)*100;
							}
							$width_percentages = self::percentageMethod($fhv_percent);
							$width = $width_percentages;
							$height = $width;
							$fhv_crop_name[] = $fhv_values['crop_name'];
							$result2 .= "<div class='block-1'>
									<div class='box_1'>
									<div class='block_a' id='activity_".$i."' style='width:".$width."px;height:".$height."px;'>
											<span>".$fhv_values['value']."</span>
													
										</div>
									</div>				
									</div>";
							$i++;
						}
					}
					if(!empty($fhv_crop_name)) {
					$result2 .='<div class="lagends">';
						foreach ($fhv_crop_name as $crop) {
							$result2 .="<span class='block_name'>".$crop."</span>";
						}
					$result2 .="</div>";
					}
				}
				if (!empty($mc)) {
					//for sorting arrays desc
					foreach ($mc as $mc_vals) {
						$mc_val[] = $mc_vals['value'];
					}
					$mcValues = array_values($mc_val);
					array_multisort($mcValues, SORT_DESC, $mc);
					//for sorting arrays desc end
					$i = 1;
					foreach ($mc as $mc_values) {
						if ($mc_values['value'] != 0) {
							if ($mc_total == 0) {
								$mc_percent = 0;
							} else {
								$mc_percent = ($mc_values['value']/$mc_total)*100;
							}
							$width_percentages = self::percentageMethod($mc_percent);
							$width = $width_percentages;
							$height = $width;
							$mc_crop_name[] = $mc_values['crop_name'];
							$result3 .= "<div class='block-1'>
									<div class='box_1'>
									<div class='block_a' id='activity_".$i."' style='width:".$width."px;height:".$height."px;'>
											<span>".$mc_values['value']."</span>
													
										</div>
									</div>				
									</div>";
							$i++;
						}
					}
					if(!empty($mc_crop_name)) {
					$result3 .='<div class="lagends">';
						foreach ($mc_crop_name as $crop) {
							$result3 .="<span class='block_name'>".$crop."</span>";
						}
					$result3 .="</div>";
					}
				}
				if (!empty($demo)) {
					//for sorting arrays desc
					foreach ($demo as $demo_vals) {
						$demo_val[] = $demo_vals['value'];
					}
					$demoValues = array_values($demo_val);
					array_multisort($demoValues, SORT_DESC, $demo);
					//for sorting arrays desc end
					$i = 1;
					foreach ($demo as $demo_values) {
						if ($demo_values['value'] != 0) {
							if ($demo_total == 0) {
								$demo_percent = 0;
							} else {
								$demo_percent = ($demo_values['value']/$demo_total)*100;
							}
							$width_percentages = self::percentageMethod($demo_percent);
							$width = $width_percentages;
							$height = $width;
							$demo_crop_name[] = $demo_values['crop_name'];
							$result4 .= "<div class='block-1'>
									<div class='box_1'>
									<div class='block_a' id='activity_".$i."' style='width:".$width."px;height:".$height."px;'>
											<span>".$demo_values['value']."</span>
													
										</div>
									</div>				
									</div>";
							$i++;
						}
					}
					if(!empty($demo_crop_name)) {
					$result4 .='<div class="lagends">';
						foreach ($demo_crop_name as $crop) {
							$result4 .="<span class='block_name'>".$crop."</span>";
						}
					$result4 .="</div>";
					}
				}
			}
			$allresult = array();
			$allresult['fgm'] = $result;
			$allresult['fhv'] = $result2;
			$allresult['mc'] = $result3;
			$allresult['demo'] = $result4;
			//echo '<pre>';print_r($allresult);exit;
			return $allresult;
	}
	
	public static function percentageMethod($percent)
	{
		$val1 = 10;
		$val2 = 20;
		$val3 = 30;
		$val4 = 40;
		$val5 = 50;
		$val6 = 60;
		$val7 = 70;
		$val8 = 80;
		$val9 = 90;
		$val10 = 100;
		if($percent <= $val1) {
			return 35;
		}
		if($percent > $val1 && $percent <= $val2) {
			return 40;
		}
		if($percent > $val2 && $percent <= $val3) {
			return 45;
		}
		if($percent > $val3 && $percent <= $val4) {
			return 50;
		}
		if($percent > $val4 && $percent <= $val5) {
			return 55;
		}
		if($percent > $val5 && $percent <= $val6) {
			return 60;
		}
		if($percent > $val6 && $percent <= $val7) {
			return 95;
		}
		if($percent > $val7 && $percent <= $val8) {
			return 105;
		}
		if($percent > $val8 && $percent <= $val9) {
			return 115;
		}
		if($percent > $val9 && $percent < $val10) {
			return 125;
		}
		if($percent = $val10) {
			return 135;
		}
	}
}
