<?php
namespace app\api\modules\v2\controllers;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\filters\ContentNegotiator;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\QueryParamAuth;
use yii\db\Query;
use yii;
use yii\web\UnauthorizedHttpException;
use app\api\modules\v2\models\TravellogYearlySummary;
use app\api\modules\v2\models\MonthWiseTravellogSummary;
use app\api\modules\v2\models\CropWiseActivityYearSummary;
use app\api\modules\v2\models\YearTotalCampaignsSummary;
use app\api\modules\v2\models\ProductWiseYearlyActivitySummary;
use app\api\modules\v2\models\TmpCropWiseYearlyActivitySummary;
use app\api\modules\v2\models\TmpProductWiseYearlyActivitySummary;
use app\api\modules\v2\models\TmpVillageWiseYearlyActivitySummary;
use app\api\modules\v2\models\MonthTotalCampaignsSummary;
use app\api\modules\v2\models\CropWiseMonthlyActivitySummary;
use app\api\modules\v2\models\ProductWiseMonthlyActivitySummary;
use app\api\modules\v2\models\TmpCropWiseMonthlyActivitySummary;
use app\api\modules\v2\models\TmpProductWiseMonthlyActivitySummary;
use app\api\modules\v2\models\TmpVillageWiseMonthlyActivitySummary;
use app\api\modules\v2\models\VillageCropYearlySummary;
use app\api\modules\v2\models\VillageCropMonthlySummary;
use app\api\modules\v2\models\VillageProductYearlySummary;
use app\api\modules\v2\models\VillageProductMonthlySummary;
use app\api\modules\v2\models\TravellogMonthlySummary;
use app\api\modules\v2\models\PlanWiseYearlySummary;
use app\api\modules\v2\models\PlanWiseMonthlySummary;

class PerformanceController extends ActiveController
{
	public $modelClass = 'app\api\modules\v2\models\PlanCards';

	public function behaviors()
	{
		$behaviors = parent::behaviors();
		$behaviors['authenticator'] = [
				'class' => CompositeAuth::className(),
				'authMethods' => [
						//HttpBasicAuth::className(),
						//HttpBearerAuth::className(),
						QueryParamAuth::className(),
				],
		];
		$behaviors['contentNegotiator'] = [
				'class' => ContentNegotiator::className(),
				'formats' => [
						'application/json' => Response::FORMAT_JSON,
						//'application/xml' => Response::FORMAT_XML,
				],
		];

		return $behaviors;
	}
	public function actionPerformancelog()
	{
		$params = Yii::$app->getRequest()->getBodyParams();
		$current_year =  date('Y');
		$current_month = date('m');
		$user_id = Yii::$app->user->identity->id;
		$flag = $params['flag'];
		$total_distance = $this->totalDistance($user_id,$current_year,$current_month, $flag);
		$total_campaings = $this->totalCampigns($user_id,$current_year,$current_month, $flag);
		$total_crops = $this->totalCrops($user_id,$current_year,$current_month, $flag);
		$total_products = $this->totalProducts($user_id,$current_year,$current_month, $flag);
		$totalsctivitywise = $this->totalActivityWise($user_id,$current_year,$current_month, $flag);
		$activity_wise_campaigns = $this->activtiyWiseCampaigns($user_id,$current_year,$current_month, $flag);
		$activity_year_villages = $this->activtiyWiseVillages($user_id,$current_year,$current_month, $flag);
		$village_crop_log = $this->villageCropLog($user_id,$current_year,$current_month, $flag);
		$village_product_log = $this->villageProductLog($user_id,$current_year,$current_month, $flag);
		$plan_summary = $this->planSummary($user_id,$current_year,$current_month, $flag);
		return $year = array('Total records' => array('all' =>array(
				'distance'       => $total_distance,
				'total_campaigns' => $total_campaings,
				'crops'           => $total_crops,
				'products'        => $total_products),
				'activity_wise_total'=> $totalsctivitywise,
				'activity_wise_campaigns' => $activity_wise_campaigns,
				'activity_wise_village'  => $activity_year_villages,
				'village_crop_log' => $village_crop_log,
				'village_product_log' => $village_product_log,
				'plan_summary'        =>$plan_summary
		)
		);
	}
	private function totalDistance($user_id,$current_year,$current_month, $flag)
	{
		//current year distance metrics
		$temp = array();
		if ($flag == 'yearly') {
			$year = array();
			$model = new TravellogYearlySummary;
			$year_travellog_max = $model->find()->select('max(month)')->where(['user_id' =>$user_id,'year' =>$current_year ])->scalar();
			$year_travellog = $model->find()->where(['user_id' =>$user_id,'year' =>$current_year ])->asArray()->all();
			
			if (!empty($year_travellog)) {
				$distance = array();
				foreach ($year_travellog as $log) {
					$distance[$log['month']]  = $log['total_distance'];
				}
			}
			for($i=1;$i<= $year_travellog_max; $i++) {
				if(!array_key_exists($i,$distance)) {
					$distance[$i] = "0";
				}
				$temp[] = $distance[$i];
			}
			return $temp;
		} else {
			$model2 = new TravellogMonthlySummary;
			$month_travellog_max = $model2->find()->select('max(day)')->where(['user_id' =>$user_id,'year' =>$current_year,'month' =>$current_month ])->scalar();
			$month_travellog = $model2->find()->where(['user_id' =>$user_id,'year' =>$current_year,'month' =>$current_month ])->asArray()->all();
			if (!empty($month_travellog)) {
				$distance = array();
				foreach ($month_travellog as $log) {
					$count[$log['day']]  = $log['total_distance'];
				}
			}
			for($i=1;$i<= $month_travellog_max; $i++) {
				if(!array_key_exists($i,$count)) {
					$count[$i] = "0";
					
				}
				$temp[] = $count[$i];
			}
			return $temp;
		}
	}
	private function totalCampigns($user_id,$current_year,$current_month, $flag)
	{
		$temp = array();
		if ($flag == 'yearly') {
			$y = array();
			$model = new YearTotalCampaignsSummary();
			$year_campaigns_max = $model->find()->select('max(month)')->where(['user_id' => $user_id,'year' => $current_year ])->scalar();
			$year_campaigns = $model->find()->where(['user_id' => $user_id,'year' => $current_year])->asArray()->all();
			if (!empty($year_campaigns)) {
				$existimbg_months = array();
				$campaigns = array();
				foreach ($year_campaigns as $log) {
					$campaigns[$log['month']]  = $log['total'];
				}
			}
			for($i=1;$i<= $year_campaigns_max; $i++) {
				if(!array_key_exists($i,$campaigns)) {
					$campaigns[$i] = "0";
				}
				$temp[] = $campaigns[$i];
			}
			return $temp;
		} else {
			$model = new MonthTotalCampaignsSummary();
			$month_campaigns_max = $model->find()->select('max(day)')->where(['user_id' => $user_id,'year' => $current_year,'month' => $current_month ])->scalar();
			$month_campaigns = $model->find()->where(['user_id' => $user_id,'year' => $current_year, 'month' => $current_month ])->asArray()->all();
			if (!empty($month_campaigns)) {
				$existimbg_months = array();
				$campaigns = array();
				foreach ($month_campaigns as $log) {
					$campaigns[$log['day']]  = $log['total'];
				}
			}
			for($i=1;$i<= $month_campaigns_max; $i++) {
				if(!array_key_exists($i,$campaigns)) {
					$campaigns[$i] = "0";
				}
				$temp[] = $campaigns[$i];
			}
			return $temp;
		}
	}
	private function totalCrops ($user_id,$current_year,$current_month,$flag)
	{
		if ($flag == 'yearly') {
			$model  = new CropWiseActivityYearSummary();
			//$crop_year_log = $model->find()->select('crop_name,sum(fgm) as fgm,sum(fhv) as fhv,sum(mc) as mc,sum(demo) as demo,sum(total) as total')->where(['user_id' => $user_id,'year' => $current_year])->groupBy('crop_name')->orderBy('total desc')->asArray()->all();
			$query = 'SELECT IF( cy.crop_id = 2147483647,  "others", cr.crop_name ) as crop_name, SUM( cy.fgm ) AS fgm, SUM( cy.fhv ) AS fhv, SUM( cy.mc ) AS mc, SUM( cy.demo ) AS demo, SUM( cy.total ) AS total
			FROM crop_wise_yearly_activity_summary cy
			LEFT JOIN crops cr ON cr.id = cy.crop_id
			WHERE cy.user_id = "'.$user_id.'"
			AND cy.year = "'.$current_year.'"
			GROUP BY cy.crop_id
			ORDER BY FIELD( cy.crop_id,  "2147483647" ) ASC , total DESC';
			$crop_year_log = Yii::$app->db->createCommand($query)->queryAll();
			return $crop_year_log;
		} else {
			$model  = new CropWiseMonthlyActivitySummary();
			//$crop_year_log = $model->find()->select('crop_name,sum(fgm) as fgm,sum(fhv) as fhv,sum(mc) as mc,sum(demo) as demo,sum(total) as total')->where(['user_id' => $user_id,'year' => $current_year,'month' =>$current_month ])->groupBy('crop_name')->orderBy('total desc')->asArray()->all();
			$query = 'SELECT IF( cy.crop_id = 2147483647,  "others", cr.crop_name ) as crop_name, SUM( cy.fgm ) AS fgm, SUM( cy.fhv ) AS fhv, SUM( cy.mc ) AS mc, SUM( cy.demo ) AS demo, SUM( cy.total ) AS total
			FROM crop_wise_monthly_activity_summary cy
			LEFT JOIN crops cr ON cr.id = cy.crop_id
			WHERE cy.user_id = "'.$user_id.'"
			AND cy.month = 	"'.$current_month.'"
			AND cy.year = "'.$current_year.'"
			GROUP BY cy.crop_id
			ORDER BY FIELD( cy.crop_id,  "2147483647" ) ASC , total DESC';
    		$crop_year_log = Yii::$app->db->createCommand($query)->queryAll();
			return $crop_year_log;
		}
	}

	private function totalProducts ($user_id,$current_year,$current_month,$flag)
	{
		if ($flag == 'yearly') {
			$model  = new ProductWiseYearlyActivitySummary();
			//$product_year_log = $model->find()->select('product_name,sum(fgm) as fgm,sum(fhv) as fhv,sum(mc) as mc,sum(demo) as demo,sum(total) as total')->where(['user_id' => $user_id,'year' => $current_year])->groupBy('product_name')->orderBy('total desc')->asArray()->all();
			$query = 'SELECT IF( py.product_id = 2147483647,  "others", pr.product_name ) as product_name, SUM( py.fgm ) AS fgm, SUM( py.fhv ) AS fhv, SUM( py.mc ) AS mc, SUM( py.demo ) AS demo, SUM( py.total ) AS total
			FROM product_wise_yearly_activity_summary py
			LEFT JOIN products pr ON pr.id = py.product_id
			WHERE py.user_id = "'.$user_id.'"
			AND py.year = "'.$current_year.'"
			GROUP BY py.product_id
			ORDER BY FIELD( py.product_id,  "2147483647" ) ASC , total DESC';
			$product_year_log = Yii::$app->db->createCommand($query)->queryAll();
			return $product_year_log;
		} else {
			$model  = new ProductWiseMonthlyActivitySummary();
			//$product_year_log = $model->find()->select('product_name,sum(fgm) as fgm,sum(fhv) as fhv,sum(mc) as mc,sum(demo) as demo,sum(total) as total')->where(['user_id' => $user_id,'year' => $current_year,'month' =>$current_month])->groupBy('product_name')->orderBy('total desc')->asArray()->all();
			$query = 'SELECT IF( pm.product_id = 2147483647,  "others", pr.product_name ) as product_name, SUM( pm.fgm ) AS fgm, SUM( pm.fhv ) AS fhv, SUM( pm.mc ) AS mc, SUM( pm.demo ) AS demo, SUM( pm.total ) AS total
			FROM product_wise_monthly_activity_summary pm
			LEFT JOIN products pr ON pr.id = pm.product_id
			WHERE pm.user_id = "'.$user_id.'"
			AND pm.month = 	"'.$current_month.'"
			AND pm.year = "'.$current_year.'"
			GROUP BY pm.product_id
			ORDER BY FIELD( pm.product_id,  "2147483647" ) ASC , total DESC';
			$product_year_log = Yii::$app->db->createCommand($query)->queryAll();
			return $product_year_log;
		}
	}
	private function totalActivityWise($user_id,$current_year,$current_month,$flag)
	{
		$act = array('fgm','fhv','demo','mc');
		if($flag == 'yearly') {
			$activity_wise = $temp = array();
			//activity wise crops
			foreach ($act as $activity ) {
				$activtiy_wise_crops[$activity] = TmpCropWiseYearlyActivitySummary::totalActivityWise($user_id, $current_year, $activity);
				$activtiy_wise_products[$activity] = TmpProductWiseYearlyActivitySummary::totalActivityWise($user_id, $current_year, $activity);
			}
			$activities = ['crops' => $activtiy_wise_crops,'products' => $activtiy_wise_products];
			return $activities;
		} else {
			foreach ($act as $activity ) {
				$activtiy_wise_crops[$activity] = TmpCropWiseMonthlyActivitySummary::totalActivityWise($user_id, $current_year, $current_month, $activity);
				$activtiy_wise_products[$activity] = TmpProductWiseMonthlyActivitySummary::totalActivityWise($user_id, $current_year, $current_month, $activity);
			}
			$activities = ['crops' => $activtiy_wise_crops,'products' => $activtiy_wise_products];
			return $activities;
		}	
	}
	private function activtiyWiseCampaigns($user_id,$current_year,$current_month,$flag)
	{
		$act = array('fgm','fhv','demo','mc');
		$results = array();
		$temp = array();
		$tmpArray = $count = array();
		if($flag == 'yearly') {
			foreach($act as $actvity) {
				$cropactys = new TmpCropWiseYearlyActivitySummary();
				$crop_activity_year_summary = 	$cropactys->find()->select('SUM('.$actvity.') as '.$actvity.' ,month')->where(['user_id' => $user_id,'year' => $current_year])->groupBy('month')->asArray()->all();
				$year_activity_max = $cropactys->find()->select('max(month)')->where(['user_id' =>$user_id,'year' =>$current_year ])->scalar();
				if (!empty($crop_activity_year_summary)) {
					for ($k =1;$k<$year_activity_max;$k++) {
						$count[$k]  = "0";
					}
					foreach ($crop_activity_year_summary as $log) {
						$month = (int)$log['month'];
						$count[$month]  = $log[$actvity];
					}
					$tmpArray = array_values($count);
// 					foreach ($count as $cnt=>$details) {
// 						$tmpArray[] = $details;					
				}
					$result [$actvity] = $tmpArray;

				}
				return $result;
		} else {
			foreach($act as $actvity) {
				$cropactms = new TmpCropWiseMonthlyActivitySummary();
				$crop_activity_month_summary = 	$cropactms->find()->select('SUM('.$actvity.') as '.$actvity.' ,day')->where(['user_id' => $user_id,'month' => $current_month,'year' =>$current_year])->groupBy('day')->asArray()->all();
				$month_activity_max = $cropactms->find()->select('max(day)')->where(['user_id' =>$user_id,'year' =>$current_year,'month' => $current_month ])->scalar();
				if (!empty($crop_activity_month_summary)) {
					for ($k =1;$k<$month_activity_max;$k++) {
						$count[$k]  = "0";
					}
					foreach ($crop_activity_month_summary as $log) {
						$day = (int)$log['day'];
						$count[$day]  = $log[$actvity];
					}
					$tmpArray = array_values($count);
					// 					foreach ($count as $cnt=>$details) {
					// 						$tmpArray[] = $details;
				}
				$result [$actvity] = $tmpArray;
				
			}
			return $result;
		}
	}
	private function activtiyWiseVillages($user_id,$current_year,$current_month,$flag) 
	{
		$query = new \yii\db\Query();
		if ($flag == 'yearly') {
			$model = new TmpVillageWiseYearlyActivitySummary();
			$sql = 	$query->select('mv.village_name,tv.fgm,tv.mc,tv.fhv,tv.demo,tv.total')
					       		->from('tmp_village_wise_yearly_activity_summary tv')			
								->leftJoin('villages_master mv','mv.village_id = tv.village_id')
								->where(['tv.user_id' => $user_id,'tv.year' => $current_year])
								->orderBy('mv.village_name')
								->all();
			return $sql;
		} else {
			$model = new TmpVillageWiseMonthlyActivitySummary();
			$sql = 	$query->select('mv.village_name,sum(tv.fgm) as fgm,sum(tv.mc) as mc,sum(tv.fhv) as fhv,sum(tv.demo) as demo,sum(tv.total) as total')
								->from('tmp_village_wise_monthly_activity_summary tv')
								->leftJoin('villages_master mv','mv.village_id = tv.village_id')
								->where(['tv.user_id' => $user_id,'tv.year' => $current_year,'tv.month' =>$current_month])
								->groupBy('tv.village_id')
								->orderBy('mv.village_name')
								->all();
			return $sql;
		}
	}
	//for village crop yearly monthly log
	private function villageCropLog($user_id, $current_year, $current_month, $flag)
	{
		if ($flag == 'yearly') {
			//$model = new VillageCropYearlySummary();
			$model = 'village_crop_yearly_summary vc';
			//$whereCond = ['user_id' => $user_id, 'year' => $current_year];
			$whereCond = "WHERE vc.user_id = $user_id AND vc.year = $current_year";
			//$groupQry = 'village_name, crop1, crop2, crop3, crop4, month';
			$groupQry = 'vc.village_id, vc.crop1, vc.crop2, vc.crop3, vc.crop4, vc.month';
		} else {
			//$model = new VillageCropMonthlySummary();
			$model = 'village_crop_monthly_summary vc';
			//$whereCond = ['user_id' => $user_id, 'year' => $current_year, 'month' => $current_month];
			$whereCond = "WHERE vc.user_id = $user_id AND vc.year = $current_year AND vc.month = $current_month";
			//$groupQry = 'village_name, crop1, crop2, crop3, crop4';
			$groupQry = 'vc.village_id, vc.crop1, vc.crop2, vc.crop3, vc.crop4';
		}
		/* $sql = $model->find()->select('village_name, crop1, SUM(crop1_total) AS crop1_total, crop2, SUM(crop2_total) AS crop2_total, crop3, SUM(crop3_total) AS crop3_total, crop4, SUM(crop4_total) AS crop4_total')
							->where($whereCond)
							->groupBy($groupQry)
							->asArray()
							->all(); */
		$query = "SELECT if(vc.crop4 = 2147483647, 'others', ifnull(cr4.crop_name,0)) AS crop4, mv.village_name, ifnull(cr1.crop_name, 0) AS crop1, SUM(vc.crop1_total) AS crop1_total, ifnull(cr2.crop_name, 0) AS crop2, SUM(vc.crop2_total) AS crop2_total, ifnull(cr3.crop_name, 0) AS crop3, SUM(vc.crop3_total) AS crop3_total, SUM(vc.crop4_total) AS crop4_total
		FROM $model
		LEFT JOIN crops cr1 ON cr1.id = vc.crop1
		LEFT JOIN crops cr2 ON cr2.id = vc.crop2
		LEFT JOIN crops cr3 ON cr3.id = vc.crop3
		LEFT JOIN crops cr4 ON cr4.id = vc.crop4
		LEFT JOIN villages_master mv ON mv.village_id = vc.village_id
		$whereCond
		GROUP BY $groupQry
		ORDER BY mv.village_name";
		
		$sql = Yii::$app ->db->createCommand($query)->queryAll();
		return $sql;
	}
	//for village product yearly monthly log
	private function villageProductLog($user_id, $current_year, $current_month, $flag)
	{
		if ($flag == 'yearly') {
			//$model = new VillageProductYearlySummary();
			//$whereCond = ['user_id' => $user_id, 'year' => $current_year];
			//$groupQry = 'village_name, product1, product2, product3, product4, month';
			$model = 'village_product_yearly_summary vc';
			$whereCond = "WHERE vc.user_id = $user_id AND vc.year = $current_year";
			$groupQry = 'vc.village_id, vc.product1, vc.product2, vc.product3, vc.product4, vc.month';
		} else {
			//$model = new VillageProductMonthlySummary();
			//$whereCond = ['user_id' => $user_id, 'year' => $current_year, 'month' => $current_month];
			//$groupQry = 'village_name, product1, product2, product3, product4,month';
			$model = 'village_product_monthly_summary vc';
			$whereCond = "WHERE vc.user_id = $user_id AND vc.year = $current_year AND vc.month = $current_month";
			$groupQry = 'vc.village_id, vc.product1, vc.product2, vc.product3, vc.product4';
		}
		/* $sql = $model->find()->select('village_name, product1, SUM(product1_total) AS product1_total, product2, SUM(product2_total) AS product2_total, product3, SUM(product3_total) AS product3_total, product4, SUM(product4_total) AS product4_total')
		->where($whereCond)
		->groupBy($groupQry)
		->asArray()
		->all(); */
		$query = "SELECT if(vc.product4 = 2147483647, 'others', ifnull(pr4.product_name, 0)) AS product4, mv.village_name,vc.village_id, ifnull(pr1.product_name, 0) AS product1, SUM(vc.product1_total) AS product1_total, ifnull(pr2.product_name, 0) AS product2, SUM(vc.product2_total) AS product2_total, ifnull(pr3.product_name, 0) AS product3, SUM(vc.product3_total) AS product3_total, SUM(vc.product4_total) AS product4_total
		FROM $model
		LEFT JOIN products pr1 ON pr1.id = vc.product1
		LEFT JOIN products pr2 ON pr2.id = vc.product2
		LEFT JOIN products pr3 ON pr3.id = vc.product3
		LEFT JOIN products pr4 ON pr4.id = vc.product4
		LEFT JOIN villages_master mv ON mv.village_id = vc.village_id
		$whereCond
		GROUP BY $groupQry
		ORDER BY mv.village_name";
		$sql = Yii::$app ->db->createCommand($query)->queryAll();
		return $sql;
	}
	private function planSummary($user_id,$current_year,$current_month, $flag)
	{
		if($flag == 'yearly') {
			$model = new PlanWiseYearlySummary();
			$plan_year_summary = $model->find()->select('*')->where(['user_id' => $user_id,'year' => $current_year])->asArray()->one();
			return $plan_year_summary;
		} else {
			$model = new PlanWiseMonthlySummary();
			$plan_month_summary = $model->find()->select('*')->where(['user_id' => $user_id,'year' => $current_year,'month' => $current_month])->asArray()->one();
			return $plan_month_summary ;
		}
	}
}	
