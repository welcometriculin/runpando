<?php

namespace app\api\modules\v3\models;

use Yii;
use app\models\PlanWiseYearlySummary;
/**
 * This is the model class for table "plan_wise_monthly_summary".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $total
 * @property string $year
 * @property integer $month
 * @property integer $rejected
 * @property integer $accepted
 * @property integer $bc
 * @property integer $bnc
 * @property integer $ac
 * @property integer $anc
 * @property integer $bc_planned
 * @property integer $bc_adhoc
 * @property integer $ac_planned
 * @property integer $ac_adhoc
 * @property integer $bnc_planned
 * @property integer $bnc_adhoc
 * @property integer $anc_planned
 * @property integer $anc_adhoc
 */
class PlanWiseMonthlySummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plan_wise_monthly_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'total', 'year', 'month', 'rejected', 'accepted', 'bc', 'bnc', 'ac', 'anc', 'bc_planned', 'bc_adhoc', 'ac_planned', 'ac_adhoc', 'bnc_planned', 'bnc_adhoc', 'anc_planned', 'anc_adhoc'], 'required'],
            [['user_id', 'total', 'month', 'rejected', 'accepted', 'bc', 'bnc', 'ac', 'anc', 'bc_planned', 'bc_adhoc', 'ac_planned', 'ac_adhoc', 'bnc_planned', 'bnc_adhoc', 'anc_planned', 'anc_adhoc'], 'integer'],
            [['year'], 'safe']
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
            'total' => 'Total',
            'year' => 'Year',
            'month' => 'Month',
            'rejected' => 'Rejected',
            'accepted' => 'Accepted',
            'bc' => 'Bc',
            'bnc' => 'Bnc',
            'ac' => 'Ac',
            'anc' => 'Anc',
            'bc_planned' => 'Bc Planned',
            'bc_adhoc' => 'Bc Adhoc',
            'ac_planned' => 'Ac Planned',
            'ac_adhoc' => 'Ac Adhoc',
            'bnc_planned' => 'Bnc Planned',
            'bnc_adhoc' => 'Bnc Adhoc',
            'anc_planned' => 'Anc Planned',
            'anc_adhoc' => 'Anc Adhoc',
        ];
    }
    public static function planMonthlySummary($user_id, $time, $current_year,$current_month)
    {
    	$plan_month_summary = self::find()->select('*')->where(['user_id' => $user_id,'year' => $current_year,'month' => $current_month ])->asArray()->one();
    if($plan_month_summary['bc'] == 0) {
    		$build_complete = 0;
    	}else {
    	   $build_complete = array(array('y' =>intval($plan_month_summary['bc_adhoc'])),array('y' =>intval($plan_month_summary['bc_planned'])));
    	}
    	if ($plan_month_summary['bnc'] == 0) {
    		$build_not_completed = 0;
    	} else {
    		$build_not_completed = array(array('y' =>intval($plan_month_summary['bnc_adhoc'])),array('y' =>intval($plan_month_summary['bnc_planned'])));
    	}
    	if ($plan_month_summary['ac'] == 0) {
    		$assign_completed = 0;
    	} else {
    		$assign_completed   = array(array('y' =>intval($plan_month_summary['ac_adhoc'])),array('y' =>intval($plan_month_summary['ac_planned'])));
    	}
    	if ($plan_month_summary['anc'] == 0) {
    		$assign_not_completed = 0;
    	} else {
    		$assign_not_completed = array(array('y' =>intval($plan_month_summary['anc_adhoc'])),array('y' =>intval($plan_month_summary['anc_planned'])));
    	}
    	$adhoc_count = $plan_month_summary['bc_adhoc'] + $plan_month_summary['ac_adhoc'] + $plan_month_summary['bnc_adhoc'] + $plan_month_summary['anc_adhoc'];
    	$planned_count = $plan_month_summary['bc_planned'] + $plan_month_summary['ac_planned'] + $plan_month_summary['bnc_planned'] + $plan_month_summary['anc_planned'];
    	if($plan_month_summary['rejected'] =='') {
    		$rejected_count = 0;
    	} else {
    		$rejected_count = $plan_month_summary['rejected'];
    	}
    	$count = '<div class="plans">
					<p class="p-t"> Plans <span class="sum-tot"><span>'.$plan_month_summary['total'].'</span></span></p>			
						<div class="plans-list">			
							<p class ="planned-green" >Planned:<span>'.$planned_count.'</span></p>
							<p class ="planned-orange">Adhoc:<span>'.$adhoc_count.'</span></p>
							<p class="planned-red">Rejected:<span>'.$rejected_count.'</span></p>	
						</div>				
					</div>';
    	
    	if ($plan_month_summary['accepted'] == 0) {
    		$build_complete_per = 0;
    		$build_not_complete_per = 0;
    		$assign_not_complete_per = 0;
    		$assign_complete_per = 0;
    	} else {
	    	$build_complete_per = round(($plan_month_summary['bc']/$plan_month_summary['accepted'])*100,2);
	     	$build_not_complete_per = round(($plan_month_summary['bnc']/$plan_month_summary['accepted'])*100,2);
	     	$assign_not_complete_per = round(($plan_month_summary['anc']/$plan_month_summary['accepted'])*100,2);
	     	$assign_complete_per = round(($plan_month_summary['ac']/$plan_month_summary['accepted'])*100,2);
    	}
     	$percentage = array($build_complete_per,$build_not_complete_per,$assign_not_complete_per,$assign_complete_per);
     	$chart_percentage = array();
    	if (!empty($percentage)) {
	    	foreach($percentage as $per){
			   $chart_percentage[] = PlanWiseYearlySummary::percentageMethod($per);		
	    	}
    	}
//     	echo '<pre>';print_r($percentage);
//     	echo '<pre>';print_r($chart_percentage);exit;
     	return ['bc' =>$build_complete,'bnc' =>$build_not_completed,'ac' => $assign_completed,'anc' => $assign_not_completed,'count' => $count,'chart_per' => $chart_percentage];
    }
}
