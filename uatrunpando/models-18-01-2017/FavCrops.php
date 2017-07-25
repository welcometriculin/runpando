<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fav_crops".
 *
 * @property integer $fav_crops_id
 * @property integer $crop_id
 * @property integer $user_id
 */
class FavCrops extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fav_crops';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['crop_id', 'user_id'], 'required'],
            [['crop_id', 'user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fav_crops_id' => 'Fav Crops ID',
            'crop_id' => 'Crop ID',
            'user_id' => 'User ID',
        ];
    }
    
}
