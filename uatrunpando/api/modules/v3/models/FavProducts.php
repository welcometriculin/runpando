<?php

namespace app\api\modules\v3\models;

use Yii;

/**
 * This is the model class for table "fav_products".
 *
 * @property integer $fav_products_id
 * @property integer $product_id
 * @property integer $user_id
 */
class FavProducts extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'fav_products';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
				[['product_id', 'user_id'], 'required'],
				[['product_id', 'user_id'], 'integer']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
				'fav_products_id' => 'Fav Products ID',
				'product_id' => 'Product ID',
				'user_id' => 'User ID',
		];
	}
	//for webservice fav products insert online and offline start
	public static function favProductsInsert($params, $user_id)
	{
		if(array_key_exists('campaign_favourites',$params)) {
			$products_favourites = $params['campaign_favourites'];
			$delete = Yii::$app->db->createCommand()->delete('fav_products', ['user_id' => $user_id])->execute();
			if (!empty($products_favourites)) {
				$insert1 = "INSERT INTO fav_products (product_id, user_id) VALUES";
				$insert2 = '';
				foreach ($products_favourites as $fav_products) {
					$insert2 .= "('".$fav_products."', '".$user_id."'),";
				}
				$insert3 = trim($insert2, ',');
				$products_insert = $insert1 . $insert3;
				$products_query = Yii::$app->db->createCommand($products_insert)->execute();
			}
		} if(array_key_exists('channel_favourites',$params)) {
			$products_favourites = $params['channel_favourites'];
			//$delete = Yii::$app->db->createCommand()->delete('fav_products', ['user_id' => $user_id])->execute();
			if (!empty($products_favourites)) {
				$insert1 = "INSERT INTO fav_products (product_id, user_id,is_channel_fav) VALUES";
				$insert2 = '';
				foreach ($products_favourites as $fav_products) {
					$insert2 .= "('".$fav_products."', '".$user_id."',1),";
				}
				$insert3 = trim($insert2, ',');
				$products_insert = $insert1 . $insert3." ON DUPLICATE KEY UPDATE is_channel_fav = 1";
				$products_query = Yii::$app->db->createCommand($products_insert)->execute();
			}
		}
	}
	//for webservice fav products insert online and offline end
}
