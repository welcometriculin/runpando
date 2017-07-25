<?php

namespace app\api\modules\v4\models;

use Yii;

/**
 * This is the model class for table "mobile_time_change".
 *
 * @property integer $mobile_time_change_id
 * @property integer $user_id
 * @property string $service_name
 * @property string $mode
 * @property resource $service_data
 * @property string $mobile_time
 * @property string $created_by
 * @property string $updated_by
 * @property string $created_date
 * @property string $updated_date
 */
class MobileTimeChange extends Kg
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mobile_time_change';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_by', 'updated_by', 'created_date', 'updated_date'], 'required'],
            [['user_id'], 'integer'],
            [['service_data'], 'string'],
            [['mobile_time', 'created_by', 'updated_by', 'created_date', 'updated_date'], 'safe'],
            [['service_name'], 'string', 'max' => 255],
            [['mode'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mobile_time_change_id' => Yii::t('app', 'Mobile Time Change ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'service_name' => Yii::t('app', 'Service Name'),
            'mode' => Yii::t('app', 'Mode'),
            'service_data' => Yii::t('app', 'Service Data'),
            'mobile_time' => Yii::t('app', 'Mobile Time'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_date' => Yii::t('app', 'Created Date'),
            'updated_date' => Yii::t('app', 'Updated Date'),
        ];
    }
}
