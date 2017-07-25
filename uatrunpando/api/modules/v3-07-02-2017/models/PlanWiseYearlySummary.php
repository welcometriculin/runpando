<?php

namespace app\api\modules\v3\models;

use Yii;

/**
 * This is the model class for table "plan_wise_yearly_summary".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $total
 * @property string $year
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
class PlanWiseYearlySummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plan_wise_yearly_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'total', 'year', 'rejected', 'accepted', 'bc', 'bnc', 'ac', 'anc', 'bc_planned', 'bc_adhoc', 'ac_planned', 'ac_adhoc', 'bnc_planned', 'bnc_adhoc', 'anc_planned', 'anc_adhoc'], 'required'],
            [['user_id', 'total', 'rejected', 'accepted', 'bc', 'bnc', 'ac', 'anc', 'bc_planned', 'bc_adhoc', 'ac_planned', 'ac_adhoc', 'bnc_planned', 'bnc_adhoc', 'anc_planned', 'anc_adhoc'], 'integer'],
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
    
    public static function planYearlySummary($user_id, $time, $current_year)
    {
    	$plan_year_summary = self::find()->select('*')->where(['user_id' => $user_id,'year' => $current_year])->asArray()->one();
    	if($plan_year_summary['bc'] == 0) {
    		$build_complete = 0;
    	}else {
    	   $build_complete = array(array('y' =>intval($plan_year_summary['bc_adhoc'])),array('y' =>intval($plan_year_summary['bc_planned'])));
    	}
    	if ($plan_year_summary['bnc'] == 0) {
    		$build_not_completed = 0;
    	} else {
    		$build_not_completed = array(array('y' =>intval($plan_year_summary['bnc_adhoc'])),array('y' =>intval($plan_year_summary['bnc_planned'])));
    	}
    	if ($plan_year_summary['ac'] == 0) {
    		$assign_completed = 0;
    	} else {
    		$assign_completed   = array(array('y' =>intval($plan_year_summary['ac_adhoc'])),array('y' =>intval($plan_year_summary['ac_planned'])));
    	}
    	if ($plan_year_summary['anc'] == 0) {
    		$assign_not_completed = 0;
    	} else {
    		$assign_not_completed = array(array('y' =>intval($plan_year_summary['anc_adhoc'])),array('y' =>intval($plan_year_summary['anc_planned'])));
    	}
    	$adhoc_count = $plan_year_summary['bc_adhoc'] + $plan_year_summary['ac_adhoc'] + $plan_year_summary['bnc_adhoc'] + $plan_year_summary['anc_adhoc'];
    	$planned_count = $plan_year_summary['bc_planned'] + $plan_year_summary['ac_planned'] + $plan_year_summary['bnc_planned'] + $plan_year_summary['anc_planned'];
    	$count = '<div class="plans">
    					<p class="p-t"> Plans <span class="sum-tot"><span>'.$plan_year_summary['total'].'</span></span></p>
						
						<div class="plans-list">			
							<p class ="planned-green" >Planned:<span>'.$planned_count.'</span></p>
							<p class ="planned-orange">Adhoc:<span>'.$adhoc_count.'</span></p>
							<p class="planned-red">Rejected:<span>'.$plan_year_summary['rejected'].'</span></p>	
						</div>				
					</div>
					';
    	if ($plan_year_summary['accepted'] == 0) {
    		$build_complete_per = 0;
    		$build_not_complete_per = 0;
    		$assign_not_complete_per = 0;
    		$assign_complete_per = 0;
    	} else {
    		$build_complete_per = round(($plan_year_summary['bc']/$plan_year_summary['accepted'])*100,2);
	     	$build_not_complete_per = round(($plan_year_summary['bnc']/$plan_year_summary['accepted'])*100,2);
	     	$assign_not_complete_per = round(($plan_year_summary['anc']/$plan_year_summary['accepted'])*100,2);
	     	$assign_complete_per = round(($plan_year_summary['ac']/$plan_year_summary['accepted'])*100,2);
    	}
     	$percentage = array($build_complete_per,$build_not_complete_per,$assign_not_complete_per,$assign_complete_per);
     	$chart_percentage = array();
    	if (!empty($percentage)) {
	    	foreach($percentage as $per){
			   $chart_percentage[] = self::percentageMethod($per);		
	    	}
    	}
//     	echo '<pre>';print_r($percentage);
//     	echo '<pre>';print_r($chart_percentage);exit;
     	return ['bc' =>$build_complete,'bnc' =>$build_not_completed,'ac' => $assign_completed,'anc' => $assign_not_completed,'count' => $count,'chart_per' => $chart_percentage];
    }
    
    public static function percentageMethod($per) 
    {
    	$val1 =10;
    	$val2 =20;
    	$val3 =30;
    	$val4 =40;
    	$val5 =50;
    	$val6 =60;
    	$val7 =70;
    	$val8 =80;
    	$val9 =90;
    	$val10 =100;
    	if($per < $val1) {
    		return '40%';
    	}
    	if($per > $val1 && $per < $val2) {
    		return '45%';
    	}
    	if($per > $val2 && $per < $val3) {
    		return '50%';
    	}
    	if($per > $val3 && $per < $val4) {
    		return '55%';
    	}
    	if($per > $val4 && $per < $val5) {
    		return '60%';
    	}
    	if($per > $val5 && $per < $val6) {
    		return '65%';
    	}
    	if($per > $val6 && $per < $val7) {
    		return '70%';
    	}
    	if($per > $val7 && $per < $val8) {
    		return '80%';
    	}
    	if($per > $val8 && $per < $val9) {
    		return '90%';
    	}
    	if($per > $val9 && $per < $val10) {
    		return '100%';
    	}
    	 
    }
    
}
