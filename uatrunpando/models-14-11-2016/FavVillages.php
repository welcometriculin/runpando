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
    
    public function favVillagesInsert($params, $user_id)
    {
    	$villages_favourites = $params['villages_favourites'];
    	$delete = Yii::$app->db->createCommand()->delete('fav_villages', ['user_id' => $user_id])->execute();
    	if (!empty($villages_favourites)) {
    		$insert1 = "INSERT INTO fav_villages (village_id, user_id) VALUES";
    		$insert2 = '';
    		foreach ($villages_favourites as $fav_villages) {
    			$insert2 .= "('".$fav_villages."', '".$user_id."'),";
    		}
    		$insert3 = trim($insert2, ',');
    		$villages_insert = $insert1 . $insert3;
    		$villages_query = Yii::$app->db->createCommand($villages_insert)->execute();
    		if($villages_query) {
    			return 'success';
    		}
    	}
    }
}
