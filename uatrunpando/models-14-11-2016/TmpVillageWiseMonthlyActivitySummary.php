<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tmp_village_wise_monthly_activity_summary".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $village_name
 * @property integer $demo
 * @property integer $fgm
 * @property integer $mc
 * @property integer $fhv
 * @property integer $total
 * @property integer $month
 * @property integer $day
 * @property string $year
 */
class TmpVillageWiseMonthlyActivitySummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tmp_village_wise_monthly_activity_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'village_name', 'demo', 'fgm', 'mc', 'fhv', 'total', 'month', 'day', 'year','village_id'], 'required'],
            [['user_id', 'demo', 'fgm', 'mc', 'fhv', 'total', 'month', 'day','village_id'], 'integer'],
            [['year'], 'safe'],
            [['village_name'], 'string', 'max' => 100],
            [['user_id', 'year', 'month', 'day', 'village_id'], 'unique', 'targetAttribute' => ['user_id', 'year', 'month', 'day', 'village_id'], 'message' => 'The combination of User ID, Village Name, Month, Day and Year has already been taken.']
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
            'demo' => 'Demo',
            'fgm' => 'Fgm',
            'mc' => 'Mc',
            'fhv' => 'Fhv',
            'total' => 'Total',
            'month' => 'Month',
            'day' => 'Day',
            'year' => 'Year',
        ];
    }
}
