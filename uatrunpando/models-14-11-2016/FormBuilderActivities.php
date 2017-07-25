<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "form_builder_activities".
 *
 * @property integer $form_builder_activity_id
 * @property integer $activity_id
 * @property integer $company_id
 *
 * @property FormBuilder[] $formBuilders
 */
class FormBuilderActivities extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_builder_activities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_id', 'company_id'], 'required'],
            [['activity_id', 'company_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'form_builder_activity_id' => 'Form Builder Activity ID',
            'activity_id' => 'Activity ID',
            'company_id' => 'Company ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormBuilders()
    {
        return $this->hasMany(FormBuilder::className(), ['form_builder_activity_id' => 'form_builder_activity_id']);
    }
}
