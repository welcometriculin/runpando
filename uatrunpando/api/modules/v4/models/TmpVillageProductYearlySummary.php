<?php

namespace app\api\modules\v4\models;

use Yii;

/**
 * This is the model class for table "tmp_village_product_yearly_summary".
 *
 * @property string $id
 * @property string $user_id
 * @property string $village_name
 * @property string $product_name
 * @property string $total
 * @property string $month
 * @property string $year
 */
class TmpVillageProductYearlySummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tmp_village_product_yearly_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'village_name', 'product_name', 'total', 'month', 'year','product_id','village_id'], 'required'],
            [['user_id', 'total', 'month','product_id','village_id'], 'integer'],
            [['year'], 'safe'],
            [['village_name', 'product_name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'village_name' => 'Village Name',
            'product_name' => 'Product Name',
            'total' => 'Total',
            'month' => 'Month',
            'year' => 'Year',
        ];
    }
}
