<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "village_crop_yearly_summary".
 *
 * @property string $id
 * @property string $user_id
 * @property string $village_name
 * @property string $crop1
 * @property string $crop2
 * @property string $crop3
 * @property string $crop4
 * @property string $total
 * @property string $month
 * @property string $year
 */
class VillageCropYearlySummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'village_crop_yearly_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'village_name', 'crop1', 'crop2', 'crop3', 'crop4', 'total', 'month', 'year','village_id'], 'required'],
            [['user_id', 'month','village_id'], 'integer'],
            [['total'], 'number'],
            [['year'], 'safe'],
            [['village_name', 'crop1', 'crop2', 'crop3', 'crop4'], 'string', 'max' => 100],
            [['year', 'month', 'user_id'], 'unique', 'targetAttribute' => ['year', 'month', 'user_id'], 'message' => 'The combination of User ID, Month and Year has already been taken.']
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
            'crop2' => 'Crop2',
            'crop3' => 'Crop3',
            'crop4' => 'Crop4',
            'total' => 'Total',
            'month' => 'Month',
            'year' => 'Year',
        ];
    }
    public static function villageCropPerformance($user_id,$time,$current_year)
    {
    	/* $village_crop_summary = (new \yii\db\Query())->select('if(vc.crop4 = 2356465, "other", cr4.crop_name) as crop4, vc.village_name, cr1.crop_name as crop1, SUM(vc.crop1_total) AS crop1_total, cr2.crop_name as crop2, SUM(vc.crop2_total) AS crop2_total, cr3.crop_name as crop3, SUM(vc.crop3_total) AS crop3_total,  SUM(vc.crop4_total) AS crop4_total, SUM(vc.total) as total')
    	->from('village_crop_yearly_summary vc')
    	->where(['vc.user_id' => $user_id, 'vc.year' => $current_year])
    	->leftJoin('crops cr1','cr1.id = vc.crop1')
    	->leftJoin('crops cr2','cr2.id = vc.crop2')
    	->leftJoin('crops cr3','cr3.id = vc.crop3')
    	->leftJoin('crops cr4','cr4.id = vc.crop4')
    	->groupBy('vc.village_name, vc.crop1, vc.crop2, vc.crop3, vc.crop4, vc.month')
    	->all(); */
    	$query = "SELECT if(vc.crop4 = 2147483647, 'others', ifnull(cr4.crop_name,'N/A')) AS crop4, vc.village_id, mv.village_name, ifnull(cr1.crop_name,'N/A') AS crop1, SUM(vc.crop1_total) AS crop1_total, ifnull(cr2.crop_name,'N/A') AS crop2, SUM(vc.crop2_total) AS crop2_total, ifnull(cr3.crop_name,'N/A') AS crop3, SUM(vc.crop3_total) AS crop3_total, SUM(vc.crop4_total) AS crop4_total, SUM(vc.total) as total 
					FROM village_crop_yearly_summary vc 
					LEFT JOIN villages_master mv ON mv.village_id = vc.village_id
					LEFT JOIN crops cr1 ON cr1.id = vc.crop1
					LEFT JOIN crops cr2 ON cr2.id = vc.crop2
					LEFT JOIN crops cr3 ON cr3.id = vc.crop3 
					LEFT JOIN crops cr4 ON cr4.id = vc.crop4 
					WHERE vc.user_id = $user_id
					AND vc.year = $current_year
					GROUP BY vc.village_id, vc.crop1, vc.crop2, vc.crop3, vc.crop4, vc.month
    				ORDER BY mv.village_name asc";
    	$village_crop_summary = Yii::$app ->db->createCommand($query)->queryAll();
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
    	return $village_crop_summary_content;
    }
}
