<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "web_service".
 *
 * @property integer $id
 * @property string $params
 * @property string $created_date
 */
class WebService extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'web_service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['params'], 'required'],
            [['params'], 'string'],
            [['created_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'params' => 'Params',
            'created_date' => 'Created Date',
        ];
    }
}
