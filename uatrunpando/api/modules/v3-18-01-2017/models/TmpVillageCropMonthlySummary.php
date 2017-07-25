<?php

namespace app\api\modules\v3\models;

use Yii;

/**
 * This is the model class for table "tmp_village_crop_monthly_summary".
 *
 * @property string $id
 * @property string $user_id
 * @property string $village_name
 * @property string $crop_name
 * @property string $total
 * @property string $month
 * @property string $year
 */
class TmpVillageCropMonthlySummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tmp_village_crop_monthly_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'village_name', 'crop_name', 'total', 'month', 'year', 'crop_id','village_id'], 'required'],
            [['user_id', 'total', 'month', 'crop_id','village_id'], 'integer'],
            [['year'], 'safe'],
            [['village_name', 'crop_name'], 'string', 'max' => 100]
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
            'crop_name' => 'Crop Name',
            'total' => 'Total',
            'month' => 'Month',
            'year' => 'Year',
        ];
    }
}
