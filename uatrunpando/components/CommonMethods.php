<?php
namespace app\components;
use yii\base\Component;

class CommonMethods
{
	public function yearRecords($current_year,$current_month)
	{
		$prev_month = 12;
		if($current_month == 01) {
			$where = ['<=','month',$prev_month];
			$year = $current_year-1;
			return ['where' => $where,'year' => $year];
		} else {
			$where = ['<','month',$current_month];
			$year = $current_year;
			return ['where' => $where,'year' => $year];
		}
	}
	
}