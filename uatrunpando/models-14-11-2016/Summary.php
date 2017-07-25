<?php

namespace app\models;
use Yii;
use yii\base\Model;
use yii\base\ErrorException;
use yii\db\Query;
class Summary extends Model
{
	public static function Commanupdate($command,$cron_table_data)
	{
		foreach($command as $record){
			$check = false;
			if(empty($cron_table_data)) {
				$model = new YearTravellog();
				$model->attributes = $record;
					try {
						$model->save();
					} catch (ErrorException $e) {
						Yii::warning("Not saved");
					}
			}
			else {
				for($i = 0; $i < count($cron_table_data); $i++) {
		
					if(in_array($record['year'],$cron_table_data[$i]) && in_array($record['month'],$cron_table_data[$i]) && in_array($record['user_id'],$cron_table_data[$i] ) )
					{
						$query = new Query;
						$query->createCommand()
						->update('travellog_yearly_summary', ['total_distance' => $record['total_distance']], ['year' => $record['year'], 'month' => $record['month'], 'user_id' => $record['user_id']])
						->execute();
						$check = true;
					}
		
				}
				if($check == false) {
					$model = new TravellogYearlySummary();
					$model->attributes = $record;
					try {
						$model->save();
					} catch (ErrorException $e) {
						Yii::warning("Not saved");
					}
				}
				
			}
		}
		
	}
	public static function Activityupdate($command, $cron_table_data, $flag)
	{
		if ($flag == 0) {
			foreach ($command as $record) {
				//echo '<pre>';print_r($record);print_r($cron_table_data);
				$check = false;
				if (empty($cron_table_data)) {
					$model = new CropWiseActivityYearSummary();
					$model->attributes = $record;
					try {
						$model->save();
					} catch (ErrorException $e) {
						Yii::warning("Not saved");
					}
				}
				else {
					for ($i = 0; $i < count($cron_table_data); $i++) {
						if(in_array($record['user_id'], $cron_table_data[$i]) && in_array($record['year'], $cron_table_data[$i]) && in_array($record['activity'], $cron_table_data[$i]) && in_array($record['count_activity'], $cron_table_data[$i] ) && in_array($record['crop_name'], $cron_table_data[$i] ) )
						{
							$query = new Query;
							$query->createCommand()
							->update('crop_wise_activity_year_summary', ['count_activity' => $record['count_activity']], ['year' => $record['year'], 'activity' => $record['activity'], 'user_id' => $record['user_id'], 'crop_name' => $record['crop_name']])
							->execute();
							$check = true;
						}
					}
					if ($check == false) {
						$model = new CropWiseActivityYearSummary();
						$model->attributes = $record;
						try {
							$model->save();
						} catch (ErrorException $e) {
							Yii::warning("Not saved");
						}
					}
				}
			}
		} else {
			foreach ($command as $record) {
				$check = false;
				if (empty($cron_table_data)) {
					$model = new SummaryCropActivityMonth();
					$model->attributes = $record;
					try {
						$model->save();
					} catch (ErrorException $e) {
						Yii::warning("Not saved");
					}
				}
				else {
					for ($i = 0; $i < count($cron_table_data); $i++) {
						if(in_array($record['user_id'], $cron_table_data[$i]) && in_array($record['year'], $cron_table_data[$i]) && in_array($record['month'], $cron_table_data[$i]) && in_array($record['activity'], $cron_table_data[$i]) && in_array($record['count_activity'], $cron_table_data[$i] ) && in_array($record['crop_name'], $cron_table_data[$i] ) )
						{
							$query = new Query;
							$query->createCommand()
							->update('crop_wise_activity_month_summary', ['count_activity' => $record['count_activity']], ['year' => $record['year'], 'month' => $record['month'], 'activity' => $record['activity'], 'user_id' => $record['user_id'], 'crop_name' => $record['crop_name']])
							->execute();
							$check = true;
						}
					}
					if ($check == false) {
						$model = new SummaryCropActivityMonth();
						$model->attributes = $record;
						try {
							$model->save();
						} catch (ErrorException $e) {
							Yii::warning("Not saved");
						}
					}
				}
			}
		}
	}
	
	public static function Reportedusers()
	{
		$query = new Query();
		$query->select('reporting_user_id AS user_id, GROUP_CONCAT(id) AS reported_users')
			->from('users')
			->where(['!=', 'reporting_user_id', ''])
			->groupBy('reporting_user_id')
			->orderBy('roleid DESC');
		
		 $result = $query->createCommand()->queryAll();
		 echo '<pre>';print_r($result);exit;
	}
}
