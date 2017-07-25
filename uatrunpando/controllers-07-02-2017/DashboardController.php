<?php

namespace app\controllers;

use Yii;
use app\models\Users;
use app\models\TravellogYearlySummary;
use app\models\VillageWiseYearlyActivitySummary;
use app\models\VillageWiseMonthlyActivitySummary;
use app\models\CropWiseActivityYearSummary;
use app\models\CropWiseMonthlyActivitySummary;
use app\models\VillageCropYearlySummary;
use app\models\VillageCropMonthlySummary;
use app\models\VillageProductYearlySummary;
use app\models\VillageProductMonthlySummary;
use app\models\ProductWiseYearlyActivitySummary;
use app\models\YearTotalCampaignsSummary;
use app\models\TravellogMonthlySummary;
use app\models\ProductWiseMonthlyActivitySummary;
use app\models\MonthTotalCampaignsSummary;
use app\models\PlanWiseYearlySummary;
use app\models\TmpCropWiseYearlyActivitySummary;
use app\models\TmpCropWiseMonthlyActivitySummary;
use app\models\PlanWiseMonthlySummary;
use app\models\TotalFarmersSummary;
use app\models\LabelNames;

class DashboardController extends KgController
{
	public function actionIndex()
	{
		
		$model = new Users;
		//$reportees_list = \app\models\Users::Reporteeslist();
		$label_names_display = LabelNames::labelNamesDisplay();
 		$user_id = Yii::$app->user->identity->id;
// 		$reportees_list[$user_id] = 'All';
		$rep = Users::getChildsRecoursive($user_id,true);
		$reportUsers = Users::dashboardUsers($rep);
		$reportUsers = array($user_id => 'All') + $reportUsers;
		//$res = $this->runChildsRecoursive($val,$ids = array());
		return $this->render('index',['model' =>$model, 'label_names_display' => $label_names_display,'data' => $reportUsers]);
	}
	public function actionPerformance() {
		$current_year = date("Y");
		$current_month = date("m");
		//header('Content-Type: application/json');
		if(isset($_REQUEST['id'])) {
			$user_id = $_REQUEST['id'];
			$time = $_REQUEST['time'];
			if ($time == 'year') {
				/* $check_user = CropWiseActivityYearSummary::find()->where(['user_id' => $user_id])->count();
				if ($check_user == 0) {
					return 'not_exist';
				} */
				$planwise_check = PlanWiseYearlySummary::find()->where(['user_id' => $user_id])->count();
				if ($planwise_check == 0) {
					return 'not_exist';
				}
				$village_wise_activity_summary = VillageWiseYearlyActivitySummary::villagePerformance($user_id, $time);
				$village_crop_summary = VillageCropYearlySummary::villageCropPerformance($user_id, $time, $current_year);
				$village_product_summary = VillageProductYearlySummary::villageProductPerformance($user_id, $time, $current_year);
				$distance_performance = TravellogYearlySummary::travelDistanceChart($user_id,$current_year);
				$crop_wise_activity_summary = CropWiseActivityYearSummary::cropActivityPerformance($user_id, $time, $current_year);
				$product_wise_activity_summary = ProductWiseYearlyActivitySummary::productActivityPerformance($user_id, $time, $current_year);
				$total_campaigns = YearTotalCampaignsSummary::totalCampaignPerformance($user_id, $time, $current_year);
				$group_campaigns = TmpCropWiseYearlyActivitySummary::groupCampaignsPerformance($user_id, $time, $current_year);
				$activity_wise_crops = CropWiseActivityYearSummary::ActivityWiseCropsPerformance($user_id, $time, $current_year);
				$activity_wise_products = ProductWiseYearlyActivitySummary::ActivityWiseProductsPerformance($user_id, $time, $current_year);
				$plan_summary = PlanWiseYearlySummary::planYearlySummary($user_id, $time, $current_year);
				$farmers_summary = TotalFarmersSummary::farmersSummary($user_id, $time, $current_year,$current_month);
			} else {
				/* $check_user = CropWiseMonthlyActivitySummary::find()->where(['user_id' => $user_id])->count();
				if ($check_user == 0) {
					return 'not_exist';
				} */
				$planwise_check = PlanWiseMonthlySummary::find()->where(['user_id' => $user_id])->count();
				if ($planwise_check == 0) {
					return 'not_exist';
				}
				$village_wise_activity_summary = VillageWiseMonthlyActivitySummary::villageMonthlyPerformance($user_id, $time);
				$distance_performance = TravellogMonthlySummary::travelMonthDistanceChart($user_id,$current_year,$current_month);
				$village_crop_summary = VillageCropMonthlySummary::villageCropMonthlyPerformance($user_id, $time, $current_year,$current_month);
				$village_product_summary = VillageProductMonthlySummary::villageProductMonthlyPerformance($user_id, $time, $current_year,$current_month);
				$crop_wise_activity_summary = CropWiseMonthlyActivitySummary::cropActivityMonthlyPerformance($user_id, $time, $current_year,$current_month);
				$product_wise_activity_summary = ProductWiseMonthlyActivitySummary::productActivityMonthlyPerformance($user_id, $time, $current_year,$current_month);
				$total_campaigns = MonthTotalCampaignsSummary::totalCampaignMonthlyPerformance($user_id, $time, $current_year,$current_month);
				$group_campaigns = TmpCropWiseMonthlyActivitySummary::groupCampaignsMonthlyPerformance($user_id, $time, $current_year,$current_month);
				$activity_wise_crops = CropWiseMonthlyActivitySummary::ActivityWiseCropsMonthlyPerformance($user_id, $time, $current_year, $current_month);
				$activity_wise_products = ProductWiseMonthlyActivitySummary::ActivityWiseProductsMonthlyPerformance($user_id, $time, $current_year, $current_month);
				$plan_summary = PlanWiseMonthlySummary::planMonthlySummary($user_id, $time, $current_year,$current_month);
				$farmers_summary = TotalFarmersSummary::farmersSummary($user_id, $time, $current_year,$current_month);
			}
				//  echo '<pre>';print_r($crop_data);exit;
				$responses = array();
				$responses[0] = $village_wise_activity_summary;
				$responses[1] = $village_crop_summary;
				$responses[2] = $village_product_summary;
				$responses[3] = $crop_wise_activity_summary;
				$responses[4] = $product_wise_activity_summary;
				$responses[5] = $distance_performance;
				$responses[6] = $total_campaigns;
				$responses[7] = $group_campaigns;
				$responses[8] = $activity_wise_crops;
				$responses[9] = $activity_wise_products;
				$responses[10] = $plan_summary;
				$responses[11] = $farmers_summary;
				return json_encode($responses);

		}

	}

	
	/* public function runChildsRecoursive($arr,$ids = array()) {
		global $ids;
		if(!empty($arr)) {
			foreach($arr as $c) {
				$ids[] = $c['id'];
				$this->runChildsRecoursive($c['childs'],$ids);
			}
		}
		return $ids;
		
	} */

}