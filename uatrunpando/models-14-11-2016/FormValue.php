<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "form_value".
 *
 * @property integer $form_value_id
 * @property integer $form_builder_id
 * @property string $data_type
 * @property string $value
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_date
 * @property string $updated_date
 *
 * @property FormBuilder $formBuilder
 */
class FormValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['form_builder_id', 'created_by', 'updated_by', 'created_date', 'updated_date'], 'required'],
            [['form_builder_id', 'created_by', 'updated_by'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['data_type', 'value'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'form_value_id' => 'Form Value ID',
            'form_builder_id' => 'Form Builder ID',
            'data_type' => 'Data Type',
            'value' => 'Value',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormBuilder()
    {
        return $this->hasOne(FormBuilder::className(), ['form_builder_id' => 'form_builder_id']);
    }
}
