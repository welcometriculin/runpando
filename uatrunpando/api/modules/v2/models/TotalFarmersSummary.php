<?php

namespace app\api\modules\v2\models;

use Yii;

/**
 * This is the model class for table "total_farmers_summary".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $no_of_farmers
 * @property string $no_of_female_farmers
 * @property integer $no_of_retailers
 * @property integer $no_of_dealers
 * @property integer $no_of_villages
 * @property string $year
 * @property integer $month
 */
class TotalFarmersSummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'total_farmers_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'no_of_farmers', 'no_of_female_farmers', 'no_of_retailers', 'no_of_dealers', 'no_of_villages', 'year', 'month'], 'required'],
            [['user_id', 'no_of_farmers', 'no_of_retailers', 'no_of_dealers', 'no_of_villages', 'month'], 'integer'],
            [['no_of_female_farmers', 'year'], 'safe'],
            [['year', 'month', 'user_id'], 'unique', 'targetAttribute' => ['year', 'month', 'user_id'], 'message' => 'The combination of User ID, Year and Month has already been taken.']
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
            'no_of_farmers' => 'No Of Farmers',
            'no_of_female_farmers' => 'No Of Female Farmers',
            'no_of_retailers' => 'No Of Retailers',
            'no_of_dealers' => 'No Of Dealers',
            'no_of_villages' => 'No Of Villages',
            'year' => 'Year',
            'month' => 'Month',
        ];
    }
    public static function farmersSummary($user_id, $time, $current_year,$current_month)
    {  
    	if($time == 'year') {
    		$farmers_summary = self::find()->select('sum(no_of_farmers) as no_of_farmers,sum(no_of_female_farmers) as no_of_female_farmers,sum(no_of_retailers) as no_of_retailers')
    		->where(['user_id' =>$user_id, 'year' => $current_year])
    		->asArray()
    		->one();
    	}
    	else{
    		$farmers_summary = self::find()->select('no_of_farmers,no_of_female_farmers,no_of_retailers')
    		->where(['user_id' =>$user_id, 'year' => $current_year,'month' => $current_month])
    		->asArray()
    		->one();
    	}
    	if (empty($farmers_summary)) {
    		return 0;
    	}
    	return [number_format($farmers_summary['no_of_farmers']),number_format($farmers_summary['no_of_female_farmers']),number_format($farmers_summary['no_of_retailers'])];
    	
    }
}
