<?php

namespace app\api\modules\v4\models;

use Yii;

/**
 * This is the model class for table "activity".
 *
 * @property integer $activity_id
 * @property string $activity_name
 */
class Activity extends \yii\db\ActiveRecord
{
	const FHV = 1;
	const FGM = 2;
	const MC = 3;
	const DEMO = 4;
	const CHANNEL = 5;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_name'], 'required'],
            [['activity_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'activity_id' => 'Activity ID',
            'activity_name' => 'Activity Name',
        ];
    }
    /* activites list for web service start */
    public static function activitiesList() 
    {
    	//return $act_list = self::find()->asArray()->all();
    	$sql = 'SELECT activity_id, IF(activity_name ="Channel Card", "Partner Visit", activity_name) AS activity_name  from activity';
    	return $q = Yii::$app->db->createCommand($sql)->queryAll();
    	
    }
    /* activites list for web service end */
}
