<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_products".
 *
 * @property string $id
 * @property string $product_name
 */
class MasterProducts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'master_products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_name'], 'required'],
            [['product_name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_name' => 'Product Name',
        ];
    }
    public static function products($hit_timestamp)
    {
    	$company_id = Yii::$app->user->identity->input_company_id;
    	if($company_id != 97 && $company_id != 99) {
    		$company_id = 78;
    	}
    	if (!$hit_timestamp) {
    		$result = MasterProducts::find()->select('id, product_name')->where(['company_id' => $company_id])->all();
    		return $result;
    	} else {
    		return $result = MasterProducts::find()->select('id, product_name')->where(['>', 'created_date', $hit_timestamp])->andWhere(['company_id' => $company_id])->all();
    	}
    }
}
