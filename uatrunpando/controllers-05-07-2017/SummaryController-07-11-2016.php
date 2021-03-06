<?php
namespace app\controllers;
use yii\web\Controller;
use Yii;
use yii\db\Query;
use app\models\TravellogYearlySummary;
use app\models\CropWiseActivityYearSummary;
use app\models\Summary;
use app\models\CropWiseMonthlyActivitySummary;
use app\models\ProductWiseYearlyActivitySummary;
use app\models\ProductWiseMonthlyActivitySummary;
use app\models\VillageWiseYearlyActivitySummary;
use app\models\VillageWiseMonthlyActivitySummary;
use app\models\MonthWiseTravellogSummary;
use app\models\TmpCropWiseYearlyActivitySummary;
use app\models\Users;
use app\models\TmpProductWiseYearlyActivitySummary;
use app\models\TmpVillageWiseYearlyActivitySummary;
use app\models\TmpCropWiseMonthlyActivitySummary;
use app\models\TmpProductWiseMonthlyActivitySummary;
use app\models\TmpVillageWiseMonthlyActivitySummary;
use app\models\TmpTravellogYearlySummary;
use app\models\YearTotalCampaignsSummary;
use app\models\MonthTotalCampaignsSummary;
use app\models\TmpTravellogMonthlySummary;
use app\models\TravellogMonthlySummary;
use app\models\TmpVillageCropYearlySummary;
use app\models\VillageCropYearlySummary;
use app\models\TmpVillageCropMonthlySummary;
use app\models\VillageCropMonthlySummary;
use app\models\TmpVillageProductYearlySummary;
use app\models\VillageProductYearlySummary;
use app\models\TmpVillageProductMonthlySummary;
use app\models\VillageProductMonthlySummary;
use app\models\TmpPlanWiseYearlySummary;
use app\models\PlanWiseYearlySummary;
use app\models\PlanWiseMonthlySummary;
use app\models\TotalFarmersSummary;
use app\models\Roles;

class SummaryController extends Controller
{
	//for travel log yearly and monthly summary
	public function actionYearlytravellog()
	{
		$current_year = date("Y");
		$current_month = date("m");

		if(isset($_GET['debug'])){
			echo "Deleting data from summary tables<br/>";
		}
		#delete current month's data
		$delete_query = new Query();
		$delete_query->createCommand()
		->delete('tmp_travellog_yearly_summary', [ 'year' => $current_year, 'month' => $current_month ])
		->execute();

		$delete_query1 = new Query();
		$delete_query1->createCommand()
		->delete('travellog_yearly_summary', [ 'year' => $current_year, 'month' => $current_month ])
		->execute();

		/* $sql = "SELECT SUM( distance_travelled ) AS total_distance, YEAR(  `updated_date` ) AS year, MONTH(  `updated_date` ) AS month, assign_to AS user_id
		 FROM  `plan_cards`
		WHERE YEAR(  `updated_date` ) = $current_year
		AND MONTH(  `updated_date` ) = $current_month
		AND status ='submitted'
		GROUP BY assign_to, MONTH(updated_date)"; */
		$sql = 'SELECT SUM(total_distance) as total_distance, YEAR( updated_date) AS year, MONTH(updated_date) AS month, user_id
				FROM ((SELECT SUM( distance_travelled ) AS total_distance, updated_date, assign_to AS user_id
				FROM  plan_cards
				WHERE YEAR( updated_date) = "'.$current_year.'"
						AND MONTH( updated_date) = "'.$current_month.'"
								AND status = "submitted"
								GROUP BY assign_to, MONTH(updated_date))
								UNION
								(SELECT SUM(distance_travelled) as total_distance, date_time as updated_time, user_id
								FROM user_travellog
								WHERE YEAR( date_time ) = "'.$current_year.'"
										AND MONTH( date_time ) = "'.$current_month.'"
												GROUP BY user_id, MONTH(date_time)))  dummy_name
												GROUP BY MONTH(updated_date), user_id';
		$queryresp = Yii::$app ->db->createCommand($sql)->queryAll();

		if (isset($_GET['debug'])) {
			echo 'Fetching data:<pre>';
			print_r($queryresp);
		}

		$reportingManagers = array();
		$ff = array();
		$flag = 'yearly';
		if (!empty($queryresp)) {
			foreach ($queryresp as $travellogInfo) {
				$obj = new TmpTravellogYearlySummary();
				$obj->attributes = $travellogInfo;
				$obj->save(false);
				$ff[] = $travellogInfo['user_id'];
			}
			


			$data = $this->getChildsRecoursive(0,true);
			if(isset($_GET['debug'])){
				echo "User Levels<br/>";
				echo "<pre>";print_r($data);
			}
			foreach ($data as $key => $val){
				//$val = $data[138];
				$params = array();
				$params['query'] =	"SELECT   [[id]] as user_id, sum(total_distance) as total_distance, month, year
				FROM tmp_travellog_yearly_summary
				WHERE user_id in  ([[ids]])
				GROUP BY year, month";
				$params['table'] = "tmp_travellog_yearly_summary";
				$params['whereCond'] = array('user_id', 'year', 'month');
				$params['updateFields'] = array('total_distance');
				$this->runChildsRecoursive($val,$params);
			}
			// $this->managersTravellogSummary($ff, $flag);
			$this->updateMainTravellogTable($current_year, $current_month, $flag);
		} else {
			echo 'Not Saved';
		}
	}
	public function actionMonthlytravellog()
	{
		$current_year = date("Y");
		$current_month = date('m');
		$current_day = date("d");

		#delete current month's data
		$delete_query = new Query();
		$delete_query->createCommand()
		->delete('tmp_travellog_monthly_summary', [ 'year' => $current_year, 'month' => $current_month ])
		->execute();

		$delete_query1 = new Query();
		$delete_query1->createCommand()
		->delete('travellog_monthly_summary', [ 'year' => $current_year, 'month' => $current_month ])
		->execute();

		/* $sql = "SELECT SUM( distance_travelled ) AS total_distance ,YEAR(  updated_date ) AS year, MONTH(  updated_date ) AS month,DAY(updated_date) as day, assign_to AS user_id
		 FROM plan_cards
		WHERE YEAR(updated_date) = $current_year
		AND MONTH(updated_date) = $current_month
		AND status ='submitted'
		GROUP BY MONTH(updated_date), DAY(updated_date), assign_to"; */
		$sql = 'SELECT SUM(total_distance) as total_distance, YEAR( updated_date) AS year, MONTH(updated_date) AS month,DAY(updated_date) as day, user_id
				FROM ((SELECT SUM( distance_travelled ) AS total_distance, updated_date, assign_to AS user_id
				FROM  plan_cards
				WHERE YEAR( updated_date) = "'.$current_year.'"
						AND MONTH( updated_date) = "'.$current_month.'"
								AND status = "submitted"
								GROUP BY assign_to, MONTH(updated_date),DAY(updated_date))
								UNION
								(SELECT SUM(distance_travelled) as total_distance, date_time as updated_time, user_id
								FROM user_travellog
								WHERE YEAR( date_time ) = "'.$current_year.'"
										AND MONTH( date_time ) = "'.$current_month.'"
												GROUP BY user_id, MONTH(date_time),DAY(date_time)))  dummy_name
												GROUP BY MONTH(updated_date),DAY(updated_date), user_id';
		$queryresp = Yii::$app ->db->createCommand($sql)->queryAll();

		if (isset($_GET['debug'])) {
			echo 'Fetching data:<pre>';
			print_r($queryresp);
		}

		$reportingManagers = array();
		$ff = array();
		$flag = 'monthly';
		if (!empty($queryresp)) {
			foreach ($queryresp as $travellogInfo) {
				$obj = new TmpTravellogMonthlySummary();
				$obj->attributes = $travellogInfo;
				$obj->save(false);
				$ff[] = $travellogInfo['user_id'];
			}
			
			
			$data = $this->getChildsRecoursive(0,true);
			if(isset($_GET['debug'])){
				echo "User Levels<br/>";
				echo "<pre>";print_r($data);
			}
			foreach ($data as $key => $val){
				//$val = $data[138];
				$params = array();
				$params['query'] =	"SELECT   [[id]] as user_id, sum(total_distance) as total_distance, day, month, year
				FROM tmp_travellog_monthly_summary
				WHERE user_id in  ([[ids]]) and month = $current_month
				GROUP BY year, month, day";
				$params['table'] = "tmp_travellog_monthly_summary";
				$params['whereCond'] =array('user_id', 'year', 'month', 'day');
				$params['updateFields'] = array('total_distance');
				$this->runChildsRecoursive($val,$params);
			}
			//$this->managersTravellogSummary($ff, $flag);
			$this->updateMainTravellogTable($current_year, $current_month, $flag);
		} else {
			echo 'Not Saved';
		}
	}
	private function managersTravellogSummary($users, $flag)
	{
		if(isset($_GET['debug'])){
			echo "Fetching managers<br/>";
		}
		$managersInfo = Users::getReportingManagers($users);
		$mgCnt = count($managersInfo);
		$ids = array();
		if ($flag == 'yearly') {
			$replace_list = ', month, year';
			$select_list = ', month, year';
			$replace_table = 'tmp_travellog_yearly_summary';
			$from_table = 'tmp_travellog_yearly_summary';
			$group_by = 'year, month';
			$where_unique_variables = array('user_id', 'year', 'month');
		} else {
			$replace_list = ', day, month, year';
			$select_list = ', day, month, year';
			$replace_table = 'tmp_travellog_monthly_summary';
			$from_table = 'tmp_travellog_monthly_summary';
			$group_by = 'year, month, day';
			$where_unique_variables = array('user_id', 'year', 'month', 'day');
		}
		#yearly travellog

		if($mgCnt > 0) {
			if(isset($_GET['debug'])){
				echo "Managers Info: <pre>";
				print_r($managersInfo);
				echo "</pre>";
			}
			if(isset($_GET['debug'])){
				echo "Adding managers activity info<br/>";
			}
			for ($j=0; $j < $mgCnt; $j++) {
				$ids[] = $managersInfo[$j]['id'];
				$mangerId = $managersInfo[$j]['id'];
				$reportees = $managersInfo[$j]['reportees'];

				/* $sql = "REPLACE INTO $replace_table (user_id, total_distance $replace_list)
					SELECT  $mangerId, sum(total_distance) $select_list
				FROM $from_table
				WHERE user_id in ($reportees)
				GROUP BY $group_by";
				$res = Yii::$app->db->createCommand($sql)->execute(); */
				$query = "SELECT  $mangerId as user_id, sum(total_distance) as total_distance $select_list
				FROM $from_table
				WHERE user_id in ($reportees)
				GROUP BY $group_by";
				$table = $from_table;
				$whereCond = $where_unique_variables;
				$updateFields = array('total_distance');
				$this->insertAndUpdateOnDupe($query, $table, $whereCond, $updateFields);
			}

			if (count($ids) > 0){
				$this->managersTravellogSummary($ids, $flag); # recursive function
			}
		}


	}
	private function updateMainTravellogTable($year, $month, $flag)
	{
		if ($flag == 'yearly') {
			$obj = new TmpTravellogYearlySummary;
			$whereCond = ['year' => $year, 'month'=> $month];
			$order_by = 'user_id, total_distance desc';
		} else {
			$obj = new TmpTravellogMonthlySummary;
			$whereCond = ['year' => $year, 'month'=> $month];
			$order_by = 'user_id, total_distance desc';
		}

		$travel_log = $obj->find()->where($whereCond)->orderBy($order_by)->asArray()->all();
		if (count($travel_log) > 0) {
			foreach ($travel_log as $log) {
				if ($flag == 'yearly') {
					$model = new TravellogYearlySummary;
				} else {
					$model = new TravellogMonthlySummary;
				}
				$model->attributes = $log;
				$model->save(false);
			}
		}

	}

	//for village crop yearly and monthly summary log
	public function actionVillagecropyearlysummarylog()
	{
		$current_year = date("Y");
		$current_month = date("m");
		$current_day = date("d");

		if(isset($_GET['debug'])){
			echo "Deleting data from summary tables<br/>";
		}

		#delete current month's data
		$delete_query1 = new Query();
		$delete_query1->createCommand()
		->delete('tmp_village_crop_yearly_summary', [ 'year' => $current_year,'month' => $current_month ])
		->execute();
			
		$delete_query = new Query();
		$delete_query->createCommand()
		->delete('village_crop_yearly_summary',[ 'year' => $current_year])
		->execute();

		if(isset($_GET['debug'])){
			echo "Fetching FF activity details and inserting them into Temp table<br/>";
		}

		#Get data to insert into Summary table
		$query = "SELECT assign_to AS user_id, village_id, crop_id, count(id) AS total, MONTH(updated_date) AS month, YEAR(updated_date) AS year
		FROM plan_cards
		WHERE status = 'submitted'
		AND card_type != 'channel card'
		AND is_deleted = 0
		AND YEAR(updated_date) = $current_year
		AND MONTH(updated_date) = $current_month
		GROUP BY assign_to, village_id, crop_id
		ORDER BY total DESC";
		$queryresp = Yii::$app->db->createCommand($query)->queryAll();
		// 		echo '<pre>';
		// 		print_r($queryresp);exit;
		$reportingManagers = array();
		$ff = array();
		$duration = 'yearly';
		if (!empty($queryresp)) {
			foreach ($queryresp as $activityInfo) {
				$obj = new TmpVillageCropYearlySummary;
				$obj->attributes = $activityInfo;
				$obj->save(false);
				$ff[] = $activityInfo['user_id'];
			}
			$this->managersVillageCropSummary($ff, $duration,$current_month);
			$this->updateMainVillageCropSummaryTable($current_year, $current_month, $duration);
		} else {
			echo 'Not Saved';
		}
	}

	public function actionVillagecropmonthlysummarylog()
	{
		$current_year = date("Y");
		$current_month = date("m");
		$current_day = date("d");

		if(isset($_GET['debug'])){
			echo "Deleting data from summary tables<br/>";
		}

		#delete current month's data
		$delete_query1 = new Query();
		$delete_query1->createCommand()
		->delete('tmp_village_crop_monthly_summary', [ 'year' => $current_year,'month' => $current_month ])
		->execute();
			
		$delete_query = new Query();
		$delete_query->createCommand()
		->delete('village_crop_monthly_summary',[ 'year' => $current_year,'month' => $current_month ])
		->execute();

		if(isset($_GET['debug'])){
			echo "Fetching FF activity details and inserting them into Temp table<br/>";
		}

		#Get data to insert into Summary table
		$query = "SELECT assign_to AS user_id, village_id, crop_id, count(id) AS total, MONTH(updated_date) AS month, YEAR(updated_date) AS year
		FROM plan_cards
		WHERE status = 'submitted'
		AND card_type != 'channel card'
		AND is_deleted = 0
		AND YEAR(updated_date) = $current_year
		AND MONTH(updated_date) = $current_month
		GROUP BY assign_to, village_id, crop_id
		ORDER BY total DESC";
		$queryresp = Yii::$app->db->createCommand($query)->queryAll();
		//echo '<pre>';print_r($queryresp);exit;
		$reportingManagers = array();
		$ff = array();
		$duration = 'monthly';
		if (!empty($queryresp)) {
			foreach ($queryresp as $activityInfo) {
				$obj = new TmpVillageCropMonthlySummary;
				$obj->attributes = $activityInfo;
				$obj->save(false);
				$ff[] = $activityInfo['user_id'];
			}
			$this->managersVillageCropSummary($ff, $duration,$current_month);
			$this->updateMainVillageCropSummaryTable($current_year, $current_month, $duration);
		} else {
			echo 'Not Saved';
		}
	}
	private function managersVillageCropSummary($users, $duration,$current_month){
		if (isset($_GET['debug'])) {
			echo "Fetching managers<br/>";
		}
		$managersInfo = Users::getReportingManagers($users);
		$mgCnt = count($managersInfo);
		$ids = array();
		if ($duration == 'yearly') {
			$replaceTable = 'tmp_village_crop_yearly_summary';
			$fromTable = 'tmp_village_crop_yearly_summary';
		} else {
			$replaceTable = 'tmp_village_crop_monthly_summary';
			$fromTable = 'tmp_village_crop_monthly_summary';
		}
		if ($mgCnt > 0) {
			if (isset($_GET['debug'])) {
				echo "Managers Info: <pre>";
				print_r($managersInfo);
				echo "</pre>";
			}
			if (isset($_GET['debug'])) {
				echo "Adding managers activity info<br/>";
			}
			for ($j = 0;$j < $mgCnt; $j++) {
				$ids[] = $managersInfo[$j]['id'];
				$mangerId = $managersInfo[$j]['id'];
				$reportees = $managersInfo[$j]['reportees'];

				/* $sql = "REPLACE INTO $replaceTable (user_id, village_name, crop_name, total, month, year)
					SELECT  $mangerId, village_name, crop_name, sum(total) as total, month, year
				FROM  $fromTable
				WHERE user_id in ($reportees)
				GROUP BY village_name, crop_name,year, month";
				$res = Yii::$app->db->createCommand($sql)->execute(); */
				$query = "SELECT  $mangerId as user_id, village_id, crop_id, sum(total) as total, month, year
				FROM  $fromTable
				WHERE user_id in ($reportees)
				and month = $current_month
				GROUP BY village_id, crop_id, year,month";
				$table = $fromTable;
				$updateFields = array('total');
				$whereCond = array('user_id', 'year','month','village_id', 'crop_id');
				$this->insertAndUpdateOnDupe($query, $table, $whereCond, $updateFields);
			}
			if (count($ids) > 0) {
				$this -> managersVillageCropSummary($ids, $duration,$current_month); # recursive function
			}

		}
	}

	private function updateMainVillageCropSummaryTable($year, $month, $duration)
	{
		$tot = 0;
		if ($duration == 'yearly') {
			$obj = new TmpVillageCropYearlySummary;
			$month_condition = ['year' => $year];
		} else {
			$obj = new TmpVillageCropMonthlySummary;
			$month_condition = ['year' => $year,'month'=> $month];
		}
			
		$crop_log = $obj->find()->select('SUM( total ) AS total, user_id,crop_id, village_id')->where($month_condition)->groupBy('user_id,crop_id,village_id')->orderBy('user_id, total desc')->asArray()->all();
		$cropsCnt = 3;

		$summary = array();
		$count_crops = array();
		foreach ($crop_log as $crop) {
			$villageName = $crop['village_id'];
			$cropName = $crop['crop_id'];
			$userId = $crop['user_id'];
			$cnt = 0;
			if (isset($summary[$userId][$villageName])) {
				$cnt = count($summary[$userId][$villageName]);
			}

			if ( $cnt < $cropsCnt) {
				$summary[$userId][$villageName][$cropName] = $crop['total'];
					
			} else {
				if ($cnt == $cropsCnt) {
					$summary[$userId][$villageName]['2147483647'] = array('total'=> $crop['total'], 'cropName' => $cropName);
					$count_crops[$userId][$villageName]['count'] = array('count_crops' => $crop['total']);
				} else {
					//$prevTotal = $summary[$userId][$villageName]['2147483647']['total'];
					//$summary[$userId][$villageName]['2147483647'] = $prevTotal + $crop['total'];
					$count_crops[$userId][$villageName]['count']['count_crops'] += $crop['total'];
					$summary[$userId][$villageName]['2147483647'] = $count_crops[$userId][$villageName]['count']['count_crops'];
				}
			}
		}
		//echo "<pre>";
		if (count($cropsCnt) > 0) {
			foreach ($summary as $userId => $villageInfo) {
				foreach ($villageInfo as $villageName => $cropInfo) {
					$crop1 = $crop2 = $crop3 = $crop4 = '0';
					$crop1Cnt = $crop2Cnt = $crop3Cnt = $crop4Cnt = '0';
					$i = 1;
					$totalSum = 0;
					//print_r($cropInfo);
					foreach($cropInfo as $cropName => $total) {
						$label = 'crop'.$i;
						$labelcnt = 'crop'.$i.'Cnt';
						if($cropName == '2147483647' && is_array($total)) {
							$$label = $total['cropName'] ;
							$$labelcnt = $total['total'] ;
						} else {
							$$label = $cropName ;
							$$labelcnt = $total ;
						}

							
						$totalSum = $totalSum + $$labelcnt;
						$i++;
					}
					if ($duration == 'yearly') {
						$model = new VillageCropYearlySummary;
					} else {
						$model = new VillageCropMonthlySummary;
						$model->month = $month;
					}
					$model->village_id = $villageName;
					$model->user_id = $userId;
					$model->year = $year;

					$model->crop1 = $crop1;
					$model->crop1_total = $crop1Cnt;
					$model->crop2 = $crop2;
					$model->crop2_total = $crop2Cnt;
					$model->crop3 = $crop3;
					$model->crop3_total = $crop3Cnt;
					$model->crop4 = $crop4;
					$model->crop4_total = $crop4Cnt;
					$model->total = $totalSum;
					$model->save(false);
					//print_r($model->attributes);
				}
			}
		} else {
			echo 'Not Saved';
		}

	}

	//for village product yearly and monthly summary log
	public function actionVillageproductyearlysummarylog()
	{
		$current_year = date("Y");
		$current_month = date("m");
		$current_day = date("d");

		if(isset($_GET['debug'])){
			echo "Deleting data from summary tables<br/>";
		}

		#delete current month's data
		$delete_query1 = new Query();
		$delete_query1->createCommand()
		->delete('tmp_village_product_yearly_summary', [ 'year' => $current_year,'month' => $current_month ])
		->execute();
			
		$delete_query = new Query();
		$delete_query->createCommand()
		->delete('village_product_yearly_summary',[ 'year' => $current_year])
		->execute();

		if(isset($_GET['debug'])){
			echo "Fetching FF activity details and inserting them into Temp table<br/>";
		}

		#Get data to insert into Summary table
		$query = "SELECT assign_to AS user_id, village_id, product_id, count(id) AS total, MONTH(updated_date) AS month, YEAR(updated_date) AS year
		FROM plan_cards
		WHERE status = 'submitted'
		AND card_type != 'channel card'
		AND is_deleted = 0
		AND YEAR(updated_date) = $current_year
		AND MONTH(updated_date) = $current_month
		GROUP BY assign_to, village_id, product_id
		ORDER BY total DESC";
		$queryresp = Yii::$app->db->createCommand($query)->queryAll();
		$reportingManagers = array();
		$ff = array();
		$duration = 'yearly';
		if (!empty($queryresp)) {
			foreach ($queryresp as $activityInfo) {
				$obj = new TmpVillageProductYearlySummary;
				$obj->attributes = $activityInfo;
				$obj->save(false);
				$ff[] = $activityInfo['user_id'];
			}
			$this->managersVillageProductSummary($ff, $duration,$current_month);
			$this->updateMainVillageProductSummaryTable($current_year, $current_month, $duration);
		} else {
			echo 'Not Saved';
		}
	}

	public function actionVillageproductmonthlysummarylog()
	{
		$current_year = date("Y");
		$current_month = date("m");
		$current_day = date("d");

		if(isset($_GET['debug'])){
			echo "Deleting data from summary tables<br/>";
		}

		#delete current month's data
		$delete_query1 = new Query();
		$delete_query1->createCommand()
		->delete('tmp_village_product_monthly_summary', [ 'year' => $current_year,'month' => $current_month ])
		->execute();

		$delete_query = new Query();
		$delete_query->createCommand()
		->delete('village_product_monthly_summary',[ 'year' => $current_year,'month' => $current_month ])
		->execute();

		if(isset($_GET['debug'])){
			echo "Fetching FF activity details and inserting them into Temp table<br/>";
		}

		#Get data to insert into Summary table
		$query = "SELECT assign_to AS user_id, village_id, product_id, count(id) AS total, MONTH(updated_date) AS month, YEAR(updated_date) AS year
		FROM plan_cards
		WHERE status = 'submitted'
		AND card_type != 'channel card'
		AND is_deleted = 0
		AND YEAR(updated_date) = $current_year
		AND MONTH(updated_date) = $current_month
		GROUP BY assign_to, village_id, product_id
		ORDER BY total DESC";
		$queryresp = Yii::$app->db->createCommand($query)->queryAll();
		//print_r($queryresp);exit;
		$reportingManagers = array();
		$ff = array();
		$duration = 'monthly';
		if (!empty($queryresp)) {
			foreach ($queryresp as $activityInfo) {
				$obj = new TmpVillageProductMonthlySummary;
				$obj->attributes = $activityInfo;
				$obj->save(false);
				$ff[] = $activityInfo['user_id'];
			}
			$this->managersVillageProductSummary($ff, $duration, $current_month);
			$this->updateMainVillageProductSummaryTable($current_year, $current_month, $duration);
		} else {
			echo 'Not Saved';
		}
	}
	private function managersVillageProductSummary($users, $duration, $current_month){
		if (isset($_GET['debug'])) {
			echo "Fetching managers<br/>";
		}
		$managersInfo = Users::getReportingManagers($users);
		$mgCnt = count($managersInfo);
		$ids = array();
		if ($duration == 'yearly') {
			$replaceTable = 'tmp_village_product_yearly_summary';
			$fromTable = 'tmp_village_product_yearly_summary';
		} else {
			$replaceTable = 'tmp_village_product_monthly_summary';
			$fromTable = 'tmp_village_product_monthly_summary';
		}
		if ($mgCnt > 0) {
			if (isset($_GET['debug'])) {
				echo "Managers Info: <pre>";
				print_r($managersInfo);
				echo "</pre>";
			}
			if (isset($_GET['debug'])) {
				echo "Adding managers activity info<br/>";
			}
			for ($j = 0;$j < $mgCnt; $j++) {
				$ids[] = $managersInfo[$j]['id'];
				$mangerId = $managersInfo[$j]['id'];
				$reportees = $managersInfo[$j]['reportees'];

				/* $sql = "REPLACE INTO $replaceTable (user_id, village_name, product_name, total, month, year)
				 SELECT  $mangerId, village_name, product_name, sum(total) as total, month, year
				FROM  $fromTable
				WHERE user_id in ($reportees)
				GROUP BY village_name, product_name, year, month";
				$res = Yii::$app->db->createCommand($sql)->execute(); */
				$query = "SELECT  $mangerId as user_id, village_id, product_id, sum(total) as total, month, year
				FROM  $fromTable
				WHERE user_id in ($reportees)
				and month = $current_month
				GROUP BY village_id, product_id, year, month";
				$table = $fromTable;
				$whereCond = array('user_id', 'year', 'month', 'village_id', 'product_id');
				$updateFields = array('total');
				$this->insertAndUpdateOnDupe($query, $table, $whereCond, $updateFields);
			}

			if (count($ids) > 0) {
				$this -> managersVillageProductSummary($ids, $duration, $current_month); # recursive function
			}
		}
	}

	private function updateMainVillageProductSummaryTable($year, $month, $duration)
	{
		if ($duration == 'yearly') {
			$obj = new TmpVillageProductYearlySummary;
			$month_condition = ['year' => $year];
		} else {
			$obj = new TmpVillageProductMonthlySummary;
			$month_condition = ['year' => $year, 'month'=> $month];
		}

		//$product_log = $obj->find()->where($month_condition)->orderBy('user_id, total desc')->asArray()->all();
		$product_log = $obj->find()->select('SUM( total ) AS total, user_id,product_id, village_id')->where($month_condition)->groupBy('user_id,product_id,village_id')->orderBy('user_id, total desc')->asArray()->all();


		$productsCnt = 3;
		$count_crops = array();
		$summary = array();
		foreach ($product_log as $product) {
			$villageName = $product['village_id'];
			$productName = $product['product_id'];
			$userId = $product['user_id'];
			$cnt = 0;
			if (isset($summary[$userId][$villageName])) {
				$cnt = count($summary[$userId][$villageName]);
			}

			if ( $cnt < $productsCnt) {
				$summary[$userId][$villageName][$productName] = $product['total'];
			} else {
				if ($cnt == $productsCnt) {
					$summary[$userId][$villageName]['2147483647'] = array('total'=> $product['total'], 'productName' => $productName);
					$count_crops[$userId][$villageName]['count'] = array('count_crops' => $product['total']);
				} else {
					/* $prevTotal = $summary[$userId][$villageName]['2147483647']['total'];
					 $summary[$userId][$villageName]['2147483647'] = $prevTotal + $product['total']; */
					$count_crops[$userId][$villageName]['count']['count_crops'] += $product['total'];
					$summary[$userId][$villageName]['2147483647'] = $count_crops[$userId][$villageName]['count']['count_crops'];
				}
			}
		}
		echo "<pre>";
		if (count($productsCnt) > 0) {
			foreach ($summary as $userId => $villageInfo) {
				foreach ($villageInfo as $villageName => $productInfo) {
					$product1 = $product2 = $product3 = $product4 = '0';
					$product1Cnt = $product2Cnt = $product3Cnt = $product4Cnt = '0';
					$i = 1;
					$totalSum = 0;
					//print_r($productInfo);
					foreach($productInfo as $productName => $total) {
						$label = 'product'.$i;
						$labelcnt = 'product'.$i.'Cnt';
						if($productName == '2147483647' && is_array($total)) {
							$$label = $total['productName'] ;
							$$labelcnt = $total['total'] ;
						} else {
							$$label = $productName ;
							$$labelcnt = $total ;
						}


						$totalSum = $totalSum + $$labelcnt;
						$i++;
					}
					if ($duration == 'yearly') {
						$model = new VillageProductYearlySummary;
					} else {
						$model = new VillageProductMonthlySummary;
						$model->month = $month;
					}
					$model->village_id = $villageName;
					$model->user_id = $userId;
					$model->year = $year;
					$model->product1 = $product1;
					$model->product1_total = $product1Cnt;
					$model->product2 = $product2;
					$model->product2_total = $product2Cnt;
					$model->product3 = $product3;
					$model->product3_total = $product3Cnt;
					$model->product4 = $product4;
					$model->product4_total = $product4Cnt;
					$model->total = $totalSum;
					$model->save(false);
					//print_r($model->attributes);
				}
			}
		} else {
			echo 'Not Saved';
		}

	}
	//for activity log yearly and monthly summary
	public function actionGenerateactivitysummarylog()
	{
		$current_year = date("Y");
		$current_month = date("m");
		$current_day = date("d");

		if(!isset($_GET['summaryType'])){
			exit ('Summary type is missing');
		}

		$basedOn = $_GET['summaryType'];
		$summaryTable = $tmpSummaryTable = '';
		$groupBy = array('user_id', 'month');
		$selectList = $replaceSelectList = array ();
		$params = '';
		$duration ='yearly';
		switch($basedOn){
			case 'crop' :
				$tmpTableModel = new TmpCropWiseYearlyActivitySummary();
				$params['summaryTable'] = $summaryTable = 'crop_wise_yearly_activity_summary';
				$params['tmpSummaryTable'] = $tmpSummaryTable = 'tmp_crop_wise_yearly_activity_summary';
				$params['groupBy'][] = $groupBy[] = 'crop_id';
				$params['replaceSelectList'][] = $params['selectList'][] = $selectList[] = 'crop_id';
				$params['summaryBasedOnField'] = 'crop_id';
				$params['current_month'] = $current_month;
				$group_name = 'user_id,crop_id';
				$params['whereCondition'][] = 'MONTH(updated_date) ='.$current_month;
				$select_group =  'user_id,crop_id';
				$whereduration = ['year' => $current_year];
				$selecColumns = 'year, month';
				$where_unique_variables = array('user_id', 'year', 'month', 'crop_id');
				break;
			case 'product' :
				$tmpTableModel = new TmpProductWiseYearlyActivitySummary();
				$params['summaryTable'] = $summaryTable = 'product_wise_yearly_activity_summary';
				$params['tmpSummaryTable'] = $tmpSummaryTable = 'tmp_product_wise_yearly_activity_summary';
				$params['groupBy'][] = $groupBy[] = 'product_id';
				$params['replaceSelectList'][] = $params['selectList'][] = $selectList[] = 'product_id';
				$params['summaryBasedOnField'] = 'product_id';
				$params['current_month'] = $current_month;
				$group_name = 'user_id, product_id';
				$params['whereCondition'][] = 'MONTH(updated_date) ='.$current_month;
				$select_group =  'user_id, product_id';
				$whereduration = ['year' => $current_year];
				$selecColumns = 'year, month';
				$where_unique_variables = array('user_id', 'year', 'month', 'product_id');
				break;
			case 'village' :
				$tmpTableModel = new TmpVillageWiseYearlyActivitySummary();
				$params['summaryTable'] = $summaryTable = 'village_wise_yearly_activity_summary';
				$params['tmpSummaryTable'] = $tmpSummaryTable = 'tmp_village_wise_yearly_activity_summary';
				$params['groupBy'][] = $groupBy[] = 'village_id';
				$params['replaceSelectList'][] = $params['selectList'][] = $selectList[] = 'village_id';
				$params['summaryBasedOnField'] = 'village_id';
				$params['current_month'] = $current_month;
				$group_name = 'user_id,village_id';
				$params['whereCondition'][] = 'MONTH(updated_date) ='.$current_month;
				$select_group =  'user_id,village_id';
				$whereduration = ['year' => $current_year];
				$selecColumns = 'year, month';
				$where_unique_variables = array('user_id', 'year', 'month', 'village_id');
				break;
			case 'monthlycrop' :
				$tmpTableModel = new TmpCropWiseMonthlyActivitySummary();
				$params['summaryTable'] = $summaryTable = 'crop_wise_monthly_activity_summary';
				$params['tmpSummaryTable'] = $tmpSummaryTable = 'tmp_crop_wise_monthly_activity_summary';
				$params['groupBy'][] = $groupBy[] = 'crop_id';
				$params['groupBy'][] = $groupBy[] = 'day';
				$params['selectList'][] = $selectList[] = 'crop_id';
				$params['selectList'][] = $selectList[] = 'DAY(updated_date) as day';
				$params['replaceSelectList'][] = $replaceSelectList[] = 'day';
				$params['replaceSelectList'][] = $replaceSelectList[] = 'crop_id';
				$params['summaryBasedOnField'] = 'crop_id';
				$params['current_month'] = $current_month;
				$group_name = 'user_id,crop_id,month';
				//	$params['whereCondition'][] = 'DAY(updated_date) ='.$current_day;
				$params['whereCondition'][] = 'MONTH(updated_date) ='.$current_month;
				$duration ='monthly';
				$select_group =  'user_id,crop_id,month';
				$whereduration = ['year' => $current_year,'month' =>$current_month];
				$selecColumns = 'year, month, day';
				$where_unique_variables = array('user_id', 'year', 'month', 'day', 'crop_id');
				break;
			case 'monthlyproduct' :
				$tmpTableModel = new TmpProductWiseMonthlyActivitySummary();
				$params['summaryTable'] = $summaryTable = 'product_wise_monthly_activity_summary';
				$params['tmpSummaryTable'] = $tmpSummaryTable = 'tmp_product_wise_monthly_activity_summary';
				$params['groupBy'][] = $groupBy[] = 'product_id';
				$params['groupBy'][] = $groupBy[] = 'day';
				$params['selectList'][] = $selectList[] = 'product_id';
				$params['selectList'][] = $selectList[] = 'DAY(updated_date) as day';
				$params['replaceSelectList'][] = $replaceSelectList[] = 'day';
				$params['replaceSelectList'][] = $replaceSelectList[] = 'product_id';
				$params['summaryBasedOnField'] = 'product_id';
				$group_name = 'user_id,product_id,month';
				$params['current_month'] = $current_month;
				//	$params['whereCondition'][] = 'DAY(updated_date) ='.$current_day;
				$params['whereCondition'][] = 'MONTH(updated_date) ='.$current_month;
				$duration ='monthly';
				$select_group =  'user_id,product_id,month';
				$whereduration = ['year' => $current_year,'month' =>$current_month];
				$selecColumns = 'year, month, day';
				$where_unique_variables = array('user_id', 'year', 'month', 'day', 'product_id');
				break;
			case 'monthlyvillage' :
				$tmpTableModel = new TmpVillageWiseMonthlyActivitySummary();
				$params['summaryTable'] = $summaryTable = 'village_wise_monthly_activity_summary';
				$params['tmpSummaryTable'] = $tmpSummaryTable = 'tmp_village_wise_monthly_activity_summary';
				$params['groupBy'][] = $groupBy[] = 'village_id';
				$params['groupBy'][] = $groupBy[] = 'day';
				$params['selectList'][] = $selectList[] = 'village_id';
				$params['selectList'][] = $selectList[] = 'DAY(updated_date) as day';
				$params['replaceSelectList'][] = $replaceSelectList[] = 'day';
				$params['replaceSelectList'][] = $replaceSelectList[] = 'village_id';
				$params['summaryBasedOnField'] = 'village_id';
				$params['current_month'] = $current_month;
				$group_name = 'user_id,village_id,month';
				//	$params['whereCondition'][] = 'DAY(updated_date) ='.$current_day;
				$params['whereCondition'][] = 'MONTH(updated_date) ='.$current_month;
				$duration ='monthly';
				$select_group =  'user_id,village_id,month';
				$whereduration = ['year' => $current_year,'month' =>$current_month];
				$selecColumns = 'year, month, day';
				$where_unique_variables = array('user_id', 'year', 'month', 'day', 'village_id');
				break;
		}
		if(isset($_GET['debug'])){
			echo "Deleting data from summary tables<br/>";
		}

		if($duration !='monthly') {
			#delete current month's data
			$delete_query1 = new Query();
			$delete_query1->createCommand()
			->delete($tmpSummaryTable, [ 'year' => $current_year,'month' =>$current_month ])
			->execute();

			$delete_query = new Query();
			$delete_query->createCommand()
			->delete($summaryTable,[ 'year' => $current_year ])
			->execute();
		} else {
			#delete current month's data
			$delete_query1 = new Query();
			$delete_query1->createCommand()
			->delete($tmpSummaryTable, [ 'year' => $current_year,'month' =>$current_month])
			->execute();

			$delete_query = new Query();
			$delete_query->createCommand()
			->delete($summaryTable,[ 'year' => $current_year,'month' =>$current_month])
			->execute();
		}

		if(isset($_GET['debug'])){
			echo "Fetching FF activity details and inserting them into Temp table<br/>";
		}
		$groupQry = implode (',',$groupBy);
		$subQry = '';
		if(count($selectList)>0)
			$subQry = ','.implode (',',$selectList);
		$whereCond = '';
		if(isset($params['whereCondition']))
			$whereCond = ' and '.implode (' and ',$params['whereCondition']);
		#Get data to insert into Summary table
		$query = "SELECT MONTH(updated_date) AS month, YEAR(updated_date) AS year, assign_to AS user_id,
				SUM( IF( activity = 'Mass Campaign', 1, 0 ) ) AS mc, SUM( IF( activity = 'Farmer Group Meeting', 1, 0 ) ) AS fgm,
				SUM( IF( activity ='Demonstration', 1, 0 ) ) AS demo, SUM( IF( activity = 'Farm and Home Visit', 1, 0 ) ) AS fhv,
				COUNT( id ) AS total ".$subQry."
				FROM plan_cards WHERE status = 'submitted'
				AND activity != 'Channel Card'
				AND is_deleted = 0
				AND YEAR(updated_date) = $current_year ".$whereCond."
						GROUP BY ".$groupQry."
								ORDER BY user_id , total DESC";
		$queryresp = Yii::$app->db->createCommand($query)->queryAll();
		$reportingManagers = array();
		$ff=array();
		if (!empty($queryresp)) {
			foreach ($queryresp as $activityInfo) {
				$obj = $this -> getModelObj('tmp'.$_GET['summaryType']);
				$obj->attributes = $activityInfo;
				$obj->save(false);
				$ff[]=$activityInfo['user_id'];
			}
			$replaceQry = $selectQry = $groupQry = '';
			
			if(count($params['groupBy'])>0)
				$groupQry = ','.implode (',',$params['groupBy']);
			
			if(count($params['selectList'])>0)
				$selectQry = ','.implode (',',$params['selectList']);
			
			if(count($params['replaceSelectList'])>0)
				$replaceQry = ','.implode (',',$params['replaceSelectList']);
		 	$data = $this->getChildsRecoursive(0,true);
			if(isset($_GET['debug'])){
				echo "User Levels<br/>";
				echo "<pre>";print_r($data);
			}
			//foreach ($data as $key => $val){
				$val = $data[138];
				$Dyparams = array();
				$Dyparams['query'] = "SELECT  [[id]] as user_id, $selecColumns ,sum(demo) as demo,sum(fgm) as fgm,sum(mc) as mc,sum(fhv) as fhv,sum(total) as total ".$replaceQry."
				FROM  ".$params['tmpSummaryTable']."
				WHERE user_id in ([[ids]]) and month = '".$params['current_month']."'
				GROUP BY year".$groupQry;
				$Dyparams['table'] =  $params['tmpSummaryTable'];
				$Dyparams['whereCond'] = $where_unique_variables;
				$Dyparams['updateFields'] = array('demo','fgm', 'mc', 'fhv', 'total');
				$this->runChildsRecoursive($val,$Dyparams);
			//} 
			//$this->managersActivitySummary($ff, $params, $selecColumns, $where_unique_variables);
			$this->updateMainSummaryTable($current_year, $current_month, $params,$group_name,$select_group,$whereduration);
		} else {
			echo 'Not Saved';
		}
	}
	private function managersActivitySummary($users, $params, $selecColumns, $where_unique_variables){
		if(isset($_GET['debug'])){
			echo "Fetching managers<br/>";
		}
		$managersInfo = Users::getReportingManagers($users);
		$mgCnt = count($managersInfo);
		$ids = array();
		$replaceQry = $selectQry = $groupQry = '';

		if(count($params['groupBy'])>0)
			$groupQry = ','.implode (',',$params['groupBy']);

		if(count($params['selectList'])>0)
			$selectQry = ','.implode (',',$params['selectList']);

		if(count($params['replaceSelectList'])>0)
			$replaceQry = ','.implode (',',$params['replaceSelectList']);

		if($mgCnt >0) {
			if(isset($_GET['debug'])){
				echo "Managers Info: <pre>";
				print_r($managersInfo);
				echo "</pre>";
			}
			if(isset($_GET['debug'])){
				echo "Adding managers activity info<br/>";
			}
			for($j=0;$j<$mgCnt;$j++) {
				$ids[] = $managersInfo[$j]['id'];
				$mangerId = $managersInfo[$j]['id'];
				$reportees = $managersInfo[$j]['reportees'];

				/* $sql = "REPLACE INTO ".$params['tmpSummaryTable']." (user_id,demo,fgm,mc,fhv,total,month, year ".$replaceQry.")
				 SELECT  $mangerId,sum(demo),sum(fgm),sum(mc),sum(fhv),sum(total),month, year ".$replaceQry."
				FROM  ".$params['tmpSummaryTable']."
				WHERE user_id in ($reportees)
				GROUP BY year, month ".$groupQry;
				$res = Yii::$app->db->createCommand($sql)->execute(); */
				$query = "SELECT  $mangerId as user_id, $selecColumns ,sum(demo) as demo,sum(fgm) as fgm,sum(mc) as mc,sum(fhv) as fhv,sum(total) as total ".$replaceQry."
						FROM  ".$params['tmpSummaryTable']."
						WHERE user_id in ($reportees) and month = '".$params['current_month']."'
								GROUP BY year".$groupQry;
				$table = $params['tmpSummaryTable'];
				$whereCond = $where_unique_variables;
				$updateFields = array('demo','fgm', 'mc', 'fhv', 'total');
				$this->insertAndUpdateOnDupe($query, $table, $whereCond, $updateFields);
			}

			if(count($ids)>0){
				$this -> managersActivitySummary($ids, $params, $selecColumns, $where_unique_variables); # recursive function
			}

		}

	}
	private function getModelObj($type){
		switch ($type){
			case 'tmpcrop':
				$obj = new TmpCropWiseYearlyActivitySummary();
				break;
			case 'tmpproduct':
				$obj = new TmpProductWiseYearlyActivitySummary();
				break;
			case 'tmpvillage':
				$obj = new TmpVillageWiseYearlyActivitySummary();
				break;
			case 'crop':
				$obj = new CropWiseActivityYearSummary();
				break;
			case 'product':
				$obj = new ProductWiseYearlyActivitySummary();
				break;
			case 'village':
				$obj = new VillageWiseYearlyActivitySummary();
				break;
			case 'tmpmonthlycrop':
				$obj = new TmpCropWiseMonthlyActivitySummary();
				break;
			case 'tmpmonthlyproduct':
				$obj = new TmpProductWiseMonthlyActivitySummary();
				break;
			case 'tmpmonthlyvillage':
				$obj = new TmpVillageWiseMonthlyActivitySummary();
				break;
			case 'monthlycrop':
				$obj = new CropWiseMonthlyActivitySummary();
				break;
			case 'monthlyproduct':
				$obj = new ProductWiseMonthlyActivitySummary();
				break;
			case 'monthlyvillage':
				$obj = new VillageWiseMonthlyActivitySummary();
				break;
		}
		return $obj;
	}
	private function updateMainSummaryTable($year, $month, $params,$group_name,$select_group,$whereduration)
	{
		$obj = $this -> getModelObj('tmp'.$_GET['summaryType']);
		$crop_log = $obj->find()->select("$select_group,year,sum(demo) as demo, sum(fgm) as fgm,sum(mc) as mc, sum(fhv) as fhv, sum(total) as total")->where($whereduration)->orderBy('user_id, total desc')->groupBy($group_name)->asArray()->all();
		$insertedRecCnt = $others = array ();
		$summaryBasedOnField = $params['summaryBasedOnField'];


		if(count($crop_log)>0) {
			if(isset($_GET['debug'])){
				echo "Adding first 4 ".$_GET['summaryType']." related activity info into Summary table<br/>";
			}
			foreach($crop_log as $log)	{
				$user_id = $log['user_id'];
					
				if(!isset($insertedRecCnt[$user_id])) {
					$insertedRecCnt[$user_id] = 0;
				}
				if($_GET['summaryType'] == 'village' || $_GET['summaryType'] == 'monthlyvillage') {
					$model = $this -> getModelObj($_GET['summaryType']);
					$model->attributes = $log;
					$model->save(false);
				}else {

					if($insertedRecCnt[$user_id]<3) {
						$model = $this -> getModelObj($_GET['summaryType']);
						$model->attributes = $log;
						$model->save(false);
					} else {
						if(!isset($others[$user_id])) {
							$others[$user_id] = $log;
						} else {
							$others[$user_id][$summaryBasedOnField] = '2147483647';
							$others[$user_id]['demo'] = $others[$user_id]['demo'] + $log ['demo'];
							$others[$user_id]['fgm'] = $others[$user_id]['fgm'] + $log ['fgm'];
							$others[$user_id]['mc'] = $others[$user_id]['mc'] + $log ['mc'];
							$others[$user_id]['fhv'] = $others[$user_id]['fhv'] + $log ['fhv'];
							$others[$user_id]['total'] = $others[$user_id]['total'] + $log ['total'];
						}
					}
					$insertedRecCnt[$user_id] = $insertedRecCnt[$user_id] + 1;
				}
			}
			if(count($others)>0) {
				echo "Adding Other ".$_GET['summaryType']." activity info into Summary table<br/>";
				foreach($others as $userid=>$activityDetails)	{
					$model = $this -> getModelObj($_GET['summaryType']);
					$model->attributes = $activityDetails;
					$model->save(false);
				}
			}
		}

	}
	public function actionTotalcampingns()
	{
		// year wise total campaigns
		$current_year = date('Y');
		$current_month = date('m');
		// year table delete query
		$delete_query = new Query();
		$delete_query->createCommand()
		->delete('year_total_campaigns_summary',[ 'year' => $current_year])
		->execute();
		//month table delete query
		$delete_query = new Query();
		$delete_query->createCommand()
		->delete('month_total_campaigns_summary',[ 'year' => $current_year,'month' =>$current_month ])
		->execute();
			
		$model = new TmpCropWiseYearlyActivitySummary();
		$result = $model->find()->select('sum(total) AS total,month,year,user_id')
		->where(['year' => $current_year])
		->groupBy('user_id, month')->asArray()->all();
		//echo '<pre>';print_r($result);exit;
		if(!empty($result)) {
			foreach($result as $log) {
				$obj = new YearTotalCampaignsSummary();
				$obj->attributes = $log;
				if(!$obj->save(false)) {
					echo 'yearlog not saved';
				}
			}
		}
		// year wise total campaigns
			
		//month wise total campaigns
		$model2 = new TmpCropWiseMonthlyActivitySummary();
		$query = $model2->find()->select('sum(total) AS total,day,month,year,user_id')
		->where(['year' => $current_year,'month' =>$current_month ])
		->groupBy('user_id, day')->asArray()->all();
			
		if(!empty($query)) {
			foreach($query as $travel) {
				$obj2 = new MonthTotalCampaignsSummary();
				$obj2->attributes = $travel;
				if(!$obj2->save(false)) {
					echo 'monthlog not saved';
				}
			}

		}
	}
	public function actionPlanyearsummary()
	{
		$current_year = date("Y");
		$current_month = date("m");
		$prev_month =  $current_month-1;
		if(isset($_GET['debug'])){
			echo "Deleting data from summary tables<br/>";
		}

		#delete current month's data
		// 		$delete_query1 = new Query();
		// 		$delete_query1->createCommand()
		// 		->delete('tmp_plan_wise_yearly_summary', [ 'year' => $current_year])
		// 		->execute();

		$delete_query = new Query();
		$delete_query->createCommand()
		->delete('plan_wise_yearly_summary',[ 'year' => $current_year])
		->execute();

		if(isset($_GET['debug'])){
			echo "Fetching FF activity details and inserting them into Temp table<br/>";
		}
		$plan_summary = "SELECT
		assign_to as user_id,
		YEAR(`updated_date`) as `year`,
		count(`id`) as `total`,
		sum(if((is_deleted = 0 and `plan_approval_status`!='Rejected'),1,0)) as `accepted`,
		sum(if((is_deleted = 0 and `plan_approval_status`='Rejected'),1,0)) as `rejected`,
		sum(if((`status`='submitted' and created_by=assign_to),1,0)) as `bc`,
		sum(if((`status`='submitted' and created_by!=assign_to),1,0)) as `ac`,
		sum(if((`status`!='submitted' and `plan_approval_status`!='Rejected' and created_by=assign_to),1,0)) as `bnc`,
		sum(if((`status`!='submitted' and `plan_approval_status`!='Rejected' and created_by!=assign_to),1,0)) as `anc`,
		sum(if((`status`='submitted' and created_by=assign_to and plan_type='planned'),1,0)) as `bc_planned`,
		sum(if((`status`='submitted' and created_by=assign_to and plan_type='adhoc'),1,0)) as `bc_adhoc`,
		sum(if((`status`='submitted' and created_by!=assign_to and plan_type='planned'),1,0)) as `ac_planned`,
		sum(if((`status`='submitted' and created_by!=assign_to and plan_type='adhoc'),1,0)) as `ac_adhoc`,
		sum(if((`status`!='submitted' and `plan_approval_status`!='Rejected' and created_by=assign_to and plan_type='planned'),1,0)) as `bnc_planned`,
		sum(if((`status`!='submitted' and `plan_approval_status`!='Rejected' and created_by=assign_to and plan_type='adhoc'),1,0)) as `bnc_adhoc`,
		sum(if((`status`!='submitted' and `plan_approval_status`!='Rejected' and created_by!=assign_to and plan_type='planned'),1,0)) as `anc_planned`,
		sum(if((`status`!='submitted' and `plan_approval_status`!='Rejected' and created_by!=assign_to and plan_type='adhoc'),1,0)) as `anc_adhoc`
		FROM `plan_cards` where `card_type`!='Channel Card' and is_deleted = 0 and YEAR(`updated_date`) = $current_year and Month(`updated_date`)<= $current_month group by `assign_to`";
		$queryresp = Yii::$app->db->createCommand($plan_summary)->queryAll();
		//print_r($queryresp);exit;
		$reportingManagers = array();
		$ff = array();
		$duration = 'yearly';
		if (!empty($queryresp)) {
			foreach ($queryresp as $planDetails) {
				$obj = new PlanWiseYearlySummary;
				$obj->attributes = $planDetails;
				$obj->save(false);
				$ff[] = $planDetails['user_id'];
				$fieldForceData[$planDetails['user_id']] = $planDetails;
			}
			$data = $this->getChildsRecoursive(0,true);
			if(isset($_GET['debug'])){
				echo "User Levels<br/>";
				echo "<pre>";print_r($data);
			}
			foreach ($data as $key => $val){
 				//$val = $data[138];
				$params = array();
				$params['query'] = "SELECT  [[id]] as user_id, sum(total) as total,$current_year as year,sum(rejected) as rejected, sum(accepted) as accepted, sum(bc) as bc, sum(bnc) as bnc,
				sum(ac) as ac, sum(anc) as anc, sum(bc_planned) as bc_planned, sum(bc_adhoc) as bc_adhoc, sum(ac_planned) as ac_planned, sum(ac_adhoc) as ac_adhoc,
				sum(bnc_planned) as bnc_planned, sum(bnc_adhoc) as bnc_adhoc, sum(anc_planned) as anc_planned, sum(anc_adhoc) as anc_adhoc
				FROM plan_wise_yearly_summary
				WHERE user_id in ([[ids]])";
				$params['table'] = "plan_wise_yearly_summary";
				$params['whereCond'] = array('user_id','year');
				$params['updateFields'] = array('total','rejected', 'accepted', 'bc', 'bnc',
									'ac', 'anc', 'bc_planned', 'bc_adhoc', 'ac_planned', 'ac_adhoc', 'bnc_planned', 'bnc_adhoc', 'anc_planned', 'anc_adhoc');
				$this->runChildsRecoursive($val,$params);
			}
		} else {
			echo 'Not Saved';
		}
	}
	public function runChildsRecoursive($arr,$params) {
		$ids = array();
		if(isset($arr['childs'])) {
			foreach($arr['childs'] as $c) {
				$ids[] = $c['id'];
				$this->runChildsRecoursive($c,$params);
			}
			if(is_array($arr['childs']) && sizeof($arr['childs'])>0) {
				$query = str_replace(array('[[id]]','[[ids]]'),array($arr['id'],implode(',',$ids)),$params['query']);
				$table = $params['table'];
				$whereCond = $params['whereCond'];
				$updateFields = $params['updateFields'];
				$this->insertAndUpdateOnDupe($query, $table, $whereCond, $updateFields);
			}
		}
		return;
	}
	private $level = 0;
	public function getChildsRecoursive($parentid=0,$recoursive=false) 
	{
		$companyIds = Users::find()->select('id')->where(['reporting_user_id'=>$parentid])->asArray()->all();
		$r = array();
		foreach($companyIds as $data){
			$cid = $data['id'];
			if($recoursive) {
				$this->level++;
				$data['level'] = $this->level;
				$data['childs'] = $this->getChildsRecoursive($cid, true);
				$this->level--;
			}
			$r[] = $data;
		}
		return $r;
	}
	

	private function insertAndUpdateOnDupe($query, $table, $whereCond, $updateFields)
	{
		$result = Yii::$app->db->createCommand($query)->queryAll();
		if(!empty($result)) {
			foreach ($result as $rec) {
				$whereQry = array();
				for ($i = 0; $i < count($whereCond); $i++) {
					$key = $whereCond[$i];
					$whereQry[] = $key.'="'.$rec[$key].'"';
				}
				$condition = implode(' and ', $whereQry);
				$selectQry = 'select count(*) as cnt from '.$table.' where '.$condition;
				$recCount = Yii::$app->db->createCommand($selectQry)->queryOne();
				/* echo '<br>';
				 print_r($recCount);
				echo "<br>"; */
				$excuteQryexecute = $excuteQry = $execute ='';
				if ($recCount['cnt'] > 0){
					//update
					$excuteQryexecute = 'update '.$table.' set ';
					$excuteQry = '';
					for ($i = 0; $i < count($updateFields); $i++) {
						$key = $updateFields[$i];
						$excuteQry .= $key.'= '.$key. '+'.$rec[$key].',';
					}
					$excuteQry = trim($excuteQry, ',');
					$excuteQry .= ' where '.$condition ;
					$execute = $excuteQryexecute .  $excuteQry;
				} else {
					$execute = 'insert into '.$table.' set ';
					$insertkeys = array();
					foreach($rec as $key=>$val) {
						$insertkeys [] = $key.'="'.$val.'"';
					}
					$execute .= implode (', ',$insertkeys);
				}
				/* echo $execute;
				 echo "<br>"; */
				Yii::$app->db->createCommand($execute)->execute();

			}
		}else {
			return;
		}
	}
	public function actionPlanmonthsummary()
	{

		$current_year = date("Y");
		$current_month = date("m");
		$prev_month =  $current_month-1;
		$month_end = strtotime('last day of this month', time());
		$month_end_date = date("d",$month_end);
		if(isset($_GET['debug'])){
			echo "Deleting data from summary tables<br/>";
		}

		#delete current month's data
		// 		$delete_query1 = new Query();
		// 		$delete_query1->createCommand()
		// 		->delete('tmp_plan_wise_yearly_summary', [ 'year' => $current_year])
		// 		->execute();

		$delete_query = new Query();
		$delete_query->createCommand()
		->delete('plan_wise_monthly_summary',[ 'year' => $current_year,'month' => $current_month])
		->execute();

		if(isset($_GET['debug'])){
			echo "Fetching FF activity details and inserting them into Temp table<br/>";
		}
		$plan_summary = "SELECT
		assign_to as user_id,
		YEAR(`updated_date`) as `year`,
		Month(`updated_date`) as month,
		count(`id`) as `total`,
		sum(if((is_deleted = 0 and `plan_approval_status`!='Rejected'),1,0)) as `accepted`,
		sum(if((is_deleted = 0 and`plan_approval_status`='Rejected'),1,0)) as `rejected`,
		sum(if((`status`='submitted' and created_by=assign_to),1,0)) as `bc`,
		sum(if((`status`='submitted' and created_by!=assign_to),1,0)) as `ac`,
		sum(if((`status`!='submitted' and `plan_approval_status`!='Rejected' and created_by=assign_to),1,0)) as `bnc`,
		sum(if((`status`!='submitted' and `plan_approval_status`!='Rejected' and created_by!=assign_to),1,0)) as `anc`,
		sum(if((`status`='submitted' and created_by=assign_to and plan_type='planned'),1,0)) as `bc_planned`,
		sum(if((`status`='submitted' and created_by=assign_to and plan_type='adhoc'),1,0)) as `bc_adhoc`,
		sum(if((`status`='submitted' and created_by!=assign_to and plan_type='planned'),1,0)) as `ac_planned`,
		sum(if((`status`='submitted' and created_by!=assign_to and plan_type='adhoc'),1,0)) as `ac_adhoc`,
		sum(if((`status`!='submitted' and `plan_approval_status`!='Rejected' and created_by=assign_to and plan_type='planned'),1,0)) as `bnc_planned`,
		sum(if((`status`!='submitted' and `plan_approval_status`!='Rejected' and created_by=assign_to and plan_type='adhoc'),1,0)) as `bnc_adhoc`,
		sum(if((`status`!='submitted' and `plan_approval_status`!='Rejected' and created_by!=assign_to and plan_type='planned'),1,0)) as `anc_planned`,
		sum(if((`status`!='submitted' and `plan_approval_status`!='Rejected' and created_by!=assign_to and plan_type='adhoc'),1,0)) as `anc_adhoc`
		FROM `plan_cards` where `card_type`!='Channel Card' and is_deleted = 0 and YEAR(`updated_date`) = $current_year and Month(`updated_date`) = $current_month and day(`updated_date`)<= $month_end_date group by `assign_to`";
		$queryresp = Yii::$app->db->createCommand($plan_summary)->queryAll();
		//print_r($queryresp);exit;
		$reportingManagers = array();
		$ff = array();
		$duration = 'yearly';
		if (!empty($queryresp)) {
			foreach ($queryresp as $planDetails) {
				$obj = new PlanWiseMonthlySummary;
				$obj->attributes = $planDetails;
				$obj->save(false);
				$ff[] = $planDetails['user_id'];
			}
			
			
			
			$data = $this->getChildsRecoursive(0,true);
			if(isset($_GET['debug'])){
				echo "User Levels<br/>";
				echo "<pre>";print_r($data);
			}
			foreach ($data as $key => $val){
				//$val = $data[138];
				$params = array();
				$params['query'] =	"SELECT  [[id]] as user_id, sum(total) as total,year,month,sum(rejected) as rejected, sum(accepted) as accepted, sum(bc) as bc, sum(bnc) as bnc,
				sum(ac) as ac, sum(anc) as anc, sum(bc_planned) as bc_planned, sum(bc_adhoc) as bc_adhoc, sum(ac_planned) as ac_planned, sum(ac_adhoc) as ac_adhoc,
				sum(bnc_planned) as bnc_planned, sum(bnc_adhoc) as bnc_adhoc, sum(anc_planned) as anc_planned, sum(anc_adhoc) as anc_adhoc
				FROM plan_wise_monthly_summary
				WHERE user_id in ([[ids]]) and month = $current_month";
				$params['table'] = "plan_wise_monthly_summary";
				$params['whereCond'] = array('user_id','year','month');
				$params['updateFields'] = array('total','rejected', 'accepted', 'bc', 'bnc',
							'ac', 'anc', 'bc_planned', 'bc_adhoc', 'ac_planned', 'ac_adhoc', 'bnc_planned', 'bnc_adhoc', 'anc_planned', 'anc_adhoc');
				$this->runChildsRecoursive($val,$params);
			}
			//$this->managersPlanmonthSummary($ff, $duration,$current_month);
			//$this->updateMainPlanSummaryTable($current_year, $current_month, $duration);
		} else {
			echo 'Not Saved';
		}
	}

/* 	private function managersPlanmonthSummary($users, $duration,$current_month)
	{
		if(isset($_GET['debug'])){
			echo "Fetching managers<br/>";
		}
		$managersInfo = Users::getReportingManagers($users);
		$mgCnt = count($managersInfo);
		if($mgCnt > 0) {
			if(isset($_GET['debug'])){
				echo "Managers Info: <pre>";
				print_r($managersInfo);
				echo "</pre>";
			}
			if(isset($_GET['debug'])){
				echo "Adding managers activity info<br/>";
			}
			for ($j=0; $j < $mgCnt; $j++) {
				$ids[] = $managersInfo[$j]['id'];
				$mangerId = $managersInfo[$j]['id'];
				$reportees = $managersInfo[$j]['reportees'];

				 $sql = "REPLACE INTO plan_wise_monthly_summary  (user_id, total, year,month,rejected, accepted, bc, bnc,
				 ac, anc, bc_planned, bc_adhoc, ac_planned, ac_adhoc, bnc_planned, bnc_adhoc, anc_planned, anc_adhoc)
				SELECT  $mangerId, sum(total), year,month,sum(rejected), sum(accepted), sum(bc), sum(bnc),
				sum(ac), sum(anc), sum(bc_planned), sum(bc_adhoc), sum(ac_planned), sum(ac_adhoc),
				sum(bnc_planned), sum(bnc_adhoc), sum(anc_planned), sum(anc_adhoc)
				FROM plan_wise_monthly_summary
				WHERE user_id in ($reportees)";
				
				$query = "SELECT  $mangerId as user_id, sum(total) as total,year,month,sum(rejected) as rejected, sum(accepted) as accepted, sum(bc) as bc, sum(bnc) as bnc,
				sum(ac) as ac, sum(anc) as anc, sum(bc_planned) as bc_planned, sum(bc_adhoc) as bc_adhoc, sum(ac_planned) as ac_planned, sum(ac_adhoc) as ac_adhoc,
				sum(bnc_planned) as bnc_planned, sum(bnc_adhoc) as bnc_adhoc, sum(anc_planned) as anc_planned, sum(anc_adhoc) as anc_adhoc
				FROM plan_wise_monthly_summary
				WHERE user_id in ($reportees) and month = $current_month";
				$table = "plan_wise_monthly_summary";
				$whereCond = array('user_id','year','month');
				$updateFields = array('total','rejected', 'accepted', 'bc', 'bnc',
						'ac', 'anc', 'bc_planned', 'bc_adhoc', 'ac_planned', 'ac_adhoc', 'bnc_planned', 'bnc_adhoc', 'anc_planned', 'anc_adhoc');

				$this->insertAndUpdateOnDupe($query, $table, $whereCond, $updateFields);
				// 				$res = Yii::$app->db->createCommand($sql)->execute();
			}
			if (count($ids) > 0){
				$this->managersPlanmonthSummary($ids, $duration,$current_month); # recursive function
			}
		}
	} */
	public function actionTotalfarmers()
	{
		$current_year = date("Y");
		$current_month = date("m");
		if(isset($_GET['debug'])){
			echo "Deleting data from summary tables<br/>";
		}
		$delete_query = new Query();
		$delete_query->createCommand()
		->delete('total_farmers_summary',[ 'year' => $current_year,'month' => $current_month])
		->execute();

		if(isset($_GET['debug'])){
			echo "Fetching FF activity details and inserting them into Temp table<br/>";
		}
		$no_farmers_summary = "SELECT userid as user_id,YEAR(`updated_date`) as year,Month(`updated_date`) as month,sum(no_of_farmers) as no_of_farmers,
		sum(no_of_female_farmers) as no_of_female_farmers,sum(no_of_retailers) as no_of_retailers,sum(no_of_villages) as no_of_villages,
		sum(no_of_dealers) as no_of_dealers FROM `campaign_card_activities`
		WHERE  YEAR(`updated_date`) = $current_year and Month(`updated_date`) = $current_month GROUP BY userid ";
		$queryresp = Yii::$app->db->createCommand($no_farmers_summary)->queryAll();
		//print_r($queryresp);exit;
		$reportingManagers = array();
		$ff = array();
		if (!empty($queryresp)) {
			foreach ($queryresp as $farmerssummary) {
				$obj = new TotalFarmersSummary;
				$obj->attributes = $farmerssummary;
				$obj->save(false);
				$ff[] = $farmerssummary['user_id'];
			}
			$this->managersFarmerSummary($ff,$current_month);
			//$this->updateMainPlanSummaryTable($current_year, $current_month, $duration);
		} else {
			echo 'Not Saved';
		}
	}
	private function managersFarmerSummary($users,$current_month)
	{
		if(isset($_GET['debug'])){
			echo "Fetching managers<br/>";
		}
		$managersInfo = Users::getReportingManagers($users);
		$mgCnt = count($managersInfo);
		if($mgCnt > 0) {
			if(isset($_GET['debug'])){
				echo "Managers Info: <pre>";
				print_r($managersInfo);
				echo "</pre>";
			}
			if(isset($_GET['debug'])){
				echo "Adding managers activity info<br/>";
			}
			for ($j=0; $j < $mgCnt; $j++) {
				$ids[] = $managersInfo[$j]['id'];
				$mangerId = $managersInfo[$j]['id'];
				$reportees = $managersInfo[$j]['reportees'];
				$query = "SELECT  $mangerId as user_id, year, month, sum(no_of_farmers) as no_of_farmers,
				sum(no_of_female_farmers) as no_of_female_farmers, sum(no_of_retailers) as no_of_retailers, sum(no_of_villages) as no_of_villages,
				sum(no_of_dealers) as no_of_dealers
				FROM total_farmers_summary
				WHERE user_id in ($reportees) and month = $current_month";
				$table = "total_farmers_summary";
				$whereCond = array('user_id','year','month');
				$updateFields = array('no_of_farmers','no_of_female_farmers', 'no_of_retailers', 'no_of_villages', 'no_of_dealers');
				$this->insertAndUpdateOnDupe($query, $table, $whereCond, $updateFields);
			}
			if (count($ids) > 0){
				$this->managersFarmerSummary($ids,$current_month); # recursive function
			}
		}
	}

}
?>
