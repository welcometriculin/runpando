<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "month_wise_travellog_summary".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $year
 * @property integer $month
 * @property integer $day
 * @property string $total_distance
 */
class MonthWiseTravellogSummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'month_wise_travellog_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'year', 'month', 'day', 'total_distance'], 'required'],
            [['user_id', 'month', 'day'], 'integer'],
            [['year'], 'safe'],
            [['total_distance'], 'number']
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
            'year' => 'Year',
            'month' => 'Month',
            'day' => 'Day',
            'total_distance' => 'Total Distance',
        ];
    }
}
