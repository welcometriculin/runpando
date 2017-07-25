<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "villages_master".
 *
 * @property integer $village_id
 * @property string $guid
 * @property string $village_name
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_date
 * @property string $updated_date
 */
class VillagesMaster extends  Kg
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'villages_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guid', 'created_by', 'updated_by', 'created_date', 'updated_date'], 'required'],
            [['created_by', 'updated_by'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['guid', 'village_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'village_id' => 'Village ID',
            'guid' => 'Guid',
            'village_name' => 'Village Name',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
        ];
    }
}
