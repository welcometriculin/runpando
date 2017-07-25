<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fav_channelpartners".
 *
 * @property integer $fav_channelpartner_id
 * @property integer $channel_partner_id
 * @property integer $user_id
 */
class FavChannelpartners extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fav_channelpartners';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channel_partner_id', 'user_id'], 'required'],
            [['channel_partner_id', 'user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fav_channelpartner_id' => 'Fav Channelpartner ID',
            'channel_partner_id' => 'Channel Partner ID',
            'user_id' => 'User ID',
        ];
    }
 
}
