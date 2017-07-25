<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "label_names".
 *
 * @property integer $label_names_id
 * @property string $crop_label
 * @property string $product_label
 * @property string $village_label
 * @property string $sub_activity_label
 * @property integer $company_id
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 */
class LabelNames extends Kg
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'label_names';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['crop_label', 'product_label', 'village_label', 'partner_label', 'created_by', 'created_date', 'updated_by', 'updated_date'], 'required'],
        	[['crop_label', 'product_label', 'village_label', 'partner_label', 'company_id', 'created_by', 'created_date', 'updated_by', 'updated_date'], 'filter', 'filter'=>'trim'],
        	[['company_id'], 'required', 'message' => 'Company cannot be blank.'],
        	[['company_id', 'created_by', 'updated_by'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['crop_label', 'product_label', 'village_label', 'partner_label'], 'string', 'min' => 3, 'max' => 20],
        	[['crop_label', 'product_label', 'village_label', 'partner_label'], 'match', 'pattern' => '/^[a-zA-Z0-9_ -\s]+$/','message' => ' Only  Alphabets(a-z), Numbers(1-9), Space, Underscore( _ ) and Hyphen(-) are allowed'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'label_names_id' => 'Label Names ID',
            'crop_label' => 'Label1',
            'product_label' => 'Label2',
            'village_label' => 'Label3',
            'partner_label' => 'Label4',
            'company_id' => 'Company',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
        ];
    }
    //for label names displays
    public static function labelNamesDisplay()
    {
    	$company_id = Yii::$app->user->identity->input_company_id;
    	$sql = LabelNames::find()->select('*')->where(['company_id' => $company_id])->asArray()->one();
    	return $sql;
    }
}
