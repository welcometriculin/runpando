<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fav_villages".
 *
 * @property integer $fav_village_id
 * @property integer $village_id
 * @property integer $user_id
 */
class FavVillages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fav_villages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['village_id', 'user_id'], 'required'],
            [['village_id', 'user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fav_village_id' => 'Fav Village ID',
            'village_id' => 'Village ID',
            'user_id' => 'User ID',
        ];
    }
}
