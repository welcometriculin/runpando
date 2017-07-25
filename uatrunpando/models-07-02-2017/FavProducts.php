<?php

namespace app\models;

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
}
