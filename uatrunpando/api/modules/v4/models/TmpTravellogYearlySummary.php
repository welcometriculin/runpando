<?php

namespace app\api\modules\v4\models;

use Yii;

/**
 * This is the model class for table "tmp_travellog_yearly_summary".
 *
 * @property string $id
 * @property string $user_id
 * @property string $total_distance
 * @property string $month
 * @property string $year
 */
class TmpTravellogYearlySummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tmp_travellog_yearly_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'total_distance', 'month', 'year'], 'required'],
            [['user_id', 'month'], 'integer'],
            [['total_distance'], 'number'],
            [['year'], 'safe'],
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
            'total_distance' => 'Total Distance',
            'month' => 'Month',
            'year' => 'Year',
        ];
    }
}
