<?php

namespace app\api\modules\v2\models;

use Yii;

/**
 * This is the model class for table "village_crop_monthly_summary".
 *
 * @property string $id
 * @property string $user_id
 * @property string $village_name
 * @property string $crop1
 * @property integer $crop1_total
 * @property string $crop2
 * @property integer $crop2_total
 * @property string $crop3
 * @property integer $crop3_total
 * @property string $crop4
 * @property integer $crop4_total
 * @property string $total
 * @property string $month
 * @property string $year
 */
class VillageCropMonthlySummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'village_crop_monthly_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'crop1', 'crop2', 'crop3', 'crop4', 'total', 'month', 'year'], 'required'],
            [['user_id', 'crop1_total', 'crop2_total', 'crop3_total', 'crop4_total', 'total', 'month','village_id'], 'integer'],
            [['year'], 'safe'],
            [['village_name', 'crop1', 'crop2', 'crop3', 'crop4'], 'string', 'max' => 100]
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
            'crop1' => 'Crop1',
            'crop1_total' => 'Crop1 Total',
            'crop2' => 'Crop2',
            'crop2_total' => 'Crop2 Total',
            'crop3' => 'Crop3',
            'crop3_total' => 'Crop3 Total',
            'crop4' => 'Crop4',
            'crop4_total' => 'Crop4 Total',
            'total' => 'Total',
            'month' => 'Month',
            'year' => 'Year',
        ];
    }
    public static function villageCropMonthlyPerformance($user_id,$time,$current_year,$current_month)
    {
    	/* $village_crop_summary = self::find()->select('village_name, crop1, SUM(crop1_total) AS crop1_total, crop2, SUM(crop2_total) AS crop2_total, crop3, SUM(crop3_total) AS crop3_total, crop4, SUM(crop4_total) AS crop4_total, SUM(total) as total')
    	->where(['user_id' => $user_id, 'year' => $current_year,'month' => $current_month])
    	->groupBy('village_name, crop1, crop2, crop3, crop4')
    	->asArray()
    	->all(); */
    	$query = 'SELECT if(vc.crop4 = 2147483647, "others", ifnull(cr4.crop_name,"N/A")) AS crop4, vc.village_id, mv.village_name, ifnull(cr1.crop_name,"N/A") AS crop1, SUM(vc.crop1_total) AS crop1_total, ifnull(cr2.crop_name,"N/A") AS crop2, SUM(vc.crop2_total) AS crop2_total, ifnull(cr3.crop_name,"N/A") AS crop3, SUM(vc.crop3_total) AS crop3_total, SUM(vc.crop4_total) AS crop4_total, SUM(vc.total) as total
    	FROM village_crop_monthly_summary vc
		LEFT JOIN villages_master mv ON mv.village_id = vc.village_id
    	LEFT JOIN crops cr1 ON cr1.id = vc.crop1
    	LEFT JOIN crops cr2 ON cr2.id = vc.crop2
    	LEFT JOIN crops cr3 ON cr3.id = vc.crop3
    	LEFT JOIN crops cr4 ON cr4.id = vc.crop4
    	WHERE vc.user_id = "'.$user_id.'"
    	AND vc.year = "'.$current_year.'"
    	AND vc.month = "'.$current_month.'"
    	GROUP BY vc.village_id, vc.crop1, vc.crop2, vc.crop3, vc.crop4
    	ORDER BY mv.village_name asc';
    	$village_crop_summary = Yii::$app ->db->createCommand($query)->queryAll();
    	//echo '<pre>';print_r($village_crop_summary);exit;
    	$village_crop_summary_content = '';
    	if (!empty($village_crop_summary)) {
    		$village_crop_summary_content = "<tbody>";
    		foreach ($village_crop_summary as $village_crop) {

    			$village_crop_summary_content .= "<tr>
    												<th><p>".$village_crop['village_name']."</p><span class='pull-right'>".$village_crop['total']."</span></th>
													<td><p>".$village_crop['crop1']."</p><span class='pull-right'>".$village_crop['crop1_total']."</span></td>
													<td><p>".$village_crop['crop2']."</p><span class='pull-right'>".$village_crop['crop2_total']."</span></td>
													<td><p>".$village_crop['crop3']."</p><span class='pull-right'>".$village_crop['crop3_total']."</span></td>
													<td><p>".$village_crop['crop4']."</p><span class='pull-right'>".$village_crop['crop4_total']."</span></td>
												</tr>";
    		}
    		$village_crop_summary_content .= "</tbody>";
    	}
    	//echo $village_crop_summary_content;exit;
    	return $village_crop_summary_content;
    }
}
