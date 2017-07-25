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
    
    //for webservice fav crops insert onlin and offline
    public static function favCropsInsert($params, $user_id)
    {
    	$crops_favourites = $params['crops_favourites'];
    	$delete = Yii::$app->db->createCommand()->delete('fav_crops', ['user_id' => $user_id])->execute();
    	if (!empty($crops_favourites)) {
	    	$insert1 = "INSERT INTO fav_crops (crop_id, user_id) VALUES";
	    	$insert2 = '';
	    	foreach ($crops_favourites as $fav_crops) {
	    		$insert2 .= "('".$fav_crops."', '".$user_id."'),";
	    	}
	    	$insert3 = trim($insert2, ',');
	    	$crops_insert = $insert1 . $insert3;
	    	$crops_query = Yii::$app->db->createCommand($crops_insert)->execute();
	    }
    	return 'success';
    }
}
