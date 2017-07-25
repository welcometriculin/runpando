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
    public function favPartnersInsert($params, $user_id)
    {
    	$partners_favourites = $params['channel_partners_favourites'];
    	$delete = Yii::$app->db->createCommand()->delete('fav_channelpartners', ['user_id' => $user_id])->execute();
    	if (!empty($partners_favourites)) {
    		$insert1 = "INSERT INTO fav_channelpartners (channel_partner_id, user_id) VALUES";
    		$insert2 = '';
    		foreach ($partners_favourites as $fav_partners) {
    			$insert2 .= "('".$fav_partners."', '".$user_id."'),";
    		}
    		$insert3 = trim($insert2, ',');
    		$partners_insert = $insert1 . $insert3;
    		$partners_query = Yii::$app->db->createCommand($partners_insert)->execute();
    		if($partners_query) {
    			return 'success';
    		}
    	}
    }
}
